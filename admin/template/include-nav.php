<?php
/**
 * Navigation Include Template
 *
 * @package GetSimple
 */
 
$debugInfoUrl = 'https://github.com/GetSimpleCMS-CE/GetSimpleCMS-CE/wiki/Debugging';

//determine page type if plugin is being shown
if (get_filename_id() == 'load') {
	$plugin_class = $plugin_info[$plugin_id]['page_type'];
} else {
	$plugin_class = '';
}

?>
<div class="gs-navwrap tw-w-full">
	<ul class="nav <?php echo $plugin_class; ?> tw-flex tw-flex-wrap tw-items-center tw-gap-1" id="gs-mainnav">
		<li id="nav_pages" ><a class="pages" href="pages.php" accesskey="<?php echo find_accesskey(i18n_r('TAB_PAGES'));?>" ><?php i18n('TAB_PAGES');?></a></li>
		<li id="nav_upload" ><a class="files" href="upload.php" accesskey="<?php echo find_accesskey(i18n_r('TAB_FILES'));?>" ><?php i18n('TAB_FILES');?></a></li>
		<li id="nav_theme" ><a class="theme" href="theme.php" accesskey="<?php echo find_accesskey(i18n_r('TAB_THEME'));?>" ><?php i18n('TAB_THEME');?></a></li>
		<li id="nav_backups" ><a class="backups" href="backups.php" accesskey="<?php echo find_accesskey(i18n_r('TAB_BACKUPS'));?>" ><?php i18n('TAB_BACKUPS');?></a></li>
		<li id="nav_plugins" ><a class="plugins" href="plugins.php" accesskey="<?php echo find_accesskey(i18n_r('PLUGINS_NAV'));?>" ><?php i18n('PLUGINS_NAV');?></a></li>

		<?php exec_action('nav-tab');	?>

		<li class="rightnav" ><a class="settings first" href="settings.php" accesskey="<?php echo find_accesskey(i18n_r('TAB_SETTINGS'));?>" title="<?php i18n('TAB_SETTINGS');?>"><?php i18n('TAB_SETTINGS');?></a></li>
		<li class="rightnav" ><a class="support last" href="support.php" accesskey="<?php echo find_accesskey(i18n_r('TAB_SUPPORT'));?>" title="<?php i18n('TAB_SUPPORT');?>"><?php i18n('TAB_SUPPORT');?></a></li>
		<?php if (isDebug()) { ?>
		<li class="rightnav"><a class="debug" href="<?php echo $debugInfoUrl; ?>" target="_blank" rel="noopener"><?php i18n('DEBUG_MODE'); ?></a></li>
		<?php } ?>
	</ul>
</div>
</div><!-- end #header -->

<div class="wrapper gs-content">

	<?php include('template/error_checking.php'); ?>
