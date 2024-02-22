<?php
global $SITEURL;
$filename      = GSDATAOTHERPATH . '/massiveadmin/massiveOption.json';
$chmod_mode    = 0755;

if (file_exists($filename)) {
	$datee = file_get_contents($filename);
	$data = json_decode($datee);
}
?>

<style>
	@import url('<?php echo $SITEURL; ?>plugins/massiveAdmin/css/massiveOption.css');
</style>

<div class="massiveoption">

	<div class="hidetitle" id="hidetitle1">
		<h3><?php echo i18n_r('massiveAdmin/MAITENANCETITLE'); ?></h3> 
		<svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 24 24" id="arrow-down" style="display:inline-block;width:20px;"><path fill="var(--main-color)" d="M17.71,11.29a1,1,0,0,0-1.42,0L13,14.59V7a1,1,0,0,0-2,0v7.59l-3.29-3.3a1,1,0,0,0-1.42,1.42l5,5a1,1,0,0,0,.33.21.94.94,0,0,0,.76,0,1,1,0,0,0,.33-.21l5-5A1,1,0,0,0,17.71,11.29Z"></path></svg>

	</div>

	<div class="hidecontent hidecontent1">
		<form action="#" method="post">
			<label for="maintence"><?php echo i18n_r("massiveAdmin/MAINTENANCE_ON"); ?></label>
			<select name="maintence" class="maintenceselect" id="">
				<option value="no"><?php echo i18n_r("massiveAdmin/NO") ?></option>
				<option value="yes"><?php echo i18n_r("massiveAdmin/YES") ?></option>
			</select>

			<label for="content"><?php echo i18n_r("massiveAdmin/CONTENT_MAINTENANCE_MODE"); ?></label>
			<textarea name="content" class="ckeditors"><?php echo $data->maintencecontent ?? ''; ?></textarea>
			<br>
			<input type="submit" name="save-option" style="width: 100%; padding: 10px; margin-top: 20px; background: #000 !important; color: #fff; border: none; border-radius: 5px;" value="<?php echo i18n_r("massiveAdmin/SAVEOPTION"); ?>" class="submit">
	</div>

	<div class="hidetitle" id="hidetitle2">
		<h3><?php echo i18n_r('massiveAdmin/BOOTSTRAPTITLE'); ?></h3>
		
		<svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 24 24" id="arrow-down" style="display:inline-block;width:20px;"><path fill="var(--main-color)" d="M17.71,11.29a1,1,0,0,0-1.42,0L13,14.59V7a1,1,0,0,0-2,0v7.59l-3.29-3.3a1,1,0,0,0-1.42,1.42l5,5a1,1,0,0,0,.33.21.94.94,0,0,0,.76,0,1,1,0,0,0,.33-.21l5-5A1,1,0,0,0,17.71,11.29Z"></path></svg>

	</div>

	<div class="hidecontent hidecontent2">
		<label for="grid" style="margin-top:10px"><?php echo i18n_r("massiveAdmin/TURNONBOOTSTRAPGRID"); ?></label>
		<select name="grid" class="gridselect" id="">
			<option value="no"><?php echo i18n_r("massiveAdmin/NO"); ?></option>
			<option value="yes"><?php echo i18n_r("massiveAdmin/YES"); ?></option>
		</select>

		<label for="gridfront" style="margin-top:10px"> <?php echo i18n_r("massiveAdmin/TURNONBOOTSTRAPGRIDONTHEME"); ?></label>
		<select name="gridfront" class="gridselectfront" id="">
			<option value="no"><?php echo i18n_r("massiveAdmin/NO"); ?></option>
			<option value="yes"> <?php echo i18n_r("massiveAdmin/YES"); ?></option>
		</select>

		<input type="submit" name="save-option" style="width: 100%; padding: 10px; margin-top: 20px; background: #000 !important; color: #fff; border: none; border-radius: 5px;" value="<?php echo i18n_r("massiveAdmin/SAVEOPTION"); ?>" class="submit">
		</form>
	</div>

	<script type="text/javascript" src="template/js/ckeditor/ckeditor.js"></script>

	<?php

	global $EDTOOL;
	global $EDOPTIONS;

	if (isset($EDTOOL)) $EDTOOL = returnJsArray($EDTOOL);
	if (isset($toolbar)) $toolbar = returnJsArray($toolbar); // handle plugins that corrupt this

	else if (strpos(trim($EDTOOL), '[[') !== 0 && strpos(trim($EDTOOL), '[') === 0) {
		$EDTOOL = "[$EDTOOL]";
	}

	if (isset($toolbar) && strpos(trim($toolbar), '[[') !== 0 && strpos($toolbar, '[') === 0) {
		$toolbar = "[$toolbar]";
	}
	$toolbar = isset($EDTOOL) ? ",toolbar: " . trim($EDTOOL, ",") : '';
	$options = isset($EDOPTIONS) ? ',' . trim($EDOPTIONS, ",") : '';

	?>

	<script>
		const ckeditorReplace = document.querySelector(".ckeditors");
		var editor = CKEDITOR.replace(ckeditorReplace, {
			skin: 'getsimple',
			forcePasteAsPlainText: true,
			defaultLanguage: 'en',
			entities: false,
			// uiColor : '#FFFFFF',
			height: '300px',
			baseHref: '<?php global $SITEURL;
						echo $SITEURL; ?>',
			tabSpaces: 10,
			filebrowserBrowseUrl: 'filebrowser.php?type=all',
			filebrowserImageBrowseUrl: 'filebrowser.php?type=images',
			filebrowserWindowWidth: '730',
			filebrowserWindowHeight: '500'
			<?php echo $toolbar; ?>
			<?php echo $options; ?>
		});
	</script>

	<script src="<?php echo $SITEURL; ?>plugins/massiveAdmin/js/massiveOption.js"></script>

</div>

<?php
if (file_exists($filename)) {
	if ($data->maintence == 'yes') {
		echo '<script>document.querySelector(".maintenceselect").value = "yes"</script></script>';
	} else {
		echo '<script>document.querySelector(".maintenceselect").value = "no"</script></script>';
	};
	if ($data->grid == 'yes') {
		echo '<script>document.querySelector(".gridselect").value = "yes"</script></script>';
	} else {
		echo '<script>document.querySelector(".gridselect").value = "no"</script></script>';
	};
	if ($data->gridfront == 'yes') {
		echo '<script>document.querySelector(".gridselectfront").value = "yes"</script></script>';
	} else {
		echo '<script>document.querySelector(".gridselectfront").value = "no"</script></script>';
	};
};

if (isset($_POST['save-option'])) {
	global $MA;
	$MA->saveMassiveOption();
};
?>