<?php 
	$filename = GSDATAOTHERPATH . '/massiveHelpDesk/helpdesk.json';
	$datee = file_get_contents($filename);
	$data = json_decode($datee);
?>

<h3><?php echo i18n_r('massiveAdmin/USERHELP');?></h3>
<br>

<?php echo $data->content;?>