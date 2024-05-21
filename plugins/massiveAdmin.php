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
	$thisfile, //Plugin id
	'Massive Admin Theme', 	//Plugin name
	'5.0.3', 		//Plugin version
	'Multicolor',  //Plugin author
	'https://multicolor.stargard.pl', //author website
	'Admin theme with new function', //Plugin description
	$sett,
	//page type - on which admin tab to display
	'massiveOption'  //main function (administration)
);

global $SITEURL;

require(GSPLUGINPATH . 'massiveAdmin/class/massiveAdmin.class.php');

$MA = new MassiveAdminClass();

 

# new option on file browser
add_action('file-extras', 'newOptionsMassive');

function newOptionsMassive()
{
	global $SITEURL;
	include(GSPLUGINPATH . 'massiveAdmin/inc/newOptionsMassive.inc.php');
}

# massive uploader on i18n gallery
add_action('pages-sidebar', 'massiveUploader');

if (strpos($_SERVER['REQUEST_URI'], "i18n_gallery&edit") !== false) {
	add_action('i18n_gallery-sidebar', 'massiveUploader');
};

if (strpos($_SERVER['REQUEST_URI'], "i18n_gallery&create") !== false) {
	add_action('i18n_gallery-sidebar', 'massiveUploader');
};

function massiveUploader()
{
	global $MA;
	$MA->massiveUpload();
}

# component on pages
add_action('pages-sidebar', 'compomassive');

function compomassive()
{
	global $MA;
	$MA->compositeOnPage();
};

# activate massive active script and css
$folder = GSDATAOTHERPATH . '/massiveadmin/';

#themeSelector 

if (file_exists(GSDATAOTHERPATH . 'massiveTheme/option.txt')) {
	$themeChecker = file_get_contents(GSDATAOTHERPATH . 'massiveTheme/option.txt');
} else {
	$themeChecker = 'massive';
}


register_style('masivestyle', $SITEURL . 'plugins/massiveAdmin/theme/' . $themeChecker  . '.css', '5.0', 'screen');
queue_style('masivestyle', GSBACK);

add_action('footer', 'ckeStyleImplementation');
function ckeStyleImplementation()
{
	include(GSPLUGINPATH . 'massiveAdmin/inc/ckeStyleImplementation.inc.php');
};

register_script('masivescript', $SITEURL . 'plugins/massiveAdmin/js/script.js', '4.0', TRUE);
queue_script('masivescript', GSBACK);

register_style('masivestyledropzone', $SITEURL . 'plugins/massiveAdmin/css/dropzone.min.css', '1.1', 'screen');
queue_style('masivestyledropzone', GSBACK);

register_script('masivescriptdropzone', $SITEURL . 'plugins/massiveAdmin/js/dropzone.min.js', '1.1', FALSE);
queue_script('masivescriptdropzone', GSBACK);

add_action('header', 'masiveHeader');

$massiveOptionFile = GSDATAOTHERPATH . '/massiveadmin/massiveOption.json';
$massiveOptionFileContent = @file_get_contents($massiveOptionFile);
if (file_exists($massiveOptionFile)) {
	global $MA;
	$MA->massiveFile();
};

# massiveHeader & Icon
function masiveHeader()
{
	global $MA;
	$MA->massiveHead();
}

# codeminor fixes
add_action('footer', 'footerCodeMirror');
function footerCodeMirror()
{

	if (!strpos($_SERVER['REQUEST_URI'], 'components.php')) {
		global $MA;
		$MA->codeMirror();
	}
}

# maitence mode on or off check
add_action('theme-footer', 'massivemaintence');
function massivemaintence()
{
	include(GSPLUGINPATH . 'massiveAdmin/inc/maintenceFront.inc.php');
};

# mtoper on front website
if (isset($_COOKIE['GS_ADMIN_USERNAME'])) {
	$cookie_user_id = _id($_COOKIE['GS_ADMIN_USERNAME']);
	if (file_exists(GSUSERSPATH . $cookie_user_id . '.xml')) {
		$datau = getXML(GSUSERSPATH  . $cookie_user_id . '.xml');
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
						echo '<link rel="stylesheet" href="' . $SITEURL . 'plugins/massiveAdmin/toper-theme/' . $style . '.css">';
					};

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

function scriptHeader()
{
	include(GSPLUGINPATH . 'massiveAdmin/inc/scriptHeader.inc.php');
};
$massiveAdminSettingsTitle = i18n_r("massiveAdmin/MASSIVEADMINSETTINGSTITLE");

# plugins search admin
add_action('footer', 'searchplugin');
function searchplugin()
{
	global $SITEURL;
	echo '<script src="' . $SITEURL . 'plugins/massiveAdmin/js/searchPlugin.js"></script>';
};

# new module massiveMenuExternal
$MenuExternalTitle = i18n_r('massiveAdmin/MENUEXTERNAL');

add_action('settings-sidebar', 'createSideMenu', [$thisfile, $MenuExternalTitle, 'menuext']);

add_action('nav-tab', 'massiveExtNavbar');

function massiveExtNavbar()
{
	include(GSPLUGINPATH . 'massiveAdmin/inc/menuExtNavbar.inc.php');
};

# hidden section and user manager
$HideMassiveTitle = i18n_r('massiveAdmin/HIDEMENUTITLE');
add_action('settings-sidebar', 'createSideMenu', [$thisfile, $HideMassiveTitle, 'hideadminsection']);
add_action('footer', 'hideSectionfooter');
function hideSectionfooter()
{
	include(GSPLUGINPATH . 'massiveAdmin/inc/hiddenAdminSectionFooter.inc.php');
};

# Own footer option
$OwnFooterOption = i18n_r('massiveAdmin/OWNFOOTERTITLE');
add_action('settings-sidebar', 'createSideMenu', [$thisfile, $OwnFooterOption, 'ownfooteroption']);
add_action('footer', 'ownFooterScripts');

function ownFooterScripts()
{
	include(GSPLUGINPATH . 'massiveAdmin/inc/ownFooterScript.inc.php');
};

add_action('header', 'ownFooterScriptHeader');
function ownFooterScriptHeader()
{
	include(GSPLUGINPATH . 'massiveAdmin/inc/ownFooterScriptHeader.inc.php');
};

add_action('index-login', 'ownFooterIndex');

function ownFooterIndex()
{
	include(GSPLUGINPATH . 'massiveAdmin/inc/ownFooterIndex.inc.php');
};

# create massive option
$MassiveAdminSettingTitle = i18n_r('massiveAdmin/MASSIVEADMINSETTINGSTITLE');
add_action('settings-sidebar', 'createSideMenu', [$thisfile, $MassiveAdminSettingTitle, 'massiveoption']);

# create helpdesk option
$helpTitle = i18n_r('massiveAdmin/USERHELPTITLE');
add_action('settings-sidebar', 'createSideMenu', [$thisfile, $helpTitle, 'helpdesk']);
$helpFile = GSDATAOTHERPATH . '/massiveHelpDesk/helpdesk.json';

if (file_exists($helpFile)) {
	$helpFileContent = file_get_contents($helpFile);
	$HelpfileDecode = json_decode($helpFileContent);
	$checkTrue = $HelpfileDecode->checkbox;
	$help = i18n_r('massiveAdmin/HELP');

	if ($checkTrue == 'true') {
		add_action('nav-tab', 'createSideMenu', [$thisfile, '<i class="gg-support"></i>' . $help, 'helpfromuser']);
	}
}

# 3.0
$migrate = i18n_r('massiveAdmin/MIGRATETITLE');
add_action('settings-sidebar', 'createSideMenu', [$thisfile, $migrate, 'migrate']);

$GSconfig = 'GSConfig';
add_action('settings-sidebar', 'createSideMenu', [$thisfile, $GSconfig, 'gsconfigEdit']);

$frontEndSettings = i18n_r('massiveAdmin/FRONTENDTITLE');
add_action('settings-sidebar', 'createSideMenu', [$thisfile, $frontEndSettings, 'frontendsettings']);

$showPassword = i18n_r('massiveAdmin/LOGINOPTIONS');
add_action('settings-sidebar', 'createSideMenu', [$thisfile, $showPassword, 'showPassword']);

add_action('index-login', 'showPass');

function showPass()
{
	global $MA;
	$MA->showIndexOption();
};

# snippet
$snippet = i18n_r('massiveAdmin/SNIPPET');
add_action('pages-sidebar', 'createSideMenu', [$thisfile, $snippet . ' 📜', 'snippet'], '');


function get_snippet($item)
{
	$file = GSDATAOTHERPATH . 'snippetMassive/snippet.xml';
	$readed = simplexml_load_file($file);
	echo htmlspecialchars_decode($readed->$item->content);
};

# downloader
$pluginDownloader = i18n_r('massiveAdmin/PLUGINDOWNLOADER');
add_action('plugins-sidebar', 'createSideMenu', [$thisfile, $pluginDownloader . ' 📦', 'downloader']);

//unistaller
$pluginUnistaller = i18n_r('massiveAdmin/UNISTALLER');
add_action('plugins-sidebar', 'createSideMenu', [$thisfile, $pluginUnistaller . ' 🗑️', 'unistaller']);

# components
add_action('component-extras', 'compCode');

function compCode()
{
	static $firstTime = true;
	if ($firstTime) {
		global $MA;
		$MA->ComponentsCodeMirror();
		$firstTime = false;
	};
};

# theme selector
$MassiveAdminThemeSelector = i18n_r('massiveAdmin/ADMINTHEMESELECTOR');
add_action('settings-sidebar', 'createSideMenu', [$thisfile, $MassiveAdminThemeSelector, 'themeselector']);


# redirect page to homepage bar



add_action('theme-edit-extras', 'makeFileInTheme');


function makeFileInTheme()
{
	include(GSPLUGINPATH . 'massiveAdmin/modules/makeFileInTheme.php');
};



$bctitle = i18n_r('massiveAdmin/BACKUPCREATOR');

add_action('backups-sidebar', 'createSideMenu',  [$thisfile, $bctitle, 'backupcreator']);


$tctitle = i18n_r('massiveAdmin/THEMECONFIGURATORNAME');

add_action('theme-sidebar', 'createSideMenu',  [$thisfile, $tctitle, 'themesettings']);



# theme settings functions

function mats($field)
{

	$xml = simplexml_load_file(GSDATAOTHERPATH . 'website.xml');

	$activeTemplate = $xml->TEMPLATE;


	if (file_exists(GSTHEMESPATH . $activeTemplate . '/settings.json')) {
		$data = file_get_contents(GSTHEMESPATH . $activeTemplate . '/settings.json');
		$filx =  json_decode($data);

		if($filx->settings->$field->type !== 'wysywig'){
		echo $filx->settings->$field->value;
		}else{
		echo html_entity_decode($filx->settings->$field->value);
		}

		
	} else {
		echo i18n_r('massiveAdmin/NOSETTINGSCREATED');
	}
};


function r_mats($field)
{

	$xml = simplexml_load_file(GSDATAOTHERPATH . 'website.xml');

	$activeTemplate = $xml->TEMPLATE;


	if (file_exists(GSTHEMESPATH . $activeTemplate . '/settings.json')) {
		$data = file_get_contents(GSTHEMESPATH . $activeTemplate . '/settings.json');
		$filx =  json_decode($data);

		
		if($filx->settings->$field->type !== 'wysywig'){
			return $filx->settings->$field->value;
			}else{
			return html_entity_decode($filx->settings->$field->value);
			}

	} else {
		echo i18n_r('massiveAdmin/NOSETTINGSCREATED');
	}
}



# all massive option  
function massiveOption()
{




	if (isset($_GET['massiveoption'])) {
		include(GSPLUGINPATH . 'massiveAdmin/modules/massiveOption.php');
	} elseif (isset($_GET['helpfromuser'])) {
		include(GSPLUGINPATH . 'massiveAdmin/modules/helpDeskInfo.php');
	} elseif (isset($_GET['helpdesk'])) {
		include(GSPLUGINPATH . 'massiveAdmin/modules/helpDesk.php');
	} elseif (isset($_GET['hideadminsection'])) {
		include(GSPLUGINPATH . 'massiveAdmin/modules/hideAdminSection.php');
	} elseif (isset($_GET['menuext'])) {
		include(GSPLUGINPATH . 'massiveAdmin/modules/menuExt.php');
	} elseif (isset($_GET['ownfooteroption'])) {
		include(GSPLUGINPATH . 'massiveAdmin/modules/ownFooterOptions.php');
	} elseif (isset($_GET['migrate'])) {
		include(GSPLUGINPATH . 'massiveAdmin/modules/migrate.php');
	} elseif (isset($_GET['gsconfigEdit'])) {
		include(GSPLUGINPATH . 'massiveAdmin/modules/gsconfig.php');
	} elseif (isset($_GET['showPassword'])) {
		include(GSPLUGINPATH . 'massiveAdmin/modules/showPassword.php');
	} elseif (isset($_GET['snippet'])) {
		include(GSPLUGINPATH . 'massiveAdmin/modules/snippet.php');
	} elseif (isset($_GET['downloader'])) {
		include(GSPLUGINPATH . 'massiveAdmin/modules/downloader.php');
	} elseif (isset($_GET['unistaller'])) {
		include(GSPLUGINPATH . 'massiveAdmin/modules/unistaller.php');
	} elseif (isset($_GET['themeselector'])) {
		include(GSPLUGINPATH . 'massiveAdmin/modules/themeSelector.php');
	} elseif (isset($_GET['frontendsettings'])) {
		include(GSPLUGINPATH . 'massiveAdmin/modules/frontendSettings.php');
	} elseif (isset($_GET['backupcreator'])) {
		include(GSPLUGINPATH . 'massiveAdmin/modules/backupCreator.php');
	} elseif (isset($_GET['themesettings'])) {
		include(GSPLUGINPATH . 'massiveAdmin/modules/themesettings.php');
	};;

	echo "
	<style>.kofitext,.kofi-button{text-decoration:none !important}</style>
	<div style='margin:20px 0;width:100%;' class='kofi'>
		<script type='text/javascript' src='https://storage.ko-fi.com/cdn/widget/Widget_2.js'></script><script type='text/javascript'>kofiwidget2.init('Support Me on Ko-fi', '#29abe0', 'I3I2RHQZS');kofiwidget2.draw();</script>
	</div> ";
};
