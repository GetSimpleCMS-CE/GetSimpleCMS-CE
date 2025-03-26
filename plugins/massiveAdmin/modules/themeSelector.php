<?php 
$fileOptionCheck = @file_get_contents( GSDATAOTHERPATH.'massiveTheme/option.txt');
?>
 

<button onclick="myFunction('Tab4')" style="margin-top:10px" class=" w3-button w3-xlarge w3-round w3-block w3-gray w3-text-white w3-left-align w3-margin-bottom"> Admin Theme Selector <span class="w3-right"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="m5 8l7 8l7-8z"/></svg></span></button>
	<div id="Tab4" class="w3-hide w3-container">
 
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
	<meta http-equiv=\'refresh\' content=\'3; url=load.php?id=massiveAdmin&massiveoption\'>';

	echo '
	<script>
		document.querySelector(`select[name="theme"]`).value = "'.$fileOptionCheck.'"

		setTimeout(function(){
			document.querySelector(".done-info").style.display="none";
		},3000)
	</script>';
};
?>
 
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
	</div>