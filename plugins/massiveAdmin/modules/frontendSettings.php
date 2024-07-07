<?php
$checkTurnOn = @file_get_contents(GSDATAOTHERPATH . 'massiveToperSettings/turnon.txt');
$styleFile = @file_get_contents(GSDATAOTHERPATH . 'massiveToperSettings/style.txt');
?>

<link rel="stylesheet" href="<?php global $SITEURL; echo $SITEURL; ?>plugins/massiveAdmin/css/w3.css">
<link rel="stylesheet" href="<?php global $SITEURL; echo $SITEURL; ?>plugins/massiveAdmin/css/w3-custom.css">

<div class="w3-parent w3-container"><!-- Start Plug -->

<h3>FrontEnd Settings</h3>
<hr>

<form action="#" method="POST">

	<div class="w3-margin-bottom w3-padding-large w3-center w3-panel w3-gs-main w3-round">
		<label class="w3-text-white" style="font-weight:600; padding-right:20px"><?php echo i18n_r("massiveAdmin/TURNONMTOPER"); ?></label>
		<input class="w3-check checkbox" style="margin-right:10px;" type="checkbox" name="turnon" <?php echo ($checkTurnOn == 'on' ? 'checked' : ''); ?> value="on">
	</div>
	
	<br>
	
	<label for=""><?php echo  i18n_r("massiveAdmin/STYLEINFO"); ?></label>
	<select class="w3-select w3-border style" style="padding:10px; width:98%" name="style" id="">
		<?php
		foreach (glob(GSPLUGINPATH . 'massiveAdmin/toper-theme/*.css') as $style) {
			$name = pathinfo($style)['filename'];
			echo '<option value="' . $name . '" >' . $name . '</option>';
		};
		?>
	</select>
	
	<div class="w3-margin-top w3-center">
		<button class="w3-btn w3-large w3-round w3-green" type="submit" value="<?php echo i18n_r('massiveAdmin/SAVEOPTION'); ?>" name="savesettings"><?php echo i18n_r('massiveAdmin/SAVEOPTION'); ?></button>
	</div>
</form>

<?php if (file_exists(GSDATAOTHERPATH . 'massiveToperSettings/style.txt')) : ?>

<script>
	document.querySelector('.style').value = '<?php echo $styleFile; ?>';
</script>

<?php endif; ?>

<?php
if (isset($_POST['savesettings'])) {
	global $MA;
	$MA->mtoperSetting();
};
?>