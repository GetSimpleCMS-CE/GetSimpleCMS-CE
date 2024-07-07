<?php 
$filename = GSDATAOTHERPATH . '/massiveHelpDesk/helpdesk.json';
$datee = file_get_contents($filename);
$data = json_decode($datee);
?>

<link rel="stylesheet" href="<?php global $SITEURL; echo $SITEURL; ?>plugins/massiveAdmin/css/w3.css">
<link rel="stylesheet" href="<?php global $SITEURL; echo $SITEURL; ?>plugins/massiveAdmin/css/w3-custom.css">

<div class="w3-parent w3-container"><!-- Start Plug -->

<h3><?php echo i18n_r('massiveAdmin/USERHELP');?></h3>
<hr>

<?php echo $data->content;?>