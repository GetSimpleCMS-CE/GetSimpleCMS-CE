<?php

define('UPDATECE_DEBUG', false); // Set to true to enable debug logging to data/updatece_debug.log

# get correct id for plugin
$UpdateCE = basename(__FILE__, ".php");

# add in this plugin's language file
i18n_merge($UpdateCE) || i18n_merge($UpdateCE, 'en_US');

// Debug logger — no-op unless UPDATECE_DEBUG is set to true
function updatece_log($msg) {
	if (!UPDATECE_DEBUG) { return; }
	$logFile = rtrim(GSDATAPATH, '/\\') . '/updatece_debug.log';
	@file_put_contents($logFile, date('[Y-m-d H:i:s] ') . $msg . PHP_EOL, FILE_APPEND | LOCK_EX);
}

# register plugin
function updatece_get_nonce() {
	global $SESSIONHASH;
	$cookieVal = $_COOKIE[$SESSIONHASH] ?? '';
	$secret    = $SESSIONHASH . __FILE__;
	return hash_hmac('sha256', $cookieVal, $secret);
}

function updatece_verify_nonce($submitted) {
	if (empty($submitted)) { return false; }
	return hash_equals(updatece_get_nonce(), $submitted);
}

/**
 * Create a full-site backup zip before performing an update.
 */
function updatece_create_backup($base_dir) {
	$base_dir   = rtrim(str_replace('\\', '/', $base_dir), '/');
	$backup_dir = $base_dir . '/backups/zip';

	if (!is_dir($backup_dir) && !mkdir($backup_dir, 0755, true)) {
		throw new RuntimeException('Failed to create backup directory: ' . $backup_dir);
	}

	$backup_filename = date('YmdHis') . '.zip';
	$backup_path     = $backup_dir . '/' . $backup_filename;

	$zip = new ZipArchive();
	if ($zip->open($backup_path, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
		throw new RuntimeException('Failed to create backup archive');
	}

	// Paths relative to site root excluded from the backup
	$exclude = ['backups', 'data/cache', 'data/logs', 'data/tmp', 'install_TMP', 'Tmpfile.zip'];

	$files = new RecursiveIteratorIterator(
		new RecursiveDirectoryIterator($base_dir, RecursiveDirectoryIterator::SKIP_DOTS),
		RecursiveIteratorIterator::LEAVES_ONLY
	);

	foreach ($files as $file) {
		$full_path     = str_replace('\\', '/', $file->getPathname());
		$relative_path = substr($full_path, strlen($base_dir) + 1);
		if (empty($relative_path)) { continue; }

		$excluded = false;
		foreach ($exclude as $pattern) {
			if (strpos($relative_path, $pattern) === 0) { $excluded = true; break; }
		}
		if ($excluded) { continue; }

		$relative_dir = dirname($relative_path);
		if ($relative_dir !== '.' && $relative_dir !== '') {
			$current = '';
			foreach (explode('/', $relative_dir) as $part) {
				$current .= $part . '/';
				if ($zip->locateName($current) === false) { $zip->addEmptyDir($current); }
			}
		}

		$zip->addFile($full_path, $relative_path);
	}

	$zip->close();

	if (!file_exists($backup_path) || filesize($backup_path) < 1000) {
		throw new RuntimeException('Backup file appears to be corrupted or empty');
	}

	return $backup_filename;
}

/**
 * Handle an update submission end-to-end: verify, optionally back up,
 * download, and install a GetSimple-CE release zip.
 */
function updatece_process_download($post) {
	$steps = [];
	$t0    = microtime(true);

	if (!updatece_verify_nonce($post['updatece_nonce'] ?? '')) {
		updatece_log('Update aborted: nonce verification failed.');
		return ['ok' => false, 'steps' => $steps, 'error' => 'Security check failed. Please reload the page and try again.'];
	}

	$url = filter_var($post['url'] ?? '', FILTER_VALIDATE_URL);
	if ($url === false) {
		updatece_log('Update aborted: invalid URL.');
		return ['ok' => false, 'steps' => $steps, 'error' => 'Invalid URL.'];
	}
	$parsedUrl = parse_url($url);
	if (
		empty($parsedUrl['scheme']) || strtolower($parsedUrl['scheme']) !== 'https' ||
		empty($parsedUrl['host'])   || strtolower($parsedUrl['host'])   !== 'github.com' ||
		empty($parsedUrl['path'])   || strpos($parsedUrl['path'], '/GetSimpleCMS-CE/') !== 0
	) {
		updatece_log('Update aborted: URL not from an allowed source - ' . $url);
		return ['ok' => false, 'steps' => $steps, 'error' => 'URL is not from an allowed source.'];
	}

	// Backing up (full site zip) + downloading + extracting can take a while on larger installs.
	@set_time_limit(0);

	$rootPath = dirname(GSDATAPATH);
	updatece_log('Update started - source: ' . $url);

	if (!empty($post['create_backup'])) {
		$steps[] = i18n_r('UpdateCE/lang_Progress_Backup');
		$tBackup = microtime(true);
		try {
			$backupFile = updatece_create_backup($rootPath);
			$dt = round(microtime(true) - $tBackup, 2);
			$steps[] = '&#10003; ' . i18n_r('UpdateCE/lang_Backup_Success') . ' backups/zip/' . htmlspecialchars($backupFile, ENT_QUOTES, 'UTF-8') . " ({$dt}s)";
			updatece_log("Backup created: {$backupFile} ({$dt}s)");
		} catch (\Throwable $e) {
			updatece_log('Backup failed: ' . $e->getMessage());
			$steps[] = '&#10007; ' . i18n_r('UpdateCE/lang_Backup_Failed') . ' ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
			return ['ok' => false, 'steps' => $steps, 'error' => i18n_r('UpdateCE/lang_Backup_Aborted')];
		}
	}

	$steps[]   = i18n_r('UpdateCE/lang_Progress_Downloading');
	$tDownload = microtime(true);
	$tmpFile   = $rootPath . "/Tmpfile.zip";

	$context     = stream_context_create(['http' => ['timeout' => 15]]);
	$fileContent = @file_get_contents($url, false, $context);
	if ($fileContent === false) {
		updatece_log('Download failed: file_get_contents returned false for ' . $url);
		return ['ok' => false, 'steps' => $steps, 'error' => 'Failed to download file.'];
	}

	if (strlen($fileContent) < 4 || substr($fileContent, 0, 4) !== "PK\x03\x04") {
		updatece_log('Download failed: response is not a valid ZIP (size ' . strlen($fileContent) . ' bytes).');
		return ['ok' => false, 'steps' => $steps, 'error' => 'Downloaded file is not a valid ZIP archive.'];
	}

	if (file_put_contents($tmpFile, $fileContent) === false) {
		updatece_log('Download failed: could not write temp file ' . $tmpFile);
		return ['ok' => false, 'steps' => $steps, 'error' => 'Failed to save downloaded file.'];
	}
	$dt = round(microtime(true) - $tDownload, 2);
	updatece_log('Downloaded ' . strlen($fileContent) . " bytes in {$dt}s");
	$steps[] = '&#10003; ' . i18n_r('UpdateCE/lang_Progress_Downloading') . " ({$dt}s, " . round(strlen($fileContent) / 1024) . ' KB)';

	// Allowed file extensions
	$allowedExtensions = [
		'php','js','css','html','htm','xml','json','txt','md',
		'png','jpg','jpeg','gif','webp','svg','ico',
		'woff','woff2','ttf','eot','otf',
		'zip','gz','map'
	];

	$steps[]  = i18n_r('UpdateCE/lang_Progress_Extracting');
	$tExtract = microtime(true);

	$zip = new ZipArchive;
	if ($zip->open($tmpFile) !== TRUE) {
		updatece_log('Extraction failed: could not open ' . $tmpFile . ' as a zip archive.');
		return ['ok' => false, 'steps' => $steps, 'error' => 'Failed to open ZIP file.'];
	}

	$installTmp = $rootPath . "/install_TMP/";
	if (!file_exists($installTmp)) {
		mkdir($installTmp, 0755);
	}

	$realInstallTmp = realpath($installTmp) . DIRECTORY_SEPARATOR;
	for ($i = 0; $i < $zip->numFiles; $i++) {
		$entryName  = $zip->getNameIndex($i);
		$normalised = $realInstallTmp . ltrim(str_replace(['\\', '../'], ['/', ''], $entryName), '/');
		if (strpos($normalised, $realInstallTmp) !== 0) {
			$zip->close();
			updatece_log('Extraction blocked: unsafe path in archive - ' . $entryName);
			return ['ok' => false, 'steps' => $steps, 'error' => 'ZIP archive contains unsafe path: ' . htmlspecialchars($entryName, ENT_QUOTES, 'UTF-8')];
		}
	}

	$zip->extractTo($installTmp);
	$zip->close();

	$subFolder = null;
	foreach (scandir($installTmp) as $item) {
		if ($item !== '.' && $item !== '..' && is_dir($installTmp . $item)) {
			$subFolder = $installTmp . $item . '/';
			break;
		}
	}

	if (!$subFolder) {
		updatece_log('Extraction failed: no top-level sub-folder found in the archive.');
		return ['ok' => false, 'steps' => $steps, 'error' => 'No sub-folder found in the extracted files.'];
	}

	$dt = round(microtime(true) - $tExtract, 2);
	updatece_log("Extracted archive in {$dt}s");
	$steps[] = '&#10003; ' . i18n_r('UpdateCE/lang_Progress_Extracting') . " ({$dt}s)";

	$steps[]  = i18n_r('UpdateCE/lang_Progress_Installing');
	$tInstall = microtime(true);

	$filesCopied  = true;
	$copiedCount  = 0;
	$skippedCount = 0;

	$directoryIterator = new RecursiveDirectoryIterator($subFolder, RecursiveDirectoryIterator::SKIP_DOTS);
	$iterator          = new RecursiveIteratorIterator($directoryIterator, RecursiveIteratorIterator::SELF_FIRST);

	$realRoot = realpath($rootPath) . DIRECTORY_SEPARATOR;

	foreach ($iterator as $file) {
		$sourcePath      = $file->getPathname();
		$relativePath    = substr($sourcePath, strlen($subFolder));
		$destinationPath = $rootPath . '/' . $relativePath;

		$checkDir       = dirname($destinationPath);
		$pendingParts   = [];
		$resolvedParent = false;
		while ($checkDir !== dirname($checkDir)) {
			$resolved = realpath($checkDir);
			if ($resolved !== false) {
				$resolvedParent = empty($pendingParts)
					? $resolved
					: $resolved . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, array_reverse($pendingParts));
				break;
			}
			$pendingParts[] = basename($checkDir);
			$checkDir       = dirname($checkDir);
		}
		if ($resolvedParent === false || strpos($resolvedParent . DIRECTORY_SEPARATOR, $realRoot) !== 0) {
			updatece_log('Blocked unsafe destination path: ' . $relativePath);
			$filesCopied = false;
			$skippedCount++;
			continue;
		}

		if ($file->isDir()) {
			if (!file_exists($destinationPath) && !mkdir($destinationPath, 0755, true)) {
				updatece_log('Failed to create directory: ' . $destinationPath);
				$filesCopied = false;
			}
		} else {
			$basename = basename($destinationPath);
			$ext      = strtolower(pathinfo($destinationPath, PATHINFO_EXTENSION));
			if ($basename !== '.htaccess' && !in_array($ext, $allowedExtensions, true)) {
				updatece_log('Skipped disallowed file type: ' . $relativePath);
				$skippedCount++;
				continue;
			}

			if (!copy($sourcePath, $destinationPath)) {
				$lastError = error_get_last();
				updatece_log('Failed to copy ' . $sourcePath . ' to ' . $destinationPath . ': ' . ($lastError['message'] ?? 'unknown error'));
				$filesCopied = false;
			} else {
				unlink($sourcePath);
				$copiedCount++;
			}
		}
	}

	$dt = round(microtime(true) - $tInstall, 2);
	updatece_log("Installed {$copiedCount} files in {$dt}s" . ($skippedCount ? " ({$skippedCount} skipped/blocked)" : ''));
	$steps[] = '&#10003; ' . i18n_r('UpdateCE/lang_Progress_Installing') . " ({$dt}s, {$copiedCount} files)";

	$steps[] = i18n_r('UpdateCE/lang_Progress_Finishing');

	if (updatece_delete_directory($installTmp)) {
		$steps[] = 'Temporary directory removed successfully.';
	} else {
		updatece_log('Failed to remove temp directory: ' . $installTmp);
		$steps[] = 'Failed to remove temporary directory.';
	}

	if (@unlink($tmpFile)) {
		$steps[] = 'Temporary file removed successfully.';
	} else {
		updatece_log('Failed to remove temp file: ' . $tmpFile);
		$steps[] = 'Failed to remove temporary file.';
	}

	$totalTime = round(microtime(true) - $t0, 2);
	updatece_log("Update finished in {$totalTime}s - result: " . ($filesCopied ? 'success' : 'partial failure'));

	if ($filesCopied) {
		return ['ok' => true, 'steps' => $steps, 'error' => null];
	}
	return ['ok' => false, 'steps' => $steps, 'error' => 'Some files could not be moved. Check the debug log for details.'];
}

/**
 * Recursively delete a directory. Used to clean up the install_TMP folder
 * after an update.
 */
function updatece_delete_directory($dirname) {
	if (!is_dir($dirname)) { return false; }
	$dir_handle = opendir($dirname);
	if (!$dir_handle) { return false; }
	while ($file = readdir($dir_handle)) {
		if ($file != "." && $file != "..") {
			$path = $dirname . "/" . $file;
			if (is_dir($path)) {
				updatece_delete_directory($path);
			} elseif (!unlink($path)) {
				$lastError = error_get_last();
				updatece_log('Failed to delete file ' . $path . ': ' . ($lastError['message'] ?? 'unknown error'));
			}
		}
	}
	closedir($dir_handle);
	if (!rmdir($dirname)) {
		updatece_log('Failed to delete directory ' . $dirname);
		return false;
	}
	return true;
}


register_plugin(
	$UpdateCE,								# ID of plugin, should be filename minus php
	i18n_r($UpdateCE.'/lang_Menu_Title'),	# Title of plugin
	'1.6',									# Plugin version
	'CE Team',								# Plugin author
	'https://getsimple-ce.ovh/donate',		# Author URL
	i18n_r($UpdateCE.'/lang_Description'),	# Plugin Description
	'support',								# Page type of plugin
	'update_ce'								# Function that displays content
);

# add a link in the admin tab 'Support'
add_action('support-sidebar','createSideMenu', array($UpdateCE, i18n_r($UpdateCE.'/lang_Menu_Title'). i18n_r($UpdateCE.'/lang_Icon')));

function update_ce() {
	global $SITEURL;
	global $GSADMIN;
	global $USR;
	global $plugin_info;
	
	$updateResult = null;
	if (isset($_POST['download'])) {
		updatece_log('--- Update submission received ---');
		$updateResult = updatece_process_download($_POST);
	}
	
	echo '
	<link rel="stylesheet" href="'.$SITEURL.'plugins/UpdateCE/assets/w3.css">
	<link rel="stylesheet" href="'.$SITEURL.'plugins/UpdateCE/assets/w3-custom.css">
	<style>
	.updatece-progress-container{display:none;margin:14px 0;padding:14px 16px;background:#f4f6f9;border-radius:8px;border:1px solid #d9dee5;}
	.updatece-progress-container.active{display:block;}
	.updatece-progress-bar{width:100%;height:20px;background:#e2e6ea;border-radius:10px;overflow:hidden;}
	.updatece-progress-fill{height:100%;width:0%;background:linear-gradient(90deg,#CF3805,#f05a28);border-radius:10px;transition:width .4s ease;}
	.updatece-progress-text{display:flex;justify-content:space-between;font-size:.85em;margin-top:6px;}
	.updatece-progress-status{margin-top:8px;padding:8px 10px;border-radius:4px;background:#fff;border-left:3px solid #CF3805;font-size:.9em;min-height:20px;text-align:left;color:#000;}
	.updatece-backup-option{margin:12px auto;padding:12px 15px;background:#f4f6f9;border-radius:8px;border:1px solid #d9dee5;max-width:420px;}
	.updatece-backup-option label{cursor:pointer;font-weight:600;align-items:center;margin:0;}
	.updatece-backup-option input[type=checkbox]{width:16px;height:16px;margin-right:6px;}
	.updatece-backup-option .updatece-backup-info{font-size:.82em;opacity:.75;margin:6px 0 0 24px;}
	.updatece-btn-busy{opacity:.6;pointer-events:none;cursor:default;}
	</style>
	<script>
	function updatece_startProgress(form){
		// Guard against double-submits without disabling the button: a disabled
		// submit button has its name/value pair (name="download") stripped from
		// the submitted form data, which breaks the server-side
		// isset($_POST[\'download\']) check and silently skips the whole
		// backup/update routine. Style it as busy instead of disabling it.
		if (form.dataset.submitting === "1") { return false; }
		form.dataset.submitting = "1";

		var container = form.querySelector(".updatece-progress-container");
		var fill      = form.querySelector(".updatece-progress-fill");
		var percent   = form.querySelector(".updatece-progress-percent");
		var status    = form.querySelector(".updatece-progress-status");
		var btn       = form.querySelector("button[type=submit]");
		if (!container) { return true; }

		container.className = "updatece-progress-container active";
		if (btn) { btn.classList.add("updatece-btn-busy"); }

		var steps = [
			{ p: 10, m: '.json_encode(i18n_r('UpdateCE/lang_Progress_Downloading')).' },
			{ p: 40, m: '.json_encode(i18n_r('UpdateCE/lang_Progress_Extracting')).' },
			{ p: 70, m: '.json_encode(i18n_r('UpdateCE/lang_Progress_Installing')).' },
			{ p: 90, m: '.json_encode(i18n_r('UpdateCE/lang_Progress_Finishing')).' }
		];
		var cb = form.querySelector("input[name=create_backup]");
		if (cb && cb.checked) {
			steps.unshift({ p: 5, m: '.json_encode(i18n_r('UpdateCE/lang_Progress_Backup')).' });
		}

		var i = 0;
		function tick(){
			if (i >= steps.length) { return; }
			if (fill)    { fill.style.width = steps[i].p + "%"; }
			if (percent) { percent.textContent = steps[i].p + "%"; }
			if (status)  { status.innerHTML = steps[i].m; }
			i++;
			if (i < steps.length) { setTimeout(tick, 900 + Math.random() * 500); }
		}
		setTimeout(tick, 200);
		return true;
	}
	</script>
	
	<div class="w3-parent w3-container"><!-- Start Plugin -->
	
		<h3>'.i18n_r("UpdateCE/lang_Icon").i18n_r("UpdateCE/lang_Page_Title").' <!--small>(v'. $plugin_info['UpdateCE']['version'].')';
		
		// Check for update...
		$db = file_get_contents('https://getsimplecms-ce.github.io/upgrade.json');
		$jsondb = json_decode($db);
		
		foreach ($jsondb as $key => $value) {
			if ((float) $value->plugver > (float) $plugin_info['UpdateCE']['version']) {
				echo '<sup class="w3-text-light w3-orange w3-round" style="padding:3px 1px;"><a style="font-weight:400; text-decoration:none; color:#fff!important;" href="load.php?id=massiveAdmin&downloader"> * Update available (v' . $value->plugver . ') <svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle" width="1em" height="1em" viewBox="0 0 24 24"><rect width="24" height="24" fill="none"/><path fill="none" stroke="#CF3805" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.213 9.787a3.39 3.39 0 0 0-4.795 0l-3.425 3.426a3.39 3.39 0 0 0 4.795 4.794l.321-.304m-.321-4.49a3.39 3.39 0 0 0 4.795 0l3.424-3.426a3.39 3.39 0 0 0-4.794-4.795l-1.028.961"/></svg></a>';
			};
		};
		
		echo '</small--></h3>
		<p>'.i18n_r("UpdateCE/lang_Description").'</p>';
		
		include(GSADMININCPATH ."configuration.php");
		
		echo  '<p class="w3-margin w3-round-medium w3-padding w3-light-green">'.i18n_r('UpdateCE/lang_Installed_Version') .': <span style="font-weight:600">'.$site_full_name. ' &ndash; '. $site_version_no.'</span>.</p>';
		
		if (isset($_GET['ok'])) {
			if ($updateResult === null) {
				echo '
				<div class="w3-panel w3-pale-yellow w3-round w3-padding-large w3-border w3-border-orange">
					<p>'.i18n_r("UpdateCE/lang_Icon").' No update was processed on this page load.</p>
				</div>
				';
			} elseif ($updateResult['ok']) {
				$stepsHtml = implode('<br style="margin-bottom:5px;">', $updateResult['steps']);
				echo '
				<div class="w3-panel w3-green w3-round w3-padding-large">
				<meta http-equiv="refresh" content="14; url=health-check.php">
				<p>'.i18n_r("UpdateCE/lang_Icon").' '.i18n_r('UpdateCE/lang_Progress_Complete').'</p>
				<div class="updatece-progress-bar">
					<div id="updatece-redirect-fill" class="updatece-progress-fill" style="width:100%;background:linear-gradient(90deg,#2e7d32,#43a047);"></div>
				</div>
				<div class="updatece-progress-text">
					<span>'.i18n_r('UpdateCE/lang_Installing').'</span>
					<span id="countdown" style="font-weight:600;">11'.'s</span>
				</div>
				<div class="updatece-progress-status" style="text-align:left;">'.$stepsHtml.'</div>
				</div>

				<script>
					var timeleft = 11;
					var totaltime = 11;
					var redirectFill = document.getElementById("updatece-redirect-fill");
					var downloadTimer = setInterval(function(){
					  if(timeleft <= 0){
						clearInterval(downloadTimer);
						document.getElementById("countdown").innerHTML = "'.i18n_r('UpdateCE/lang_Finished').'";
						if (redirectFill) { redirectFill.style.width = "0%"; }
					  } else {
						document.getElementById("countdown").innerHTML = timeleft + " '.i18n_r('UpdateCE/lang_Seconds_remaining').'";
						if (redirectFill) { redirectFill.style.width = Math.round((timeleft / totaltime) * 100) + "%"; }
					  }
					  timeleft -= 1;
					}, 1000);
				</script>
				';
			} else {
				$stepsHtml = implode('<br style="margin-bottom:5px;">', $updateResult['steps']);
				echo '
				<div class="w3-panel w3-pale-red w3-round w3-padding-large w3-border w3-border-red">
					<p>'.i18n_r("UpdateCE/lang_Icon").' <strong>'.i18n_r('UpdateCE/lang_Update_Failed').'</strong> '.htmlspecialchars($updateResult['error'], ENT_QUOTES, 'UTF-8').'</p>
					<div class="updatece-progress-bar">
						<div class="updatece-progress-fill" style="width:100%;background:linear-gradient(90deg,#b91c1c,#ef4444);"></div>
					</div>
					<div class="updatece-progress-status" style="text-align:left;">'.$stepsHtml.'</div>
					<p style="margin-top:10px;"><a href="'.$SITEURL.'admin/load.php?id=UpdateCE">'.i18n_r('UpdateCE/lang_Reload_Page').'</a></p>
				</div>
				';
			}
		};
		
		echo '
		<hr>
		
		<div class="w3-container ">';

		foreach ($jsondb as $key => $value) {
			if (version_compare($value->version, $site_version_no, '>')) {
				echo '
				<div class="w3-card-4 w3-margin-bottom">
					<div class="w3-row">
						<header class="w3-container w3-deep-orange">
							<div class="w3-col s6 w3-center">
								<h3 class="w3-text-white"><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="currentColor" d="m18 22l3-3l-.7-.7l-1.8 1.8V16h-1v4.1l-1.8-1.8l-.7.7zm-6-11.15L6.075 7.425L5 8.05V9.1l7 4.05l7-4.05V8.05l-1.075-.625zm-1 10.875L4 17.7q-.475-.275-.737-.725t-.263-1v-7.95q0-.55.263-1T4 6.3l7-4.025Q11.475 2 12 2t1 .275L20 6.3q.475.275.738.725t.262 1v4.65q-.675-.325-1.437-.5T18 12q-2.9 0-4.95 2.05T11 19q0 .8.163 1.538t.487 1.412q-.175-.05-.337-.087T11 21.725M18 24q-2.075 0-3.537-1.463T13 19t1.463-3.537T18 14t3.538 1.463T23 19t-1.463 3.538T18 24"/></svg> ' . $value->name . '</h3>
								<p class="info">' . $value->info . '</p>
							</div>
							<div class="w3-col s6">
								<div class="w3-margin w3-right">
									<button class="w3-button w3-margin-top w3-round w3-padding-small w3-light-gray" style="cursor:default!important;"><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="currentColor" d="M8 14q-.425 0-.712-.288T7 13t.288-.712T8 12t.713.288T9 13t-.288.713T8 14m4 0q-.425 0-.712-.288T11 13t.288-.712T12 12t.713.288T13 13t-.288.713T12 14m4 0q-.425 0-.712-.288T15 13t.288-.712T16 12t.713.288T17 13t-.288.713T16 14M5 22q-.825 0-1.412-.587T3 20V6q0-.825.588-1.412T5 4h1V3q0-.425.288-.712T7 2t.713.288T8 3v1h8V3q0-.425.288-.712T17 2t.713.288T18 3v1h1q.825 0 1.413.588T21 6v14q0 .825-.587 1.413T19 22zm0-2h14V10H5zM5 8h14V6H5zm0 0V6z"/></svg> ' . $value->lastupdate . '</button>
									
									<button class="w3-button w3-border w3-round-xxlarge w3-margin-top w3-red w3-text-white" style="margin-left:10px;font-weight:600;cursor:default!important;"><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="currentColor" d="M19 21q-.975 0-1.75-.562T16.175 19H11q-1.65 0-2.825-1.175T7 15t1.175-2.825T11 11h2q.825 0 1.413-.587T15 9t-.587-1.412T13 7H7.825q-.325.875-1.088 1.438T5 9q-1.25 0-2.125-.875T2 6t.875-2.125T5 3q.975 0 1.738.563T7.825 5H13q1.65 0 2.825 1.175T17 9t-1.175 2.825T13 13h-2q-.825 0-1.412.588T9 15t.588 1.413T11 17h5.175q.325-.875 1.088-1.437T19 15q1.25 0 2.125.875T22 18t-.875 2.125T19 21M5 7q.425 0 .713-.288T6 6t-.288-.712T5 5t-.712.288T4 6t.288.713T5 7"/></svg> ' . $value->version . '</button>
								</div>
							</div>
						</header>
					</div>
					
					<div class="w3-container">
						<h4 class="w3-margin-top">'.i18n_r('UpdateCE/lang_Key_Changes').':</h4>
						<div style="margin:32px 32px 0 32px !important">
							<p><svg xmlns="http://www.w3.org/2000/svg" class="w3-text-green" style="vertical-align:middle" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="m8.6 22.5l-1.9-3.2l-3.6-.8l.35-3.7L1 12l2.45-2.8l-.35-3.7l3.6-.8l1.9-3.2L12 2.95l3.4-1.45l1.9 3.2l3.6.8l-.35 3.7L23 12l-2.45 2.8l.35 3.7l-3.6.8l-1.9 3.2l-3.4-1.45zm2.35-6.95L16.6 9.9l-1.4-1.45l-4.25 4.25l-2.15-2.1L7.4 12z"/></svg> <b>'.i18n_r('UpdateCE/lang_New').':</b> ' . $value->new . '</p>
							
							<p class="updates"><svg xmlns="http://www.w3.org/2000/svg" class="w3-text-indigo" style="vertical-align:middle" width="1.5em" height="1.5em" viewBox="0 0 36 36"><path fill="currentColor" d="M19.5 28.1h-2.9c-.5 0-.9-.3-1-.8l-.5-1.8l-.4-.2l-1.6.9c-.4.2-.9.2-1.2-.2l-2.1-2.1c-.3-.3-.4-.8-.2-1.2l.9-1.6l-.2-.4l-1.8-.5c-.4-.1-.8-.5-.8-1v-2.9c0-.5.3-.9.8-1l1.8-.5l.2-.4l-.9-1.6c-.2-.4-.2-.9.2-1.2l2.1-2.1c.3-.3.8-.4 1.2-.2l1.6.9l.4-.2l.5-1.8c.1-.4.5-.8 1-.8h2.9c.5 0 .9.3 1 .8L21 10l.4.2l1.6-.9c.4-.2.9-.2 1.2.2l2.1 2.1c.3.3.4.8.2 1.2l-.9 1.6l.2.4l1.8.5c.4.1.8.5.8 1v2.9c0 .5-.3.9-.8 1l-1.8.5l-.2.4l.9 1.6c.2.4.2.9-.2 1.2L24.2 26c-.3.3-.8.4-1.2.2l-1.6-.9l-.4.2l-.5 1.8c-.2.5-.6.8-1 .8m-2.2-2h1.4l.5-2.1l.5-.2c.4-.1.7-.3 1.1-.4l.5-.3l1.9 1.1l1-1l-1.1-1.9l.3-.5c.2-.3.3-.7.4-1.1l.2-.5l2.1-.5v-1.4l-2.1-.5l-.2-.5c-.1-.4-.3-.7-.4-1.1l-.3-.5l1.1-1.9l-1-1l-1.9 1.1l-.5-.3c-.3-.2-.7-.3-1.1-.4l-.5-.2l-.5-2.1h-1.4l-.5 2.1l-.5.2c-.4.1-.7.3-1.1.4l-.5.3l-1.9-1.1l-1 1l1.1 1.9l-.3.5c-.2.3-.3.7-.4 1.1l-.2.5l-2.1.5v1.4l2.1.5l.2.5c.1.4.3.7.4 1.1l.3.5l-1.1 1.9l1 1l1.9-1.1l.5.3c.3.2.7.3 1.1.4l.5.2zm9.8-6.6"/><path fill="currentColor" d="M18 22.3c-2.4 0-4.3-1.9-4.3-4.3s1.9-4.3 4.3-4.3s4.3 1.9 4.3 4.3s-1.9 4.3-4.3 4.3m0-6.6c-1.3 0-2.3 1-2.3 2.3s1 2.3 2.3 2.3s2.3-1 2.3-2.3s-1-2.3-2.3-2.3"/><path fill="currentColor" d="M18 2c-.6 0-1 .4-1 1s.4 1 1 1c7.7 0 14 6.3 14 14s-6.3 14-14 14S4 25.7 4 18c0-2.8.8-5.5 2.4-7.8v1.2c0 .6.4 1 1 1s1-.4 1-1v-5h-5c-.6 0-1 .4-1 1s.4 1 1 1h1.8C3.1 11.1 2 14.5 2 18c0 8.8 7.2 16 16 16s16-7.2 16-16S26.8 2 18 2"/><path fill="none" d="M0 0h36v36H0z"/></svg> <b>'.i18n_r('UpdateCE/lang_Updated').':</b> ' . $value->updates. '</p>
							
							<p><svg xmlns="http://www.w3.org/2000/svg" class="w3-text-deep-orange" style="vertical-align:middle" width="1.5em" height="1.5em" viewBox="0 0 256 256"><path fill="currentColor" d="M240 116h-20.78A92.21 92.21 0 0 0 140 36.78V16a12 12 0 0 0-24 0v20.78A92.21 92.21 0 0 0 36.78 116H16a12 12 0 0 0 0 24h20.78A92.21 92.21 0 0 0 116 219.22V240a12 12 0 0 0 24 0v-20.78A92.21 92.21 0 0 0 219.22 140H240a12 12 0 0 0 0-24m-112 80a68 68 0 1 1 68-68a68.07 68.07 0 0 1-68 68m0-112a44 44 0 1 0 44 44a44.05 44.05 0 0 0-44-44m0 64a20 20 0 1 1 20-20a20 20 0 0 1-20 20"/></svg> <b>'.i18n_r('UpdateCE/lang_Fixes').':</b> ' . $value->fixed. '</p>
							
							<p><svg xmlns="http://www.w3.org/2000/svg" class="w3-text-red" style="vertical-align:middle" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M14.48 18.71a3.996 3.996 0 0 1-5.163-5.272l2.619 2.619l2.12-2.121l-2.618-2.619a3.988 3.988 0 0 1 5.2 5.308l1.933 1.933A7.96 7.96 0 0 0 20 14A17.11 17.11 0 0 0 13.5.67a21.5 21.5 0 0 1 .74 4.8a3.47 3.47 0 0 1-3.41 3.73A3.64 3.64 0 0 1 7.2 5.47l.03-.36A13.77 13.77 0 0 0 4 14a8 8 0 0 0 12.43 6.66Z"/></svg> <b>'.i18n_r('UpdateCE/lang_Security').':</b> ' . $value->security. '</p>
							<hr>
							
							<div class="w3-row w3-margin">
								<div class="w3-col s6 w3-center">
								<p><a href="' . $value->repo . '" target="_blank" style="text-decoration:none"><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2A10 10 0 0 0 2 12c0 4.42 2.87 8.17 6.84 9.5c.5.08.66-.23.66-.5v-1.69c-2.77.6-3.36-1.34-3.36-1.34c-.46-1.16-1.11-1.47-1.11-1.47c-.91-.62.07-.6.07-.6c1 .07 1.53 1.03 1.53 1.03c.87 1.52 2.34 1.07 2.91.83c.09-.65.35-1.09.63-1.34c-2.22-.25-4.55-1.11-4.55-4.92c0-1.11.38-2 1.03-2.71c-.1-.25-.45-1.29.1-2.64c0 0 .84-.27 2.75 1.02c.79-.22 1.65-.33 2.5-.33s1.71.11 2.5.33c1.91-1.29 2.75-1.02 2.75-1.02c.55 1.35.2 2.39.1 2.64c.65.71 1.03 1.6 1.03 2.71c0 3.82-2.34 4.66-4.57 4.91c.36.31.69.92.69 1.85V21c0 .27.16.59.67.5C19.14 20.16 22 16.42 22 12A10 10 0 0 0 12 2"/></svg> '.i18n_r('UpdateCE/lang_More_Info').'</a></p>
								</div>
								
								<div class="w3-col s6 w3-center">
								<p><a href="' . $value->url . '" style="text-decoration:none" download><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle" width="1.2em" height="1.2em" viewBox="0 0 24 24"><g fill="none"><path d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/><path fill="currentColor" d="M20 14.5a1.5 1.5 0 0 1 1.5 1.5v4a2.5 2.5 0 0 1-2.5 2.5H5A2.5 2.5 0 0 1 2.5 20v-4a1.5 1.5 0 0 1 3 0v3.5h13V16a1.5 1.5 0 0 1 1.5-1.5m-8-13A1.5 1.5 0 0 1 13.5 3v9.036l1.682-1.682a1.5 1.5 0 0 1 2.121 2.12l-4.066 4.067a1.75 1.75 0 0 1-2.474 0l-4.066-4.066a1.5 1.5 0 0 1 2.121-2.121l1.682 1.682V3A1.5 1.5 0 0 1 12 1.5"/></g></svg> '.i18n_r('UpdateCE/lang_Download').'</a></p>
								</div>
							</div>
							
						</div>
					</div>

					<footer class="w3-container w3-light-gray">
						<form action="'.$SITEURL.'admin/load.php?id=UpdateCE&&ok=ok" method="POST" onsubmit="return updatece_startProgress(this);">
							<div class="w3-margin w3-center">
								<input type="hidden" name="url" value="' . htmlspecialchars($value->url, ENT_QUOTES, 'UTF-8') . '">
								<input type="hidden" name="updatece_nonce" value="' . updatece_get_nonce() . '">

								<div class="updatece-backup-option">
									<label>
										<input type="checkbox" name="create_backup" value="1" checked>
										<span>'.i18n_r('UpdateCE/lang_Backup_Option').'</span>
									</label>
									<div class="updatece-backup-info">'.i18n_r('UpdateCE/lang_Backup_Info').'</div>
								</div>

								<div class="updatece-progress-container">
									<div class="updatece-progress-bar">
										<div class="updatece-progress-fill" style="width:0%;"></div>
									</div>
									<div class="updatece-progress-text">
										<span>'.i18n_r('UpdateCE/lang_Installing').'</span>
										<span class="updatece-progress-percent">0%</span>
									</div>
									<div class="updatece-progress-status"></div>
								</div>

								<button class="w3-btn w3-large w3-round w3-green" type="submit" name="download"><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle" width="1.2em" height="1.2em" viewBox="0 0 36 36"><path fill="currentColor" d="M19.5 28.1h-2.9c-.5 0-.9-.3-1-.8l-.5-1.8l-.4-.2l-1.6.9c-.4.2-.9.2-1.2-.2l-2.1-2.1c-.3-.3-.4-.8-.2-1.2l.9-1.6l-.2-.4l-1.8-.5c-.4-.1-.8-.5-.8-1v-2.9c0-.5.3-.9.8-1l1.8-.5l.2-.4l-.9-1.6c-.2-.4-.2-.9.2-1.2l2.1-2.1c.3-.3.8-.4 1.2-.2l1.6.9l.4-.2l.5-1.8c.1-.4.5-.8 1-.8h2.9c.5 0 .9.3 1 .8L21 10l.4.2l1.6-.9c.4-.2.9-.2 1.2.2l2.1 2.1c.3.3.4.8.2 1.2l-.9 1.6l.2.4l1.8.5c.4.1.8.5.8 1v2.9c0 .5-.3.9-.8 1l-1.8.5l-.2.4l.9 1.6c.2.4.2.9-.2 1.2L24.2 26c-.3.3-.8.4-1.2.2l-1.6-.9l-.4.2l-.5 1.8c-.2.5-.6.8-1 .8m-2.2-2h1.4l.5-2.1l.5-.2c.4-.1.7-.3 1.1-.4l.5-.3l1.9 1.1l1-1l-1.1-1.9l.3-.5c.2-.3.3-.7.4-1.1l.2-.5l2.1-.5v-1.4l-2.1-.5l-.2-.5c-.1-.4-.3-.7-.4-1.1l-.3-.5l1.1-1.9l-1-1l-1.9 1.1l-.5-.3c-.3-.2-.7-.3-1.1-.4l-.5-.2l-.5-2.1h-1.4l-.5 2.1l-.5.2c-.4.1-.7.3-1.1.4l-.5.3l-1.9-1.1l-1 1l1.1 1.9l-.3.5c-.2.3-.3.7-.4 1.1l-.2.5l-2.1.5v1.4l2.1.5l.2.5c.1.4.3.7.4 1.1l.3.5l-1.1 1.9l1 1l1.9-1.1l.5.3c.3.2.7.3 1.1.4l.5.2zm9.8-6.6"/><path fill="currentColor" d="M18 22.3c-2.4 0-4.3-1.9-4.3-4.3s1.9-4.3 4.3-4.3s4.3 1.9 4.3 4.3s-1.9 4.3-4.3 4.3m0-6.6c-1.3 0-2.3 1-2.3 2.3s1 2.3 2.3 2.3s2.3-1 2.3-2.3s-1-2.3-2.3-2.3"/><path fill="currentColor" d="M18 2c-.6 0-1 .4-1 1s.4 1 1 1c7.7 0 14 6.3 14 14s-6.3 14-14 14S4 25.7 4 18c0-2.8.8-5.5 2.4-7.8v1.2c0 .6.4 1 1 1s1-.4 1-1v-5h-5c-.6 0-1 .4-1 1s.4 1 1 1h1.8C3.1 11.1 2 14.5 2 18c0 8.8 7.2 16 16 16s16-7.2 16-16S26.8 2 18 2"/><path fill="none" d="M0 0h36v36H0z"/></svg> '.i18n_r('UpdateCE/lang_Update_Now').'</button>
							</div>
						</form>
					</footer>
				</div>';
			}
		};
		
		// No updates available...
		if (count($jsondb) > 0) {
			$hasUpdates = false;
			foreach ($jsondb as $value) {
				if (version_compare($value->version, $site_version_no, '>')) {
					$hasUpdates = true;
					break;
				}
			}
			if (!$hasUpdates) {
				echo '<div class="w3-card-4 w3-panel w3-round-large w3-padding-32 w3-green"><p>'.i18n_r('UpdateCE/lang_No_Updates').' <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 512 512"><rect width="512" height="512" fill="none"/><path fill="#CF3805" d="M313.4 32.9c26 5.2 42.9 30.5 37.7 56.5l-2.3 11.4c-5.3 26.7-15.1 52.1-28.8 75.2h144c26.5 0 48 21.5 48 48c0 18.5-10.5 34.6-25.9 42.6C497 275.4 504 288.9 504 304c0 23.4-16.8 42.9-38.9 47.1c4.4 7.3 6.9 15.8 6.9 24.9c0 21.3-13.9 39.4-33.1 45.6c.7 3.3 1.1 6.8 1.1 10.4c0 26.5-21.5 48-48 48h-97.5c-19 0-37.5-5.6-53.3-16.1l-38.5-25.7C176 420.4 160 390.4 160 358.3V247.1c0-29.2 13.3-56.7 36-75l7.4-5.9c26.5-21.2 44.6-51 51.2-84.2l2.3-11.4c5.2-26 30.5-42.9 56.5-37.7M32 192h64c17.7 0 32 14.3 32 32v224c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32V224c0-17.7 14.3-32 32-32" stroke-width="20" stroke="#CF3805"/></svg></p></div>';
			}
		};
		
		echo '
		</div>
		
		<hr>
		
		<div class="w3-container w3-padding">
			<h4 class=" w3-text-red w3-padding w3-pale-yellow" style="font-weight:600"><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle" width="1.2em" height="1.2em" viewBox="0 0 16 16"><path fill="currentColor" fill-rule="evenodd" d="M8.429 2.746a.5.5 0 0 0-.858 0L1.58 12.743a.5.5 0 0 0 .429.757h11.984a.5.5 0 0 0 .43-.757zm-2.144-.77C7.06.68 8.939.68 9.715 1.975l5.993 9.996c.799 1.333-.161 3.028-1.716 3.028H2.008C.453 15-.507 13.305.292 11.972l5.993-9.997ZM9 11.5a1 1 0 1 1-2 0a1 1 0 0 1 2 0m-.25-5.75a.75.75 0 0 0-1.5 0v3a.75.75 0 0 0 1.5 0z" clip-rule="evenodd"/></svg> '.i18n_r('UpdateCE/lang_Note').': </h4>
		
			<ul class="w3-ul w3-hoverable w3-margin-bottom">
				<li><p>'.i18n_r('UpdateCE/lang_Requirement').'</p></li>
				<li><p>'.i18n_r('UpdateCE/lang_Create_Backup').'</p></li>
				<li><p>'.i18n_r('UpdateCE/lang_Rename_Admin').'</p></li>
			</ul>
		
		</div>
		
		<hr>
		
<!-- ### Start Instructions ### -->

';

$allowedBase = 'https://getsimplecms-ce.github.io/';
$cacheDir = GSDATAPATH . 'cache/';
$cacheTime = 21600; // 6 hours

// Force refresh (?refresh=1)
$forceRefresh = isset($_GET['refresh']);

// Prevent duplicate loads
static $alreadyLoaded = [];

// Ensure cache directory exists
if (!file_exists($cacheDir)) {
	mkdir($cacheDir, 0755, true);
}

// Default fallback (local)
$defaultFallback = GSROOTPATH . 'plugins/UpdateCE/upgrade-info/index.html';

// Get info_url safely
$info_url = !empty($value->info_url) ? $value->info_url : '';

// Build cache file only if URL exists
$cacheFile = !empty($info_url)
	? $cacheDir . 'update_info_' . md5($info_url) . '.html'
	: null;

$content = false;

// =========================
// 1. Edge-case: already loaded
// =========================
if (!empty($info_url) && isset($alreadyLoaded[$info_url])) {
	$content = $alreadyLoaded[$info_url];
}

// =========================
// 2. Try cache
// =========================
if (
	$content === false &&
	!$forceRefresh &&
	$cacheFile &&
	file_exists($cacheFile) &&
	(time() - filemtime($cacheFile) < $cacheTime)
) {
	$content = file_get_contents($cacheFile);
}

// =========================
// 3. Try remote
// =========================
if (
	$content === false &&
	!empty($info_url) &&
	strpos($info_url, $allowedBase) === 0
) {
	$context = stream_context_create([
		'http' => [
			'timeout' => 2
		]
	]);

	$remote = @file_get_contents($info_url, false, $context);

	if ($remote !== false && !empty($remote)) {
		$content = $remote;

		// Save cache if possible
		if ($cacheFile) {
			file_put_contents($cacheFile, $remote);
		}
	}
}

// =========================
// 4. Default fallback
// =========================
if ($content === false && file_exists($defaultFallback)) {
	$content = file_get_contents($defaultFallback);
}

// =========================
// 5. Cache cleanup (lazy)
// =========================
if (is_dir($cacheDir)) {
	foreach (glob($cacheDir . 'update_info_*.html') as $file) {
		if (time() - filemtime($file) > 86400) { // 24 hours
			@unlink($file);
		}
	}
}

// =========================
// 6. Output
// =========================
if ($content !== false) {

	// Store for reuse (edge-case fix)
	if (!empty($info_url)) {
		$alreadyLoaded[$info_url] = $content;
	}

	echo $content;

} else {
	echo '<p>Visit the GetSimple <a href="https://getsimple-ce.ovh/install" target="_blank">Install</a> page for more information.</p>';
}

echo '

<!-- ### End Instructions ### -->

	</div><!-- End Plugin -->
	';
};
?>