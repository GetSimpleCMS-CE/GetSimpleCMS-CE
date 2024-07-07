<?php 
$fileOptionCheck = @file_get_contents( GSDATAOTHERPATH.'massiveTheme/option.txt');
?>

<link rel="stylesheet" href="<?php global $SITEURL; echo $SITEURL; ?>plugins/massiveAdmin/css/w3.css">
<link rel="stylesheet" href="<?php global $SITEURL; echo $SITEURL; ?>plugins/massiveAdmin/css/w3-custom.css">

<div class="w3-parent w3-container"><!-- Start Plug -->

<?php 
if(isset($_POST['save'])){
	$folder =GSDATAOTHERPATH.'massiveTheme/';
	if(!file_exists($folder)){
	mkdir($folder,0755);
	}

	file_put_contents($folder.'option.txt',$_POST['theme']);

	echo '
	<div class="w3-panel w3-green done-info w3-round">
		<h4 class="w3-text-white">Success!</h4>
		<p style="font-size:1.2em">Updating to the <b style="text-transform: uppercase;">"'.$_POST['theme'].'"</b> theme.</p>
	</div>
	<meta http-equiv=\'refresh\' content=\'3; url=load.php?id=massiveAdmin&themeselector\'>';

	echo '
	<script>
		document.querySelector(`select[name="theme"]`).value = "'.$fileOptionCheck.'"

		setTimeout(function(){
			document.querySelector(".done-info").style.display="none";
		},3000)
	</script>';
};
?>

<h3>Admin Theme Selector</h3>
<hr>

<form method="POST">

	<select name="theme" class="w3-select w3-border" style="padding:10px;  width:98%">
		<?php 
			foreach(glob(GSPLUGINPATH.'massiveAdmin/theme/*.css') as $style){
				$pure = pathinfo($style)['filename'];
				echo '<option value="'. $pure.'" '.( $fileOptionCheck == $pure ? 'selected':'').'>'. $pure.'</option>';
			};
		?>
	</select>
	
	<div class="w3-margin-top w3-center">
		<button class="w3-btn w3-large w3-round w3-green" type="submit" name="save"><?php echo i18n_r('massiveAdmin/SAVEOPTION'); ?></button>
	</div>
</form>