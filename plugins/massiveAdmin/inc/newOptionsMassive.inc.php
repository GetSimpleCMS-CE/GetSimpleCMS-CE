<?php
// ADDED: Generate CSRF tokens
$copy_nonce = MassiveAdminClass::generate_nonce('copy_rename');
$delete_nonce = MassiveAdminClass::generate_nonce('delete_file');
$upload_nonce = MassiveAdminClass::generate_nonce('upload_file');
$save_nonce = MassiveAdminClass::generate_nonce('save_rename');
?>

<style>
	@import url('<?php global $SITEURL;
	echo $SITEURL; ?>plugins/massiveAdmin/css/newOptionsMassive.css');
</style>

<div class="rename-fog hide-fog">
	<div class="form-rename">
		<form class="form-form-rename" action="#" method="post">
			<!-- ADDED: CSRF token field -->
			<input type="hidden" name="nonce" value="<?php echo htmlspecialchars($copy_nonce); ?>">
			
			<input type="text" name="rename-massive-hide" style="display:none">
			<input type="text" name="rename-massive">
			<input type="submit" name="save-rename-massive" class="submit" value="<?php echo i18n_r("massiveAdmin/RENAMEFILE"); ?>">
			<input type="submit" name="copy-rename-massive" class="submit" value="<?php echo i18n_r("massiveAdmin/COPYFILE"); ?>">
			<button class="close-rename-fog">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="times" style="width:20px;height:20px;padding:0;"><path fill="#fff" d="M13.41,12l4.3-4.29a1,1,0,1,0-1.42-1.42L12,10.59,7.71,6.29A1,1,0,0,0,6.29,7.71L10.59,12l-4.3,4.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l4.29,4.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path></svg></button>
		</form>
	</div>
</div>

<script src="<?php echo $SITEURL; ?>plugins/massiveAdmin/js/newOptionsMassive.js?v=6"></script>

<?php
// MODIFIED: Added CSRF checks before processing
if (isset($_POST['deleteFileList'])) {
	if (!isset($_POST['nonce']) || !MassiveAdminClass::verify_nonce($_POST['nonce'], 'delete_file')) {
		die('CSRF validation failed');
	}
	global $MA;
	$MA->deleteFileList();
};

if (isset($_POST['save-rename-massive'])) {
	if (!isset($_POST['nonce']) || !MassiveAdminClass::verify_nonce($_POST['nonce'], 'save_rename')) {
		die('CSRF validation failed');
	}
	global $MA;
	$MA->saveRename();
}

if (isset($_POST['copy-rename-massive'])) {
	if (!isset($_POST['nonce']) || !MassiveAdminClass::verify_nonce($_POST['nonce'], 'copy_rename')) {
		die('CSRF validation failed');
	}
	global $MA;
	$MA->copyRename();
};

// ADDED: Handle uploads with CSRF check
if (isset($_POST['massiveUpload'])) {
	if (!isset($_POST['nonce']) || !MassiveAdminClass::verify_nonce($_POST['nonce'], 'upload_file')) {
		die('CSRF validation failed');
	}
	global $MA;
	$MA->massiveUpload();
}
?>