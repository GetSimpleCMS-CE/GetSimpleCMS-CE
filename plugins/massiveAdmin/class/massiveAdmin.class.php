<?php

class MassiveAdminClass{
    
    // ========== SECURITY METHODS ==========
    
    /**
     * Server-side CSRF secret derived from the installation salt.
     *
     * GetSimple does not start a PHP session on admin pages, so $_SESSION is
     * not reliable here. The authorization apikey / GSUSECUSTOMSALT value is
     * random per install and never exposed to visitors, which makes tokens
     * unforgeable while staying stable for every request.
     */
    private static function nonce_secret() {
        static $secret = null;
        if ($secret !== null) {
            return $secret;
        }

        $salt = '';
        if (!empty($GLOBALS['SALT'])) {
            $salt = (string)$GLOBALS['SALT'];
        } elseif (defined('GSUSECUSTOMSALT')) {
            $salt = sha1(GSUSECUSTOMSALT);
        } else {
            $auth_file = GSDATAOTHERPATH . 'authorization.xml';
            if (file_exists($auth_file)) {
                $xml = @simplexml_load_file($auth_file);
                if ($xml && isset($xml->apikey)) {
                    $salt = (string)$xml->apikey;
                }
            }
        }

        if ($salt === '') {
            // Degraded fallback: still unique per installation path, but a
            // normal install always has an apikey in authorization.xml.
            $salt = __DIR__ . PHP_VERSION;
        }

        $secret = hash('sha256', 'massiveadmin-csrf|' . $salt);
        return $secret;
    }

    /**
     * Generate CSRF token
     */
    public static function generate_nonce($action) {
        $user = '';
        if (!empty($GLOBALS['USR'])) {
            $user = (string)$GLOBALS['USR'];
        } elseif (isset($_SESSION['user'])) {
            $user = (string)$_SESSION['user'];
        }
        return hash_hmac('sha256', $action . '|' . $user, self::nonce_secret());
    }
    
    /**
     * Verify CSRF token
     */
    public static function verify_nonce($nonce, $action) {
        if (!is_string($nonce) || $nonce === '') return false;
        return hash_equals(self::generate_nonce($action), $nonce);
    }
    
    /**
     * Security: Validate path is safe (prevents path traversal)
     */
    public static function is_safe_path($path, $base_path) {
        // Remove null bytes and control characters
        $path = preg_replace('/[\x00-\x1F]/', '', (string)$path);
        // Normalize path
        $path = str_replace('\\', '/', $path);
        // Get real base path
        $real_base = realpath($base_path);
        if ($real_base === false) return false;
        $real_base = rtrim(str_replace('\\', '/', $real_base), '/');

        // Build full path
        $full_path = $base_path . '/' . ltrim($path, '/');
        $real_path = realpath($full_path);

        if ($real_path === false) {
            // Target does not exist yet (e.g. a new user file). Verify the
            // parent directory instead and allow plain file names only.
            $name = basename($path);
            if ($name === '' || $name === '.' || $name === '..' || strpos($path, '/') !== false) {
                return false;
            }
            $real_parent = realpath(dirname($full_path));
            if ($real_parent === false) return false;
            $real_parent = rtrim(str_replace('\\', '/', $real_parent), '/');
            return ($real_parent === $real_base) || (strpos($real_parent, $real_base . '/') === 0);
        }

        // Ensure path is within base directory (separator-aware comparison,
        // otherwise /data/uploads-evil would match /data/uploads)
        $real_path = rtrim(str_replace('\\', '/', $real_path), '/');
        return ($real_path === $real_base) || (strpos($real_path, $real_base . '/') === 0);
    }
    
    /**
     * Security: Check if file extension is allowed
     */
    public static function is_allowed_extension($filename) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'txt', 'zip', 'css', 'js'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        return in_array($ext, $allowed);
    }
    
    /**
     * Security: Scan file for malicious content
     */
    public static function scan_file_safety($filepath) {
        if (!file_exists($filepath)) return true;
        
        $content = file_get_contents($filepath);
        
        // Check for PHP code
        if (preg_match('/<\?php/i', $content)) {
            return false;
        }
        
        // Check for dangerous functions
        $dangerous = ['exec', 'system', 'shell_exec', 'passthru', 'eval', 'base64_decode'];
        foreach ($dangerous as $func) {
            if (stripos($content, $func) !== false) {
                return false;
            }
        }
        
        return true;
    }
    
    /**
	 * Security: Log security events
	 */
	private static function log_action($action, $details) {
		$log_file = GSDATAOTHERPATH . 'massive_admin.log';
		$timestamp = date('Y-m-d H:i:s');
		$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
		
		// Try to get the username from various sources
		$user = 'guest';
		if (isset($_SESSION['username'])) {
			$user = $_SESSION['username'];
		} elseif (isset($_COOKIE['GS_ADMIN_USERNAME'])) {
			$user = $_COOKIE['GS_ADMIN_USERNAME'];
		} elseif (isset($_SESSION['user'])) {
			$user = $_SESSION['user'];
		}
		
		$log_entry = "[{$timestamp}] [{$user}] [{$ip}] [{$action}] {$details}\n";
		@file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);
	}

	/* massive Options */
	public function deleteFileList(){
		if (!isset($_POST['nonce']) || !self::verify_nonce($_POST['nonce'], 'delete_file')) {
			die('CSRF validation failed');
		}
		
		$list = $_POST['delFileList'];
		$ar = explode(",", $list);
		foreach ($ar as $key => $value) {
			$value = trim($value);
			$value = preg_replace('/\s+/', '-', $value);
			if (self::is_safe_path($value, GSDATAUPLOADPATH)) {
				$filepath = GSDATAUPLOADPATH . $value;
				if (is_file($filepath)) {
					@unlink($filepath);
					self::log_action('delete_file', "Deleted: {$value}");
				}
			}
			echo ("<meta http-equiv='refresh' content='1'>");
		};
	}

	public function copyRename(){
		if (!isset($_POST['nonce']) || !self::verify_nonce($_POST['nonce'], 'copy_rename')) {
			die('CSRF validation failed');
		}
		
		$fileIsHere = i18n_r("massiveAdmin/INFOERROR");

		$oldDirMassive = '../data/uploads/' . $_POST['rename-massive-hide'];
		$newDirMassive = '../data/uploads/' . $_POST['rename-massive'];

		$afterNewDir = preg_replace('/\s+/', '-', $newDirMassive);
		
		$sourcePath = GSDATAUPLOADPATH . $_POST['rename-massive-hide'];
		$destPath = GSDATAUPLOADPATH . $afterNewDir;
		
		if (!self::is_safe_path($_POST['rename-massive-hide'], GSDATAUPLOADPATH) || 
		    !self::is_safe_path($afterNewDir, GSDATAUPLOADPATH)) {
			echo '<div class="massive-error">Path traversal detected</div>';
			return;
		}

		if (file_exists($destPath)) {
			echo '<div class="massive-error">' . $fileIsHere . '</div>';
		} else {
			copy($sourcePath, $destPath);
			self::log_action('copy_rename', "Copied: {$_POST['rename-massive-hide']} -> {$afterNewDir}");
			echo ("<meta http-equiv='refresh' content='1'>");
			echo '<div class="massive-done">' . i18n_r("massiveAdmin/INFOCOPY") . $afterNewDir . '</div>';
		}
	}

	public function saveRename(){
		if (!isset($_POST['nonce']) || !self::verify_nonce($_POST['nonce'], 'save_rename')) {
			die('CSRF validation failed');
		}
		
		$oldDirMassive = '../data/uploads/' . $_POST['rename-massive-hide'];
		$newDirMassive = '../data/uploads/' . $_POST['rename-massive'];

		$afterNewDir = preg_replace('/\s+/', '-', $newDirMassive);
		
		if (!self::is_safe_path($_POST['rename-massive-hide'], GSDATAUPLOADPATH) || 
		    !self::is_safe_path($afterNewDir, GSDATAUPLOADPATH)) {
			echo '<div class="massive-error">Path traversal detected</div>';
			return;
		}
		
		$oldPath = GSDATAUPLOADPATH . $_POST['rename-massive-hide'];
		$newPath = GSDATAUPLOADPATH . $afterNewDir;
		
		if (file_exists($oldPath)) {
			rename($oldPath, $newPath);
			self::log_action('save_rename', "Renamed: {$_POST['rename-massive-hide']} -> {$afterNewDir}");
			echo '<div class="massive-done">' . i18n_r("massiveAdmin/FILENOW") . $afterNewDir . '</div>';
			echo ("<meta http-equiv='refresh' content='1'>");
		}
	}

	/* massive uploader */
	public function massiveUpload(){
		if (isset($_POST['massiveUpload']) && (!isset($_POST['nonce']) || !self::verify_nonce($_POST['nonce'], 'upload_file'))) {
			die('CSRF validation failed');
		}
		
		echo '
		<li style="margin: 0 0 3px 0;" class="masive-uploader">
			<h3>' . i18n_r("massiveAdmin/UPLOADFILE") . '</h3>
			<form action="#" class="dropzone"></form>
		</li>';

		$DropFiles = i18n_r('massiveAdmin/DROPFILES');
		echo '<script> const dropFilesName = "' . $DropFiles . '"</script>';
		echo "<script>document.addEventListener('DOMContentLoaded', function(){document.querySelector('.dz-button').innerHTML = dropFilesName});</script>";

		$ds   = DIRECTORY_SEPARATOR;

		if (!empty($_FILES)) {
			$tempFile = $_FILES['file']['tmp_name'];
			$targetPath = GSDATAUPLOADPATH;
			$nameFile = preg_replace('/[^0-9a-z-]+/', '', pathinfo($_FILES['file']['name'])['filename']) . '.' . pathinfo($_FILES['file']['name'])['extension'];
			
			if (!self::is_allowed_extension($_FILES['file']['name'])) {
				echo '<div class="massive-error">File type not allowed</div>';
				return;
			}
			
			if (!self::scan_file_safety($tempFile)) {
				echo '<div class="massive-error">File content not allowed</div>';
				return;
			}
			
			$targetFile =  $targetPath . $nameFile;

			if (file_exists($targetFile)) {
				$targetFile =  $targetPath . rand(0, 3432423) . $nameFile;
			};

			if (move_uploaded_file($tempFile, $targetFile)) {
				self::log_action('upload_file', "Uploaded: {$nameFile}");
			}
		};
	}

	/* composite on page */
	public function compositeOnPage(){
		echo '
		<li>
			<a href="components.php" class="compmassive">' . i18n_r("massiveAdmin/EDITCOMPONENTS") . '</a>
		</li>';
	}

	/*massive option file */
	public function massiveFile(){
		global $SITEURL;
		global $massiveOptionFileContent;
		$newmassiveOptionFile = json_decode($massiveOptionFileContent);
		if ($newmassiveOptionFile->gridfront == "yes") {
			register_style('massivegrid', $SITEURL . 'plugins/massiveAdmin/css/bootstrap-grid.min.css', '2.0', 'screen');
			queue_style('massivegrid', GSFRONT);
		};

		if ($newmassiveOptionFile->grid == "no") {
			register_style('hideUpCke', $SITEURL . 'plugins/massiveAdmin/css/hideUpCke.css', '2.0', 'screen');
			queue_style('hideUpCke', GSBACK);
		};
	}

	/* massive header and icon */

	public function massiveHead()
	{
		global $SITEURL, $USR, $GSADMIN;

		echo '<link rel="stylesheet" href="' . $SITEURL . 'plugins/massiveAdmin/css/massiveIcons.css">
	';
		echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';

		$massiveOptionFile = GSDATAOTHERPATH . '/massiveadmin/massiveOption.json';
		$file = GSDATAOTHERPATH . 'massiveHiddenSection/' . $USR . '.json';
		$url = $SITEURL . ltrim($_SERVER['REQUEST_URI'], '/');

		if (!file_exists($massiveOptionFile)) {
			mkdir(GSDATAOTHERPATH . 'massiveadmin', 0755);
			$content = '{
			"maintence" : "",
			"maintencecontent" : null,
			"grid" : "yes",
			"gridfront" : "no"
		}';

			file_put_contents($massiveOptionFile, $content);
		};

		if (file_exists($file) && filesize($file) > 0) {
			$fileContent = file_get_contents($file);
			$jscheck = json_decode($fileContent, true);

			if (is_array($jscheck)) {
				$restrictedPages = [
					'hidefiles' => 'upload.php',
					'hidethemes' => ['theme.php', 'theme-edit.php'],
					'hidei18n' => 'load.php?id=i18n_gallery',
					'hideplugin' => 'plugins.php',
					'hidepages' => ['pages.php', 'edit.php'],
					'hidesupport' => 'support.php',
					'hidesettings' => 'load.php?id=massiveAdmin',
					'hidegssettings' => 'settings.php'
				];

				foreach ($restrictedPages as $key => $paths) {
					if (isset($jscheck[$key]) && $jscheck[$key] === 'hide') {
						foreach ((array) $paths as $path) {
							if (strpos($url, $SITEURL . $GSADMIN . '/' . $path) !== false) {
								header("HTTP/1.1 403 Forbidden");
								echo "You don't have access to this page";
								exit;
							}
						}
					}
				}
			}
		}
	}

	/* codeMirror edit */
	public function codeMirror(){
		echo '<script>if(document.querySelector(".CodeMirror")!==null){document.querySelector(".CodeMirror textarea").filter="invert(20%)"}</script>';
	}

	/* HELPINFO - DESK */
	public function saveHelpInfo(){
		if (!isset($_POST['nonce']) || !self::verify_nonce($_POST['nonce'], 'help_desk')) {
			die('CSRF validation failed');
		}

		$folder		= GSDATAOTHERPATH . '/massiveHelpDesk/';
		$filename	  = $folder . 'helpdesk.json';
		$chmod_mode	= 0755;

		$checkbox = (isset($_POST['checkbox']) && $_POST['checkbox'] === 'true') ? 'true' : 'false';
		$helper = isset($_POST['helper']) ? $_POST['helper'] : '';
		$helpers = json_encode($helper, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

		$json = '{
			"content": ' . $helpers . ',
			"checkbox":  "' . $checkbox . '" 
		}';

		$folder_exists = file_exists($folder) || mkdir($folder, $chmod_mode);

		if ($folder_exists) {
			file_put_contents($filename, $json, LOCK_EX);
		};

		echo ("<meta http-equiv='refresh' content='0'>");
	}

	/* massiveOption Save Option */
	public function saveMassiveOption(){
		if (!isset($_POST['nonce']) || !self::verify_nonce($_POST['nonce'], 'massive_options')) {
			die('CSRF validation failed');
		}

		// Set up the data
		$yn = function ($key) {
			return (isset($_POST[$key]) && $_POST[$key] === 'yes') ? 'yes' : 'no';
		};
		$grid     = $yn('grid');
		$gridfront = $yn('gridfront');
		$maintence = $yn('maintence');
		$mcontent = isset($_POST['content']) ? $_POST['content'] : '';

		// Set up the folder name and its permissions
		// Note the constant GSDATAOTHERPATH, which points to /path/to/getsimple/data/other/
		$folder		= GSDATAOTHERPATH . '/massiveadmin/';
		$filename	  = $folder . 'massiveOption.json';
		$chmod_mode	= 0755;
		$folder_exists = file_exists($folder) || mkdir($folder, $chmod_mode);

		$json = json_encode(array(
			'maintence'        => $maintence,
			'maintencecontent' => $mcontent,
			'grid'             => $grid,
			'gridfront'        => $gridfront,
		), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

		// Save the file (assuming that the folder indeed exists)
		if ($folder_exists) {
			file_put_contents($filename, $json, LOCK_EX);
		};

		echo "<script>const Another = '" . i18n_r('massiveAdmin/ANOTHERPAGE') . "'</script>";
		echo "
		<script>document.querySelector('.massiveoption').innerHTML = '<span>'+Another+'</span>' </script>";
		echo ("<meta http-equiv='refresh' content='0'>");

		/* hideAdminSection */
	}

	public function saveCreateUser(){
		if (!isset($_POST['nonce']) || !self::verify_nonce($_POST['nonce'], 'manage_users')) {
			die('CSRF validation failed');
		}

		$newposUser = strtolower(preg_replace('/[^a-z0-9._-]/i', '', (string)$_POST['createuserhidden']));
		$disName    = htmlspecialchars(trim($_POST['createdisname']), ENT_XML1, 'UTF-8');
		$createUserEmail = htmlspecialchars(trim($_POST['createuseremail']), ENT_XML1, 'UTF-8');
		$pass = (string)$_POST['createpassword'];
		$lang = (string)$_POST['lang'];

		// Validate input before touching the users folder
		if ($newposUser === '' || $newposUser === '.' || $newposUser === '..' || !preg_match('/^[a-z0-9._-]+$/', $newposUser)) {
			echo '<div class="error" style="padding:10px;background:#f44336;color:white;margin:10px 0;">Invalid username. Use letters, numbers, dot, dash or underscore only.</div>';
			return;
		}
		if ($pass === '') {
			echo '<div class="error" style="padding:10px;background:#f44336;color:white;margin:10px 0;">Password is required.</div>';
			return;
		}
		if (!in_array($lang, array_map(function ($f) { return pathinfo($f, PATHINFO_FILENAME); }, glob(GSLANGPATH . '*.php')), true)) {
			echo '<div class="error" style="padding:10px;background:#f44336;color:white;margin:10px 0;">Invalid language selected.</div>';
			return;
		}

		$newUserFile = GSUSERSPATH . $newposUser . '.xml';
		if (!self::is_safe_path($newposUser . '.xml', GSUSERSPATH)) {
			die('Invalid user path');
		}
		if (file_exists($newUserFile)) {
			echo '<div class="error" style="padding:10px;background:#f44336;color:white;margin:10px 0;">A user with this name already exists.</div>';
			return;
		}

		$passhash = passhash($pass);
		$userinfo = '<?xml version="1.0" encoding="UTF-8"?>
	<item><USR>' . $newposUser . '</USR><NAME>' . $disName . '</NAME><PWD>' . $passhash . '</PWD><EMAIL>' . $createUserEmail . '</EMAIL><HTMLEDITOR>1</HTMLEDITOR><TIMEZONE/><LANG>' . $lang . '</LANG></item>';
		
		file_put_contents($newUserFile, $userinfo, LOCK_EX);
		@chmod($newUserFile, 0644);

		global $SITEURL, $GSADMIN;
		$redirectUrl = $SITEURL . $GSADMIN . "/load.php?id=massiveAdmin&usermanager";
		echo '<script>window.location.href = "' . addslashes($redirectUrl) . '";</script>';
		echo '<noscript><meta http-equiv="refresh" content="0;url=' . htmlspecialchars($redirectUrl, ENT_QUOTES) . '"></noscript>';
	}

	public function saveChangedUser(){
		if (!isset($_POST['nonce']) || !self::verify_nonce($_POST['nonce'], 'manage_users')) {
			die('CSRF validation failed');
		}

		$nameUser = basename((string)$_POST['nameuser']);
		if ($nameUser === '' || !preg_match('/^[a-z0-9._-]+$/i', $nameUser)) {
			die('Invalid user');
		}
		$userFile = GSUSERSPATH . $nameUser . '.xml';
		if (!self::is_safe_path($nameUser . '.xml', GSUSERSPATH) || !file_exists($userFile)) {
			die('Invalid user');
		}

		$data = new SimpleXMLElement(file_get_contents($userFile));
		$oldPWD   = (string)$data->PWD[0];
		$oldLANG  = (string)$data->LANG[0];
		$oldEMAIL = (string)$data->EMAIL[0];
		$oldNAME  = (string)$data->NAME[0];

		$newNAME  = htmlspecialchars(trim($_POST['dname']),  ENT_XML1, 'UTF-8');
		$newEMAIL = htmlspecialchars(trim($_POST['email']),  ENT_XML1, 'UTF-8');
		$newPWD   = (string)$_POST['password'];
		$newLANG  = (string)$_POST['lang'];

		if ($newLANG !== '' && !in_array($newLANG, array_map(function ($f) { return pathinfo($f, PATHINFO_FILENAME); }, glob(GSLANGPATH . '*.php')), true)) {
			die('Invalid language');
		}

		$file = file_get_contents($userFile);

		$file = str_replace('<NAME/>',  '<NAME></NAME>',  $file);
		$file = str_replace('<EMAIL/>', '<EMAIL></EMAIL>', $file);
		$file = str_replace('<LANG/>',  '<LANG></LANG>',  $file);

		if ($newNAME !== '') {
			if ($oldNAME !== '') {
				$file = str_replace('<NAME>' . $oldNAME . '</NAME>', '<NAME>' . $newNAME . '</NAME>', $file);
			} else {
				$file = str_replace('<NAME></NAME>', '<NAME>' . $newNAME . '</NAME>', $file);
			}
		}

		if ($newEMAIL !== '') {
			if ($oldEMAIL !== '') {
				$file = str_replace('<EMAIL>' . $oldEMAIL . '</EMAIL>', '<EMAIL>' . $newEMAIL . '</EMAIL>', $file);
			} else {
				$file = str_replace('<EMAIL></EMAIL>', '<EMAIL>' . $newEMAIL . '</EMAIL>', $file);
			}
		}

		if ($newLANG !== '') {
			if ($oldLANG !== '') {
				$file = str_replace('<LANG>' . $oldLANG . '</LANG>', '<LANG>' . $newLANG . '</LANG>', $file);
			} else {
				$file = str_replace('<LANG></LANG>', '<LANG>' . $newLANG . '</LANG>', $file);
			}
		}

		if ($newPWD !== '') {
			$passhash = passhash($newPWD);
			$file = str_replace('<PWD>' . $oldPWD . '</PWD>', '<PWD>' . $passhash . '</PWD>', $file);
		}

		file_put_contents($userFile, $file, LOCK_EX);

		global $SITEURL, $GSADMIN;
		$redirectUrl = $SITEURL . $GSADMIN . "/load.php?id=massiveAdmin&usermanager";
		echo '<script>window.location.href = "' . addslashes($redirectUrl) . '";</script>';
		echo '<noscript><meta http-equiv="refresh" content="0;url=' . htmlspecialchars($redirectUrl, ENT_QUOTES) . '"></noscript>';
	}

	public function userList(){
		$files = glob(GSUSERSPATH . "*.xml");

		foreach ($files as &$value) {
			$oldDir = ["../data/users/", ".xml"];
			$newDir = ['', ''];
			$newValue = str_replace($oldDir, $newDir, $value);

			$username = new SimpleXMLElement(file_get_contents($value));

			$usrfile = pathinfo($value)['filename'];
			$usrLangFile = (string)$username->LANG[0];

			// Handle POST actions before any HTML output to avoid partial renders before redirect
			if (isset($_POST['changeuser-' . $newValue])) {
				$this->saveChangedUser();
				return;
			}

			if (isset($_POST['deleteuser-' . $newValue])) {
				if (!isset($_POST['nonce']) || !self::verify_nonce($_POST['nonce'], 'manage_users')) {
					die('CSRF validation failed');
				}
				global $USR;
				if ($usrfile !== $USR) {
					unlink($value);
					global $SITEURL, $GSADMIN;
					$redirectUrl = $SITEURL . $GSADMIN . "/load.php?id=massiveAdmin&usermanager";
					echo '<script>window.location.href = "' . addslashes($redirectUrl) . '";</script>';
					echo '<noscript><meta http-equiv="refresh" content="0;url=' . htmlspecialchars($redirectUrl, ENT_QUOTES) . '"></noscript>';
					return;
				} else {
					echo '<div class="error" style="padding:10px;background:#f44336;color:white;margin:10px 0;">Cannot delete currently logged-in user!</div>';
				}
			}

			echo '
			<li> 
				<div class="w3-panel w3-leftbar w3-pale-blue w3-border-blue w3-padding w3-row">
					<div class="w3-col m11 l11">
						<h4 class="w3-margin-top"><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle"width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="currentColor" d="M12 4a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4m0 10c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4"/></svg> ' . htmlspecialchars($usrfile) . '</h4>
					</div>
					<div class="w3-col m1 l1">
						<form action="" method="POST">
							<input type="hidden" name="nonce" value="' . htmlspecialchars(self::generate_nonce('manage_users'), ENT_QUOTES) . '">
							<button name="deleteuser-' . htmlspecialchars($newValue) . '" class="delete-this w3-bar-item w3-btn w3-red w3-round w3-right" style="margin-top:15px; padding: 2px 5px;">
							<svg xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24" id="trash"><path fill="#fff" d="M20,6H16V5a3,3,0,0,0-3-3H11A3,3,0,0,0,8,5V6H4A1,1,0,0,0,4,8H5V19a3,3,0,0,0,3,3h8a3,3,0,0,0,3-3V8h1a1,1,0,0,0,0-2ZM10,5a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1V6H10Zm7,14a1,1,0,0,1-1,1H8a1,1,0,0,1-1-1V8H17Z"></path></svg>
							</button>
						</form>
					</div>
				</div>
							
				<form method="POST">

					<input type="hidden" name="nonce" value="' . htmlspecialchars(self::generate_nonce('manage_users'), ENT_QUOTES) . '">
					<input name="nameuser" type="hidden"  value="' . htmlspecialchars($usrfile) . '">

					<label for="dname"> ' . i18n_r('LABEL_DISPNAME') . ' <span style="opacity:0.7">(' . i18n_r('DISPLAY_NAME'). ')</span></label>
					<input class="w3-input w3-border w3-round w3-margin-bottom" type="text" name="dname" value="' . htmlspecialchars((string)$username->NAME[0]) . '">

					<label for="email"> ' . i18n_r("massiveAdmin/EMAIL") . '</label>
					<input class="w3-input w3-border w3-round w3-margin-bottom" type="email" name="email" value="' . htmlspecialchars($username->EMAIL[0]) . '">

					<label for="password">' . i18n_r("massiveAdmin/PASSWORD") . '</label>
					<input class="w3-input w3-border w3-round w3-margin-bottom" type="password" name="password" placeholder="' . i18n_r("massiveAdmin/CHANGEPLACEHOLDER") . '">

					<label for="lang">' . i18n_r("massiveAdmin/LANG") . '</label>
					<select class="w3-select w3-border w3-round w3-margin-bottom" name="lang">
					';

					foreach (glob(GSLANGPATH . '*.php') as $lang) {
						$pureLang = pathinfo($lang)['filename'];
						echo '
						<option value="' . htmlspecialchars($pureLang) . '" ' . ($usrLangFile == $pureLang  ? 'selected' : '') . '>' . htmlspecialchars($pureLang)  . '</option>';
					}

					echo '
					</select>
					
					<div class="w3-margin-top w3-center">
						<button class="w3-btn w3-large w3-round w3-green" type="submit" name="changeuser-' . htmlspecialchars($newValue) . '">
							' . i18n_r("massiveAdmin/SAVEOPTION") . '
						</button>
					</div>

				</form>
			</li>';
		}
	}

	public function submitHideAdminSection(){
		if (!isset($_POST['nonce']) || !self::verify_nonce($_POST['nonce'], 'hide_admin_section')) {
			die('CSRF validation failed');
		}

		$onoff = function ($key) {
			return (isset($_POST[$key]) && $_POST[$key] === 'hide') ? 'hide' : 'show';
		};
		$hidefiles      = $onoff('hidefiles');
		$hidebackup     = $onoff('hidebackup');
		$hidethemes     = $onoff('hidethemes');
		$hideplugin     = $onoff('hideplugin');
		$hidei18n       = $onoff('hidei18n');
		$hidepages      = $onoff('hidepages');
		$hidesupport    = $onoff('hidesupport');
		$hidesettings   = $onoff('hidesettings');
		$hidegssettings = $onoff('hidegssettings');
		$hideuser       = basename((string)($_POST['user'] ?? ''));

		if ($hideuser === '' || !preg_match('/^[a-z0-9._-]+$/i', $hideuser)) {
			die('Invalid user');
		}

		$json = json_encode(array(
			'hidefiles'      => $hidefiles,
			'hidebackup'     => $hidebackup,
			'hidethemes'     => $hidethemes,
			'hidei18n'       => $hidei18n,
			'hideplugin'     => $hideplugin,
			'hidepages'      => $hidepages,
			'hidesupport'    => $hidesupport,
			'hidesettings'   => $hidesettings,
			'hidegssettings' => $hidegssettings,
		));

		$massiveHiddenSection = GSDATAOTHERPATH . '/massiveHiddenSection/';
		$filejson = $hideuser . '.json';
		$finaljson = $massiveHiddenSection . $filejson;
		$chmod_mode	= 0755;
		$folder_exists = file_exists($massiveHiddenSection) || mkdir($massiveHiddenSection, $chmod_mode);
		if ($folder_exists && self::is_safe_path($filejson, $massiveHiddenSection)) {
			file_put_contents($finaljson, $json, LOCK_EX);
		}
		echo ("<meta http-equiv='refresh' content='0'>");
	}

	/* menu ext */
	public function createLinkMenuExt(){
		if (!isset($_POST['nonce']) || !self::verify_nonce($_POST['nonce'], 'menu_ext')) {
			die('CSRF validation failed');
		}

		$linkname  = isset($_POST['linkname']) ? trim((string)$_POST['linkname']) : '';
		$linkurl   = isset($_POST['linkurl'])  ? trim((string)$_POST['linkurl']) : '';
		$linkblank = (isset($_POST['linkblank']) && $_POST['linkblank'] === '_blank') ? '_blank' : '_self';

		if ($linkname === '' || $linkurl === '') { die('Invalid link'); }
		if (!preg_match('#^(https?://|/|#)#i', $linkurl)) { die('Invalid URL'); }

		$folder		= GSDATAOTHERPATH . 'massiveMenuExt/';
		$filename	  = $folder . 'menuext.json';
		$chmod_mode	= 0755;
		$folder_exists = file_exists($folder) || mkdir($folder, $chmod_mode);
		$daterJson = @file_get_contents($filename);
		$daterJsonNew = json_encode($daterJson);

		if ($folder_exists) {
			$datee = @file_get_contents($filename);
			$data = json_decode($datee, true);
			if (!is_array($data)) { $data = array(); }
			$data[$linkname] = array(
				'name'       => $linkname,
				'url'        => $linkurl,
				'linkblank'  => $linkblank,
			);
			$datee = json_encode($data);

			file_put_contents($filename, $datee, LOCK_EX);
			echo ("<meta http-equiv='refresh' content='0'>");
		};
	}

	/* migrate & SSL */
	public function migrateMassive(){
		if (!isset($_POST['nonce']) || !self::verify_nonce($_POST['nonce'], 'migrate_domain')) {
			die('CSRF validation failed');
		}

		$old = isset($_POST['oldMassiveUrl']) ? (string)$_POST['oldMassiveUrl'] : '';
		$replace = isset($_POST['newMassiveUrl']) ? (string)$_POST['newMassiveUrl'] : '';
		if ($old === '' || $old === $replace) { return; }

		foreach (glob(GSDATAPATH . '{,*/,*/*/,*/*/*/}*.xml', GLOB_BRACE) as $file) {
			$content = file_get_contents($file);
			$new = str_replace($old, $replace, $content);
			file_put_contents($file, $new, LOCK_EX);
		}
	}

	public function forceSSL(){
		if (!isset($_POST['nonce']) || !self::verify_nonce($_POST['nonce'], 'force_ssl')) {
			die('CSRF validation failed');
		}

		$turnon = (isset($_POST['turnon']) && $_POST['turnon'] === 'on') ? 'on' : 'off';
		$file = GSDATAOTHERPATH . 'MassiveForceSSL/';
		$status = $file . 'status.txt';

		if (file_exists($file)) {
			file_put_contents($file . 'status.txt', $turnon, LOCK_EX);
		} else {
			mkdir($file, 0755);
			file_put_contents($file . 'status.txt', $turnon, LOCK_EX);
		}

		//code for htaccess //
		if (file_get_contents($status) == 'on') {
			global $https;
			$htaccess = file_get_contents(GSROOTPATH . '.htaccess');
			$htaccess .= "
			# MassiveAdmin HTACCESS 
			RewriteEngine On 
	RewriteCond %{HTTPS} off 
	RewriteRule .* https://%{HTTP_HOST}%{REQUEST_URI} 
			";
			file_put_contents(GSROOTPATH . '.htaccess', $htaccess);
		} else {
			$htaccess = file_get_contents(GSROOTPATH . '.htaccess');
			$withoutHTTPS =  str_replace("
			# MassiveAdmin HTACCESS 
			RewriteEngine On 
	RewriteCond %{HTTPS} off 
	RewriteRule .* https://%{HTTP_HOST}%{REQUEST_URI} 
			", '', $htaccess);
			file_put_contents(GSROOTPATH . '.htaccess', $withoutHTTPS);
		}
	}

	public function showPassword(){
		if (!isset($_POST['nonce']) || !self::verify_nonce($_POST['nonce'], 'show_password')) {
			die('CSRF validation failed');
		}

		$val = (isset($_POST['showPassword']) && $_POST['showPassword'] === 'on') ? 'on' : 'off';
		$file = GSDATAOTHERPATH . 'MassiveShowPassword/';
		$status = $file . 'status.txt';

		if (file_exists($file)) {
			file_put_contents($file . 'status.txt', $val, LOCK_EX);
		} else {
			mkdir($file, 0755);
			file_put_contents($file . 'status.txt', $val, LOCK_EX);
		}
	}

	// remove forget password
	public function removeForgetPassword(){
		if (!isset($_POST['nonce']) || !self::verify_nonce($_POST['nonce'], 'show_password')) {
			die('CSRF validation failed');
		}

		$val = (isset($_POST['removeForgetPassword']) && $_POST['removeForgetPassword'] === 'on') ? 'on' : 'off';
		$file = GSDATAOTHERPATH . 'MassiveShowForgetPassword/';
		$status = $file . 'status.txt';

		if (file_exists($file)) {
			file_put_contents($file . 'status.txt', $val, LOCK_EX);
		} else {
			mkdir($file, 0755);
			file_put_contents($file . 'status.txt', $val, LOCK_EX);
		}
	}

	// show button password front
	public function showIndexOption(){
		$file = @file_get_contents(GSDATAOTHERPATH . 'MassiveShowPassword/status.txt');
		$file2 = @file_get_contents(GSDATAOTHERPATH . 'MassiveShowForgetPassword/status.txt');

		if ($file == 'on') {
			echo '
			<script>
				window.addEventListener("load", (event) => {
					document.querySelector(".submit").insertAdjacentHTML("afterend",`<button class="button" style="margin-left:5px;padding:7px;" onclick="event.preventDefault();showPass()">
  Show Password</button>`);
				});

				function showPass(){
					if(document.querySelector("#pwd").getAttribute("type")== "password"){
						document.querySelector("#pwd").setAttribute("type","text");
					}else{
						document.querySelector("#pwd").setAttribute("type","password");
					}
				};
			</script>
			';
		};

		if ($file2 == 'on') {
			echo '
			<script>
				window.addEventListener("load", (event) => {
					document.querySelector("#index .cta").remove(); 
				});
			</script>
			';
		};
	}

	//download plugin 
	public function downloadPlugin(){
		// ADDED: CSRF check
		if (!isset($_POST['nonce']) || !self::verify_nonce($_POST['nonce'], 'download_plugin')) {
			die('CSRF validation failed');
		}
		
		function delete_directory($dirname)
		{
			if (is_dir($dirname))
				$dir_handle = opendir($dirname);
			if (!$dir_handle)
				return false;
			while ($file = readdir($dir_handle)) {
				if ($file != "." && $file != "..") {
					if (!is_dir($dirname . "/" . $file))
						unlink($dirname . "/" . $file);
					else
						delete_directory($dirname . '/' . $file);
				}
			}
			closedir($dir_handle);
			rmdir($dirname);
			return true;
		};

		$url = $_POST['url'];
		
		// ADDED: Validate URL - only allow specific domains
		$parsed_url = parse_url($url);
		$allowed_hosts = ['github.com', 'raw.githubusercontent.com', 'getsimple-ce.ovh'];
		if (!in_array($parsed_url['host'], $allowed_hosts)) {
			echo '<div class="error">Download source not allowed</div>';
			return;
		}

		file_put_contents(GSPLUGINPATH . "Tmpfile.zip", fopen("$url", 'r'));
		$path = GSPLUGINPATH . "Tmpfile.zip";

		$zip = new ZipArchive;
		if ($zip->open($path) === TRUE) {
			if (file_exists(GSPLUGINPATH . "tmp_plugin/") == false) {
				mkdir(GSPLUGINPATH . "tmp_plugin/", 0755);
			};
			$zip->extractTo(GSPLUGINPATH  . "tmp_plugin/");
			$zip->close();

			foreach (glob(GSPLUGINPATH  . "tmp_plugin/*/*") as $filename) {
				if (file_exists(str_replace(pathinfo($filename)['dirname'], GSPLUGINPATH, $filename))) {
					delete_directory(str_replace(pathinfo($filename)['dirname'], GSPLUGINPATH, $filename));
				}
				rename($filename, str_replace(pathinfo($filename)['dirname'], GSPLUGINPATH, $filename));
			};

			delete_directory(GSPLUGINPATH . "tmp_plugin");

			unlink($path);
			
			self::log_action('download_plugin', "Downloaded plugin from: {$url}");
		};

		echo '<div class="success" style="position:absolute;top:0;left:0;">Installed!</div>';
		echo ("<meta http-equiv='refresh' content='1'>");
	}

	// remover
	public function unistaller(){
		// ADDED: CSRF check
		if (!isset($_POST['nonce']) || !self::verify_nonce($_POST['nonce'], 'uninstall')) {
			die('CSRF validation failed');
		}
		
		$delPlug = $_POST['delPlugin'] ?? '';

		if ($delPlug === '') {
			return ['deleted' => false, 'reason' => 'No plugin was specified.'];
		}

		$rawDelPlug = $delPlug;
		$delPlug = basename($delPlug);
		if (!preg_match('/^[A-Za-z0-9_\-]+$/', $delPlug)) {
			return ['deleted' => false, 'reason' => 'Plugin name "' . $rawDelPlug . '" contains characters that are not allowed (only letters, numbers, "-", and "_" are permitted).'];
		}

		$pluginRoot = realpath(GSPLUGINPATH);
		if ($pluginRoot === false) {
			return ['deleted' => false, 'reason' => 'Could not resolve the plugins directory (GSPLUGINPATH: ' . GSPLUGINPATH . ').'];
		}

		function delete_directory($dirname){
			if (file_exists($dirname)) {
				if (is_dir($dirname))
					$dir_handle = opendir($dirname);
				if (!$dir_handle)
					return false;
				while ($file = readdir($dir_handle)) {
					if ($file != "." && $file != "..") {
						if (!is_dir($dirname . "/" . $file))
							unlink($dirname . "/" . $file);
						else
							delete_directory($dirname . '/' . $file);
					}
				}
				closedir($dir_handle);
				rmdir($dirname);
				return true;
			}
		};

		$didDelete = false;

		$targetDirRaw = GSPLUGINPATH . $delPlug;
		$targetDir = realpath($targetDirRaw);
		if ($targetDir !== false && is_dir($targetDir)) {
			if (strpos($targetDir, $pluginRoot . DIRECTORY_SEPARATOR) === 0) {
				delete_directory($targetDir);
				$didDelete = true;
			} else {
				return ['deleted' => false, 'reason' => 'Resolved path "' . $targetDir . '" is outside the plugins directory "' . $pluginRoot . '" — refusing to delete.'];
			}
		}

		$targetFileRaw = GSPLUGINPATH . $delPlug . '.php';
		$targetFile = realpath($targetFileRaw);
		if ($targetFile !== false && is_file($targetFile)) {
			if (strpos($targetFile, $pluginRoot . DIRECTORY_SEPARATOR) === 0) {
				unlink($targetFile);
				$didDelete = true;
			} else {
				return ['deleted' => false, 'reason' => 'Resolved path "' . $targetFile . '" is outside the plugins directory "' . $pluginRoot . '" — refusing to delete.'];
			}
		}

		if (!$didDelete) {
			return ['deleted' => false, 'reason' => 'Nothing matching "' . $delPlug . '" (looked for "' . $targetDirRaw . '" and "' . $targetFileRaw . '") was found to delete.'];
		}

		self::log_action('uninstall_plugin', "Uninstalled plugin: {$delPlug}");

		global $GSADMIN;
		global $SITEURL;
		$url =  $SITEURL . $GSADMIN . '/load.php?id=massiveAdmin&unistaller';

		echo '
		<div class="success" style="position:absolute; top:0; left:0; width: 100%; background: green; padding: 10px; box-sizing: border-box; color: #fff; margin-bottom: 20px;">
			Removed!
		</div>';

		echo ("<script>
		setTimeout(()=>{
			window.location.href = '" . $url . "';
		},1000);
		</script>");

		return ['deleted' => true, 'reason' => null];
	}


	// snippet save
	public function snippetSave() {
		if (!isset($_POST['nonce']) || !self::verify_nonce($_POST['nonce'], 'snippet_save')) {
			die('CSRF validation failed');
		}

		$title = (isset($_POST['snippetTitle']) && is_array($_POST['snippetTitle'])) ? $_POST['snippetTitle'] : null;
		$content = (isset($_POST['content']) && is_array($_POST['content'])) ? $_POST['content'] : null;
		$fileFolder = GSDATAOTHERPATH . 'snippetMassive/';
		$filePath = $fileFolder . 'snippet.json';
	
		$snippets = [];
	
		if ($title !== null && $content !== null) {
			if (!file_exists($fileFolder)) {
				mkdir($fileFolder, 0755, true);
			}
	
			foreach ($title as $key => $value) {
				// Sanitize title, allow Unicode letters, numbers, hyphens, underscores, spaces
				$cleanTitle = preg_replace('/[^\p{L}0-9_ -]/u', '', trim($value));
	
				if (!empty($cleanTitle) && isset($content[$key])) {
					// Decode HTML entities to avoid issues like ó
					$cleanContent = html_entity_decode($content[$key], ENT_QUOTES | ENT_HTML5, 'UTF-8');
					$snippets[] = [
						'title' => $cleanTitle,
						'content' => $cleanContent
					];
				}
			}
	
			if (!empty($snippets)) {
				// Encode array to JSON with proper formatting and UTF-8 handling
				$jsonData = json_encode($snippets, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
				if ($jsonData === false) {
					error_log("Failed to encode JSON: " . json_last_error_msg());
				} else {
					if (file_put_contents($filePath, $jsonData, LOCK_EX) === false) {
						error_log("Failed to save JSON to $filePath");
					}
				}
			} else {
				error_log("No valid snippets to save");
			}
		} else {
			if (file_exists($filePath)) {
				unlink($filePath);
			}
		}
	}

	// codemirror components
	public function ComponentsCodeMirror(){
		$CMTHEME = defined('GSCMTHEME') ? constant('GSCMTHEME') : 'blackboard';
		global $SITEURL;
		$compscript = '
		<script src="' . $SITEURL . 'plugins/massiveAdmin/js/codemirror.min.js"></script>
		<link rel="stylesheet" href="' . $SITEURL . 'plugins/massiveAdmin/css/codemirror.min.css">
		<link rel="stylesheet" href="' . $SITEURL . 'plugins/massiveAdmin/css/blackboard.min.css">	
 		<script src="' . $SITEURL . 'plugins/massiveAdmin/js/php.min.js"></script>
		<script src="' . $SITEURL . 'plugins/massiveAdmin/js/css.min.js"></script>
		<script src="' . $SITEURL . 'plugins/massiveAdmin/js/javascript.min.js"></script>
		<script src="' . $SITEURL . 'plugins/massiveAdmin/js/xml.min.js"></script>
		<script src="' . $SITEURL . 'plugins/massiveAdmin/js/htmlmixed.min.js"></script>
		<script src="' . $SITEURL . 'plugins/massiveAdmin/js/clike.min.js"></script>

		<style type="text/css">.CodeMirror {font-size: 15px; width: 100%; height: 200px;border:solid 1px #ccc;}</style>

		<script>
			window.addEventListener("load",()=>{
				if(document.querySelector("#components")) {
					document.querySelectorAll(".compdiv textarea").forEach(x=>{
						var editor = CodeMirror.fromTextArea(x, {
							theme: "' . $CMTHEME . '",
							lineNumbers: true,
							matchBrackets: true,
							indentUnit: 4,
							indentWithTabs: true,
							lineWrapping: true,
							enterMode: "keep",
							tabMode: "shift",
							mode:"htmlmixed"
						});
						
					});
				}
			})
		</script>
		';

		echo $compscript;
			}

	// gsconfig edit
	public function gsConfigEdit(){
		// Check for either our nonce OR the gsconfig module's token (both are
		// now HMACs bound to a per-session server-side secret).
		$valid = false;

		if (isset($_POST['nonce']) && self::verify_nonce($_POST['nonce'], 'edit_gsconfig')) {
			$valid = true;
		}
		if (!$valid && isset($_POST['gs_csrf_token']) && self::verify_nonce((string)$_POST['gs_csrf_token'], 'edit_gsconfig')) {
			$valid = true;
		}
		
		if (!$valid) {
			die('CSRF validation failed');
		}
		
		// Now save the file
		$content = isset($_POST['content']) ? (string)$_POST['content'] : '';

		// Create backup before saving - keep it outside the web root because
		// gsconfig.php may contain secrets (salts).
		$backupDir = GSBACKUPSPATH . 'gsconfig/';
		if (!file_exists($backupDir)) {
			@mkdir($backupDir, 0755, true);
			@file_put_contents($backupDir . '.htaccess', "Require all denied\nDeny from all\n");
			@file_put_contents($backupDir . 'index.php', "<?php exit; ?>\n");
		}
		$backup_path = $backupDir . 'gsconfig.backup.' . date('Y-m-d-H-i-s') . '.php';
		@copy(GSROOTPATH . 'gsconfig.php', $backup_path);
		
		// Save the file
		if (file_put_contents(GSROOTPATH . 'gsconfig.php', $content, LOCK_EX) !== false) {
			self::log_action('edit_gsconfig', "gsconfig.php updated");
			echo '<div class="massive-done">gsconfig.php updated successfully. Backup created: ' . basename($backup_path) . '</div>';
		} else {
			echo '<div class="massive-error">Failed to save gsconfig.php</div>';
		}
	}

	//create option for toper
	public function mtoperSetting(){
		if (!isset($_POST['nonce']) || !self::verify_nonce($_POST['nonce'], 'frontend_settings')) {
			die('CSRF validation failed');
		}

		global $mtoperSettingPath;
		$mtoperSettingPath = GSDATAOTHERPATH . 'massiveToperSettings/';

		$turnon = (isset($_POST['turnon']) && $_POST['turnon'] === 'on') ? 'on' : 'off';
		$style  = isset($_POST['style']) ? basename((string)$_POST['style']) : '';
		$allowedStyles = array_map(function ($f) { return pathinfo($f, PATHINFO_FILENAME); }, glob(GSPLUGINPATH . 'massiveAdmin/toper-theme/*.css'));
		if (!in_array($style, $allowedStyles, true)) {
			$style = $allowedStyles ? $allowedStyles[0] : '';
		}

		if (!file_exists($mtoperSettingPath)) {
			mkdir($mtoperSettingPath, 0755);
			// No "Allow from all": the data directory must stay private.
		};

		file_put_contents($mtoperSettingPath . 'turnon.txt', $turnon, LOCK_EX);
		file_put_contents($mtoperSettingPath . 'style.txt', $style, LOCK_EX);

		echo ("<meta http-equiv='refresh' content='0'>");
	}

	public function createBackupZip(){
		if (!isset($_POST['nonce']) || !self::verify_nonce($_POST['nonce'], 'backup_creator')) {
			die('CSRF validation failed');
		}

		$folderPath = isset($_POST['folder']) ? (string)$_POST['folder'] : '';
		$allowedFolders = array(
			GSDATAUPLOADPATH => 'upload',
			GSPLUGINPATH     => 'plugins',
			GSDATAPATH       => 'data',
			GSTHEMESPATH     => 'themes',
			GSADMINPATH      => 'admin',
		);
		if (!isset($allowedFolders[$folderPath])) {
			die('Invalid backup folder');
		}
		$foldername = $allowedFolders[$folderPath];

		// Specify the name for the zip file
		$dateString = date('Y-m-d-Hi_s');

		$backupDir = GSBACKUPSPATH . 'backupCreator/';
		if (!file_exists($backupDir)) {
			mkdir($backupDir, 0755);
		};
		// Backups may contain credentials, so keep the directory private and
		// serve downloads through admin/download.php instead of "Allow from all".
		if (!file_exists($backupDir . '.htaccess')) {
			file_put_contents($backupDir . '.htaccess', "Require all denied\nDeny from all\n");
		};

		$zipFileName = $backupDir . $dateString . '-' . $foldername . '.zip';

		// Create a ZipArchive object
		$zip = new ZipArchive();

		// Open the zip file for writing
		if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {

			// Add all files and folders from the specified folder
			$files = new RecursiveIteratorIterator(
				new RecursiveDirectoryIterator($folderPath, RecursiveDirectoryIterator::SKIP_DOTS),
				RecursiveIteratorIterator::SELF_FIRST
			);

			foreach ($files as $file) {
				$filePath = $file->getRealPath();
				$relativePath = substr($filePath, strlen(dirname($folderPath)) + 1);

				if ($file->isDir()) {
					$zip->addEmptyDir($relativePath);
				} elseif ($file->isFile()) {
					$zip->addFile($filePath, $relativePath);
				}
			}

			// Close the zip file
			$zip->close();
		} else {
			echo 'Failed to create zip file';
		}

		echo ("<meta http-equiv='refresh' content='0'>");
	}

	public function deleteBackupZip(){
		if (!isset($_POST['nonce']) || !self::verify_nonce($_POST['nonce'], 'backup_creator')) {
			die('CSRF validation failed');
		}

		$backupDir = GSBACKUPSPATH . 'backupCreator/';
		$requested = isset($_POST['delbackup']) ? (string)$_POST['delbackup'] : '';

		// Only allow deleting an existing *.zip that really lives in the
		// backupCreator directory - never trust the submitted path.
		$name = basename(str_replace('\\', '/', $requested));
		$file = $backupDir . $name;
		if (
			$name === '' ||
			!preg_match('/^[A-Za-z0-9._-]+\.zip$/', $name) ||
			!file_exists($file) ||
			!self::is_safe_path($name, $backupDir)
		) {
			die('Invalid backup file');
		}

		unlink($file);
		echo ("<meta http-equiv='refresh' content='0'>");
	}
};
?>