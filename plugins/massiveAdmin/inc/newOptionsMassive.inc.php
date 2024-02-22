<style>
	@import url('<?php global $SITEURL;
					echo $SITEURL; ?>plugins/massiveAdmin/css/newOptionsMassive.css');
</style>




<div class="rename-fog hide-fog">
	<div class="form-rename">
		<form class="form-form-rename" action="#" method="post">

			<input type="text" name="rename-massive-hide" style="display:none">

			<input type="text" name="rename-massive">
			<input type="submit" name="save-rename-massive" class="submit" value="<?php echo i18n_r("massiveAdmin/RENAMEFILE"); ?>">
			<input type="submit" name="copy-rename-massive" class="submit" value="<?php echo i18n_r("massiveAdmin/COPYFILE"); ?>">
			<button class="close-rename-fog">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="times" style="width:20px;height:20px;padding:0;"><path fill="#fff" d="M13.41,12l4.3-4.29a1,1,0,1,0-1.42-1.42L12,10.59,7.71,6.29A1,1,0,0,0,6.29,7.71L10.59,12l-4.3,4.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l4.29,4.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path></svg></button>
		</form>
	</div>
</div>

 


<script src="<?php echo $SITEURL; ?>plugins/massiveAdmin/js/newOptionsMassive.js?v=2"></script>




<?php

if (isset($_POST['deleteFileList'])) {
	global $MA;
	$MA->deleteFileList();
};

if (isset($_POST['save-rename-massive'])) {
	global $MA;

	$MA->saveRename();
}

if (isset($_POST['copy-rename-massive'])) {
	global $MA;

	$MA->copyRename();
};

?>