<?php 

$filename = GSDATAOTHERPATH.'/massiveOwnFooter/OwnFooter.json';
$datee = @file_get_contents($filename);
$data = json_decode($datee);

$thisfilew = GSDATAOTHERPATH .'website.xml';
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
};

?>

<script>
	if ("<?php if (isset($data->ownlogo)) {
				echo $data->ownlogo;
			}; ?>" == "yes") {
		<?php $footerimg = $SITEURL . 'data/other/footerfoto/' . $data->ownfootericon; ?>

		document.addEventListener('DOMContentLoaded', () => {
			document.querySelector('#user-circle').remove();
			document.querySelector('.login').insertAdjacentHTML('beforebegin', `<img src="<?php echo $footerimg; ?>" style="width:80px;height:80px;object-fit:cover;margin:10px 0;">`);
		})
	}
</script>