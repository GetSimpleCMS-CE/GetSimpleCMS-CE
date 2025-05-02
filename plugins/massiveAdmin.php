<?php

# get correct id for plugin
$thisfile = basename(__FILE__, ".php");

i18n_merge('massiveAdmin') || i18n_merge('massiveAdmin', 'en_US');

# this changes category sidebar
if (isset($_GET['snippet'])) {
	$sett = 'pages';
} elseif (isset($_GET['downloader']) || isset($_GET['unistaller'])) {
	$sett = 'plugins';
} elseif (isset($_GET['backupcreator'])) {
	$sett = 'backups';
} elseif (isset($_GET['themesettings'])) {
	$sett = 'theme';
} else {
	$sett = 'settings';
}

# register plugin
register_plugin(
	$thisfile, 				//Plugin id
	'Massive Admin Theme',	//Plugin name
	'6.0.3', 				//Plugin version
	'Multicolor',			//Plugin author
	'https://ko-fi.com/multicolorplugins', //author website
	'Admin theme with new function', //Plugin description
	$sett,					//page type - on which admin tab to display
	'massiveOption'			//main function (administration)
);

#themeSelector 
if (file_exists(GSDATAOTHERPATH . 'massiveTheme/option.txt')) {
	$themeChecker = file_get_contents(GSDATAOTHERPATH . 'massiveTheme/option.txt');
} else {
	$themeChecker = 'massive';
}

##Script

register_style('masivestyle', $SITEURL . 'plugins/massiveAdmin/theme/' . $themeChecker . '.css', rand(0, 33030), 'screen');
queue_style('masivestyle', GSBACK);

register_script('masivescript', $SITEURL . 'plugins/massiveAdmin/js/script.js', '4.0', TRUE);
queue_script('masivescript', GSBACK);

register_style('masivestyledropzone', $SITEURL . 'plugins/massiveAdmin/css/dropzone.min.css', '1.1', 'screen');
queue_style('masivestyledropzone', GSBACK);

register_script('masivescriptdropzone', $SITEURL . 'plugins/massiveAdmin/js/dropzone.min.js', '1.1', FALSE);
queue_script('masivescriptdropzone', GSBACK);

## Whole hook 

global $SITEURL;

require(GSPLUGINPATH . 'massiveAdmin/class/massiveAdmin.class.php');

$MA = new MassiveAdminClass();

# new option on file browser
add_action('file-extras', 'newOptionsMassive');

# massive uploader on i18n gallery
add_action('pages-sidebar', 'massiveUploader');

if (strpos($_SERVER['REQUEST_URI'], "i18n_gallery&edit") !== false) {
	add_action('i18n_gallery-sidebar', 'massiveUploader');
};

if (strpos($_SERVER['REQUEST_URI'], "i18n_gallery&create") !== false) {
	add_action('i18n_gallery-sidebar', 'massiveUploader');
};

# component on pages
add_action('pages-sidebar', 'compomassive');

# activate massive active script and css
$folder = GSDATAOTHERPATH . '/massiveadmin/';

#bootstrap grid added to ckeditor
add_action('footer', 'ckeStyleImplementation');

#header for massive
add_action('header', 'masiveHeader');

$massiveOptionFile = GSDATAOTHERPATH . '/massiveadmin/massiveOption.json';
$massiveOptionFileContent = @file_get_contents($massiveOptionFile);
if (file_exists($massiveOptionFile)) {
	global $MA;
	$MA->massiveFile();
};

# codeminor fixes
add_action('footer', 'footerCodeMirror');

# maitence mode on or off check
add_action('theme-footer', 'massivemaintence');

# mtoper on front website
if (isset($_COOKIE['GS_ADMIN_USERNAME'])) {
	$cookie_user_id = _id($_COOKIE['GS_ADMIN_USERNAME']);
	if (file_exists(GSUSERSPATH . $cookie_user_id . '.xml')) {
		$datau = getXML(GSUSERSPATH . $cookie_user_id . '.xml');
		$USR = stripslashes($datau->USR);
		$HTMLEDITOR = $datau->HTMLEDITOR;
		$TIMEZONE = $datau->TIMEZONE;
		$LANG = $datau->LANG;

		add_action('theme-header', 'massivefronter');

		function massivefronter()
		{
			global $SITEURL;
			$mtoperSettingPath = GSDATAOTHERPATH . 'massiveToperSettings/';
			if (file_exists($mtoperSettingPath . 'turnon.txt')) {
				$checkTurnOn = @file_get_contents($mtoperSettingPath . 'turnon.txt');
				$style = @file_get_contents($mtoperSettingPath . 'style.txt');
				if ($checkTurnOn == 'on') {
					if ($style !== '') {
						echo '<link rel="stylesheet" href="' . $SITEURL . 'plugins/massiveAdmin/toper-theme/' . $style . '.css?v=6">';
					}
					;
					include(GSPLUGINPATH . 'massiveAdmin/inc/mToper.inc.php');
				}
			};
		}
	} else {
		$USR = null;
	};
};

# login plugins
add_action('index-login', 'scriptHeader');
$massiveAdminSettingsTitle = i18n_r("massiveAdmin/MASSIVEADMINSETTINGSTITLE");

# plugins search admin
add_action('footer', 'searchplugin');

# hidden section and user manager
$HideMassiveTitle = i18n_r('massiveAdmin/HIDEMENUTITLE');
add_action('settings-sidebar', 'createSideMenu', [$thisfile, $HideMassiveTitle, 'usermanager']);
add_action('footer', 'hideSectionfooter');

# Own footer option
$OwnFooterOption = i18n_r('massiveAdmin/OWNFOOTERTITLE');
add_action('settings-sidebar', 'createSideMenu', [$thisfile, $OwnFooterOption, 'whitelabel']);
$MenuExternalTitle = i18n_r('massiveAdmin/MENUEXTERNAL');
add_action('nav-tab', 'massiveExtNavbar');

#own footer script
add_action('footer', 'ownFooterScripts');

#own ooterScript on Header 
add_action('header', 'ownFooterScriptHeader');

#ownFooter on login
add_action('index-login', 'ownFooterIndex');

# create massive option
$MassiveAdminSettingTitle = i18n_r('massiveAdmin/MASSIVEADMINSETTINGSTITLE');
add_action('settings-sidebar', 'createSideMenu', [$thisfile, $MassiveAdminSettingTitle, 'massiveoption']);

#show password checkbox add to login
add_action('index-login', 'showPass');

# snippet
$snippet = i18n_r('massiveAdmin/SNIPPET');
add_action('pages-sidebar', 'createSideMenu', [$thisfile, $snippet . ' 📜', 'snippet'], '');

# downloader
$pluginDownloader = i18n_r('massiveAdmin/PLUGINDOWNLOADER');
add_action('plugins-sidebar', 'createSideMenu', [$thisfile, $pluginDownloader . ' 📦', 'downloader']);

//unistaller
$pluginUnistaller = i18n_r('massiveAdmin/UNISTALLER');
add_action('plugins-sidebar', 'createSideMenu', [$thisfile, $pluginUnistaller . ' 🗑️', 'unistaller']);

# components
add_action('header', 'compCode');

# Make File in theme  - option removed for security reasons


# backup creator 
$bctitle = i18n_r('massiveAdmin/BACKUPCREATOR');
add_action('backups-sidebar', 'createSideMenu', [$thisfile, $bctitle, 'backupcreator']);

# theme settings functions

$tctitle = i18n_r('massiveAdmin/THEMECONFIGURATORNAME');
add_action('theme-sidebar', 'createSideMenu', [$thisfile, $tctitle, 'themesettings']);

#another function 

#backend
require_once(GSPLUGINPATH . 'massiveAdmin/function/backendFunction.php');

#-frontend
require_once(GSPLUGINPATH . 'massiveAdmin/function/frontendFunction.php');

# all massive option  
function massiveOption()
{
	if (isset($_GET['massiveoption'])) {
		include(GSPLUGINPATH . 'massiveAdmin/modules/massiveOption.php');
		include(GSPLUGINPATH . 'massiveAdmin/modules/themeSelector.php');
		include(GSPLUGINPATH . 'massiveAdmin/modules/migrate.php');
		include(GSPLUGINPATH . 'massiveAdmin/modules/showPassword.php');
		include(GSPLUGINPATH . 'massiveAdmin/modules/gsconfig.php');
	} elseif (isset($_GET['helpfromuser'])) {
		include(GSPLUGINPATH . 'massiveAdmin/modules/helpDeskInfo.php');
	} elseif (isset($_GET['usermanager'])) {
		include(GSPLUGINPATH . 'massiveAdmin/modules/hideAdminSection.php');
		include(GSPLUGINPATH . 'massiveAdmin/modules/frontendSettings.php');
		include(GSPLUGINPATH . 'massiveAdmin/modules/helpDesk.php');
	} elseif (isset($_GET['whitelabel'])) {
		include(GSPLUGINPATH . 'massiveAdmin/modules/menuExt.php');
		include(GSPLUGINPATH . 'massiveAdmin/modules/ownFooterOptions.php');
	} elseif (isset($_GET['snippet'])) {
		include(GSPLUGINPATH . 'massiveAdmin/modules/snippet.php');
	} elseif (isset($_GET['downloader'])) {
		include(GSPLUGINPATH . 'massiveAdmin/modules/downloader.php');
	} elseif (isset($_GET['unistaller'])) {
		include(GSPLUGINPATH . 'massiveAdmin/modules/unistaller.php');
	} elseif (isset($_GET['backupcreator'])) {
		include(GSPLUGINPATH . 'massiveAdmin/modules/backupCreator.php');
	} elseif (isset($_GET['themesettings'])) {
		include(GSPLUGINPATH . 'massiveAdmin/modules/themesettings.php');
	} elseif (isset($_GET['themeinputcreator'])) {
		include(GSPLUGINPATH . 'massiveAdmin/modules/themeInputCreator.php');
	};

	echo '
	<hr>
	
	<div id="paypal" style="padding-top:10px">
			<style>
			.donateButton {
				box-shadow:inset 0px 1px 0px 0px #fff6af;
				background:linear-gradient(to bottom, #ffec64 5%, #ffab23 100%);
				background-color:#ffec64;
				border-radius:6px;
				border:1px solid #ffaa22;
				display:inline-block;
				cursor:pointer;
				color:#333333;
				font-family:Arial;
				font-size:15px;
				font-weight:bold;
				padding:6px 24px;
				text-decoration:none;
				text-shadow:0px 1px 0px #ffee66;
			}
			.donateButton:hover {
				background:linear-gradient(to bottom, #ffab23 5%, #ffec64 100%);
				background-color:#ffab23;
			}
			.donateButton:active {
				position:relative;
				top:1px;
			}
			</style>
			<p><a href="https://getsimple-ce.ovh/donate" target="_blank" class="donateButton">Buy Us A Coffee <svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" fill-opacity="0" d="M17 14v4c0 1.66 -1.34 3 -3 3h-6c-1.66 0 -3 -1.34 -3 -3v-4Z"><animate fill="freeze" attributeName="fill-opacity" begin="0.8s" dur="0.5s" values="0;1"></animate></path><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path stroke-dasharray="48" stroke-dashoffset="48" d="M17 9v9c0 1.66 -1.34 3 -3 3h-6c-1.66 0 -3 -1.34 -3 -3v-9Z"><animate fill="freeze" attributeName="stroke-dashoffset" dur="0.6s" values="48;0"></animate></path><path stroke-dasharray="14" stroke-dashoffset="14" d="M17 9h3c0.55 0 1 0.45 1 1v3c0 0.55 -0.45 1 -1 1h-3"><animate fill="freeze" attributeName="stroke-dashoffset" begin="0.6s" dur="0.2s" values="14;0"></animate></path><mask id="lineMdCoffeeHalfEmptyFilledLoop0"><path stroke="#fff" d="M8 0c0 2-2 2-2 4s2 2 2 4-2 2-2 4 2 2 2 4M12 0c0 2-2 2-2 4s2 2 2 4-2 2-2 4 2 2 2 4M16 0c0 2-2 2-2 4s2 2 2 4-2 2-2 4 2 2 2 4"><animateMotion calcMode="linear" dur="3s" path="M0 0v-8" repeatCount="indefinite"></animateMotion></path></mask><rect width="24" height="0" y="7" fill="currentColor" mask="url(#lineMdCoffeeHalfEmptyFilledLoop0)"><animate fill="freeze" attributeName="y" begin="0.8s" dur="0.6s" values="7;2"></animate><animate fill="freeze" attributeName="height" begin="0.8s" dur="0.6s" values="0;5"></animate></rect></g></svg></a></p>
		</div>
</div><!-- End Plug -->';
};