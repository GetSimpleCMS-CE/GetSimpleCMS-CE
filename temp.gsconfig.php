<?php
/**
 * GSConfig
 *
 * The base configurations for GetSimple	
 *
 * @package GetSimple
 */

/** Prevent direct access */
if (basename($_SERVER['PHP_SELF']) == 'gsconfig.php') { 
	die('You cannot load this page directly.');
}; 

/*****************************************************************************/
/** Below are constants that you can use to customize how GetSimple operates */ 

# Extra salt to secure your password with. Default is empty for backwards compatibility.
# define('GSLOGINSALT', 'your_unique_phrase');

# Turn off auto-generation of SALT and use a custom value. Used for cookies & upload security.
# define('GSUSECUSTOMSALT', 'your_new_salt_value_here');

# Default thumbnail width of uploaded image
define('GSIMAGEWIDTH','480');

# Change the administrative panel folder name
# define('GSADMIN','admin');

# Turn on debug mode
# define('GSDEBUG',TRUE);

# Ping search engines upon sitemap generation?
define('GSDONOTPING',1);

# Turn off CSRF protection. Uncomment this if you keep receiving the error message "CSRF error detected..."
# define('GSNOCSRF',TRUE);

# Set override CHMOD mode
# define('GSCHMOD',0755);

# Disable chmod operations
# define('GSDOCHMOD',FALSE);

# Enable Canonical Redirects?
# define('GSCANONICAL',1);

# Login Page Default Language: en_EN, es_ES, pl_PL, de_DE, uk_UK, etc.
$LANG = 'en_EN';

# Sort admin page list by title or menu
define('GSSORTPAGELISTBY','menu');

# WYSIWYG editor height (default 500)
# define('GSEDITORHEIGHT','400');

# WYSIWYG toolbars (advanced, basic, CEbar, island or [custom config])
define('GSEDITORTOOL','CEbar');

# WYSIWYG editor language (default en)
# define('GSEDITORLANG','en');

# WYSIWYG Editor Options
define('GSEDITOROPTIONS', '
extraPlugins:"fontawesome5,youtube,codemirror,cmsgrid,colorbutton,oembed,simplebutton,spacingsliders",
disableNativeSpellChecker : false,
forcePasteAsPlainText : true
');

# Set CodeMirror Theme (blackboard or default)
define('GSCMTHEME','blackboard');

# Set email from address
# define('GSFROMEMAIL','noreply@getsimple-ce.ovh');

# Autosave within edit.php. Value is the autosave interval in seconds
# define('GSAUTOSAVE',900);

# Enable the External API to be shown on settings page 
# define('GSEXTAPI',1);
	
# Set PHP locale
# https://php.net/manual/en/function.setlocale.php
# setlocale(LC_ALL,'en_US');

# Set default timezone of server, accepts php timezone string
# valid timeszones can be found here https://www.php.net/manual/en/timezones.php
# Europe/London, Australia/Sydney, Etc/GMT-8
# define('GSTIMEZONE','America/Chicago');

# Disable loading of external CDN versions of scripts (jQuery/jQueryUI)
define("GSNOCDN",TRUE);

# Disable Codemirror theme editor
# define("GSNOHIGHLIGHT",TRUE);

# Forces suppression of php errors when GSDEBUG is FALSE, despite php ini settings
define('GSSUPPRESSERRORS',TRUE);

# Disable check for Apache web server, default FALSE
#define('GSNOAPACHECHECK',TRUE);

# Disable Sitemap generation and menu items
# define('GSNOSITEMAP',TRUE);

# Enable auto meta descriptions from content excerpts when empty
define('GSAUTOMETAD',TRUE);

# Set default language for missing lang token merge, 
# accepts a lang string, default is 'en_US', FALSE to disable
# define('GSMERGELANG',FALSE);

# GS can prevent backend or frontend pages from being loaded inside a frame 
# this is done by sending an x-frame-options header, and helps protect against clickjacking attacks
# This is enabled by default for backend pages (TRUE/GSBACK)
# setting GSNOFRAME to (FALSE) will disable this behavior
# You can also customize this by passing the gs location definitions,
# GSFRONT, GSBACK, GSBOTH or FALSE for never definitions enable this for front and/or backends
# define('GSNOFRAME',GSBOTH); # prevent in frames ALWAYS

# GS can format its xml files before saving them if you require human readable source for them
# define('GSFORMATXML',TRUE);

# Hide I18N text on View All Pages.
# define('I18N_SINGLE_LANGUAGE',TRUE);

# Ignore user browser language
# define('I18N_IGNORE_USER_LANGUAGE',TRUE);

?>
