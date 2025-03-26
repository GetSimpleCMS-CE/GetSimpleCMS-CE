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

<button onclick="myFunction('Tab5');ckeNow()" class="w3-button w3-xlarge w3-round w3-block w3-gray w3-text-white w3-left-align w3-margin-bottom"><?php echo i18n_r('massiveAdmin/USERHELPTITLE'); ?><span class="w3-right"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="m5 8l7 8l7-8z"/></svg></span></button>
<div id="Tab5" class="w3-hide w3-container">

 
<hr>

<form action="#" method="POST" style="margin-bottom:20px;display:block;" >
	<div class="w3-margin-bottom w3-padding-large w3-center w3-panel w3-gs-main w3-round">
		<label class="w3-text-white" style="font-weight:600; padding-right:20px"><?php echo i18n_r('massiveAdmin/TURNON'); ?></label>
		<input class="w3-check checkbox-turnhelp" style="margin-right:10px;" type="checkbox" name="checkbox" value="true">
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
</div>

<script type="text/javascript" src="template/js/ckeditor/ckeditor.js"></script>

<script>
  function ckeNow() {
    const ckeditorReplace = document.querySelector(".ckeditors");
    var editor = CKEDITOR.replace(ckeditorReplace, {
      skin: 'getsimple',
      forcePasteAsPlainText: true,
      defaultLanguage: 'en',
      entities: false,
      height: '300px',
      baseHref: '<?php global $SITEURL; echo $SITEURL; ?>',
      tabSpaces: 10,
      filebrowserBrowseUrl: 'filebrowser.php?type=all',
      filebrowserImageBrowseUrl: 'filebrowser.php?type=images',
      filebrowserWindowWidth: '730',
      filebrowserWindowHeight: '500',
      <?php global $toolbar; echo $toolbar; ?>
      <?php global $options; echo $options; ?>
    });
  }

  // Listen for when the Tab5 is displayed and then call ckeNow
  document.querySelector('button').addEventListener('click', function() {
    const tab5 = document.getElementById('Tab5');
    
    // Check if the tab is being shown
    if (tab5 && tab5.classList.contains('w3-hide')) {
      tab5.classList.remove('w3-hide');  // Show the tab
      ckeNow();  // Initialize CKEditor
    }
  });

  // Ensure CKEditor initializes correctly when the page loads
  document.addEventListener('DOMContentLoaded', function() {
    if ('<?php echo isset($data->checkbox) ? $data->checkbox : ""; ?>' === "true") {
      document.querySelector('.checkbox-turnhelp').checked = true;
    } else {
      document.querySelector('.checkbox-turnhelp').checked = false;
    }
  });
</script>

<script>
 
	const json = `<?php echo @file_get_contents($filename); ?>`;

	if ('<?php if (isset($data->checkbox)) {
				echo $data->checkbox;
			}; ?>' == "true") {
		document.querySelector('.checkbox-turnhelp').checked = true;
	} else {
		document.querySelector('.checkbox-turnhelp').checked = false;
	}
</script>

<?php
if (isset($_POST['savehelpinfo'])) {
	global $MA;
	$MA->saveHelpInfo();
};
?>