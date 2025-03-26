<?php

#showpassword function
function showPass()
{
    global $MA;
    $MA->showIndexOption();
};


#add to component extras
function compCode()
{
    static $firstTime = true;
    if ($firstTime) {
        global $MA;
        $MA->ComponentsCodeMirror();
        $firstTime = false;
    }
    ;
};

# create helpdesk option
$helpTitle = i18n_r('massiveAdmin/USERHELPTITLE');

$helpFile = GSDATAOTHERPATH . '/massiveHelpDesk/helpdesk.json';
if (file_exists($helpFile)) {
    $helpFileContent = file_get_contents($helpFile);
    $HelpfileDecode = json_decode($helpFileContent);
    $checkTrue = $HelpfileDecode->checkbox;
    $help = i18n_r('massiveAdmin/HELP');
    if ($checkTrue == 'true') {
        add_action('nav-tab', 'createSideMenu', [$thisfile, '<i class="gg-support"></i>' . $help, 'helpfromuser']);
    }
};

#add new item to navbar
function massiveExtNavbar()
{
    include(GSPLUGINPATH . 'massiveAdmin/inc/menuExtNavbar.inc.php');
};

#own footer index
function ownFooterIndex()
{
    include(GSPLUGINPATH . 'massiveAdmin/inc/ownFooterIndex.inc.php');
};

#own script header
function ownFooterScriptHeader()
{
    include(GSPLUGINPATH . 'massiveAdmin/inc/ownFooterScriptHeader.inc.php');
}

#own footer script 

function ownFooterScripts()
{
    include(GSPLUGINPATH . 'massiveAdmin/inc/ownFooterScript.inc.php');
};

#function for hide Section
function hideSectionfooter()
{
    include(GSPLUGINPATH . 'massiveAdmin/inc/hiddenAdminSectionFooter.inc.php');
};

#plugin search admin

function searchplugin()
{
    global $SITEURL;
    echo '<script src="' . $SITEURL . 'plugins/massiveAdmin/js/searchPlugin.js?v=6"></script>';
};


#next script for header

function scriptHeader()
{
    include(GSPLUGINPATH . 'massiveAdmin/inc/scriptHeader.inc.php');
};

#codemirror edit

function footerCodeMirror()
{
    if (!strpos($_SERVER['REQUEST_URI'], 'components.php')) {
        global $MA;
        $MA->codeMirror();
    }
};

# massiveHeader & Icon
function masiveHeader()
{
    global $MA;
    $MA->massiveHead();
};

#bootstrap to cke implementation
function ckeStyleImplementation()
{
	include(GSPLUGINPATH . 'massiveAdmin/inc/ckeStyleImplementation.inc.php');
};

#componentOnPage
function compomassive()
{
	global $MA;
	$MA->compositeOnPage();
};

#massive uploader
function massiveUploader()
{
	global $MA;
	$MA->massiveUpload();
};

#new option on file browser
function newOptionsMassive()
{
	global $SITEURL;
	include(GSPLUGINPATH . 'massiveAdmin/inc/newOptionsMassive.inc.php');
}

?>