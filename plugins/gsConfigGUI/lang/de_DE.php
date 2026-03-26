<?php

$i18n = [
	
# Basics
	'lang_Menu_Title'			=>	'GS Config GUI',
	
	'lang_Page_Title'			=>	'GS Config GUI',
	'lang_Description'			=>	'Visueller Editor für die Konfiguration von <pre>gsconfig.php</pre>',
	
# General
	'lang_Sections'				=>	'Abschnitte',
	'lang_Site_Behavior'		=>	'Seitenverhalten',
	'lang_Editor'				=>	'Editor',
	'lang_Files_Permissions'	=>	'Dateien & Berechtigungen',
	'lang_Localization'			=>	'Lokalisierung',
	'lang_Debugging'			=>	'Debugging',
	'lang_Security'				=>	'Sicherheit',
	'lang_Plugins'				=>	'Plugins',
	
	'lang_More_info'			=>	'Weitere Informationen',
	'lang_Salt_Config'			=>	'Salt-Konfiguration',
	
	'lang_On'					=>	'Ein',
	'lang_Off'					=>	'Aus',
	'lang_Value'				=>	'Wert',
	
	'lang_Login_Page'			=>	'Sprache der Login-Seite',
	'lang_Login_Page_info'		=>	'Standardsprache der Admin-Login-Seite',
	'lang_Language'				=>	'Sprache',
	
	'lang_Sort_Page'			=>	'Seitenliste sortieren nach',
	'lang_Sort_Page_info'		=>	'Admin-Seitenliste nach "Titel" oder "Menü" sortieren',
	
	'lang_Admin_Folder'			=>	'Name des Admin-Ordners',
	'lang_Admin_Folder_info'	=>	'Namen des Admin-Ordners ändern',
	
	'lang_Canonical'			=>	'Kanonische Weiterleitungen',
	'lang_Canonical_info'		=>	'Kanonische Weiterleitungen aktivieren',
	
	'lang_Search_Ping'			=>	'Suchmaschinen-Ping aktivieren',
	'lang_Search_Ping_info'		=>	'Suchmaschinen bei Sitemap-Erstellung benachrichtigen',
	
	'lang_Disable_Sitemap'		=>	'Sitemap deaktivieren',
	'lang_Disable_Sitemap_info'	=>	'Generierung der Sitemap und Menüeinträge deaktivieren',
	
	'lang_Auto_Meta'			=>	'Automatische Meta-Beschreibungen',
	'lang_Auto_Meta_info'		=>	'Meta-Beschreibungen automatisch aus Inhalten generieren',
	
	'lang_External_API'			=>	'Externe API aktivieren',
	'lang_External_API_info'	=>	'Externe API in den Einstellungen aktivieren',
	
	'lang_Editor_Toolbar'		=>	'Editor-Werkzeugleiste',
	'lang_Editor_Toolbar_info'	=>	'WYSIWYG-Leisten: "advanced", "basic", "CEbar", "island" oder benutzerdefiniert',
	
	'lang_Editor_Height'		=>	'Editorhöhe',
	'lang_Editor_Height_info'	=>	'Höhe des Editors in Pixeln (Standard 500)',
	
	'lang_Editor_Language'		=>	'Editor-Sprache',
	'lang_Editor_Language_info'	=>	'Sprachcode des Editors (Standard "en")',
	
	'lang_Editor_Options'		=>	'Editor-Optionen',
	'lang_Editor_Options_info'	=>	'Zusätzliche Optionen als Schlüssel:Wert-Paare',
	'lang_Restore_defaults'		=>	'Standardwerte wiederherstellen',
	
	'lang_CodeMirror'			=>	'CodeMirror-Theme',
	'lang_CodeMirror_info'		=>	'Theme festlegen: "blackboard" oder "default"',
	
	'lang_Disable_CodeMirror'	=>	'CodeMirror deaktivieren',
	'lang_Disable_CodeMirror_info'	=>	'CodeMirror-Editor deaktivieren',
	
	'lang_Autosave'				=>	'Autospeicher-Intervall',
	'lang_Autosave_info'		=>	'Intervall in Sekunden (z. B. 900)',
	
	'lang_Thumbnail_Width'		=>	'Miniaturbild-Breite',
	'lang_Thumbnail_Width_info'	=>	'Standardbreite in Pixeln',
	
	'lang_CHMOD_Mode'			=>	'CHMOD-Modus überschreiben',
	'lang_CHMOD_Mode_info'		=>	'CHMOD-Wert als Oktalzahl setzen (z. B. 0755)',
	
	'lang_Disable_CHMOD'		=>	'CHMOD deaktivieren',
	'lang_Disable_CHMOD_info'	=>	'CHMOD deaktivieren (FALSE zum Deaktivieren)',
	
	'lang_Format_XML'			=>	'XML-Dateien formatieren',
	'lang_Format_XML_info'		=>	'XML vor dem Speichern formatieren',
	
	'lang_Disable_CDN'			=>	'Externes CDN deaktivieren',
	'lang_Disable_CDN_info'		=>	'Externe jQuery/CDN-Dateien deaktivieren',
	
	'lang_Server_Timezone'		=>	'Server-Zeitzone',
	'lang_Server_Timezone_info'	=>	'Standard-Zeitzone (z. B. Europe/Berlin)',
	'lang_PHP_Timezones'		=>	'PHP-Zeitzonen',
	
	'lang_PHP_Locale'			=>	'PHP-Locale',
	'lang_PHP_Locale_info'		=>	'Locale setzen (z. B. de_DE)',
	'lang_php_url'				=>	'php.net/setlocale',
	
	'lang_Merge_Language'		=>	'Sprache zusammenführen',
	'lang_Merge_Language_info'	=>	'Fallback-Sprache für fehlende Übersetzungen',
	
	'lang_Debug_Mode'			=>	'Debug-Modus',
	'lang_Debug_Mode_info'		=>	'Debug-Modus aktivieren',
	
	'lang_PHP_Errors'			=>	'PHP-Fehler unterdrücken',
	'lang_PHP_Errors_info'		=>	'Fehler unterdrücken, auch wenn php.ini etwas anderes vorgibt',
	
	'lang_Password_Hash'		=>	'Passwort-Hash',
	'lang_Password_Hash_info'	=>	'Zusätzlicher Salt zur Sicherheit',
	'lang_Generator'			=>	'Hash-Generator',
	
	'lang_Custom_Salt'			=>	'Benutzerdefinierter Salt',
	'lang_Custom_Salt_info'		=>	'Automatischen Salt deaktivieren',
	
	'lang_Disable_CSRF'			=>	'CSRF-Schutz deaktivieren',
	'lang_Disable_CSRF_info'	=>	'Nur aktivieren, wenn Fehler auftreten',
	
	'lang_XFrame'				=>	'X-Frame-Options',
	'lang_XFrame_info'			=>	'Verhindert das Laden in Frames',
	
	'lang_Apache_Check'			=>	'Apache-Prüfung deaktivieren',
	'lang_Apache_Check_info'	=>	'Überprüfung deaktivieren',
	
	'lang_Email_Address'		=>	'Absenderadresse',
	'lang_Email_Address_info'	=>	'E-Mail-Absender festlegen',
	
	'lang_i18n_Language'		=>	'i18n Einzelsprache',
	'lang_i18n_Language_info'	=>	'I18N Texte ausblenden',
	
	'lang_i18n_Ignore'			=>	'Browser-Sprache ignorieren',
	'lang_i18n_Ignore_info'		=>	'Browser-Sprache nicht verwenden',
	
	'lang_backupbefore_saving'	=>	'Vor dem Speichern wird eine Sicherung erstellt',
	'lang_Save_Changes'			=>	'Änderungen speichern',
	
	'lang_not_found'			=>	'gsconfig.php wurde nicht gefunden unter',
	'lang_not_writable'			=>	'gsconfig.php ist nicht beschreibbar',
	
	'lang_current_value'		=>	'Aktueller Wert',
	'lang_not_match'			=>	'stimmt mit keiner Sprachdatei überein',
	'lang_lang_not_found'		=>	'nicht im Sprachordner gefunden',
	
	'lang_Settings_saved'		=>	'Einstellungen gespeichert',
	'lang_Failed_to_write'		=>	'Datei konnte nicht geschrieben werden',
	
];