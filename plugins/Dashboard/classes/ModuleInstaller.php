<?php
if (!defined('IN_GS')) { die('You cannot load this page directly.'); }

class ModuleInstaller {

	const DB_URL	  = 'https://getsimplecms-ce-plugins.github.io/mdb.json';
	const MODULES_DIR = 'Dashboard/modules/';

	// -------------------------------------------------------
	// Fetch remote DB
	// -------------------------------------------------------
	private static function fetchDB() {
		$json = @file_get_contents(self::DB_URL);
		if (!$json) return array();
		$data = json_decode($json, true);
		return is_array($data) ? $data : array();
	}

	// -------------------------------------------------------
	// Get installed modules as id => version map
	// -------------------------------------------------------
	private static function getInstalled() {
		$installed = array();
		$path = GSPLUGINPATH . self::MODULES_DIR;
		if (!is_dir($path)) return $installed;
		foreach (glob($path . '*.php') as $file) {
			$contents = file_get_contents($file);
			$id	  = null;
			$version = '0';
			if (preg_match('/Module ID:\s*(.+)/i', $contents, $m))	  $id	  = trim($m[1]);
			if (preg_match('/Version:\s*(.+)/i',   $contents, $m))	  $version = trim($m[1]);
			if ($id) $installed[$id] = $version;
		}
		return $installed;
	}

	// -------------------------------------------------------
	// Handle install POST — called from top-level AJAX block
	// -------------------------------------------------------
	public static function install() {
		header('Content-Type: application/json');

		$url = isset($_POST['url']) ? trim($_POST['url']) : '';
		$id  = isset($_POST['id'])  ? trim($_POST['id'])  : '';

		if (!$url || !$id) {
			echo json_encode(array('status' => 'error', 'message' => i18n_r('Dashboard/lang_Missing_parameters') . '.'));
			return;
		}

		// Only allow zip downloads from github.com
		if (!preg_match('#^https://github\.com/#', $url)) {
			echo json_encode(array('status' => 'error', 'message' => i18n_r('Dashboard/lang_Invalid_URL') . '.'));
			return;
		}

		// Download zip to temp file
		$tmpZip = sys_get_temp_dir() . '/dash_module_' . $id . '.zip';
		$zipData = @file_get_contents($url);
		if (!$zipData) {
			echo json_encode(array('status' => 'error', 'message' => i18n_r('Dashboard/lang_Failed_download') . '.'));
			return;
		}
		file_put_contents($tmpZip, $zipData);

		// Extract zip
		$zip = new ZipArchive();
		if ($zip->open($tmpZip) !== true) {
			@unlink($tmpZip);
			echo json_encode(array('status' => 'error', 'message' => i18n_r('Dashboard/lang_Failed_to_open') . '.'));
			return;
		}

		$modulesDir = GSPLUGINPATH . self::MODULES_DIR;
		if (!is_dir($modulesDir)) mkdir($modulesDir, 0755, true);

		// GitHub zips extract to a folder like "repo-name-main/"
		// Find the root prefix (e.g. "siteoverview-main/") to strip it
		$prefix = '';
		for ($i = 0; $i < $zip->numFiles; $i++) {
			$name = $zip->getNameIndex($i);
			if (substr($name, -1) === '/' && substr_count(trim($name, '/'), '/') === 0) {
				$prefix = $name;
				break;
			}
		}

		$installed	= array();
		$validModules = array();

		// First pass — identify valid module .php files at the repo root level
		for ($i = 0; $i < $zip->numFiles; $i++) {
			$name = $zip->getNameIndex($i);
			if (substr($name, -1) === '/') continue; // skip directories
			$relative = $prefix ? substr($name, strlen($prefix)) : $name;
			if (empty($relative)) continue;
			$depth = substr_count(trim($relative, '/'), '/');
			// Top-level .php files are the module entry points
			if ($depth === 0 && substr($relative, -4) === '.php' && substr($relative, 0, 1) !== '.') {
				$contents = $zip->getFromIndex($i);
				if (preg_match('/Module ID:\s*(.+)/i', $contents, $match)) {
					$validModules[] = pathinfo($relative, PATHINFO_FILENAME); // e.g. "siteoverview"
				}
			}
		}

		if (empty($validModules)) {
			$zip->close();
			@unlink($tmpZip);
			echo json_encode(array('status' => 'error', 'message' => i18n_r('Dashboard/lang_No_valid_module') . '.'));
			return;
		}

		// Second pass — extract all files that belong to a valid module
		for ($i = 0; $i < $zip->numFiles; $i++) {
			$name = $zip->getNameIndex($i);
			if (substr($name, -1) === '/') continue; // skip directories
			$relative = $prefix ? substr($name, strlen($prefix)) : $name;
			if (empty($relative) || (substr(basename($relative), 0, 1) === '.' && basename($relative) !== '.htaccess')) continue;

			// Check this file belongs to one of the valid modules:
			// either it IS the module php (siteoverview.php)
			// or it lives inside the module's subfolder (siteoverview/lang/en_US.php)
			$belongs = false;
			foreach ($validModules as $moduleId) {
				if ($relative === $moduleId . '.php' ||
					strpos($relative, $moduleId . '/') === 0) {
					$belongs = true;
					break;
				}
			}
			if (!$belongs) continue;

			$destPath = $modulesDir . $relative;
			$destDir  = dirname($destPath);
			if (!is_dir($destDir)) mkdir($destDir, 0755, true);
			file_put_contents($destPath, $zip->getFromIndex($i));
			$installed[] = $relative;
		}

		$zip->close();
		@unlink($tmpZip);

		echo json_encode(array('status' => 'ok', 'message' => i18n_r('Dashboard/lang_Module_installed') . '.', 'files' => $installed));
	}

	// -------------------------------------------------------
	// Render the module store panel (injected into the tab via AJAX)
	// -------------------------------------------------------
	public static function renderPanel() {
		global $SITEURL;
		$db		= self::fetchDB();
		$installed = self::getInstalled();
		?>
		<style>
			.mstore-grid {
				display: grid;
				grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
				gap: 16px;
				margin-top: 16px;
			}
			.mstore-card {
				background: #fff;
				border: 1px solid #e0e0e0;
				border-radius: 6px;
				padding: 16px;
				display: flex;
				flex-direction: column;
				gap: 8px;
				font-size: 13px;
			}
			.mstore-card-name {
				font-weight: 700;
				font-size: 14px;
				color: #222;
			}
			.mstore-card-info {
				color: #666;
				flex: 1;
				line-height: 1.5;
			}
			.mstore-card-meta {
				font-size: 11px;
				color: #999;
				display: flex;
				gap: 12px;
				flex-wrap: wrap;
			}
			.mstore-card-meta a {
				color: #4a90d9;
				text-decoration: none!important;
			}
			.mstore-card-meta a:hover { text-decoration: underline; }
			.mstore-card-footer {
				display: flex;
				align-items: center;
				justify-content: space-between;
				margin-top: 4px;
				gap: 8px;
			}
			.mstore-btn {
				padding: 5px 14px;
				border-radius: 4px;
				font-size: 12px;
				border: none;
				cursor: pointer;
				font-weight: 600;
				transition: background 0.15s;
			}
			.mstore-btn-install {
				background: #4a90d9;
				color: #fff;
			}
			.mstore-btn-install:hover { background: #357abd; }
			.mstore-btn-installed {
				background: #d4edda;
				color: #28a745;
				border: 1px solid #28a745;
				cursor: default;
			}
			.mstore-btn-update {
				background: #fff3cd;
				color: #856404;
				border: 1px solid #ffc107;
			}
			.mstore-btn-update:hover { background: #ffe69c; }
			.mstore-version {
				font-size: 11px;
				color: #aaa;
			}
			.mstore-msg {
				font-size: 12px;
				margin-left: 8px;
				font-weight: 600;
			}
			.mstore-msg.ok	{ color: #28a745; }
			.mstore-msg.error { color: #e74c3c; }
			.mstore-search {
				width: 100%;
				max-width: 360px;
				padding: 7px 12px;
				border: 1px solid #ddd;
				border-radius: 4px;
				font-size: 13px;
				margin-bottom: 4px;
			}
			.mstore-search:focus { outline: none; border-color: #4a90d9; }
			.mstore-empty { color: #bbb; font-style: italic; margin-top: 24px; }
		</style>

		<?php if (empty($db)): ?>
			<p class="mstore-empty"><?php echo i18n_r('Dashboard/lang_Could_not_load_db'); ?>.</p>
		<?php else: ?>
			<input type="text" class="mstore-search" id="mstore-search" placeholder="🔎 <?php echo i18n_r('Dashboard/lang_Search_Model'); ?>..." />
			<div class="mstore-grid" id="mstore-grid">
					<?php foreach ($db as $mod):
						$id		= htmlspecialchars($mod['id']);
						$name	  = htmlspecialchars($mod['name']);
						$info	  = htmlspecialchars($mod['info']);
						$version   = htmlspecialchars($mod['version']);
						$author	= htmlspecialchars($mod['author']);
						$repo	  = htmlspecialchars($mod['repo']);
						$wiki	  = isset($mod['wiki']) ? htmlspecialchars($mod['wiki']) : '';
						$url	   = htmlspecialchars($mod['url']);
						$localVer  = isset($installed[$mod['id']]) ? $installed[$mod['id']] : null;
						$hasUpdate = $localVer !== null && version_compare($mod['version'], $localVer, '>');
						$isInstalled = $localVer !== null && !$hasUpdate;
					?>
						<div class="mstore-card" data-name="<?php echo strtolower($name); ?>" data-info="<?php echo strtolower($info); ?>" data-author="<?php echo strtolower($author); ?>">
							<div class="mstore-card-name"><?php echo $name; ?></div>
							<div class="mstore-card-info"><?php echo $info; ?></div>
							<div class="mstore-card-meta">
								<span><svg data-src="<?php echo $SITEURL ?>plugins/Dashboard/assets/img/author.svg" style="vertical-align:middle; width:16px; height:16px;"></svg> <strong><?php echo $author; ?></strong></span>
								<a href="<?php echo $repo; ?>" target="_blank"><svg data-src="<?php echo $SITEURL ?>plugins/Dashboard/assets/img/github.svg" style="vertical-align:middle; width:16px; height:16px;"></svg> Repo</a>
								<?php if ($wiki): ?>
									<a href="<?php echo $wiki; ?>" target="_blank"><svg data-src="<?php echo $SITEURL ?>plugins/Dashboard/assets/img/wiki.svg" style="vertical-align:middle; width:16px; height:16px;"></svg> Wiki</a>
								<?php endif; ?>
							</div>
							<div class="mstore-card-footer">
								<span class="mstore-version">
									v<?php echo $version; ?>
									<?php if ($hasUpdate): ?>
										<span style="color:#856404;"> (<?php echo i18n_r('Dashboard/lang_Installed'); ?>: v<?php echo htmlspecialchars($localVer); ?>)</span>
									<?php endif; ?>
								</span>
								<?php if ($isInstalled): ?>
									<button class="mstore-btn mstore-btn-installed" disabled>✓ <?php echo i18n_r('Dashboard/lang_Installed'); ?></button>
								<?php elseif ($hasUpdate): ?>
									<button class="mstore-btn mstore-btn-update mstore-btn-install"
											data-id="<?php echo $id; ?>"
											data-url="<?php echo $url; ?>">↑ <?php echo i18n_r('Dashboard/lang_Update'); ?></button>
								<?php else: ?>
									<button class="mstore-btn mstore-btn-install"
											data-id="<?php echo $id; ?>"
											data-url="<?php echo $url; ?>"><?php echo i18n_r('Dashboard/lang_Install'); ?></button>
								<?php endif; ?>
								<span class="mstore-msg" id="mstore-msg-<?php echo $id; ?>"></span>
							</div>
						</div>
					<?php endforeach; ?>
					</div>
		<?php endif; ?>

		<script>
		// Install / Update
		document.querySelectorAll('.mstore-btn-install').forEach(function(btn) {
			btn.addEventListener('click', function() {
				var id	  = this.dataset.id;
				var url	 = this.dataset.url;
				var msg	 = document.getElementById('mstore-msg-' + id);
				var self	= this;
				var isUpdate = self.classList.contains('mstore-btn-update');

				self.disabled = true;
				self.textContent = isUpdate ? '<?php echo i18n_r('Dashboard/lang_Updating'); ?>...' : '<?php echo i18n_r('Dashboard/lang_Installing'); ?>...';
				if (msg) msg.textContent = '';

				var xhr = new XMLHttpRequest();
				xhr.open('POST', 'load.php?id=Dashboard&dashboard-settings');
				xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				xhr.onload = function() {
					try {
						var res = JSON.parse(xhr.responseText);
						if (res.status === 'ok') {
							self.className = 'mstore-btn mstore-btn-installed';
							self.textContent = '✓ ' + (isUpdate ? '<?php echo i18n_r('Dashboard/lang_Updated'); ?>' : '<?php echo i18n_r('Dashboard/lang_Installed'); ?>');
							self.disabled = true;
							if (msg) {
								msg.className = 'mstore-msg ok';
								// Countdown redirect
								var secs = 3;
								msg.textContent = '<?php echo i18n_r('Dashboard/lang_Reloading'); ?> ' + secs + 's...';
								var timer = setInterval(function() {
									secs--;
									if (secs <= 0) {
										clearInterval(timer);
										window.location.href = 'load.php?id=Dashboard&dashboard-settings&tab=modules';
									} else {
										msg.textContent = '<?php echo i18n_r('Dashboard/lang_Reloading'); ?> ' + secs + 's...';
									}
								}, 1000);
							}
						} else {
							self.disabled = false;
							self.textContent = isUpdate ? '↑ <?php echo i18n_r('Dashboard/lang_Update'); ?>' : '<?php echo i18n_r('Dashboard/lang_Install'); ?>';
							if (msg) { msg.className = 'mstore-msg error'; msg.textContent = res.message; }
						}
					} catch(e) {
						self.disabled = false;
						self.textContent = isUpdate ? '↑ <?php echo i18n_r('Dashboard/lang_Update'); ?>' : '<?php echo i18n_r('Dashboard/lang_Install'); ?>';
						if (msg) { msg.className = 'mstore-msg error'; msg.textContent = '<?php echo i18n_r('Dashboard/lang_Unexpected_error'); ?>.'; }
					}
				};
				xhr.onerror = function() {
					self.disabled = false;
					self.textContent = isUpdate ? '↑ <?php echo i18n_r('Dashboard/lang_Update'); ?>' : '<?php echo i18n_r('Dashboard/lang_Install'); ?>';
					if (msg) { msg.className = 'mstore-msg error'; msg.textContent = '<?php echo i18n_r('Dashboard/lang_Network_error'); ?>.'; }
				};
				xhr.send('dash_install_module=1&id=' + encodeURIComponent(id) + '&url=' + encodeURIComponent(url));
			});
		});
		</script>
		<?php
	}
}