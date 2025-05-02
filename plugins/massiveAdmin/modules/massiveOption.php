<?php
global $SITEURL;
$filename = GSDATAOTHERPATH . '/massiveadmin/massiveOption.json';
$chmod_mode = 0755;

if (file_exists($filename)) {
	$datee = file_get_contents($filename);
	$data = json_decode($datee);
}
?>

<link rel="stylesheet" href="<?php global $SITEURL;
echo $SITEURL; ?>plugins/massiveAdmin/css/w3.css">
<link rel="stylesheet" href="<?php global $SITEURL;
echo $SITEURL; ?>plugins/massiveAdmin/css/w3-custom.css">
<style>
	.w3-block,
	.w3-select {
		width: 96%;
		box-sizing: border-box;
	}
</style>

<div class="w3-parent w3-container" style="padding:10px;box-sizing:border-box !important"><!-- Start Plug -->

	<h3><?php echo i18n_r('massiveAdmin/MASSIVEADMINSETTINGSTITLE'); ?></h3>
	<hr>

	<button onclick="myFunction('Tab1')"
		class="w3-button w3-xlarge w3-round w3-block w3-gray w3-text-white w3-left-align w3-margin-bottom" style="box-sizing: border-box !important;"><span
			class="w3-right"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24">
				<path fill="currentColor" fill-rule="evenodd" d="m5 8l7 8l7-8z" />
			</svg></span> <?php echo i18n_r('massiveAdmin/MASSIVEADMINSETTINGSTITLE'); ?></button>
	<div id="Tab1" class="w3-hide w3-container w3-margin-bottom" style="box-sizing: border-box !important;">
		<form action="#" method="post">
			<h3><?php echo i18n_r('massiveAdmin/MAITENANCETITLE'); ?></h3>
			<label for="maintence"><?php echo i18n_r("massiveAdmin/MAINTENANCE_ON"); ?></label>
			<select class="maintenceselect w3-select w3-padding w3-border w3-round w3-margin-bottom" name="maintence"
				id="">
				<option value="no"><?php echo i18n_r("massiveAdmin/NO") ?></option>
				<option value="yes"><?php echo i18n_r("massiveAdmin/YES") ?></option>
			</select>

			<label for="content"><?php echo i18n_r("massiveAdmin/CONTENT_MAINTENANCE_MODE"); ?></label>
			<textarea class="ckeditors w3-input w3-padding w3-border w3-round w3-margin-bottom"
				name="content"><?php echo $data->maintencecontent ?? ''; ?></textarea>

			<div class="w3-margin-top w3-center">
	
			</div>
	 

	<h3><?php echo i18n_r('massiveAdmin/BOOTSTRAPTITLE'); ?></h3>
			<label for="grid"><?php echo i18n_r("massiveAdmin/TURNONBOOTSTRAPGRID"); ?></label>
			<select class="gridselect w3-select w3-padding w3-border w3-round w3-margin-bottom" name="grid" id="">
				<option value="no"><?php echo i18n_r("massiveAdmin/NO"); ?></option>
				<option value="yes"><?php echo i18n_r("massiveAdmin/YES"); ?></option>
			</select>

			<label for="gridfront"> <?php echo i18n_r("massiveAdmin/TURNONBOOTSTRAPGRIDONTHEME"); ?></label>
			<select class="gridselectfront w3-select w3-padding w3-border w3-round w3-margin-bottom" name="gridfront"
				id="">
				<option value="no"><?php echo i18n_r("massiveAdmin/NO"); ?></option>
				<option value="yes"> <?php echo i18n_r("massiveAdmin/YES"); ?></option>
			</select>

			<div class="w3-margin-top w3-center">
				<button class="w3-btn w3-large w3-round w3-green" type="submit" name="save-option">
					<?php echo i18n_r("massiveAdmin/SAVEOPTION"); ?>
				</button>
			</div>
		</form></div>
	

	<script type="text/javascript" src="template/js/ckeditor/ckeditor.js"></script>

	<?php
	global $EDTOOL;
	global $EDOPTIONS;

	if (isset($EDTOOL))
		$EDTOOL = returnJsArray($EDTOOL);
	if (isset($toolbar))
		$toolbar = returnJsArray($toolbar); // handle plugins that corrupt this
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

	<script>
		function myFunction(id) {
			var x = document.getElementById(id);
			if (x.className.indexOf("w3-show") == -1) {
				x.className += " w3-show";
				x.previousElementSibling.className =
					x.previousElementSibling.className.replace("w3-gray", "w3-gs-main");
			} else {
				x.className = x.className.replace(" w3-show", "");
				x.previousElementSibling.className =
					x.previousElementSibling.className.replace("w3-gs-main", "w3-gray");
			}
		}
	</script>

	<?php
	if (file_exists($filename)) {
		if ($data->maintence == 'yes') {
			echo '<script>document.querySelector(".maintenceselect").value = "yes"</script></script>';
		} else {
			echo '<script>document.querySelector(".maintenceselect").value = "no"</script></script>';
		}
		;
		if ($data->grid == 'yes') {
			echo '<script>document.querySelector(".gridselect").value = "yes"</script></script>';
		} else {
			echo '<script>document.querySelector(".gridselect").value = "no"</script></script>';
		}
		;
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