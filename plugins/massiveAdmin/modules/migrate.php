<?php global $SITEURL; ?>

<link rel="stylesheet" href="<?php global $SITEURL; echo $SITEURL; ?>plugins/massiveAdmin/css/w3.css">
<link rel="stylesheet" href="<?php global $SITEURL; echo $SITEURL; ?>plugins/massiveAdmin/css/w3-custom.css">

<div class="w3-parent"><!-- Start Plug -->

<?php 
if (isset($_POST['replaceMassiveUrl'])) {
	global $MA;
	$MA->migrateMassive();

	echo '
	<div class="w3-panel w3-green w3-round">
		<h4 class="w3-text-white">Success!</h4>
	</div>';

	echo ("<meta http-equiv='refresh' content='1'>");
}; 
?>

<?php if (isset($_POST['forceSSLturnon'])) {
	global $MA;
	$MA->forceSSL();

	echo '
	<div class="w3-panel w3-green w3-round">
		<h4 class="w3-text-white">Success!</h4>
	</div>';

	echo ("<meta http-equiv='refresh' content='1'>");
}; 
?>
<div class="w3-row">

	<div class="w3-half">
		<h3><?php echo i18n_r('massiveAdmin/MIGRATEDOMAIN'); ?></h3>
		<hr>
		<form action="#" method="POST" style="width:85%">
		
			<label for="newurl"><?php echo i18n_r('massiveAdmin/OLDDOMAIN'); ?>:</label>
			<input class="w3-input w3-padding w3-border w3-round w3-margin-bottom" type="text" value="<?php echo $SITEURL; ?>" placeholder="<?php echo i18n_r('massiveAdmin/OLDDOMAIN'); ?>" name="oldMassiveUrl">

			<label for="newurl"><?php echo i18n_r('massiveAdmin/NEWDOMAIN'); ?>:</label>
			<input class="w3-input w3-padding w3-border w3-round w3-margin-bottom" text="text" value="" placeholder="<?php echo i18n_r('massiveAdmin/NEWDOMAIN'); ?>" name="newMassiveUrl">

			<button class="w3-btn w3-green w3-large w3-round" type="submit" name="replaceMassiveUrl"><?php echo i18n_r('massiveAdmin/REPLACEDOMAIN'); ?></button>
		</form>
	</div>

	<div class="w3-rest" xstyle="width:46%">
		<h3><?php echo i18n_r('massiveAdmin/FORCESSL'); ?></h3>
		<hr>
		<form action="#" method="POST" style="width:85%">
			
			<label for=""><?php echo i18n_r('massiveAdmin/TURNONSSL'); ?></label>
			<input class="w3-check" type="checkbox" name="turnon" value="on" <?php echo (@file_get_contents(GSDATAOTHERPATH . 'MassiveForceSSL/status.txt') == 'on' ? 'checked' : ''); ?>>
			<br>
			<button class="w3-btn w3-green w3-large w3-round w3-margin-top" type="submit" name="forceSSLturnon"><?php echo i18n_r('massiveAdmin/SAVESSL'); ?></button>
		</form>
	</div>
</div>