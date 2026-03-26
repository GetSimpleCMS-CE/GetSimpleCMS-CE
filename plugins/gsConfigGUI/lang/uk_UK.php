<?php

$i18n = [
	
# Basics
	'lang_Menu_Title'			=>	'Графічний інтерфейс GS Config',
	
	'lang_Page_Title'			=>	'Графічний інтерфейс GS Config',
	'lang_Description'			=>	'Візуальний редактор налаштувань конфігурації <pre>gsconfig.php</pre>',
	
# General
	'lang_Sections'				=>	'Розділи',
	'lang_Site_Behavior'		=>	'Поведінка сайту',
	'lang_Editor'				=>	'Редактор',
	'lang_Files_Permissions'	=>	'Файли та дозволи',
	'lang_Localization'			=>	'Локалізація',
	'lang_Debugging'			=>	'Налагодження',
	'lang_Security'				=>	'Безпека',
	'lang_Plugins'				=>	'Плагіни',
	
	'lang_More_info'			=>	'Докладніше',
	'lang_Salt_Config'			=>	'Конфігурація солі',
	
	'lang_On'					=>	'Увімк.',
	'lang_Off'					=>	'Вимк.',
	'lang_Value'				=>	'Значення',
	
	'lang_Login_Page'			=>	'Мова сторінки входу',
	'lang_Login_Page_info'		=>	'Мова за замовчуванням, яка відображається на сторінці входу в адмінку',
	'lang_Language'				=>	'Мова',
	
	'lang_Sort_Page'			=>	'Сортувати список сторінок за',
	'lang_Sort_Page_info'		=>	'Сортувати список сторінок адмінки за "заголовком" або "меню"',
	
	'lang_Admin_Folder'			=>	'Назва папки адміністратора',
	'lang_Admin_Folder_info'	=>	'Змінити назву папки панелі керування',
	
	'lang_Canonical'			=>	'Канонічні редіректи',
	'lang_Canonical_info'		=>	'Увімкнути канонічні редіректи',
	
	'lang_Search_Ping'			=>	'Увімкнути ping пошукових систем',
	'lang_Search_Ping_info'		=>	'Надсилати ping пошуковим системам при генерації карти сайту',
	
	'lang_Disable_Sitemap'		=>	'Вимкнути карту сайту',
	'lang_Disable_Sitemap_info'	=>	'Вимкнути генерацію карти сайту та пов’язані пункти меню',
	
	'lang_Auto_Meta'			=>	'Автоматичні мета-описи',
	'lang_Auto_Meta_info'		=>	'Увімкнути автоматичні мета-описи з уривків вмісту, якщо вони порожні',
	
	'lang_External_API'			=>	'Увімкнути зовнішній API',
	'lang_External_API_info'	=>	'Увімкнути опцію зовнішнього API, яка відображається на сторінці налаштувань',
	
	'lang_Editor_Toolbar'		=>	'Панель інструментів редактора',
	'lang_Editor_Toolbar_info'	=>	'Панелі інструментів WYSIWYG: "advanced", "basic", "CEbar", "island" або власна назва конфігурації',
	
	'lang_Editor_Height'		=>	'Висота редактора',
	'lang_Editor_Height_info'	=>	'Висота редактора WYSIWYG у пікселях (за замовчуванням 500)',
	
	'lang_Editor_Language'		=>	'Мова редактора',
	'lang_Editor_Language_info'	=>	'Код мови редактора WYSIWYG (за замовчуванням "en")',
	
	'lang_Editor_Options'		=>	'Опції редактора',
	'lang_Editor_Options_info'	=>	'Додаткові опції редактора WYSIWYG у вигляді пар ключ:значення',
	'lang_Restore_defaults'		=>	'Відновити типові',
	
	'lang_CodeMirror'			=>	'Тема CodeMirror',
	'lang_CodeMirror_info'		=>	'Встановити тему CodeMirror: "blackboard" або "default"',
	
	'lang_Disable_CodeMirror'	=>	'Вимкнути редактор CodeMirror',
	'lang_Disable_CodeMirror_info'	=>	'Вимкнути редактор теми CodeMirror',
	
	'lang_Autosave'				=>	'Інтервал автозбереження',
	'lang_Autosave_info'		=>	'Інтервал автозбереження в секундах у edit.php (наприклад, 900)',
	
	'lang_Thumbnail_Width'		=>	'Ширина мініатюри зображення',
	'lang_Thumbnail_Width_info'	=>	'Типова ширина мініатюри завантажених зображень у пікселях',
	
	'lang_CHMOD_Mode'			=>	'Перевизначити режим CHMOD',
	'lang_CHMOD_Mode_info'		=>	'Встановити режим CHMOD як вісімкове ціле число, наприклад 0755',
	
	'lang_Disable_CHMOD'		=>	'Вимкнути операції CHMOD',
	'lang_Disable_CHMOD_info'	=>	'Вимкнути операції chmod. Встановіть FALSE, щоб вимкнути',
	
	'lang_Format_XML'			=>	'Форматувати XML-файли',
	'lang_Format_XML_info'		=>	'Форматувати XML-файли перед збереженням для зручності читання',
	
	'lang_Disable_CDN'			=>	'Вимкнути зовнішній CDN',
	'lang_Disable_CDN_info'		=>	'Вимкнути завантаження зовнішніх CDN-версій jQuery та jQueryUI',
	
	'lang_Server_Timezone'		=>	'Часовий пояс сервера',
	'lang_Server_Timezone_info'	=>	'Рядок часового поясу за замовчуванням, наприклад America/Chicago або Europe/London',
	'lang_PHP_Timezones'		=>	'Часові пояси PHP',
	
	'lang_PHP_Locale'			=>	'Локаль PHP (setlocale)',
	'lang_PHP_Locale_info'		=>	'Встановити локаль PHP, наприклад en_US',
	'lang_php_url'				=>	'php.net/setlocale',
	
	'lang_Merge_Language'		=>	'Об’єднання мов',
	'lang_Merge_Language_info'	=>	'Мова за замовчуванням для об’єднання відсутніх мовних токенів, наприклад en_US. Встановіть FALSE, щоб вимкнути',
	
	'lang_Debug_Mode'			=>	'Режим налагодження',
	'lang_Debug_Mode_info'		=>	'Увімкнути режим налагодження',
	
	'lang_PHP_Errors'			=>	'Пригнічувати помилки PHP',
	'lang_PHP_Errors_info'		=>	'Примусово пригнічувати помилки PHP, коли GSDEBUG має значення FALSE, незалежно від налаштувань php.ini',
	
	'lang_Password_Hash'		=>	'Хеш пароля',
	'lang_Password_Hash_info'	=>	'Додаткова сіль для захисту вашого пароля',
	'lang_Generator'			=>	'Генератор солі/хешу',
	
	'lang_Custom_Salt'			=>	'Користувацька сіль',
	'lang_Custom_Salt_info'		=>	'Вимкнути автоматичну генерацію SALT і використовувати власне значення. Використовується для файлів cookie та безпеки завантажень',
	
	'lang_Disable_CSRF'			=>	'Вимкнути захист CSRF',
	'lang_Disable_CSRF_info'	=>	'Увімкніть, якщо ви продовжуєте отримувати повідомлення "CSRF error detected"',
	
	'lang_XFrame'				=>	'Опції X-Frame',
	'lang_XFrame_info'			=>	'Запобігти завантаженню сторінок у фреймах. Значення: GSFRONT, GSBACK, GSBOTH або FALSE',
	
	'lang_Apache_Check'			=>	'Вимкнути перевірку Apache',
	'lang_Apache_Check_info'	=>	'Вимкнути перевірку веб-сервера Apache. Типово FALSE',
	
	'lang_Email_Address'		=>	'Електронна адреса відправника',
	'lang_Email_Address_info'	=>	'Встановити адресу відправника для вихідної електронної пошти',
	
	'lang_i18n_Language'		=>	'i18n одна мова',
	'lang_i18n_Language_info'	=>	'Приховати текст I18N на екрані Переглянути всі сторінки',
	
	'lang_i18n_Ignore'			=>	'i18n ігнорувати мову браузера',
	'lang_i18n_Ignore_info'		=>	'Ігнорувати налаштування мови браузера користувача',
	
	'lang_backupbefore_saving'	=>	'Резервна копія буде записана в "gsconfig.php.bak" перед збереженням',
	'lang_Save_Changes'			=>	'Зберегти зміни',
	
	'lang_not_found'			=>	'gsconfig.php не знайдено за адресою',
	'lang_not_writable'			=>	'gsconfig.php недоступний для запису &mdash; зміни не можуть бути збережені. Перевірте права на файл (chmod 644 або 666)',
	
	'lang_current_value'		=>	'Поточне значення',
	'lang_not_match'			=>	'не відповідає жодному мовному файлу в папці lang. Будь ласка, виберіть дійсну мову — збереження буде заблоковано, доки ви це не зробите',
	'lang_lang_not_found'		=>	'не знайдено в папці lang',
	
	'lang_Settings_saved'		=>	'Налаштування збережено. Резервну копію записано в "gsconfig.php.bak"',
	'lang_Failed_to_write'		=>	'Не вдалося записати "gsconfig.php". Перевірте права на файл.',
	
];