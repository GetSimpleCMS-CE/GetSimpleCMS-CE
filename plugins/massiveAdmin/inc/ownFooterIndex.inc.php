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
} ;

?>


<script>

if( "<?php if(isset($data->ownlogo)){echo $data->ownlogo;};?>" =="yes"){
    document.querySelector('.uil-user-circle').classList.add('loger');
    document.querySelector('.loger').classList.remove('uil-user-circle','uil');
    document.querySelector('.loger').insertAdjacentHTML('afterbegin','<img class="logo" style="max-height:100px">');
document.querySelector('.logo').setAttribute('src','<?php echo $SITEURL.'data/other/footerfoto/';?><?php if(isset($data->ownfootericon)){echo $data->ownfootericon;}?>');
}

</script>