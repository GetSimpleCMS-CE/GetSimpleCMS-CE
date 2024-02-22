<?php
$filename = GSDATAOTHERPATH . '/massiveOwnFooter/OwnFooter.json';
$datee = @file_get_contents($filename);
$data = json_decode($datee);; ?>

<?php error_reporting(E_ALL ^ E_NOTICE); ?>

<style>
	#ownfooterform {
		width: 100%;
		background: #fafafa;
		border: solid 1px #ddd;
		padding: 10px;
	}

	#ownfooterform input {
		width: 100%;
		padding: 5px;
		margin: 10px 0;
	}

	#ownfooterform input[type="submit"] {
		background: #000;
		color: #fff;
		border: none;
		padding: 10px;
	}

	#ownfooterform input[type="checkbox"] {
		all: revert;
		padding: 0;
	}
</style>

<h3><?php echo i18n_r('massiveAdmin/OWNFOOTERTITLE'); ?></h3>

<form id="ownfooterform" action="#" method="POST" enctype="multipart/form-data">

	<div style="background:#ddd; padding:10px; display:flex; aling-items:center; margin-bottom:10px; justify-content:space-between; border:solid 1px #111;">
		<label for="turnon" style="margin-top: 2px;"><?php echo i18n_r('massiveAdmin/TURNON'); ?></label>
		<input type="checkbox" name="turnon" class="checkbox" value="true">
	</div>

	<label for="ownfootername"><?php echo i18n_r('massiveAdmin/OWNFOOTERNAME'); ?> </label>
	<input type="text" value="<?php echo $data->ownfootername ?? ''; ?>" name="ownfootername">

	<label for="ownfootericon"><?php echo i18n_r('massiveAdmin/OWNFOOTERICON'); ?></label>
	<input type="file" name="ownfootericon">

	<label for="ownlogo"><?php echo i18n_r('massiveAdmin/OWNLOGO'); ?></label>

	<select name="ownlogo" class="ownlogo" style="width:100%; padding:5px; margin:10px 0;"><br>
		<option value="yes"><?php echo i18n_r('massiveAdmin/YES'); ?></option>
		<option value="no"><?php echo i18n_r('massiveAdmin/NO'); ?></option>
	</select>

	<label for="ownfooterlink"><?php echo i18n_r('massiveAdmin/OWNFOOTERLINK'); ?></label>
	<input type="text" value="<?php echo $data->ownfooterlink ?? ''; ?>" style="margin-top:10px;display:block;" name="ownfooterlink">

	<br>

	<?php global $SITEURL; ?>

	<script src="<?php echo $SITEURL; ?>plugins/massiveAdmin/js/codemirror.min.js" integrity="sha512-8RnEqURPUc5aqFEN04aQEiPlSAdE0jlFS/9iGgUyNtwFnSKCXhmB6ZTNl7LnDtDWKabJIASzXrzD0K+LYexU9g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<link rel="stylesheet" href="<?php echo $SITEURL; ?>plugins/massiveAdmin/css/codemirror.min.css" integrity="sha512-uf06llspW44/LZpHzHT6qBOIVODjWtv4MxCricRxkzvopAlSWnTf6hpZTFxuuZcuNE9CBQhqE0Seu1CoRk84nQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="<?php echo $SITEURL; ?>plugins/massiveAdmin/css/blackboard.min.css" integrity="sha512-KnHAkH0/78Cyjs1tjV9/+00HK8gu1uKRCCKcWFxX0+rehRh9SYJqiG/2fY4St7H8rPItOsBkgQjN0m4rL5Wobw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<script src="<?php echo $SITEURL; ?>plugins/massiveAdmin/js/php.min.js" integrity="sha512-jZGz5n9AVTuQGhKTL0QzOm6bxxIQjaSbins+vD3OIdI7mtnmYE6h/L+UBGIp/SssLggbkxRzp9XkQNA4AyjFBw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="<?php echo $SITEURL; ?>plugins/massiveAdmin/js/css.min.js" integrity="sha512-rQImvJlBa8MV1Tl1SXR5zD2bWfmgCEIzTieFegGg89AAt7j/NBEe50M5CqYQJnRwtkjKMmuYgHBqtD1Ubbk5ww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="<?php echo $SITEURL; ?>plugins/massiveAdmin/js/javascript.min.js" integrity="sha512-I6CdJdruzGtvDyvdO4YsiAq+pkWf2efgd1ZUSK2FnM/u2VuRASPC7GowWQrWyjxCZn6CT89s3ddGI+be0Ak9Fg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="<?php echo $SITEURL; ?>plugins/massiveAdmin/js/xml.min.js" integrity="sha512-LarNmzVokUmcA7aUDtqZ6oTS+YXmUKzpGdm8DxC46A6AHu+PQiYCUlwEGWidjVYMo/QXZMFMIadZtrkfApYp/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="<?php echo $SITEURL; ?>plugins/massiveAdmin/js/htmlmixed.min.js" integrity="sha512-HN6cn6mIWeFJFwRN9yetDAMSh+AK9myHF1X9GlSlKmThaat65342Yw8wL7ITuaJnPioG0SYG09gy0qd5+s777w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="<?php echo $SITEURL; ?>plugins/massiveAdmin/js/clike.min.js" integrity="sha512-l8ZIWnQ3XHPRG3MQ8+hT1OffRSTrFwrph1j1oc1Fzc9UKVGef5XN9fdO0vm3nW0PRgQ9LJgck6ciG59m69rvfg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	<style type="text/css">
		.CodeMirror {
			font-size: 15px;
			width: 100%, ;
			margin-top: 5px;
		}
	</style>

	<label for="ownheader"><?php echo i18n_r('massiveAdmin/OWNFOOTERHEADER'); ?></label>
	<textarea name="ownheader" id="ownheader" style="width:100%; height:200px; margin-top:10px; display:block;"><?php echo $data->ownheader ?? ''; ?></textarea>

	<br>

	<label for="ownfooter"><?php echo i18n_r('massiveAdmin/OWNFOOTERFOOTER'); ?></label>
	<textarea name="ownfooter" id="ownfooter" style="width:100%; height:200px; margin-top:10px; display:block;"><?php echo $data->ownfooter ?? ''; ?></textarea>

	<script>
		function editor(id) {
			CodeMirror.fromTextArea(id, {
				theme: "blackboard",
				lineNumbers: true,
				matchBrackets: true,
				indentUnit: 4,
				indentWithTabs: true,
				enterMode: "keep",
				tabMode: "shift",
				mode: 'htmlmixed',
				inlineDynamicImports: true
			});
		}
		editor(ownheader);
		editor(ownfooter);
	</script>

	<br>

	<label><?php echo i18n_r('massiveAdmin/CHANGETITLECOLOR'); ?></label>
	<div class="colors" style="background:#ddd; padding:5px; display:flex; aling-items:center; margin:20px 0; justify-content:space-between; border:solid 1px #111; flex-wrap:wrap;">

		<div class="colors-item" style="width:100%;display:flex;align-items:center;justify-content:space-between;padding:5px;">
			<label for="turncolor"><?php echo i18n_r('massiveAdmin/TURNON'); ?></label>
			<input type="checkbox" class="turncolor" value="true" name="turncolor">
		</div>

		<div class="colors-item" style="width:50%;padding:10px;">
			<label for="ownmaincolor"><?php echo i18n_r('massiveAdmin/MAINCOLOR'); ?></label>
			<input type="color" value="<?php echo $data->maincolor ?? ''; ?>" name="maincolor">
		</div>

		<div class="colors-item" style="width:50%;padding:10px;">
			<label for="ownmaincolor"><?php echo i18n_r('massiveAdmin/BGCOLOR'); ?></label>
			<input type="color" value="<?php echo $data->bgcolor ?? ''; ?>" name="bgcolor">
		</div>

	</div>

	<input type="submit" name="submit" value="<?php echo i18n_r('massiveAdmin/SAVEOPTION'); ?>">

</form>

<script>
	const checkbox = '<?php echo $data->turnon; ?>';
	const turncolor = '<?php echo $data->turncolor; ?>';

	if (turncolor == 'true') {
		document.querySelector('.turncolor').checked = true;
	} else {
		document.querySelector('.turncolor').checked = false;
	}
	if (checkbox == 'true') {
		document.querySelector('.checkbox').checked = true;
	} else {
		document.querySelector('.checkbox').checked = false;
	}
	if ("<?php echo $data->ownlogo; ?>" == "yes") {
		document.querySelector(".ownlogo").value = "yes";
	} else {
		document.querySelector(".ownlogo").value = "no";
	}
</script>

<?php
if (isset($_POST['submit'])) {
	$turnon = $_POST['turnon'] ?? '';
	if ($turnon == 'true') {
		$turnon = "true";
	} else {
		$turnon = "false";
	};

	$ownfootername = $_POST['ownfootername'] ?? '';
	$ownlogo = $_POST['ownlogo'] ?? '';
	$ownheader = $_POST['ownheader'] ?? '';
	$ownheadernew =  json_encode($ownheader, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
	$ownfooter = $_POST['ownfooter'] ?? '';
	$ownfooternew =  json_encode($ownfooter, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
	$ownfootericon = $_FILES["ownfootericon"]["name"];

	$maincolor = $_POST['maincolor'] ?? '';
	$bgcolor = $_POST['bgcolor'] ?? '';
	$turncolor = $_POST['turncolor'] ?? '';
	if ($turncolor == 'true') {
		$turncolor = "true";
	} else {
		$turncolor = "false";
	};

	if ($ownfootericon == "") {
		$ownfootericon = $data->ownfootericon;
	}

	$ownfooterlink = $_POST['ownfooterlink'];

	$json = '{
	"turnon": "' . $turnon . '",
	"ownfootername": "' . $ownfootername . '",
	"ownfootericon": "' . $ownfootericon . '",
	"ownfooterlink": "' . $ownfooterlink . '",
	"ownlogo": "' . $ownlogo . '",
	"ownheader": ' . $ownheadernew . ',
	"ownfooter": ' . $ownfooternew . ',
	"turncolor": "' . $turncolor . '",
	"bgcolor": "' . $bgcolor . '",
	"maincolor": "' . $maincolor . '"
}';

	$massiveOwnFooterFolder = GSDATAOTHERPATH . '/massiveOwnFooter/';
	$filejson = 'OwnFooter.json';
	$finaljson = $massiveOwnFooterFolder . $filejson;
	$chmod_mode    = 0755;
	$folder_exists = file_exists($massiveOwnFooterFolder) || mkdir($massiveOwnFooterFolder, $chmod_mode);

	file_put_contents($finaljson, $json);

	$massiveOwnFooterFolderFoto = GSDATAOTHERPATH . '/footerfoto/';

	$target_dir =  $massiveOwnFooterFolderFoto;
	$target_file = $target_dir . basename($_FILES["ownfootericon"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

	if (!file_exists($massiveOwnFooterFolderFoto)) {
		mkdir($massiveOwnFooterFolderFoto, 0755);
		$datas = 'Allow from all';
		file_put_contents($massiveOwnFooterFolderFoto . '.htaccess', $datas);
	};

	// Check if image file is a actual image or fake image
	if (isset($_POST["ownfootericon"])) {
		$check = getimagesize($_FILES["ownfootericon"]["tmp_name"]);
		if ($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}
	}

	// Allow certain file formats
	if (
		$imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif"
	) {
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}

	if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
	} else {
		if (move_uploaded_file($_FILES["ownfootericon"]["tmp_name"], $target_file)) {
			echo "The file " . htmlspecialchars(basename($_FILES["ownfootericon"]["name"])) . " has been uploaded.";
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
	}

	echo ("<meta http-equiv='refresh' content='0'>");
}; ?>