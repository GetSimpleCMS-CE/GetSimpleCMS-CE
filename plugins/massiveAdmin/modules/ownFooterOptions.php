<?php
$filename = GSDATAOTHERPATH . '/massiveOwnFooter/OwnFooter.json';
$datee = @file_get_contents($filename);
$dataOwnFooter = json_decode($datee);
?>

<?php error_reporting(E_ALL ^ E_NOTICE); ?>

<link rel="stylesheet" href="<?php global $SITEURL;
echo $SITEURL; ?>plugins/massiveAdmin/css/w3.css">
<link rel="stylesheet" href="<?php global $SITEURL;
echo $SITEURL; ?>plugins/massiveAdmin/css/w3-custom.css">
<style>
	input::file-selector-button {
		background-color: var(--main-color);
		border: 0;
		border-radius: 5px;
		color: #fff;
		padding: .75rem 1rem;
		margin: 0 10px 20px 20px;
	}

	input::file-selector-button:hover {
		box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)
	}

	.CodeMirror {
		font-size: 15px;
		width: 100%;
		margin-top: 5px;
		border:solid 1px #ccc;
	}
</style>

<button onclick="myFunctionWithCodemirror('Tab2')"
	class="w3-button w3-xlarge w3-round w3-block w3-gray w3-text-white w3-left-align w3-margin-bottom"><?php echo i18n_r('massiveAdmin/OWNFOOTERTITLE'); ?><span
		class="w3-right"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24">
			<path fill="currentColor" fill-rule="evenodd" d="m5 8l7 8l7-8z" />
		</svg></span></button>
<div id="Tab2" class="w3-hide w3-container">

	<form id="ownfooterform" action="#" method="POST" enctype="multipart/form-data">
		<div class="w3-margin-bottom w3-padding-large w3-center w3-panel w3-gs-main w3-round">
			<label class="w3-text-white"
				style="font-weight:600; padding-right:20px"><?php echo i18n_r('massiveAdmin/TURNON'); ?></label>
			<input class="w3-check checkbox" style="margin-right:10px;" type="checkbox" name="turnon" value="true">
		</div>

		<div class="w3-margin-bottom">
			<label for="ownfootername"><?php echo i18n_r('massiveAdmin/OWNFOOTERNAME'); ?> </label>
			<input class="w3-input w3-padding w3-border w3-round w3-margin-bottom" style="width:96%" type="text"
				value="<?php echo $dataOwnFooter->ownfootername ?? ''; ?>" name="ownfootername">
		</div>

		<div class="w3-margin-bottom">

			<?php if (isset($dataOwnFooter->ownfootericon) && !empty($dataOwnFooter->ownfootericon)): ?>
				<img src="<?php global $SITEURL;
				echo $SITEURL . 'data/other/footerfoto/' . @$dataOwnFooter->ownfootericon; ?>"
					style="width:80px;height:80px;display:block;border:solid 1px #ddd;padding:5px;margin:10px 0;object-fit:contain;">

			<?php endif; ?>

			<label for="ownfootericon"><?php echo i18n_r('massiveAdmin/OWNFOOTERICON'); ?></label>
			<input class="w3-input" type="file" value="<?php echo @$dataOwnFooter->ownfootericon; ?>" name="ownfootericon">
		</div>

		<div class="w3-margin-bottom">
			<label for="ownlogo"><?php echo i18n_r('massiveAdmin/OWNLOGO'); ?></label>
			<select class="w3-select w3-padding w3-border ownlogo" style="width:96%" name="ownlogo"><br>
				<option value="yes"><?php echo i18n_r('massiveAdmin/YES'); ?></option>
				<option value="no"><?php echo i18n_r('massiveAdmin/NO'); ?></option>
			</select>
		</div>

		<div class="w3-margin-bottom">
			<label for="ownfooterlink"><?php echo i18n_r('massiveAdmin/OWNFOOTERLINK'); ?></label>
			<input class="w3-input w3-padding w3-border w3-round w3-margin-bottom" style="width:96%" type="text"
				value="<?php echo $dataOwnFooter->ownfooterlink ?? ''; ?>" name="ownfooterlink">
		</div>

		<?php global $SITEURL; ?>

		<script src="<?php echo $SITEURL; ?>plugins/massiveAdmin/js/codemirror.min.js"></script>
		<link rel="stylesheet" href="<?php echo $SITEURL; ?>plugins/massiveAdmin/css/codemirror.min.css">
		<link rel="stylesheet" href="<?php echo $SITEURL; ?>plugins/massiveAdmin/css/blackboard.min.css">
		<script src="<?php echo $SITEURL; ?>plugins/massiveAdmin/js/php.min.js"></script>
		<script src="<?php echo $SITEURL; ?>plugins/massiveAdmin/js/css.min.js"></script>
		<script src="<?php echo $SITEURL; ?>plugins/massiveAdmin/js/javascript.min.js"></script>
		<script src="<?php echo $SITEURL; ?>plugins/massiveAdmin/js/xml.min.js"></script>
		<script src="<?php echo $SITEURL; ?>plugins/massiveAdmin/js/htmlmixed.min.js"></script>
		<script src="<?php echo $SITEURL; ?>plugins/massiveAdmin/js/clike.min.js"></script>

		<div class="w3-margin-bottom">
			<label for="ownheader"><?php echo i18n_r('massiveAdmin/OWNFOOTERHEADER'); ?></label>
			<textarea name="ownheader" id="ownheader"
				style="width:100%; height:200px; margin-top:10px; display:block;"><?php echo $dataOwnFooter->ownheader ?? ''; ?></textarea>
		</div>

		<div class="w3-margin-bottom">
			<label for="ownfooter"><?php echo i18n_r('massiveAdmin/OWNFOOTERFOOTER'); ?></label>
			<textarea name="ownfooter" id="ownfooter"
				style="width:100%; height:200px; margin-top:10px; display:block;"><?php echo $dataOwnFooter->ownfooter ?? ''; ?></textarea>
		</div>

		<div class="w3-container w3-margin-bottom" style="margin-top:70px">
			<h4><?php echo i18n_r('massiveAdmin/CHANGETITLECOLOR'); ?>:</h4>

			<div class="w3-margin-bottom w3-padding w3-center w3-panel w3-gray w3-round">
				<label class="w3-text-white" style="font-weight:600; padding-right:20px"
					for="turncolor"><?php echo i18n_r('massiveAdmin/TURNON'); ?></label>
				<input class="w3-check turncolor" type="checkbox" value="true" name="turncolor">
			</div>

			<div class="w3-row w3-margin-bottom">
				<div class="w3-half colors-item" style="padding:15px;">
					<label for="ownmaincolor"><?php echo i18n_r('massiveAdmin/MAINCOLOR'); ?></label>
					<input class="w3-input" type="color" style="height:50px"
						value="<?php echo $dataOwnFooter->maincolor ?? ''; ?>" name="maincolor">
				</div>

				<div class="w3-rest colors-item" style="padding:15px;">
					<label for="ownmaincolor"><?php echo i18n_r('massiveAdmin/BGCOLOR'); ?></label>
					<input class="w3-input" type="color" style="height:50px" value="<?php echo $dataOwnFooter->bgcolor ?? ''; ?>"
						name="bgcolor">
				</div>
			</div>

		</div>

		<div class="w3-margin-top w3-center">
			<button class="w3-btn w3-large w3-round w3-green" type="submit"
				name="submit"><?php echo i18n_r('massiveAdmin/SAVEOPTION'); ?></button>
		</div>

	</form>
 
<script>
	const checkbox = '<?php echo $dataOwnFooter->turnon; ?>';
	const turncolor = '<?php echo $dataOwnFooter->turncolor; ?>';

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
	if ("<?php echo $dataOwnFooter->ownlogo; ?>" == "yes") {
		document.querySelector(".ownlogo").value = "yes";
	} else {
		document.querySelector(".ownlogo").value = "no";
	}
</script>

<?php $CMTHEME = defined('GSCMTHEME') ? constant('GSCMTHEME') : 'blackboard'; ?>

<script>
    function myFunctionWithCodemirror(tabName) {
        var x = document.getElementById(tabName);
        if (x.className.indexOf("w3-show") == -1) {
            x.className += " w3-show"; // Pokazujemy zawartość
            
            // Inicjalizacja CodeMirror tylko raz, gdy zakładka jest pokazana
            if (!x.dataset.codemirrorInitialized) {
                // Inicjalizacja dla ownheader
                CodeMirror.fromTextArea(document.getElementById("ownheader"), {
					theme: "<?php echo $CMTHEME; ?>",
					lineNumbers: true,
					matchBrackets: true,
					indentUnit: 4,
					indentWithTabs: true,
					lineWrapping: true,
					enterMode: "keep",
					tabMode: "shift",
					mode: 'htmlmixed',
					inlineDynamicImports: true
                });

                // Inicjalizacja dla ownfooter
                CodeMirror.fromTextArea(document.getElementById("ownfooter"), {
					theme: "<?php echo $CMTHEME; ?>",
					lineNumbers: true,
					matchBrackets: true,
					indentUnit: 4,
					indentWithTabs: true,
					lineWrapping: true,
					enterMode: "keep",
					tabMode: "shift",
					mode: 'htmlmixed',
					inlineDynamicImports: true
                });

                // Oznaczamy, że CodeMirror został zainicjalizowany
                x.dataset.codemirrorInitialized = "true";
            }
        } else {
            x.className = x.className.replace(" w3-show", ""); // Ukrywamy zawartość
        }
    }


	// Save with ctrl+s
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            var saveButton = document.querySelector('button[name="submit"]');
            if (saveButton) {
                saveButton.click();
            }
        }
    });
</script>


<?php
if (isset($_POST['submit'])) {
	$turnon = $_POST['turnon'] ?? '';
	if ($turnon == 'true') {
		$turnon = "true";
	} else {
		$turnon = "false";
	}
	;

	$ownfootername = $_POST['ownfootername'] ?? '';
	$ownlogo = $_POST['ownlogo'] ?? '';
	$ownheader = $_POST['ownheader'] ?? '';
	$ownheadernew = json_encode($ownheader, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
	$ownfooter = $_POST['ownfooter'] ?? '';
	$ownfooternew = json_encode($ownfooter, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
	$ownfootericon = $_FILES["ownfootericon"]["name"];

	$maincolor = $_POST['maincolor'] ?? '';
	$bgcolor = $_POST['bgcolor'] ?? '';
	$turncolor = $_POST['turncolor'] ?? '';
	if ($turncolor == 'true') {
		$turncolor = "true";
	} else {
		$turncolor = "false";
	}
	;

	if ($ownfootericon == "") {
		$ownfootericon = $dataOwnFooter->ownfootericon;
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
	$chmod_mode = 0755;
	$folder_exists = file_exists($massiveOwnFooterFolder) || mkdir($massiveOwnFooterFolder, $chmod_mode);

	file_put_contents($finaljson, $json);

	$massiveOwnFooterFolderFoto = GSDATAOTHERPATH . '/footerfoto/';

	$target_dir = $massiveOwnFooterFolderFoto;
	$target_file = $target_dir . basename($_FILES["ownfootericon"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

	if (!file_exists($massiveOwnFooterFolderFoto)) {
		mkdir($massiveOwnFooterFolderFoto, 0755);
		$datas = 'Allow from all';
		file_put_contents($massiveOwnFooterFolderFoto . '.htaccess', $datas);
	}
	;

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
};
?>