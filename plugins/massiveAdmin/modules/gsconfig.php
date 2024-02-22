
<?php global $SITEURL;?>

<script src="<?php echo $SITEURL; ?>plugins/massiveAdmin/js/codemirror.min.js"></script>
<link rel="stylesheet" href="<?php echo $SITEURL; ?>plugins/massiveAdmin/css/codemirror.min.css" />
<link rel="stylesheet" href="<?php echo $SITEURL; ?>plugins/massiveAdmin/css/rubyblue.min.css" />
<script src="<?php echo $SITEURL; ?>plugins/massiveAdmin/js/clike.min.js"></script>

<style type="text/css">
	.CodeMirror {
		font-size: 15px;
		width: 100%, ;
		height: 500px;
	}
</style>

<form action="#" method="Post" style="background:#fafafa;border:solid 1px #ddd;padding:10px;box-sizing:border-box;">
	<h3><?php echo i18n_r('massiveAdmin/GSCONFIGTITLE'); ?></h3>
	<hr>
	<textarea name="content" id="myTextarea" wrap='off'><?php echo file_get_contents(GSROOTPATH . 'gsconfig.php'); ?></textarea>

	<script>
		var editor = CodeMirror.fromTextArea(document.querySelector('#myTextarea'), {
			theme: "rubyblue",
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

	<input type="submit" name="editGSConfig" style="background:var(--main-color);color:#fff;padding:10px;margin-top:10px;border:none;" value="<?php echo i18n_r('massiveAdmin/GSCONFIGSAVE'); ?>">

</form>

<?php
if (isset($_POST['editGSConfig'])) {
	global $MA;
	$MA->gsConfigEdit();
	echo '<div class="doneMassive" style="background:green;width:100%;text-align:center;padding:10px;border-radius:3px;color:#fff;">Done</div>';
	echo ("<meta http-equiv='refresh' content='1'>");
};; ?>