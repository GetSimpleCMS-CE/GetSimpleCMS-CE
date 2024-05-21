<?php
	$folder        = GSDATAOTHERPATH . '/massiveHelpDesk/';
	$filename      = $folder . 'helpdesk.json';
	$chmod_mode    = 0755;

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

<h3><?php echo i18n_r('massiveAdmin/USERHELPTITLE'); ?></h3>

<form action="#" method="POST">
    <div style="background:#ddd; padding:15px; display:flex; aling-items:center; margin-bottom:10px; justify-content:space-between; border:solid 1px #111;">
        <label for=""><?php echo i18n_r('massiveAdmin/TURNON'); ?></label> <input type="checkbox" name="checkbox" class="checkbox" value="true" style="margin-right:10px;">
    </div>

    <textarea name="helper" class="ckeditors">
<?php
if (file_exists($filename)) {
    echo $data->content;
}; ?>

	</textarea>
    <input type="submit" value="<?php echo i18n_r('massiveAdmin/SAVEOPTION'); ?>" name="savehelpinfo" style="width: 100%; padding: 10px; margin-top: 20px; background: #000; color: #fff; border: none; border-radius: 5px;">
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
}; ?>