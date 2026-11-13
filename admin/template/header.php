<?php if(!defined('IN_GS')){ die('you cannot load this page directly.'); }
/**
 * Header Admin Template
 *
 * @package GetSimple
 */
 
global $SITENAME, $SITEURL, $USR;

$GSSTYLE         = getDef('GSSTYLE') ? GSSTYLE : '';
$GSSTYLE_sbfixed = in_array('sbfixed',explode(',',$GSSTYLE));
$GSSTYLE_wide    = in_array('wide',explode(',',$GSSTYLE));

$bodyclass="class=\"gs-admin";
if( $GSSTYLE_sbfixed ) $bodyclass .= " sbfixed";
if( $GSSTYLE_wide )    $bodyclass .= " wide";
if( isAuthPage() )     $bodyclass .= " gs-auth";
$bodyclass .="\"";

if(get_filename_id()!='index') exec_action('admin-pre-header');

?>
<!DOCTYPE html>
<html lang="<?php echo get_site_lang(true); ?>" class="gs-admin-root">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"  />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title><?php echo $title ?></title>
	<script>
	(function(){try{var t=localStorage.getItem('gs-admin-theme');var d=t?t==='dark':window.matchMedia&&window.matchMedia('(prefers-color-scheme: dark)').matches;document.documentElement.classList.toggle('dark',!!d);}catch(e){}})();
	</script>
	<?php if(!isAuthPage()) { ?><meta name="generator" content="GetSimple - <?php echo GSVERSION; ?>" /> 
	<link rel="shortcut icon" href="favicon.png" type="image/x-icon" />
	<link rel="apple-touch-icon" href="apple-touch-icon.png"/>
	<link rel="stylesheet" type="text/css" href="template/style.php?<?php echo 's='.$GSSTYLE.'&amp;v='.GSVERSION; ?>" media="screen" />
	<link rel="stylesheet" type="text/css" href="template/css/tailwind-admin.css?v=<?php echo GSVERSION; ?>" media="screen" />
	<!--[if IE 6]><link rel="stylesheet" type="text/css" href="template/ie6.css?v=<?php echo GSVERSION; ?>" media="screen" /><![endif]-->
    <?php
		if($GSSTYLE_sbfixed) queue_script('scrolltofixed', GSBACK);
		get_scripts_backend();
	?>
	<script type="text/javascript" src="template/js/jquery.getsimple.js?v=<?php echo GSVERSION; ?>"></script>
	<link rel="stylesheet" type="text/css" href="template/css/admin-modern.css?v=<?php echo GSVERSION; ?>" media="screen" />
	<?php  } else { ?> 
	<link rel="shortcut icon" href="favicon.png" type="image/x-icon" />
	<link rel="apple-touch-icon" href="apple-touch-icon.png"/>
	<meta name="robots" content="noindex, nofollow">
	<link rel="stylesheet" type="text/css" href="template/style.php" media="screen" />
	<link rel="stylesheet" type="text/css" href="template/css/tailwind-admin.css?v=<?php echo GSVERSION; ?>" media="screen" />
	<link rel="stylesheet" type="text/css" href="template/css/admin-modern.css?v=<?php echo GSVERSION; ?>" media="screen" />
	<!--[if IE 6]><link rel="stylesheet" type="text/css" href="template/ie6.css" media="screen" /><![endif]-->
	<?php } ?>
	<!--[if lt IE 9]><script type="text/javascript" src="//html5shiv.googlecode.com/svn/trunk/html5.js" ></script><![endif]-->
	<?php if(get_filename_id()=='image') { ?>
	<script type="text/javascript" src="template/js/jcrop/jquery.Jcrop.min.js"></script>
	<link rel="stylesheet" type="text/css" href="template/js/jcrop/jquery.Jcrop.css" media="screen" />
	<?php } ?>

    <?php 
	# Plugin hook to allow insertion of stuff into the header
	if(!isAuthPage()) exec_action('header'); 
	
	function doVerCheck(){
		return !isAuthPage() && !getDef('GSNOVERCHECK');
	}

    if( doVerCheck() ) { ?>
	<script type="text/javascript">		
		// check to see if core update is needed
		jQuery(document).ready(function() { 
			<?php 
				$data = get_api_details();
				if ($data) {
					$apikey = json_decode($data);
					
					if(isset($apikey->status)) {
						$verstatus = $apikey->status;
			?>
				var verstatus = <?php echo $verstatus; ?>;
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
		<div class="wrapper gs-topbar tw-flex tw-items-center tw-gap-3">
			<button type="button" class="gs-iconbtn gs-nav-toggle tw-inline-flex tw-items-center tw-justify-center" id="gs-nav-toggle" aria-label="Toggle navigation" aria-expanded="false">
				<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
			</button>
			<h1 id="sitename" class="gs-brand"><a href="<?php echo $SITEURL; ?>" target="_blank" rel="noopener"><?php echo cl($SITENAME); ?></a></h1>
			<div class="gs-topbar-actions tw-flex tw-items-center tw-gap-2">
				<button type="button" class="gs-iconbtn gs-theme-toggle tw-inline-flex tw-items-center tw-justify-center" id="gs-theme-toggle" aria-label="Toggle dark mode" title="<?php i18n('DARK_MODE'); ?>">
					<svg class="gs-icon-sun" viewBox="0 0 24 24" width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/></svg>
					<svg class="gs-icon-moon" viewBox="0 0 24 24" width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
				</button>
				<?php if(cookie_check()) { ?>
					<a class="gs-chip tw-inline-flex tw-items-center tw-gap-1" href="settings.php#profile" title="<?php echo htmlspecialchars($USR); ?>"><?php i18n('WELCOME'); ?> <strong><?php echo htmlspecialchars($USR); ?></strong></a>
					<a class="gs-chip gs-chip-danger tw-inline-flex tw-items-center tw-gap-1" href="logout.php" accesskey="<?php echo find_accesskey(i18n_r('TAB_LOGOUT')); ?>"><?php i18n('TAB_LOGOUT'); ?></a>
				<?php } ?>
			</div>
		</div>
	 <?php exec_action('header-body'); ?>
