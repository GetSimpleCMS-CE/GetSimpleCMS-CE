<?php 
$folder = GSDATAOTHERPATH . '/massiveOwnFooter/';
$filename = GSDATAOTHERPATH . '/massiveOwnFooter/OwnFooter.json';
$datee = @file_get_contents($filename);
$data = json_decode($datee);

$thisfilew = GSDATAOTHERPATH . 'website.xml';
if (file_exists($thisfilew)) {
	$dataw = getXML($thisfilew);
	$SITENAME = html_entity_decode(stripslashes($dataw->SITENAME), ENT_QUOTES | ENT_HTML5, 'UTF-8');
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
	
	// Decode any HTML entities in the footer name
	$footerName = isset($data->ownfootername) && !empty($data->ownfootername) 
		? html_entity_decode($data->ownfootername, ENT_QUOTES | ENT_HTML5, 'UTF-8')
		: '';
?>
<script>
	(function() {
		<?php if ($iconExists): ?>
		// Update footer logo
		var gslogoImg = document.querySelector('.gslogo img');
		if (gslogoImg) {
			gslogoImg.setAttribute('src', <?php echo json_encode($SITEURL . 'data/other/footerfoto/' . $data->ownfootericon, JSON_UNESCAPED_UNICODE); ?>);
			gslogoImg.style.maxHeight = "30px";
			gslogoImg.setAttribute('alt', <?php echo json_encode($footerName, JSON_UNESCAPED_UNICODE); ?>);
			gslogoImg.setAttribute('title', <?php echo json_encode($footerName, JSON_UNESCAPED_UNICODE); ?>);
		}
		
		// Update site logo
		var sitenameLink = document.querySelector('#sitename a');
		if (sitenameLink) {
			var img = document.createElement('img');
			img.className = 'logocustom';
			img.style.verticalAlign = 'middle';
			img.src = <?php echo json_encode($SITEURL . 'data/other/footerfoto/' . $data->ownfootericon, JSON_UNESCAPED_UNICODE); ?>;
			img.alt = <?php echo json_encode($SITENAME, JSON_UNESCAPED_UNICODE); ?>;
			
			var span = document.createElement('span');
			span.className = 'sitename';
			span.textContent = <?php echo json_encode($SITENAME, JSON_UNESCAPED_UNICODE); ?>;
			
			sitenameLink.innerHTML = '';
			sitenameLink.appendChild(img);
			sitenameLink.appendChild(document.createTextNode(' '));
			sitenameLink.appendChild(span);
		}
		<?php endif; ?>
		
		// Update footer link (even without icon)
		var gslogoLink = document.querySelector('.gslogo a');
		if (gslogoLink) {
			<?php if (isset($data->ownfooterlink) && !empty($data->ownfooterlink)): ?>
			gslogoLink.setAttribute('href', <?php echo json_encode($data->ownfooterlink, JSON_UNESCAPED_UNICODE); ?>);
			<?php endif; ?>
		}
		
		// Update footer text
		var footerLeft = document.querySelector('.footer-left');
		if (footerLeft) {
			footerLeft.style.marginTop = "5px";
			<?php if ($footerName): ?>
			footerLeft.textContent = <?php echo json_encode(date('Y') . ' © ' . $footerName, JSON_UNESCAPED_UNICODE); ?>;
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
