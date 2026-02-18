<?php

include('../../../gsconfig.php');
$admin = defined('GSADMIN') ? GSADMIN : 'admin';
include("../../../{$admin}/inc/common.php");
$loggedin = cookie_check();
if (!$loggedin) die("Not logged in!");
if (!defined('IN_GS')) {
	die('you cannot load this page directly.');
}

i18n_merge('i18n_gallery', substr($LANG, 0, 2));
i18n_merge('i18n_gallery', 'en');

if (isset($_GET['path'])) {
	$subPath = preg_replace('/\.+\//', '', $_GET['path']);
	if ($subPath) $subPath .= '/';
	$path = "../../../data/uploads/" . $subPath;
} else {
	$subPath = "";
	$path = "../../../data/uploads/";
}
$path = tsl($path);

// Check if host uses Linux (used for displaying permissions)
$isUnixHost = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? false : true);
$path_parts = pathinfo($_SERVER['PHP_SELF']);
$dir = str_replace("/plugins/i18n_gallery/browser", "", $path_parts['dirname']);
$fullPath = htmlspecialchars("http://" . $_SERVER['SERVER_NAME'] . ($dir == '/' ? "" : $dir) . "/data/uploads/", ENT_QUOTES, 'UTF-8');
$sitepath = htmlspecialchars("http://" . $_SERVER['SERVER_NAME'] . ($dir == '/' ? "" : $dir) . "/", ENT_QUOTES, 'UTF-8');

$func = preg_replace('/[^\w]/', '', $_GET['func'] ?? '');
$w = (int) ($_GET['w'] ?? 0);
$h = (int) ($_GET['h'] ?? 0);
if (!$w && !$h) {
	$w = 160;
	$h = 120;
}
$autoclose = isset($_GET['autoclose']) ? (int) $_GET['autoclose'] : 0;
$debug = isset($_GET['debug']) ? (bool) $_GET['debug'] : false;

global $LANG;
$LANG_header = preg_replace('/(?:(?<=([a-z]{2}))).*/', '', $LANG);
$count = 0;
$dircount = 0;
$totalsize = 0;
$filesArray = [];
$dirsArray = [];

clearstatcache();
$dir_handle = opendir($path) or die("Unable to open " . htmlspecialchars($path, ENT_QUOTES, 'UTF-8'));
while ($file = readdir($dir_handle)) {
	if ($file == "." || $file == ".." || $file == ".htaccess") {
		// not an upload file
	} elseif (is_dir($path . $file)) {
		$dirsArray[$dircount]['name'] = $file;
		$dircount++;
	} else {
		$ext = strtolower(substr($file, strrpos($file, '.') + 1));
		if ($ext !== 'php' && $ext !== 'htaccess') {
			$ss = @stat($path . $file);
			// Only attempt getimagesize for known image types to avoid warnings on non-images
			$imgExts = ['jpg', 'jpeg', 'gif', 'webp', 'png', 'svg'];
			$imgSize = in_array($ext, $imgExts) ? @getimagesize($path . $file) : false;
			$width  = $imgSize ? $imgSize[0] : 0;
			$height = $imgSize ? $imgSize[1] : 0;
			$filesArray[] = [
				'name'        => $file,
				'date'        => @date('M j, Y', $ss['ctime']),
				'size'        => fSize($ss['size']),
				'bytes'       => $ss['size'],
				'width'       => $width,
				'height'      => $height,
				'title'       => '',
				'tags'        => '',
				'description' => '',
			];
			$totalsize += $ss['size'];
			$count++;
		}
	}
}
closedir($dir_handle);

$filesSorted = subval_sort($filesArray, 'name');
$dirsSorted  = subval_sort($dirsArray, 'name');

$pathParts = explode("/", $subPath);
$urlPath = "";
?>
<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($LANG_header, ENT_QUOTES, 'UTF-8'); ?>">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php echo i18n_r('FILE_BROWSER'); ?></title>
	<link rel="shortcut icon" href="../../../<?php echo htmlspecialchars($admin, ENT_QUOTES, 'UTF-8'); ?>/favicon.png" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="../../../<?php echo htmlspecialchars($admin, ENT_QUOTES, 'UTF-8'); ?>/template/style.php?v=<?php echo GSVERSION; ?>" media="screen" />
	<style>
		.wrapper,
		#maincontent,
		#imageTable {
			width: 100%
		}
	</style>
</head>

<body id="imagebrowser">
	<div class="wrapper">
		<div id="maincontent">
			<div class="main" style="border:none;">
				<h3><?php i18n('UPLOADED_FILES'); ?></h3>
				<div class="h5">/ <a href="?func=<?php echo htmlspecialchars($func, ENT_QUOTES, 'UTF-8'); ?>&amp;w=<?php echo $w; ?>&amp;h=<?php echo $h; ?>&amp;autoclose=<?php echo $autoclose; ?>">uploads</a> /
					<?php
					foreach ($pathParts as $pathPart) {
						if ($pathPart != '') {
							$urlPath .= $pathPart;
					?>
						<a href="?path=<?php echo htmlspecialchars($urlPath, ENT_QUOTES, 'UTF-8'); ?>&amp;func=<?php echo htmlspecialchars($func, ENT_QUOTES, 'UTF-8'); ?>&amp;w=<?php echo $w; ?>&amp;h=<?php echo $h; ?>&amp;autoclose=1"><?php echo htmlspecialchars($pathPart, ENT_QUOTES, 'UTF-8'); ?></a> /
					<?php
							$urlPath .= '/';
						}
					}
					?>
				</div>
				<table class="highlight" id="imageTable">
					<tbody>
						<?php
						if (count((array) $dirsSorted) !== 0) {
							foreach ((array) $dirsSorted as $upload) {
								$p = $subPath . $upload['name'];
						?>
								<tr class="All">
									<td colspan="5">
										<a href="filebrowser.php?path=<?php echo htmlspecialchars($p, ENT_QUOTES, 'UTF-8'); ?>&amp;func=<?php echo htmlspecialchars($func, ENT_QUOTES, 'UTF-8'); ?>&amp;w=<?php echo $w; ?>&amp;h=<?php echo $h; ?>&amp;autoclose=1" title="<?php echo htmlspecialchars($upload['name'], ENT_QUOTES, 'UTF-8'); ?>"><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;" width="32" height="32" viewBox="0 0 80 80"><rect width="80" height="80" fill="none"/><g fill="none"><path fill="#f2994a" fill-rule="evenodd" d="M16 17a4 4 0 0 0-4 4v38a4 4 0 0 0 4 4h48a4 4 0 0 0 4-4V29a4 4 0 0 0-4-4H35.4c-.367 0-.711-.177-.924-.475l-.34-.474l-.376-.526l-.377-.525l-3.099-4.329A4 4 0 0 0 27.032 17z" clip-rule="evenodd"/><rect width="56" height="38" x="12" y="25" fill="#f2c94c" rx="4"/></g></svg> <strong><?php echo htmlspecialchars($upload['name'], ENT_QUOTES, 'UTF-8'); ?></strong></a>
									</td>
								</tr>
						<?php
							}
						}

						$metadata = [];
						if (count((array) $filesSorted) !== 0) {
							foreach ((array) $filesSorted as $upload) {
								$onclick = 'submitLink(' . count($metadata) . ')';
								$metadata[] = [
									'url'         => $subPath . $upload['name'],
									'size'        => $upload['bytes'],
									'width'       => $upload['width'],
									'height'      => $upload['height'],
									'title'       => $upload['title'],
									'tags'        => $upload['tags'],
									'description' => $upload['description'],
								];
								$filePerms = null;
								$fileOwner = null;
								if ($isUnixHost && defined('GSDEBUG') && function_exists('posix_getpwuid')) {
									$filePerms = substr(sprintf('%o', fileperms($path . $upload['name'])), -4);
									$fileOwner = posix_getpwuid(fileowner($path . $upload['name']));
								}
						?>
								<tr class="All images">
									<td style="vertical-align:middle;">
										<a href="javascript:void(0)" title="<?php echo htmlspecialchars(i18n_r('SELECT_FILE') . ': ' . $upload['name'], ENT_QUOTES, 'UTF-8'); ?>" onclick="<?php echo htmlspecialchars($onclick, ENT_QUOTES, 'UTF-8'); ?>">
											<img style="width:30px;height:30px;object-fit:cover;vertical-align:middle;" src="file.svg" data-src="<?php echo htmlspecialchars($SITEURL . 'data/uploads/' . $subPath . $upload['name'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($upload['name'], ENT_QUOTES, 'UTF-8'); ?>" />
										</a>
									</td>
									<td style="vertical-align:middle;">
										<a class="primarylink" href="javascript:void(0)" title="<?php echo htmlspecialchars(i18n_r('SELECT_FILE') . ': ' . $upload['name'], ENT_QUOTES, 'UTF-8'); ?>" onclick="<?php echo htmlspecialchars($onclick, ENT_QUOTES, 'UTF-8'); ?>">
											<?php echo htmlspecialchars($upload['name'], ENT_QUOTES, 'UTF-8'); ?>
										</a>
									</td>
									<td style="white-space:nowrap;vertical-align:middle;">
										<span><?php echo (int) $upload['width']; ?> x <?php echo (int) $upload['height']; ?></span>
									</td>
									<td style="width:80px;text-align:right;vertical-align:middle;">
										<span><?php echo $upload['size']; ?></span>
									</td>
									<?php if ($filePerms !== null && isset($fileOwner['name'])) { ?>
										<td style="width:70px;text-align:right;">
											<span><?php echo htmlspecialchars($fileOwner['name'], ENT_QUOTES, 'UTF-8'); ?>/<?php echo htmlspecialchars($filePerms, ENT_QUOTES, 'UTF-8'); ?></span>
										</td>
									<?php } ?>
									<td style="width:85px;text-align:right;vertical-align:middle;">
										<span><?php echo htmlspecialchars(shtDate($upload['date']), ENT_QUOTES, 'UTF-8'); ?></span>
									</td>
								</tr>
								<?php if ($debug) echo '<tr><td colspan="4"><pre>' . htmlspecialchars($upload['debug'] ?? '', ENT_QUOTES, 'UTF-8') . '</pre></td></tr>'; ?>
						<?php
							}
						}
						?>
					</tbody>
				</table>

				<p><em><b><?php echo count((array) $filesSorted); ?></b> <?php i18n('TOTAL_FILES'); ?> (<?php echo fSize($totalsize); ?>)</em></p>

				<script type="text/javascript">
					var metadata = <?php echo json_encode($metadata, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
				</script>

				<script>
					function submitLink(e) {
						var linker = document.querySelectorAll('.images img')[e].getAttribute('data-src');
						var funcName = <?php echo json_encode($func); ?>;
						var input = window.opener.document.querySelector('input[name="' + funcName + '"]');
						if (input) {
							input.value = linker;
							window.close();
						}
					}
				</script>

			</div>
		</div>
	</div>
</body>

</html>
