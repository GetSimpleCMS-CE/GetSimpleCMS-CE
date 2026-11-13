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
<nav class="gs-navwrap" aria-label="Main navigation">
	<ul class="nav <?php echo $plugin_class; ?>" id="gs-mainnav">
		<li id="nav_pages"><a class="pages" href="pages.php" accesskey="<?php echo find_accesskey(i18n_r('TAB_PAGES'));?>"><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5"/><path d="M9 13h6M9 17h6"/></svg><span><?php i18n('TAB_PAGES');?></span></a></li>
		<li id="nav_upload"><a class="files" href="upload.php" accesskey="<?php echo find_accesskey(i18n_r('TAB_FILES'));?>"><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg><span><?php i18n('TAB_FILES');?></span></a></li>
		<li id="nav_theme"><a class="theme" href="theme.php" accesskey="<?php echo find_accesskey(i18n_r('TAB_THEME'));?>"><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="3"/><path d="M3 9h18M9 21V9"/></svg><span><?php i18n('TAB_THEME');?></span></a></li>
		<li id="nav_backups"><a class="backups" href="backups.php" accesskey="<?php echo find_accesskey(i18n_r('TAB_BACKUPS'));?>"><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 7v5h5"/><path d="M3.5 12a9 9 0 1 0 2.2-6"/><path d="M12 8v5l3 2"/></svg><span><?php i18n('TAB_BACKUPS');?></span></a></li>
		<li id="nav_plugins"><a class="plugins" href="plugins.php" accesskey="<?php echo find_accesskey(i18n_r('PLUGINS_NAV'));?>"><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 3a2 2 0 0 1 2 2v1h2V5a2 2 0 0 1 4 0v1h1a2 2 0 0 1 2 2v2h-1a2 2 0 0 0 0 4h1v2a2 2 0 0 1-2 2h-2v-1a2 2 0 0 0-4 0v1H7a2 2 0 0 1-2-2v-3H4a2 2 0 0 0 0-4h1V7a2 2 0 0 1 2-2h2V5a2 2 0 0 1 2-2z"/></svg><span><?php i18n('PLUGINS_NAV');?></span></a></li>

		<?php exec_action('nav-tab');	?>

		<li class="rightnav gs-nav-sep"><a class="settings first" href="settings.php" accesskey="<?php echo find_accesskey(i18n_r('TAB_SETTINGS'));?>" title="<?php i18n('TAB_SETTINGS');?>"><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.7 1.7 0 0 0 .3 1.9l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1.1-1.5 1.7 1.7 0 0 0-1.9.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.9 1.7 1.7 0 0 0-1.5-1H3a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.5-1.1 1.7 1.7 0 0 0-.3-1.9l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.9.3H9a1.7 1.7 0 0 0 1-1.5V3a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.9-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.9V9a1.7 1.7 0 0 0 1.5 1H21a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1z"/></svg><span><?php i18n('TAB_SETTINGS');?></span></a></li>
		<li class="rightnav"><a class="support last" href="support.php" accesskey="<?php echo find_accesskey(i18n_r('TAB_SUPPORT'));?>" title="<?php i18n('TAB_SUPPORT');?>"><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M9.1 9a3 3 0 1 1 4.8 2.4c-.9.7-1.9 1.2-1.9 2.6"/><path d="M12 17h.01"/></svg><span><?php i18n('TAB_SUPPORT');?></span></a></li>
		<?php if (isDebug()) { ?>
		<li class="rightnav"><a class="debug" href="<?php echo $debugInfoUrl; ?>" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 9h8M9 4l1.5 3M15 4l-1.5 3"/><rect x="6" y="7" width="12" height="9" rx="3"/><path d="M3 11h3M18 11h3M4 16l2.5-1.5M17.5 14.5 20 16M4 6l2.5 1.5M17.5 7.5 20 6"/></svg><span><?php i18n('DEBUG_MODE'); ?></span></a></li>
		<?php } ?>
	</ul>
</nav>

<div class="gs-rail-foot">
	<?php if (cookie_check()) { ?>
	<a class="gs-user" href="settings.php#profile" title="<?php echo htmlspecialchars($USR, ENT_QUOTES, 'UTF-8'); ?>">
		<span class="gs-avatar" aria-hidden="true"><?php echo htmlspecialchars(strtoupper(substr((string)$USR, 0, 1)), ENT_QUOTES, 'UTF-8'); ?></span>
		<span class="gs-user-meta">
			<strong><?php echo htmlspecialchars($USR, ENT_QUOTES, 'UTF-8'); ?></strong>
			<small><?php i18n('SIDE_USER_PROFILE'); ?></small>
		</span>
	</a>
	<div class="gs-rail-actions">
		<a class="gs-rail-link" href="<?php echo $SITEURL; ?>" target="_blank" rel="noopener">
			<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><path d="M15 3h6v6"/><path d="M10 14 21 3"/></svg>
			<span><?php i18n('BACK_TO_WEBSITE'); ?></span>
		</a>
		<a class="gs-rail-link gs-rail-link-danger" href="logout.php" accesskey="<?php echo find_accesskey(i18n_r('TAB_LOGOUT')); ?>">
			<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="m16 17 5-5-5-5"/><path d="M21 12H9"/></svg>
			<span><?php i18n('TAB_LOGOUT'); ?></span>
		</a>
	</div>
	<div class="gs-rail-tools">
		<button type="button" class="gs-iconbtn gs-layout-toggle" aria-label="Toggle layout" title="Sidebar / top bar">
			<svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 9h18M9 9v11"/></svg>
		</button>
		<button type="button" class="gs-iconbtn gs-theme-toggle" aria-label="Toggle dark mode" title="<?php i18n('DARK_MODE'); ?>">
			<svg class="gs-icon-sun" viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/></svg>
			<svg class="gs-icon-moon" viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
		</button>
	</div>
	<?php } ?>
</div>
</div><!-- end #header -->

<div class="wrapper gs-content">

	<?php include('template/error_checking.php'); ?>
