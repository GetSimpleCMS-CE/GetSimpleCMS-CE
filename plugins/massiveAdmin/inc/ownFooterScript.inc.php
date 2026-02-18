<?php 
$folder = GSDATAOTHERPATH . '/massiveOwnFooter/';
$filename = GSDATAOTHERPATH . '/massiveOwnFooter/OwnFooter.json';
$datee = @file_get_contents($filename);
$data = json_decode($datee);

$thisfilew = GSDATAOTHERPATH . 'website.xml';
if (file_exists($thisfilew)) {
	$dataw = getXML($thisfilew);
	$SITENAME = stripslashes($dataw->SITENAME);
	$SITEURL = $dataw->SITEURL;
	$TEMPLATE = $dataw->TEMPLATE;
	$PRETTYURLS = $dataw->PRETTYURLS;
	$PERMALINK = $dataw->PERMALINK;
} else {
	$SITENAME = '';
	$SITEURL = '';
}

// Check if feature is turned on
if (isset($data->turnon) && $data->turnon == 'true'):
	$hasIcon = isset($data->ownfootericon) && !empty($data->ownfootericon);
	$iconPath = $hasIcon ? GSDATAOTHERPATH . '/footerfoto/' . $data->ownfootericon : '';
	$iconExists = $hasIcon && file_exists($iconPath);
?>
<script>
	(function() {
		<?php if ($iconExists): ?>
		// Update footer logo
		var gslogoImg = document.querySelector('.gslogo img');
		if (gslogoImg) {
			gslogoImg.setAttribute('src', '<?php echo htmlspecialchars($SITEURL . 'data/other/footerfoto/' . $data->ownfootericon, ENT_QUOTES, 'UTF-8'); ?>');
			gslogoImg.style.maxHeight = "30px";
			gslogoImg.setAttribute('alt', '<?php echo htmlspecialchars($data->ownfootername ?? '', ENT_QUOTES, 'UTF-8'); ?>');
			gslogoImg.setAttribute('title', '<?php echo htmlspecialchars($data->ownfootername ?? '', ENT_QUOTES, 'UTF-8'); ?>');
		}
		
		// Update site logo
		var sitenameLink = document.querySelector('#sitename a');
		if (sitenameLink) {
			sitenameLink.innerHTML = '<img class="logocustom" style="vertical-align:middle;" src="<?php echo htmlspecialchars($SITEURL . 'data/other/footerfoto/' . $data->ownfootericon, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($SITENAME, ENT_QUOTES, 'UTF-8'); ?>"> <span class="sitename"><?php echo htmlspecialchars($SITENAME, ENT_QUOTES, 'UTF-8'); ?></span>';
		}
		<?php endif; ?>
		
		// Update footer link (even without icon)
		var gslogoLink = document.querySelector('.gslogo a');
		if (gslogoLink) {
			<?php if (isset($data->ownfooterlink) && !empty($data->ownfooterlink)): ?>
			gslogoLink.setAttribute('href', '<?php echo htmlspecialchars($data->ownfooterlink, ENT_QUOTES, 'UTF-8'); ?>');
			<?php endif; ?>
		}
		
		// Update footer text
		var footerLeft = document.querySelector('.footer-left');
		if (footerLeft) {
			footerLeft.style.marginTop = "5px";
			<?php if (isset($data->ownfootername) && !empty($data->ownfootername)): ?>
			footerLeft.innerHTML = '<?php echo date('Y'); ?> © <?php echo htmlspecialchars($data->ownfootername, ENT_QUOTES, 'UTF-8'); ?>';
			<?php endif; ?>
		}
	})();
</script>

<?php
endif;

// Output custom footer code if it exists
if (file_exists($filename) && isset($data->ownfooter) && !empty($data->ownfooter)) {
	echo $data->ownfooter;
}
