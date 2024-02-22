<?php if (!defined('IN_GS')) {
    die('you cannot load this page directly.');
}
/****************************************************
 *
 * @File: 		header.inc.php
 * @Package:	GetSimple CE
 * @Action:		Starter for GetSimple CMS CE
 *
 *****************************************************/
?>


<!DOCTYPE html data->
<html <?php echo ($mode !== '' ? 'data-theme="' . $mode . '"' : ''); ?>>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php get_page_clean_title(); ?> | <?php get_site_name(); ?></title>
    <link rel="stylesheet" type="text/css" href="<?php get_theme_url(); ?>/css/pico.min.css">
    <?php echo ($bootstrap !== 'yes' ?  '' : '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.3/css/bootstrap-grid.min.css" integrity="sha512-JQksK36WdRekVrvdxNyV3B0Q1huqbTkIQNbz1dlcFVgNynEMRl0F8OSqOGdVppLUDIvsOejhr/W5L3G/b3J+8w==" crossorigin="anonymous" referrerpolicy="no-referrer" />'); ?>
    <link rel="stylesheet" type="text/css" href="<?php get_theme_url(); ?>/css/style.css?v=<?php echo rand(); ?>">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <?php get_header(); ?>
</head>

<body>

    <header class="header">
        <div class="container">
            <nav class="header-grid">

                <a class="contrast header-logo" href="<?php get_site_url(); ?>">
                <?php echo ($logo == '' ?  get_site_name() : '<img src="' . $logo . '" style="width:60px;">'); ?>
                </a>

                <button class="header-mobile-btn hide-desktop">
                    <img src="<?php get_theme_url(); ?>/images/bar.svg" alt="">
                </button>

                <ul class=" header-nav hide-mobile">
                    <?php get_navigation(); ?>
                </ul>

            </nav>
        </div>
    </header>
