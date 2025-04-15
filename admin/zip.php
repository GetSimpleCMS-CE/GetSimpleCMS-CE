<?php

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Setup inclusions
$load['plugin'] = true;

// Include common.php
include('inc/common.php');
login_cookie_check();

// Increase limits for large backups
ini_set('memory_limit', '512M');
set_time_limit(0);

if (!extension_loaded('zip')) {
	exit('PHP zip extension is not installed.');
}

// Ensure backup directory exists
$backupDir = GSBACKUPSPATH . 'zip/';
if (!is_dir($backupDir) && !mkdir($backupDir, 0755, true)) {
	exit('Failed to create backup directory: ' . $backupDir);
}

// Verify backup directory is writable
if (!is_writable($backupDir)) {
	exit('Backup directory is not writable: ' . $backupDir);
}

$filename = $backupDir . date('YmdHis') . '.zip';
$zip = new ZipArchive();
$zipStatus = $zip->open($filename, ZipArchive::CREATE);
if ($zipStatus !== TRUE) {
	exit("Cannot open <$filename>. Error code: " . $zipStatus);
}

$dir = GSROOTPATH; // Adjust the directory you want to backup

// List of files and folders to exclude
$exclude = [
	'admin',
	'backups',
	'index.php',
	'robots.txt',
	'sitemap.xml',
];

// Prepend root path to each exclusion
$exclude = array_map(function($path) use ($dir) {
	return realpath($dir . '/' . $path);
}, $exclude);

// Function to check if a file or folder should be excluded
function shouldExclude($filePath, $exclude) {
	foreach ($exclude as $excludedPath) {
		if (strpos(realpath($filePath), $excludedPath) === 0) {
			return true;
		}
	}
	return false;
}

addFolderToZip($dir, $zip, '', $exclude);

if (!$zip->close()) {
	exit('Failed to close zip archive: ' . $filename);
}

// Redirect after successful backup
header('Location: archive.php?done');
exit;

function addFolderToZip($dir, $zipArchive, $zipdir = '', $exclude = []) {
	if (is_dir($dir)) {
		if ($dh = opendir($dir)) {
			// Add empty directory
			if (!empty($zipdir)) {
				$zipArchive->addEmptyDir($zipdir);
			}

			while (($file = readdir($dh)) !== false) {
				if ($file === '.' || $file === '..') {
					continue;
				}
				$filePath = $dir . '/' . $file;
				if (shouldExclude($filePath, $exclude)) {
					continue;
				}
				if (!is_file($filePath)) {
					// Recursive call
					addFolderToZip($filePath, $zipArchive, $zipdir . $file . '/', $exclude);
				} else {
					$zipArchive->addFile($filePath, $zipdir . $file);
				}
			}
			closedir($dh);
		}
	}
}
?>