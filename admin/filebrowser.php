<?php
/**
 * File Browser for CKEditor
 *
 * Displays, selects, and uploads files for insertion into CKEditor / links.
 *
 * @package GetSimple
 * @subpackage Files
 *
 * Version: 2.0 (modernized UI + upload support (2026-07-09))
 */

// Setup inclusions
include('inc/common.php');
login_cookie_check();

$filesSorted=null;$dirsSorted=null;

$path = (isset($_GET['path'])) ? "../data/uploads/".$_GET['path'] : "../data/uploads/";
$subPath = (isset($_GET['path'])) ? $_GET['path'] : "";
if(!path_is_safe($path,GSDATAUPLOADPATH)) die();
$returnid = isset($_GET['returnid']) ? var_out($_GET['returnid']) : "";
$func = (isset($_GET['func'])) ? var_out($_GET['func']) : "";
$path = tsl($path);
// check if host uses Linux (used for displaying permissions
$isUnixHost = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? false : true);
$CKEditorFuncNum = isset($_GET['CKEditorFuncNum']) ? var_out($_GET['CKEditorFuncNum']) : '';
$sitepath = suggest_site_path();
$fullPath = $sitepath . "data/uploads/";
$type = isset($_GET['type']) ? var_out($_GET['type']) : '';

global $LANG;
$LANG_header = preg_replace('/(?:(?<=([a-z]{2}))).*/', '', $LANG);

// -----------------------------------------------------------------------
// Upload handling
// -----------------------------------------------------------------------
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['fb_upload_token'])) {
	$_SESSION['fb_upload_token'] = bin2hex(random_bytes(16));
}
$fbUploadToken = $_SESSION['fb_upload_token'];

// Extensions we will never allow to be uploaded here, regardless of what
// the server's own upload settings permit.
$fbBlockedExts = [
	'php','php2','php3','php4','php5','php7','php8','phtml','pht','phar',
	'cgi','pl','py','sh','bash','exe','com','bat','cmd','msi','dll','so',
	'asp','aspx','jsp','jspx','vbs','ps1','ini','htaccess','htpasswd','cer','crt'
];

function fb_sanitize_filename($name) {
	$name = basename($name);
	$ext  = strtolower(pathinfo($name, PATHINFO_EXTENSION));
	$base = pathinfo($name, PATHINFO_FILENAME);

	$base = preg_replace('/[^A-Za-z0-9_\-\.]+/', '-', $base);
	$base = trim($base, " -_.");
	if ($base === '') $base = 'file';

	$ext = preg_replace('/[^A-Za-z0-9]+/', '', $ext);

	if (defined('GSUPLOADSLC') && GSUPLOADSLC) {
		$base = strtolower($base);
		$ext  = strtolower($ext);
	}

	return $ext !== '' ? $base . '.' . $ext : $base;
}

function fb_unique_filename($dir, $filename) {
	$ext  = pathinfo($filename, PATHINFO_EXTENSION);
	$base = pathinfo($filename, PATHINFO_FILENAME);
	$final = $filename;
	$i = 1;
	while (file_exists($dir . $final)) {
		$final = $ext !== '' ? $base . '-' . $i . '.' . $ext : $base . '-' . $i;
		$i++;
	}
	return $final;
}

// Pre-generate the "thumbsm." preview used by this browser's grid.
function fb_generate_thumbsm($relFile) {
	static $classLoaded = false;

	$rasterExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
	$ext = strtolower(pathinfo($relFile, PATHINFO_EXTENSION));
	if (!in_array($ext, $rasterExts, true)) return false; // svg etc. don't need this

	if (!$classLoaded) {
		$classFile = GSADMININCPATH . 'image.class.php';
		if (!file_exists($classFile)) return false;
		require_once $classFile;
		$classLoaded = true;
	}
	if (!class_exists('Zubrag_image')) return false;

	$dirname  = dirname($relFile);
	$basename = basename($relFile);
	$destRel  = ($dirname !== '.' && $dirname !== '') ? $dirname . '/thumbsm.' . $basename : 'thumbsm.' . $basename;

	$srcAbs  = GSDATAUPLOADPATH . $relFile;
	$destAbs = GSTHUMBNAILPATH  . $destRel;

	if (!file_exists($srcAbs)) return false;

	// Mirror thumb.php's own subdirectory creation so nested-folder uploads
	// don't fail because data/thumbs/<subfolder>/ doesn't exist yet.
	$destDir = dirname($destAbs);
	if (!is_dir($destDir)) {
		if (!@mkdir($destDir, 0755, true) && !is_dir($destDir)) return false;
	}

	try {
		$img = new Zubrag_image();
		$img->max_x			= 65;   // matches the x=65 this browser's grid requests
		$img->max_y			= 130;  // thumb.php's own default
		$img->quality		= 75;   // thumb.php's own default
		$img->save_to_file	= true;
		$img->image_type	= -1;   // keep source format
		$img->GenerateThumbFile($srcAbs, $destAbs);
		return file_exists($destAbs);
	} catch (\Throwable $e) {
		// Non-fatal: the grid already falls back to showing the full image
		// directly when no thumbsm. file exists.
		return false;
	}
}

// Pre-generate the larger "thumbnail." file (used by the fb-card-thumbnail-link
// "Thumbnail" option next to an image).
function fb_generate_thumbnail_large($relDir, $safeName) {
	static $fnLoaded = false;

	$rasterExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
	$ext = strtolower(pathinfo($safeName, PATHINFO_EXTENSION));
	if (!in_array($ext, $rasterExts, true)) return false;

	if (!$fnLoaded) {
		if (!function_exists('genStdThumb')) {
			$incFile = GSADMININCPATH . 'imagemanipulation.php';
			if (!file_exists($incFile)) return false;
			require_once $incFile;
		}
		$fnLoaded = true;
	}
	if (!function_exists('genStdThumb')) return false;

	try {
		genStdThumb($relDir, $safeName);
		return file_exists(GSTHUMBNAILPATH . $relDir . 'thumbnail.' . $safeName);
	} catch (\Throwable $e) {
		return false;
	}
}

if (isset($_POST['fb_action']) && $_POST['fb_action'] === 'upload') {
	header('Content-Type: application/json; charset=UTF-8');

	$results = [];

	$token = $_POST['fb_token'] ?? '';
	if (!hash_equals($fbUploadToken, (string)$token)) {
		echo json_encode(['ok' => false, 'msg' => 'Security token expired - please refresh this window and try again.']);
		exit;
	}

	if (!path_is_safe($path, GSDATAUPLOADPATH)) {
		echo json_encode(['ok' => false, 'msg' => 'Invalid path.']);
		exit;
	}

	if (empty($_FILES['files'])) {
		echo json_encode(['ok' => false, 'msg' => 'No files received.']);
		exit;
	}

	// Normalise $_FILES['files'] (which arrives as parallel arrays) into a
	// simple list of single-file entries.
	$fileCount = is_array($_FILES['files']['name']) ? count($_FILES['files']['name']) : 0;

	for ($i = 0; $i < $fileCount; $i++) {
		$origName	= $_FILES['files']['name'][$i];
		$tmpName	= $_FILES['files']['tmp_name'][$i];
		$error		= $_FILES['files']['error'][$i];
		$size		= $_FILES['files']['size'][$i];

		if ($error !== UPLOAD_ERR_OK || !is_uploaded_file($tmpName)) {
			$results[] = ['name' => $origName, 'ok' => false, 'msg' => 'Upload error.'];
			continue;
		}

		$ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
		if ($ext === '' || in_array($ext, $fbBlockedExts, true)) {
			$results[] = ['name' => $origName, 'ok' => false, 'msg' => 'File type not allowed.'];
			continue;
		}

		$safeName = fb_sanitize_filename($origName);
		// fb_sanitize_filename() already runs the name through basename() and
		// strips anything but [A-Za-z0-9_-.], so it cannot contain a path
		// separator or a ".." traversal segment at this point.
		$safeName = fb_unique_filename($path, $safeName);

		if (!move_uploaded_file($tmpName, $path . $safeName)) {
			$results[] = ['name' => $origName, 'ok' => false, 'msg' => 'Could not save file.'];
			continue;
		}

		// Belt-and-suspenders check now that the file actually exists on
		// disk (filepath_is_safe() resolves paths, which requires the file
		// to be present - checking beforehand rejected every upload).
		if (function_exists('filepath_is_safe') && !filepath_is_safe($path . $safeName, $path)) {
			@unlink($path . $safeName);
			$results[] = ['name' => $origName, 'ok' => false, 'msg' => 'Invalid filename.'];
			continue;
		}

		@chmod($path . $safeName, 0644);

		$relDir  = ($subPath !== '' ? rtrim($subPath, '/') . '/' : '');
		$relFile = $relDir . $safeName;
		fb_generate_thumbsm($relFile);
		fb_generate_thumbnail_large($relDir, $safeName);

		$results[]	= [
			'name'	=> $safeName,
			'ok'	=> true,
			'size'	=> fSize($size),
		];
	}

	$anyOk = false;
	foreach ($results as $r) { if ($r['ok']) { $anyOk = true; break; } }

	echo json_encode(['ok' => $anyOk, 'files' => $results]);
	exit;
}

// -----------------------------------------------------------------------
// Helper: map a file extension to an icon-type name
// -----------------------------------------------------------------------
function getFileIconType(string $ext): string {
	$ext = strtolower($ext);
	$map = [
		'image'		=> ['jpg','jpeg','png','gif','webp','svg','bmp','tiff','ico'],
		'pdf'		=> ['pdf'],
		'text'		=> ['txt','md','csv','log','rtf'],
		'archive'	=> ['zip','tar','gz','bz2','rar','7z'],
		'audio'		=> ['mp3','wav','ogg','flac','aac','m4a'],
		'video'		=> ['mp4','mov','avi','mkv','webm','flv'],
		'code'		=> ['js','css','html','htm','xml','json','py','rb','sh'],
		'word'		=> ['doc','docx','odt'],
		'sheet'		=> ['xls','xlsx','ods'],
	];
	foreach ($map as $iconType => $exts) {
		if (in_array($ext, $exts)) return $iconType;
	}
	return 'generic';
}

// -----------------------------------------------------------------------
// Helper: render an inline SVG icon for a given icon-type name
// -----------------------------------------------------------------------
function renderFileIcon(string $iconType): string {
	$colors = [
		'image'		=> '#4CAF50',
		'pdf'		=> '#F44336',
		'text'		=> '#607D8B',
		'archive'	=> '#FF9800',
		'audio'		=> '#9C27B0',
		'video'		=> '#2196F3',
		'code'		=> '#00BCD4',
		'word'		=> '#1565C0',
		'sheet'		=> '#2E7D32',
		'generic'	=> '#9E9E9E',
	];
	$c = $colors[$iconType] ?? '#9E9E9E';

	$paths = [
		'image'   => '<rect x="3" y="3" width="18" height="18" rx="2" fill="none" stroke="'.$c.'" stroke-width="1.5"/>'
				   . '<circle cx="8.5" cy="8.5" r="1.5" fill="'.$c.'"/>'
				   . '<polyline points="21,15 16,10 5,21" fill="none" stroke="'.$c.'" stroke-width="1.5"/>',

		'pdf'	 => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" fill="none" stroke="'.$c.'" stroke-width="1.5"/>'
				   . '<polyline points="14,2 14,8 20,8" fill="none" stroke="'.$c.'" stroke-width="1.5"/>'
				   . '<line x1="9" y1="13" x2="15" y2="13" stroke="'.$c.'" stroke-width="1.5"/>'
				   . '<line x1="9" y1="17" x2="12" y2="17" stroke="'.$c.'" stroke-width="1.5"/>',

		'text'	=> '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" fill="none" stroke="'.$c.'" stroke-width="1.5"/>'
				   . '<polyline points="14,2 14,8 20,8" fill="none" stroke="'.$c.'" stroke-width="1.5"/>'
				   . '<line x1="9" y1="13" x2="15" y2="13" stroke="'.$c.'" stroke-width="1.5"/>'
				   . '<line x1="9" y1="17" x2="15" y2="17" stroke="'.$c.'" stroke-width="1.5"/>',

		'archive' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" fill="none" stroke="'.$c.'" stroke-width="1.5"/>'
				   . '<polyline points="14,2 14,8 20,8" fill="none" stroke="'.$c.'" stroke-width="1.5"/>'
				   . '<line x1="12" y1="11" x2="12" y2="17" stroke="'.$c.'" stroke-width="1.5" stroke-dasharray="2,1"/>',

		'audio'   => '<path d="M9 18V5l12-2v13" fill="none" stroke="'.$c.'" stroke-width="1.5"/>'
				   . '<circle cx="6" cy="18" r="3" fill="none" stroke="'.$c.'" stroke-width="1.5"/>'
				   . '<circle cx="18" cy="16" r="3" fill="none" stroke="'.$c.'" stroke-width="1.5"/>',

		'video'   => '<rect x="2" y="7" width="15" height="10" rx="2" fill="none" stroke="'.$c.'" stroke-width="1.5"/>'
				   . '<polyline points="17,10 22,7 22,17 17,14" fill="none" stroke="'.$c.'" stroke-width="1.5"/>',

		'code'	=> '<polyline points="16,18 22,12 16,6" fill="none" stroke="'.$c.'" stroke-width="1.5"/>'
				   . '<polyline points="8,6 2,12 8,18" fill="none" stroke="'.$c.'" stroke-width="1.5"/>',

		'word'	=> '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" fill="none" stroke="'.$c.'" stroke-width="1.5"/>'
				   . '<polyline points="14,2 14,8 20,8" fill="none" stroke="'.$c.'" stroke-width="1.5"/>'
				   . '<text x="7" y="19" font-size="7" font-family="sans-serif" font-weight="bold" fill="'.$c.'">W</text>',

		'sheet'   => '<rect x="3" y="3" width="18" height="18" rx="1" fill="none" stroke="'.$c.'" stroke-width="1.5"/>'
				   . '<line x1="3" y1="9" x2="21" y2="9" stroke="'.$c.'" stroke-width="1.5"/>'
				   . '<line x1="3" y1="15" x2="21" y2="15" stroke="'.$c.'" stroke-width="1.5"/>'
				   . '<line x1="9" y1="3" x2="9" y2="21" stroke="'.$c.'" stroke-width="1.5"/>',

		'generic' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" fill="none" stroke="'.$c.'" stroke-width="1.5"/>'
				   . '<polyline points="14,2 14,8 20,8" fill="none" stroke="'.$c.'" stroke-width="1.5"/>',
	];

	$inner = $paths[$iconType] ?? $paths['generic'];
	return '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" style="vertical-align:middle;">'.$inner.'</svg>';
}

// -----------------------------------------------------------------------
// Gather directory contents (unchanged logic, just reused below)
// -----------------------------------------------------------------------
$count="0";
$dircount="0";
$counter = "0";
$totalsize = 0;
$filesArray = [];
$dirsArray = [];

$filenames = getFiles($path);
if (count($filenames) != 0) {
	foreach ($filenames as $file) {
		if ($file == "." || $file == ".." || $file == ".htaccess" ){
		// not a upload file
		} elseif (is_dir($path . $file)) {
			$dirsArray[$dircount]['name'] = $file;
			$dircount++;
		} else {
			$filesArray[$count]['name'] = $file;
			$ext = substr($file, strrpos($file, '.') + 1);
			$extention = get_FileType($ext);
			$filesArray[$count]['type'] = $extention;
			clearstatcache();
			$ss = @stat($path . $file);
			$filesArray[$count]['date'] = @date('M j, Y',$ss['mtime']);
			$filesArray[$count]['size'] = fSize($ss['size']);
			$totalsize = $totalsize + $ss['size'];
			$count++;
		}
	}
	$filesSorted = subval_sort($filesArray,'name');
	$dirsSorted = subval_sort($dirsArray,'name');
}

$pathParts=explode("/",$subPath);
$urlPath="";
?>
<!DOCTYPE html>
<html lang="<?php echo $LANG_header; ?>">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"  />
	<title><?php echo i18n_r('FILE_BROWSER'); ?></title>
	<link rel="shortcut icon" href="favicon.png" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="template/style.php?v=<?php echo GSVERSION; ?>" media="screen" />
	<style>
		:root{--fb-bg:#f5f6f8;--fb-panel:#ffffff;--fb-border:#e2e5ea;--fb-text:#1a1a2e;--fb-muted:#6b7280;--fb-accent:#2764e7;--fb-accent-hover:#0094f0;--fb-danger:#e74c3c;--fb-radius:10px}#imageTable,#maincontent,.wrapper{width:100%}#filebrowser{background:var(--fb-bg)}#filebrowser .main{border:none!important;background:0 0;padding:1.25rem 1.5rem 2rem;font-family:system-ui,-apple-system,"Segoe UI",Roboto,sans-serif;color:var(--fb-text)}#filebrowser h3{display:flex;align-items:center;gap:.5rem;font-size:1.15rem;font-weight:700;margin:0 0 1rem}#filetypetoggle a{color:var(--fb-accent);font-weight:600;text-decoration:none}#filetypetoggle a:hover{text-decoration:underline}

		/* Two-column header: title+breadcrumb on the left, upload dropzone on the right */
		.fb-header-row{display:flex;align-items:stretch;gap:1rem;flex-wrap:wrap;margin-bottom:1rem}.fb-header-left{flex:1 1 320px;min-width:240px;display:flex;flex-direction:column;gap:.6rem}.fb-header-left h3{margin-bottom:0}.fb-header-right{flex:0 1 300px;min-width:220px;display:flex}

		/* Breadcrumb */
		.fb-breadcrumb{display:flex;flex-wrap:wrap;align-items:center;gap:.25rem;font-size:.875rem;padding:.6rem .9rem;background:var(--fb-panel);border:1px solid var(--fb-border);border-radius:var(--fb-radius)}.fb-breadcrumb a{color:var(--fb-accent);text-decoration:none;font-weight:600;padding:.15rem .35rem;border-radius:5px}.fb-breadcrumb a:hover{background:#eef3ff}.fb-breadcrumb .fb-sep{color:var(--fb-muted)}

		/* Dropzone - compact, horizontal, sits beside the title/breadcrumb column */
		.fb-dropzone{position:relative;display:flex;flex-direction:row;align-items:center;justify-content:center;gap:.55rem;text-align:left;width:100%;padding:.75rem 1rem;border:2px dashed #c7cedb;border-radius:var(--fb-radius);background:var(--fb-panel);color:var(--fb-muted);font-size:.85rem;cursor:pointer;transition:border-color .15s,background .15s}.fb-dropzone:hover{border-color:var(--fb-accent);background:#f7faff}.fb-dropzone.fb-dragover{border-color:var(--fb-accent);background:#eef3ff;color:var(--fb-accent)}.fb-dropzone svg{color:var(--fb-accent);flex:0 0 auto}.fb-dropzone strong{color:var(--fb-text)}.fb-dropzone input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer}.fb-dz-hint{font-size:.78rem;color:#9aa1ae}

		@media (max-width: 640px){
			.fb-header-right{ flex-basis:100%; }
		}

		/* Upload progress list */
		.fb-uploads{margin-bottom:1.25rem;display:flex;flex-direction:column;gap:.4rem}.fb-upload-row{display:flex;align-items:center;gap:.6rem;background:var(--fb-panel);border:1px solid var(--fb-border);border-radius:8px;padding:.5rem .75rem;font-size:.82rem}.fb-upload-row .fb-up-name{flex:1 1 auto;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.fb-upload-row .fb-up-bar{flex:0 0 120px;height:6px;background:#e5e8ee;border-radius:4px;overflow:hidden}.fb-upload-row .fb-up-bar-fill{height:100%;width:0%;background:var(--fb-accent);transition:width .15s}.fb-upload-row.fb-up-ok .fb-up-bar-fill{background:#16a34a}.fb-upload-row.fb-up-err .fb-up-bar-fill{background:var(--fb-danger);width:100%!important}.fb-upload-row .fb-up-status{flex:0 0 auto;font-weight:600}.fb-upload-row.fb-up-ok .fb-up-status{color:#16a34a}.fb-upload-row.fb-up-err .fb-up-status{color:var(--fb-danger)}

		/* Grid of folders/files */
		.fb-card,.fb-card-thumb{overflow:hidden;display:flex}.fb-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:.75rem}.fb-card{position:relative;flex-direction:column;background:var(--fb-panel);border:1px solid var(--fb-border);border-radius:var(--fb-radius);text-decoration:none;color:var(--fb-text);transition:box-shadow .15s,transform .15s,border-color .15s;cursor:pointer}.fb-card:hover{box-shadow:0 6px 18px rgba(20,30,60,.09);transform:translateY(-2px);border-color:#c9d6f5}.fb-card:focus-visible{outline:2px solid var(--fb-accent);outline-offset:2px}.fb-card-thumb{position:relative;width:100%;aspect-ratio:4/3;background:#f0f2f6;align-items:center;justify-content:center}.fb-card-thumb img{width:100%;height:100%;object-fit:cover;display:block}.fb-card-folder .fb-card-thumb{background:#fff8e6}.fb-card-body{padding:.55rem .65rem .65rem;display:flex;flex-direction:column;gap:.15rem}.fb-card-name{font-size:.8rem;font-weight:600;line-height:1.25;overflow:hidden;text-overflow:ellipsis;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical}.fb-card-meta{font-size:.7rem;color:var(--fb-muted);display:flex;justify-content:space-between;gap:.4rem}.fb-card-thumbnail-link{position:absolute;top:.35rem;right:.35rem;background:rgba(26,26,46,.72);color:#fff!important;font-size:.65rem;font-weight:600;padding:.15rem .4rem;border-radius:4px;text-decoration:none!important}.fb-empty,.fb-footer{color:var(--fb-muted)}.fb-card-thumbnail-link:hover{background:var(--fb-accent)}.fb-empty{padding:2rem 1rem;text-align:center;font-size:.9rem}.fb-footer{margin-top:1rem;font-size:.8rem}
	</style>
	<script type='text/javascript'>

	function submitLink($funcNum, $url) {
		<?php if (isset($_GET['returnid'])){ ?>
			if(window.opener){
				window.opener.document.getElementById('<?php echo $returnid; ?>').focus();
				window.opener.document.getElementById('<?php echo $returnid; ?>').value=$url;
			}
		<?php
			if (isset($_GET['func'])){
		?>
				if(window.opener){
					if(typeof window.opener.<?php echo $func; ?> == 'function') {
						window.opener.<?php echo $func; ?>('<?php echo $returnid; ?>');
					}
				}
		<?php
			}
		}
		 else { ?>
			if(window.opener){
				window.opener.CKEDITOR.tools.callFunction($funcNum, $url);
			}
		<?php } ?>
		window.close();
	}

	// ---- Upload handling ----
	document.addEventListener('DOMContentLoaded', function () {
		var dropzone   = document.getElementById('fbDropzone');
		var fileInput  = document.getElementById('fbFileInput');
		var uploadList = document.getElementById('fbUploadList');
		if (!dropzone || !fileInput) return;

		var token = <?php echo json_encode($fbUploadToken); ?>;

		['dragenter','dragover'].forEach(function (evt) {
			dropzone.addEventListener(evt, function (e) {
				e.preventDefault(); e.stopPropagation();
				dropzone.classList.add('fb-dragover');
			});
		});
		['dragleave','drop'].forEach(function (evt) {
			dropzone.addEventListener(evt, function (e) {
				e.preventDefault(); e.stopPropagation();
				dropzone.classList.remove('fb-dragover');
			});
		});
		dropzone.addEventListener('drop', function (e) {
			var files = e.dataTransfer ? e.dataTransfer.files : null;
			if (files && files.length) uploadFiles(files);
		});
		fileInput.addEventListener('change', function () {
			if (fileInput.files && fileInput.files.length) uploadFiles(fileInput.files);
			fileInput.value = '';
		});

		function uploadFiles(fileList) {
			var files = Array.prototype.slice.call(fileList);
			var anySucceeded = false;
			var pending = files.length;

			files.forEach(function (file) {
				var row = document.createElement('div');
				row.className = 'fb-upload-row';
				row.innerHTML =
					'<span class="fb-up-name">' + file.name + '</span>' +
					'<span class="fb-up-bar"><span class="fb-up-bar-fill"></span></span>' +
					'<span class="fb-up-status">…</span>';
				uploadList.appendChild(row);

				var fill   = row.querySelector('.fb-up-bar-fill');
				var status = row.querySelector('.fb-up-status');

				var fd = new FormData();
				fd.append('fb_action', 'upload');
				fd.append('fb_token', token);
				fd.append('files[]', file);

				var xhr = new XMLHttpRequest();
				xhr.open('POST', window.location.href, true);
				xhr.upload.addEventListener('progress', function (e) {
					if (e.lengthComputable) {
						fill.style.width = Math.round((e.loaded / e.total) * 100) + '%';
					}
				});
				xhr.onload = function () {
					var ok = false;
					try {
						var resp = JSON.parse(xhr.responseText);
						ok = !!resp.ok && resp.files && resp.files[0] && resp.files[0].ok;
						if (!ok && resp.files && resp.files[0] && resp.files[0].msg) {
							status.textContent = resp.files[0].msg;
						} else if (!ok && resp.msg) {
							status.textContent = resp.msg;
						}
					} catch (err) {
						status.textContent = 'Upload failed';
					}
					row.classList.add(ok ? 'fb-up-ok' : 'fb-up-err');
					if (ok) { status.textContent = 'Done'; anySucceeded = true; }
					finishOne();
				};
				xhr.onerror = function () {
					row.classList.add('fb-up-err');
					status.textContent = 'Network error';
					finishOne();
				};
				xhr.send(fd);
			});

			function finishOne() {
				pending--;
				if (pending === 0 && anySucceeded) {
					setTimeout(function () { window.location.reload(); }, 600);
				}
			}
		}
	});
	</script>
</head>
<body id="filebrowser" >
	<div class="wrapper">
		<div id="maincontent">
			<div class="main">
			<div class="fb-header-row">
				<div class="fb-header-left">
					<h3><?php echo i18n('UPLOADED_FILES'); ?><span id="filetypetoggle">&nbsp;&nbsp;/&nbsp;&nbsp;<?php echo ($type == 'images' ? i18n('IMAGES') : i18n('SHOW_ALL') ); ?></span></h3>

<?php
	echo '<div class="fb-breadcrumb"><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;" width="16" height="16" viewBox="0 0 48 48"><rect width="48" height="48" fill="none"></rect><path fill="#ffa000" d="M40 12H22l-4-4H8c-2.2 0-4 1.8-4 4v8h40v-4c0-2.2-1.8-4-4-4"></path><path fill="#ffca28" d="M40 12H8c-2.2 0-4 1.8-4 4v20c0 2.2 1.8 4 4 4h32c2.2 0 4-1.8 4-4V16c0-2.2-1.8-4-4-4"></path></svg> / <a href="?CKEditorFuncNum='.$CKEditorFuncNum.'&amp;type='.$type.'">uploads</a>';
	foreach ($pathParts as $pathPart){
		if ($pathPart!=''){
			$urlPath.=$pathPart."/";
			echo '<span class="fb-sep">/</span><a href="?path='.$urlPath.'&amp;CKEditorFuncNum='.$CKEditorFuncNum.'&amp;type='.$type.'&amp;func='.$func.'">'.$pathPart.'</a>';
		}
	}
	echo "</div>";
?>
				</div>

				<div class="fb-header-right">
					<label class="fb-dropzone" id="fbDropzone" for="fbFileInput">
						<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 16V4M12 4l-4 4M12 4l4 4"/><path d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/></svg>
						<div><strong><?php echo i18n_r('FILE_UPLOAD') ?></strong></div>
						<input type="file" id="fbFileInput" multiple>
					</label>
				</div>
			</div>

			<div class="fb-uploads" id="fbUploadList"></div>

<?php
	$hasDirs = (count((array)$dirsSorted) != 0);
	$hasFiles = (count((array)$filesSorted) != 0);

	if (!$hasDirs && !$hasFiles) {
		echo '<div class="fb-empty">No files here yet.</div>';
	} else {
		echo '<div class="fb-grid" id="imageTable">';

		if ($hasDirs) {
			foreach ((array)$dirsSorted as $upload) {
				$adm = substr($path . $upload['name'] ,  16);
				$returnlink = ($returnid!='') ? '&returnid='.$returnid : '';
				$funct = ($func!='') ? '&func='.$func : '';
				echo '<a class="fb-card fb-card-folder" href="filebrowser.php?path='.$adm.'&amp;CKEditorFuncNum='.$CKEditorFuncNum.'&amp;type='.$type.$returnlink.'&amp;'.$funct.'" title="'. htmlspecialchars($upload['name']) .'">';
				echo '<div class="fb-card-thumb"><svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 48 48"><rect width="48" height="48" fill="none"/><path fill="#ffa000" d="M40 12H22l-4-4H8c-2.2 0-4 1.8-4 4v8h40v-4c0-2.2-1.8-4-4-4"/><path fill="#ffca28" d="M40 12H8c-2.2 0-4 1.8-4 4v20c0 2.2 1.8 4 4 4h32c2.2 0 4-1.8 4-4V16c0-2.2-1.8-4-4-4"/></svg></div>';
				echo '<div class="fb-card-body"><div class="fb-card-name">'.htmlspecialchars($upload['name']).'</div></div>';
				echo '</a>';
			}
		}

		if ($hasFiles) {
			foreach ($filesSorted as $upload) {
				$originalName = $upload['name'];
				$fileExtension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

				// Never show PHP files
				if ($fileExtension === 'php') { continue; }

				$upload['name'] = rawurlencode($upload['name']);
				$thumbInner = null; $thumbnailLink = null;
				$subDir = ($subPath == '' ? '' : $subPath.'/');
				$selectClick = 'submitLink('.$CKEditorFuncNum.',\''.$fullPath.$subDir.$upload['name'].'\')';
				$titleAttr = i18n_r('SELECT_FILE').': '. htmlspecialchars($originalName);

				if ($type == 'images') {
					// Image-picker mode: show thumbnails, skip non-image files
					if ($upload['type'] == i18n_r('IMAGES') .' Images' || $fileExtension === 'svg') {
						if ($fileExtension === 'svg') {
							$imgSrc = '<img src="../data/uploads/'. $subDir . $upload['name'] .'" loading="lazy" />';
						} else {
							$thumbLink = $urlPath.'thumbsm.'.$upload['name'];
							if (file_exists('../data/thumbs/'.$thumbLink)) {
								$imgSrc='<img src="../data/thumbs/'. $thumbLink .'" loading="lazy" />';
							} else {
								$imgSrc='<img src="../data/uploads/'. $urlPath . $upload['name'] .'" loading="lazy" />';
							}
						}
						$thumbInner = $imgSrc;

						$thumbnailLink = '';
						if ($fileExtension !== 'svg') {
							$thumbLinkExternal = 'data/thumbs/'.$urlPath.'thumbnail.'.$upload['name'];
							if (file_exists('../'.$thumbLinkExternal)) {
								$thumbnailLink = '<a class="fb-card-thumbnail-link" href="javascript:void(0)" onclick="event.stopPropagation();submitLink('.$CKEditorFuncNum.',\''.$sitepath.$thumbLinkExternal.'\')">'.i18n_r('THUMBNAIL').'</a>';
							}
						}
					} else {
						continue;
					}
				} else {
					// Link/file-picker mode: show a coloured type icon
					$iconType  = getFileIconType($fileExtension);
					$thumbInner = renderFileIcon($iconType);
					$thumbnailLink = '';
				}

				$counter++;

				$permTitle = '';
				if ($isUnixHost && isDebug() && function_exists('posix_getpwuid')) {
					$filePerms = substr(sprintf('%o', fileperms($path.$upload['name'])), -4);
					$fileOwner = posix_getpwuid(fileowner($path.$upload['name']));
					$permTitle = ' ('.$fileOwner['name'].'/'.$filePerms.')';
				}

				echo '<div class="fb-card" tabindex="0" role="button" onclick="'.$selectClick.'" onkeydown="if(event.key===\'Enter\'||event.key===\' \'){'.$selectClick.'}" title="'.$titleAttr.$permTitle.'">';
				echo '<div class="fb-card-thumb">'.$thumbInner.$thumbnailLink.'</div>';
				echo '<div class="fb-card-body">';
				echo '<div class="fb-card-name">'.htmlspecialchars($originalName).'</div>';
				echo '<div class="fb-card-meta"><span>'.$upload['size'].'</span><span>'.shtDate($upload['date']).'</span></div>';
				echo '</div>';
				echo '</div>';
			}
		}

		echo '</div>'; // .fb-grid
	}

	echo '<p class="fb-footer"><em><b>'. $counter .'</b> '.i18n_r('TOTAL_FILES').' ('. fSize($totalsize) .')</em></p>';
?>
			</div>
		</div>
	</div>
</body>
</html>