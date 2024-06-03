<?php if (!defined('IN_GS')) {
    die('you cannot load this page directly.');
}
/****************************************************
 *
 * @File: 		header.inc.php
 * @Package:	W3 Startup
 * @Action:		W3 template for GetSimple CMS CE
 *
 *****************************************************/
?>


<head>
	<title><?php get_page_title(); ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?php get_theme_url(); ?>/assets/css/w3.css">
	<link rel="stylesheet" href="<?php get_theme_url(); ?>/assets/css/all.min.css">
	<style>
		body,h1,h2,h3,h4,h5,h6 {font-family: "Raleway", sans-serif}

		body, html {height: 100%;line-height: 1.8;}

		/* Full height image header */
		.bgimg-1 {
		  background-position: center;
		  background-size: cover;
		  background-image: url("<?php get_theme_url(); ?>/assets/images/mac.jpg");
		  min-height: 100%;
		}

		.w3-bar .w3-button {padding: 16px;}
		.w3-bar-item.w3-button.active{color:white;font-weight:600;background-color:grey;}
		
		div.w3-col.m6 p br{display:none;}
		div.w3-col.m6 p img{display:none;}
		a.w3-bar-item.w3-button.w3-wide.logo img{height:50px;padding-left:8px;margin:-20px;}
	</style>
	<?php get_header(); ?> <!-- ## required in all themes ##-->
</head>
<body>

<!-- Navbar (sit on top) -->
<div class="w3-top">
	<div class="w3-bar w3-white w3-card" id="myNavbar">
		<a href="#home" class="w3-bar-item w3-button w3-wide logo"><img src="<?php get_theme_url(); ?>/assets/images/logo-square.png"><span style="padding-left:30px"><?php echo $site_full_name; ?> v<?php echo get_site_version(); ?></span></a>
		<!-- Right-sided navbar links -->
		<div class="w3-right w3-hide-small">
			<?php get_custom_navigation(); ?> <!-- ## look in functions.php ##-->
		</div>
		<!-- Hide right-floated links on small screens and replace them with a menu icon -->
		<a href="javascript:void(0)" class="w3-bar-item w3-button w3-right w3-hide-large w3-hide-medium" onclick="w3_open()">
			<i class="fa fa-bars"></i>
		</a>
	</div>
</div>

<!-- Sidebar on small screens when clicking the menu icon -->
<nav class="w3-sidebar w3-bar-block w3-black w3-card w3-animate-left w3-hide-medium w3-hide-large" style="display:none" id="mySidebar">
	<a href="javascript:void(0)" onclick="w3_close()" class="w3-bar-item w3-button w3-large w3-padding-16">Close &times;</a>
	<?php get_custom_navigation(); ?> <!-- ## look in functions.php ##-->
</nav>

<!-- Header with full-height image -->
<?php if (return_page_slug() == 'index') { ?>
<header class="bgimg-1 w3-display-container w3-grayscale-min" id="home">
	<div class="w3-display-left w3-text-white" style="padding:48px">
		<span class="w3-jumbo w3-hide-small"><?php get_page_clean_title(); ?> :: <?php get_site_name(); ?></span>
		<br>
		<span class="w3-xxlarge w3-hide-large w3-hide-medium"><?php get_page_clean_title(); ?> :: <?php get_site_name(); ?></span>
		<br>
		<span class="w3-large"><?php get_component("tagline"); ?></span>
		<p>
			<a href="https://getsimple-ce.ovh/" target="_blank" class="w3-button w3-white w3-padding-large w3-large w3-margin-top w3-opacity w3-hover-opacity-off">Learn more and start today</a>
		</p>
	</div>
	<div class="w3-display-bottomleft w3-text-grey w3-large" style="padding:24px 48px">
		<i class="fa-brands fa-square-facebook w3-hover-opacity"></i>
		<i class="fa-brands fa-instagram w3-hover-opacity"></i>
		<i class="fa-brands fa-square-snapchat w3-hover-opacity"></i>
		<i class="fa-brands fa-pinterest-p w3-hover-opacity"></i>
		<i class="fa-brands fa-twitter w3-hover-opacity"></i>
		<i class="fa-brands fa-linkedin w3-hover-opacity"></i>
	</div>
</header>
<?php } else{ ?>
<header class="w3-display-container w3-light-grey w3-center" id="home" style="padding:60px 48px 20px">
	<h1><?php get_page_clean_title(); ?></h1>
</header>
<?php } ?>
