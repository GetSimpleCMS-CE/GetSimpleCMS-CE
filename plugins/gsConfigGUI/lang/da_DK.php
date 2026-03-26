<?php

$i18n = [
	
# Basics
	'lang_Menu_Title'			=>	'GS Config GUI',
	
	'lang_Page_Title'			=>	'GS Config GUI',
	'lang_Description'			=>	'Visuel editor for <pre>gsconfig.php</pre> konfigurationsindstillinger',
	
# General
	'lang_Sections'				=>	'Sektioner',
	'lang_Site_Behavior'		=>	'Webstedsadfærd',
	'lang_Editor'				=>	'Editor',
	'lang_Files_Permissions'	=>	'Filer og rettigheder',
	'lang_Localization'			=>	'Lokalisering',
	'lang_Debugging'			=>	'Fejlfinding',
	'lang_Security'				=>	'Sikkerhed',
	'lang_Plugins'				=>	'Plugins',
	
	'lang_More_info'			=>	'Mere info',
	'lang_Salt_Config'			=>	'Salt-konfiguration',
	
	'lang_On'					=>	'Til',
	'lang_Off'					=>	'Fra',
	'lang_Value'				=>	'Værdi',
	
	'lang_Login_Page'			=>	'Sprog på loginside',
	'lang_Login_Page_info'		=>	'Standardsprog vist på admin-loginsiden',
	'lang_Language'				=>	'Sprog',
	
	'lang_Sort_Page'			=>	'Sorter sideliste efter',
	'lang_Sort_Page_info'		=>	'Sorter admin-sideliste efter "title" eller "menu"',
	
	'lang_Admin_Folder'			=>	'Admin-mappenavn',
	'lang_Admin_Folder_info'	=>	'Skift navnet på administrationspanelets mappe',
	
	'lang_Canonical'			=>	'Kanoniske omdirigeringer',
	'lang_Canonical_info'		=>	'Aktivér kanoniske omdirigeringer',
	
	'lang_Search_Ping'			=>	'Aktivér søgemaskine-ping',
	'lang_Search_Ping_info'		=>	'Ping søgemaskiner ved generering af sitemap',
	
	'lang_Disable_Sitemap'		=>	'Deaktiver sitemap',
	'lang_Disable_Sitemap_info'	=>	'Deaktiver sitemap-generering og relaterede menupunkter',
	
	'lang_Auto_Meta'			=>	'Auto metabeskrivelser',
	'lang_Auto_Meta_info'		=>	'Aktivér automatiske metabeskrivelser fra indholdsuddrag når tomme',
	
	'lang_External_API'			=>	'Aktivér ekstern API',
	'lang_External_API_info'	=>	'Aktivér den eksterne API-mulighed vist på indstillingssiden',
	
	'lang_Editor_Toolbar'		=>	'Editor-værktøjslinje',
	'lang_Editor_Toolbar_info'	=>	'WYSIWYG-værktøjslinjer: "advanced", "basic", "CEbar", "island" eller brugerdefineret konfigurationsnavn',
	
	'lang_Editor_Height'		=>	'Editor-højde',
	'lang_Editor_Height_info'	=>	'WYSIWYG-editorhøjde i pixels (standard 500)',
	
	'lang_Editor_Language'		=>	'Editor-sprog',
	'lang_Editor_Language_info'	=>	'WYSIWYG-editorsprogkode (standard "en")',
	
	'lang_Editor_Options'		=>	'Editor-indstillinger',
	'lang_Editor_Options_info'	=>	'Ekstra WYSIWYG-editorindstillinger som nøgle:værdi-par',
	'lang_Restore_defaults'		=>	'Gendan standardindstillinger',
	
	'lang_CodeMirror'			=>	'CodeMirror-tema',
	'lang_CodeMirror_info'		=>	'Vælg CodeMirror-tema: "blackboard" eller "default"',
	
	'lang_Disable_CodeMirror'	=>	'Deaktiver CodeMirror-editor',
	'lang_Disable_CodeMirror_info'	=>	'Deaktiver CodeMirror-temaeditoren',
	
	'lang_Autosave'				=>	'Autogem-interval',
	'lang_Autosave_info'		=>	'Autogem-interval i sekunder i edit.php (f.eks. 900)',
	
	'lang_Thumbnail_Width'		=>	'Miniaturebilledbredde',
	'lang_Thumbnail_Width_info'	=>	'Standard miniaturebredde for uploadede billeder i pixels',
	
	'lang_CHMOD_Mode'			=>	'Overskriv CHMOD-tilstand',
	'lang_CHMOD_Mode_info'		=>	'Indstil overskrivnings-CHMOD-tilstand som et oktalt heltal, f.eks. 0755',
	
	'lang_Disable_CHMOD'		=>	'Deaktiver CHMOD-operationer',
	'lang_Disable_CHMOD_info'	=>	'Deaktiver chmod-operationer. Sæt til FALSE for at deaktivere',
	
	'lang_Format_XML'			=>	'Formater XML-filer',
	'lang_Format_XML_info'		=>	'Formater XML-filer før gem for menneskelæsbart indhold',
	
	'lang_Disable_CDN'			=>	'Deaktiver eksternt CDN',
	'lang_Disable_CDN_info'		=>	'Deaktiver indlæsning af eksterne CDN-versioner af jQuery og jQueryUI',
	
	'lang_Server_Timezone'		=>	'Server-tidszone',
	'lang_Server_Timezone_info'	=>	'Standard tidszonestreng, f.eks. America/Chicago eller Europe/London',
	'lang_PHP_Timezones'		=>	'PHP-tidszoner',
	
	'lang_PHP_Locale'			=>	'PHP-lokale (setlocale)',
	'lang_PHP_Locale_info'		=>	'Indstil PHP-lokale, f.eks. en_US',
	'lang_php_url'				=>	'php.net/setlocale',
	
	'lang_Merge_Language'		=>	'Flet sprog',
	'lang_Merge_Language_info'	=>	'Standardsprog til manglende sprogtoken-fletning, f.eks. en_US. Sæt til FALSE for at deaktivere',
	
	'lang_Debug_Mode'			=>	'Fejlfindingstilstand',
	'lang_Debug_Mode_info'		=>	'Aktivér fejlfindingstilstand',
	
	'lang_PHP_Errors'			=>	'Undertryk PHP-fejl',
	'lang_PHP_Errors_info'		=>	'Tving undertrykkelse af PHP-fejl når GSDEBUG er FALSE, uanset php.ini-indstillinger',
	
	'lang_Password_Hash'		=>	'Adgangskode-hash',
	'lang_Password_Hash_info'	=>	'Ekstra salt til at sikre din adgangskode',
	'lang_Generator'			=>	'Salt/hash-generator',
	
	'lang_Custom_Salt'			=>	'Tilpasset salt',
	'lang_Custom_Salt_info'		=>	'Slå automatisk generering af SALT fra og brug en brugerdefineret værdi. Bruges til cookies og upload-sikkerhed',
	
	'lang_Disable_CSRF'			=>	'Deaktiver CSRF-beskyttelse',
	'lang_Disable_CSRF_info'	=>	'Aktivér hvis du fortsat modtager beskeden "CSRF error detected"',
	
	'lang_XFrame'				=>	'X-Frame-indstillinger',
	'lang_XFrame_info'			=>	'Forhindr sider i at blive indlæst i rammer. Værdier: GSFRONT, GSBACK, GSBOTH eller FALSE',
	
	'lang_Apache_Check'			=>	'Deaktiver Apache-kontrol',
	'lang_Apache_Check_info'	=>	'Deaktiver kontrollen for Apache-webserver. Standard er FALSE',
	
	'lang_Email_Address'		=>	'Fra e-mail-adresse',
	'lang_Email_Address_info'	=>	'Indstil afsenderadresse for udgående e-mail',
	
	'lang_i18n_Language'		=>	'i18n enkelt sprog',
	'lang_i18n_Language_info'	=>	'Skjul I18N-tekst på skærmen Vis alle sider',
	
	'lang_i18n_Ignore'			=>	'i18n ignorer browsersprog',
	'lang_i18n_Ignore_info'		=>	'Ignorer brugerens browsersprogindstilling',
	
	'lang_backupbefore_saving'	=>	'Der oprettes en sikkerhedskopi til "gsconfig.php.bak" før gem',
	'lang_Save_Changes'			=>	'Gem ændringer',
	
	'lang_not_found'			=>	'gsconfig.php blev ikke fundet på',
	'lang_not_writable'			=>	'gsconfig.php er ikke skrivbar &mdash; ændringer kan ikke gemmes. Tjek filrettigheder (chmod 644 eller 666)',
	
	'lang_current_value'		=>	'Den nuværende værdi',
	'lang_not_match'			=>	'matcher ingen sprogfiler i lang-mappen. Vælg et gyldigt sprog — gemning blokeres indtil du gør det',
	'lang_lang_not_found'		=>	'ikke fundet i lang-mappen',
	
	'lang_Settings_saved'		=>	'Indstillinger gemt. Sikkerhedskopi skrevet til "gsconfig.php.bak"',
	'lang_Failed_to_write'		=>	'Kunne ikke skrive "gsconfig.php". Tjek filrettigheder.',
	
];