<link rel="stylesheet" href="<?php global $SITEURL;
echo $SITEURL; ?>plugins/massiveAdmin/css/w3.css">
<link rel="stylesheet" href="<?php global $SITEURL;
echo $SITEURL; ?>plugins/massiveAdmin/css/w3-custom.css">

<style>
	.copybutton {
		display: inline-block;
		position: relative;
		vertical-align: middle;
	}

	.copybutton img {
		transition: transform 0.3s;
		width: 22px;
	}

	.copybutton:hover img {
		transform: scale(1.2);
	}

	.copybutton:active img {
		transform: scale(0.8);
	}
</style>

<div class="w3-parent w3-container"><!-- Start Plug -->

	<h3><?php echo i18n_r('massiveAdmin/EDITSNIPPET'); ?></h3>

	<div class="w3-margin-top w3-right-align">
		<button class="w3-btn w3-tiny w3-round w3-green" type="submit" id="addsnippet" accesskey="a"
			onclick="event.preventDefault();addNewSnippet();"><?php echo i18n_r('massiveAdmin/ADDSNIPPET'); ?>
			+</button>
	</div>

	<hr>

	<form action="#" method="post">
		<div class="snippet-list">

			<?php
			$file = GSDATAOTHERPATH . 'snippetMassive/snippet.json';

			if (file_exists($file)) {
				$readed = json_decode(file_get_contents($file));
			}
			;
			?>

			<?php
			if (file_exists($file)) {
				$fileFolder = GSDATAOTHERPATH . 'snippetMassive/';
				foreach ($readed as $file) {
					$title = $file->title;
					$content = $file->content;
					echo '
				<div class="w3-container">
					<div class="w3-row w3-center w3-margin-bottom w3-padding-large w3-panel w3-gs-main w3-round">
						<div class="w3-half w3-left-align">
							<span class="shortcode tpl" id="' . $title . '">&#60;?php get_snippet("' . $title . '");?></span>
							<a href="javascript:;" class="copybutton">
								<image id="copy-' . $title . '" data-clipboard-target="#' . $title . '" src=" data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAQAAABKfvVzAAAAIGNIUk0AAHomAACAhAAA+gAAAIDoAAB1MAAA6mAAADqYAAAXcJy6UTwAAAACYktHRAAAqo0jMgAAAAlwSFlzAAAAYAAAAGAA8GtCzwAAAAd0SU1FB+cFFgkEJsO3fd8AAADQSURBVDjLvZM7CsJAFEWP0SKSUlJoOi2yiDSJK3ALFindUMBSV2HAzyJEQVHxU0gqm5QWAXWSyWdAPeV9c7nzLjPwa2pS1cPHFJQ7AXMATXp8hpPSHELcvNQpR/SUpnNikpfQZk+c0mJ2dAAaEsOjaGmZYahqiKoYCooU0VSLTBJ8ztipZnS2+NkMrbxIAJr0uOYtLdJijIGNRfBOKGeFx6JaQsQgu4MC/zLc6GYe9KtIkeTHuYRc2AgTG4t+0swndQAOLDAxhMmaEUvVC3+DJ4xiLDPLiEozAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDIzLTA1LTIyVDA5OjA0OjM4KzAwOjAwa+wQugAAACV0RVh0ZGF0ZTptb2RpZnkAMjAyMy0wNS0yMlQwOTowNDozOCswMDowMBqxqAYAAAAodEVYdGRhdGU6dGltZXN0YW1wADIwMjMtMDUtMjJUMDk6MDQ6MzgrMDA6MDBNpInZAAAAAElFTkSuQmCC">
							</a>
						</div>
						
						<div class="w3-half w3-right-align">
							<button class="w3-bar-item w3-btn w3-red w3-round w3-right"  style="padding:0 5px; border:black solid 1px" onclick="event.preventDefault();closeThisSnippet(this)"><svg xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24" id="trash"><path fill="#fff" d="M20,6H16V5a3,3,0,0,0-3-3H11A3,3,0,0,0,8,5V6H4A1,1,0,0,0,4,8H5V19a3,3,0,0,0,3,3h8a3,3,0,0,0,3-3V8h1a1,1,0,0,0,0-2ZM10,5a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1V6H10Zm7,14a1,1,0,0,1-1,1H8a1,1,0,0,1-1-1V8H17Z"></path></svg></button>
						</div>
					</div>
					
					<input class="w3-input w3-border w3-round w3-margin-bottom" style="width:98%;" type="text" required  pattern="[a-zA-Z0-9_-]+" placeholder="' . i18n_r('massiveAdmin/TITLESNIPPET') . '" value="' . $title . '" name="snippetTitle[]">
					
					<textarea name="content[]" class="snippet-content" id="post-content" style="width:100%;">' . $content . '</textarea>
				
					<hr style="margin:30px 0; border:lightgrey 1px dashed">
				</div>
				
				<script>
					document.getElementById("copy-' . $title . '").addEventListener("click", copyCodeToClipboard);
					function copyCodeToClipboard() {
					  const codeSnippet = document.getElementById("' . $title . '");
					  const range = document.createRange();
					  range.selectNode(' . $title . ');
					  const selection = window.getSelection();
					  selection.removeAllRanges();
					  selection.addRange(range);
					  document.execCommand("copy");
					  selection.removeAllRanges();
					}
				</script>
				';
				}
				;
			}
			;
			?>

			<div class="w3-margin-top w3-center">
				<button class="w3-btn w3-large w3-round w3-green" type="submit"
					value="<?php echo i18n_r('massiveAdmin/SUBMITSNIPPET'); ?>"
					name="snippetSave"><?php echo i18n_r('massiveAdmin/SUBMITSNIPPET'); ?></button>
			</div>

		</div>
	</form>

	<script type="text/javascript" src="template/js/ckeditor/ckeditor.js?t=3.3.18.1"></script>

	<?php
	global $EDTOOL;
	global $toolbar;
	global $options;
	global $EDOPTIONS;


	if (isset($EDTOOL))
		$EDTOOL = returnJsArray($EDTOOL);
	if (isset($toolbar))
		$toolbar = returnJsArray($toolbar); // handle plugins that corrupt this
	else if (strpos(trim($EDTOOL), '[[') !== 0 && strpos(trim($EDTOOL), '[') === 0) {
		$EDTOOL = "[$EDTOOL]";
	}

	if (isset($toolbar) && strpos(trim($toolbar), '[[') !== 0 && strpos($toolbar, '[') === 0) {
		$toolbar = "[$toolbar]";
	}
	$toolbar = isset($EDTOOL) ? ",toolbar: " . trim($EDTOOL, ",") : '';
	$options = isset($EDOPTIONS) ? ',' . trim($EDOPTIONS, ",") : '';
	?>

	<script>
		function addNewSnippet() {
			document.querySelector('.snippet-list').insertAdjacentHTML('afterBegin', `
		<div class="w3-container">
			<button style="border-radius:5px; position:absolute; top:5px; right:10px; background:red; color:#fff; border:none;" onclick="event.preventDefault();closeThisSnippet(this)"> ✕ </button>
			
			<input class="w3-input w3-border w3-round w3-margin-bottom" style="width:98%;" type="text" required  pattern="[a-zA-Z0-9_-]+" placeholder="<?php echo i18n_r('massiveAdmin/TITLESNIPPET'); ?>" name="snippetTitle[]">
			
			<textarea name="content[]" id="post-content" style="width:100%;"></textarea>
				
			<hr style="margin:50px 0;border:lightgrey 2px dashed">
		</div>
		`);

			let editor = CKEDITOR.replace('post-content', {
				skin: 'getsimple',
				forcePasteAsPlainText: true,
				entities: false,
				// uiColor : '#FFFFFF',
				<?php
				global $TEMPLATE;
				if (file_exists(GSTHEMESPATH . $TEMPLATE . "/editor.css")) {
					$fullpath = suggest_site_path();
					?>
												contentsCss: '<?php echo $fullpath; ?>theme/<?php echo $TEMPLATE; ?>/editor.css',
				<?php } ?>
			height: '250px',
				tabSpaces: 10,
				filebrowserBrowseUrl: 'filebrowser.php?type=all',
				filebrowserImageBrowseUrl: 'filebrowser.php?type=images',
				filebrowserWindowWidth: '730',
				filebrowserWindowHeight: '500'
			
			<?php echo $toolbar; ?>
			<?php echo $options; ?>
			});
		}

		document.querySelectorAll('.snippet-content').forEach(x => {
			let editor = CKEDITOR.replace(x, {
				skin: 'getsimple',
				forcePasteAsPlainText: true,
				entities: false,
				// uiColor : '#FFFFFF',
				<?php
				global $TEMPLATE;
				if (file_exists(GSTHEMESPATH . $TEMPLATE . "/editor.css")) {
					$fullpath = suggest_site_path();
					?>
												contentsCss: '<?php echo $fullpath; ?>theme/<?php echo $TEMPLATE; ?>/editor.css',
				<?php } ?>
			height: '250px',
				tabSpaces: 10,
				filebrowserBrowseUrl: 'filebrowser.php?type=all',
				filebrowserImageBrowseUrl: 'filebrowser.php?type=images',
				filebrowserWindowWidth: '730',
				filebrowserWindowHeight: '500'
			
			<?php echo $toolbar; ?>
			<?php echo $options; ?>
			});
		})

		function closeThisSnippet(x) {
			x.closest('.w3-container').remove()

		};
	</script>

	<?php
	if (isset($_POST['snippetSave'])) {
		global $MA;
		$MA->snippetSave();

		echo ("<meta http-equiv='refresh' content='0'>");
	}
	;
	?>