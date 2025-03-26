<link rel="stylesheet" href="<?php global $SITEURL;
echo $SITEURL; ?>plugins/massiveAdmin/css/w3.css">
<link rel="stylesheet" href="<?php global $SITEURL;
echo $SITEURL; ?>plugins/massiveAdmin/css/w3-custom.css">

<button onclick="myFunction('Tab6')" style="margin-top:10px"
	class=" w3-button w3-xlarge w3-round w3-block w3-gray w3-text-white w3-left-align w3-margin-bottom">
	<?php echo i18n_r('massiveAdmin/LOGINOPTIONS'); ?> <span class="w3-right"><svg xmlns="http://www.w3.org/2000/svg"
			width="22" height="22" viewBox="0 0 24 24">
			<path fill="currentColor" fill-rule="evenodd" d="m5 8l7 8l7-8z" />
		</svg></span></button>
<div id="Tab6" class="w3-hide w3-container">

	<div class="w3-container">
		<form action="#" method="post">
			<div class="w3-border-bottom w3-padding-32">
				<label style="padding-right:20px"
					for=""><?php echo i18n_r('massiveAdmin/SHOWPASSWORDQUESTION'); ?></label>
				<input class="w3-check" type="checkbox" name="showPassword" value="on" <?php echo (@file_get_contents(GSDATAOTHERPATH . 'MassiveShowPassword/status.txt') == 'on' ? 'checked' : ''); ?>>
			</div>
			<div class="w3-border-bottom w3-padding-32">
				<label style="padding-right:20px"
					for=""><?php echo i18n_r('massiveAdmin/REMOVEFORGETPASSWORDTITLE'); ?></label>
				<input class="w3-check" type="checkbox" name="removeForgetPassword" value="on" <?php echo (@file_get_contents(GSDATAOTHERPATH . 'MassiveShowForgetPassword/status.txt') == 'on' ? 'checked' : ''); ?>>
			</div>
			<div class="w3-margin-top w3-center">
				<button class="w3-btn w3-large w3-round w3-green" type="submit" name="removeForgetPasswordSave"
					value="<?php echo i18n_r('massiveAdmin/SAVESETTINGS'); ?>"><?php echo i18n_r('massiveAdmin/SAVESETTINGS'); ?></button>
			</div>
		</form>
	</div>
</div>

<?php
if (isset($_POST['removeForgetPasswordSave'])) {
	global $MA;
	$MA->showPassword();

	global $MA;
	$MA->removeForgetPassword();

	echo '<div class="doneMassive" style="background:green; width:100%; text-align:center; padding:10px; border-radius:3px; color:#fff;">Done</div>';
	echo ("<meta http-equiv='refresh' content='1'>");
};
?>