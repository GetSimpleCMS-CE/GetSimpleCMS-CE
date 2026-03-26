<?php

$i18n = [
	
# Basics
	'lang_Menu_Title'			=>	'Графический интерфейс GS Config',
	
	'lang_Page_Title'			=>	'Графический интерфейс GS Config',
	'lang_Description'			=>	'Визуальный редактор настроек конфигурации <pre>gsconfig.php</pre>',
	
# General
	'lang_Sections'				=>	'Разделы',
	'lang_Site_Behavior'		=>	'Поведение сайта',
	'lang_Editor'				=>	'Редактор',
	'lang_Files_Permissions'	=>	'Файлы и разрешения',
	'lang_Localization'			=>	'Локализация',
	'lang_Debugging'			=>	'Отладка',
	'lang_Security'				=>	'Безопасность',
	'lang_Plugins'				=>	'Плагины',
	
	'lang_More_info'			=>	'Подробнее',
	'lang_Salt_Config'			=>	'Конфигурация соли',
	
	'lang_On'					=>	'Вкл',
	'lang_Off'					=>	'Выкл',
	'lang_Value'				=>	'Значение',
	
	'lang_Login_Page'			=>	'Язык страницы входа',
	'lang_Login_Page_info'		=>	'Язык, отображаемый на странице входа в админку по умолчанию',
	'lang_Language'				=>	'Язык',
	
	'lang_Sort_Page'			=>	'Сортировать список страниц по',
	'lang_Sort_Page_info'		=>	'Сортировать список страниц админки по "заголовку" или "меню"',
	
	'lang_Admin_Folder'			=>	'Имя папки администратора',
	'lang_Admin_Folder_info'	=>	'Изменить имя папки панели управления',
	
	'lang_Canonical'			=>	'Канонические редиректы',
	'lang_Canonical_info'		=>	'Включить канонические редиректы',
	
	'lang_Search_Ping'			=>	'Включить ping поисковых систем',
	'lang_Search_Ping_info'		=>	'Отправлять ping поисковым системам при генерации карты сайта',
	
	'lang_Disable_Sitemap'		=>	'Отключить карту сайта',
	'lang_Disable_Sitemap_info'	=>	'Отключить генерацию карты сайта и связанные пункты меню',
	
	'lang_Auto_Meta'			=>	'Автоматические мета-описания',
	'lang_Auto_Meta_info'		=>	'Включить автоматические мета-описания из отрывков содержимого, если они пусты',
	
	'lang_External_API'			=>	'Включить внешний API',
	'lang_External_API_info'	=>	'Включить опцию внешнего API, отображаемую на странице настроек',
	
	'lang_Editor_Toolbar'		=>	'Панель инструментов редактора',
	'lang_Editor_Toolbar_info'	=>	'Панели инструментов WYSIWYG: "advanced", "basic", "CEbar", "island" или пользовательское имя конфигурации',
	
	'lang_Editor_Height'		=>	'Высота редактора',
	'lang_Editor_Height_info'	=>	'Высота редактора WYSIWYG в пикселях (по умолчанию 500)',
	
	'lang_Editor_Language'		=>	'Язык редактора',
	'lang_Editor_Language_info'	=>	'Код языка редактора WYSIWYG (по умолчанию "en")',
	
	'lang_Editor_Options'		=>	'Опции редактора',
	'lang_Editor_Options_info'	=>	'Дополнительные опции редактора WYSIWYG в виде пар ключ:значение',
	'lang_Restore_defaults'		=>	'Восстановить значения по умолчанию',
	
	'lang_CodeMirror'			=>	'Тема CodeMirror',
	'lang_CodeMirror_info'		=>	'Установить тему CodeMirror: "blackboard" или "default"',
	
	'lang_Disable_CodeMirror'	=>	'Отключить редактор CodeMirror',
	'lang_Disable_CodeMirror_info'	=>	'Отключить редактор темы CodeMirror',
	
	'lang_Autosave'				=>	'Интервал автосохранения',
	'lang_Autosave_info'		=>	'Интервал автосохранения в секундах в edit.php (например, 900)',
	
	'lang_Thumbnail_Width'		=>	'Ширина миниатюры изображения',
	'lang_Thumbnail_Width_info'	=>	'Ширина миниатюры загружаемых изображений по умолчанию в пикселях',
	
	'lang_CHMOD_Mode'			=>	'Переопределить режим CHMOD',
	'lang_CHMOD_Mode_info'		=>	'Установить режим CHMOD как восьмеричное целое число, например 0755',
	
	'lang_Disable_CHMOD'		=>	'Отключить операции CHMOD',
	'lang_Disable_CHMOD_info'	=>	'Отключить операции chmod. Установите FALSE для отключения',
	
	'lang_Format_XML'			=>	'Форматировать XML-файлы',
	'lang_Format_XML_info'		=>	'Форматировать XML-файлы перед сохранением для удобочитаемости',
	
	'lang_Disable_CDN'			=>	'Отключить внешний CDN',
	'lang_Disable_CDN_info'		=>	'Отключить загрузку внешних CDN-версий jQuery и jQueryUI',
	
	'lang_Server_Timezone'		=>	'Часовой пояс сервера',
	'lang_Server_Timezone_info'	=>	'Строка часового пояса по умолчанию, например America/Chicago или Europe/London',
	'lang_PHP_Timezones'		=>	'Часовые пояса PHP',
	
	'lang_PHP_Locale'			=>	'Локаль PHP (setlocale)',
	'lang_PHP_Locale_info'		=>	'Установить локаль PHP, например en_US',
	'lang_php_url'				=>	'php.net/setlocale',
	
	'lang_Merge_Language'		=>	'Слияние языка',
	'lang_Merge_Language_info'	=>	'Язык по умолчанию для слияния отсутствующих языковых токенов, например en_US. Установите FALSE для отключения',
	
	'lang_Debug_Mode'			=>	'Режим отладки',
	'lang_Debug_Mode_info'		=>	'Включить режим отладки',
	
	'lang_PHP_Errors'			=>	'Подавлять ошибки PHP',
	'lang_PHP_Errors_info'		=>	'Принудительно подавлять ошибки PHP, когда GSDEBUG имеет значение FALSE, независимо от настроек php.ini',
	
	'lang_Password_Hash'		=>	'Хэш пароля',
	'lang_Password_Hash_info'	=>	'Дополнительная соль для защиты вашего пароля',
	'lang_Generator'			=>	'Генератор соли/хэша',
	
	'lang_Custom_Salt'			=>	'Пользовательская соль',
	'lang_Custom_Salt_info'		=>	'Отключить автоматическую генерацию SALT и использовать пользовательское значение. Используется для cookies и безопасности загрузок',
	
	'lang_Disable_CSRF'			=>	'Отключить защиту CSRF',
	'lang_Disable_CSRF_info'	=>	'Включите, если вы продолжаете получать сообщение "CSRF error detected"',
	
	'lang_XFrame'				=>	'Опции X-Frame',
	'lang_XFrame_info'			=>	'Запретить загрузку страниц во фреймах. Значения: GSFRONT, GSBACK, GSBOTH или FALSE',
	
	'lang_Apache_Check'			=>	'Отключить проверку Apache',
	'lang_Apache_Check_info'	=>	'Отключить проверку веб-сервера Apache. По умолчанию FALSE',
	
	'lang_Email_Address'		=>	'Адрес электронной почты отправителя',
	'lang_Email_Address_info'	=>	'Установить адрес отправителя для исходящей электронной почты',
	
	'lang_i18n_Language'		=>	'i18n один язык',
	'lang_i18n_Language_info'	=>	'Скрыть текст I18N на экране Просмотр всех страниц',
	
	'lang_i18n_Ignore'			=>	'i18n игнорировать язык браузера',
	'lang_i18n_Ignore_info'		=>	'Игнорировать настройку языка браузера пользователя',
	
	'lang_backupbefore_saving'	=>	'Резервная копия будет сохранена в "gsconfig.php.bak" перед сохранением',
	'lang_Save_Changes'			=>	'Сохранить изменения',
	
	'lang_not_found'			=>	'gsconfig.php не найден по адресу',
	'lang_not_writable'			=>	'gsconfig.php недоступен для записи &mdash; изменения не могут быть сохранены. Проверьте права на файл (chmod 644 или 666)',
	
	'lang_current_value'		=>	'Текущее значение',
	'lang_not_match'			=>	'не соответствует ни одному языковому файлу в папке lang. Пожалуйста, выберите допустимый язык — сохранение будет заблокировано, пока вы это не сделаете',
	'lang_lang_not_found'		=>	'не найден в папке lang',
	
	'lang_Settings_saved'		=>	'Настройки сохранены. Резервная копия записана в "gsconfig.php.bak"',
	'lang_Failed_to_write'		=>	'Не удалось записать "gsconfig.php". Проверьте права на файл.',
	
];