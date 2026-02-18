<?php
/**
 * Basic File Browser for CKEditor
 *
 * Displays and selects file link to insert into CKEditor
 *
 * @package GetSimple
 * @subpackage Files
 * 
 * Version: 1.1 (2011-03-12)
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
?>
<!DOCTYPE html>
<html lang="<?php echo $LANG_header; ?>">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"  />
	<title><?php echo i18n_r('FILE_BROWSER'); ?></title>
	<link rel="shortcut icon" href="favicon.png" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="template/style.php?v=<?php echo GSVERSION; ?>" media="screen" />
	<style>
		.wrapper, #maincontent, #imageTable { width: 100% }
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
	</script>
</head>
<body id="filebrowser" >	
 <div class="wrapper">
  <div id="maincontent">
	<div class="main" style="border:none;">
		<h3><?php echo i18n('UPLOADED_FILES'); ?><span id="filetypetoggle">&nbsp;&nbsp;/&nbsp;&nbsp;<?php echo ($type == 'images' ? i18n('IMAGES') : i18n('SHOW_ALL') ); ?></span></h3>
<?php
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

	echo '<div class="h5">/ <a href="?CKEditorFuncNum='.$CKEditorFuncNum.'&amp;type='.$type.'">uploads</a> / ';
	foreach ($pathParts as $pathPart){
		if ($pathPart!=''){
			$urlPath.=$pathPart."/";
			echo '<a href="?path='.$urlPath.'&amp;CKEditorFuncNum='.$CKEditorFuncNum.'&amp;type='.$type.'&amp;func='.$func.'">'.$pathPart.'</a> / ';
		}
	}
	echo "</div>";

	echo '<table class="highlight" id="imageTable">';

	if (count((array)$dirsSorted) != 0) {       
		foreach ((array)$dirsSorted as $upload) {
			echo '<tr class="All" >';  
			echo '<td class="" colspan="5">';
			$adm = substr($path . $upload['name'] ,  16); 
			if ($returnid!='') {
				$returnlink = '&returnid='.$returnid;
			} else {
				$returnlink='';
			}
			if ($func!='') {
				$funct = '&func='.$func;
			} else {
				$funct='';
			}
			echo '<a href="filebrowser.php?path='.$adm.'&amp;CKEditorFuncNum='.$CKEditorFuncNum.'&amp;type='.$type.$returnlink.'&amp;'.$funct.'" title="'. $upload['name'] .'"  ><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle; margin:0 10px" width="32" height="32" viewBox="0 0 48 48"><rect width="48" height="48" fill="none"/><path fill="#ffa000" d="M40 12H22l-4-4H8c-2.2 0-4 1.8-4 4v8h40v-4c0-2.2-1.8-4-4-4"/><path fill="#ffca28" d="M40 12H8c-2.2 0-4 1.8-4 4v20c0 2.2 1.8 4 4 4h32c2.2 0 4-1.8 4-4V16c0-2.2-1.8-4-4-4"/></svg> <strong>'.$upload['name'].'</strong></a>';
			echo '</td>';
			echo '</tr>';
		}
	}

	if (count($filesSorted) != 0) { 			
		foreach ($filesSorted as $upload) {
			$originalName = $upload['name'];
			$upload['name'] = rawurlencode($upload['name']);
			$thumb = null; $thumbnailLink = null;
			$subDir = ($subPath == '' ? '' : $subPath.'/');
			$selectLink = 'title="'.i18n_r('SELECT_FILE').': '. htmlspecialchars($originalName) .'" href="javascript:void(0)" onclick="submitLink('.$CKEditorFuncNum.',\''.$fullPath.$subDir.$upload['name'].'\')"';

			if ($type == 'images') {
				$fileExtension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
				
				// Include SVG files as images
				if ($upload['type'] == i18n_r('IMAGES') .' Images' || $fileExtension === 'svg') {
					# get internal thumbnail to show beside link in table
					$thumb = '<td class="imgthumb" style="display:table-cell;vertical-align:middle;" >';
					
					// Handle SVG files differently - use direct file instead of thumbnail
					if ($fileExtension === 'svg') {
						// For SVG files, use the original file as thumbnail with fixed dimensions
						$imgSrc = '<img src="../data/uploads/'. $subDir . $upload['name'] .'" width="85" height="65" style="vertical-align:middle; object-fit:cover;border-radius:3px" />';
					} else {
						// Regular image handling
						$thumbLink = $urlPath.'thumbsm.'.$upload['name'];
						if (file_exists('../data/thumbs/'.$thumbLink)) {
							$imgSrc='<img src="../data/thumbs/'. $thumbLink .'" width="85" height="65" style="object-fit:cover;border-radius:3px" />';
						} else {
							$imgSrc='<img src="inc/thumb.php?src='. $urlPath . $upload['name'] .'&amp;dest='. $thumbLink .'&amp;x=65&amp;f=1" width="85" height="65" style="object-fit:cover;border-radius:3px" />';
						}
					}
					
					$thumb .= '<a '.$selectLink.' >'.$imgSrc.'</a>';
					$thumb .= '</td>';
					
					# get external thumbnail link (skip for SVG files since they use the original)
					$thumbnailLink = '';
					if ($fileExtension !== 'svg') {
						$thumbLinkExternal = 'data/thumbs/'.$urlPath.'thumbnail.'.$upload['name'];
						if (file_exists('../'.$thumbLinkExternal)) {
							$thumbnailLink = '<span>&nbsp;&ndash;&nbsp;&nbsp;</span><a href="javascript:void(0)" onclick="submitLink('.$CKEditorFuncNum.',\''.$sitepath.$thumbLinkExternal.'\')">'.i18n_r('THUMBNAIL').'</a>';
						}
					}
				}
				else { continue; }
			}

			$counter++;	

			echo '<tr class="All '.$upload['type'].'" >';
			echo ($thumb=='' ? '<td style="display: none"></td>' : $thumb);
			echo '<td style="vertical-align:middle;"><a '.$selectLink.' class="primarylink">'.htmlspecialchars($originalName) .'</a>'.$thumbnailLink.'</td>';
			echo '<td style="width:80px;text-align:right;vertical-align:middle;" ><span>'. $upload['size'] .'</span></td>';

			// get the file permissions.
			if ($isUnixHost && isDebug() && function_exists('posix_getpwuid')) {
				$filePerms = substr(sprintf('%o', fileperms($path.$upload['name'])), -4);
				$fileOwner = posix_getpwuid(fileowner($path.$upload['name']));
				echo '<td style="width:70px;text-align:right;vertical-align:middle;"><span>'.$fileOwner['name'].'/'.$filePerms.'</span></td>';
			}

			echo '<td style="width:85px;text-align:right;vertical-align:middle;" ><span>'. shtDate($upload['date']) .'</span></td>';
			echo '</tr>';
		}

	}
	echo '</table>';
	echo '<p><em><b>'. $counter .'</b> '.i18n_r('TOTAL_FILES').' ('. fSize($totalsize) .')</em></p>';
?>	
	</div>
  </div>
 </div>	
</body>
</html>