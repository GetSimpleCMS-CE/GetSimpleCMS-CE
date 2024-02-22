<?php global $SITEURL; ?>

<form action="#" method="POST" style="border:solid 1px #ddd;background:#fafafa;padding:10px;box-sizing:border-box;">
	<h3><?php echo i18n_r('massiveAdmin/MIGRATEDOMAIN'); ?></h3>
	<hr>
	<label for="newurl" style="font-size:1rem;margin:10px 0;font-weight:400;"><?php echo i18n_r('massiveAdmin/OLDDOMAIN'); ?></label>
	<input type="text" value="<?php echo $SITEURL; ?>" style="width:100%;padding:10px;box-sizing:border-box;" placeholder="<?php echo i18n_r('massiveAdmin/OLDDOMAIN'); ?>" name="oldMassiveUrl">

	<label for="newurl" style="font-size:1rem;margin:10px 0;font-weight:400;"><?php echo i18n_r('massiveAdmin/NEWDOMAIN'); ?></label>
	<input text="text" value="" style="width:100%;padding:10px;box-sizing:border-box;" placeholder="<?php echo i18n_r('massiveAdmin/NEWDOMAIN'); ?>" name="newMassiveUrl">

	<input type="submit" name="replaceMassiveUrl" style="color: #ffffff !important; text-decoration: none; text-shadow: none !important; background: #000 !important; border:solid 1px #ddd; padding:10px; border: none !important; margin-top:10px;" value="<?php echo i18n_r('massiveAdmin/REPLACEDOMAIN'); ?>">
</form>

<form action="#" method="POST" style="border:solid 1px #ddd;background:#fafafa;padding:10px;box-sizing:border-box;margin-top:20px;">
	<h3><?php echo i18n_r('massiveAdmin/FORCESSL'); ?></h3>
	<hr>
	<label for="">
		<?php echo i18n_r('massiveAdmin/TURNONSSL'); ?>
		<input type="checkbox" name="turnon" value="on" <?php echo (@file_get_contents(GSDATAOTHERPATH . 'MassiveForceSSL/status.txt') == 'on' ? 'checked' : ''); ?>>
	</label>

	<input type="submit" name="forceSSLturnon" style="color: #ffffff !important; text-decoration: none; text-shadow: none !important; background: #000 !important; border:solid 1px #ddd; padding:10px; border: none !important; margin-top:10px;" value="<?php echo i18n_r('massiveAdmin/SAVESSL'); ?>">
</form>

<?php 
if (isset($_POST['replaceMassiveUrl'])) {
	global $MA;
	$MA->migrateMassive();

	echo '<div class="doneMassive" style="background:green;width:100%;text-align:center;padding:10px;border-radius:3px;color:#fff;">Done</div>';

	echo ("<meta http-equiv='refresh' content='1'>");
}; 
?>

<?php if (isset($_POST['forceSSLturnon'])) {
	global $MA;
	$MA->forceSSL();

	echo '
	<div class="doneMassive" style="background:green; width:100%; text-align:center; padding:10px; border-radius:3px; color:#fff;">Done</div>';

	echo ("<meta http-equiv='refresh' content='1'>");
}; ?>