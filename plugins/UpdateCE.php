<?php

# get correct id for plugin
$UpdateCE = basename(__FILE__, ".php");

# add in this plugin's language file
i18n_merge($UpdateCE) || i18n_merge($UpdateCE, 'en_US');

# register plugin
register_plugin(
	$UpdateCE,								# ID of plugin, should be filename minus php
	i18n_r($UpdateCE.'/lang_Menu_Title'),	# Title of plugin
	'1.2',									# Plugin version
	'CE Team',								# Plugin author
	'https://getsimple-ce.ovh/donate',		# Author URL
	i18n_r($UpdateCE.'/lang_Description'),	# Plugin Description
	'support',								# Page type of plugin
	'update_ce'								# Function that displays content
);

# add a link in the admin tab 'Support'
add_action('support-sidebar','createSideMenu', array($UpdateCE, i18n_r($UpdateCE.'/lang_Menu_Title'). i18n_r($UpdateCE.'/lang_Icon')));

function update_ce() {
	global $SITEURL;
	global $GSADMIN;
	global $USR;
	global $plugin_info;
	
	echo '
	<link rel="stylesheet" href="'.$SITEURL.'plugins/UpdateCE/assets/w3.css">
	<link rel="stylesheet" href="'.$SITEURL.'plugins/UpdateCE/assets/w3-custom.css">
	
	<div class="w3-parent w3-container"><!-- Start Plugin -->
	
		<h3>'.i18n_r("UpdateCE/lang_Icon").i18n_r("UpdateCE/lang_Page_Title").' <small>(v'. $plugin_info['UpdateCE']['version'].')';
		
		// Check for update...
		$db = file_get_contents('https://getsimplecms-ce.github.io/upgrade.json');
		$jsondb = json_decode($db);
		
		foreach ($jsondb as $key => $value) {
			if ((float) $value->plugver > (float) $plugin_info['UpdateCE']['version']) {
				echo '<sup class="w3-text-light w3-orange w3-round" style="padding:3px 1px;"><a style="font-weight:400; text-decoration:none; color:#fff!important;" href="load.php?id=massiveAdmin&downloader"> * Update available (v' . $value->plugver . ') <svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle" width="1em" height="1em" viewBox="0 0 24 24"><rect width="24" height="24" fill="none"/><path fill="none" stroke="#CF3805" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.213 9.787a3.39 3.39 0 0 0-4.795 0l-3.425 3.426a3.39 3.39 0 0 0 4.795 4.794l.321-.304m-.321-4.49a3.39 3.39 0 0 0 4.795 0l3.424-3.426a3.39 3.39 0 0 0-4.794-4.795l-1.028.961"/></svg></a>';
			};
		};
		
		echo '</small></h3>
		<p>'.i18n_r("UpdateCE/lang_Description").'</p>';
		
		include(GSADMININCPATH ."configuration.php");
		
		echo  '<p class="w3-margin w3-round-medium w3-padding w3-light-green">'.i18n_r('UpdateCE/lang_Installed_Version') .': <span style="font-weight:600">'.$site_full_name. ' &ndash; '. $site_version_no.'</span>.</p>';
		
		if(isset($_GET['ok'])){
			echo '
			<div class="w3-panel w3-green w3-round w3-padding-large"> 
			<meta http-equiv="refresh" content="14; url=health-check.php">
			<p>'.i18n_r("UpdateCE/lang_Icon").' '.i18n_r('UpdateCE/lang_Installing').' <span id="countdown" style="font-weight:600; color:red"></span></p>
			</div>
			
			<script>
				var timeleft = 11;
				var downloadTimer = setInterval(function(){
				  if(timeleft <= 0){
					clearInterval(downloadTimer);
					document.getElementById("countdown").innerHTML = "'.i18n_r('UpdateCE/lang_Finished').'";
				  } else {
					document.getElementById("countdown").innerHTML = timeleft + " '.i18n_r('UpdateCE/lang_Seconds_remaining').'";
				  }
				  timeleft -= 1;
				}, 1000);
			</script>
			';
		};
		
		echo '
		<hr>
		
		<div class="w3-container ">';

		foreach ($jsondb as $key => $value) {
			if (version_compare($value->version, $site_version_no, '>')) {
				echo '
				<div class="w3-card-4 w3-margin-bottom">
					<div class="w3-row">
						<header class="w3-container w3-deep-orange">
							<div class="w3-col s6 w3-center">
								<h3 class="w3-text-white"><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="currentColor" d="m18 22l3-3l-.7-.7l-1.8 1.8V16h-1v4.1l-1.8-1.8l-.7.7zm-6-11.15L6.075 7.425L5 8.05V9.1l7 4.05l7-4.05V8.05l-1.075-.625zm-1 10.875L4 17.7q-.475-.275-.737-.725t-.263-1v-7.95q0-.55.263-1T4 6.3l7-4.025Q11.475 2 12 2t1 .275L20 6.3q.475.275.738.725t.262 1v4.65q-.675-.325-1.437-.5T18 12q-2.9 0-4.95 2.05T11 19q0 .8.163 1.538t.487 1.412q-.175-.05-.337-.087T11 21.725M18 24q-2.075 0-3.537-1.463T13 19t1.463-3.537T18 14t3.538 1.463T23 19t-1.463 3.538T18 24"/></svg> ' . $value->name . '</h3>
								<p class="info">' . $value->info . '</p>
							</div>
							<div class="w3-col s6">
								<div class="w3-margin w3-right">
									<button class="w3-button w3-margin-top w3-round w3-padding-small w3-light-gray"><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="currentColor" d="M8 14q-.425 0-.712-.288T7 13t.288-.712T8 12t.713.288T9 13t-.288.713T8 14m4 0q-.425 0-.712-.288T11 13t.288-.712T12 12t.713.288T13 13t-.288.713T12 14m4 0q-.425 0-.712-.288T15 13t.288-.712T16 12t.713.288T17 13t-.288.713T16 14M5 22q-.825 0-1.412-.587T3 20V6q0-.825.588-1.412T5 4h1V3q0-.425.288-.712T7 2t.713.288T8 3v1h8V3q0-.425.288-.712T17 2t.713.288T18 3v1h1q.825 0 1.413.588T21 6v14q0 .825-.587 1.413T19 22zm0-2h14V10H5zM5 8h14V6H5zm0 0V6z"/></svg> ' . $value->lastupdate . '</button>
									
									<button class="w3-button w3-border w3-round-xxlarge w3-margin-top w3-red w3-text-white" style="margin-left:10px;font-weight:600"><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="currentColor" d="M19 21q-.975 0-1.75-.562T16.175 19H11q-1.65 0-2.825-1.175T7 15t1.175-2.825T11 11h2q.825 0 1.413-.587T15 9t-.587-1.412T13 7H7.825q-.325.875-1.088 1.438T5 9q-1.25 0-2.125-.875T2 6t.875-2.125T5 3q.975 0 1.738.563T7.825 5H13q1.65 0 2.825 1.175T17 9t-1.175 2.825T13 13h-2q-.825 0-1.412.588T9 15t.588 1.413T11 17h5.175q.325-.875 1.088-1.437T19 15q1.25 0 2.125.875T22 18t-.875 2.125T19 21M5 7q.425 0 .713-.288T6 6t-.288-.712T5 5t-.712.288T4 6t.288.713T5 7"/></svg> ' . $value->version . '</button>
								</div>
							</div>
						</header>
					</div>
					
					<div class="w3-container">
						<h4 class="w3-margin-top">'.i18n_r('UpdateCE/lang_Key_Changes').':</h4>
						<div style="margin:32px 32px 0 32px !important">
							<p><svg xmlns="http://www.w3.org/2000/svg" class="w3-text-green" style="vertical-align:middle" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="m8.6 22.5l-1.9-3.2l-3.6-.8l.35-3.7L1 12l2.45-2.8l-.35-3.7l3.6-.8l1.9-3.2L12 2.95l3.4-1.45l1.9 3.2l3.6.8l-.35 3.7L23 12l-2.45 2.8l.35 3.7l-3.6.8l-1.9 3.2l-3.4-1.45zm2.35-6.95L16.6 9.9l-1.4-1.45l-4.25 4.25l-2.15-2.1L7.4 12z"/></svg> <b>'.i18n_r('UpdateCE/lang_New').':</b> ' . $value->new . '</p>
							
							<p class="updates"><svg xmlns="http://www.w3.org/2000/svg" class="w3-text-indigo" style="vertical-align:middle" width="1.5em" height="1.5em" viewBox="0 0 36 36"><path fill="currentColor" d="M19.5 28.1h-2.9c-.5 0-.9-.3-1-.8l-.5-1.8l-.4-.2l-1.6.9c-.4.2-.9.2-1.2-.2l-2.1-2.1c-.3-.3-.4-.8-.2-1.2l.9-1.6l-.2-.4l-1.8-.5c-.4-.1-.8-.5-.8-1v-2.9c0-.5.3-.9.8-1l1.8-.5l.2-.4l-.9-1.6c-.2-.4-.2-.9.2-1.2l2.1-2.1c.3-.3.8-.4 1.2-.2l1.6.9l.4-.2l.5-1.8c.1-.4.5-.8 1-.8h2.9c.5 0 .9.3 1 .8L21 10l.4.2l1.6-.9c.4-.2.9-.2 1.2.2l2.1 2.1c.3.3.4.8.2 1.2l-.9 1.6l.2.4l1.8.5c.4.1.8.5.8 1v2.9c0 .5-.3.9-.8 1l-1.8.5l-.2.4l.9 1.6c.2.4.2.9-.2 1.2L24.2 26c-.3.3-.8.4-1.2.2l-1.6-.9l-.4.2l-.5 1.8c-.2.5-.6.8-1 .8m-2.2-2h1.4l.5-2.1l.5-.2c.4-.1.7-.3 1.1-.4l.5-.3l1.9 1.1l1-1l-1.1-1.9l.3-.5c.2-.3.3-.7.4-1.1l.2-.5l2.1-.5v-1.4l-2.1-.5l-.2-.5c-.1-.4-.3-.7-.4-1.1l-.3-.5l1.1-1.9l-1-1l-1.9 1.1l-.5-.3c-.3-.2-.7-.3-1.1-.4l-.5-.2l-.5-2.1h-1.4l-.5 2.1l-.5.2c-.4.1-.7.3-1.1.4l-.5.3l-1.9-1.1l-1 1l1.1 1.9l-.3.5c-.2.3-.3.7-.4 1.1l-.2.5l-2.1.5v1.4l2.1.5l.2.5c.1.4.3.7.4 1.1l.3.5l-1.1 1.9l1 1l1.9-1.1l.5.3c.3.2.7.3 1.1.4l.5.2zm9.8-6.6"/><path fill="currentColor" d="M18 22.3c-2.4 0-4.3-1.9-4.3-4.3s1.9-4.3 4.3-4.3s4.3 1.9 4.3 4.3s-1.9 4.3-4.3 4.3m0-6.6c-1.3 0-2.3 1-2.3 2.3s1 2.3 2.3 2.3s2.3-1 2.3-2.3s-1-2.3-2.3-2.3"/><path fill="currentColor" d="M18 2c-.6 0-1 .4-1 1s.4 1 1 1c7.7 0 14 6.3 14 14s-6.3 14-14 14S4 25.7 4 18c0-2.8.8-5.5 2.4-7.8v1.2c0 .6.4 1 1 1s1-.4 1-1v-5h-5c-.6 0-1 .4-1 1s.4 1 1 1h1.8C3.1 11.1 2 14.5 2 18c0 8.8 7.2 16 16 16s16-7.2 16-16S26.8 2 18 2"/><path fill="none" d="M0 0h36v36H0z"/></svg> <b>'.i18n_r('UpdateCE/lang_Updated').':</b> ' . $value->updates. '</p>
							
							<p><svg xmlns="http://www.w3.org/2000/svg" class="w3-text-deep-orange" style="vertical-align:middle" width="1.5em" height="1.5em" viewBox="0 0 256 256"><path fill="currentColor" d="M240 116h-20.78A92.21 92.21 0 0 0 140 36.78V16a12 12 0 0 0-24 0v20.78A92.21 92.21 0 0 0 36.78 116H16a12 12 0 0 0 0 24h20.78A92.21 92.21 0 0 0 116 219.22V240a12 12 0 0 0 24 0v-20.78A92.21 92.21 0 0 0 219.22 140H240a12 12 0 0 0 0-24m-112 80a68 68 0 1 1 68-68a68.07 68.07 0 0 1-68 68m0-112a44 44 0 1 0 44 44a44.05 44.05 0 0 0-44-44m0 64a20 20 0 1 1 20-20a20 20 0 0 1-20 20"/></svg> <b>'.i18n_r('UpdateCE/lang_Fixes').':</b> ' . $value->fixed. '</p>
							
							<p><svg xmlns="http://www.w3.org/2000/svg" class="w3-text-red" style="vertical-align:middle" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M14.48 18.71a3.996 3.996 0 0 1-5.163-5.272l2.619 2.619l2.12-2.121l-2.618-2.619a3.988 3.988 0 0 1 5.2 5.308l1.933 1.933A7.96 7.96 0 0 0 20 14A17.11 17.11 0 0 0 13.5.67a21.5 21.5 0 0 1 .74 4.8a3.47 3.47 0 0 1-3.41 3.73A3.64 3.64 0 0 1 7.2 5.47l.03-.36A13.77 13.77 0 0 0 4 14a8 8 0 0 0 12.43 6.66Z"/></svg> <b>'.i18n_r('UpdateCE/lang_Security').':</b> ' . $value->security. '</p>
							<hr>
							
							<div class="w3-row">
								<div class="w3-col s6 w3-center">
								<p><a href="' . $value->repo . '" target="_blank" style="text-decoration:none"><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2A10 10 0 0 0 2 12c0 4.42 2.87 8.17 6.84 9.5c.5.08.66-.23.66-.5v-1.69c-2.77.6-3.36-1.34-3.36-1.34c-.46-1.16-1.11-1.47-1.11-1.47c-.91-.62.07-.6.07-.6c1 .07 1.53 1.03 1.53 1.03c.87 1.52 2.34 1.07 2.91.83c.09-.65.35-1.09.63-1.34c-2.22-.25-4.55-1.11-4.55-4.92c0-1.11.38-2 1.03-2.71c-.1-.25-.45-1.29.1-2.64c0 0 .84-.27 2.75 1.02c.79-.22 1.65-.33 2.5-.33s1.71.11 2.5.33c1.91-1.29 2.75-1.02 2.75-1.02c.55 1.35.2 2.39.1 2.64c.65.71 1.03 1.6 1.03 2.71c0 3.82-2.34 4.66-4.57 4.91c.36.31.69.92.69 1.85V21c0 .27.16.59.67.5C19.14 20.16 22 16.42 22 12A10 10 0 0 0 12 2"/></svg> '.i18n_r('UpdateCE/lang_More_Info').'</a></p>
								</div>
								
								<div class="w3-col s6 w3-center">
								<p><a href="' . $value->url . '" style="text-decoration:none" download><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle" width="1.2em" height="1.2em" viewBox="0 0 24 24"><g fill="none"><path d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/><path fill="currentColor" d="M20 14.5a1.5 1.5 0 0 1 1.5 1.5v4a2.5 2.5 0 0 1-2.5 2.5H5A2.5 2.5 0 0 1 2.5 20v-4a1.5 1.5 0 0 1 3 0v3.5h13V16a1.5 1.5 0 0 1 1.5-1.5m-8-13A1.5 1.5 0 0 1 13.5 3v9.036l1.682-1.682a1.5 1.5 0 0 1 2.121 2.12l-4.066 4.067a1.75 1.75 0 0 1-2.474 0l-4.066-4.066a1.5 1.5 0 0 1 2.121-2.121l1.682 1.682V3A1.5 1.5 0 0 1 12 1.5"/></g></svg> '.i18n_r('UpdateCE/lang_Download').'</a></p>
								</div>
							</div>
							
						</div>
					</div>

					<footer class="w3-container w3-light-gray">
						<form action="'.$SITEURL.'admin/load.php?id=UpdateCE&&ok=ok" method="POST">
							<div class="w3-margin w3-center">
								<input type="hidden" name="url" value="' . $value->url . '">
								<button class="w3-btn w3-large w3-round w3-green" type="submit" name="download"><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle" width="1.2em" height="1.2em" viewBox="0 0 36 36"><path fill="currentColor" d="M19.5 28.1h-2.9c-.5 0-.9-.3-1-.8l-.5-1.8l-.4-.2l-1.6.9c-.4.2-.9.2-1.2-.2l-2.1-2.1c-.3-.3-.4-.8-.2-1.2l.9-1.6l-.2-.4l-1.8-.5c-.4-.1-.8-.5-.8-1v-2.9c0-.5.3-.9.8-1l1.8-.5l.2-.4l-.9-1.6c-.2-.4-.2-.9.2-1.2l2.1-2.1c.3-.3.8-.4 1.2-.2l1.6.9l.4-.2l.5-1.8c.1-.4.5-.8 1-.8h2.9c.5 0 .9.3 1 .8L21 10l.4.2l1.6-.9c.4-.2.9-.2 1.2.2l2.1 2.1c.3.3.4.8.2 1.2l-.9 1.6l.2.4l1.8.5c.4.1.8.5.8 1v2.9c0 .5-.3.9-.8 1l-1.8.5l-.2.4l.9 1.6c.2.4.2.9-.2 1.2L24.2 26c-.3.3-.8.4-1.2.2l-1.6-.9l-.4.2l-.5 1.8c-.2.5-.6.8-1 .8m-2.2-2h1.4l.5-2.1l.5-.2c.4-.1.7-.3 1.1-.4l.5-.3l1.9 1.1l1-1l-1.1-1.9l.3-.5c.2-.3.3-.7.4-1.1l.2-.5l2.1-.5v-1.4l-2.1-.5l-.2-.5c-.1-.4-.3-.7-.4-1.1l-.3-.5l1.1-1.9l-1-1l-1.9 1.1l-.5-.3c-.3-.2-.7-.3-1.1-.4l-.5-.2l-.5-2.1h-1.4l-.5 2.1l-.5.2c-.4.1-.7.3-1.1.4l-.5.3l-1.9-1.1l-1 1l1.1 1.9l-.3.5c-.2.3-.3.7-.4 1.1l-.2.5l-2.1.5v1.4l2.1.5l.2.5c.1.4.3.7.4 1.1l.3.5l-1.1 1.9l1 1l1.9-1.1l.5.3c.3.2.7.3 1.1.4l.5.2zm9.8-6.6"/><path fill="currentColor" d="M18 22.3c-2.4 0-4.3-1.9-4.3-4.3s1.9-4.3 4.3-4.3s4.3 1.9 4.3 4.3s-1.9 4.3-4.3 4.3m0-6.6c-1.3 0-2.3 1-2.3 2.3s1 2.3 2.3 2.3s2.3-1 2.3-2.3s-1-2.3-2.3-2.3"/><path fill="currentColor" d="M18 2c-.6 0-1 .4-1 1s.4 1 1 1c7.7 0 14 6.3 14 14s-6.3 14-14 14S4 25.7 4 18c0-2.8.8-5.5 2.4-7.8v1.2c0 .6.4 1 1 1s1-.4 1-1v-5h-5c-.6 0-1 .4-1 1s.4 1 1 1h1.8C3.1 11.1 2 14.5 2 18c0 8.8 7.2 16 16 16s16-7.2 16-16S26.8 2 18 2"/><path fill="none" d="M0 0h36v36H0z"/></svg> '.i18n_r('UpdateCE/lang_Update_Now').'</button>
							</div>
						</form>
					</footer>
				</div>';
			}
		};
		
		// No updates available...
		if (count($jsondb) > 0) {
			$hasUpdates = false;
			foreach ($jsondb as $value) {
				if (version_compare($value->version, $site_version_no, '>')) {
					$hasUpdates = true;
					break;
				}
			}
			if (!$hasUpdates) {
				echo '<div class="w3-card-4 w3-panel w3-round-large w3-padding-32 w3-green"><p>'.i18n_r('UpdateCE/lang_No_Updates').' <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 512 512"><rect width="512" height="512" fill="none"/><path fill="#CF3805" d="M313.4 32.9c26 5.2 42.9 30.5 37.7 56.5l-2.3 11.4c-5.3 26.7-15.1 52.1-28.8 75.2h144c26.5 0 48 21.5 48 48c0 18.5-10.5 34.6-25.9 42.6C497 275.4 504 288.9 504 304c0 23.4-16.8 42.9-38.9 47.1c4.4 7.3 6.9 15.8 6.9 24.9c0 21.3-13.9 39.4-33.1 45.6c.7 3.3 1.1 6.8 1.1 10.4c0 26.5-21.5 48-48 48h-97.5c-19 0-37.5-5.6-53.3-16.1l-38.5-25.7C176 420.4 160 390.4 160 358.3V247.1c0-29.2 13.3-56.7 36-75l7.4-5.9c26.5-21.2 44.6-51 51.2-84.2l2.3-11.4c5.2-26 30.5-42.9 56.5-37.7M32 192h64c17.7 0 32 14.3 32 32v224c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32V224c0-17.7 14.3-32 32-32" stroke-width="20" stroke="#CF3805"/></svg></p></div>';
			}
		};
		
		echo '
		</div>
		
		<hr>
		
		<div class="w3-panel w3-leftbar w3-pale-yellow">
			<h4 class="w3-text-red"><svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 16 16"><path fill="currentColor" fill-rule="evenodd" d="M8.429 2.746a.5.5 0 0 0-.858 0L1.58 12.743a.5.5 0 0 0 .429.757h11.984a.5.5 0 0 0 .43-.757zm-2.144-.77C7.06.68 8.939.68 9.715 1.975l5.993 9.996c.799 1.333-.161 3.028-1.716 3.028H2.008C.453 15-.507 13.305.292 11.972l5.993-9.997ZM9 11.5a1 1 0 1 1-2 0a1 1 0 0 1 2 0m-.25-5.75a.75.75 0 0 0-1.5 0v3a.75.75 0 0 0 1.5 0z" clip-rule="evenodd"/></svg><span style="font-weight:600"> '.i18n_r('UpdateCE/lang_Note').':</span></h4>
			<ul class="w3-ul">
				<li><p>'.i18n_r('UpdateCE/lang_Requirement').'</p></li>
				<li><p>'.i18n_r('UpdateCE/lang_Create_Backup').'</p></li>
				<li><p>'.i18n_r('UpdateCE/lang_Themes_Overwritten').'</p></li>
				<li><p>'.i18n_r('UpdateCE/lang_Rename_Admin').'</p></li>
			</ul>
		</div>
		
		<hr>
		
		<div class="w3-container w3-padding" style="margin-top:50px">
			<h4 class=" w3-text-orange w3-padding w3-pale-yellow" style="font-weight:600"><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="currentColor" d="M12 9a1 1 0 0 0-1 1v3a1 1 0 0 0 2 0v-3a1 1 0 0 0-1-1m7-7H5a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h11.59l3.7 3.71A1 1 0 0 0 21 22a.84.84 0 0 0 .38-.08A1 1 0 0 0 22 21V5a3 3 0 0 0-3-3m1 16.59l-2.29-2.3A1 1 0 0 0 17 16H5a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1ZM12 6a1 1 0 1 0 1 1a1 1 0 0 0-1-1"/></svg> '.i18n_r('UpdateCE/lang_New').' </h4>
		
			<ul class="w3-ul w3-hoverable w3-margin-bottom">
				<li>
					<p>'.i18n_r('UpdateCE/lang_Plugin_MA').'</p>
				</li>
				<li>
					<p>'.i18n_r('UpdateCE/lang_Update_gsConfig').'</p>
				</li>
			</ul>
			
			<p>'.i18n_r('UpdateCE/lang_Add_New').':</p>
			<div class="w3-codespan w3-padding w3-margin-bottom">
# Login Page Default Language;<br>
$LANG = \'en_EN\'; // es_ES, pl_PL, de_DE, uk_UK, etc.<br><br>

# Sort admin page list by title or menu<br>
define(\'GSSORTPAGELISTBY\',\'menu\');<br><br>

# Set CodeMirror Theme (blackboard or default)<br>
define(\'GSCMTHEME\',\'blackboard\');
			</div>
		
			<p>'.i18n_r('UpdateCE/lang_Replace_section').':</p>
			<div class="w3-codespan w3-padding  w3-margin-bottom">
# WYSIWYG toolbars (advanced, basic or [custom config]) <br>
# define(\'GSEDITORTOOL\', \'advanced\');<br><br>

# WYSIWYG Editor Options<br>
# define(\'GSEDITOROPTIONS\', \'\');
			</div>
		
			<p>'.i18n_r('UpdateCE/lang_With_updated').':</p>
			<div class="w3-codespan w3-padding  w3-margin-bottom">
# WYSIWYG toolbars (advanced, basic, CEbar, island or [custom config])<br>
define(\'GSEDITORTOOL\', "CEbar");<br><br>

# WYSIWYG Editor Options<br>
define(\'GSEDITOROPTIONS\', \'<br>
extraPlugins:"fontawesome5,youtube,codemirror,cmsgrid,colorbutton,oembed,simplebutton,spacingsliders",<br>
disableNativeSpellChecker : false,<br>
forcePasteAsPlainText : true<br>
\');
			</div>
			
		</div>
		';

		echo '
			<hr>
			
			<div id="paypal" class="xw3-opacity">
				<p>Made with <span class="credit-icon">❤️</span> especially for "<b>'.$USR.'</b>". Is this plugin useful to you?
				 <a href="https://getsimple-ce.ovh/donate" target="_blank" class="donateButton">Buy Us A Coffee <svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" fill-opacity="0" d="M17 14v4c0 1.66 -1.34 3 -3 3h-6c-1.66 0 -3 -1.34 -3 -3v-4Z"><animate fill="freeze" attributeName="fill-opacity" begin="0.8s" dur="0.5s" values="0;1"/></path><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path stroke-dasharray="48" stroke-dashoffset="48" d="M17 9v9c0 1.66 -1.34 3 -3 3h-6c-1.66 0 -3 -1.34 -3 -3v-9Z"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.6s" values="48;0"/></path><path stroke-dasharray="14" stroke-dashoffset="14" d="M17 9h3c0.55 0 1 0.45 1 1v3c0 0.55 -0.45 1 -1 1h-3"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.6s" dur="0.2s" values="14;0"/></path><mask id="lineMdCoffeeHalfEmptyFilledLoop0"><path stroke="#fff" d="M8 0c0 2-2 2-2 4s2 2 2 4-2 2-2 4 2 2 2 4M12 0c0 2-2 2-2 4s2 2 2 4-2 2-2 4 2 2 2 4M16 0c0 2-2 2-2 4s2 2 2 4-2 2-2 4 2 2 2 4"><animateMotion calcMode="linear" dur="3s" path="M0 0v-8" repeatCount="indefinite"/></path></mask><rect width="24" height="0" y="7" fill="currentColor" mask="url(#lineMdCoffeeHalfEmptyFilledLoop0)"><animate fill="freeze" attributeName="y" begin="0.8s" dur="0.6s" values="7;2"/><animate fill="freeze" attributeName="height" begin="0.8s" dur="0.6s" values="0;5"/></rect></g></svg></a></p>
			</div>
		</div><!-- End Plugin -->';

	if (isset($_POST['download'])) {
		$url = filter_var($_POST['url'], FILTER_VALIDATE_URL);
		if ($url === false) {
			echo "Invalid URL.";
			return;
		}

		$rootPath = dirname(GSDATAPATH);
		$tmpFile = $rootPath . "/Tmpfile.zip";

		$fileContent = @file_get_contents($url);
		if ($fileContent === false) {
			echo "Failed to download file.";
			return;
		}

		if (file_put_contents($tmpFile, $fileContent) === false) {
			echo "Failed to save downloaded file.";
			return;
		}

		$zip = new ZipArchive;
		if ($zip->open($tmpFile) === TRUE) {
			$installTmp = $rootPath . "/install_TMP/";
			if (!file_exists($installTmp)) {
				mkdir($installTmp, 0755);
			}

			$zip->extractTo($installTmp);
			$zip->close();

			$subFolder = null;
			// Find the top-level sub-folder
			foreach (scandir($installTmp) as $item) {
				if ($item !== '.' && $item !== '..') {
					if (is_dir($installTmp . $item)) {
						$subFolder = $installTmp . $item . '/';
						break;
					}
				}
			}

			if ($subFolder) {
				$filesCopied = true;

				$directoryIterator = new RecursiveDirectoryIterator($subFolder, RecursiveDirectoryIterator::SKIP_DOTS);
				$iterator = new RecursiveIteratorIterator($directoryIterator, RecursiveIteratorIterator::SELF_FIRST);

				foreach ($iterator as $file) {
					$sourcePath = $file->getPathname();
					$relativePath = substr($sourcePath, strlen($subFolder));
					$destinationPath = $rootPath . '/' . $relativePath;

					if ($file->isDir()) {
						if (!file_exists($destinationPath) && !mkdir($destinationPath, 0755, true)) {
							echo "Failed to create directory $destinationPath<br>";
							$filesCopied = false;
						}
					} else {
						if (!copy($sourcePath, $destinationPath)) {
							$lastError = error_get_last();
							echo "Failed to copy $sourcePath to $destinationPath: " . $lastError['message'] . "<br>";
							$filesCopied = false;
						} else {
							unlink($sourcePath); // Remove the original file after copying
						}
					}
				}

				// Cleanup
				if (delete_directory($installTmp)) {
					echo "Temporary directory removed successfully.<br>";
				} else {
					echo "Failed to remove temporary directory.<br>";
					$lastError = error_get_last();
					if ($lastError) {
						echo "Error: " . $lastError['message'] . "<br>";
					}
				}

				if (unlink($tmpFile)) {
					echo "Temporary file removed successfully.<br>";
				} else {
					echo "Failed to remove temporary file.<br>";
					$lastError = error_get_last();
					if ($lastError) {
						echo "Error: " . $lastError['message'] . "<br>";
					}
				}

				if ($filesCopied) {
					echo "Update installed successfully.";
				} else {
					echo "Some files could not be moved.";
				}
			} else {
				echo "No sub-folder found in the extracted files.";
			}
		} else {
			echo "Failed to open ZIP file.";
		}
	}

	function delete_directory($dirname) {
		if (!is_dir($dirname)) {
			return false;
		}

		$dir_handle = opendir($dirname);
		if (!$dir_handle) {
			return false;
		}

		while ($file = readdir($dir_handle)) {
			if ($file != "." && $file != "..") {
				$path = $dirname . "/" . $file;
				if (is_dir($path)) {
					delete_directory($path);
				} else {
					if (!unlink($path)) {
						$lastError = error_get_last();
						echo "Failed to delete file $path: " . $lastError['message'] . "<br>";
					}
				}
			}
		}

		closedir($dir_handle);
		if (!rmdir($dirname)) {
			$lastError = error_get_last();
			echo "Failed to delete directory $dirname: " . $lastError['message'] . "<br>";
			return false;
		}
		return true;
	}

};
?>
