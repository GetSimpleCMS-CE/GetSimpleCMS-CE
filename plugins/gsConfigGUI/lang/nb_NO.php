<?php

$i18n = [
	
# Basics
	'lang_Menu_Title'			=>	'GS Config GUI',
	
	'lang_Page_Title'			=>	'GS Config GUI',
	'lang_Description'			=>	'Visuell editor for <pre>gsconfig.php</pre> konfigurasjonsinnstillinger',
	
# General
	'lang_Sections'				=>	'Seksjoner',
	'lang_Site_Behavior'		=>	'Nettstedsatferd',
	'lang_Editor'				=>	'Editor',
	'lang_Files_Permissions'	=>	'Filer og tillatelser',
	'lang_Localization'			=>	'Lokalisering',
	'lang_Debugging'			=>	'Feilsøking',
	'lang_Security'				=>	'Sikkerhet',
	'lang_Plugins'				=>	'Plugins',
	
	'lang_More_info'			=>	'Mer info',
	'lang_Salt_Config'			=>	'Salt-konfigurasjon',
	
	'lang_On'					=>	'På',
	'lang_Off'					=>	'Av',
	'lang_Value'				=>	'Verdi',
	
	'lang_Login_Page'			=>	'Innloggingssidespråk',
	'lang_Login_Page_info'		=>	'Standardspråk vist på admin-innloggingssiden',
	'lang_Language'				=>	'Språk',
	
	'lang_Sort_Page'			=>	'Sorter sideliste etter',
	'lang_Sort_Page_info'		=>	'Sorter admin-sideliste etter "title" eller "menu"',
	
	'lang_Admin_Folder'			=>	'Admin-mappenavn',
	'lang_Admin_Folder_info'	=>	'Endre navnet på administratormappen',
	
	'lang_Canonical'			=>	'Kanoniske omdirigeringer',
	'lang_Canonical_info'		=>	'Aktiver kanoniske omdirigeringer',
	
	'lang_Search_Ping'			=>	'Aktiver ping til søkemotorer',
	'lang_Search_Ping_info'		=>	'Ping søkemotorer ved generering av sitemap',
	
	'lang_Disable_Sitemap'		=>	'Deaktiver sitemap',
	'lang_Disable_Sitemap_info'	=>	'Deaktiver generering av sitemap og relaterte menyelementer',
	
	'lang_Auto_Meta'			=>	'Automatiske metabeskrivelser',
	'lang_Auto_Meta_info'		=>	'Aktiver automatiske metabeskrivelser fra innholdsutdrag når tomme',
	
	'lang_External_API'			=>	'Aktiver ekstern API',
	'lang_External_API_info'	=>	'Aktiver det eksterne API-alternativet som vises på innstillingssiden',
	
	'lang_Editor_Toolbar'		=>	'Editor-verktøylinje',
	'lang_Editor_Toolbar_info'	=>	'WYSIWYG-verktøylinjer: "advanced", "basic", "CEbar", "island" eller egendefinert konfigurasjonsnavn',
	
	'lang_Editor_Height'		=>	'Editor-høyde',
	'lang_Editor_Height_info'	=>	'WYSIWYG-editorhøyde i piksler (standard 500)',
	
	'lang_Editor_Language'		=>	'Editor-språk',
	'lang_Editor_Language_info'	=>	'WYSIWYG-editorspråkkode (standard "en")',
	
	'lang_Editor_Options'		=>	'Editor-innstillinger',
	'lang_Editor_Options_info'	=>	'Ekstra WYSIWYG-editorinnstillinger som nøkkel:verdi-par',
	'lang_Restore_defaults'		=>	'Tilbakestill standard',
	
	'lang_CodeMirror'			=>	'CodeMirror-tema',
	'lang_CodeMirror_info'		=>	'Velg CodeMirror-tema: "blackboard" eller "default"',
	
	'lang_Disable_CodeMirror'	=>	'Deaktiver CodeMirror-editor',
	'lang_Disable_CodeMirror_info'	=>	'Deaktiver CodeMirror-temaeditoren',
	
	'lang_Autosave'				=>	'Autolagringsintervall',
	'lang_Autosave_info'		=>	'Autolagringsintervall i sekunder i edit.php (f.eks. 900)',
	
	'lang_Thumbnail_Width'		=>	'Miniatyrbildebredde',
	'lang_Thumbnail_Width_info'	=>	'Standard miniatyrbredde for opplastede bilder i piksler',
	
	'lang_CHMOD_Mode'			=>	'Overstyr CHMOD-modus',
	'lang_CHMOD_Mode_info'		=>	'Angi overstyrt CHMOD-modus som et oktalt heltall, f.eks. 0755',
	
	'lang_Disable_CHMOD'		=>	'Deaktiver CHMOD-operasjoner',
	'lang_Disable_CHMOD_info'	=>	'Deaktiver chmod-operasjoner. Sett til FALSE for å deaktivere',
	
	'lang_Format_XML'			=>	'Formater XML-filer',
	'lang_Format_XML_info'		=>	'Formater XML-filer før lagring for menneskelesbar kildekode',
	
	'lang_Disable_CDN'			=>	'Deaktiver eksternt CDN',
	'lang_Disable_CDN_info'		=>	'Deaktiver lasting av eksterne CDN-versjoner av jQuery og jQueryUI',
	
	'lang_Server_Timezone'		=>	'Server-tidssone',
	'lang_Server_Timezone_info'	=>	'Standard tidssonestreng, f.eks. America/Chicago eller Europe/London',
	'lang_PHP_Timezones'		=>	'PHP-tidssoner',
	
	'lang_PHP_Locale'			=>	'PHP-lokale (setlocale)',
	'lang_PHP_Locale_info'		=>	'Angi PHP-lokale, f.eks. en_US',
	'lang_php_url'				=>	'php.net/setlocale',
	
	'lang_Merge_Language'		=>	'Flett språk',
	'lang_Merge_Language_info'	=>	'Standardspråk for manglende språktoken-fletting, f.eks. en_US. Sett til FALSE for å deaktivere',
	
	'lang_Debug_Mode'			=>	'Feilsøkingsmodus',
	'lang_Debug_Mode_info'		=>	'Slå på feilsøkingsmodus',
	
	'lang_PHP_Errors'			=>	'Undertrykk PHP-feil',
	'lang_PHP_Errors_info'		=>	'Tving undertrykkelse av PHP-feil når GSDEBUG er FALSE, uavhengig av php.ini-innstillinger',
	
	'lang_Password_Hash'		=>	'Passord-hash',
	'lang_Password_Hash_info'	=>	'Ekstra salt for å sikre passordet ditt',
	'lang_Generator'			=>	'Salt/hash-generator',
	
	'lang_Custom_Salt'			=>	'Egendefinert salt',
	'lang_Custom_Salt_info'		=>	'Slå av automatisk generering av SALT og bruk en egendefinert verdi. Brukes for informasjonskapsler og opplastingssikkerhet',
	
	'lang_Disable_CSRF'			=>	'Deaktiver CSRF-beskyttelse',
	'lang_Disable_CSRF_info'	=>	'Aktiver hvis du fortsetter å få meldingen "CSRF error detected"',
	
	'lang_XFrame'				=>	'X-Frame-alternativer',
	'lang_XFrame_info'			=>	'Forhindre at sider lastes i rammer. Verdier: GSFRONT, GSBACK, GSBOTH eller FALSE',
	
	'lang_Apache_Check'			=>	'Deaktiver Apache-sjekk',
	'lang_Apache_Check_info'	=>	'Deaktiver sjekken for Apache-nettserver. Standard er FALSE',
	
	'lang_Email_Address'		=>	'Fra e-postadresse',
	'lang_Email_Address_info'	=>	'Angi avsenderadresse for utgående e-post',
	
	'lang_i18n_Language'		=>	'i18n enkelt språk',
	'lang_i18n_Language_info'	=>	'Skjul I18N-tekst på skjermen Vis alle sider',
	
	'lang_i18n_Ignore'			=>	'i18n ignorer nettleserspråk',
	'lang_i18n_Ignore_info'		=>	'Ignorer brukerens nettleserspråkinnstilling',
	
	'lang_backupbefore_saving'	=>	'En sikkerhetskopi vil bli skrevet til "gsconfig.php.bak" før lagring',
	'lang_Save_Changes'			=>	'Lagre endringer',
	
	'lang_not_found'			=>	'gsconfig.php ble ikke funnet på',
	'lang_not_writable'			=>	'gsconfig.php er ikke skrivbar &mdash; endringer kan ikke lagres. Sjekk filtillatelser (chmod 644 eller 666)',
	
	'lang_current_value'		=>	'Gjeldende verdi',
	'lang_not_match'			=>	'matcher ingen språkfiler i lang-mappen. Vennligst velg et gyldig språk — lagring vil bli blokkert til du gjør det',
	'lang_lang_not_found'		=>	'ikke funnet i lang-mappen',
	
	'lang_Settings_saved'		=>	'Innstillinger lagret. Sikkerhetskopi skrevet til "gsconfig.php.bak"',
	'lang_Failed_to_write'		=>	'Kunne ikke skrive "gsconfig.php". Sjekk filtillatelser.',
	
];