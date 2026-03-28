<?php
/*
Plugin Name: GS Config GUI
Description: Visual editor for gsconfig.php configuration settings.
Version: 1.0
Author: risingisland
Author URI: https://www.getsimple-ce.ovh
*/

# get correct id for plugin
$gsConfigGUI = basename(__FILE__, ".php");

# add in this plugin's language file
i18n_merge($gsConfigGUI) || i18n_merge($gsConfigGUI, 'en_US');

# register plugin
register_plugin(
	$gsConfigGUI,
	'GS Config GUI',
	'1.1',
	'risingisland',
	'https://www.getsimple-ce.ovh/',
	'Visual editor for gsconfig.php configuration settings.',
	'settings',
	'gscfg_panel'
);

# add sidebar link
add_action('settings-sidebar', 'createSideMenu', array($gsConfigGUI, i18n_r('gsConfigGUI/lang_Menu_Title') . ' <svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;" width="18px" height="18px" viewBox="0 0 24 24"><rect width="24" height="24" fill="none"/><path fill="#0" fill-rule="evenodd" d="M7 3a4 4 0 0 1 3.874 3H19v2h-8.126A4.002 4.002 0 0 1 3 7a4 4 0 0 1 4-4m0 6a2 2 0 1 0 0-4a2 2 0 0 0 0 4m10 11a4 4 0 0 1-3.874-3H5v-2h8.126A4.002 4.002 0 0 1 21 16a4 4 0 0 1-4 4m0-2a2 2 0 1 0 0-4a2 2 0 0 0 0 4" clip-rule="evenodd"/></svg>'));


# ----------------------------------------------------------
#  CONSTANTS / KNOWN SETTINGS
# ----------------------------------------------------------

function gscfg_get_path() {
	return GSROOTPATH . 'gsconfig.php';
}

function gscfg_known() {
	return array(
		'GSLOGINSALT'               => array('type' => 'text',     'label' => i18n_r('gsConfigGUI/lang_Password_Hash'),               'desc' => i18n_r('gsConfigGUI/lang_Password_Hash_info').'.', 'link' => '<a class="gscfg-desc-link" href="salt-shaker.php" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>' . i18n_r('gsConfigGUI/lang_Generator') . '</a>'),
		
		'GSUSECUSTOMSALT'           => array('type' => 'text',     'label' => i18n_r('gsConfigGUI/lang_Custom_Salt'),               'desc' => i18n_r('gsConfigGUI/lang_Custom_Salt_info').'.', 'link' => '<a class="gscfg-desc-link" href="salt-shaker.php" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>' . i18n_r('gsConfigGUI/lang_Generator') . '</a>'),
		
		'GSIMAGEWIDTH'              => array('type' => 'text',     'label' => i18n_r('gsConfigGUI/lang_Thumbnail_Width'),     'desc' => i18n_r('gsConfigGUI/lang_Thumbnail_Width_info').'.'),
		
		'GSADMIN'                   => array('type' => 'text',     'label' => i18n_r('gsConfigGUI/lang_Admin_Folder'),         'desc' => i18n_r('gsConfigGUI/lang_Admin_Folder_info').'.'),
		
		'GSDEBUG'                   => array('type' => 'bool',     'label' => i18n_r('gsConfigGUI/lang_Debug_Mode'),                'desc' => i18n_r('gsConfigGUI/lang_Debug_Mode_info').'.'),
		
		'GSDONOTPING'               => array('type' => 'bool',     'label' => i18n_r('gsConfigGUI/lang_Search_Ping'),'desc' => i18n_r('gsConfigGUI/lang_Search_Ping_info').'.'),
		
		'GSNOCSRF'                  => array('type' => 'bool',     'label' => i18n_r('gsConfigGUI/lang_Disable_CSRF'),   'desc' => i18n_r('gsConfigGUI/lang_Disable_CSRF_info').'.'),
		
		'GSCHMOD'                   => array('type' => 'rawval',   'label' => i18n_r('gsConfigGUI/lang_CHMOD_Mode'),       'desc' => i18n_r('gsConfigGUI/lang_CHMOD_Mode_info').'.'),
		
		'GSDOCHMOD'                 => array('type' => 'rawval',   'label' => i18n_r('gsConfigGUI/lang_Disable_CHMOD'),  'desc' => i18n_r('gsConfigGUI/lang_Disable_CHMOD_info').'.'),
		
		'GSCANONICAL'               => array('type' => 'bool',     'label' => i18n_r('gsConfigGUI/lang_Canonical'),       'desc' => i18n_r('gsConfigGUI/lang_Canonical_info').'.'),
		
		'GSSORTPAGELISTBY'          => array('type' => 'text',     'label' => i18n_r('gsConfigGUI/lang_Sort_Page'),         'desc' => i18n_r('gsConfigGUI/lang_Sort_Page_info').'.', 'default' => 'menu'),
		
		'GSEDITORHEIGHT'            => array('type' => 'text',     'label' => i18n_r('gsConfigGUI/lang_Editor_Height'),             'desc' => i18n_r('gsConfigGUI/lang_Editor_Height_info').'.'),
		
		'GSEDITORTOOL'              => array('type' => 'text',     'label' => i18n_r('gsConfigGUI/lang_Editor_Toolbar'),            'desc' => i18n_r('gsConfigGUI/lang_Editor_Toolbar_info').'.'),
		
		'GSEDITORLANG'              => array('type' => 'text',     'label' => i18n_r('gsConfigGUI/lang_Editor_Language'),           'desc' => i18n_r('gsConfigGUI/lang_Editor_Language_info').'.'),
		
		'GSEDITOROPTIONS'           => array('type' => 'textarea', 'label' => i18n_r('gsConfigGUI/lang_Editor_Options'),            'desc' => i18n_r('gsConfigGUI/lang_Editor_Options_info'), 'link' => '<a class="gscfg-desc-link" href="#" onclick="gscfgEditorOptionsDefault();return false;"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg> ' . i18n_r('gsConfigGUI/lang_Restore_defaults') . '</a>'),
		
		'GSCMTHEME'                 => array('type' => 'text',     'label' => i18n_r('gsConfigGUI/lang_CodeMirror'),          'desc' => i18n_r('gsConfigGUI/lang_CodeMirror_info').'.', 'default' => 'blackboard'),
		
		'GSFROMEMAIL'               => array('type' => 'email',    'label' => i18n_r('gsConfigGUI/lang_Email_Address'),        'desc' => i18n_r('gsConfigGUI/lang_Email_Address_info').'.'),
		
		'GSAUTOSAVE'                => array('type' => 'rawval',   'label' => i18n_r('gsConfigGUI/lang_Autosave'),         'desc' => i18n_r('gsConfigGUI/lang_Autosave_info').'.'),
		
		'GSTIMEZONE'                => array('type' => 'text',     'label' => i18n_r('gsConfigGUI/lang_Server_Timezone'),           'desc' => i18n_r('gsConfigGUI/lang_Server_Timezone_info').'.', 'link' => '<a class="gscfg-desc-link" href="https://www.php.net/manual/en/timezones.php" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg> ' . i18n_r('gsConfigGUI/lang_PHP_Timezones') . '</a>'),
		
		'GSNOCDN'                   => array('type' => 'bool',     'label' => i18n_r('gsConfigGUI/lang_Disable_CDN'),      'desc' => i18n_r('gsConfigGUI/lang_Disable_CDN_info').'.'),
		
		'GSNOHIGHLIGHT'             => array('type' => 'bool',     'label' => i18n_r('gsConfigGUI/lang_Disable_CodeMirror'), 'desc' => i18n_r('gsConfigGUI/lang_Disable_CodeMirror_info').'.'),
		
		'GSSUPPRESSERRORS'          => array('type' => 'bool',     'label' => i18n_r('gsConfigGUI/lang_PHP_Errors'),       'desc' => i18n_r('gsConfigGUI/lang_PHP_Errors_info').'.'),
		
		'GSNOAPACHECHECK'           => array('type' => 'bool',     'label' => i18n_r('gsConfigGUI/lang_Apache_Check'),      'desc' => i18n_r('gsConfigGUI/lang_Apache_Check_info').'.'),
		
		'GSNOSITEMAP'               => array('type' => 'bool',     'label' => i18n_r('gsConfigGUI/lang_Disable_Sitemap'),           'desc' => i18n_r('gsConfigGUI/lang_Disable_Sitemap_info').'.'),
		
		'GSAUTOMETAD'               => array('type' => 'bool',     'label' => i18n_r('gsConfigGUI/lang_Auto_Meta'),    'desc' => i18n_r('gsConfigGUI/lang_Auto_Meta_info').'.'),
		
		'GSMERGELANG'               => array('type' => 'rawval',   'label' => i18n_r('gsConfigGUI/lang_Merge_Language'),            'desc' => i18n_r('gsConfigGUI/lang_Merge_Language_info').'.'),
		
		'GSNOFRAME'                 => array('type' => 'rawval',   'label' => i18n_r('gsConfigGUI/lang_XFrame'),           'desc' => i18n_r('gsConfigGUI/lang_XFrame_info').'.'),
		
		'GSFORMATXML'               => array('type' => 'bool',     'label' => i18n_r('gsConfigGUI/lang_Format_XML'),          'desc' => i18n_r('gsConfigGUI/lang_Format_XML_info').'.'),
		
		'GSEXTAPI'                  => array('type' => 'bool',     'label' => i18n_r('gsConfigGUI/lang_External_API'),       'desc' => i18n_r('gsConfigGUI/lang_External_API_info').'.'),
		
		'I18N_SINGLE_LANGUAGE'      => array('type' => 'bool',     'label' => i18n_r('gsConfigGUI/lang_i18n_Language'),      'desc' => i18n_r('gsConfigGUI/lang_i18n_Language_info').'.'),
		
		'I18N_IGNORE_USER_LANGUAGE' => array('type' => 'bool',     'label' => i18n_r('gsConfigGUI/lang_i18n_Ignore'),  'desc' => i18n_r('gsConfigGUI/lang_i18n_Ignore_info').'.'),
	);
}

function gscfg_groups() {
	return array(
		i18n_r('gsConfigGUI/lang_Site_Behavior')		=> array('$LANG', 'GSSORTPAGELISTBY', 'GSADMIN', 'GSCANONICAL', 'GSDONOTPING', 'GSNOSITEMAP', 'GSAUTOMETAD', 'GSEXTAPI'),

		i18n_r('gsConfigGUI/lang_Editor')				=> array('GSEDITORTOOL', 'GSEDITORHEIGHT', 'GSEDITORLANG', 'GSEDITOROPTIONS', 'GSCMTHEME', 'GSNOHIGHLIGHT', 'GSAUTOSAVE'),

		i18n_r('gsConfigGUI/lang_Files_Permissions')	=> array('GSIMAGEWIDTH', 'GSCHMOD', 'GSDOCHMOD', 'GSFORMATXML', 'GSNOCDN'),

		i18n_r('gsConfigGUI/lang_Localization')			=> array('GSTIMEZONE', 'setlocale', 'GSMERGELANG'),

		i18n_r('gsConfigGUI/lang_Debugging')			=> array('GSDEBUG', 'GSSUPPRESSERRORS'),

		i18n_r('gsConfigGUI/lang_Security')				=> array('GSLOGINSALT', 'GSUSECUSTOMSALT', 'GSNOCSRF', 'GSNOFRAME', 'GSNOAPACHECHECK', 'GSFROMEMAIL'),

		i18n_r('gsConfigGUI/lang_Plugins')				=> array('I18N_SINGLE_LANGUAGE', 'I18N_IGNORE_USER_LANGUAGE'),
	);
}

function gscfg_get_langs() {
	$langs = array();
	$langPath = GSADMINPATH . 'lang/';
	if (is_dir($langPath)) {
		$files = glob($langPath . '*.php');
		if ($files) {
			foreach ($files as $file) {
				$langs[] = basename($file, '.php');
			}
		}
	}
	if (empty($langs)) {
		$langs = array('ar_SA','da_DK','de_DE','en_US','es_ES','fr_FR','it_IT','ja_JP','nb_NO','nl_NL','pt_PT','pl_PL','ru_RU','sv_SE','uk_UK');
	}
	return $langs;
}


# ----------------------------------------------------------
#  PARSE gsconfig.php
# ----------------------------------------------------------

function gscfg_parse($content) {
	$settings = array();
	$known    = gscfg_known();

	foreach ($known as $key => $meta) {
		$enabled = false;
		$value   = '';
		$qkey    = preg_quote($key, '/');

		// Active define (no leading #) — s flag allows . to match newlines for multiline values
		if (preg_match('/^[ \t]*define\s*\(\s*[\'"]' . $qkey . '[\'"]\s*,\s*(.*?)\s*\)\s*;/ms', $content, $m)) {
			$enabled = true;
			$raw = trim($m[1]);
			// Strip surrounding quotes if present, otherwise keep bare value (TRUE, FALSE, 1, 0, GSBOTH, etc.)
			if (preg_match('/^([\'"])(.*)\1$/s', $raw, $qm)) {
				$value = $qm[2];
			} else {
				$value = $raw;
			}
		}
		// Commented define
		elseif (preg_match('/^[ \t]*#[ \t]*define\s*\(\s*[\'"]' . $qkey . '[\'"]\s*,\s*(.*?)\s*\)\s*;/ms', $content, $m)) {
			$enabled = false;
			$raw = trim($m[1]);
			if (preg_match('/^([\'"])(.*)\1$/s', $raw, $qm)) {
				$value = $qm[2];
			} else {
				$value = $raw;
			}
		}

		$entry = $meta;
		$entry['enabled'] = $enabled;
		$entry['value']   = $value;
		// If not found in the file at all, fall back to the declared default (if any)
		if (!$enabled && $value === '' && isset($meta['default'])) {
			$entry['value']   = $meta['default'];
			$entry['enabled'] = true;
		}
		$settings[$key]   = $entry;
	}

	// $LANG — never commented
	if (preg_match('/^\s*\$LANG\s*=\s*[\'"]([^\'"]+)[\'"]\s*;/m', $content, $m)) {
		$settings['$LANG'] = array('type' => 'lang', 'label' => i18n_r('gsConfigGUI/lang_Login_Page'), 'desc' => i18n_r('gsConfigGUI/lang_Login_Page_info'), 'enabled' => true, 'value' => $m[1]);
	} else {
		$settings['$LANG'] = array('type' => 'lang', 'label' => i18n_r('gsConfigGUI/lang_Login_Page'), 'desc' => i18n_r('gsConfigGUI/lang_Login_Page_info'), 'enabled' => true, 'value' => 'en_US');
	}

	$setlocale_link = '<a class="gscfg-desc-link" href="https://www.php.net/manual/en/function.setlocale.php" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg> ' . i18n_r('gsConfigGUI/lang_php_url') . '</a>';
	// setlocale
	if (preg_match('/^[ \t]*setlocale\s*\(\s*LC_ALL\s*,\s*[\'"]([^\'"]+)[\'"]\s*\)\s*;/m', $content, $m)) {
		$settings['setlocale'] = array('type' => 'text', 'label' => i18n_r('gsConfigGUI/lang_PHP_Locale'), 'desc' => i18n_r('gsConfigGUI/lang_PHP_Locale_info'), 'link' => $setlocale_link, 'enabled' => true, 'value' => $m[1]);
	} elseif (preg_match('/^[ \t]*#[ \t]*setlocale\s*\(\s*LC_ALL\s*,\s*[\'"]([^\'"]+)[\'"]\s*\)\s*;/m', $content, $m)) {
		$settings['setlocale'] = array('type' => 'text', 'label' => i18n_r('gsConfigGUI/lang_PHP_Locale'), 'desc' => i18n_r('gsConfigGUI/lang_PHP_Locale_info'), 'link' => $setlocale_link, 'enabled' => false, 'value' => $m[1]);
	} else {
		$settings['setlocale'] = array('type' => 'text', 'label' => i18n_r('gsConfigGUI/lang_PHP_Locale'), 'desc' => i18n_r('gsConfigGUI/lang_PHP_Locale_info'), 'link' => $setlocale_link, 'enabled' => false, 'value' => 'en_US');
	}

	return $settings;
}


# ----------------------------------------------------------
#  WRITE gsconfig.php
# ----------------------------------------------------------

function gscfg_write($content, $settings) {
	$known = gscfg_known();

	foreach ($known as $key => $meta) {
		if (!isset($settings[$key])) { continue; }
		$s       = $settings[$key];
		$enabled = !empty($s['enabled']);
		$val     = isset($s['value']) ? $s['value'] : '';
		$qkey    = preg_quote($key, '/');

		if ($meta['type'] === 'bool') {
			// Preserve the original style — 1/0 stay as integers, TRUE/FALSE stay as barewords
			$u = strtoupper(trim($val));
			if ($u === 'FALSE') {
				$valStr = 'FALSE';
			} elseif ($u === 'TRUE') {
				$valStr = 'TRUE';
			} elseif ($val === '0') {
				$valStr = '0';
			} else {
				$valStr = '1';
			}
		} elseif ($meta['type'] === 'rawval') {
			// Written bare — no quotes. Covers FALSE, en_US, PHP constants like GSBOTH.
			$valStr = $val;
		} elseif ($meta['type'] === 'number') {
			// Written as a bare integer — no quotes
			$valStr = intval($val);
		} elseif ($meta['type'] === 'textarea') {
			// Use multiline format only when there is content; empty stays as ''
			$valStr = ($val !== '') ? "'\n" . str_replace("'", "\\'", $val) . "\n'" : "''";
		} else {
			$valStr = "'" . addslashes($val) . "'";
		}

		$newLine  = ($enabled ? '' : '# ') . "define('" . $key . "', " . $valStr . ");";
		// s flag so . matches newlines — essential for GSEDITOROPTIONS multiline value
		$pat_on   = '/^[ \t]*define\s*\(\s*[\'"]' . $qkey . '[\'"]\s*,.*?\)\s*;/ms';
		$pat_off  = '/^[ \t]*#[ \t]*define\s*\(\s*[\'"]' . $qkey . '[\'"]\s*,.*?\)\s*;/ms';

		if (preg_match($pat_on, $content)) {
			$content = preg_replace($pat_on, $newLine, $content, 1);
		} elseif (preg_match($pat_off, $content)) {
			$content = preg_replace($pat_off, $newLine, $content, 1);
		} else {
			// Setting not found — build the insert line, using the declared default if available
			if ($val === '' && isset($meta['default'])) {
				$defaultVal = $meta['default'];
				if ($meta['type'] === 'bool') {
					$u = strtoupper(trim($defaultVal));
					$defaultStr = ($u === 'FALSE' || $u === '0') ? $defaultVal : $defaultVal;
				} elseif ($meta['type'] === 'rawval') {
					$defaultStr = $defaultVal;
				} elseif ($meta['type'] === 'number') {
					$defaultStr = intval($defaultVal);
				} else {
					$defaultStr = "'" . addslashes($defaultVal) . "'";
				}
				// Always write enabled when a default exists
				$newLine = "define('" . $key . "', " . $defaultStr . ");";
			}
			$insert = "\n# " . $meta['label'] . "\n" . $newLine . "\n";
			if (preg_match('/\?>\s*$/', $content)) {
				$content = preg_replace('/\?>\s*$/', $insert . "\n?>", $content);
			} else {
				$content .= $insert;
			}
		}
	}

	// $LANG
	if (isset($settings['$LANG'])) {
		$newLang = "\$LANG = '" . addslashes($settings['$LANG']['value']) . "';";
		if (preg_match('/^\s*\$LANG\s*=\s*[\'"][^\'"]*[\'"]\s*;/m', $content)) {
			$content = preg_replace('/^\s*\$LANG\s*=\s*[\'"][^\'"]*[\'"]\s*;/m', $newLang, $content, 1);
		} else {
			if (preg_match('/\?>\s*$/', $content)) {
				$content = preg_replace('/\?>\s*$/', "\n# Login Page Default Language\n" . $newLang . "\n\n?>", $content);
			} else {
				$content .= "\n# Login Page Default Language\n" . $newLang . "\n";
			}
		}
	}

	// setlocale
	if (isset($settings['setlocale'])) {
		$s       = $settings['setlocale'];
		$enabled = !empty($s['enabled']);
		$val     = addslashes(isset($s['value']) ? $s['value'] : 'en_US');
		$newLine = ($enabled ? '' : '# ') . "setlocale(LC_ALL,'" . $val . "');";
		$pat     = '/^[ \t]*#?[ \t]*setlocale\s*\(\s*LC_ALL\s*,\s*[\'"][^\'"]*[\'"]\s*\)\s*;/m';
		if (preg_match($pat, $content)) {
			$content = preg_replace($pat, $newLine, $content, 1);
		} else {
			if (preg_match('/\?>\s*$/', $content)) {
				$content = preg_replace('/\?>\s*$/', "\n# Set PHP locale\n" . $newLine . "\n\n?>", $content);
			} else {
				$content .= "\n# Set PHP locale\n" . $newLine . "\n";
			}
		}
	}

	return $content;
}


# ----------------------------------------------------------
#  HANDLE SAVE
# ----------------------------------------------------------

function gscfg_handle_save() {
	if (!isset($_POST['gscfg_save'])) { return null; }

	$path    = gscfg_get_path();
	if (!file_exists($path)) {
		return array('error', 'gsconfig.php not found at: ' . htmlspecialchars($path));
	}
	if (!is_writable($path)) {
		return array('error', 'gsconfig.php is not writable. Check file permissions.');
	}

	$content  = file_get_contents($path);
	$known    = gscfg_known();
	$settings = gscfg_parse($content);
	$toWrite  = array();

	foreach ($known as $key => $meta) {
		$formKey = str_replace(array('$', '(', ')'), array('_d_', '', ''), $key);
		$enabled = (isset($_POST['en_' . $formKey]) && $_POST['en_' . $formKey] === '1');
		if (isset($_POST['val_' . $formKey])) {
			$value = stripslashes(trim($_POST['val_' . $formKey]));
		} else {
			$value = isset($settings[$key]['value']) ? $settings[$key]['value'] : '';
		}
		$entry = $meta;
		$entry['enabled'] = $enabled;
		$entry['value']   = $value;
		$toWrite[$key]    = $entry;
	}

	// $LANG — validate against available langs before saving
	$langVal = isset($_POST['val__d_LANG']) ? stripslashes(trim($_POST['val__d_LANG'])) : $settings['$LANG']['value'];
	$validLangs = gscfg_get_langs();
	if (!in_array($langVal, $validLangs)) {
		return array('error', 'Invalid language "' . htmlspecialchars($langVal, ENT_QUOTES, 'UTF-8') . '" — this language file does not exist in the lang folder. Please select a valid language before saving.');
	}
	$langEntry = $settings['$LANG'];
	$langEntry['enabled'] = true;
	$langEntry['value']   = $langVal;
	$toWrite['$LANG'] = $langEntry;

	// setlocale
	$slEnabled = (isset($_POST['en_setlocale']) && $_POST['en_setlocale'] === '1');
	$slVal     = isset($_POST['val_setlocale']) ? stripslashes(trim($_POST['val_setlocale'])) : $settings['setlocale']['value'];
	$slEntry   = $settings['setlocale'];
	$slEntry['enabled'] = $slEnabled;
	$slEntry['value']   = $slVal;
	$toWrite['setlocale'] = $slEntry;

	$newContent = gscfg_write($content, $toWrite);

	copy($path, $path . '.bak');

	if (file_put_contents($path, $newContent) !== false) {
		return array('success', i18n_r('gsConfigGUI/lang_Settings_saved'));
	}
	return array('error', i18n_r('gsConfigGUI/lang_Failed_to_write'));
}


# ----------------------------------------------------------
#  ADMIN PANEL
# ----------------------------------------------------------

function gscfg_panel() {

	$result   = gscfg_handle_save();
	$path     = gscfg_get_path();
	$exists   = file_exists($path);
	$writable = $exists && is_writable($path);
	$content  = $exists ? file_get_contents($path) : '';
	$settings = $content ? gscfg_parse($content) : array();
	$langs    = gscfg_get_langs();

	// Build grouped list — each key shown only once
	$rawGroups = gscfg_groups();
	$shown     = array();
	$grouped   = array();
	foreach ($rawGroups as $gname => $keys) {
		$grouped[$gname] = array();
		foreach ($keys as $k) {
			if (!in_array($k, $shown) && isset($settings[$k])) {
				$grouped[$gname][] = $k;
				$shown[] = $k;
			}
		}
	}
	// Catch any leftovers
	$leftovers = array();
	foreach ($settings as $k => $v) {
		if (!in_array($k, $shown)) { $leftovers[] = $k; }
	}
	if (!empty($leftovers)) { $grouped['Other'] = $leftovers; }

?>
<style>
#gscfg-wrap, #gscfg-wrap * { box-sizing: border-box; }
#gscfg-wrap {
	font-family: inherit;
	margin-top: 10px;
}
#gscfg-wrap .gscfg-header {
	background: #f8f9fb;
	border: 1px solid #dde1e9;
	border-radius: 8px 8px 0 0;
	padding: 14px 20px;
	display: flex;
	align-items: center;
	gap: 14px;
	flex-wrap: wrap;
	border-bottom: none;
}
#gscfg-wrap .gscfg-logo {
	display: flex;
	align-items: center;
	gap: 10px;
}
#gscfg-wrap .gscfg-logo-icon {
	width: 30px;
	height: 30px;
	background: linear-gradient(135deg, #272727, #4E4E4E);
	border-radius: 6px;
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 14px;
	font-weight: bold;
	color: #fff;
}
#gscfg-wrap .gscfg-logo-title {
	font-size: 15px;
	font-weight: 700;
	color: #1e293b;
	letter-spacing: -0.2px;
}
#gscfg-wrap .gscfg-logo-title span { color: #CF3805; }
#gscfg-wrap .gscfg-filepath {
	font-family: monospace;
	font-size: 11px;
	color: #64748b;
	background: #fff;
	padding: 4px 10px;
	border-radius: 5px;
	border: 1px solid #dde1e9;
	display: inline-flex;
	align-items: center;
	gap: 6px;
}
#gscfg-wrap .gscfg-header .gscfg-desc {
	flex: 0 0 100%; /* Takes full width */
	order: 3; /* Ensures it comes after the first two */
	margin-top: 8px; /* Optional spacing */
}
#gscfg-wrap .gscfg-dot {
	width: 7px;
	height: 7px;
	border-radius: 50%;
	flex-shrink: 0;
}
#gscfg-wrap .gscfg-notice {
	padding: 10px 16px;
	font-size: 12px;
	border-left: 4px solid;
	margin: 0 0 12px;
	border-radius: 0 4px 4px 0;
}
#gscfg-wrap .gscfg-notice.success { background: #f0fdf4; border-color: #22c55e; color: #15803d; }
#gscfg-wrap .gscfg-notice.error   { background: #fef2f2; border-color: #ef4444; color: #b91c1c; }
#gscfg-wrap .gscfg-notice.warning { background: #fff7ed; border-color: #f97316; color: #c2410c; font-family: monospace; }
#gscfg-wrap .gscfg-layout {
	display: flex;
	border: 1px solid #dde1e9;
	border-bottom: none;
	background: #fff;
}
#gscfg-wrap .gscfg-sidebar {
	width: 170px;
	flex-shrink: 0;
	background: #f8f9fb;
	border-right: 1px solid #dde1e9;
	padding: 14px 0;
}
#gscfg-wrap .gscfg-sidebar-label {
	font-size: 9px;
	text-transform: uppercase;
	letter-spacing: 1.5px;
	color: #94a3b8;
	padding: 0 14px 8px;
	display: block;
	font-family: monospace;
}
#gscfg-wrap .gscfg-nav a {
	display: flex;
	align-items: center;
	gap: 7px;
	padding: 7px 14px;
	font-size: 12px;
	font-weight: 600;
	color: #64748b;
	text-decoration: none;
	border-left: 3px solid transparent;
	transition: color 0.12s, background 0.12s;
}
#gscfg-wrap .gscfg-nav a:hover {
	color: #1e293b;
	background: #eef2f7;
	text-decoration: none;
}
#gscfg-wrap .gscfg-nav a.gscfg-active {
	color: #3b82f6;
	border-left-color: #3b82f6;
	background: #eff6ff;
}
#gscfg-wrap .gscfg-nav-dot {
	width: 5px;
	height: 5px;
	border-radius: 50%;
	background: currentColor;
	flex-shrink: 0;
}
#gscfg-wrap .gscfg-main {
	flex: 1;
	padding: 18px 22px;
	overflow-x: hidden;
}
.help-nav {
	margin-top:30px;
	padding-top:15px;
	border-top:1px #DDE1E9 solid;
}
.help-nav a {
	font-weight: 400 !important;
	color: #7F8EA3  !important;
}
#gscfg-wrap .gscfg-section {
	margin-bottom: 26px;
}
#gscfg-wrap .gscfg-section-title {
	font-size: 12px;
	font-family: monospace;
	font-weight:600;
	text-transform: uppercase;
	letter-spacing: 2px;
	color: #CF3805;
	margin-bottom: 10px;
	display: flex;
	align-items: center;
	gap: 10px;
}
#gscfg-wrap .gscfg-section-title:after {
	content: '';
	flex: 1;
	height: 1px;
	background: #e2e8f0;
}
#gscfg-wrap .gscfg-card {
	background: #f8f9fb;
	border: 1px solid #e2e8f0;
	border-radius: 8px;
	padding: 12px 14px;
	margin-bottom: 6px;
	display: flex;
	gap: 12px;
	align-items: flex-start;
	transition: border-color 0.12s;
}
#gscfg-wrap .gscfg-card:hover { border-color: #cbd5e1; }
#gscfg-wrap .gscfg-card.gscfg-off { opacity: 0.5; }
#gscfg-wrap .gscfg-card-body { flex: 1; min-width: 0; }
#gscfg-wrap .gscfg-card-top {
	display: flex;
	align-items: center;
	gap: 8px;
	margin-bottom: 3px;
	flex-wrap: wrap;
}
#gscfg-wrap .gscfg-key {
	font-family: monospace;
	font-size: 12px;
	color: #0891b2;
	background: #ecfeff;
	border: 1px solid #a5f3fc;
	padding: 1px 6px;
	border-radius: 3px;
	white-space: nowrap;
}
#gscfg-wrap .gscfg-label {
	font-size: 14px;
	font-weight: 600;
	color: #1e293b;
}
#gscfg-wrap .gscfg-desc {
	font-size: 12px;
	color: #64748b;
	margin-bottom: 7px;
	line-height: 1.5;
	display: flex;
	align-items: center;
	gap: 8px;
	flex-wrap: wrap;
}
#gscfg-wrap .gscfg-desc-link {
	display: inline-flex;
	align-items: center;
	gap: 4px;
	font-size: 11px;
	color: #3b82f6;
	text-decoration: none;
	white-space: nowrap;
	flex-shrink: 0;
}
#gscfg-wrap .gscfg-desc-link:hover {
	color: #2563eb;
	text-decoration: underline;
}
#gscfg-wrap .gscfg-desc-link svg {
	flex-shrink: 0;
	vertical-align: middle;
}
/* Toggle */
#gscfg-wrap .gscfg-tog-col {
	display: flex;
	flex-direction: column;
	align-items: center;
	gap: 3px;
	padding-top: 1px;
	flex-shrink: 0;
}
#gscfg-wrap .gscfg-tog {
	position: relative;
	width: 40px;
	height: 21px;
	display: inline-block;
}
#gscfg-wrap .gscfg-tog input {
	opacity: 0;
	width: 0;
	height: 0;
	position: absolute;
}
#gscfg-wrap .gscfg-tog-track {
	position: absolute;
	top: 0; left: 0; right: 0; bottom: 0;
	background: #cbd5e1;
	border: 1px solid #94a3b8;
	border-radius: 21px;
	cursor: pointer;
	transition: background 0.18s, border-color 0.18s;
}
#gscfg-wrap .gscfg-tog input:checked ~ .gscfg-tog-track {
	background: #3b82f6;
	border-color: #3b82f6;
}
#gscfg-wrap .gscfg-tog-track:after {
	content: '';
	position: absolute;
	top: 3px;
	left: 3px;
	width: 13px;
	height: 13px;
	background: #fff;
	border-radius: 50%;
	transition: transform 0.18s;
	box-shadow: 0 1px 2px rgba(0,0,0,0.15);
}
#gscfg-wrap .gscfg-tog input:checked ~ .gscfg-tog-track:after {
	transform: translateX(19px);
}
#gscfg-wrap .gscfg-tog-lbl {
	font-family: monospace;
	font-size: 9px;
	text-transform: uppercase;
	letter-spacing: 1px;
	color: #94a3b8;
}
/* Inputs */
#gscfg-wrap .gscfg-input-row {
	display: flex;
	align-items: center;
	gap: 8px;
	flex-wrap: wrap;
}
#gscfg-wrap .gscfg-input-lbl {
	font-family: monospace;
	font-size: 10px;
	color: #94a3b8;
	text-transform: uppercase;
	letter-spacing: 1px;
}
#gscfg-wrap input.gscfg-input,
#gscfg-wrap select.gscfg-input {
	background: #fff;
	border: 1px solid #cbd5e1;
	border-radius: 5px;
	color: #0033FF;
	font-family: monospace;
	font-size: 12px;
	padding: 5px 8px;
	outline: none;
	min-width: 200px;
	width: auto;
	transition: border-color 0.12s;
}
#gscfg-wrap input.gscfg-input:focus,
#gscfg-wrap select.gscfg-input:focus {
	border-color: #3b82f6;
	box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
}
#gscfg-wrap textarea.gscfg-ta {
	background: #fff;
	border: 1px solid #cbd5e1;
	border-radius: 5px;
	color: #0033FF;
	font-family: monospace;
	font-size: 11px;
	padding: 6px 8px;
	outline: none;
	width: 100%;
	height: 120px;
	min-height: 80px;
	resize: vertical;
	line-height: 1.6;
	margin-top: 4px;
	display: block;
	transition: border-color 0.12s;
}
#gscfg-wrap textarea.gscfg-ta:focus {
	border-color: #3b82f6;
	box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
}
#gscfg-wrap .gscfg-input-invalid { border-color: #ef4444 !important; }
#gscfg-wrap .gscfg-lang-warn {
	margin-top: 7px;
	padding: 8px 12px;
	background: #fef2f2;
	border-left: 3px solid #ef4444;
	border-radius: 0 4px 4px 0;
	font-size: 11px;
	color: #b91c1c;
	line-height: 1.5;
}
/* Save footer bar */
#gscfg-wrap .gscfg-footer {
	background: #f8f9fb;
	border: 1px solid #dde1e9;
	border-radius: 0 0 8px 8px;
	padding: 14px 20px;
	display: flex;
	align-items: center;
	justify-content: flex-end;
	gap: 12px;
}
#gscfg-wrap .gscfg-save-btn {
	background: linear-gradient(135deg, #3b82f6, #2563eb);
	border: none;
	color: #fff;
	font-size: 13px;
	font-weight: 700;
	padding: 9px 24px;
	border-radius: 6px;
	cursor: pointer;
	letter-spacing: 0.1px;
	transition: opacity 0.15s;
}
#gscfg-wrap .gscfg-save-btn:hover { opacity: 0.88; }
#gscfg-wrap .gscfg-save-note {
	font-size: 11px;
	color: #94a3b8;
}
pre {color: #3B82F6;}
</style>

<div id="gscfg-wrap">
<form method="post" action="">
<input type="hidden" name="gscfg_save" value="1">

<!-- Header bar -->
<div class="gscfg-header">
	<div class="gscfg-logo">
		<div class="gscfg-logo-icon"><svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 24 24"><rect width="24" height="24" fill="none"/><path fill="#CF3805" fill-rule="evenodd" d="M7 3a4 4 0 0 1 3.874 3H19v2h-8.126A4.002 4.002 0 0 1 3 7a4 4 0 0 1 4-4m0 6a2 2 0 1 0 0-4a2 2 0 0 0 0 4m10 11a4 4 0 0 1-3.874-3H5v-2h8.126A4.002 4.002 0 0 1 21 16a4 4 0 0 1-4 4m0-2a2 2 0 1 0 0-4a2 2 0 0 0 0 4" clip-rule="evenodd"/></svg></div>
		<div class="gscfg-logo-title">GS<span>Config</span> GUI</div>
	</div>
	<div class="gscfg-filepath">
		<span class="gscfg-dot" style="background:<?php echo $writable ? '#22c55e' : '#ef4444'; ?>"></span>
		<?php echo htmlspecialchars($path, ENT_QUOTES, 'UTF-8'); ?>
	</div>
	<div class="gscfg-desc"><?php echo i18n_r('gsConfigGUI/lang_Description'); ?>.
	</div>
</div>

<!-- Notices -->
<?php if ($result): ?>
<div class="gscfg-notice <?php echo $result[0]; ?>">
	<?php echo ($result[0] === 'success') ? '&#10003; ' : '&#10007; '; ?>
	<?php echo $result[1]; ?>
</div>
<?php endif; ?>

<?php if (!$exists): ?>
<div class="gscfg-notice error"><?php echo i18n_r('gsConfigGUI/lang_not_found'); ?>: <?php echo htmlspecialchars($path, ENT_QUOTES, 'UTF-8'); ?></div>
<?php elseif (!$writable): ?>
<div class="gscfg-notice warning">&#9888; <?php echo i18n_r('gsConfigGUI/lang_not_writable'); ?>.</div>
<?php endif; ?>

<div class="gscfg-layout">

	<!-- Sidebar -->
	<div class="gscfg-sidebar">
		<span class="gscfg-sidebar-label"><?php echo i18n_r('gsConfigGUI/lang_Sections'); ?></span>
		<div class="gscfg-nav">
		<?php foreach ($grouped as $gname => $keys): ?>
		<?php if (empty($keys)) { continue; } ?>
		<?php $sid = 'gscfg-' . preg_replace('/[^a-z0-9]+/', '-', strtolower($gname)); ?>
		<a href="#<?php echo $sid; ?>">
			<span class="gscfg-nav-dot"></span>
			<?php echo htmlspecialchars($gname, ENT_QUOTES, 'UTF-8'); ?>
		</a>
		<?php endforeach; ?>
		</div>
		
		<div class="gscfg-nav help-nav">
			<span class="gscfg-sidebar-label">More info</span>
			<a href="https://github.com/GetSimpleCMS-CE/GetSimpleCMS-CE/wiki/gsconfig.php" target="_blank">Wiki</a>
			<a href="https://github.com/GetSimpleCMS-CE/GetSimpleCMS-CE/wiki/Debugging" target="_blank"><?php echo i18n_r('gsConfigGUI/lang_Debugging'); ?></a>
			<a href="https://github.com/GetSimpleCMS-CE/GetSimpleCMS-CE/wiki/Salt-Configuration" target="_blank"><?php echo i18n_r('gsConfigGUI/lang_Salt_Config'); ?></a>
		</div>
	</div>

	<!-- Main -->
	<div class="gscfg-main">
	<?php foreach ($grouped as $gname => $keys): ?>
	<?php if (empty($keys)) { continue; } ?>
	<?php $sid = 'gscfg-' . preg_replace('/[^a-z0-9]+/', '-', strtolower($gname)); ?>

	<div class="gscfg-section" id="<?php echo $sid; ?>">
		<div class="gscfg-section-title"><?php echo htmlspecialchars($gname, ENT_QUOTES, 'UTF-8'); ?></div>

		<?php foreach ($keys as $key): ?>
		<?php
			$s        = $settings[$key];
			$type     = $s['type'];
			$enabled  = !empty($s['enabled']);
			$val      = isset($s['value']) ? $s['value'] : '';
			$formKey  = str_replace(array('$', '(', ')'), array('_d_', '', ''), $key);
			$boolOnly = ($type === 'bool');
			$isTA     = ($type === 'textarea');
			$isLang   = ($type === 'lang');
			$isRaw    = ($type === 'rawval'); // like text but written without quotes
			$noToggle = ($key === '$LANG');
			$cardCls  = 'gscfg-card' . ($enabled ? '' : ' gscfg-off');
		?>
		<div class="<?php echo $cardCls; ?>" id="gscfg-card-<?php echo htmlspecialchars($formKey, ENT_QUOTES, 'UTF-8'); ?>">

			<?php if (!$noToggle): ?>
			<div class="gscfg-tog-col">
				<label class="gscfg-tog">
					<input type="checkbox"
						name="en_<?php echo $formKey; ?>"
						value="1"
						<?php echo $enabled ? 'checked="checked"' : ''; ?>
						onchange="gscfgToggle(this,'<?php echo $formKey; ?>')">
					<span class="gscfg-tog-track"></span>
				</label>
				<span class="gscfg-tog-lbl" id="gscfg-lbl-<?php echo $formKey; ?>"><?php echo $enabled ? i18n_r('gsConfigGUI/lang_On') : i18n_r('gsConfigGUI/lang_Off'); ?></span>
			</div>
			<?php endif; ?>

			<div class="gscfg-card-body">
				<div class="gscfg-card-top">
					<span class="gscfg-key"><?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); ?></span>
					<span class="gscfg-label"><?php echo htmlspecialchars($s['label'], ENT_QUOTES, 'UTF-8'); ?></span>
				</div>
				<div class="gscfg-desc">
					<span><?php echo htmlspecialchars($s['desc'], ENT_QUOTES, 'UTF-8'); ?></span>
					<?php if (!empty($s['link'])): ?><?php echo $s['link']; ?><?php endif; ?>
				</div>

				<?php if (!$boolOnly): ?>

				<?php if ($isTA): ?>
					<div class="gscfg-input-lbl">Value</div>
					<textarea
						name="val_<?php echo $formKey; ?>"
						class="gscfg-ta"
						<?php echo (!$enabled && !$noToggle) ? 'disabled="disabled"' : ''; ?>
					><?php echo htmlspecialchars($val, ENT_QUOTES, 'UTF-8'); ?></textarea>

				<?php elseif ($isLang): ?>
					<?php $langInvalid = !in_array($val, $langs); ?>
					<div class="gscfg-input-row">
						<span class="gscfg-input-lbl"><?php echo i18n_r('gsConfigGUI/lang_Language'); ?></span>
						<select name="val_<?php echo $formKey; ?>" class="gscfg-input<?php echo $langInvalid ? ' gscfg-input-invalid' : ''; ?>" onchange="gscfgLangCheck(this)">
						<?php if ($langInvalid): ?>
							<option value="<?php echo htmlspecialchars($val, ENT_QUOTES, 'UTF-8'); ?>" selected="selected" style="color:#b91c1c;background:#fef2f2;">
								&#9888; <?php echo htmlspecialchars($val, ENT_QUOTES, 'UTF-8'); ?> — <?php echo i18n_r('gsConfigGUI/lang_lang_not_found'); ?>
							</option>
						<?php endif; ?>
						<?php foreach ($langs as $l): ?>
							<option value="<?php echo htmlspecialchars($l, ENT_QUOTES, 'UTF-8'); ?>"<?php echo (!$langInvalid && $l === $val) ? ' selected="selected"' : ''; ?>><?php echo htmlspecialchars($l, ENT_QUOTES, 'UTF-8'); ?></option>
						<?php endforeach; ?>
						</select>
					</div>
					<?php if ($langInvalid): ?>
					<div class="gscfg-lang-warn">
						&#9888; <?php echo i18n_r('gsConfigGUI/lang_current_value'); ?> <strong><?php echo htmlspecialchars($val, ENT_QUOTES, 'UTF-8'); ?></strong> <?php echo i18n_r('gsConfigGUI/lang_not_match'); ?>.
					</div>
					<?php endif; ?>

				<?php else: ?>
					<div class="gscfg-input-row">
						<span class="gscfg-input-lbl"><?php echo i18n_r('gsConfigGUI/lang_Value'); ?></span>
						<input
							type="<?php echo ($type === 'number') ? 'number' : (($type === 'email') ? 'email' : 'text'); ?>"
							name="val_<?php echo $formKey; ?>"
							value="<?php echo htmlspecialchars($val, ENT_QUOTES, 'UTF-8'); ?>"
							class="gscfg-input"
							<?php if ($isRaw): ?>placeholder="e.g. en_US or FALSE"<?php endif; ?>
							<?php echo (!$enabled && !$noToggle) ? 'disabled="disabled"' : ''; ?>
						>
					</div>
				<?php endif; ?>

				<?php endif; ?>
			</div>

		</div>
		<?php endforeach; ?>
	</div>
	<?php endforeach; ?>
	</div><!-- .gscfg-main -->

</div><!-- .gscfg-layout -->

<?php if ($writable): ?>
<div class="gscfg-footer">
	<span class="gscfg-save-note"><?php echo i18n_r('gsConfigGUI/lang_backupbefore_saving'); ?>.</span>
	<button type="submit" class="gscfg-save-btn">&#10003; <?php echo i18n_r('gsConfigGUI/lang_Save_Changes'); ?></button>
</div>
<?php endif; ?>
</form>
</div><!-- #gscfg-wrap -->

<script type="text/javascript">
function gscfgEditorOptionsDefault() {
	var ta = document.querySelector('textarea[name="val_GSEDITOROPTIONS"]');
	if (!ta) { return; }
	ta.value = 'extraPlugins:"fontawesome5,youtube,codemirror,cmsgrid,colorbutton,oembed,simplebutton,spacingsliders",\ndisableNativeSpellChecker : false,\nforcePasteAsPlainText : true';
	ta.focus();
}
function gscfgLangCheck(sel) {
	// The invalid option has a value that won't appear in the valid list —
	// once the user picks anything else, remove the warning and red border.
	var warn = sel.parentNode.parentNode.querySelector('.gscfg-lang-warn');
	var firstOpt = sel.options[0];
	// If user moved away from the flagged option, clean up
	if (firstOpt && firstOpt.text.indexOf('\u26a0') !== -1 && sel.selectedIndex !== 0) {
		sel.className = sel.className.replace(' gscfg-input-invalid', '');
		firstOpt.parentNode.removeChild(firstOpt);
		if (warn) { warn.parentNode.removeChild(warn); }
	}
}
function gscfgToggle(cb, key) {
	var card   = document.getElementById('gscfg-card-' + key);
	var lbl    = document.getElementById('gscfg-lbl-' + key);
	var inputs = card.querySelectorAll('input:not([type=checkbox]),select,textarea');
	var i;
	if (cb.checked) {
		card.className = card.className.replace(' gscfg-off', '');
		for (i = 0; i < inputs.length; i++) { inputs[i].disabled = false; }
		if (lbl) { lbl.innerHTML = 'On'; }
	} else {
		if (card.className.indexOf('gscfg-off') === -1) { card.className += ' gscfg-off'; }
		for (i = 0; i < inputs.length; i++) { inputs[i].disabled = true; }
		if (lbl) { lbl.innerHTML = 'Off'; }
	}
}
(function() {
	var secs  = document.querySelectorAll('.gscfg-section');
	var items = document.querySelectorAll('.gscfg-nav a');
	if (!secs.length || !items.length) { return; }
	function onScroll() {
		var active = secs[0].id;
		var i, j;
		for (i = 0; i < secs.length; i++) {
			if (secs[i].getBoundingClientRect().top < 120) { active = secs[i].id; }
		}
		for (j = 0; j < items.length; j++) {
			var href = items[j].getAttribute('href');
			items[j].className = items[j].className.replace(' gscfg-active', '');
			if (href === '#' + active) { items[j].className += ' gscfg-active'; }
		}
	}
	function easeInOut(t) {
		return t < 0.5 ? 2 * t * t : -1 + (4 - 2 * t) * t;
	}
	function smoothScrollTo(targetY, duration) {
		var startY   = window.pageYOffset;
		var distance = targetY - startY;
		var startTime = null;
		function step(timestamp) {
			if (!startTime) { startTime = timestamp; }
			var elapsed  = timestamp - startTime;
			var progress = Math.min(elapsed / duration, 1);
			window.scrollTo(0, startY + distance * easeInOut(progress));
			if (elapsed < duration) { requestAnimationFrame(step); }
		}
		requestAnimationFrame(step);
	}
	for (var k = 0; k < items.length; k++) {
		items[k].addEventListener('click', function(e) {
			var targetId = this.getAttribute('href').replace('#', '');
			var target   = document.getElementById(targetId);
			if (target) {
				e.preventDefault();
				var offsetY = target.getBoundingClientRect().top + window.pageYOffset - 20;
				smoothScrollTo(offsetY, 800); // 800ms — increase to slow down further
			}
		});
	}
	if (window.addEventListener) { window.addEventListener('scroll', onScroll, false); }
	onScroll();
})();
</script>
<?php
}