<?php

$i18n = [
	
# Basics
	'lang_Menu_Title'			=>	'GS Config GUI',
	
	'lang_Page_Title'			=>	'GS Config GUI',
	'lang_Description'			=>	'Visual editor for <pre>gsconfig.php</pre> configuration settings',
	
# General
	'lang_Sections'				=>	'Sections',
	'lang_Site_Behavior'		=>	'Site Behavior',
	'lang_Editor'				=>	'Editor',
	'lang_Files_Permissions'	=>	'Files & Permissions',
	'lang_Localization'			=>	'Localization',
	'lang_Debugging'			=>	'Debugging',
	'lang_Security'				=>	'Security',
	'lang_Plugins'				=>	'Plugins',
	
	'lang_More_info'			=>	'More info',
	'lang_Salt_Config'			=>	'Salt Configuration',
	
	'lang_On'					=>	'On',
	'lang_Off'					=>	'Off',
	'lang_Value'				=>	'Value',
	
	'lang_Login_Page'			=>	'Login Page Language',
	'lang_Login_Page_info'		=>	'Default language shown on the admin login page',
	'lang_Language'				=>	'Language',
	
	'lang_Sort_Page'			=>	'Sort Page List By',
	'lang_Sort_Page_info'		=>	'Sort admin page list by "title" or "menu"',
	
	'lang_Admin_Folder'			=>	'Admin Folder Name',
	'lang_Admin_Folder_info'	=>	'Change the administrative panel folder name',
	
	'lang_Canonical'			=>	'Canonical Redirects',
	'lang_Canonical_info'		=>	'Enable canonical redirects',
	
	'lang_Search_Ping'			=>	'Enable Search Engine Ping',
	'lang_Search_Ping_info'		=>	'Ping search engines upon sitemap generation',
	
	'lang_Disable_Sitemap'		=>	'Disable Sitemap',
	'lang_Disable_Sitemap_info'	=>	'Disable sitemap generation and related menu items',
	
	'lang_Auto_Meta'			=>	'Auto Meta Descriptions',
	'lang_Auto_Meta_info'		=>	'Enable auto meta descriptions from content excerpts when empty',
	
	'lang_External_API'			=>	'Enable External API',
	'lang_External_API_info'	=>	'Enable the External API option shown on the settings page',
	
	'lang_Editor_Toolbar'		=>	'Editor Toolbar',
	'lang_Editor_Toolbar_info'	=>	'WYSIWYG toolbars: "advanced", "basic", "CEbar", "island", or custom config name',
	
	'lang_Editor_Height'		=>	'Editor Height',
	'lang_Editor_Height_info'	=>	'WYSIWYG editor height in pixels (default 500)',
	
	'lang_Editor_Language'		=>	'Editor Language',
	'lang_Editor_Language_info'	=>	'WYSIWYG editor language code (default "en")',
	
	'lang_Editor_Options'		=>	'Editor Options',
	'lang_Editor_Options_info'	=>	'Additional WYSIWYG editor options as key:value pairs',
	'lang_Restore_defaults'		=>	'Restore defaults',
	
	'lang_CodeMirror'			=>	'CodeMirror Theme',
	'lang_CodeMirror_info'		=>	'Set CodeMirror theme: "blackboard" or "default"',
	
	'lang_Disable_CodeMirror'	=>	'Disable CodeMirror Editor',
	'lang_Disable_CodeMirror_info'	=>	'Disable the CodeMirror theme editor',
	
	'lang_Autosave'				=>	'Autosave Interval',
	'lang_Autosave_info'		=>	'Autosave interval in seconds within edit.php (e.g. 900)',
	
	'lang_Thumbnail_Width'		=>	'Image Thumbnail Width',
	'lang_Thumbnail_Width_info'	=>	'Default thumbnail width of uploaded images in pixels',
	
	'lang_CHMOD_Mode'			=>	'Override CHMOD Mode',
	'lang_CHMOD_Mode_info'		=>	'Set override CHMOD mode as an octal integer, e.g. 0755',
	
	'lang_Disable_CHMOD'		=>	'Disable CHMOD Operations',
	'lang_Disable_CHMOD_info'	=>	'Disable chmod operations. Set to FALSE to disable',
	
	'lang_Format_XML'			=>	'Format XML Files',
	'lang_Format_XML_info'		=>	'Format XML files before saving them for human-readable source',
	
	'lang_Disable_CDN'			=>	'Disable External CDN',
	'lang_Disable_CDN_info'		=>	'Disable loading of external CDN versions of jQuery and jQueryUI',
	
	'lang_Server_Timezone'		=>	'Server Timezone',
	'lang_Server_Timezone_info'	=>	'Default timezone string, e.g. America/Chicago or Europe/London',
	'lang_PHP_Timezones'		=>	'PHP Timezones',
	
	'lang_PHP_Locale'			=>	'PHP Locale (setlocale)',
	'lang_PHP_Locale_info'		=>	'Set PHP locale, e.g. en_US',
	'lang_php_url'				=>	'php.net/setlocale',
	
	'lang_Merge_Language'		=>	'Merge Language',
	'lang_Merge_Language_info'	=>	'Default language for missing lang token merge, e.g. en_US. Set to FALSE to disable',
	
	'lang_Debug_Mode'			=>	'Debug Mode',
	'lang_Debug_Mode_info'		=>	'Turn on debug mode',
	
	'lang_PHP_Errors'			=>	'Suppress PHP Errors',
	'lang_PHP_Errors_info'		=>	'Forces suppression of PHP errors when GSDEBUG is FALSE, despite php.ini settings',
	
	'lang_Password_Hash'		=>	'Password Hash',
	'lang_Password_Hash_info'	=>	'Extra salt to secure your password with',
	'lang_Generator'			=>	'Salt/Hash Generator',
	
	'lang_Custom_Salt'			=>	'Custom Salt',
	'lang_Custom_Salt_info'		=>	'Turn off auto-generation of SALT and use a custom value. Used for cookies and upload security',
	
	'lang_Disable_CSRF'			=>	'Disable CSRF Protection',
	'lang_Disable_CSRF_info'	=>	'Enable if you keep receiving the "CSRF error detected" message',
	
	'lang_XFrame'				=>	'X-Frame-Options',
	'lang_XFrame_info'			=>	'Prevent pages from loading in frames. Values: GSFRONT, GSBACK, GSBOTH, or FALSE',
	
	'lang_Apache_Check'			=>	'Disable Apache Check',
	'lang_Apache_Check_info'	=>	'Disable the check for Apache web server. Default is FALSE',
	
	'lang_Email_Address'		=>	'From Email Address',
	'lang_Email_Address_info'	=>	'Set the from address for outgoing email',
	
	'lang_i18n_Language'		=>	'i18n Single Language',
	'lang_i18n_Language_info'	=>	'Hide I18N text on the View All Pages screen',
	
	'lang_i18n_Ignore'			=>	'i18n Ignore Browser Lang',
	'lang_i18n_Ignore_info'		=>	'Ignore the user browser language setting',
	
	'lang_backupbefore_saving'	=>	'A backup will be written to "gsconfig.php.bak" before saving',
	'lang_Save_Changes'			=>	'Save Changes',
	
	'lang_not_found'			=>	'gsconfig.php was not found at',
	'lang_not_writable'			=>	'gsconfig.php is not writable &mdash; changes cannot be saved. Check file permissions (chmod 644 or 666)',
	
	'lang_current_value'		=>	'The current value',
	'lang_not_match'			=>	'does not match any language file in the lang folder. Please select a valid language — saving will be blocked until you do',
	'lang_lang_not_found'		=>	'not found in lang folder',
	
	'lang_Settings_saved'		=>	'Settings saved. Backup written to "gsconfig.php.bak"',
	'lang_Failed_to_write'		=>	'Failed to write "gsconfig.php". Check file permissions.',
	
];