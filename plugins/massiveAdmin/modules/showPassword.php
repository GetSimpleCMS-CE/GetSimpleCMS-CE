<form action="#" method="post" style="padding:10px;background:#fafafa;border:solid 1px #ddd;box-sizing:border-box;">

	<h3><?php echo  i18n_r('massiveAdmin/TURNONSHOWPASSWORDTITLE'); ?></h3>
	<hr>
	<label for="">
		<?php echo i18n_r('massiveAdmin/SHOWPASSWORDQUESTION'); ?>
		<input type="checkbox" name="showPassword" value="on" <?php echo (@file_get_contents(GSDATAOTHERPATH . 'MassiveShowPassword/status.txt') == 'on' ? 'checked' : ''); ?>>
	</label>
 
	<br>

	<h3><?php echo  i18n_r('massiveAdmin/REMOVEFORGETPASSWORDTITLE'); ?></h3>
	<hr>
	<label for="">
		<?php echo  i18n_r('massiveAdmin/REMOVEFORGETPASSWORDTITLE'); ?>
		<input type="checkbox" name="removeForgetPassword" value="on" <?php echo (@file_get_contents(GSDATAOTHERPATH . 'MassiveShowForgetPassword/status.txt') == 'on' ? 'checked' : ''); ?>>
	</label>
	<br>
	<input type="submit" name="removeForgetPasswordSave" style="background:var(--main-color); color:#fff; padding:10px; margin-top:10px; border:none;" value="<?php echo  i18n_r('massiveAdmin/SAVESETTINGS'); ?>">

</form>

<?php if (isset($_POST['removeForgetPasswordSave'])) {

	global $MA;
	$MA->showPassword();

	global $MA;
	$MA->removeForgetPassword();

	echo '<div class="doneMassive" style="background:green; width:100%; text-align:center; padding:10px; border-radius:3px; color:#fff;">Done</div>';
	echo ("<meta http-equiv='refresh' content='1'>");
};

?>