<?php

// Setup inclusions
$load['plugin'] = true;

// Include common.php
include('inc/common.php');
login_cookie_check();

if (!extension_loaded('zip')) {
	exit('PHP zip extension is not installed.');
}

$filename = GSBACKUPSPATH . 'zip/' . date('YmdHis') . '.zip';
$zip = new ZipArchive();
if ($zip->open($filename, ZipArchive::CREATE) !== TRUE) {
	exit("Cannot open <$filename>\n");
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

$zip->close();
redirect('archive.php?done');

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