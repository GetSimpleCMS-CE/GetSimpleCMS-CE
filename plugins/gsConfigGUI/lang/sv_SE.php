<?php

$i18n = [
	
# Basics
	'lang_Menu_Title'			=>	'GS Config GUI',
	
	'lang_Page_Title'			=>	'GS Config GUI',
	'lang_Description'			=>	'Visuell redigerare för <pre>gsconfig.php</pre> konfigurationsinställningar',
	
# General
	'lang_Sections'				=>	'Sektioner',
	'lang_Site_Behavior'		=>	'Webbplatsbeteende',
	'lang_Editor'				=>	'Redigerare',
	'lang_Files_Permissions'	=>	'Filer och behörigheter',
	'lang_Localization'			=>	'Lokalisering',
	'lang_Debugging'			=>	'Felsökning',
	'lang_Security'				=>	'Säkerhet',
	'lang_Plugins'				=>	'Insticksprogram',
	
	'lang_More_info'			=>	'Mer information',
	'lang_Salt_Config'			=>	'Salt-konfiguration',
	
	'lang_On'					=>	'På',
	'lang_Off'					=>	'Av',
	'lang_Value'				=>	'Värde',
	
	'lang_Login_Page'			=>	'Språk för inloggningssida',
	'lang_Login_Page_info'		=>	'Standardspråk som visas på admin-inloggningssidan',
	'lang_Language'				=>	'Språk',
	
	'lang_Sort_Page'			=>	'Sortera sidlista efter',
	'lang_Sort_Page_info'		=>	'Sortera admin-sidlista efter "titel" eller "meny"',
	
	'lang_Admin_Folder'			=>	'Admin-mappnamn',
	'lang_Admin_Folder_info'	=>	'Ändra namnet på administratörspanelens mapp',
	
	'lang_Canonical'			=>	'Kanoniska omdirigeringar',
	'lang_Canonical_info'		=>	'Aktivera kanoniska omdirigeringar',
	
	'lang_Search_Ping'			=>	'Aktivera sökmotor-ping',
	'lang_Search_Ping_info'		=>	'Pinga sökmotorer vid generering av webbplatskarta',
	
	'lang_Disable_Sitemap'		=>	'Inaktivera webbplatskarta',
	'lang_Disable_Sitemap_info'	=>	'Inaktivera generering av webbplatskarta och relaterade menyobjekt',
	
	'lang_Auto_Meta'			=>	'Automatiska metabeskrivningar',
	'lang_Auto_Meta_info'		=>	'Aktivera automatiska metabeskrivningar från innehållsutdrag när de är tomma',
	
	'lang_External_API'			=>	'Aktivera externt API',
	'lang_External_API_info'	=>	'Aktivera det externa API-alternativet som visas på inställningssidan',
	
	'lang_Editor_Toolbar'		=>	'Redigeringsverktygsfält',
	'lang_Editor_Toolbar_info'	=>	'WYSIWYG-verktygsfält: "advanced", "basic", "CEbar", "island" eller anpassat konfigurationsnamn',
	
	'lang_Editor_Height'		=>	'Redigerarhöjd',
	'lang_Editor_Height_info'	=>	'WYSIWYG-redigerarens höjd i pixlar (standard 500)',
	
	'lang_Editor_Language'		=>	'Redigerarspråk',
	'lang_Editor_Language_info'	=>	'WYSIWYG-redigerarens språkkod (standard "en")',
	
	'lang_Editor_Options'		=>	'Redigeringsalternativ',
	'lang_Editor_Options_info'	=>	'Ytterligare WYSIWYG-redigeringsalternativ som nyckel:värde-par',
	'lang_Restore_defaults'		=>	'Återställ standardvärden',
	
	'lang_CodeMirror'			=>	'CodeMirror-tema',
	'lang_CodeMirror_info'		=>	'Ange CodeMirror-tema: "blackboard" eller "default"',
	
	'lang_Disable_CodeMirror'	=>	'Inaktivera CodeMirror-redigerare',
	'lang_Disable_CodeMirror_info'	=>	'Inaktivera CodeMirror-temaredigeraren',
	
	'lang_Autosave'				=>	'Autosparingsintervall',
	'lang_Autosave_info'		=>	'Autosparingsintervall i sekunder i edit.php (t.ex. 900)',
	
	'lang_Thumbnail_Width'		=>	'Miniatyyrbredd',
	'lang_Thumbnail_Width_info'	=>	'Standard miniatyrbredd för uppladdade bilder i pixlar',
	
	'lang_CHMOD_Mode'			=>	'Åsidosätt CHMOD-läge',
	'lang_CHMOD_Mode_info'		=>	'Ange åsidosatt CHMOD-läge som ett oktalt heltal, t.ex. 0755',
	
	'lang_Disable_CHMOD'		=>	'Inaktivera CHMOD-operationer',
	'lang_Disable_CHMOD_info'	=>	'Inaktivera chmod-operationer. Sätt till FALSE för att inaktivera',
	
	'lang_Format_XML'			=>	'Formatera XML-filer',
	'lang_Format_XML_info'		=>	'Formatera XML-filer innan de sparas för mänsklig läsbarhet',
	
	'lang_Disable_CDN'			=>	'Inaktivera externt CDN',
	'lang_Disable_CDN_info'		=>	'Inaktivera inläsning av externa CDN-versioner av jQuery och jQueryUI',
	
	'lang_Server_Timezone'		=>	'Server-tidszon',
	'lang_Server_Timezone_info'	=>	'Standard tidszonssträng, t.ex. America/Chicago eller Europe/London',
	'lang_PHP_Timezones'		=>	'PHP-tidszoner',
	
	'lang_PHP_Locale'			=>	'PHP-lokale (setlocale)',
	'lang_PHP_Locale_info'		=>	'Ange PHP-lokale, t.ex. en_US',
	'lang_php_url'				=>	'php.net/setlocale',
	
	'lang_Merge_Language'		=>	'Slå samman språk',
	'lang_Merge_Language_info'	=>	'Standardspråk för sammanslagning av saknade språktokens, t.ex. en_US. Sätt till FALSE för att inaktivera',
	
	'lang_Debug_Mode'			=>	'Felsökningsläge',
	'lang_Debug_Mode_info'		=>	'Aktivera felsökningsläge',
	
	'lang_PHP_Errors'			=>	'Undertryck PHP-fel',
	'lang_PHP_Errors_info'		=>	'Tvingar fram undertryckning av PHP-fel när GSDEBUG är FALSE, oavsett php.ini-inställningar',
	
	'lang_Password_Hash'		=>	'Lösenordshash',
	'lang_Password_Hash_info'	=>	'Extra salt för att säkra ditt lösenord',
	'lang_Generator'			=>	'Salt/hash-generator',
	
	'lang_Custom_Salt'			=>	'Anpassat salt',
	'lang_Custom_Salt_info'		=>	'Stäng av automatisk generering av SALT och använd ett anpassat värde. Används för cookies och uppladdningssäkerhet',
	
	'lang_Disable_CSRF'			=>	'Inaktivera CSRF-skydd',
	'lang_Disable_CSRF_info'	=>	'Aktivera om du fortsätter att få meddelandet "CSRF error detected"',
	
	'lang_XFrame'				=>	'X-Frame-alternativ',
	'lang_XFrame_info'			=>	'Förhindra att sidor laddas i ramar. Värden: GSFRONT, GSBACK, GSBOTH eller FALSE',
	
	'lang_Apache_Check'			=>	'Inaktivera Apache-kontroll',
	'lang_Apache_Check_info'	=>	'Inaktivera kontrollen för Apache-webbserver. Standard är FALSE',
	
	'lang_Email_Address'		=>	'Från e-postadress',
	'lang_Email_Address_info'	=>	'Ange avsändaradress för utgående e-post',
	
	'lang_i18n_Language'		=>	'i18n enstaka språk',
	'lang_i18n_Language_info'	=>	'Dölj I18N-text på skärmen Visa alla sidor',
	
	'lang_i18n_Ignore'			=>	'i18n ignorera webbläsarspråk',
	'lang_i18n_Ignore_info'		=>	'Ignorera användarens webbläsarspråksinställning',
	
	'lang_backupbefore_saving'	=>	'En säkerhetskopia kommer att skrivas till "gsconfig.php.bak" innan du sparar',
	'lang_Save_Changes'			=>	'Spara ändringar',
	
	'lang_not_found'			=>	'gsconfig.php hittades inte på',
	'lang_not_writable'			=>	'gsconfig.php är inte skrivbar &mdash; ändringar kan inte sparas. Kontrollera filbehörigheter (chmod 644 eller 666)',
	
	'lang_current_value'		=>	'Nuvarande värde',
	'lang_not_match'			=>	'matchar ingen språkfil i lang-mappen. Välj ett giltigt språk — sparande kommer att blockeras tills du gör det',
	'lang_lang_not_found'		=>	'hittades inte i lang-mappen',
	
	'lang_Settings_saved'		=>	'Inställningar sparade. Säkerhetskopia skriven till "gsconfig.php.bak"',
	'lang_Failed_to_write'		=>	'Kunde inte skriva "gsconfig.php". Kontrollera filbehörigheter.',
	
];