<link rel="stylesheet" href="<?php global $SITEURL;
echo $SITEURL; ?>plugins/massiveAdmin/css/w3.css">
<link rel="stylesheet" href="<?php global $SITEURL;
echo $SITEURL; ?>plugins/massiveAdmin/css/w3-custom.css">
<div class="w3-parent w3-container"><!-- Start Plug -->

	<h3><?php echo i18n_r('massiveAdmin/THEMECONFIGURATORNAME'); ?></h3>
	<hr>

	<div class="w3-panel w3-leftbar w3-pale-yellow w3-padding-large">
		<p><?php echo i18n_r("massiveAdmin/HOWUSETHEMECONFIG"); ?></p>
		<button class="w3-btn w3-gs-main w3-round w3-right showdialog"
			onclick="document.getElementById('id01').style.display='block'"><?php echo i18n_r("massiveAdmin/WATCHEXAMPLE"); ?></button>
	</div>

	<p class="w3-margin-bottom">
		<?php
		$websiteXml = GSDATAOTHERPATH . 'website.xml';
		if (!file_exists($websiteXml)) {
			echo '<b style="color:red">Error: website.xml not found.</b>';
			return;
		}
		$xml = simplexml_load_file($websiteXml);
		if ($xml === false) {
			echo '<b style="color:red">Error: could not parse website.xml.</b>';
			return;
		}
		$activeTemplate = (string) $xml->TEMPLATE;
		echo "Active Theme: <b>" . htmlspecialchars($activeTemplate, ENT_QUOTES, 'UTF-8') . "</b>";
		?>
	</p>
	<hr>

	<h3><?php echo i18n_r("massiveAdmin/SETTINGS"); ?></h3>
	<hr>

	<?php
	$settingsFile = GSTHEMESPATH . $activeTemplate . '/settings.json';

	if (file_exists($settingsFile)) {
		$data = file_get_contents($settingsFile);
		$filx = json_decode($data);

		if ($filx === null || !isset($filx->settings)) {
			echo '<p style="color:red">Error: settings.json could not be parsed.</p>';
		} else {

			// Handle POST before rendering the form
			if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ssettings'])) {
				foreach ($filx->settings as $key => $loop) {
					if (isset($_POST[$key])) {
						$filx->settings->$key->value = $_POST[$key];
					}
				}
				file_put_contents(
					$settingsFile,
					json_encode($filx, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
				);
				echo "<meta http-equiv='refresh' content='0'>";
				return;
			}

			echo '<form class="settheme" method="post">';

			foreach ($filx->settings as $key => $loop) {
				$keyEsc   = htmlspecialchars($key, ENT_QUOTES, 'UTF-8');
				$title    = htmlspecialchars($loop->title ?? '', ENT_QUOTES, 'UTF-8');
				$value    = $loop->value ?? '';
				$valueEsc = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');

				if ($loop->type == 'wysywig') {
					echo '
			<div class="w3-margin-bottom">
				<label>' . $title . ' :</label>
				<textarea class="mbinput w3-input w3-padding w3-border w3-round w3-margin-bottom" style="width:98%; display:block; height:250px;" id="post-content" name="' . $keyEsc . '">' . htmlspecialchars(html_entity_decode($value), ENT_QUOTES, 'UTF-8') . '</textarea>
			</div>';

				} elseif ($loop->type == 'image') {
					global $SITEURL;
					echo '
			<span class="formedit">
			<div class="w3-margin-bottom">
				<label>' . $title . ' :</label>
				<div class="w3-row w3-margin-bottom">';
					if (!empty($value) && $value !== 'undefined') {
						echo '
				<div class="w3-col m2 l2 w3-center">
					<img src="' . $valueEsc . '" class="w3-border w3-padding" style="width:80px;height:80px;object-fit:cover;" alt="' . $title . '">
				</div>';
					}
					echo '
				<div class="w3-col m8 l8 w3-center">
					<input type="text" class="mb_foto foto mbinput w3-input w3-padding w3-border w3-round w3-margin-bottom" style="margin-top:30px" name="' . $keyEsc . '" value="' . $valueEsc . '">
				</div>
				<div class="w3-col m2 l2 w3-center">
					<button class="mb_fotobtn choose-image w3-btn w3-gs-main w3-round" style="margin-top:30px; padding:4px 6px">
					<svg xmlns="http://www.w3.org/2000/svg" width="22px" height="22px" viewBox="0 0 24 24"><path fill="currentColor" d="M19 2H5a3 3 0 0 0-3 3v14a3 3 0 0 0 3 3h14a2.81 2.81 0 0 0 .49-.05l.3-.07h.12l.37-.14l.13-.07c.1-.06.21-.11.31-.18a3.79 3.79 0 0 0 .38-.32l.07-.09a2.69 2.69 0 0 0 .27-.32l.09-.13a2.31 2.31 0 0 0 .18-.35a1 1 0 0 0 .07-.15c.05-.12.08-.25.12-.38v-.15a2.6 2.6 0 0 0 .1-.6V5a3 3 0 0 0-3-3M5 20a1 1 0 0 1-1-1v-4.31l3.29-3.3a1 1 0 0 1 1.42 0l8.6 8.61Zm15-1a1 1 0 0 1-.07.36a1 1 0 0 1-.08.14a.94.94 0 0 1-.09.12l-5.35-5.35l.88-.88a1 1 0 0 1 1.42 0l3.29 3.3Zm0-5.14L18.12 12a3.08 3.08 0 0 0-4.24 0l-.88.88L10.12 10a3.08 3.08 0 0 0-4.24 0L4 11.86V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1Z"/></svg></button>
				</div>
			</div>
			</div>
			</span>';

				} elseif ($loop->type == 'file') {
					echo '
			<div class="w3-margin-bottom">
			<span class="formedit-file">
				<label>' . $title . ' :</label>
				<div class="w3-row w3-margin-bottom">
					<!--div class="w3-col m2 l2 w3-center">&nbsp;</div-->
					<div class="w3-col m10 l8 w3-center">
						<input type="text" class="mb_file file mbinput w3-input w3-padding w3-border w3-round w3-margin-bottom" name="' . $keyEsc . '" value="' . $valueEsc . '" style="margin-top:30px">
					</div>
					<div class="w3-col m2 l2 w3-center">
						<button class="mb_filebtn choose-file w3-btn w3-gs-main w3-round" style="margin-top:30px; padding:4px 6px">
						<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 16 16"><path fill="currentColor" fill-rule="evenodd" d="M11 13.5H5A1.5 1.5 0 0 1 3.5 12V4A1.5 1.5 0 0 1 5 2.5h2V5a3 3 0 0 0 3 3h2.5v4a1.5 1.5 0 0 1-1.5 1.5m1.303-7a1.5 1.5 0 0 0-.242-.318L8.818 2.939a1.5 1.5 0 0 0-.318-.242V5A1.5 1.5 0 0 0 10 6.5zm.818-1.379A3 3 0 0 1 14 7.243V12a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3V4a3 3 0 0 1 3-3h2.757a3 3 0 0 1 2.122.879z" clip-rule="evenodd"/></svg></button>
					</div>
				</div>
			</span>
			</div>';

				} elseif ($loop->type == 'textarea') {
					echo '
			<div class="w3-margin-bottom">
				<label>' . $title . ' :</label>
				<textarea class="mbinput w3-input w3-padding w3-border w3-round w3-margin-bottom" style="width:98%; height:250px;" name="' . $keyEsc . '">' . htmlspecialchars(html_entity_decode($value), ENT_QUOTES, 'UTF-8') . '</textarea>
			</div>';

				} elseif ($loop->type == 'dropdown') {
					$ars = explode('||', $loop->options ?? '');
					echo '
			<div class="w3-margin-bottom">
				<label>' . $title . ' :</label>
				<select class="w3-select w3-border w3-round w3-margin-bottom ' . $keyEsc . '" name="' . $keyEsc . '" style="width:98%">';
					foreach ($ars as $sel) {
						$sel = trim($sel);
						$selEsc = htmlspecialchars($sel, ENT_QUOTES, 'UTF-8');
						$selected = ($sel === trim($value)) ? ' selected' : '';
						echo '<option value="' . $selEsc . '"' . $selected . '>' . $selEsc . '</option>';
					}
					echo '</select>
			</div>';

				} elseif ($loop->type == 'link') {
					global $SITEURL;
					echo '
			<div class="w3-margin-bottom">
				<label>' . $title . ' :</label>
				<select class="w3-select w3-border w3-round w3-margin-bottom ' . $keyEsc . '" name="' . $keyEsc . '" style="width:98%">';
					foreach (glob(GSDATAPAGESPATH . "*.{xml}", GLOB_BRACE) as $page) {
						$path_parts = pathinfo($page);
						$filename = $path_parts['filename'];
						$pageUrl = htmlspecialchars($SITEURL . $filename, ENT_QUOTES, 'UTF-8');
						$filenameEsc = htmlspecialchars($filename, ENT_QUOTES, 'UTF-8');
						$selected = ($SITEURL . $filename === $value) ? ' selected' : '';
						echo '<option value="' . $pageUrl . '"' . $selected . '>' . $filenameEsc . '</option>';
					}
					echo '</select>
			</div>';

				} else {
					// text, color, date, number, etc.
					echo '
			<div class="w3-margin-bottom">
				<label>' . $title . ' :</label>
				<input class="w3-input w3-padding w3-border w3-round w3-margin-bottom" style="width:98%" type="' . htmlspecialchars($loop->type, ENT_QUOTES, 'UTF-8') . '" name="' . $keyEsc . '" value="' . htmlspecialchars(html_entity_decode($value ?? ''), ENT_QUOTES, 'UTF-8') . '">
			</div>';
				}
			}

			echo '
		<div class="w3-margin-top w3-center">
			<button class="w3-btn w3-large w3-round w3-green" type="submit" name="ssettings">' . i18n_r('massiveAdmin/SAVEOPTION') . '</button>
		</div>
	</form>';

		}
	} else {
		echo '<p>' . i18n_r("massiveAdmin/SETTINGS") . ': <em>settings.json not found for this theme.</em></p>';
	}
	?>

	<?php
	global $EDTOOL;
	global $toolbar;
	global $options;
	global $EDOPTIONS;

	if (isset($EDTOOL))
		$EDTOOL = returnJsArray($EDTOOL);
	if (isset($toolbar))
		$toolbar = returnJsArray($toolbar);
	else if (isset($EDTOOL) && strpos(trim($EDTOOL), '[[') !== 0 && strpos(trim($EDTOOL), '[') === 0) {
		$EDTOOL = "[$EDTOOL]";
	}

	if (isset($toolbar) && strpos(trim($toolbar), '[[') !== 0 && strpos($toolbar, '[') === 0) {
		$toolbar = "[$toolbar]";
	}
	$toolbar = isset($EDTOOL) ? ",toolbar: " . trim($EDTOOL, ",") : '';
	$options = isset($EDOPTIONS) ? ',' . trim($EDOPTIONS, ",") : '';
	?>

	<script type="text/javascript" src="template/js/ckeditor/ckeditor.js?t=3.3.16"></script>

	<script type="text/javascript">
		document.querySelectorAll('#post-content').forEach(function(c) {
			CKEDITOR.replace(c, {
				skin: 'getsimple',
				forcePasteAsPlainText: true,
				language: 'en',
				defaultLanguage: 'en',
				<?php
				global $TEMPLATE;
				if (file_exists(GSTHEMESPATH . $TEMPLATE . "/editor.css")) {
					$fullpath = suggest_site_path();
					?>
					contentsCss: '<?php echo $fullpath; ?>theme/<?php echo $TEMPLATE; ?>/editor.css',
				<?php } ?>
				entities: true,
				height: '300px',
				baseHref: '<?php global $SITEURL; echo $SITEURL; ?>',
				tabSpaces: 10,
				filebrowserBrowseUrl: 'filebrowser.php?type=all',
				filebrowserImageBrowseUrl: 'filebrowser.php?type=images',
				filebrowserWindowWidth: '730',
				filebrowserWindowHeight: '500'
				<?php echo $toolbar; ?>
				<?php echo $options; ?>
			});
		});
	</script>

	<script>
		if (document.querySelector('.mb_foto') !== null) {
			document.querySelectorAll('.formedit').forEach(function(e) {
				e.querySelector('.choose-image').addEventListener('click', function(y) {
					y.preventDefault();
					var funcName = e.querySelector('input[type="text"]').getAttribute('name');
					var url = <?php global $SITEURL; echo json_encode($SITEURL . "plugins/massiveAdmin/files/imagebrowser.php?"); ?> + "&func=" + encodeURIComponent(funcName);
					var win = window.open(url, "myWindow", "toolbar=no,scrollbars=no,menubar=no,width=500,height=500");
					win.focus();
				});
			});
		}

		if (document.querySelector('.mb_file') !== null) {
			document.querySelectorAll('.formedit-file').forEach(function(e) {
				e.querySelector('.choose-file').addEventListener('click', function(y) {
					y.preventDefault();
					var funcName = e.querySelector('input[type="text"]').getAttribute('name');
					var url = <?php global $SITEURL; echo json_encode($SITEURL . "plugins/massiveAdmin/files/filebrowser.php?"); ?> + "&type=all&func=" + encodeURIComponent(funcName);
					var win = window.open(url, "myWindow", "toolbar=no,scrollbars=no,menubar=no,width=500,height=500");
					win.focus();
				});
			});
		}
	</script>

	<!-- The Modal -->
	<div id="id01" class="w3-modal">
		<div class="w3-modal-content">
			<div class="w3-container">
				<span onclick="document.getElementById('id01').style.display='none'"
					class="w3-button w3-red w3-xlarge w3-display-topright" style="font-size:2em">&times;</span>

				<h3><?php echo i18n_r("massiveAdmin/HOWCREATETITLE"); ?></h3>
				<p><?php echo i18n_r("massiveAdmin/TUTORIALHOWCREATESETTINGS"); ?></p>
				<hr>

				<div class="w3-codespan w3-padding w3-margin" style="height: 350px; overflow-y: scroll;">
					{<br>
					"settings": {<br><br>
					"fieldname1": {<br>
					"type": "text",<br>
					"title": "field title 1",<br>
					"value": ""<br>
					},<br><br>
					"fieldname2": {<br>
					"type": "wysywig",<br>
					"title": "field title 2",<br>
					"value": ""<br>
					},<br><br>
					"fieldname3": {<br>
					"type": "textarea",<br>
					"title": "field title 3",<br>
					"value": ""<br>
					},<br><br>
					"fieldname4": {<br>
					"type": "color",<br>
					"title": "field title 4",<br>
					"value": ""<br>
					},<br><br>
					"fieldname5": {<br>
					"type": "date",<br>
					"title": "field title 5",<br>
					"value": ""<br>
					},<br><br>
					"fieldname6": {<br>
					"type": "image",<br>
					"title": "field title 6",<br>
					"value": ""<br>
					},<br><br>
					"fieldname7": {<br>
					"type": "file",<br>
					"title": "field title 7",<br>
					"value": ""<br>
					},<br><br>
					"fieldname8": {<br>
					"type": "link",<br>
					"title": "field title 8",<br>
					"value": ""<br>
					},<br><br>
					"fieldname9": {<br>
					"type": "dropdown",<br>
					"options": "Options 1 || Options 2",<br>
					"title": "field title 9",<br>
					"value": ""<br>
					&nbsp; &nbsp;}<br>
					&nbsp;}<br>
					}<br>
				</div>

			</div>
		</div>
	</div>

	<?php
	// Add JSON support to the theme editor only once
	if (!file_exists(GSDATAOTHERPATH . 'jsonsupportadded.txt')) {
		$themeEditFile = GSADMINPATH . 'theme-edit.php';
		if (file_exists($themeEditFile)) {
			$f = file_get_contents($themeEditFile);
			$n = str_replace(
				"['php', 'css', 'js', 'html', 'htm']",
				"['php', 'css', 'js', 'html', 'htm', 'json']",
				$f
			);
			file_put_contents($themeEditFile, $n);
		}
		file_put_contents(GSDATAOTHERPATH . 'jsonsupportadded.txt', '1');
	}
	?>
