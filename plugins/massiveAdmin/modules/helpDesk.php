<?php
$folder		= GSDATAOTHERPATH . '/massiveHelpDesk/';
$filename	  = $folder . 'helpdesk.json';
$chmod_mode	= 0755;

if (file_exists($filename)) {
	$datee = @file_get_contents($filename);
	$data = json_decode($datee);
}; 
?>

<?php 
global $EDTOOL;
global $EDOPTIONS;

if(isset($EDTOOL)) $EDTOOL = returnJsArray($EDTOOL);
if(isset($toolbar)) $toolbar = returnJsArray($toolbar); // handle plugins that corrupt this

else if(strpos(trim($EDTOOL),'[[')!==0 && strpos(trim($EDTOOL),'[')===0){ $EDTOOL = "[$EDTOOL]"; }

if(isset($toolbar) && strpos(trim($toolbar),'[[')!==0 && strpos($toolbar,'[')===0){ $toolbar = "[$toolbar]"; }
$toolbar = isset($EDTOOL) ? ",toolbar: ".trim($EDTOOL,",") : '';
$options = isset($EDOPTIONS) ? ','.trim($EDOPTIONS,",") : '';
?>

<?php error_reporting(E_ALL ^ E_NOTICE); ?>

<link rel="stylesheet" href="<?php global $SITEURL; echo $SITEURL; ?>plugins/massiveAdmin/css/w3.css">
<link rel="stylesheet" href="<?php global $SITEURL; echo $SITEURL; ?>plugins/massiveAdmin/css/w3-custom.css">

<div class="w3-parent w3-container"><!-- Start Plug -->

<h3><?php echo i18n_r('massiveAdmin/USERHELPTITLE'); ?></h3>

<hr>

<form action="#" method="POST">
	<div class="w3-margin-bottom w3-padding-large w3-center w3-panel w3-gs-main w3-round">
		<label class="w3-text-white" style="font-weight:600; padding-right:20px"><?php echo i18n_r('massiveAdmin/TURNON'); ?></label>
		<input class="w3-check checkbox" style="margin-right:10px;" type="checkbox" name="checkbox" value="true">
	</div>

	<textarea name="helper" class="ckeditors">
<?php
if (file_exists($filename)) {
	echo $data->content;
};
?>
	</textarea>
	
	<div class="w3-margin-top w3-center">
		<button class="w3-btn w3-large w3-round w3-green" type="submit" value="<?php echo i18n_r('massiveAdmin/SAVEOPTION'); ?>" name="savehelpinfo"><?php echo i18n_r('massiveAdmin/SAVEOPTION'); ?></button>
	</div>
</form>

<script type="text/javascript" src="template/js/ckeditor/ckeditor.js"></script>

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

	const json = `<?php echo @file_get_contents($filename); ?>`;

	if ('<?php if (isset($data->checkbox)) {
				echo $data->checkbox;
			}; ?>' == "true") {
		document.querySelector('.checkbox').checked = true;
	} else {
		document.querySelector('.checkbox').checked = false;
	}
</script>

<?php
if (isset($_POST['savehelpinfo'])) {
	global $MA;
	$MA->saveHelpInfo();
};
?>