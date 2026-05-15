<?php
/**
 * Common Setup File
 * 
 * This file initializes up most variables for the site. It is also where most files
 * are included from. It also reads and stores certain variables.
 *
 * @package GetSimple
 * @subpackage init
 */

/**
 * Headers
 */

// charset utf-8
header('content-type: text/html; charset=utf-8');

// headers for backend
if(!isset($base)){
	// no-cache headers
	$timestamp = gmdate("D, d M Y H:i:s") . " GMT";
	header("Expires: " . $timestamp);
	header("Last-Modified: " . $timestamp);
	header("Pragma: no-cache");
	header("Cache-Control: no-cache, must-revalidate");
}

define('IN_GS', TRUE); // GS enviroment flag

// GS Debugger
global $GS_debug; // GS debug trace array
if(!isset($GS_debug)) $GS_debug = [];	

/**
 * Debug Console Log
 *
 * @since 3.1
 *
 * @param $txt string
 */
function debugLog($txt = '') {
	global $GS_debug;
	array_push($GS_debug,$txt);
}

/**
 * Set PHP enviroment
 */
if(function_exists('mb_internal_encoding')) mb_internal_encoding("UTF-8"); // set multibyte encoding

/**
 *  GSCONFIG definitions
 */

if(!defined('GSFRONT')) define('GSFRONT',1);
if(!defined('GSBACK'))  define('GSBACK',2);
if(!defined('GSBOTH'))  define('GSBOTH',3);
if(!defined('GSSTYLEWIDE')) define('GSSTYLEWIDE','wide'); // wide style sheet
if(!defined('GSSTYLE_SBFIXED')) define('GSSTYLE_SBFIXED','sbfixed'); // fixed sidebar

/**
 * Bad stuff protection
 */
include_once('security_functions.php');

if (version_compare(PHP_VERSION, "5")  >= 0) {
	foreach ($_GET as &$xss) $xss = antixss($xss);
}

/**
 * Basic file inclusions
 */
include('basic.php');
include('template_functions.php');
include('logging.class.php');

define('GSROOTPATH', get_root_path());

if(!is_frontend()){
	if (file_exists(GSROOTPATH . 'gsconfig.php')) {
		require_once(GSROOTPATH . 'gsconfig.php');
	}

	if (defined('GSADMIN')) {
		$GSADMIN = GSADMIN;
	} else {
		$GSADMIN = 'admin';
	}
}

// definition defaults

if(!defined('GSUPLOADSLC'))	define('GSUPLOADSLC',true);

if(!defined('GSNOFRAME')) define('GSNOFRAME',true);
if(!defined('GSNOFRAMEDEFAULT')) define('GSNOFRAMEDEFAULT','SAMEORIGIN');

// Add X-Frame-Options to HTTP header, so that page can only be shown in an iframe of the same site.
if(getDef('GSNOFRAME') !== false){
	if(getDef('GSNOFRAME') === GSBOTH) header_xframeoptions();
	else if((getDef('GSNOFRAME') === true || getDef('GSNOFRAME') === GSBACK) && !is_frontend()) header_xframeoptions();
	else if(getDef('GSNOFRAME') === GSFRONT && is_frontend()) header_xframeoptions();
}

/**
 * Define some constants
 */
define('GSADMINPATH', get_admin_path());
define('GSADMININCPATH', GSADMINPATH. 'inc/');
define('GSPLUGINPATH', GSROOTPATH. 'plugins/');
define('GSLANGPATH', GSADMINPATH. 'lang/');
define('GSDATAPATH', GSROOTPATH. 'data/');
define('GSDATAOTHERPATH', GSROOTPATH. 'data/other/');
define('GSDATAPAGESPATH', GSROOTPATH. 'data/pages/');
define('GSDATAUPLOADPATH', GSROOTPATH. 'data/uploads/');
define('GSTHUMBNAILPATH', GSROOTPATH. 'data/thumbs/');
define('GSBACKUPSPATH', GSROOTPATH. 'backups/');
define('GSTHEMESPATH', GSROOTPATH. 'theme/');
define('GSUSERSPATH', GSROOTPATH. 'data/users/');
define('GSBACKUSERSPATH', GSROOTPATH. 'backups/users/');
define('GSCACHEPATH', GSROOTPATH. 'data/cache/');
define('GSAUTOSAVEPATH', GSROOTPATH. 'data/pages/autosave/');
define('GSHOMEPATH', GSROOTPATH. '/');

$reservedSlugs = [$GSADMIN, 'data', 'theme', 'plugins', 'backups'];

require_once(GSADMININCPATH.'configuration.php');

/** grab authorization and security data — must load before grab user data */
if (defined('GSUSECUSTOMSALT')) {
	$SALT = sha1(GSUSECUSTOMSALT);
} else {
	if (file_exists(GSDATAOTHERPATH . 'authorization.xml')) {
		$dataa = getXML(GSDATAOTHERPATH . 'authorization.xml');
		$SALT  = stripslashes($dataa->apikey);
	}
}

/**
 * SQLite3: define gs_db() singleton — must come before any usage
*/

if (defined('GSDATABASE') && GSDATABASE == 'sqlite3') {
	function gs_db(): SQLite3 {
		static $db = null;
		if ($db === null) {
			$db = new SQLite3(GSDATAPATH . 'database.db');
			$db->enableExceptions(true);
			$db->exec('PRAGMA journal_mode=WAL');
			$db->exec('PRAGMA foreign_keys=ON');
		}
		return $db;
	}
}

/** 
* SQLite3: create tables and run one-time migration from XML
*/
if (defined('GSDATABASE') && GSDATABASE == 'sqlite3') {

 gs_db()->exec("
	CREATE TABLE IF NOT EXISTS pages (
		id		  INTEGER PRIMARY KEY AUTOINCREMENT,
		slug		TEXT	NOT NULL UNIQUE,
		title	   TEXT	NOT NULL,
		content	 TEXT,
		template	TEXT	DEFAULT 'template.php',
		meta		TEXT,
		metad	   TEXT,
		menu		TEXT,
		menu_order  INTEGER DEFAULT 0,
		menu_status TEXT	DEFAULT 'Y',
		parent	  TEXT	DEFAULT '',
		private	 INTEGER DEFAULT 0,
		pub_date	TEXT	DEFAULT (datetime('now')),
		author	  TEXT	NOT NULL DEFAULT ''
	)
");

	gs_db()->exec("
		CREATE TABLE IF NOT EXISTS settings (
			id		 INTEGER PRIMARY KEY AUTOINCREMENT,
			key		TEXT	NOT NULL UNIQUE,
			value	  TEXT,
			updated_at TEXT	DEFAULT (datetime('now'))
		)
	");

	gs_db()->exec("
		CREATE TABLE IF NOT EXISTS users (
			id		 INTEGER PRIMARY KEY AUTOINCREMENT,
			username   TEXT	NOT NULL UNIQUE,
			password   TEXT	NOT NULL,
			email	  TEXT	NOT NULL DEFAULT '',
			name	   TEXT	NOT NULL DEFAULT '',
			htmleditor TEXT	DEFAULT 'ckeditor',
			timezone   TEXT	DEFAULT '',
			lang	   TEXT	DEFAULT 'en_US',
			created_at TEXT	NOT NULL DEFAULT (datetime('now'))
		)
	");

	gs_db()->exec("
		CREATE TABLE IF NOT EXISTS components (
			id		 INTEGER PRIMARY KEY AUTOINCREMENT,
			slug	   TEXT	NOT NULL UNIQUE,
			title	  TEXT	NOT NULL DEFAULT '',
			value	  TEXT	NOT NULL DEFAULT '',
			updated_at TEXT	NOT NULL DEFAULT (datetime('now'))
		)
	");

	gs_db()->exec("
		CREATE TABLE IF NOT EXISTS plugins (
			id		 INTEGER PRIMARY KEY AUTOINCREMENT,
			plugin	 TEXT	NOT NULL UNIQUE,
			enabled	TEXT	NOT NULL DEFAULT 'false',
			updated_at TEXT	NOT NULL DEFAULT (datetime('now'))
		)
	");

	// Run one-time migration from XML files to SQLite3
	$migrationDone = gs_db()->querySingle(
		"SELECT value FROM settings WHERE key = 'migration_done' LIMIT 1"
	);

	if ($migrationDone !== '1') {

		$count  = 0;
		$errors = [];

		// Migrate components
		if (file_exists(GSDATAOTHERPATH . 'components.xml')) {
			try {
				$xml = simplexml_load_file(GSDATAOTHERPATH . 'components.xml');
				if ($xml && isset($xml->item)) {
					$cstmt = gs_db()->prepare("
						INSERT INTO components (slug, title, value)
						VALUES (:slug, :title, :value)
						ON CONFLICT(slug) DO UPDATE SET
							title	  = excluded.title,
							value	  = excluded.value,
							updated_at = datetime('now')
					");
					foreach ($xml->item as $item) {
						$cstmt->bindValue(':slug',  (string)$item->slug,  SQLITE3_TEXT);
						$cstmt->bindValue(':title', (string)$item->title, SQLITE3_TEXT);
						$cstmt->bindValue(':value', (string)$item->value, SQLITE3_TEXT);
						$cstmt->execute();
						$cstmt->reset();
					}
				}
			} catch (Exception $e) {
				$errors[] = 'components.xml: ' . $e->getMessage();
			}
		}

		// Migrate pages
		$stmt = gs_db()->prepare("
			INSERT INTO pages
				(slug, title, content, template, meta, metad,
				 menu, menu_order, menu_status, parent, private, pub_date, author)
			VALUES
					(:slug, :title, :content, :template, :meta, :metad,
					:menu, :menu_order, :menu_status, :parent, :private, :pub_date,:author)
			ON CONFLICT(slug) DO UPDATE SET
				title	   = excluded.title,
				content	 = excluded.content,
				template	= excluded.template,
				meta		= excluded.meta,
				metad	   = excluded.metad,
				menu		= excluded.menu,
				menu_order  = excluded.menu_order,
				menu_status = excluded.menu_status,
				parent	  = excluded.parent,
				private	 = excluded.private,
				pub_date	= excluded.pub_date,
				author	  = excluded.author
		");

		foreach (glob(GSDATAPAGESPATH . '*.xml') as $file) {
			try {
				$xml = simplexml_load_file($file);
				if (!$xml) { $errors[] = basename($file); continue; }

				$stmt->bindValue(':slug',		(string) $xml->url,						SQLITE3_TEXT);
				$stmt->bindValue(':title',	   (string) $xml->title,					  SQLITE3_TEXT);
				$stmt->bindValue(':content',	 (string) $xml->content,					SQLITE3_TEXT);
				$stmt->bindValue(':template',	(string) $xml->template ?: 'template.php', SQLITE3_TEXT);
				$stmt->bindValue(':meta',		(string) $xml->meta,					   SQLITE3_TEXT);
				$stmt->bindValue(':metad',	   (string) $xml->metad,					  SQLITE3_TEXT);
				$stmt->bindValue(':menu',		(string) $xml->menu,					   SQLITE3_TEXT);
				$stmt->bindValue(':menu_order',  (int)	$xml->menuOrder,				  SQLITE3_INTEGER);
				$stmt->bindValue(':menu_status', (string) $xml->menuStatus ?: 'Y',		  SQLITE3_TEXT);
				$stmt->bindValue(':parent',	  (string) $xml->parent,					 SQLITE3_TEXT);
				$stmt->bindValue(':private',	 (string) $xml->private ? 1 : 0,			SQLITE3_INTEGER);
				$stmt->bindValue(':pub_date',	(string) $xml->pubDate,					SQLITE3_TEXT);
				$stmt->bindValue(':author',	  (string) $xml->author,					 SQLITE3_TEXT);
				$stmt->execute();
				$stmt->reset();
				$count++;
			} catch (Exception $e) {
				$errors[] = basename($file) . ': ' . $e->getMessage();
			}
		}

		// Migrate users
		foreach (glob(GSUSERSPATH . '*.xml') as $file) {
			try {
				$xml = simplexml_load_file($file);
				if (!$xml) continue;

		  $ustmt = gs_db()->prepare("
	INSERT INTO users (username, password, email, name, htmleditor, timezone, lang)
	VALUES (:username, :password, :email, :name, :htmleditor, :timezone, :lang)
	ON CONFLICT(username) DO UPDATE SET
		password   = excluded.password,
		email	  = excluded.email,
		name	   = excluded.name,
		htmleditor = excluded.htmleditor,
		timezone   = excluded.timezone,
		lang	   = excluded.lang
");
$ustmt->bindValue(':username',   strtolower((string) $xml->USR),	  SQLITE3_TEXT);
$ustmt->bindValue(':password',   (string) $xml->PWD,				  SQLITE3_TEXT);
$ustmt->bindValue(':email',	  (string) ($xml->EMAIL	?? ''),	 SQLITE3_TEXT);
$ustmt->bindValue(':name',	   (string) ($xml->NAME	 ?? ''),	 SQLITE3_TEXT);
$ustmt->bindValue(':htmleditor', (string) ($xml->HTMLEDITOR ?? 'ckeditor'), SQLITE3_TEXT);
$ustmt->bindValue(':timezone',   (string) ($xml->TIMEZONE  ?? ''),   SQLITE3_TEXT);
$ustmt->bindValue(':lang',	   (string) ($xml->LANG	  ?? 'en_US'), SQLITE3_TEXT);
$ustmt->execute();
			} catch (Exception $e) {
				$errors[] = basename($file) . ': ' . $e->getMessage();
			}
		}

		// Migrate website settings
		if (file_exists(GSDATAOTHERPATH . 'website.xml')) {
			try {
				$wxml = simplexml_load_file(GSDATAOTHERPATH . 'website.xml');
				if ($wxml) {
					$wstmt = gs_db()->prepare("
						INSERT INTO settings (key, value)
						VALUES (:key, :value)
						ON CONFLICT(key) DO UPDATE SET
							value	  = excluded.value,
							updated_at = datetime('now')
					");
					foreach ([
						'sitename'   => (string) $wxml->SITENAME,
						'siteurl'	=> (string) $wxml->SITEURL,
						'template'   => (string) $wxml->TEMPLATE,
						'prettyurls' => (string) $wxml->PRETTYURLS,
						'permalink'  => (string) $wxml->PERMALINK,
					] as $key => $value) {
						$wstmt->bindValue(':key',   $key,   SQLITE3_TEXT);
						$wstmt->bindValue(':value', $value, SQLITE3_TEXT);
						$wstmt->execute();
						$wstmt->reset();
					}
				}
			} catch (Exception $e) {
				$errors[] = 'website.xml: ' . $e->getMessage();
			}
		}

		// Migrate plugins
		if (file_exists(GSDATAOTHERPATH . 'plugins.xml')) {
			try {
				$pxml = simplexml_load_file(GSDATAOTHERPATH . 'plugins.xml');
				if ($pxml && isset($pxml->item)) {
					$pstmt = gs_db()->prepare("
						INSERT INTO plugins (plugin, enabled)
						VALUES (:plugin, :enabled)
						ON CONFLICT(plugin) DO UPDATE SET
							enabled	= excluded.enabled,
							updated_at = datetime('now')
					");
					foreach ($pxml->item as $item) {
						$pstmt->bindValue(':plugin',  trim((string)$item->plugin),  SQLITE3_TEXT);
						$pstmt->bindValue(':enabled', trim((string)$item->enabled), SQLITE3_TEXT);
						$pstmt->execute();
						$pstmt->reset();
					}
				}
			} catch (Exception $e) {
				$errors[] = 'plugins.xml: ' . $e->getMessage();
			}
		}

		// Save migration flag
		$flag = gs_db()->prepare("
			INSERT INTO settings (key, value)
			VALUES (:key, :value)
			ON CONFLICT(key) DO UPDATE SET value = excluded.value
		");
		foreach ([
			'migration_done'   => '1',
			'migration_date'   => date('Y-m-d H:i:s'),
			'migration_pages'  => (string) $count,
			'migration_errors' => implode(',', $errors),
		] as $key => $value) {
			$flag->bindValue(':key',   $key,   SQLITE3_TEXT);
			$flag->bindValue(':value', $value, SQLITE3_TEXT);
			$flag->execute();
			$flag->reset();
		}

	} // end migration
}

/**
 * Debugging
 */
if ( isDebug() ) {
	error_reporting(-1);
	ini_set('display_errors', 1);
} else if( getDef('GSSUPPRESSERRORS',true) ||  getDef('SUPPRESSERRORS',true) ) {
	error_reporting(0);
	ini_set('display_errors', 0);
}
ini_set('log_errors', 1);
ini_set('error_log', GSDATAOTHERPATH .'logs/errorlog.txt');

/**
 * Variable check to prevent debugging going off
 * @todo some of these may not even be needed anymore
 */
$admin_relative = (isset($admin_relative)) ? $admin_relative : '';
$lang_relative = (isset($lang_relative)) ? $lang_relative : '';
$load['login'] = (isset($load['login'])) ? $load['login'] : '';
$load['plugin'] = (isset($load['plugin'])) ? $load['plugin'] : '';

/**
 * Pull data from storage
 */
 
/** grab website data */
$thisfilew = GSDATAOTHERPATH . 'website.xml';

if (defined('GSDATABASE') && GSDATABASE == 'sqlite3') {
	// read site settings from database
	$wresult  = gs_db()->query(
		"SELECT key, value FROM settings
		 WHERE key IN ('sitename','siteurl','template','prettyurls','permalink')"
	);
	$wsettings = [];
	while ($r = $wresult->fetchArray(SQLITE3_ASSOC)) {
		$wsettings[$r['key']] = $r['value'];
	}
	$SITENAME   = stripslashes($wsettings['sitename']   ?? '');
	$SITEURL	= $wsettings['siteurl']	?? '';
	$TEMPLATE   = $wsettings['template']   ?? '';
	$PRETTYURLS = $wsettings['prettyurls'] ?? '';
	$PERMALINK  = $wsettings['permalink']  ?? '';

} elseif (file_exists($thisfilew)) {
	// XML fallback
	$dataw	  = getXML($thisfilew);
	$SITENAME   = stripslashes($dataw->SITENAME);
	$SITEURL	= $dataw->SITEURL;
	$TEMPLATE   = $dataw->TEMPLATE;
	$PRETTYURLS = $dataw->PRETTYURLS;
	$PERMALINK  = $dataw->PERMALINK;

} else {
	$SITENAME = '';
	$SITEURL  = '';
}


/** grab user data */
if (isset($_COOKIE['GS_ADMIN_USERNAME'])) {
	 $cookie_user_id = strtolower(preg_replace('/[^a-zA-Z0-9_\-]/', '', $_COOKIE['GS_ADMIN_USERNAME']));
 

	if (defined('GSDATABASE') && GSDATABASE == 'sqlite3') {
		// read user from database
		$ustmt = gs_db()->prepare(
			"SELECT username, email, name, htmleditor, timezone, lang
			 FROM users WHERE username = :u LIMIT 1"
		);
		$ustmt->bindValue(':u', strtolower($cookie_user_id), SQLITE3_TEXT);
		$urow = $ustmt->execute()->fetchArray(SQLITE3_ASSOC);

		if ($urow) {
			$USR		= $urow['username'];
			$GLOBALS['USR'] = $USR;
			$HTMLEDITOR = $urow['htmleditor'] ?? 'ckeditor';
			$TIMEZONE   = $urow['timezone']   ?? (defined('GSTIMEZONE') ? GSTIMEZONE : '');
			$LANG	   = $urow['lang']	   ?? 'en_US';
		} else {
			$USR = null;
		}

	} else {
		// XML fallback
		if (file_exists(GSUSERSPATH . $cookie_user_id . '.xml')) {
			$datau	  = getXML(GSUSERSPATH . $cookie_user_id . '.xml');
			$USR		= stripslashes($datau->USR);
			$HTMLEDITOR = $datau->HTMLEDITOR;
			$TIMEZONE   = $datau->TIMEZONE;
			$LANG	   = $datau->LANG;
		} else {
			$USR = null;
		}
	}

} else {
	$USR = null;
}

/**
 * Language control
 */
if(!isset($LANG) || $LANG == '') {
	$filenames = glob(GSLANGPATH.'*.php');	
	$cntlang = count($filenames);
	if ($cntlang == 1) {
		// assign lang to only existing file
		$LANG = basename($filenames[0], ".php");
	} elseif($cntlang > 1 && in_array(GSLANGPATH .'en_US.php',$filenames)) {
		// fallback to en_US if it exists
		$LANG = 'en_US';
	} elseif(isset($filenames[0])) {
		// fallback to first lang found
		$LANG=basename($filenames[0], ".php");
	}
}

i18n_merge(null); // load $LANG file into $i18n

// Merge fallback language to fill any missing tokens
if( !getDef('GSMERGELANG') ) {
	// No custom merge lang defined — fall back to en_US
	if( $LANG != 'en_US' ) i18n_merge(null, 'en_US');
} else {
	// Merge the custom defined fallback lang if different from current
	if( $LANG != getDef('GSMERGELANG') ) i18n_merge(null, getDef('GSMERGELANG'));
}

/** 
 * Init Editor globals
 * @uses $EDHEIGHT
 * @uses $EDLANG
 * @uses $EDTOOL js array string | php array | 'none' | ck toolbar_ name
 * @uses $EDOPTIONS js obj param strings, comma delimited
 */

if(!defined('GSCKETSTAMP')) define('GSCKETSTAMP',get_gs_version()); // ckeditor asset querystring for cache control
if (defined('GSEDITORHEIGHT')) { $EDHEIGHT = GSEDITORHEIGHT .'px'; } else {	$EDHEIGHT = '500px'; }
if (defined('GSEDITORLANG'))   { $EDLANG = GSEDITORLANG; } else {	$EDLANG = i18n_r('CKEDITOR_LANG'); }
if (defined('GSEDITORTOOL') and !isset($EDTOOL)) { $EDTOOL = GSEDITORTOOL; }
if (defined('GSEDITOROPTIONS') and !isset($EDOPTIONS) && trim(GSEDITOROPTIONS)!="" ) $EDOPTIONS = GSEDITOROPTIONS;
if (defined('GSCMTHEME')) { $CMTHEME = GSCMTHEME; } else { $CMTHEME = 'blackboard'; }

if(!isset($EDTOOL)) $EDTOOL = 'basic'; // default gs toolbar

if($EDTOOL == "none") $EDTOOL = null; // toolbar to use cke default
$EDTOOL = returnJsArray($EDTOOL);
// if($EDTOOL === null) $EDTOOL = 'null'; // not supported in cke 3.x
// at this point $EDTOOL should always be a valid js nested array ([[ ]]) or escaped toolbar id ('toolbar_id')

/**
 * Timezone setup
 */

// set defined timezone from config if not set on user
if( (!isset($TIMEZONE) || trim($TIMEZONE) == '' ) && defined('GSTIMEZONE') ){
	$TIMEZONE = GSTIMEZONE;
}

if(isset($TIMEZONE) && function_exists('date_default_timezone_set') && ($TIMEZONE != "" || stripos($TIMEZONE, '--')) ) { 
	date_default_timezone_set($TIMEZONE);
}

/**
 * Variable Globalization
 */
global $SITENAME, $SITEURL, $TEMPLATE, $TIMEZONE, $LANG, $SALT, $i18n, $USR, $PERMALINK, $GSADMIN, $components, $EDTOOL, $EDOPTIONS, $EDLANG, $EDHEIGHT;

/** grab authorization and security data */
 if (empty($SALT) && $SITEURL != '' && get_filename_id() != 'install' && get_filename_id() != 'setup' && get_filename_id() != 'update' && get_filename_id() != 'style') {
	die(i18n_r('KILL_CANT_CONTINUE')."<br/>".i18n_r('MISSING_FILE').": authorization.xml");
}
$SESSIONHASH = sha1($SALT . $SITENAME);

/**
 * $base is if the site is being viewed from the front-end
 */
if(isset($base)) {
	include_once(GSADMININCPATH.'theme_functions.php');
}

function serviceUnavailable(){
	GLOBAL $base;
	if(isset($base)){
		header('HTTP/1.1 503 Service Temporarily Unavailable');
		header('Status: 503 Service Temporarily Unavailable');
		header('Retry-After: 7200'); // in seconds
		i18n('SERVICE_UNAVAILABLE');
		die();
	}
}

/**
 * Check to make sure site is already installed
 */
if (get_filename_id() != 'install' && get_filename_id() != 'setup' && get_filename_id() != 'update') {
	$fullpath = suggest_site_path();
	
	// if there is no SITEURL set, then it's a fresh install. Start installation process
	// siteurl check is not good for pre 3.0 since it will be empty, so skip and run update first.
	if ($SITEURL == '' && version_compare(get_gs_version(), '3.0', '>=')) {
		serviceUnavailable();
		redirect($fullpath . $GSADMIN.'/install.php');
	} 
	else {	
		// if an update file was included in the install package, redirect there first	
		if (file_exists(GSADMINPATH.'update.php') && !isset($_GET['updated']) && !getDef('GSDEBUGINSTALL'))	{
			serviceUnavailable();
			redirect($fullpath . $GSADMIN.'/update.php');
		}
	}

	if (!getDef('GSDEBUGINSTALL', true)) {
		// If the site is already installed, remove the installation files
		$filesToDelete = [
			GSADMINPATH . 'cron.php',
			GSADMINPATH . 'humans.txt',
			GSADMINPATH . 'load-ajax.php',
			GSADMINPATH . 'loadtab.php',
			GSADMINPATH . 'install.php',
			GSADMINPATH . 'option.txt',
			GSADMINPATH . 'setup.php',
			GSADMINPATH . 'update.php',
			GSADMINPATH . 'uploadify-check-exists.php',
			GSADMINPATH . 'upload-uploadify.php',
			
			GSADMININCPATH . 'nonce.php',
			GSADMININCPATH . 'xss.php',
			GSADMININCPATH . 'ZipArchive.php',
			
			GSHOMEPATH . 'readme.txt',
			GSHOMEPATH . 'README.md',
			GSHOMEPATH . 'LICENSE.txt',
			GSHOMEPATH . 'LICENSE',
			GSHOMEPATH . 'Tmpfile.zip',
			
			GSPLUGINPATH . 'anonymous_data.php',
			GSPLUGINPATH . 'README.md',
			
			GSTHEMESPATH . 'README.md',
		];

		$failedDeletions = []; // Array to store files that couldn't be deleted

		foreach ($filesToDelete as $file) {
			if (file_exists($file) && !unlink($file)) {
				$failedDeletions[] = $file; // Add the file to the failed deletions array
			}
		}

		if (!empty($failedDeletions)) {
			// Construct the error message dynamically
			$failedFilesList = array_map(function($file) {
				return '<code>' . basename($file) . '</code>';
			}, $failedDeletions);

			$error = sprintf(
				i18n_r('ERR_CANNOT_DELETE'),
				implode(', ', $failedFilesList) // List of files that couldn't be deleted
			);
		}

		function deleteDirectory($dir)
		{
			if (!file_exists($dir)) {
				return true;
			}
			if (!is_dir($dir)) {
				return unlink($dir);
			}
			foreach (scandir($dir) as $item) {
				if ($item === '.' || $item === '..') {
					continue;
				}
				if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
					return false;
				}
			}
			return rmdir($dir);
		}

		$dirsToDelete = [
			GSHOMEPATH . 'install_TMP',
			GSADMINPATH . 'template/js/fancybox',
			GSADMINPATH . 'template/js/uploadify',
			GSADMINPATH . 'template/js/codemirror/lib',
			GSADMINPATH . 'template/js/codemirror/theme',
			
			GSPLUGINPATH . 'anonymous_data',
		];

		foreach ($dirsToDelete as $dir) {
			if (file_exists($dir)) {
				if (!deleteDirectory($dir)) {
					// Handle directory deletion failure if needed
				}
			}
		}
	}

}

/**
 * Include other files depending if they are needed or not
 */
include_once(GSADMININCPATH.'cookie_functions.php');
if(isset($load['plugin']) && $load['plugin']){
	// remove the pages.php plugin if it exists. 	
	if (file_exists(GSPLUGINPATH.'pages.php'))	{
		unlink(GSPLUGINPATH.'pages.php');
	}
	include_once(GSADMININCPATH.'plugin_functions.php');
	if(get_filename_id()=='settings' || get_filename_id()=='load') {
		/* this core plugin only needs to be visible when you are viewing the 
		settings page since that is where its sidebar item is. */
		if (defined('GSEXTAPI') && GSEXTAPI==1) {
			include_once('api.plugin.php');
		}
	}
	// include core plugin for page caching
	include_once('caching_functions.php');
	
	// main hook for common.php
	exec_action('common');

	// Re-merge fallback lang in plugins.
	if( !getDef('GSMERGELANG') ) {
		if( $LANG != 'en_US' ) i18n_merge(null, 'en_US');
	} else {
		if( $LANG != getDef('GSMERGELANG') ) i18n_merge(null, getDef('GSMERGELANG'));
	}

}
if(isset($load['login']) && $load['login']){
	include_once(GSADMININCPATH.'login_functions.php'); 
}
?>