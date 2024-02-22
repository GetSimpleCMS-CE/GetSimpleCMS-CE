<?php 
	$fileOptionCheck = @file_get_contents( GSDATAOTHERPATH.'massiveTheme/option.txt');
;?>

<form method="POST">
	<h3>Admin Theme Selector</h3>

	<select name="theme" style="width:100%;padding:10px;border:solid 1px #ddd; background:#fff;">
		<?php 
			foreach(glob(GSPLUGINPATH.'massiveAdmin/theme/*.css') as $style){
				$pure = pathinfo($style)['filename'];
				echo '<option value="'. $pure.'" '.( $fileOptionCheck == $pure ? 'selected':'').'>'. $pure.'</option>';
			};
		?>
	</select>

	<input type="submit" class="submit" style="margin-top:20px;" name="save">
</form>

<?php 
	if(isset($_POST['save'])){
		$folder =GSDATAOTHERPATH.'massiveTheme/';
		if(!file_exists($folder)){
		mkdir($folder,0755);
		}

		file_put_contents($folder.'option.txt',$_POST['theme']);

		echo '
		<div style="width:100%;background:var(--main-color);padding:10px;border-radius:5px;color:#fff;margin-top:20px;display:block;" class="done-info">Done! You choose '.$_POST['theme'].' Theme</div>';

		echo '
		<script>
			document.querySelector(`select[name="theme"]`).value = "'.$fileOptionCheck.'"

			setTimeout(function(){
				document.querySelector(".done-info").style.display="none";
			},3000)
		</script>';
	};
;?>