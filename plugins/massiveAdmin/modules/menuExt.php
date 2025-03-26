<?php
$folder = GSDATAOTHERPATH . 'massiveMenuExt/';
$filename = $folder . 'menuext.json';
$chmod_mode = 0755;
$folder_exists = file_exists($folder) || mkdir($folder, $chmod_mode);
$daterJson = @file_get_contents($filename);
$daterJsonNew = json_encode($daterJson);
?>

<link rel="stylesheet" href="<?php global $SITEURL;
echo $SITEURL; ?>plugins/massiveAdmin/css/w3.css">
<link rel="stylesheet" href="<?php global $SITEURL;
echo $SITEURL; ?>plugins/massiveAdmin/css/w3-custom.css">
<style>
	.wrapper a:link,
	.wrapper .w3-bar-item a:visited {
		text-decoration: none;
	}

	.w3-ul li:nth-child(odd) {
		background: #F3F3F3;
	}

	.w3-ul {
		margin-left: 0 !important
	}
</style>

<style>
	.w3-block,
	.w3-select {
		width: 96%;
		box-sizing: border-box;
	}
</style>

<h3><?php echo i18n_r('massiveAdmin/OWNFOOTERTITLE'); ?></h3>
<hr>

<button onclick="myFunction('Tab1')"
	class="w3-button w3-xlarge w3-round w3-block w3-gray w3-text-white w3-left-align w3-margin-bottom"><?php echo i18n_r('massiveAdmin/MENUEXTERNAL'); ?><span
		class="w3-right"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24">
			<path fill="currentColor" fill-rule="evenodd" d="m5 8l7 8l7-8z" />
		</svg></span></button>
<div id="Tab1" class="w3-hide w3-container">

		<ul class="w3-ul w3-hoverable" style="margin:0 0 50px 0px">
			<?php
			$datee = @file_get_contents($filename);
			$data = json_decode($datee, true);

			if (file_exists($filename)) {
				foreach ($data as $query) {
					$oldname = $query["name"];
					$newname = str_replace(" ", "", $query["name"]);
					$newnamenew = strtolower($newname);
					echo '
				<li class="w3-bar">
					<a href="' . $query["url"] . '" class="w3-bar-item">' . $query["name"] . '</a>
					<form action="#" method="POST" >
						<button name="' . $newnamenew . '" class="w3-bar-item w3-btn w3-red w3-round w3-right" style="margin-top:5px; padding: 2px 5px;">
						<svg xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24" id="trash"><path fill="#fff" d="M20,6H16V5a3,3,0,0,0-3-3H11A3,3,0,0,0,8,5V6H4A1,1,0,0,0,4,8H5V19a3,3,0,0,0,3,3h8a3,3,0,0,0,3-3V8h1a1,1,0,0,0,0-2ZM10,5a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1V6H10Zm7,14a1,1,0,0,1-1,1H8a1,1,0,0,1-1-1V8H17Z"></path></svg></button>
					</form>
				</li>
				';
					if (isset($_POST[$newnamenew])) {
						$datee = file_get_contents($filename);
						$data = json_decode($datee, true);
						unset($data[$oldname]);
						$datee = json_encode($data);
						file_put_contents($filename, $datee);
						echo ("<meta http-equiv='refresh' content='0'>");
					};
				};
			}; 
			?>
		</ul>

		<form action="#" method="POST" class="w3-container" style="margin-bottom:20px;display:block;">
			<div class="w3-margin-bottom">
				<label for=""><?php echo i18n_r('massiveAdmin/LINKNAME'); ?></label>
				<input class="w3-input w3-border w3-round w3-margin-bottom" type="text" name="linkname" required>
			</div>

			<div class="w3-margin-bottom">
				<label for=""><?php echo i18n_r('massiveAdmin/LINKURL'); ?></label>
				<input class="w3-input w3-border w3-round w3-margin-bottom" type="text" name="linkurl" required>
			</div>

			<div class="w3-margin-bottom">
				<label for=""><?php echo i18n_r('massiveAdmin/NEWWINDOW'); ?></label>
				<select class="w3-input w3-border" name="linkblank">
					<option value="_self"><?php echo i18n_r('massiveAdmin/NO'); ?></option>
					<option value="_blank"><?php echo i18n_r('massiveAdmin/YES'); ?></option>
				</select>
			</div>

			<div class="w3-margin-top w3-center">
				<button class="w3-btn w3-large w3-round w3-green" type="submit"
					name="addnew"><?php echo i18n_r('massiveAdmin/ADDLINK'); ?></button>
			</div>
		</form>
	</div>
 
<?php
if (isset($_POST['addnew'])) {
	global $MA;
	global $folder_exists;
	$MA->createLinkMenuExt();
};
?>

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