<h3 class="floated"><?php echo i18n_r('massiveAdmin/EDITSNIPPET'); ?></h3>

<div class="edit-nav">
	<a href="#" onclick="event.preventDefault();addNewSnippet();" id="addsnippet" accesskey="a"><?php echo i18n_r('massiveAdmin/ADDSNIPPET'); ?></a>
	<div class="clear"></div>
</div>

<style>
	.copybutton { display: inline-block; position: relative; vertical-align: middle; }
	.copybutton img { transition: transform 0.3s; width:22px; }
	.copybutton:hover img { transform: scale(1.2); }
	.copybutton:active img { transform: scale(0.8); }
	.shortcode{font-size:small; background-color:#f1f1f1; padding:3px 5px; border:1px solid #B2B2B2; margin-right:5px; border-radius: 5px;}
	.tpl{color:royalblue;}
	.cke{color:hotpink;}
</style>

<form action="#" method="post">
	<div class="snippet-list">

		<?php
			$file = GSDATAOTHERPATH . 'snippetMassive/snippet.xml';

			if (file_exists($file)) {
				$readed = simplexml_load_file($file);
			};
		?>

		<?php
			if (file_exists($file)) {
				$fileFolder = GSDATAOTHERPATH . 'snippetMassive/';
				foreach ($readed as $file) {
					$title = $file->title;
					$content = $file->content;
					echo '
					<div style="display:block; position:relative; width:100%; border:solid 1px #ddd; margin-top:15px; background:#fafafa; padding:10px; box-sizing:border-box; padding-top:40px;">
						<div style="position:absolute; top:5px; left:10px;padding-bottom:20px;height:40px;">
							<span id="' . $title . '" class="shortcode tpl">&#60;?php get_snippet("' . $title . '");?></span>
							<a href="javascript:;" class="copybutton">
							<image id="copy-' . $title . '" data-clipboard-target="#' . $title . '" src=" data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAQAAABKfvVzAAAAIGNIUk0AAHomAACAhAAA+gAAAIDoAAB1MAAA6mAAADqYAAAXcJy6UTwAAAACYktHRAAAqo0jMgAAAAlwSFlzAAAAYAAAAGAA8GtCzwAAAAd0SU1FB+cFFgkEJsO3fd8AAADQSURBVDjLvZM7CsJAFEWP0SKSUlJoOi2yiDSJK3ALFindUMBSV2HAzyJEQVHxU0gqm5QWAXWSyWdAPeV9c7nzLjPwa2pS1cPHFJQ7AXMATXp8hpPSHELcvNQpR/SUpnNikpfQZk+c0mJ2dAAaEsOjaGmZYahqiKoYCooU0VSLTBJ8ztipZnS2+NkMrbxIAJr0uOYtLdJijIGNRfBOKGeFx6JaQsQgu4MC/zLc6GYe9KtIkeTHuYRc2AgTG4t+0swndQAOLDAxhMmaEUvVC3+DJ4xiLDPLiEozAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDIzLTA1LTIyVDA5OjA0OjM4KzAwOjAwa+wQugAAACV0RVh0ZGF0ZTptb2RpZnkAMjAyMy0wNS0yMlQwOTowNDozOCswMDowMBqxqAYAAAAodEVYdGRhdGU6dGltZXN0YW1wADIwMjMtMDUtMjJUMDk6MDQ6MzgrMDA6MDBNpInZAAAAAElFTkSuQmCC"></a>
						</div>
						<button style="border-radius:5px; position:absolute; top:5px; right:10px; background:red; color:#fff; border:none;" onclick="event.preventDefault();closeThisSnippet(this)"> ✕ </button>
						<input type="text" required  pattern="[a-zA-Z0-9]+" style="width:100%; padding:10px; margin-bottom:10px;" placeholder="' . i18n_r('massiveAdmin/TITLESNIPPET') . '" value="' .  $title . '" name="snippetTitle[]">
						<textarea name="content[]" class="snippet-content" id="post-content" style="width:100%;">' . $content . '</textarea>
					</div>
					
					<script>
						document.getElementById("copy-' . $title . '").addEventListener("click", copyCodeToClipboard);
						function copyCodeToClipboard() {
						  const codeSnippet = document.getElementById("' .  $title . '");
						  const range = document.createRange();
						  range.selectNode(' .  $title . ');
						  const selection = window.getSelection();
						  selection.removeAllRanges();
						  selection.addRange(range);
						  document.execCommand("copy");
						  selection.removeAllRanges();
						}
					</script>
					
					';
				};
			};
		?>

		<div style="width:100%; margin-top:20px;" class="submit-show">
			<input type="submit" class="submit" name="snippetSave" id="button" value="<?php echo i18n_r('massiveAdmin/SUBMITSNIPPET');?>">
		</div>

	</div>
</form>

<script type="text/javascript" src="template/js/ckeditor/ckeditor.js?t=3.3.18.1"></script>

<?php 
	global $EDTOOL;
	global $EDOPTIONS;

	if(isset($EDTOOL)) $EDTOOL = returnJsArray($EDTOOL);
	if(isset($toolbar)) $toolbar = returnJsArray($toolbar); // handle plugins that corrupt this

	else if(strpos(trim($EDTOOL),'[[')!==0 && strpos(trim($EDTOOL),'[')===0){ $EDTOOL = "[$EDTOOL]"; }

	if(isset($toolbar) && strpos(trim($toolbar),'[[')!==0 && strpos($toolbar,'[')===0){ $toolbar = "[$toolbar]"; }
	$toolbar = isset($EDTOOL) ? ",toolbar: ".trim($EDTOOL,",") : '';
	$options = isset($EDOPTIONS) ? ','.trim($EDOPTIONS,",") : '';
?>

<script>
	function addNewSnippet() {
		document.querySelector('.snippet-list').insertAdjacentHTML('afterBegin', `
		<div style="display:block; position:relative; width:100%; border:solid 1px #ddd; margin-top:15px; background:#fafafa; padding:10px; box-sizing:border-box; padding-top:30px;">
			<button style="border-radius:5px; position:absolute; top:5px; right:10px; background:red; color:#fff; border:none;" onclick="event.preventDefault();closeThisSnippet(this)"> ✕ </button>
			<input type="text" required  pattern="[a-zA-Z0-9]+" style="width:100%; padding:10px; margin-bottom:10px;" placeholder="<?php echo i18n_r('massiveAdmin/TITLESNIPPET');?>"  name="snippetTitle[]">
			<textarea name="content[]" id="post-content" style="width:100%;"></textarea>
		</div>
		`);

		let editor = CKEDITOR.replace('post-content', {
			skin: 'getsimple',
			forcePasteAsPlainText: true,
			entities: false,
			// uiColor : '#FFFFFF',
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
		x.parentElement.remove();
	};
</script>

<?php if (isset($_POST['snippetSave'])) {
	global $MA;
	$MA->snippetSave();

	echo ("<meta http-equiv='refresh' content='0'>");
}; ?>