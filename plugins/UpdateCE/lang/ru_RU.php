<?php

$i18n = [
	
# Basics
	'lang_Menu_Title'			=>	'Обновление CE',
	
	'lang_Page_Title'			=>	'Обновление CE',
	'lang_Description'			=>	'Обновите свою установку до последней версии.',
	
# General
	'lang_Installed_Version'	=>	'Установленная версия',
	'lang_Note'					=>	'Примечание',
	'lang_Requirement'			=>	'Требуется версия не менее 3.3.16',
	'lang_Create_Backup'		=>	'Всегда создавайте <b><a class="w3-text-light w3-orange w3-round w3-padding" href="archive.php">резервную</a></b> копию для защиты от непредвиденных обстоятельств!',
	'lang_Themes_Overwritten'	=>	'Темы <u>ResponsiveCE</u> и <u>W3-Startup</u> будут перезаписаны.',
	'lang_Rename_Admin'			=>	'If you have renamed the default <b>/admin/</b> folder, this needs to be <u>reverted back before</u> applying this update. <br>After you have applied the update, you may again personalize this.',
	
	'lang_Key_Changes'			=>	'Основные изменения в этом обновлении',
	'lang_New'					=>	'Новое',
	'lang_Updated'				=>	'Обновлено',
	'lang_Fixes'				=>	'Исправления',
	'lang_Security'				=>	'Безопасность',
	'lang_More_Info'			=>	'Дополнительная информация: Репозиторий на Github',
	'lang_Wiki'					=>	'Wiki',
	'lang_Download'				=>	'Только прямая загрузка',
	'lang_Update_Now'			=>	'Обновите сейчас',
	
	'lang_New_as_of'			=>	'Новая версия на',
	'lang_Plugin_MA'			=>	'Плагин "Massive Admin Theme" включен в комплект поставки, и, возможно, его потребуется активировать.',
	'lang_Update_gsConfig'		=>	'Если вы обновляетесь с более ранней версии, вам потребуется вручную обновить существующий "<b>gsconfig.php</b>" следующим образом...',
	'lang_Add_New'				=>	'Добавить новый',
	'lang_Replace_section'		=>	'Заменить раздел',
	'lang_With_updated'			=>	'С обновленнием',
	
	'lang_Installing'			=>	'Установка...',
	'lang_Seconds_remaining'	=>	'оставшиеся секунды',
	'lang_Finished'				=>	'Закончено... Перенаправление...',
	
	'lang_No_Updates'			=>	'No updates are needed. You are using the current version.',
	
# Backup option
	'lang_Backup_Option'		=>	'Создать резервную копию перед обновлением',
	'lang_Backup_Info'			=>	'Перед началом обновления полная резервная копия сайта будет сохранена в backups/zip/.',
	'lang_Backup_Success'		=>	'Резервная копия успешно создана:',
	'lang_Backup_Failed'		=>	'Не удалось создать резервную копию:',
	'lang_Backup_Aborted'		=>	'Обновление прервано в целях безопасности. Устраните проблему с резервным копированием и повторите попытку либо повторите обновление без использования резервного копирования.',
	
# Progress bar
	'lang_Progress_Backup'		=>	'💾 Создание резервной копии...',
	'lang_Progress_Downloading'	=>	'📥 Загрузка обновления...',
	'lang_Progress_Extracting'	=>	'📦 Распаковка файлов...',
	'lang_Progress_Installing'	=>	'⚙️ Установка обновления...',
	'lang_Progress_Finishing'	=>	'🧹 Завершение...',
	'lang_Progress_Complete'	=>	'Обновление завершено! Выполняется перенаправление...',
	'lang_Update_Failed'		=>	'Не удалось выполнить обновление:',
	'lang_Reload_Page'			=>	'Перезагрузить эту страницу',
	
	'lang_Icon'					=>	'<svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;" width="2em" height="2em" viewBox="0 0 24 24"><path fill="#CF3805" d="M4 16h4v4H4V16z" class="st0"><animate fill="remove" accumulate="none" additive="replace" attributeName="opacity" begin=".2" calcMode="linear" dur="3s" keyTimes="0;0.9;1" repeatCount="indefinite" restart="always" values="1;0;0"/></path><path fill="#CF3805" d="M10 16h4v4h-4V16z" class="st0"><animate fill="remove" accumulate="none" additive="replace" attributeName="opacity" begin=".4" calcMode="linear" dur="3s" keyTimes="0;0.9;1" repeatCount="indefinite" restart="always" values="1;0;0"/></path><path fill="#CF3805" d="M16 16h4v4h-4V16z" class="st0"><animate fill="remove" accumulate="none" additive="replace" attributeName="opacity" begin=".6" calcMode="linear" dur="3s" keyTimes="0;0.9;1" repeatCount="indefinite" restart="always" values="1;0;0"/></path><path fill="#CF3805" d="M4 10h4v4H4V10z" class="st0"><animate fill="remove" accumulate="none" additive="replace" attributeName="opacity" begin=".8" calcMode="linear" dur="3s" keyTimes="0;0.9;1" repeatCount="indefinite" restart="always" values="1;0;0"/></path><path fill="#CF3805" d="M10 10h4v4h-4V10z" class="st0"><animate fill="remove" accumulate="none" additive="replace" attributeName="opacity" begin="1" calcMode="linear" dur="3s" keyTimes="0;0.9;1" repeatCount="indefinite" restart="always" values="1;0;0"/></path><path fill="#CF3805" d="M16 10h4v4h-4V10z" class="st0"><animate fill="remove" accumulate="none" additive="replace" attributeName="opacity" begin="1.2" calcMode="linear" dur="3s" keyTimes="0;0.9;1" repeatCount="indefinite" restart="always" values="1;0;0"/></path><path fill="#CF3805" d="M4 4h4v4H4V4z" class="st0"><animate fill="remove" accumulate="none" additive="replace" attributeName="opacity" begin="1.4" calcMode="linear" dur="3s" keyTimes="0;0.9;1" repeatCount="indefinite" restart="always" values="1;0;0"/></path><path fill="#CF3805" d="M10 4h4v4h-4V4z" class="st0"><animate fill="remove" accumulate="none" additive="replace" attributeName="opacity" begin="1.6" calcMode="linear" dur="3s" keyTimes="0;0.9;1" repeatCount="indefinite" restart="always" values="1;0;0"/></path><path fill="#CF3805" d="M16 4h4v4h-4V4z" class="st0"><animate fill="remove" accumulate="none" additive="replace" attributeName="opacity" begin="1.8" calcMode="linear" dur="3s" keyTimes="0;0.9;1" repeatCount="indefinite" restart="always" values="1;0;0"/></path></svg> ',
	
];