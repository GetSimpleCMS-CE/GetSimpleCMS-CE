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
				value="<?php echo htmlspecialchars($dataOwnFooter->ownfootername ?? '', ENT_QUOTES, 'UTF-8'); ?>" name="ownfootername">
		</div>

		<div class="w3-margin-bottom">
			<label for="ownfooterlink"><?php echo i18n_r('massiveAdmin/OWNFOOTERLINK'); ?></label>
			<input class="w3-input w3-padding w3-border w3-round w3-margin-bottom" style="width:96%" type="text"
				value="<?php echo htmlspecialchars($dataOwnFooter->ownfooterlink ?? '', ENT_QUOTES, 'UTF-8'); ?>" name="ownfooterlink">
		</div>

		<div class="w3-margin-bottom">

			<?php if (isset($dataOwnFooter->ownfootericon) && !empty($dataOwnFooter->ownfootericon)): ?>
				<?php 
				$iconPath = GSDATAOTHERPATH . '/footerfoto/' . $dataOwnFooter->ownfootericon;
				if (file_exists($iconPath)): 
				?>
					<img src="<?php global $SITEURL;
					echo $SITEURL . 'data/other/footerfoto/' . htmlspecialchars($dataOwnFooter->ownfootericon, ENT_QUOTES, 'UTF-8'); ?>"
						style="width:80px;height:80px;display:block;border:solid 1px #ddd;padding:5px;margin:10px 0;object-fit:contain;"
						alt="<?php echo htmlspecialchars($dataOwnFooter->ownfootername ?? 'Footer icon', ENT_QUOTES, 'UTF-8'); ?>">
				<?php endif; ?>
			<?php endif; ?>

			<label for="ownfootericon"><?php echo i18n_r('massiveAdmin/OWNFOOTERICON'); ?></label>
			<input class="w3-input" type="file" name="ownfootericon" accept="image/jpeg,image/png,image/gif">
			<?php if (isset($dataOwnFooter->ownfootericon) && !empty($dataOwnFooter->ownfootericon)): ?>
				<small style="display:block;margin-top:5px;color:#666;">Current: <?php echo htmlspecialchars($dataOwnFooter->ownfootericon, ENT_QUOTES, 'UTF-8'); ?></small>
			<?php endif; ?>
		</div>

		<div class="w3-margin-bottom">
			<label for="ownlogo"><?php echo i18n_r('massiveAdmin/OWNLOGO'); ?></label>
			<select class="w3-select w3-padding w3-border ownlogo" style="width:96%" name="ownlogo"><br>
				<option value="yes"><?php echo i18n_r('massiveAdmin/YES'); ?></option>
				<option value="no"><?php echo i18n_r('massiveAdmin/NO'); ?></option>
			</select>
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
				style="width:100%; height:200px; margin-top:10px; display:block;"><?php echo htmlspecialchars($dataOwnFooter->ownheader ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
		</div>

		<div class="w3-margin-bottom">
			<label for="ownfooter"><?php echo i18n_r('massiveAdmin/OWNFOOTERFOOTER'); ?></label>
			<textarea name="ownfooter" id="ownfooter"
				style="width:100%; height:200px; margin-top:10px; display:block;"><?php echo htmlspecialchars($dataOwnFooter->ownfooter ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
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
					<label for="maincolor"><?php echo i18n_r('massiveAdmin/MAINCOLOR'); ?></label>
					<input class="w3-input" type="color" style="height:50px"
						value="<?php echo htmlspecialchars($dataOwnFooter->maincolor ?? '#000000', ENT_QUOTES, 'UTF-8'); ?>" name="maincolor">
				</div>

				<div class="w3-rest colors-item" style="padding:15px;">
					<label for="bgcolor"><?php echo i18n_r('massiveAdmin/BGCOLOR'); ?></label>
					<input class="w3-input" type="color" style="height:50px" value="<?php echo htmlspecialchars($dataOwnFooter->bgcolor ?? '#ffffff', ENT_QUOTES, 'UTF-8'); ?>"
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
	const checkbox = '<?php echo $dataOwnFooter->turnon ?? ''; ?>';
	const turncolor = '<?php echo $dataOwnFooter->turncolor ?? ''; ?>';

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
	if ("<?php echo $dataOwnFooter->ownlogo ?? ''; ?>" == "yes") {
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
            x.className += " w3-show";
            
            // Initialize CodeMirror only once when tab is shown
            if (!x.dataset.codemirrorInitialized) {
                // Initialize for ownheader
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

                // Initialize for ownfooter
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

                x.dataset.codemirrorInitialized = "true";
            }
        } else {
            x.className = x.className.replace(" w3-show", "");
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
	$turnon = isset($_POST['turnon']) && $_POST['turnon'] == 'true' ? 'true' : 'false';
	$ownfootername = $_POST['ownfootername'] ?? '';
	$ownlogo = $_POST['ownlogo'] ?? '';
	$ownfooterlink = $_POST['ownfooterlink'] ?? '';
	$turncolor = isset($_POST['turncolor']) && $_POST['turncolor'] == 'true' ? 'true' : 'false';
	$maincolor = $_POST['maincolor'] ?? '';
	$bgcolor = $_POST['bgcolor'] ?? '';
	
	// Handle textarea content - decode from JSON if needed for storage
	$ownheader = $_POST['ownheader'] ?? '';
	$ownfooter = $_POST['ownfooter'] ?? '';

	// Handle file upload
	$ownfootericon = '';
	
	// Check if a file was actually uploaded
	if (isset($_FILES["ownfootericon"]) && $_FILES["ownfootericon"]["error"] === UPLOAD_ERR_OK) {
		$massiveOwnFooterFolderFoto = GSDATAOTHERPATH . '/footerfoto/';
		
		// Create directory if it doesn't exist
		if (!file_exists($massiveOwnFooterFolderFoto)) {
			mkdir($massiveOwnFooterFolderFoto, 0755, true);
			$htaccess = 'Allow from all';
			file_put_contents($massiveOwnFooterFolderFoto . '.htaccess', $htaccess);
		}

		$target_dir = $massiveOwnFooterFolderFoto;
		$imageFileType = strtolower(pathinfo($_FILES["ownfootericon"]["name"], PATHINFO_EXTENSION));
		
		// Validate file type
		$allowed_types = array("jpg", "jpeg", "png", "gif");
		if (in_array($imageFileType, $allowed_types)) {
			// Validate it's actually an image
			$check = getimagesize($_FILES["ownfootericon"]["tmp_name"]);
			if ($check !== false) {
				// Generate safe filename
				$safe_filename = preg_replace("/[^a-zA-Z0-9._-]/", "", basename($_FILES["ownfootericon"]["name"]));
				$target_file = $target_dir . $safe_filename;
				
				// Move uploaded file
				if (move_uploaded_file($_FILES["ownfootericon"]["tmp_name"], $target_file)) {
					$ownfootericon = $safe_filename;
				}
			}
		}
	}
	
	// If no new file was uploaded, keep the existing icon
	if (empty($ownfootericon)) {
		$ownfootericon = $dataOwnFooter->ownfootericon ?? '';
	}

	// Build JSON - properly escape values
	$jsonData = array(
		'turnon' => $turnon,
		'ownfootername' => $ownfootername,
		'ownfootericon' => $ownfootericon,
		'ownfooterlink' => $ownfooterlink,
		'ownlogo' => $ownlogo,
		'ownheader' => $ownheader,
		'ownfooter' => $ownfooter,
		'turncolor' => $turncolor,
		'bgcolor' => $bgcolor,
		'maincolor' => $maincolor
	);

	$json = json_encode($jsonData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

	// Save JSON file
	$massiveOwnFooterFolder = GSDATAOTHERPATH . '/massiveOwnFooter/';
	if (!file_exists($massiveOwnFooterFolder)) {
		mkdir($massiveOwnFooterFolder, 0755, true);
	}
	
	$finaljson = $massiveOwnFooterFolder . 'OwnFooter.json';
	file_put_contents($finaljson, $json);

	echo ("<meta http-equiv='refresh' content='0'>");
}
