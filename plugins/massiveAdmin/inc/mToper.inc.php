<?php error_reporting(E_ALL ^ E_NOTICE); ?>

<?php $massiveHiddenSection = GSDATAOTHERPATH . '/massiveHiddenSection/';

	global $GSADMIN;
	global $SITEURL;

	$URL = $SITEURL . $GSADMIN;

	$filejson = 'userhidden.json';
	$finaljson = $massiveHiddenSection . $filejson;

	$datee = @file_get_contents($finaljson);
	$data = json_decode($datee);

	$folder2        = GSDATAOTHERPATH . '/massiveMenuExt/';
	$filename2     = $folder2 . 'menuext.json';
	$datee2 = @file_get_contents($filename2);
	$data2 = json_decode($datee2, true);

	global $mtoperSettingPath;

	

; ?>

 

<div class="m-toper">
	<div class="m-toper-container">
		<ul class="massiveedit">
			<li data-hover="<?php echo i18n('EDITPAGE_TITLE'); ?>"> <a href="<?php echo $URL; ?>/edit.php?id=<?php echo get_page_slug(); ?>" >
			
			
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="edit" style="width:18px;fill:#fff;display:inline-block"><path  d="M21,12a1,1,0,0,0-1,1v6a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V5A1,1,0,0,1,5,4h6a1,1,0,0,0,0-2H5A3,3,0,0,0,2,5V19a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V13A1,1,0,0,0,21,12ZM6,12.76V17a1,1,0,0,0,1,1h4.24a1,1,0,0,0,.71-.29l6.92-6.93h0L21.71,8a1,1,0,0,0,0-1.42L17.47,2.29a1,1,0,0,0-1.42,0L13.23,5.12h0L6.29,12.05A1,1,0,0,0,6,12.76ZM16.76,4.41l2.83,2.83L18.17,8.66,15.34,5.83ZM8,13.17l5.93-5.93,2.83,2.83L10.83,16H8Z"></path></svg>
			<span> <?php echo i18n('EDITPAGE_TITLE'); ?></span></a></li>
			<li data-hover="<?php echo i18n('NEW_PAGE'); ?>" ><a href="<?php echo $URL; ?>/edit.php" >
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="plus-circle" style="width:18px;fill:#fff;display:inline-block"><path  d="M12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8,8,0,0,1,12,20Zm4-9H13V8a1,1,0,0,0-2,0v3H8a1,1,0,0,0,0,2h3v3a1,1,0,0,0,2,0V13h3a1,1,0,0,0,0-2Z"></path></svg>
				
			<span><?php echo i18n('NEW_PAGE'); ?></span> </a></li>
		</ul>

		<ul class="massivepages">
			<li id="nav_pages" data-hover=" <?php echo i18n('massiveAdmin/TAB_PAGES'); ?> "><a href="<?php echo $URL; ?>/pages.php">
		
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="desktop" style="width:18px;fill:#fff;display:inline-block"><path  d="M19,3H5A3,3,0,0,0,2,6v8a3,3,0,0,0,3,3h6v2H7a1,1,0,0,0,0,2H17a1,1,0,0,0,0-2H13V17h6a3,3,0,0,0,3-3V6A3,3,0,0,0,19,3Zm1,11a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V6A1,1,0,0,1,5,5H19a1,1,0,0,1,1,1Z"></path></svg>
		</a></li>
			<li id="nav_upload" data-hover="<?php echo i18n('massiveAdmin/TAB_FILES'); ?>"><a href="<?php echo $URL; ?>/upload.php">
		
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="file" style="width:18px;fill:#fff;display:inline-block"><path  d="M20,8.94a1.31,1.31,0,0,0-.06-.27l0-.09a1.07,1.07,0,0,0-.19-.28h0l-6-6h0a1.07,1.07,0,0,0-.28-.19l-.09,0L13.06,2H7A3,3,0,0,0,4,5V19a3,3,0,0,0,3,3H17a3,3,0,0,0,3-3V9S20,9,20,8.94ZM14,5.41,16.59,8H14ZM18,19a1,1,0,0,1-1,1H7a1,1,0,0,1-1-1V5A1,1,0,0,1,7,4h5V9a1,1,0,0,0,1,1h5Z"></path></svg>
		</a></li>
			<li id="nav_theme" data-hover="<?php echo i18n('massiveAdmin/TAB_THEME'); ?>"><a href="<?php echo $URL; ?>/theme.php">
		
<svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 24 24" id="paint-tool" style="width:18px;fill:#fff;display:inline-block"><path  d="M18,1H10A3,3,0,0,0,7,4H6A3,3,0,0,0,3,7v3a3,3,0,0,0,3,3h6a1,1,0,0,1,1,1v1a2,2,0,0,0-2,2v4a2,2,0,0,0,2,2h2a2,2,0,0,0,2-2V17a2,2,0,0,0-2-2V14a3,3,0,0,0-3-3H6a1,1,0,0,1-1-1V7A1,1,0,0,1,6,6H7a3,3,0,0,0,3,3h8a3,3,0,0,0,3-3V4A3,3,0,0,0,18,1ZM15,17v4H13V17ZM19,6a1,1,0,0,1-1,1H10A1,1,0,0,1,9,6V4a1,1,0,0,1,1-1h8a1,1,0,0,1,1,1Z"></path></svg>
		</a></li>
			<li id="nav_backups" data-hover="<?php echo i18n('massiveAdmin/TAB_BACKUPS'); ?>"><a href="<?php echo $URL; ?>/backups.php">
		
<svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 24 24" id="save" style="width:18px;fill:#fff;display:inline-block"><path   d="m20.71 9.29-6-6a1 1 0 0 0-.32-.21A1.09 1.09 0 0 0 14 3H6a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-8a1 1 0 0 0-.29-.71ZM9 5h4v2H9Zm6 14H9v-3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1Zm4-1a1 1 0 0 1-1 1h-1v-3a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3v3H6a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V6.41l4 4Z"></path></svg>
		</a></li>
			<li id="nav_plugins" data-hover="<?php i18n('massiveAdmin/PLUGINS_NAV'); ?>"><a href="<?php echo $URL; ?>/plugins.php">
		
<svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 24 24" id="plug" style="width:18px;fill:#fff;display:inline-block"><path d="M19,6H16V3a1,1,0,0,0-2,0V6H10V3A1,1,0,0,0,8,3V6H5A1,1,0,0,0,5,8H6v5a1,1,0,0,0,.29.71L9,16.41V21a1,1,0,0,0,2,0V17h2v4a1,1,0,0,0,2,0V16.41l2.71-2.7A1,1,0,0,0,18,13V8h1a1,1,0,0,0,0-2Zm-3,6.59L13.59,15H10.41L8,12.59V8h8ZM11,13h2a1,1,0,0,0,0-2H11a1,1,0,0,0,0,2Z"></path></svg>
		</a></li>

			<?php
				if (file_exists($filename2)) {
					foreach ($data2 as $query) {
						echo '<li  data-hover="' . $query["name"] . '"><a href="' . $query["url"] . '" target="' . $query["linkblank"] . '" >
						
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="plus-circle" style="width:18px;fill:#fff;display:inline-block"><path  d="M12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8,8,0,0,1,12,20Zm4-9H13V8a1,1,0,0,0-2,0v3H8a1,1,0,0,0,0,2h3v3a1,1,0,0,0,2,0V13h3a1,1,0,0,0,0-2Z"></path></svg>
						</a></li>';
					};
				};
			?>

			<li data-hover="<?php i18n('massiveAdmin/TAB_SETTINGS'); ?>"> <a href="<?php get_site_url(); ?>admin/settings.php">
		
<svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 24 24" id="setting"  style="width:18px;fill:#fff;display:inline-block"><path   d="M19.9 12.66a1 1 0 0 1 0-1.32l1.28-1.44a1 1 0 0 0 .12-1.17l-2-3.46a1 1 0 0 0-1.07-.48l-1.88.38a1 1 0 0 1-1.15-.66l-.61-1.83a1 1 0 0 0-.95-.68h-4a1 1 0 0 0-1 .68l-.56 1.83a1 1 0 0 1-1.15.66L5 4.79a1 1 0 0 0-1 .48L2 8.73a1 1 0 0 0 .1 1.17l1.27 1.44a1 1 0 0 1 0 1.32L2.1 14.1a1 1 0 0 0-.1 1.17l2 3.46a1 1 0 0 0 1.07.48l1.88-.38a1 1 0 0 1 1.15.66l.61 1.83a1 1 0 0 0 1 .68h4a1 1 0 0 0 .95-.68l.61-1.83a1 1 0 0 1 1.15-.66l1.88.38a1 1 0 0 0 1.07-.48l2-3.46a1 1 0 0 0-.12-1.17ZM18.41 14l.8.9-1.28 2.22-1.18-.24a3 3 0 0 0-3.45 2L12.92 20h-2.56L10 18.86a3 3 0 0 0-3.45-2l-1.18.24-1.3-2.21.8-.9a3 3 0 0 0 0-4l-.8-.9 1.28-2.2 1.18.24a3 3 0 0 0 3.45-2L10.36 4h2.56l.38 1.14a3 3 0 0 0 3.45 2l1.18-.24 1.28 2.22-.8.9a3 3 0 0 0 0 3.98Zm-6.77-6a4 4 0 1 0 4 4 4 4 0 0 0-4-4Zm0 6a2 2 0 1 1 2-2 2 2 0 0 1-2 2Z"></path></svg>
		</a>
			<li data-hover="<?php i18n('massiveAdmin/TAB_LOGOUT'); ?>"><a href="<?php get_site_url(); ?>admin/logout.php">
		
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="power" style="width:18px;fill:#fff;display:inline-block"><path   d="M10.21,6.21l.79-.8V10a1,1,0,0,0,2,0V5.41l.79.8a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42l-2.5-2.5a1,1,0,0,0-.33-.21,1,1,0,0,0-.76,0,1,1,0,0,0-.33.21l-2.5,2.5a1,1,0,0,0,1.42,1.42ZM18,7.56A1,1,0,1,0,16.56,9,6.45,6.45,0,1,1,7.44,9,1,1,0,1,0,6,7.56a8.46,8.46,0,1,0,12,0Z"></path></svg>
		</a>
		</ul>
	</div>
</div>

<script>
	if (document.querySelector("#nav_pages") !== null) {
		if ('<?php echo @$data->hidepages; ?>' == "hide") {
			document.querySelector("#nav_pages").remove()
		};
	};

	if (document.querySelector("#nav_upload") !== null) {
		if ('<?php echo @$data->hidefiles; ?>' == "hide") {
			document.querySelector("#nav_upload").remove()
		};
	};

	if (document.querySelector("#nav_theme") !== null) {
		if ('<?php echo @$data->hidethemes; ?>' == "hide") {
			document.querySelector("#nav_theme").remove()
		};
	};

	if (document.querySelector("#nav_plugins") !== null) {
		if ('<?php echo @$data->hideplugin; ?>' == "hide") {
			document.querySelector("#nav_plugins").remove()
		};
	};

	if (document.querySelector("#nav_backups") !== null) {
		if ('<?php echo @$data->hidebackup; ?>' == "hide") {
			document.querySelector("#nav_backups").remove()
		};
	};

	if (document.querySelector("#nav_i18n_gallery") !== null) {
		if ('<?php echo @$data->hidei18n; ?>' == "hide") {
			document.querySelector("#nav_i18n_gallery").remove()
		};
	};

	if (document.querySelector(".support") !== null) {
		if ('<?php echo @$data->hidesupport; ?>' == "hide") {
			document.querySelector(".support").remove()
		};
	};
</script>