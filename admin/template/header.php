<?php if(!defined('IN_GS')){ die('you cannot load this page directly.'); }
/**
 * Header Admin Template
 *
 * @package GetSimple
 */
 
global $SITENAME, $SITEURL;

$GSSTYLE         = getDef('GSSTYLE') ? GSSTYLE : '';
$GSSTYLE_sbfixed = in_array('sbfixed',explode(',',$GSSTYLE));
$GSSTYLE_wide    = in_array('wide',explode(',',$GSSTYLE));

$bodyclass="class=\"";
if( $GSSTYLE_sbfixed ) $bodyclass .= " sbfixed";
if( $GSSTYLE_wide )    $bodyclass .= " wide";
$bodyclass .="\"";

if(get_filename_id()!='index') exec_action('admin-pre-header');

?>
<!DOCTYPE html>
<html lang="<?php echo get_site_lang(true); ?>">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"  />
	<title><?php echo $title ?></title>
	<?php if(!isAuthPage()) { ?><meta name="generator" content="GetSimple - <?php echo GSVERSION; ?>" /> 
	<link rel="shortcut icon" href="favicon.png" type="image/x-icon" />
	<link rel="apple-touch-icon" href="apple-touch-icon.png"/>
	<link rel="stylesheet" type="text/css" href="template/style.php?<?php echo 's='.$GSSTYLE.'&amp;v='.GSVERSION; ?>" media="screen" />
	<!--[if IE 6]><link rel="stylesheet" type="text/css" href="template/ie6.css?v=<?php echo GSVERSION; ?>" media="screen" /><![endif]-->
    <?php
		if($GSSTYLE_sbfixed) queue_script('scrolltofixed', GSBACK);
		get_scripts_backend();
	?>
	
	<script type="text/javascript" src="template/js/getsimple.js"></script>
	<?php  } else { ?> 
	<link rel="shortcut icon" href="favicon.png" type="image/x-icon" />
	<link rel="apple-touch-icon" href="apple-touch-icon.png"/>
	<meta name="robots" content="noindex, nofollow">
	<link rel="stylesheet" type="text/css" href="template/style.php" media="screen" />
	<!--[if IE 6]><link rel="stylesheet" type="text/css" href="template/ie6.css" media="screen" /><![endif]-->
	<?php } ?>
	<!--[if lt IE 9]><script type="text/javascript" src="//html5shiv.googlecode.com/svn/trunk/html5.js" ></script><![endif]-->

    <?php 
	# Plugin hook to allow insertion of stuff into the header
	if(!isAuthPage()) exec_action('header'); 
	
	function doVerCheck(){
		return !isAuthPage() && !getDef('GSNOVERCHECK');
	}

    if( doVerCheck() ) { ?>
	<script type="text/javascript">		
		// check to see if core update is needed
		document.addEventListener('DOMContentLoaded', function() {
			<?php 
				$data = get_api_details();
				if ($data) {
					$apikey = json_decode($data);
					
					if(isset($apikey->status)) {
						$verstatus = $apikey->status;
			?>
				var verstatus = <?php echo $verstatus; ?>;
				/*if(verstatus != 1) {
					<?php if(isBeta()){ ?> document.querySelectorAll('a.support').forEach(function(anchor) {
    var parentLi = anchor.closest('li');
    if (parentLi) {
        var span = document.createElement('span');
        span.className = 'info';
        span.textContent = 'i';
        parentLi.appendChild(span);
    }
});
					<?php } else { ?> document.querySelectorAll('a.support').forEach(function(anchor) {
    var parentLi = anchor.closest('li');
    if (parentLi) {
        var span = document.createElement('span');
        span.className = 'warning';
        span.textContent = '!';
        parentLi.appendChild(span);
    }
}); <?php } ?>
					document.querySelectorAll('a.support').forEach(function(anchor) {
    anchor.setAttribute('href', 'health-check.php');
});
				}*/
			<?php  }} ?>
		});
	</script>
	<?php } ?>

	<script type="text/javascript">		
		// init gs namespace and i18n
		var GS = {};
		GS.i18n = new Array();
		GS.i18n['PLUGIN_UPDATED'] = '<?php i18n("PLUGIN_UPDATED"); ?>';
		GS.i18n['ERROR'] = '<?php i18n("ERROR"); ?>';
	</script>

</head>

<body <?php filename_id(); echo ' '.$bodyclass; ?> >	
	<div class="header" id="header" >
		<div class="wrapper clearfix">
 <?php exec_action('header-body'); ?>