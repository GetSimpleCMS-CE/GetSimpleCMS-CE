<?php
// CSRF protection using HMAC of the session ID.
global $SITEURL, $GSADMIN, $MA;
$unistaller_token = hash_hmac('sha256', 'massive_admin_unistaller', session_id());
$unistaller_error = null;

if (isset($_POST['delPlugin'])) {
	$submitted = $_POST['unistaller_csrf_token'] ?? '';
	if (!hash_equals($unistaller_token, $submitted)) {
		$unistaller_error = 'Invalid security token. Please reload the page and try again.';
	} else {
		$result = $MA->unistaller();
		if (!$result['deleted']) {
			$unistaller_error = $result['reason'];
		}
	}
}
?>
<link rel="stylesheet" href="<?php global $SITEURL; echo $SITEURL; ?>plugins/massiveAdmin/css/w3.css">
<link rel="stylesheet" href="<?php global $SITEURL; echo $SITEURL; ?>plugins/massiveAdmin/css/w3-custom.css">
<style>
.w3-ul{margin-left:0!important}
p.w3-bar-item {font-weight:600;}
.w3-ul li:nth-child(odd) {background: #F3F3F3;}
form.unistallerForm{display:inline;margin:0;}
</style>

<div class="w3-parent w3-container"><!-- Start Plug -->

<h3><?php echo i18n_r('massiveAdmin/UNISTALLER');?></h3>
<hr>
<?php if ($unistaller_error): ?>
	<div style="background:#c0392b; width:100%; text-align:center; padding:10px; border-radius:3px; color:#fff; margin-bottom:10px;">
		<?php echo htmlspecialchars($unistaller_error, ENT_QUOTES, 'UTF-8'); ?>
	</div>
<?php endif; ?>
<div class="w3-container">
	<ul class="w3-ul w3-hoverable">
		<?php
			foreach( glob(GSPLUGINPATH.'*.php') as $file) {

			$filename = pathinfo($file)['filename'];
				echo '
		<li class="w3-bar" data-plugin="' . htmlspecialchars($filename, ENT_QUOTES, 'UTF-8') . '">
			<p class="w3-bar-item" style="padding-bottom:0">'.htmlspecialchars($filename, ENT_QUOTES, 'UTF-8').'</p>
			<form class="unistallerForm" method="post" action="' . htmlspecialchars($SITEURL.$GSADMIN.'/load.php?id=massiveAdmin&unistaller', ENT_QUOTES, 'UTF-8') . '" onsubmit="return confirm(`'.i18n_r('massiveAdmin/UNISTALLQUESTION').' '.htmlspecialchars($filename, ENT_QUOTES, 'UTF-8').'?`);">
				<input type="hidden" name="delPlugin" value="' . htmlspecialchars($filename, ENT_QUOTES, 'UTF-8') . '">
				<input type="hidden" name="unistaller_csrf_token" value="' . htmlspecialchars($unistaller_token, ENT_QUOTES, 'UTF-8') . '">
				<button type="submit" title="'.i18n_r('ASK_DELETE').'" class="w3-bar-item w3-btn w3-red w3-round w3-right" style="margin-top:5px; padding: 2px 5px; border:none;"><svg xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24" id="trash"><path fill="#fff" d="M20,6H16V5a3,3,0,0,0-3-3H11A3,3,0,0,0,8,5V6H4A1,1,0,0,0,4,8H5V19a3,3,0,0,0,3,3h8a3,3,0,0,0,3-3V8h1a1,1,0,0,0,0-2ZM10,5a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1V6H10Zm7,14a1,1,0,0,1-1,1H8a1,1,0,0,1-1-1V8H17Z"></path></svg></button>
			</form>
		</li>';
			};
		?>
	</ul>
</div>
<script>
	// Function to hide <li> elements for plugins that should never be deletable via this UI
	function hideListItemsContainingWords(words) {
		var listItems = document.querySelectorAll('li[data-plugin]');

		listItems.forEach(function(item) {
			var plugin = item.getAttribute('data-plugin');
			for (var i = 0; i < words.length; i++) {
				if (plugin === words[i]) {
					item.style.display = 'none';
					break;
				}
			}
		});
	}
	hideListItemsContainingWords(['massiveAdmin', 'Dashboard', 'UpdateCE', 'gsConfigGUI']);
</script>
