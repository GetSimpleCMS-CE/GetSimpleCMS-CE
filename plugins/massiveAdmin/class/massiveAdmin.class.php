<?php

class MassiveAdminClass{

	/* massive Options */
	public function deleteFileList(){
		$list = $_POST['delFileList'];
		$ar = explode(",", $list);
		foreach ($ar as $key => $value) {
			unlink(GSDATAUPLOADPATH . $value);
			echo ("<meta http-equiv='refresh' content='1'>");
		};
	}

	public function copyRename(){
		$fileIsHere = i18n_r("massiveAdmin/INFOERROR");

		$oldDirMassive = '../data/uploads/' . $_POST['rename-massive-hide'];
		$newDirMassive = '../data/uploads/' . $_POST['rename-massive'];

		$afterNewDir = preg_replace('/\s+/', '-', $newDirMassive);

		if (file_exists($afterNewDir) == 'true') {
			echo '<div class="massive-error">' . $fileIsHere . '</div>';
		} else {
			copy($oldDirMassive, $afterNewDir);
			echo ("<meta http-equiv='refresh' content='1'>");
			echo '<div class="massive-done">' . i18n_r("massiveAdmin/INFOCOPY") . $afterNewDir . '</div>';
		}
	}

	public function saveRename(){
		$oldDirMassive = '../data/uploads/' . $_POST['rename-massive-hide'];
		$newDirMassive = '../data/uploads/' . $_POST['rename-massive'];

		$afterNewDir = preg_replace('/\s+/', '-', $newDirMassive);

		rename($oldDirMassive, $afterNewDir);
		echo '<div class="massive-done">' . i18n_r("massiveAdmin/FILENOW") . $afterNewDir . '</div>';
		echo ("<meta http-equiv='refresh' content='1'>");
	}

	/* massive uploader */
	public function massiveUpload(){
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
			$targetFile =  $targetPath . $nameFile;

			if (file_exists($targetFile)) {
				$targetFile =  $targetPath . rand(0, 3432423) . $nameFile;
			};

			move_uploaded_file($tempFile, $targetFile);
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

		echo '<link rel="stylesheet" href="' . $SITEURL . 'plugins/massiveAdmin/css/massiveIcons.css">';
		echo ' <meta name="viewport" content="width=device-width, initial-scale=1.0">';

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
		}
		;

		

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
		$folder		= GSDATAOTHERPATH . '/massiveHelpDesk/';
		$filename	  = $folder . 'helpdesk.json';
		$chmod_mode	= 0755;

		$checkbox = $_POST['checkbox'];
		if ($checkbox == 'true') {
			$checkboxer = "true";
		} else {
			$checkboxer = "false";
		}
		$helper = $_POST['helper'];
		$helpers =  json_encode($helper,  JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
		$json = '{
			"content": ' . $helpers . ',
			"checkbox":  "' . $checkboxer . '" 
		}';

		$folder_exists = file_exists($folder) || mkdir($folder, $chmod_mode);

		// Save the file (assuming that the folder indeed exists)
		if ($folder_exists) {
			file_put_contents($filename, $json);
		};

		echo ("<meta http-equiv='refresh' content='0'>");
	}

	/* massiveOption Save Option */
	public function saveMassiveOption(){
		// Set up the data
		$grid = $_POST["grid"];
		$gridfront = $_POST["gridfront"];
		$maintence = $_POST["maintence"];
		$mcontent = $_POST["content"];
		$mcontentNew =  json_encode($mcontent,  JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);

		// Set up the folder name and its permissions
		// Note the constant GSDATAOTHERPATH, which points to /path/to/getsimple/data/other/
		$folder		= GSDATAOTHERPATH . '/massiveadmin/';
		$filename	  = $folder . 'massiveOption.json';
		$chmod_mode	= 0755;
		$folder_exists = file_exists($folder) || mkdir($folder, $chmod_mode);

		$json = '{
			"maintence" : "' . $maintence . '",
			"maintencecontent" : ' . $mcontentNew . ',
			"grid" : "' . $grid . '",
			"gridfront" : "' . $gridfront . '"
		}';

		// Save the file (assuming that the folder indeed exists)
		if ($folder_exists) {
			file_put_contents($filename, $json);
		};

		echo "<script>const Another = '" . i18n_r('massiveAdmin/ANOTHERPAGE') . "'</script>";
		echo "<script>document.querySelector('.massiveoption').innerHTML = '<span>'+Another+'</span>' </script>";
		echo ("<meta http-equiv='refresh' content='0'>");

		/* hideAdminSection */
	}

	public function saveCreateUser(){
		$newposUser = $_POST['createuserhidden'];
		$newposUserwithspace = str_replace(' ', '-', $newposUser);
		$supportUserMailMonkey = str_replace('@', '', $newposUserwithspace);
		$supportUserMailFinal = str_replace('.', '', $supportUserMailMonkey);
		$createUserEmail = $_POST['createuseremail'];
		$pass = $_POST['createpassword'];
		$lang = $_POST['lang'];
		$passhash = passhash($pass);
		$folder = '../data/users';
		$newUserFile = $folder . '/' . $supportUserMailFinal . '.xml';
		$userinfo = '<?xml version="1.0" encoding="UTF-8"?>
<item><USR>' . strtolower($newposUser) . '</USR><NAME/><PWD>' . $passhash . '</PWD><EMAIL>' . $createUserEmail . '</EMAIL><HTMLEDITOR>1</HTMLEDITOR><TIMEZONE/><LANG>' . $lang . '</LANG></item>';
		file_put_contents($newUserFile, $userinfo);

		chmod($newUserFile, 0755);

		echo ("<meta http-equiv='refresh' content='0'>");
	}

	public function saveChangedUser(){
		$file = file_get_contents(GSUSERSPATH . $_POST['nameuser'] . '.xml');
		$data = new SimpleXMLElement(file_get_contents(GSUSERSPATH . $_POST['nameuser'] . '.xml'));
		$oldPWD = $data->PWD[0];
		$oldLANG = $data->LANG[0];
		$oldEMAIL = $data->EMAIL[0];

		$newEMAIL = $_POST['email'];
		$newePWD = $_POST['password'];
		$newLANG = $_POST['lang'];

		if ($oldPWD !== $newEMAIL && $newEMAIL !== '') {
			$file = str_replace($oldEMAIL, $newEMAIL, $file);
		};

		if ($oldLANG !==  $newLANG &&  $newLANG !== '') {
			$file = str_replace($oldLANG, $newLANG, $file);
		};

		if ($newPWD !== '') {
			$passhash = passhash($newePWD);
			$file = str_replace($oldPWD, $passhash, $file);
		};

		file_put_contents(GSUSERSPATH . $_POST['nameuser'] . '.xml', $file);

		echo ("<meta http-equiv='refresh' content='0'>");
	}

	public function userList(){
		$files = glob(GSUSERSPATH . "*.xml");

		foreach ($files as &$value) {
			$oldDir = ["../data/users/", ".xml"];
			$newDir = ['', ''];
			$newValue = str_replace($oldDir, $newDir, $value);

			$username = new SimpleXMLElement(file_get_contents($value));

			$usrfile = pathinfo($value)['filename'];
			$usrLangFile = $username->LANG[0];

			echo '
			<li> 
				<div class="w3-panel w3-leftbar w3-pale-blue w3-border-blue w3-padding w3-row">
					<div class="w3-col m11 l11">
						<h4 class="w3-margin-top"><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle"width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="currentColor" d="M12 4a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4m0 10c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4"/></svg> ' . $usrfile . '</h4>
					</div>
					<div class="w3-col m1 l1">
						<form action="" method="POST">
							<button name="' . $newValue . '" class="delete-this w3-bar-item w3-btn w3-red w3-round w3-right" style="margin-top:15px; padding: 2px 5px;">
							<svg xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24" id="trash"><path fill="#fff" d="M20,6H16V5a3,3,0,0,0-3-3H11A3,3,0,0,0,8,5V6H4A1,1,0,0,0,4,8H5V19a3,3,0,0,0,3,3h8a3,3,0,0,0,3-3V8h1a1,1,0,0,0,0-2ZM10,5a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1V6H10Zm7,14a1,1,0,0,1-1,1H8a1,1,0,0,1-1-1V8H17Z"></path></svg>
							</button>
						</form>
					</div>
				</div>
							
				<form method="POST">

					<input name="nameuser" type="hidden"  value="' . $usrfile . '">

					<label for="email">' . i18n_r("massiveAdmin/EMAIL") . '</label>
					<input class="w3-input w3-border w3-round w3-margin-bottom" type="email" name="email" value="' . $username->EMAIL[0] . '">

					<label for="password">' . i18n_r("massiveAdmin/PASSWORD") . '</label>
					<input class="w3-input w3-border w3-round w3-margin-bottom" type="password" name="password" placeholder="' . i18n_r("massiveAdmin/CHANGEPLACEHOLDER") . '">

					<label for="password">' . i18n_r("massiveAdmin/LANG") . '</label>
					<select class="w3-select w3-border w3-round w3-margin-bottom w3-margin-bottom" name="lang">
					';

					foreach (glob(GSLANGPATH . '*.php') as $lang) {
						$pureLang = pathinfo($lang)['filename'];
						echo '
						<option value="' . $pureLang . '" ' . ($usrLangFile == $pureLang  ? 'selected' : '') . '>' . $pureLang  . '</option>';
					};

					echo '
					</select>
					
					<div class="w3-margin-top w3-center">
						<button class="w3-btn w3-large w3-round w3-green" type="submit" name="changeuser-' . $newValue . '">
							' . i18n_r("massiveAdmin/SAVEOPTION") . '
						</button>
					</div>

				</form>
			</li>';

			if (isset($_POST['changeuser-' . $newValue])) {
				$this->saveChangedUser();
				echo ("<meta http-equiv='refresh' content='0'>");
			};

			if (isset($_POST[$newValue])) {
				unlink($value);
				echo ("<meta http-equiv='refresh' content='0'>");
			};
		};
	}

	public function submitHideAdminSection(){
		$hidefiles = $_POST['hidefiles'];
		$hidebackup = $_POST['hidebackup'];
		$hidethemes = $_POST['hidethemes'];
		$hideplugin = $_POST['hideplugin'];
		$hidei18n = $_POST['hidei18n'];
		$hidepages = $_POST['hidepages'];
		$hidesupport = $_POST['hidesupport'];
		$hidesettings = $_POST['hidesettings'];
		$hidegssettings = $_POST['hidegssettings'];
		$hideuser = $_POST['user'];

		$json = '{
			"hidefiles": "' . $hidefiles . '",
			"hidebackup": "' . $hidebackup . '",
			"hidethemes": "' . $hidethemes . '",
			"hidei18n": "' . $hidei18n . '",
			"hideplugin":"' . $hideplugin . '",
			"hidepages": "' . $hidepages . '",
 			"hidesupport": "' . $hidesupport . '",
			"hidesettings": "' . $hidesettings . '",
			"hidegssettings": "' . $hidegssettings . '"
		}';

		$massiveHiddenSection = GSDATAOTHERPATH . '/massiveHiddenSection/';
		$filejson = $hideuser . '.json';
		$finaljson = $massiveHiddenSection . $filejson;
		$chmod_mode	= 0755;
		$folder_exists = file_exists($massiveHiddenSection) || mkdir($massiveHiddenSection, $chmod_mode);
		file_put_contents($finaljson, $json);
		echo ("<meta http-equiv='refresh' content='0'>");
	}

	/* menu ext */
	public function createLinkMenuExt(){
		$folder		= GSDATAOTHERPATH . 'massiveMenuExt/';
		$filename	  = $folder . 'menuext.json';
		$chmod_mode	= 0755;
		$folder_exists = file_exists($folder) || mkdir($folder, $chmod_mode);
		$daterJson = @file_get_contents($filename);
		$daterJsonNew = json_encode($daterJson);

		if ($folder_exists) {
			$datee = @file_get_contents($filename);
			$data = json_decode($datee, true);
			$data[$_POST['linkname']] = array();
			$data[$_POST['linkname']]['name'] = $_POST['linkname'];
			$data[$_POST['linkname']]['url'] = $_POST['linkurl'];
			$data[$_POST['linkname']]['linkblank'] = $_POST['linkblank'];
			$datee = json_encode($data, true);

			file_put_contents($filename, $datee);
			echo ("<meta http-equiv='refresh' content='0'>");
		};
	}

	/* migrate & SSL */
	public function migrateMassive(){
		foreach (glob(GSDATAPATH . '{,*/,*/*/,*/*/*/}*.xml', GLOB_BRACE) as $file) {
			$old = $_POST['oldMassiveUrl'];
			$replace = $_POST['newMassiveUrl'];
			$content = file_get_contents($file);
			$new = str_replace($old, $replace, $content);
			file_put_contents($file, $new);
		}
	}

	public function forceSSL(){
		$file = GSDATAOTHERPATH . 'MassiveForceSSL/';
		$status = $file . 'status.txt';

		if (file_exists($file)) {
			file_put_contents($file . 'status.txt', $_POST['turnon'] ?? '');
		} else {
			mkdir($file, 0755);
			file_put_contents($file . 'status.txt', $_POST['turnon'] ?? '');
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

	// showPassword option 
	public function showPassword(){
		$file = GSDATAOTHERPATH . 'MassiveShowPassword/';
		$status = $file . 'status.txt';

		if (file_exists($file)) {
			file_put_contents($file . 'status.txt', $_POST['showPassword'] ?? '');
		} else {
			mkdir($file, 0755);
			file_put_contents($file . 'status.txt', $_POST['showPassword'] ?? '');
		}
	}

	// remove forget password
	public function removeForgetPassword(){
		$file = GSDATAOTHERPATH . 'MassiveShowForgetPassword/';
		$status = $file . 'status.txt';

		if (file_exists($file)) {
			file_put_contents($file . 'status.txt', $_POST['removeForgetPassword'] ?? '');
		} else {
			mkdir($file, 0755);
			file_put_contents($file . 'status.txt', $_POST['removeForgetPassword'] ?? '');
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
		};

		echo '<div class="success" style="position:absolute;top:0;left:0;">Installed!</div>';
		echo ("<meta http-equiv='refresh' content='1'>");
	}

	// remover
	public function unistaller(){
		$delPlug = $_GET['delPlugin'];

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

		if (GSPLUGINPATH . $delPlug) {
			delete_directory(GSPLUGINPATH . $delPlug);
		};

		if (file_exists(GSPLUGINPATH . $delPlug . '.php')) {
			unlink(GSPLUGINPATH . $delPlug . '.php');
		}

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
	}

	// snippet save
	public function snippetSave() {
		$title = $_POST['snippetTitle'] ?? null;
		$content = $_POST['content'] ?? null;
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
					if (file_put_contents($filePath, $jsonData) === false) {
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
		file_put_contents(GSROOTPATH . 'gsconfig.php', $_POST['content']);
	}

	//create option for toper
	public function mtoperSetting(){
		global $mtoperSettingPath;
		$mtoperSettingPath = GSDATAOTHERPATH . 'massiveToperSettings/';

		if (!file_exists($mtoperSettingPath)) {
			mkdir($mtoperSettingPath, 0755);
			file_put_contents($mtoperSettingPath . '.htaccess', 'Allow from All');
		};

		file_put_contents($mtoperSettingPath . 'turnon.txt', $_POST['turnon']);
		file_put_contents($mtoperSettingPath . 'style.txt', $_POST['style']);

		echo ("<meta http-equiv='refresh' content='0'>");
	}

	public function createBackupZip(){
		$folderPath = $_POST['folder'];
		$foldername = '';
		if ($folderPath == GSDATAUPLOADPATH) {
			$foldername = 'upload';
		} elseif ($folderPath == GSPLUGINPATH) {
			$foldername = 'plugins';
		} elseif ($folderPath == GSDATAPATH) {
			$foldername = 'data';
		} elseif ($folderPath == GSTHEMESPATH) {
			$foldername = 'themes';
		} elseif ($folderPath == GSADMINPATH) {
			$foldername = 'admin';
		};

		// Specify the name for the zip file
		$dateString = date('Y-m-d-Hi_s');

		if (!file_exists(GSBACKUPSPATH . 'backupCreator/')) {
			mkdir(GSBACKUPSPATH . 'backupCreator/', 0755);
			file_put_contents(GSBACKUPSPATH . 'backupCreator/.htaccess', 'Allow from all');
		};

		$zipFileName = GSBACKUPSPATH . 'backupCreator/' . $dateString . '-' . $foldername . '.zip';

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
		global $SITEURL;
		global $GSADMIN;
		unlink($_POST['delbackup']);
		echo ("<meta http-equiv='refresh' content='0'>");
	}
};