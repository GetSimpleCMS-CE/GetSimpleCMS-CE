<?php global $SITEURL;?>

<link rel="stylesheet" href="<?php echo $SITEURL; ?>plugins/massiveAdmin/css/codemirror.min.css" />
<link rel="stylesheet" href="<?php echo $SITEURL; ?>plugins/massiveAdmin/css/blackboard.min.css" />
<script src="<?php echo $SITEURL; ?>plugins/massiveAdmin/js/codemirror.min.js"></script>
<script src="<?php echo $SITEURL; ?>plugins/massiveAdmin/js/clike.min.js"></script>

<style type="text/css">
	.CodeMirror {font-size: 15px;width: 100%, ;height: 500px;}
</style>

<link rel="stylesheet" href="<?php global $SITEURL; echo $SITEURL; ?>plugins/massiveAdmin/css/w3.css">
<link rel="stylesheet" href="<?php global $SITEURL; echo $SITEURL; ?>plugins/massiveAdmin/css/w3-custom.css">

<div class="w3-parent w3-container"><!-- Start Plug -->

<h3><?php echo i18n_r('massiveAdmin/GSCONFIGTITLE'); ?></h3>
<hr>

<form action="#" method="Post">
	<textarea name="content" id="myTextarea" wrap='off'><?php echo file_get_contents(GSROOTPATH . 'gsconfig.php'); ?></textarea>

	<script>
		var editor = CodeMirror.fromTextArea(document.querySelector('#myTextarea'), {
			theme: "blackboard",
			lineNumbers: true,
			matchBrackets: true,
			indentUnit: 4,
			indentWithTabs: true,
			enterMode: "keep",
			tabMode: "shift",
			mode: 'clike',
			inlineDynamicImports: true
		});
	</script>
	
	<div class="w3-center" style="margin-top:30px">
		<button class="w3-btn w3-large w3-round w3-green" type="submit" value="<?php echo i18n_r('massiveAdmin/GSCONFIGSAVE'); ?>" name="editGSConfig"><?php echo i18n_r('massiveAdmin/GSCONFIGSAVE'); ?></button>
	</div>
</form>

<?php
if (isset($_POST['editGSConfig'])) {
	global $MA;
	$MA->gsConfigEdit();
	echo '<div class="doneMassive" style="background:green;width:100%;text-align:center;padding:10px;border-radius:3px;color:#fff;">Done</div>';
	echo ("<meta http-equiv='refresh' content='1'>");
}; 
?>