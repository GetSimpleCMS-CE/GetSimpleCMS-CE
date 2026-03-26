<?php

$i18n = [
	
# Basics
	'lang_Menu_Title'			=>	'Interfaccia GS Config',
	
	'lang_Page_Title'			=>	'Interfaccia GS Config',
	'lang_Description'			=>	'Editor visivo per le impostazioni di configurazione di <pre>gsconfig.php</pre>',
	
# General
	'lang_Sections'				=>	'Sezioni',
	'lang_Site_Behavior'		=>	'Comportamento del sito',
	'lang_Editor'				=>	'Editor',
	'lang_Files_Permissions'	=>	'File e permessi',
	'lang_Localization'			=>	'Localizzazione',
	'lang_Debugging'			=>	'Debug',
	'lang_Security'				=>	'Sicurezza',
	'lang_Plugins'				=>	'Plugin',
	
	'lang_More_info'			=>	'Maggiori informazioni',
	'lang_Salt_Config'			=>	'Configurazione Salt',
	
	'lang_On'					=>	'Attivo',
	'lang_Off'					=>	'Disattivo',
	'lang_Value'				=>	'Valore',
	
	'lang_Login_Page'			=>	'Lingua pagina di accesso',
	'lang_Login_Page_info'		=>	'Lingua predefinita mostrata nella pagina di accesso admin',
	'lang_Language'				=>	'Lingua',
	
	'lang_Sort_Page'			=>	'Ordina elenco pagine per',
	'lang_Sort_Page_info'		=>	'Ordina l’elenco pagine admin per "titolo" o "menu"',
	
	'lang_Admin_Folder'			=>	'Nome cartella admin',
	'lang_Admin_Folder_info'	=>	'Modifica il nome della cartella del pannello amministrativo',
	
	'lang_Canonical'			=>	'Redirect canonici',
	'lang_Canonical_info'		=>	'Abilita redirect canonici',
	
	'lang_Search_Ping'			=>	'Abilita ping ai motori di ricerca',
	'lang_Search_Ping_info'		=>	'Invia ping ai motori di ricerca durante la generazione della sitemap',
	
	'lang_Disable_Sitemap'		=>	'Disabilita sitemap',
	'lang_Disable_Sitemap_info'	=>	'Disabilita la generazione della sitemap e le voci di menu correlate',
	
	'lang_Auto_Meta'			=>	'Meta descrizioni automatiche',
	'lang_Auto_Meta_info'		=>	'Abilita meta descrizioni automatiche dagli estratti di contenuto quando vuoti',
	
	'lang_External_API'			=>	'Abilita API esterna',
	'lang_External_API_info'	=>	'Abilita l’opzione API esterna mostrata nella pagina delle impostazioni',
	
	'lang_Editor_Toolbar'		=>	'Barra strumenti editor',
	'lang_Editor_Toolbar_info'	=>	'Barre strumenti WYSIWYG: "advanced", "basic", "CEbar", "island" o nome configurazione personalizzato',
	
	'lang_Editor_Height'		=>	'Altezza editor',
	'lang_Editor_Height_info'	=>	'Altezza editor WYSIWYG in pixel (predefinito 500)',
	
	'lang_Editor_Language'		=>	'Lingua editor',
	'lang_Editor_Language_info'	=>	'Codice lingua editor WYSIWYG (predefinito "en")',
	
	'lang_Editor_Options'		=>	'Opzioni editor',
	'lang_Editor_Options_info'	=>	'Opzioni aggiuntive editor WYSIWYG come coppie chiave:valore',
	'lang_Restore_defaults'		=>	'Ripristina predefiniti',
	
	'lang_CodeMirror'			=>	'Tema CodeMirror',
	'lang_CodeMirror_info'		=>	'Imposta tema CodeMirror: "blackboard" o "default"',
	
	'lang_Disable_CodeMirror'	=>	'Disabilita editor CodeMirror',
	'lang_Disable_CodeMirror_info'	=>	'Disabilita l’editor tema CodeMirror',
	
	'lang_Autosave'				=>	'Intervallo salvataggio automatico',
	'lang_Autosave_info'		=>	'Intervallo salvataggio automatico in secondi all’interno di edit.php (es. 900)',
	
	'lang_Thumbnail_Width'		=>	'Larghezza miniature',
	'lang_Thumbnail_Width_info'	=>	'Larghezza predefinita delle miniature delle immagini caricate in pixel',
	
	'lang_CHMOD_Mode'			=>	'Override modalità CHMOD',
	'lang_CHMOD_Mode_info'		=>	'Imposta la modalità CHMOD come intero ottale, es. 0755',
	
	'lang_Disable_CHMOD'		=>	'Disabilita operazioni CHMOD',
	'lang_Disable_CHMOD_info'	=>	'Disabilita operazioni chmod. Impostare su FALSE per disabilitare',
	
	'lang_Format_XML'			=>	'Formatta file XML',
	'lang_Format_XML_info'		=>	'Formatta i file XML prima del salvataggio per una sorgente leggibile',
	
	'lang_Disable_CDN'			=>	'Disabilita CDN esterno',
	'lang_Disable_CDN_info'		=>	'Disabilita il caricamento di versioni CDN esterne di jQuery e jQueryUI',
	
	'lang_Server_Timezone'		=>	'Fuso orario server',
	'lang_Server_Timezone_info'	=>	'Stringa fuso orario predefinito, es. America/Chicago o Europe/London',
	'lang_PHP_Timezones'		=>	'Fusi orari PHP',
	
	'lang_PHP_Locale'			=>	'Locale PHP (setlocale)',
	'lang_PHP_Locale_info'		=>	'Imposta locale PHP, es. en_US',
	'lang_php_url'				=>	'php.net/setlocale',
	
	'lang_Merge_Language'		=>	'Unisci lingua',
	'lang_Merge_Language_info'	=>	'Lingua predefinita per unire token lingua mancanti, es. en_US. Impostare su FALSE per disabilitare',
	
	'lang_Debug_Mode'			=>	'Modalità debug',
	'lang_Debug_Mode_info'		=>	'Attiva modalità debug',
	
	'lang_PHP_Errors'			=>	'Sopprimi errori PHP',
	'lang_PHP_Errors_info'		=>	'Forza la soppressione degli errori PHP quando GSDEBUG è FALSE, nonostante le impostazioni php.ini',
	
	'lang_Password_Hash'		=>	'Hash password',
	'lang_Password_Hash_info'	=>	'Sale aggiuntivo per proteggere la tua password',
	'lang_Generator'			=>	'Generatore Sale/Hash',
	
	'lang_Custom_Salt'			=>	'Sale personalizzato',
	'lang_Custom_Salt_info'		=>	'Disattiva la generazione automatica del SALT e usa un valore personalizzato. Utilizzato per cookie e sicurezza caricamenti',
	
	'lang_Disable_CSRF'			=>	'Disabilita protezione CSRF',
	'lang_Disable_CSRF_info'	=>	'Abilita se continui a ricevere il messaggio "CSRF error detected"',
	
	'lang_XFrame'				=>	'Opzioni X-Frame',
	'lang_XFrame_info'			=>	'Impedisci il caricamento delle pagine in frame. Valori: GSFRONT, GSBACK, GSBOTH o FALSE',
	
	'lang_Apache_Check'			=>	'Disabilita controllo Apache',
	'lang_Apache_Check_info'	=>	'Disabilita il controllo per il server web Apache. Il valore predefinito è FALSE',
	
	'lang_Email_Address'		=>	'Indirizzo email mittente',
	'lang_Email_Address_info'	=>	'Imposta l’indirizzo del mittente per le email in uscita',
	
	'lang_i18n_Language'		=>	'i18n lingua singola',
	'lang_i18n_Language_info'	=>	'Nascondi il testo I18N nella schermata Vedi tutte le pagine',
	
	'lang_i18n_Ignore'			=>	'i18n ignora lingua browser',
	'lang_i18n_Ignore_info'		=>	'Ignora l’impostazione della lingua del browser dell’utente',
	
	'lang_backupbefore_saving'	=>	'Un backup verrà scritto in "gsconfig.php.bak" prima del salvataggio',
	'lang_Save_Changes'			=>	'Salva modifiche',
	
	'lang_not_found'			=>	'gsconfig.php non trovato in',
	'lang_not_writable'			=>	'gsconfig.php non è scrivibile &mdash; le modifiche non possono essere salvate. Verifica i permessi del file (chmod 644 o 666)',
	
	'lang_current_value'		=>	'Il valore corrente',
	'lang_not_match'			=>	'non corrisponde a nessun file lingua nella cartella lang. Seleziona una lingua valida — il salvataggio sarà bloccato finché non lo fai',
	'lang_lang_not_found'		=>	'non trovato nella cartella lang',
	
	'lang_Settings_saved'		=>	'Impostazioni salvate. Backup scritto in "gsconfig.php.bak"',
	'lang_Failed_to_write'		=>	'Impossibile scrivere "gsconfig.php". Verifica i permessi del file.',
	
];