<?php

$i18n = [
	
# Basics
	'lang_Menu_Title'			=>	'Interfejs GS Config',
	
	'lang_Page_Title'			=>	'Interfejs GS Config',
	'lang_Description'			=>	'Wizualny edytor ustawień konfiguracyjnych <pre>gsconfig.php</pre>',
	
# General
	'lang_Sections'				=>	'Sekcje',
	'lang_Site_Behavior'		=>	'Zachowanie witryny',
	'lang_Editor'				=>	'Edytor',
	'lang_Files_Permissions'	=>	'Pliki i uprawnienia',
	'lang_Localization'			=>	'lokalizacja',
	'lang_Debugging'			=>	'Debugowanie',
	'lang_Security'				=>	'Bezpieczeństwo',
	'lang_Plugins'				=>	'Wtyczki',
	
	'lang_More_info'			=>	'Więcej informacji',
	'lang_Salt_Config'			=>	'Konfiguracja salt',
	
	'lang_On'					=>	'Wł.',
	'lang_Off'					=>	'Wył.',
	'lang_Value'				=>	'Wartość',
	
	'lang_Login_Page'			=>	'Język strony logowania',
	'lang_Login_Page_info'		=>	'Domyślny język wyświetlany na stronie logowania administratora',
	'lang_Language'				=>	'Język',
	
	'lang_Sort_Page'			=>	'Sortuj listę stron według',
	'lang_Sort_Page_info'		=>	'Sortuj listę stron administratora według "tytułu" lub "menu"',
	
	'lang_Admin_Folder'			=>	'Nazwa folderu admin',
	'lang_Admin_Folder_info'	=>	'Zmień nazwę folderu panelu administracyjnego',
	
	'lang_Canonical'			=>	'Przekierowania kanoniczne',
	'lang_Canonical_info'		=>	'Włącz przekierowania kanoniczne',
	
	'lang_Search_Ping'			=>	'Włącz ping wyszukiwarek',
	'lang_Search_Ping_info'		=>	'Wyślij ping do wyszukiwarek podczas generowania mapy witryny',
	
	'lang_Disable_Sitemap'		=>	'Wyłącz mapę witryny',
	'lang_Disable_Sitemap_info'	=>	'Wyłącz generowanie mapy witryny i powiązane elementy menu',
	
	'lang_Auto_Meta'			=>	'Automatyczne opisy meta',
	'lang_Auto_Meta_info'		=>	'Włącz automatyczne opisy meta z fragmentów treści, gdy są puste',
	
	'lang_External_API'			=>	'Włącz zewnętrzne API',
	'lang_External_API_info'	=>	'Włącz opcję zewnętrznego API widoczną na stronie ustawień',
	
	'lang_Editor_Toolbar'		=>	'Pasek narzędzi edytora',
	'lang_Editor_Toolbar_info'	=>	'Paski narzędzi WYSIWYG: "advanced", "basic", "CEbar", "island" lub niestandardowa nazwa konfiguracji',
	
	'lang_Editor_Height'		=>	'Wysokość edytora',
	'lang_Editor_Height_info'	=>	'Wysokość edytora WYSIWYG w pikselach (domyślnie 500)',
	
	'lang_Editor_Language'		=>	'Język edytora',
	'lang_Editor_Language_info'	=>	'Kod języka edytora WYSIWYG (domyślnie "en")',
	
	'lang_Editor_Options'		=>	'Opcje edytora',
	'lang_Editor_Options_info'	=>	'Dodatkowe opcje edytora WYSIWYG jako pary klucz:wartość',
	'lang_Restore_defaults'		=>	'Przywróć domyślne',
	
	'lang_CodeMirror'			=>	'Motyw CodeMirror',
	'lang_CodeMirror_info'		=>	'Ustaw motyw CodeMirror: "blackboard" lub "default"',
	
	'lang_Disable_CodeMirror'	=>	'Wyłącz edytor CodeMirror',
	'lang_Disable_CodeMirror_info'	=>	'Wyłącz edytor motywu CodeMirror',
	
	'lang_Autosave'				=>	'Interwał automatycznego zapisu',
	'lang_Autosave_info'		=>	'Interwał automatycznego zapisu w sekundach w edit.php (np. 900)',
	
	'lang_Thumbnail_Width'		=>	'Szerokość miniatury obrazu',
	'lang_Thumbnail_Width_info'	=>	'Domyślna szerokość miniatury przesyłanych obrazów w pikselach',
	
	'lang_CHMOD_Mode'			=>	'Nadpisz tryb CHMOD',
	'lang_CHMOD_Mode_info'		=>	'Ustaw nadpisany tryb CHMOD jako liczbę ósemkową, np. 0755',
	
	'lang_Disable_CHMOD'		=>	'Wyłącz operacje CHMOD',
	'lang_Disable_CHMOD_info'	=>	'Wyłącz operacje chmod. Ustaw FALSE, aby wyłączyć',
	
	'lang_Format_XML'			=>	'Formatuj pliki XML',
	'lang_Format_XML_info'		=>	'Formatuj pliki XML przed zapisaniem dla czytelności',
	
	'lang_Disable_CDN'			=>	'Wyłącz zewnętrzne CDN',
	'lang_Disable_CDN_info'		=>	'Wyłącz ładowanie zewnętrznych wersji CDN jQuery i jQueryUI',
	
	'lang_Server_Timezone'		=>	'Strefa czasowa serwera',
	'lang_Server_Timezone_info'	=>	'Domyślny ciąg strefy czasowej, np. America/Chicago lub Europe/London',
	'lang_PHP_Timezones'		=>	'Strefy czasowe PHP',
	
	'lang_PHP_Locale'			=>	'Ustawienia regionalne PHP (setlocale)',
	'lang_PHP_Locale_info'		=>	'Ustaw ustawienia regionalne PHP, np. en_US',
	'lang_php_url'				=>	'php.net/setlocale',
	
	'lang_Merge_Language'		=>	'Scal język',
	'lang_Merge_Language_info'	=>	'Domyślny język scalania brakujących tokenów językowych, np. en_US. Ustaw FALSE, aby wyłączyć',
	
	'lang_Debug_Mode'			=>	'Tryb debugowania',
	'lang_Debug_Mode_info'		=>	'Włącz tryb debugowania',
	
	'lang_PHP_Errors'			=>	'Pomiń błędy PHP',
	'lang_PHP_Errors_info'		=>	'Wymusza pomijanie błędów PHP, gdy GSDEBUG ma wartość FALSE, niezależnie od ustawień php.ini',
	
	'lang_Password_Hash'		=>	'Hash hasła',
	'lang_Password_Hash_info'	=>	'Dodatkowy salt do zabezpieczenia hasła',
	'lang_Generator'			=>	'Generator salt/hash',
	
	'lang_Custom_Salt'			=>	'Niestandardowy salt',
	'lang_Custom_Salt_info'		=>	'Wyłącz automatyczne generowanie SALT i użyj niestandardowej wartości. Używane do plików cookie i bezpieczeństwa przesyłania',
	
	'lang_Disable_CSRF'			=>	'Wyłącz ochronę CSRF',
	'lang_Disable_CSRF_info'	=>	'Włącz, jeśli nadal otrzymujesz komunikat "CSRF error detected"',
	
	'lang_XFrame'				=>	'Opcje X-Frame',
	'lang_XFrame_info'			=>	'Zapobiega ładowaniu stron w ramkach. Wartości: GSFRONT, GSBACK, GSBOTH lub FALSE',
	
	'lang_Apache_Check'			=>	'Wyłącz sprawdzanie Apache',
	'lang_Apache_Check_info'	=>	'Wyłącz sprawdzanie serwera internetowego Apache. Domyślnie FALSE',
	
	'lang_Email_Address'		=>	'Adres e-mail nadawcy',
	'lang_Email_Address_info'	=>	'Ustaw adres nadawcy dla wychodzących wiadomości e-mail',
	
	'lang_i18n_Language'		=>	'i18n pojedynczy język',
	'lang_i18n_Language_info'	=>	'Ukryj tekst I18N na ekranie Wyświetl wszystkie strony',
	
	'lang_i18n_Ignore'			=>	'i18n ignoruj język przeglądarki',
	'lang_i18n_Ignore_info'		=>	'Ignoruj ustawienie języka przeglądarki użytkownika',
	
	'lang_backupbefore_saving'	=>	'Kopia zapasowa zostanie zapisana w "gsconfig.php.bak" przed zapisaniem',
	'lang_Save_Changes'			=>	'Zapisz zmiany',
	
	'lang_not_found'			=>	'Nie znaleziono gsconfig.php w',
	'lang_not_writable'			=>	'gsconfig.php nie jest zapisywalny &mdash; zmiany nie mogą zostać zapisane. Sprawdź uprawnienia pliku (chmod 644 lub 666)',
	
	'lang_current_value'		=>	'Bieżąca wartość',
	'lang_not_match'			=>	'nie pasuje do żadnego pliku językowego w folderze lang. Wybierz poprawny język — zapisywanie zostanie zablokowane do czasu dokonania wyboru',
	'lang_lang_not_found'		=>	'nie znaleziono w folderze lang',
	
	'lang_Settings_saved'		=>	'Ustawienia zapisane. Kopia zapasowa zapisana w "gsconfig.php.bak"',
	'lang_Failed_to_write'		=>	'Nie udało się zapisać "gsconfig.php". Sprawdź uprawnienia pliku.',
	
];