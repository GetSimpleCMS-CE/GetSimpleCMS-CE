<?php
/**
 * Components
 *
 * Displays and creates static components 	
 *
 * @package GetSimple
 * @subpackage Components
 * @link https://github.com/GetSimpleCMS-CE/GetSimpleCMS-CE/wiki/Components
 */
 
# setup inclusions
$load['plugin'] = true;
include('inc/common.php');

# variable settings
$userid 	= login_cookie_check();
$file 		= "components.xml";
$path 		= GSDATAOTHERPATH;
$bakpath 	= GSBACKUPSPATH .'other/';
$update 	= ''; $table = ''; $list='';

# Security function to check for dangerous PHP
function containsDangerousPHP($content) { 
	$dangerousFunctions = array( 
		'exec', 'passthru', 'shell_exec', 'system', 'popen', 'proc_open', 'pcntl_exec', 'eval', 'assert', 'create_function', 'preg_replace', 'preg_replace_callback', 'include', 'include_once', 'require', 'require_once', 'dl', 'call_user_func', 'call_user_func_array', 'ReflectionFunction', 'ob_start', 'assert_options', 'mail', 'header', 'putenv', 'ini_set', 'fopen', 'tmpfile', 'bzopen', 'gzopen', 'SplFileObject', 'chgrp', 'chmod', 'chown', 'copy', 'file_put_contents', 'lchgrp', 'lchown', 'link', 'mkdir', 'move_uploaded_file', 'rename', 'rmdir', 'symlink', 'tempnam', 'touch', 'unlink', 'file_exists', 'file_get_contents', 'file', 'fileatime', 'filectime', 'filegroup', 'fileinode', 'filemtime', 'fileowner', 'fileperms', 'filesize', 'filetype', 'glob', 'is_dir', 'is_executable', 'is_file', 'is_link', 'is_readable', 'is_uploaded_file', 'is_writable', 'linkinfo', 'lstat', 'parse_ini_file', 'pathinfo', 'readfile', 'readlink', 'realpath', 'stat', 'gzfile', 'readgzfile', 'getimagesize', 'imagecreatefromgif', 'imagecreatefromjpeg', 'imagecreatefrompng', 'imagecreatefromwbmp', 'imagecreatefromxbm', 'imagecreatefromxpm', 'ftp_get', 'ftp_nb_get', 'ftp_put', 'ftp_nb_put', 'exif_read_data', 'read_exif_data', 'exif_thumbnail', 'exif_imagetype', 'hash_file', 'hash_hmac_file', 'hash_update_file', 'md5_file', 'sha1_file', 'highlight_file', 'show_source', 'php_strip_whitespace', 'get_meta_tags', 'proc_nice', 'proc_terminate', 'proc_close', 'pfsockopen', 'fsockopen', 'apache_child_terminate', 'posix_kill', 'posix_mkfifo', 'posix_setpgid', 'posix_setsid', 'posix_setuid' 
	);
	
	foreach ($dangerousFunctions as $func) {
		if (stripos($content, $func . '(') !== false) {
			return true;
		}
	}
	
	return false;
}

# check to see if form was submitted
if (isset($_POST['submitted'])){
	$value = @$_POST['val'];
	$slug = @$_POST['slug'];
	$title = @$_POST['title'];
	$ids = @$_POST['id'];
	
	if($ids==""){
		$ids = [];
	};
	
	// check for csrf
	if (!defined('GSNOCSRF') || (GSNOCSRF == FALSE) ) {
		$nonce = $_POST['nonce'];	
		if(!check_nonce($nonce, "modify_components")) {
			die("CSRF detected!");
		}
	}

	// Security check for dangerous PHP in component values
	if (is_array($value)) {
		foreach ($value as $val) {
			if (containsDangerousPHP($val)) {
				die("Security violation: Dangerous PHP content detected");
			}
		}
	} elseif (containsDangerousPHP($value)) {
		die("Security violation: Dangerous PHP content detected");
	}

	# create backup file for undo	   
	createBak($file, $path, $bakpath);
	
	# start creation of top of components.xml file
	$xml = new SimpleXMLExtended('<?xml version="1.0" encoding="UTF-8"?><channel></channel>');
	if (count($ids) != 0) { 
		
		$ct = 0; $coArray = [];
		foreach ($ids as $id)		{
			if ($title[$ct] != null) {
				if ( $slug[$ct] == null )	{
					$slug_tmp = to7bit($title[$ct], 'UTF-8');
					$slug[$ct] = clean_url($slug_tmp); 
					$slug_tmp = '';
				}
				
				$coArray[$ct]['id'] = $ids[$ct];
				$coArray[$ct]['slug'] = xss_clean($slug[$ct]);
				$coArray[$ct]['title'] = safe_slash_html($title[$ct]);
				$coArray[$ct]['value'] = safe_slash_html($value[$ct]);
				
			}
			$ct++;
		}
		
		$ids = subval_sort($coArray,'title');
		
		$count = 0;
		foreach ($ids as $comp)	{
			# create the body of components.xml file
			$components = $xml->addChild('item');
			$c_note = $components->addChild('title');
			$c_note->addCData($comp['title']);
			$components->addChild('slug', $comp['slug']);
			$c_note = $components->addChild('value');
			$c_note->addCData($comp['value']);
			$count++;
		}
	}
	exec_action('component-save');
	XMLsave($xml, $path . $file);
	redirect('components.php?upd=comp-success');
}

# if undo was invoked
if (isset($_GET['undo'])) { 
	
	# check for csrf
	$nonce = $_GET['nonce'];	
	if(!check_nonce($nonce, "undo")) {
		die("CSRF detected!");
	}
	
	# perform the undo
	undo($file, $path, $bakpath);
	redirect('components.php?upd=comp-restored');
}

# create components form html
$data = getXML($path . $file);
$componentsec = $data->item;
$count= 0;
if (count($componentsec) != 0) {
	foreach ($componentsec as $component) {
		$table .= '<div class="compdiv" id="section-'.$count.'"><table class="comptable" ><tr><td><b title="'.i18n_r('DOUBLE_CLICK_EDIT').'" class="editable">'. stripslashes($component->title) .'</b></td>';
		$table .= '
		<td style="text-align:center;" >
			<span id="' . stripslashes($component->title) . '_c" class="shortcode tpl">&#60;?php get_component("' . $component->slug . '"); ?></span>
			<a href="javascript:;" class="copybutton">
			<image id="copy-' . htmlspecialchars($component->title, ENT_QUOTES, 'UTF-8') . '" data-clipboard-target="#' . htmlspecialchars($component->title, ENT_QUOTES, 'UTF-8') . '" src=" data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAQAAABKfvVzAAAAIGNIUk0AAHomAACAhAAA+gAAAIDoAAB1MAAA6mAAADqYAAAXcJy6UTwAAAACYktHRAAAqo0jMgAAAAlwSFlzAAAAYAAAAGAA8GtCzwAAAAd0SU1FB+cFFgkEJsO3fd8AAADQSURBVDjLvZM7CsJAFEWP0SKSUlJoOi2yiDSJK3ALFindUMBSV2HAzyJEQVHxU0gqm5QWAXWSyWdAPeV9c7nzLjPwa2pS1cPHFJQ7AXMATXp8hpPSHELcvNQpR/SUpnNikpfQZk+c0mJ2dAAaEsOjaGmZYahqiKoYCooU0VSLTBJ8ztipZnS2+NkMrbxIAJr0uOYtLdJijIGNRfBOKGeFx6JaQsQgu4MC/zLc6GYe9KtIkeTHuYRc2AgTG4t+0swndQAOLDAxhMmaEUvVC3+DJ4xiLDPLiEozAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDIzLTA1LTIyVDA5OjA0OjM4KzAwOjAwa+wQugAAACV0RVh0ZGF0ZTptb2RpZnkAMjAyMy0wNS0yMlQwOTowNDozOCswMDowMBqxqAYAAAAodEVYdGRhdGU6dGltZXN0YW1wADIwMjMtMDUtMjJUMDk6MDQ6MzgrMDA6MDBNpInZAAAAAElFTkSuQmCC"></a>
			<script>
				document.getElementById("copy-' . stripslashes($component->title) . '").addEventListener("click", copyCodeToClipboard);
				function copyCodeToClipboard() {
				  const codeSnippet = document.getElementById("' .  htmlspecialchars($component->title, ENT_QUOTES, 'UTF-8') . '_c");
				  const range = document.createRange();
				  range.selectNode(codeSnippet);
				  const selection = window.getSelection();
				  selection.removeAllRanges();
				  selection.addRange(range);
				  document.execCommand("copy");
				  selection.removeAllRanges();
				}
			</script>
		</td><td class="delete" >';
		$table .= '<a href="#" title="'.i18n_r('DELETE_COMPONENT').': '. cl($component->title).'?" class="delcomponent" rel="'.$count.'" >&times;</a></td></tr></table>';
		$table .= '<textarea name="val[]">'. stripslashes($component->value) .'</textarea>';
		$table .= '<input type="hidden" class="compslug" name="slug[]" value="'. $component->slug .'" />';
		$table .= '<input type="hidden" class="comptitle" name="title[]" value="'. stripslashes($component->title) .'" />';
		$table .= '<input type="hidden" name="id[]" value="'. $count .'" />';
		exec_action('component-extras');
		$table .= '</div>';
		$count++;
	}
}
	# create list to show on sidebar for easy access
	$listc = ''; $submitclass = '';
	if($count > 1) {
		$item = 0;
		foreach($componentsec as $component) {
			$listc .= '<a id="divlist-' . $item . '" href="#section-' . $item . '" class="component">' . $component->title . '</a>';
			$item++;
		}
	} elseif ($count == 0) {
		$submitclass = 'hidden';
		
	}

get_template('header', cl($SITENAME).' &raquo; '.i18n_r('COMPONENTS')); 

?>
	
<?php include('template/include-nav.php'); ?>

<script>
const delmsg = '<?php echo i18n_r('DELETE_COMPONENT');?>';
</script>

<div class="bodycontent clearfix">
	
	<div id="maincontent">
	<div class="main">
	<h3 class="floated"><?php echo i18n('EDIT_COMPONENTS');?></h3>
	<div class="edit-nav" >
		<a href="#" id="addcomponent" accesskey="<?php echo find_accesskey(i18n_r('ADD_COMPONENT'));?>" ><?php i18n('ADD_COMPONENT');?></a>
		<div class="clear"></div>
	</div>
	
	<form class="manyinputs" action="<?php myself(); ?>" method="post" accept-charset="utf-8" >
		<input type="hidden" id="id" value="<?php echo $count; ?>" />
		<input type="hidden" id="nonce" name="nonce" value="<?php echo get_nonce("modify_components"); ?>" />

		<div id="divTxt"></div> 
		<?php echo $table; ?>
		<p id="submit_line" class="<?php echo $submitclass; ?>" >
			<span><input type="submit" class="submit" name="submitted" id="button" value="<?php i18n('SAVE_COMPONENTS');?>" /></span> &nbsp;&nbsp;<?php i18n('OR'); ?>&nbsp;&nbsp; <a class="cancel" href="components.php?cancel"><?php i18n('CANCEL'); ?></a>
		</p>
	</form>
	</div>
	</div>
	
	<div id="sidebar">
		<?php include('template/sidebar-theme.php'); ?>
		<?php if ($listc != '') { echo '<div class="compdivlist">'.$listc .'</div>'; } ?>
	</div>

</div>
<script>// Save with ctrl+s
	document.addEventListener('keydown', function(e) {
		if ((e.ctrlKey || e.metaKey) && e.key === 's') {
			e.preventDefault();
			var saveButton = document.querySelector('input[name="submitted"][value="<?php i18n('SAVE_COMPONENTS');?>"]');
			if (saveButton) {
				saveButton.click();
			}
		}
	});
</script>
<?php get_template('footer'); ?>
