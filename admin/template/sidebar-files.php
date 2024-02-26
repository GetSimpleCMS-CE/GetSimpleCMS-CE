<?php
/**
 * Sidebar Files Template
 *
 * @package GetSimple
 */
 
$path = (isset($_GET['path'])) ? $_GET['path'] : "";
?>
<ul class="snav">
	<li id="sb_upload" ><a href="upload.php" <?php check_menu('upload');  ?>><?php i18n('FILE_MANAGEMENT');?></a></li>
	<?php if(isset($_GET['i']) && $_GET['i'] != '') { ?><li id="sb_image" ><a href="#" class="current"><?php i18n('IMG_CONTROl_PANEL');?></a></li><?php } ?>
	
	<?php exec_action("files-sidebar"); ?>

	<li style="float:right;" id="sb_filesize" ><small><?php i18n('MAX_FILE_SIZE'); ?>: <strong><?php echo (toBytes(ini_get('upload_max_filesize'))/1024)/1024; ?>MB</strong></small></li>
</ul>

<form class="uploadform" action="upload.php?path=<?php echo $path; ?>" method="post" enctype="multipart/form-data">
	<p><input type="file" name="file[]" id="file" style="width:220px;" multiple /></p>
	<input type="hidden" name="hash" id="hash" value="<?php echo $SESSIONHASH; ?>" />
	<input type="submit" class="submit" name="submit" value="<?php i18n('UPLOAD'); ?>" />
</form>

<!-- show normal upload form if javascript is turned off -->
<noscript>
	<form class="uploadform" action="upload.php?path=<?php echo $path; ?>" method="post" enctype="multipart/form-data">
		<p><input type="file" name="file[]" id="file" style="width:220px;" multiple /></p>
		<input type="hidden" name="hash" id="hash" value="<?php echo $SESSIONHASH; ?>" />
		<input type="submit" class="submit" name="submit" value="<?php i18n('UPLOAD'); ?>" />
	</form>
</noscript>
