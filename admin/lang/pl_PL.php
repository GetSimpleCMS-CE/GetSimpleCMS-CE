<?php

/**
 * Polish Language File
 *
 * Date: 		2011.12.06
 * Revision:	2023.07.23
 * Version:		GetSimple 3.3.19 CE
 * Traductors: 	GS Community 
 *
 * @package GetSimple
 * @subpackage Language
 */

$i18n = [

/* 
 * For: install.php
*/
"PHPVER_ERROR"			=>	"<strong>Kontynuacja niemożliwa:</strong> wymagane jest PHP 7.4, lub nowsze, na serwerze zainstalowane jest",
"SIMPLEXML_ERROR"		=>	"<strong>Kontynuacja niemożliwa:</strong> <em>SimpleXML</em> nie jest zainstalowany",
"CURL_WARNING"			=>	"<strong>Ostrzeżenie:</strong> <em>cURL</em> nie jest zainstalowany",
"TZ_WARNING"			=>	"<strong>Ostrzeżenie:</strong> <em>date_default_timezone_set</em> nie został ustawiony",
"WEBSITENAME_ERROR"		=>	"<strong>Błąd:</strong> Wystapił problem z tytułem twojej strony",
"WEBSITEURL_ERROR"		=>	"<strong>Błąd:</strong> Wystapił problem z URLem twojej strony",
"USERNAME_ERROR"		=>	"<strong>Błąd:</strong> Nazwa użytkownika nie została podana",
"EMAIL_ERROR"			=>	"<strong>Błąd:</strong> Wystapił problem z Twoim adresem e-mail",
"CHMOD_ERROR"			=>	"<strong>Kontynuacja niemożliwa:</strong> Nie można zapisac pliku konfiguracyjnego. Użyj <em>CHMOD</em> do nadania praw dostępu 755 lub 777 dla katalogów  <b>/data</b> oraz <b>/backups</b> wraz z podkatalogami i spróbuj ponownie",
"EMAIL_COMPLETE"		=>	"Instalacja zakończona",
"EMAIL_USERNAME"		=>	"Twoje imię",
"EMAIL_PASSWORD"		=>	"Twoje nowe hasło",
"EMAIL_LOGIN"			=>	"Logowanie",
"EMAIL_THANKYOU"		=>	"Dziękujemy za korzystanie",
"NOTE_REGISTRATION"		=>	"Dane rejestracyjne użyte podczas instalacji zostały wysłane na adres: ",
"NOTE_REGERROR"			=>	"<strong>Błąd:</strong> Wystąpił problem z wysłaniem informacji rejestracyjnych na e-mail. Proszę zapisać poniższe hasło",
"NOTE_USERNAME"			=>	"Nazwa użytkownika: ",
"NOTE_PASSWORD"			=>	"<br>hasło: ",
"INSTALLATION"			=>	"Instalacja",
"LABEL_WEBSITE"			=>	"Nazwa strony",
"LABEL_BASEURL"			=>	"URL strony głównej",
"LABEL_SUGGESTION"		=>	"Sugerowany",
"LABEL_USERNAME"		=>	"Użytkownik (login)",
"LABEL_DISPNAME"		=>	"Wyświetlana nazwa",
"LABEL_EMAIL"			=>	"Adres e-mail",
"LABEL_INSTALL"			=>	"Instaluj!",
"SELECT_LANGUAGE"		=> "Wybierz wersję językową",
"CONTINUE_SETUP" 		=> "Kontynuuj instalację",
"DOWNLOAD_LANG" 		=> "Pobierz dodatkowe pliki językowe </a><p>Spolszczenie dla Get-Simple CMS 3:<br>Wojciech Jodła - <a href=\"http://www.wujitsu.pl\" target=\"_blank\" >www.WuJitsu.pl</a></p>",
"SITE_UPDATED"			=>	"Strona została zaktualizowana do najnowszej wersji",
"SERVICE_UNAVAILABLE"	=>	"Strona tymczasowo niedostępna",

/* 
 * For: pages.php
*/
"MENUITEM_SUBTITLE"		=>	"wyświetlana w menu",
"HOMEPAGE_SUBTITLE"		=>	"Strona główna",
"PRIVATE_SUBTITLE"		=>	"Prywatna",
"EDITPAGE_TITLE"  		=>	"Edytuj stronę",
"VIEWPAGE_TITLE"	  	=>	"Podgląd strony ",
"DELETEPAGE_TITLE"		=>	"Usuń stronę ",
"PAGE_MANAGEMENT"	  	=>	"Zarządzanie stronami",
"TOGGLE_STATUS"	  		=>	"Stat<em>u</em>s strony w menu",
"TOTAL_PAGES"	    	=>	"- stron ogółem",
"ALL_PAGES"		    	=>	"Wszystkie strony",

/* 
 * For: edit.php
*/
"PAGE_NOTEXIST"			=>	"Strona nie istnieje",
"BTN_SAVEPAGE"			=>	"Zapisz stronę",
"BTN_SAVEUPDATES"		=>	"Zapisz aktualizację",
"DEFAULT_TEMPLATE"		=>	"Domyślny szablon",
"NONE"					=>	"Nie",
"PAGE"		    		=>	"Strona",
"NEW_PAGE"			  	=>	"Nowa strona",
"PAGE_EDIT_MODE"		=>	"Tryb edycji strony",
"CREATE_NEW_PAGE"		=>	"Nowa strona",
"VIEW"					=>	"Podgląd strony ", // 'v' is the accesskey identifier
"PAGE_OPTIONS"			=>	"Opcje stro<em>n</em>y", // 'o' is the accesskey identifier
"SLUG_URL"			  	=>	"nazwa pliku/URL strony",
"TAG_KEYWORDS"			=>	"Tagi i słowa kluczowe &lt;meta keywords&gt; ",
"PARENT_PAGE"		  	=>	"Podstrona",
"TEMPLATE"			  	=>	"Szablon",
"KEEP_PRIVATE"			=>	"Typ strony",
"ADD_TO_MENU"		  	=>	"Dodaj do menu",
"PRIORITY"			  	=>	"Kolejność",
"MENU_TEXT"			  	=>	"Tekst w menu",
"LABEL_PAGEBODY"		=>	"Body strony",
"CANCEL"				=>	"Anuluj edycję",
"BACKUP_AVAILABLE"		=>	"Dostępna kopia zapasowa strony",
"MAX_FILE_SIZE"			=>	"Maks. rozmiar pliku",
"LAST_SAVED"		  	=>	"Ostatnia aktualizacja",
"FILE_UPLOAD"	  		=>	"Załadowane pliki",
"OR"			      		=>	" lub ",
"SAVE_AND_CLOSE"		=>  "Zapisz i zamknij",
"PAGE_UNSAVED"			=>	"Na stronie dokonano niezapisanych zmian",

/* 
 * For: upload.php
*/
"ERROR_UPLOAD"			=>	"Wystąpił problem podczas przesyłania pliku",
"FILE_SUCCESS_MSG"		=>	"Sukces! Plik załadowany",
"FILE_MANAGEMENT"		=>	"Zarządzanie plikami",
"UPLOADED_FILES"		=>	"Przesłane pliki",
"SHOW_ALL"				=>	"Pokaż wszystkie",
"VIEW_FILE"				=>	"Podgląd pliku",
"DELETE_FILE"			=>	"Usuń plik",
"TOTAL_FILES"			=>	"- wszystkich plików",

/* 
 * For: logout.php
*/
"MSG_LOGGEDOUT"			=>	"Zostałeś wylogowany.",

/* 
 * For: index.php
*/
"LOGIN"			  		=>	"Zaloguj się",
"USERNAME"				=>	"Użytkownik",
"PASSWORD"				=>	"Hasło",
"FORGOT_PWD"			=>	"Zapomniałeś hasła ?",
"CONTROL_PANEL"  		=>	"Panel zarządzania",

/* 
 * For: navigation.php
*/
"CURRENT_MENU" 			=> 	"Aktualne menu",
"NO_MENU_PAGES" 		=> 	"Nie przedzielono żadnej strony do menu głównego.",

/* 
 * For: theme-edit.php
*/
"TEMPLATE_FILE" 	=> 	"Pliki szablonu <strong>%s</strong> pomyślnie zaktualizowano!",
"THEME_MANAGEMENT"	=> 	"Zarządzanie szablonami",
"EDIT_THEME" 		=> 	"Edytuj szablon",
"EDITING_FILE" 		=> 	"Edytowanie pliku",
"BTN_SAVECHANGES" 	=> 	"Zapisz zmiany",
"EDIT" 				=> 	"Edytuj",

/* 
 * For: support.php
*/
"SETTINGS_UPDATED"	=> 	"Ustawienia zostały zaktualizowane",
"UNDO" 				=> 	"Przywróć",
"SUPPORT" 			=> 	"Wsparcie",
"SETTINGS" 			=> 	"Ustawienia",
"ERROR" 			=> 	"Błąd",
"BTN_SAVESETTINGS" 	=> 	"Zapisz ustawienia",
"VIEW_FAILED_LOGIN"	=> 	"Zobacz nieudane próby logowania</a></p></li></ul><br><h3>Tłumaczenie</h3><ul><li><p>Spolszczenie dla Get-Simple CMS: Wojciech Jodła - <a href=\"http://www.wujitsu.pl\" target=\"_blank\" >www.WuJitsu.pl</a></p></li></ul>",


    /* 
     * For: log.php
    */
"MSG_HAS_BEEN_CLR"	=> 	" zostało wyczyszczone",
"LOGS" 				=> 	"Logi",
"VIEWING" 			=> 	"Podgląd",
"LOG_FILE" 			=> 	"logów z pliku",
"CLEAR_ALL_DATA" 	=> 	"Wyczyścić wszystkie dane z",
"CLEAR_THIS_LOG" 	=> 	"Wy<em>c</em>zyść logi", // 'c' is the accesskey identifier
"LOG_FILE_ENTRY" 	=> 	"WPIS W LOGU",
"THIS_COMPUTER"		=>	"Z tego komputera",

/* 
 * For: backup-edit.php
*/
"BAK_MANAGEMENT"		=>	"Zarządzanie kopią zapasową i archiwum",
"ASK_CANCEL"			=>	"Zrezygnuj", // 'c' is the accesskey identifier
"ASK_RESTORE"			=>	"Przywróć", // 'r' is the accesskey identifier
"ASK_DELETE"			=>	"Usuń", // 'd' is the accesskey identifier
"BACKUP_OF"				=>	"Kopia",
"PAGE_TITLE"			=>	"Tytuł strony",
"YES"					=>	"Tak",
"NO"					=>	"Nie",
"DATE"					=>	"Data",
"PERMS"					=>  "Zezwolenia",

/* 
 * For: components.php
*/
"COMPONENTS"		  	=>	"Komponenty",
"DELETE_COMPONENT"		=>	"Usuń komponent",
"EDIT"					=>	"Edytuj",
"ADD_COMPONENT"			=>	"Dod<em>a</em>j komponent", // 'a' is the accesskey identifier
"SAVE_COMPONENTS"		=>	"Zapisz komponent",

/* 
 * For: sitemap.php
*/
"SITEMAP_CREATED"		=>	"Mapa strony została utworzona! Wysłano również ping do 4 serwisów wyszukiwawczych z informacją o aktualizacji",
"SITEMAP_ERRORPING"	=>	"Mapa strony została utworzona, ale wystąpił błąd pingowania jednego lub więcej serwisów wyszukiwania",
"SITEMAP_ERROR"			=>	"<strong>Ostrzeżenie:</strong> mapa strony nie mogła zostać utworzona",
"SITEMAP_WAIT"			=>	"<strong>Proszę czekać:</strong> trwa generowanie mapy strony (sitemap.xml)",

/* 
 * For: theme.php
*/
"THEME_CHANGED"			=>	"Twój szablon został zmieniony",
"CHOOSE_THEME"			=>	"Wybierz szablon",
"ACTIVATE_THEME"		=>	"Aktywuj szablon",
"THEME_SCREENSHOT"		=>	"Podgląd szablonu",
"THEME_PATH"			=>	"Lokalizacja aktualnego szablonu",

/* 
 * For: resetpassword.php
*/
"RESET_PASSWORD"		=>	"Reset hasła",
"YOUR_NEW"				=>	"Twoje nowe",
"PASSWORD_IS"			=>	"hasło to",
"ATTEMPT"				=>	"Próba",
"MSG_PLEASE_EMAIL"		=>	"Podaj adres e-mail zarejestrowanego użytkownika. Nowe hasło zostanie wysłane na ten adres",
"SEND_NEW_PWD"			=>	"Wyślij nowe hasło",

/* 
 * For: settings.php
*/
"GENERAL_SETTINGS"		=>	"Konfiguracja strony",
"WEBSITE_SETTINGS"		=>	"Ustawienia strony",
"LOCAL_TIMEZONE"  		=>	"Czas lokalny",
"LANGUAGE"				=>	"Język",
"USE_FANCY_URLS"		=>	"Włącz przyjazne adresy URL stron - wymaga włączonej obsługi <code>mod_rewrite</code> na serwerze",
"ENABLE_HTML_ED"		=>	"Włącz wizualny edytor HTML",
"WARN_EMAILINVALID"		=>	"Ostrzeżenie: wprowadzony adres e-mail jest niepoprawny!",
"ONLY_NEW_PASSWORD"		=>	"Poniższe pola służą do zmiany <b>aktualnego</b> hasła do logowania",
"NEW_PASSWORD"			=>	"Nowe hasło",
"CONFIRM_PASSWORD"		=>	"Potwierdź hasło",
"PASSWORD_NO_MATCH"		=>	"Hasła nie pasują do siebie",
"PERMALINK" 			=> 	"Struktura przyjaznych URL",
"MORE" 					=> 	"Więcej...",
"HELP" 					=> 	"Pomoc",
"FLUSHCACHE"      		=>  "Wyczyść pamięć podręczną <em>cache</em>",
"FLUSHCACHE-SUCCESS"	=>  "Cache został wyczyszczony",
"DISPLAY_NAME"			=>  "(publiczna nazwa użytkownika, inna niż login)",

/* 
 * For: health-check.php
*/
"WEB_HEALTH_CHECK"		=>	"Stan działania strony",
"VERSION"				=>	"Wersja",
"UPG_NEEDED"			=>	"- dostępna jest aktualizacja v.",
"CANNOT_CHECK"			=>	"Nie można sprawdzić. Twoja wersja to",
"LATEST_VERSION"		=>	"najnowsza wersja",
"SERVER_SETUP"			=>	"Ustawienia serwera",
"OR_GREATER_REQ"		=>	"lub nowsza jest wymagana",
"OK"			     	=>	"OK",
"INSTALLED"			  	=>	"Zainstalowana",
"NOT_INSTALLED"			=>	"Nie zainstalowana",
"WARNING"				=>	"Ostrzeżenie",
"DATA_FILE_CHECK"		=>	"Stan integralności danych i plików",
"DIR_PERMISSIONS"		=>	"Prawa dostępu do katalogu",
"EXISTANCE"			  	=>	"%s - poprawność", /*lub występowanie/istnienie*/
"MISSING_FILE"			=>	"Nieistniejący plik",/*"Zagubiony plik",*/
"BAD_FILE"		  		=>	"Błędny plik",
"NO_FILE"				=>	"Brak pliku .htaccess",
"GOOD_D_FILE"	  		=>	 "Odmowa dostępu", /*"Good 'Deny' file", */
"GOOD_A_FILE"	  		=>	"Dostęp możliwy &nbsp; &nbsp;",/*"Good 'Allow' file",*/
"CANNOT_DEL_FILE"		=>	"Nie można usunąć pliku",
"DOWNLOAD"			  	=>	"Ściągnij",
"WRITABLE"		  		=>	"Zapisywalny",
"NOT_WRITABLE"			=>	"Nie zapisywalny! ",

/* 
 * For: footer.php
*/
"POWERED_BY"			=>	"Strona oparta na ",

/* 
 * For: backups.php
*/
"PAGE_BACKUPS"			=>	"Kopia zapasowa stron",
"ASK_DELETE_ALL"		=>	"Usuń wszystkie",
"DELETE_ALL_BAK"		=>	"Usunąć wszystkie kopie zapasowe ?",
"TOTAL_BACKUPS"			=>	"- wszystkich kopii zapasowych",

/* 
 * For: archive.php
*/
"SUCC_WEB_ARCHIVE"		=>	"Archiwizacja całej strony zakończona sukcesem!",
"SUCC_WEB_ARC_DEL"		=>	"Archiwum strony usunięte",
"WEBSITE_ARCHIVES"		=>	"Archiwa strony www",
"ARCHIVE_DELETED"		=>	"Archiwum zostało usunięte !",
"CREATE_NEW_ARC"		=>	"Utwórz nowe archiwum",
"ASK_CREATE_ARC"		=>	"Utwórz TERAZ nowe archiwum",
"CREATE_ARC_WAIT"		=>	"<strong>Proszę czekać:</strong> tworzenie archiwum strony w toku...",
"DOWNLOAD_ARCHIVES"		=>	"Pobierz archiwum",
"DELETE_ARCHIVE"		=>	"Usunąć archiwum",
"TOTAL_ARCHIVES"		=>	"- liczba wszystkich archiwów",

/* 
 * For: include-nav.php
*/
"WELCOME"			=>	"Zalogowany jako", // used as 'Welcome USERNAME!'
"TAB_PAGES"			=>	"Strony",
"TAB_FILES"			=>	"Pliki",
"TAB_THEME"			=>	"Szablony",
"TAB_BACKUPS"		=>	"Kopia zapasowa i archiwum",
"PLUGINS_NAV" 		=>  "Wtyczki",
"TAB_SETTINGS"		=>	"Ustawienia",
"TAB_SUPPORT"		=>	"Pomoc",
"TAB_LOGOUT"		=>	"Wyloguj",

/* 
 * For: sidebar-files.php
*/
"BROWSE_COMPUTER"	=>	"Przeglądaj w poszukiwaniu pliku",
"UPLOAD"			=>	"Załaduj",

/* 
 * For: sidebar-support.php
*/
"SIDE_SUPPORT_LOG"		=>	"Wsparcie ustawień i l<em>o</em>gów",
"SIDE_HEALTH_CHK"	  	=>	"Stan działania strony",
"SIDE_DOCUMENTATION"	=>	"Dokumentacja Wiki",
"SIDE_VIEW_LOG"			=>	"Podgląd logów",

/* 
 * For: sidebar-theme.php
*/
"SIDE_VIEW_SITEMAP"	=>	"Zobacz mapę strony",
"SIDE_GEN_SITEMAP"	=>	"Generuj <em>m</em>apę strony",
"SIDE_COMPONENTS"	=>	"<em>E</em>dytuj komponenty",
"SIDE_EDIT_THEME"	=>	"Edytuj szablon",
"SIDE_CHOOSE_THEME"	=>	"Wybierz szablon",

/* 
 * For: sidebar-pages.php
*/
"SIDE_CREATE_NEW"		=>	"Dodaj nową stronę",
"SIDE_VIEW_PAGES"		=>	"Zobacz wszystkie strony",

/* 
 * For: sidebar-settings.php
*/
"SIDE_GEN_SETTINGS"		=>	"Konfiguracja strony",
"SIDE_USER_PROFILE"		=>	"Profil użytkownika",

/* 
 * For: sidebar-backups.php
*/
"SIDE_VIEW_BAK"			=>	"Zobacz kopie zapasowe strony",
"SIDE_WEB_ARCHIVES"		=>	"Archiwum strony",
"SIDE_PAGE_BAK"			=>	"Kopia zapasowa stron",

/* 
 * For: error_checking.php
*/
"ER_PWD_CHANGE"			=>	"<strong>Uwaga!</strong> Nie zapomnij o <a href=\"settings.php\">zmianie swojego hasła</a> na takie, które zapamiętasz...",
"ER_BAKUP_DELETED"		=>	"Kopia bezpieczeństwa została skasowana dla %s",
"ER_REQ_PROC_FAIL"		=>	"<strong>Ostrzeżenie:</strong> zadanie nie zostało wykonane",
"ER_YOUR_CHANGES"		=>	"Twoje zmiany %s zostały zapisane",
"ER_HASBEEN_REST"		=>	"%s zostało przywrócone",
"ER_HASBEEN_DEL"		=>	"%s zostało usunięte",
"ER_CANNOT_INDEX"		=>	"Nie można zmienić URL strony głównej (index)",
"ER_SETTINGS_UPD"		=>	"Twoje ustawienia zostały zaktualizowane",
"ER_OLD_RESTORED"		=>	"Twoje stare ustawienia zostały przywrócone",
"ER_NEW_PWD_SENT"		=>	"Nowe hasło zostało wysłane na e-mail podany w konfiguracji",
"ER_SENDMAIL_ERR"		=>	"<strong>Ostrzeżenie:</strong> wystąpił problem z wysłaniem e-maila. Spróbuj ponownie",
"ER_FILE_DEL_SUC"		=>	"Plik został usunięty",
"ER_PROBLEM_DEL"		=>	"<strong>Ostrzeżenie:</strong> wystąpił problem z usunięciem pliku",
"ER_COMPONENT_SAVE"	=>	"Twoje komponenty zostały zapisane",
"ER_COMPONENT_REST"	=>	"Twoje komponenty zostały przywrócone",
"ER_CANCELLED_FAIL"	=>	"<strong>Rezygnacja:</strong> Aktualizacja tego pliku została anulowana",

/* 
 * For: changedata.php
*/
"CANNOT_SAVE_EMPTY"		=>	"Nie można zapisać strony bez tytułu",
"META_DESC" 			=>  "Opis podstrony &lt;meta description&gt; ",

/* 
 * For: template_functions.php
*/
"FTYPE_COMPRESSED"	=>	"Skompresowane", //a file-type
"FTYPE_VECTOR"		=>	"Wektorowe", //a file-type
"FTYPE_FLASH"		=>	"Flash", //a file-type
"FTYPE_VIDEO"		=>	"Wideo", //a file-type
"FTYPE_AUDIO"		=>	"Audio", //a file-type
"FTYPE_WEB"			=>	"Web", //a file-type
"FTYPE_DOCUMENTS"	=>	"Dokumenty", //a file-type
"FTYPE_SYSTEM"		=>	"System", //a file-type
"FTYPE_MISC"		=>	"Różne", //a file-type
"IMAGES"			=>	"Obrazy",

/* 
 * For: login_functions.php
*/
"FILL_IN_REQ_FIELD"	=>	"Wpełnij wszystkie wymagane pola",
"LOGIN_FAILED"		=>	"Podałeś zły login lub hasło. Sprawdź ponownie wpisane dane",

	/* 
	 * For: Date Format
	*/
"DATE_FORMAT"			=>	"j.m.Y", //please keep short
"DATE_AND_TIME_FORMAT"	=>	"j.m.Y - G:i",

/* 
 * For: welcome.php
*/
"WELCOME_MSG"			=>	"Dziękujemy za wybranie GetSimple jako systemu CMS!",
"WELCOME_P"				=>	"Get-Simple pozwala na zarządzanie twoją stroną w niezykle prosty sposób dzięki wysokiej klasy interfejsowi użytkownika i bardzo prostemu systemowi szablonów.",
"GETTING_STARTED"		=>	"Rozpocznij pracę",

    /* 
     * For: image.php
    */
"CURRENT_THUMBNAIL"		=> "Aktualna miniatura",
"RECREATE" 			  	=> "stwórz na nowo",
"CREATE_ONE" 		  	=> "stwórz",
"IMG_CONTROl_PANEL"		=> "Panel zarządzania grafikami",
"ORIGINAL_IMG" 			=> "Oryginalny obraz",
"CLIPBOARD_INSTR"	 	=> "Zaznacz wszystko",/*, po czym kliknij <em>ctrl-c</em> lub <em>command-c</em>",*/
"CREATE_THUMBNAIL" 		=> "Stwórz miniaturę obrazu",
"CROP_INSTR_NEW" 		=> "<em>ctrl+B</em> lub <em>command+B</em> aby zaznaczyć kwadrat",
"SELECT_DIMENTIONS" 	=> "Zaznaczony obszar",
"HTML_ORIG_IMG" 		=> "Kod HTML dla oryginalnego obrazu",
"LINK_ORIG_IMG" 		=> "Odnośnik do oryginalnego obrazu",
"HTML_THUMBNAIL" 		=> "Kod HTML do wstawienia miniatury",
"LINK_THUMBNAIL" 		=> "Odnośnik do miniatury",
"HTML_THUMB_ORIG" 		=> "Obrazkowy odnośnik z miniaturą do oryginalnej grafiki",

    /* 
     * For: plugins.php
    */
"PLUGINS_MANAGEMENT"	=> "Zainstalowane wtyczki",
"PLUGINS_MANAGEMENT_INFO"	=> "Niektóre wtyczki wymagają do prawidłowego działania dodatkowych skryptów js/css.",
"PLUGINS_INSTALLED" 	=> "wtyczek zainstalowanych",
"PLUGIN_DISABLED"   => "Wyłączona ⛔",
"SHOW_PLUGINS"		  	=> "Zarządzanie w<em>t</em>yczkami",
"PLUGIN_NAME" 	  		=> "Nazwa",
"PLUGIN_DESC" 	  		=> "Opis",
"PLUGIN_VER" 			=> "Wersja",
"PLUGIN_UPDATED"		=> "Zmieniono stan wtyczki ✅",

	/***********************************************************************************
	 * SINCE Version 3.0
	***********************************************************************************/

	/* 
	 * For: setup.php
	 */
"ROOT_HTACCESS_ERROR"     => "<strong>Ostrzeżenie:</strong> nie było możliwe utworzenie pliku .htaccess w katalogu głównym! Skopiuj <code>%s</code> jako <code>.htaccess</code> i zmień <code>%s</code> na <code>%s</code>",
"REMOVE_TEMPCONFIG_ERROR" => "<strong>Ostrzeżenie:</strong> nie można usunąć<b>%s</b>! Proszę usunąć plik własnoręcznie.",
"MOVE_TEMPCONFIG_ERROR"   => "<strong>Ostrzeżenie:</strong> nie można zmienić nazwy <b>%s</b> na <b>%s</b>! Proszę zrobić to własnoręcznie.",
"KILL_CANT_CONTINUE"      => "<strong>Ostrzeżenie:</strong> nie można kontynuować. Proszę poprawić błędy i spróbować ponownie.",
"REFRESH"                 => "Odśwież stronę",
"BETA"                    => "Beta / Bleeding Edge",

/*
 * Misc Cleanup Work
 */
# new to 3.0 
"HOMEPAGE_DELETE_ERROR" => "Nie możesz usunąć strony głównej",
"NO_ZIPARCHIVE"         => "rozszerzenie ZipArchive nie jest zainstalowane. Kontynuacja nie jest możliwa", //zip
"REDIRECT_MSG"          => "Jeśli Twoja przeglądarka nie przekieruje Cię automatycznie, <a href=\"%s\">kliknij tutaj</a>", //basic
"REDIRECT"              => "Przekierowanie", //basic
"DENIED"                => "Odmowa", //sitemap
"DEBUG_MODE"            => "Tryb debugowania", //nav-include
"DOUBLE_CLICK_EDIT"     => "Kliknij dwa razy aby edytować", //components
"THUMB_SAVED"           => "Zapisano miniaturkę", //image
"EDIT_COMPONENTS"       =>	"Edytuj komponenty", //components
"REQS_MORE_INFO"        => "<p>Więcej informacji o wymaganych modułach serwera jest dostępnych na stronie z <a href=\"%s\" target=\"_blank\" >wymaganiami instalacyjnymi</a>.</p>", //install & health-check
"SYSTEM_UPDATE"         => "Aktualizacja systemu", // update.php
"AUTHOR" 				=> "Autor", //plugins.php
"ENABLE" 				=> "Włącz", //plugins.php
"DISABLE" 				=> "Wyłącz", //plugins.php
"NO_THEME_SCREENSHOT"   => "Podgląd szablonu niedostępny", //theme.php
"UNSAVED_INFORMATION"   => "Opuszczając stronę stracisz wszystkie niezapisane informacje i dokonane zmiany.", //edit.php
"BACK_TO_WEBSITE"       => "Powrót na stronę główną", //index & resetpassword
"SUPPORT_FORUM"         => "Forum pomocy", //support.php
"FILTER"                => "Filtr stron", //pages.php
"UPLOADIFY_BUTTON"      => "Załaduj pliki/obrazy...", //upload.php
"FILE_BROWSER"          => "Menedżer plików", //filebrowser.php
"SELECT_FILE"           => "Wybierz plik", //filebrowser.php
"CREATE_FOLDER"         => "Załóż nowy folder", //upload.php
"THUMBNAIL"             => "Miniaturka", //filebrowser.php
"ERROR_FOLDER_EXISTS"   => "<strong>Ostrzeżenie:</strong> folder który próbujesz utworzyć już istnieje!", //upload.php
"FOLDER_CREATED"        => "Nowy folder został założony: <strong>%s</strong>", //upload.php
"ERROR_CREATING_FOLDER" => "<strong>Ostrzeżenie:</strong> wystąpił problem podczas zakładania nowego folderu", //upload.php
"DELETE_FOLDER"         => "Usuń folder", //upload.php
"FILE_NAME"             => "Nazwa pliku", //multiple tr header rows
"FILE_SIZE"             => "Rozmiar", //multiple tr header rows
"ARCHIVE_DATE"          => "Data archiwum", //archive.php
"CKEDITOR_LANG" 		=> "pl", // edit.php ; set CKEditor language, don't forget to include CKEditor language file in translation zip

# new to 3.1 
"XML_INVALID" => "plik XML nieprawidłowy", //template-functions.php
"XML_VALID" => "plik XML prawidłowy",
"UPDATE_AVAILABLE" => "Aktualizuj do", //plugins.php
"STATUS" => "Status", //plugins.php
"CLONE" => "Duplikuj stronę", //edit.php
"CLONE_SUCCESS" => "<strong>%s</strong> - zduplikowano poprawnie", //pages.php
"COPY" => "Kopiuj", //pages.php
"CLONE_ERROR" => "<strong>Ostrzeżenie:</strong> Wystapił problem podczas duplikowania <strong>%s</strong>",  //pages.php
"AUTOSAVE_NOTIFY" => 'Strona zapisana automatycznie o', //edit.php
"MENU_MANAGER" => '<em>M</em>enedżer menu', //edit.php
"GET_PLUGINS_LINK" => 'Pobierz dodatkowe pluginy', /*Download <em>M</em>ore Plugins',*/
"SITEMAP_REFRESHED" => "Mapa strony została odświeżona", //edit.php
"LOG_FILE_EMPTY" 		=> 	"Plik logu jest pusty", //log.php
"SHARE" 		=> 	"Udostępnij", //footer.php
"NO_PARENT" => "Nie zagnieżdżona", //edit.php
"REMAINING" => "pozostało znaków", //edit.php
"NORMAL" => "Publiczna", //edit.php
"ERR_CANNOT_DELETE" => "<strong>Ostrzeżenie:</strong> Nie można usunąć %s automatycznie. Istnieje możliwość ręcznego usunięcia poprzez FTP.", //common.php
"ADDITIONAL_ACTIONS" => "Pozostałe akcje", //edit.php
"ITEMS" => "items", //upload.php
"SAVE_MENU_ORDER" => "Zapisz strukturę menu", //menu-manager.php
"MENU_MANAGER_DESC" => "Chwytaj i przeciągaj elementy menu aby ustalać ich kolejność. Nie zapomnij <strong>zapisać zmian</strong> w strukturze menu.",//menu-manager.php
"MENU_MANAGER_SUCCESS" => "Nowa kolejność elementów w menu została zapisana", //menu-manager.php


/* 
 * For: api related pages
 */
"API_ERR_MISSINGPARAM" => 'podany parametr nie istnieje', /*parameter data does not exist',*/
"API_ERR_BADMETHOD" => 'metoda %s nie istnieje',
"API_ERR_AUTHFAILED" => 'uwierzytelnianie zakończone niepowodzeniem', /*authentication failed',*/
"API_ERR_AUTHDISABLED" => 'uwierzytelnianie wyłączone',
"API_ERR_NOPAGE" => 'strona %s nie istnieje',
"API_CONFIGURATION" => 'Konfiguracja API',
"API_ENABLE" => 'Uaktywnij API',
"API_REGENKEY" => 'Generuj nowy klucz dostępu',
"API_DISCLAIMER" => "Aktywując tę opcję umożliwisz zewnętrznym aplikacjom — posiadającym kopię klucza — dostęp do danych zawartych na twojej stronie. <strong>Używaj tej opcji wyłącznie w zaufanych aplikacjach!</strong>",
"API_REGEN_DISCLAIMER" => "Nowy klucz dostępu do API - wymaga zmiany starego klucza w zewnętrznych aplikacjach korzystających z danych na Twojej stronie.",
"API_CONFIRM" => "Jesteś pewien?",


/*
 * Default transliteration
 */
    "TRANSLITERATION" => [
  // Roman
  'á'=>'a', 'é'=>'e', 'í'=>'i', 'ó'=>'o', 'ú'=>'u',
  'Á'=>'a', 'É'=>'e', 'Í'=>'i', 'Ó'=>'o', 'Ú'=>'u',
  'à'=>'a', 'è'=>'e', 'ì'=>'i', 'ò'=>'o', 'ù'=>'u',
  'À'=>'a', 'È'=>'e', 'Ì'=>'i', 'Ò'=>'o', 'Ù'=>'u',
  'ä'=>'a', 'ë'=>'e', 'ï'=>'i', 'ö'=>'o', 'ü'=>'u',
  'Ä'=>'a', 'Ë'=>'e', 'Ï'=>'i', 'Ö'=>'o', 'Ü'=>'u',
  'â'=>'a', 'ê'=>'e', 'î'=>'i', 'ô'=>'o', 'û'=>'u',
  'Â'=>'a', 'Ê'=>'e', 'Î'=>'i', 'Ô'=>'o', 'Û'=>'u',
  'ñ'=>'n', 'ç'=>'c',
  'Ñ'=>'n', 'Ç'=>'c',
  '¿'=>'', '¡'=>'',
  // special Czech chars with diacritics (except some)
  "ě"=>"e","Ě"=>"E","š"=>"s","Š"=>"S","č"=>"c",
  "Č"=>"c","ř"=>"r","Ř"=>"r","ž"=>"z","Ž"=>"z",
  "ý"=>"y","Ý"=>"y",
  "ů"=>"u","Ů"=>"u","ť"=>"t","Ť"=>"t",
  "ď"=>"d","Ď"=>"d","ň"=>"n","Ň"=>"n",
  //special Slovakian chars with diacritics (except some)
  "ĺ"=>"l","ľ"=>"l","ŕ"=>"r", 
  "Ĺ"=>"l","Ľ"=>"L","Ŕ"=>"r",
  // Polish
  "Ą"=>"A","Ć"=>"C","Ę"=>"E",
  "Ł"=>"L","Ń"=>"N","Ó"=>"O",
  "Ś"=>"S","Ź"=>"Z","Ż"=>"Z",
  "ą"=>"a","ć"=>"c","ę"=>"e",
  "ł"=>"l","ń"=>"n","ó"=>"o",
  "ś"=>"s","ź"=>"z","ż"=>"z",
  // Russian
  "А"=>"a","Б"=>"b","В"=>"v",
  "Г"=>"g","Д"=>"d","Е"=>"e","Ё"=>"yo","Ж"=>"zh",
  "З"=>"z","И"=>"i","Й"=>"j","К"=>"k","Л"=>"l",
  "М"=>"m","Н"=>"n","О"=>"o","П"=>"p","Р"=>"r",
  "С"=>"s","Т"=>"t","У"=>"u","Ф"=>"f","Х"=>"h",
  "Ц"=>"c","Ч"=>"ch","Ш"=>"sh","Щ"=>"shh","Ъ"=>"'",
  "Ы"=>"y","Ь"=>"","Э"=>"e","Ю"=>"yu","Я"=>"ya",
  "а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d",
  "е"=>"e","ё"=>"yo","ж"=>"zh","з"=>"z","и"=>"i",
  "й"=>"j","к"=>"k","л"=>"l","м"=>"m","н"=>"n",
  "о"=>"o","п"=>"p","р"=>"r","с"=>"s","т"=>"t",
  "у"=>"u","ф"=>"f","х"=>"h","ц"=>"c","ч"=>"ch",
  "ш"=>"sh","щ"=>"shh","ъ"=>"","ы"=>"y","ь"=>"",
  
  "э"=>"e","ю"=>"yu","я"=>"ya"
],

"X" => "not translated",

/*
 * Additions for 3.1
 */
"DEBUG_CONSOLE" => 'Konsola debugowania',

];

?>