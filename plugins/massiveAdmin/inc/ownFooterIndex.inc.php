<?php 

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

// Only output script if logo is enabled AND icon exists
if (isset($data->ownlogo) && $data->ownlogo == "yes" && isset($data->ownfootericon) && !empty($data->ownfootericon)):
	$footerimg = $SITEURL . 'data/other/footerfoto/' . $data->ownfootericon;
	$footerIconPath = GSDATAOTHERPATH . '/footerfoto/' . $data->ownfootericon;
	
	// Double-check the file actually exists on disk
	if (file_exists($footerIconPath)):
?>
<script>
	document.addEventListener('DOMContentLoaded', function() {
		var userCircle = document.querySelector('#user-circle');
		var loginElement = document.querySelector('.login');
		
		if (userCircle && loginElement) {
			userCircle.remove();
			loginElement.insertAdjacentHTML('beforebegin', '<img src="<?php echo htmlspecialchars($footerimg, ENT_QUOTES, 'UTF-8'); ?>" style="width:80px;height:80px;object-fit:cover;margin:10px 0;" title="<?php echo htmlspecialchars($data->ownfootername ?? '', ENT_QUOTES, 'UTF-8'); ?>">');
		}
	});
</script>
<?php 
	endif;
endif;
