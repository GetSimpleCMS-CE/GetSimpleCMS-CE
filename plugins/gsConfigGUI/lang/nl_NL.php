<?php

$i18n = [
	
# Basics
	'lang_Menu_Title'			=>	'GS Config GUI',
	
	'lang_Page_Title'			=>	'GS Config GUI',
	'lang_Description'			=>	'Visuele editor voor <pre>gsconfig.php</pre> configuratie-instellingen',
	
# General
	'lang_Sections'				=>	'Secties',
	'lang_Site_Behavior'		=>	'Websitegedrag',
	'lang_Editor'				=>	'Editor',
	'lang_Files_Permissions'	=>	'Bestanden en machtigingen',
	'lang_Localization'			=>	'Lokalisatie',
	'lang_Debugging'			=>	'Debuggen',
	'lang_Security'				=>	'Beveiliging',
	'lang_Plugins'				=>	'Plugins',
	
	'lang_More_info'			=>	'Meer info',
	'lang_Salt_Config'			=>	'Zoutconfiguratie',
	
	'lang_On'					=>	'Aan',
	'lang_Off'					=>	'Uit',
	'lang_Value'				=>	'Waarde',
	
	'lang_Login_Page'			=>	'Taal inlogpagina',
	'lang_Login_Page_info'		=>	'Standaardtaal getoond op de admin-inlogpagina',
	'lang_Language'				=>	'Taal',
	
	'lang_Sort_Page'			=>	'Sorteer paginalijst op',
	'lang_Sort_Page_info'		=>	'Sorteer admin-paginalijst op "titel" of "menu"',
	
	'lang_Admin_Folder'			=>	'Admin-mapnaam',
	'lang_Admin_Folder_info'	=>	'Wijzig de naam van de administratieve panelmap',
	
	'lang_Canonical'			=>	'Canonieke doorverwijzingen',
	'lang_Canonical_info'		=>	'Canonieke doorverwijzingen inschakelen',
	
	'lang_Search_Ping'			=>	'Zoekmachine-ping inschakelen',
	'lang_Search_Ping_info'		=>	'Ping zoekmachines bij het genereren van de sitemap',
	
	'lang_Disable_Sitemap'		=>	'Sitemap uitschakelen',
	'lang_Disable_Sitemap_info'	=>	'Sitemap-generatie en gerelateerde menu-items uitschakelen',
	
	'lang_Auto_Meta'			=>	'Automatische metabeschrijvingen',
	'lang_Auto_Meta_info'		=>	'Automatische metabeschrijvingen uit inhoudsfragmenten inschakelen wanneer leeg',
	
	'lang_External_API'			=>	'Externe API inschakelen',
	'lang_External_API_info'	=>	'De externe API-optie op de instellingenpagina inschakelen',
	
	'lang_Editor_Toolbar'		=>	'Editor-werkbalk',
	'lang_Editor_Toolbar_info'	=>	'WYSIWYG-werkbalken: "advanced", "basic", "CEbar", "island" of aangepaste configuratienaam',
	
	'lang_Editor_Height'		=>	'Editor-hoogte',
	'lang_Editor_Height_info'	=>	'WYSIWYG-editorhoogte in pixels (standaard 500)',
	
	'lang_Editor_Language'		=>	'Editor-taal',
	'lang_Editor_Language_info'	=>	'WYSIWYG-editor-taalcode (standaard "en")',
	
	'lang_Editor_Options'		=>	'Editor-opties',
	'lang_Editor_Options_info'	=>	'Extra WYSIWYG-editoropties als sleutel:waarde-paren',
	'lang_Restore_defaults'		=>	'Standaardwaarden herstellen',
	
	'lang_CodeMirror'			=>	'CodeMirror-thema',
	'lang_CodeMirror_info'		=>	'CodeMirror-thema instellen: "blackboard" of "default"',
	
	'lang_Disable_CodeMirror'	=>	'CodeMirror-editor uitschakelen',
	'lang_Disable_CodeMirror_info'	=>	'De CodeMirror-thema-editor uitschakelen',
	
	'lang_Autosave'				=>	'Automatisch opslaginterval',
	'lang_Autosave_info'		=>	'Automatisch opslaginterval in seconden in edit.php (bijv. 900)',
	
	'lang_Thumbnail_Width'		=>	'Afbeeldingsminiatuurbreedte',
	'lang_Thumbnail_Width_info'	=>	'Standaard miniatuurbreedte van geüploade afbeeldingen in pixels',
	
	'lang_CHMOD_Mode'			=>	'CHMOD-modus overschrijven',
	'lang_CHMOD_Mode_info'		=>	'Stel de CHMOD-modus in als een octaal getal, bijv. 0755',
	
	'lang_Disable_CHMOD'		=>	'CHMOD-bewerkingen uitschakelen',
	'lang_Disable_CHMOD_info'	=>	'Schakel chmod-bewerkingen uit. Zet op FALSE om uit te schakelen',
	
	'lang_Format_XML'			=>	'XML-bestanden opmaken',
	'lang_Format_XML_info'		=>	'XML-bestanden opmaken voordat ze worden opgeslagen voor menselijke leesbaarheid',
	
	'lang_Disable_CDN'			=>	'Externe CDN uitschakelen',
	'lang_Disable_CDN_info'		=>	'Het laden van externe CDN-versies van jQuery en jQueryUI uitschakelen',
	
	'lang_Server_Timezone'		=>	'Servertijdzone',
	'lang_Server_Timezone_info'	=>	'Standaard tijdzonetekenreeks, bijv. America/Chicago of Europe/London',
	'lang_PHP_Timezones'		=>	'PHP-tijdzones',
	
	'lang_PHP_Locale'			=>	'PHP-locale (setlocale)',
	'lang_PHP_Locale_info'		=>	'PHP-locale instellen, bijv. en_US',
	'lang_php_url'				=>	'php.net/setlocale',
	
	'lang_Merge_Language'		=>	'Talen samenvoegen',
	'lang_Merge_Language_info'	=>	'Standaardtaal voor het samenvoegen van ontbrekende taaltokens, bijv. en_US. Zet op FALSE om uit te schakelen',
	
	'lang_Debug_Mode'			=>	'Debugmodus',
	'lang_Debug_Mode_info'		=>	'Debugmodus inschakelen',
	
	'lang_PHP_Errors'			=>	'PHP-fouten onderdrukken',
	'lang_PHP_Errors_info'		=>	'Dwingt onderdrukking van PHP-fouten af wanneer GSDEBUG FALSE is, ongeacht php.ini-instellingen',
	
	'lang_Password_Hash'		=>	'Wachtwoordhash',
	'lang_Password_Hash_info'	=>	'Extra zout om uw wachtwoord te beveiligen',
	'lang_Generator'			=>	'Zout/hash-generator',
	
	'lang_Custom_Salt'			=>	'Aangepast zout',
	'lang_Custom_Salt_info'		=>	'Zet automatische generatie van SALT uit en gebruik een aangepaste waarde. Gebruikt voor cookies en uploadbeveiliging',
	
	'lang_Disable_CSRF'			=>	'CSRF-bescherming uitschakelen',
	'lang_Disable_CSRF_info'	=>	'Inschakelen als u steeds het bericht "CSRF error detected" ontvangt',
	
	'lang_XFrame'				=>	'X-Frame-opties',
	'lang_XFrame_info'			=>	'Voorkom dat pagina’s in frames worden geladen. Waarden: GSFRONT, GSBACK, GSBOTH of FALSE',
	
	'lang_Apache_Check'			=>	'Apache-controle uitschakelen',
	'lang_Apache_Check_info'	=>	'De controle op Apache-webserver uitschakelen. Standaard is FALSE',
	
	'lang_Email_Address'		=>	'Van e-mailadres',
	'lang_Email_Address_info'	=>	'Stel het afzenderadres in voor uitgaande e-mail',
	
	'lang_i18n_Language'		=>	'i18n enkele taal',
	'lang_i18n_Language_info'	=>	'I18N-tekst verbergen op het scherm Alle pagina’s bekijken',
	
	'lang_i18n_Ignore'			=>	'i18n negeer browsertaal',
	'lang_i18n_Ignore_info'		=>	'Negeer de browsertaalinstelling van de gebruiker',
	
	'lang_backupbefore_saving'	=>	'Er wordt een back-up geschreven naar "gsconfig.php.bak" voordat wordt opgeslagen',
	'lang_Save_Changes'			=>	'Wijzigingen opslaan',
	
	'lang_not_found'			=>	'gsconfig.php niet gevonden op',
	'lang_not_writable'			=>	'gsconfig.php is niet beschrijfbaar &mdash; wijzigingen kunnen niet worden opgeslagen. Controleer bestandsrechten (chmod 644 of 666)',
	
	'lang_current_value'		=>	'De huidige waarde',
	'lang_not_match'			=>	'komt niet overeen met een taalbestand in de lang-map. Selecteer een geldige taal — opslaan wordt geblokkeerd totdat u dat doet',
	'lang_lang_not_found'		=>	'niet gevonden in lang-map',
	
	'lang_Settings_saved'		=>	'Instellingen opgeslagen. Back-up geschreven naar "gsconfig.php.bak"',
	'lang_Failed_to_write'		=>	'Kan "gsconfig.php" niet schrijven. Controleer bestandsrechten.',
	
];