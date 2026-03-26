<?php

$i18n = [
	
# Basics
	'lang_Menu_Title'			=>	'GS Config GUI',
	
	'lang_Page_Title'			=>	'GS Config GUI',
	'lang_Description'			=>	'Editor visual para la configuración de <pre>gsconfig.php</pre>',
	
# General
	'lang_Sections'				=>	'Secciones',
	'lang_Site_Behavior'		=>	'Comportamiento del sitio',
	'lang_Editor'				=>	'Editor',
	'lang_Files_Permissions'	=>	'Archivos y permisos',
	'lang_Localization'			=>	'Localización',
	'lang_Debugging'			=>	'Depuración',
	'lang_Security'				=>	'Seguridad',
	'lang_Plugins'				=>	'Plugins',
	
	'lang_More_info'			=>	'Más información',
	'lang_Salt_Config'			=>	'Configuración de Salt',
	
	'lang_On'					=>	'Activado',
	'lang_Off'					=>	'Desactivado',
	'lang_Value'				=>	'Valor',
	
	'lang_Login_Page'			=>	'Idioma de la página de inicio de sesión',
	'lang_Login_Page_info'		=>	'Idioma predeterminado mostrado en la página de acceso del administrador',
	'lang_Language'				=>	'Idioma',
	
	'lang_Sort_Page'			=>	'Ordenar lista de páginas por',
	'lang_Sort_Page_info'		=>	'Ordenar la lista de páginas del administrador por "title" o "menu"',
	
	'lang_Admin_Folder'			=>	'Nombre de la carpeta de administración',
	'lang_Admin_Folder_info'	=>	'Cambiar el nombre de la carpeta del panel administrativo',
	
	'lang_Canonical'			=>	'Redirecciones canónicas',
	'lang_Canonical_info'		=>	'Habilitar redirecciones canónicas',
	
	'lang_Search_Ping'			=>	'Activar ping a motores de búsqueda',
	'lang_Search_Ping_info'		=>	'Notificar a los motores de búsqueda al generar el sitemap',
	
	'lang_Disable_Sitemap'		=>	'Desactivar sitemap',
	'lang_Disable_Sitemap_info'	=>	'Desactivar la generación del sitemap y los elementos de menú relacionados',
	
	'lang_Auto_Meta'			=>	'Metadescripciones automáticas',
	'lang_Auto_Meta_info'		=>	'Generar automáticamente metadescripciones a partir de extractos del contenido cuando estén vacías',
	
	'lang_External_API'			=>	'Activar API externa',
	'lang_External_API_info'	=>	'Activar la opción de API externa en la página de configuración',
	
	'lang_Editor_Toolbar'		=>	'Barra de herramientas del editor',
	'lang_Editor_Toolbar_info'	=>	'Barras WYSIWYG: "advanced", "basic", "CEbar", "island" o nombre de configuración personalizado',
	
	'lang_Editor_Height'		=>	'Altura del editor',
	'lang_Editor_Height_info'	=>	'Altura del editor WYSIWYG en píxeles (por defecto 500)',
	
	'lang_Editor_Language'		=>	'Idioma del editor',
	'lang_Editor_Language_info'	=>	'Código de idioma del editor WYSIWYG (por defecto "en")',
	
	'lang_Editor_Options'		=>	'Opciones del editor',
	'lang_Editor_Options_info'	=>	'Opciones adicionales del editor WYSIWYG como pares clave:valor',
	'lang_Restore_defaults'		=>	'Restaurar valores predeterminados',
	
	'lang_CodeMirror'			=>	'Tema de CodeMirror',
	'lang_CodeMirror_info'		=>	'Establecer tema de CodeMirror: "blackboard" o "default"',
	
	'lang_Disable_CodeMirror'	=>	'Desactivar editor CodeMirror',
	'lang_Disable_CodeMirror_info'	=>	'Desactivar el editor CodeMirror',
	
	'lang_Autosave'				=>	'Intervalo de autoguardado',
	'lang_Autosave_info'		=>	'Intervalo de autoguardado en segundos en edit.php (ej. 900)',
	
	'lang_Thumbnail_Width'		=>	'Ancho de miniatura de imagen',
	'lang_Thumbnail_Width_info'	=>	'Ancho predeterminado de miniaturas de imágenes subidas en píxeles',
	
	'lang_CHMOD_Mode'			=>	'Sobrescribir modo CHMOD',
	'lang_CHMOD_Mode_info'		=>	'Establecer modo CHMOD como entero octal, ej. 0755',
	
	'lang_Disable_CHMOD'		=>	'Desactivar operaciones CHMOD',
	'lang_Disable_CHMOD_info'	=>	'Desactivar operaciones chmod. Establecer en FALSE para desactivar',
	
	'lang_Format_XML'			=>	'Formatear archivos XML',
	'lang_Format_XML_info'		=>	'Formatear archivos XML antes de guardarlos para que sean legibles',
	
	'lang_Disable_CDN'			=>	'Desactivar CDN externo',
	'lang_Disable_CDN_info'		=>	'Desactivar la carga de versiones externas de jQuery y jQueryUI',
	
	'lang_Server_Timezone'		=>	'Zona horaria del servidor',
	'lang_Server_Timezone_info'	=>	'Cadena de zona horaria predeterminada, ej. America/Chicago o Europe/London',
	'lang_PHP_Timezones'		=>	'Zonas horarias de PHP',
	
	'lang_PHP_Locale'			=>	'Locale de PHP (setlocale)',
	'lang_PHP_Locale_info'		=>	'Establecer locale de PHP, ej. en_US',
	'lang_php_url'				=>	'php.net/setlocale',
	
	'lang_Merge_Language'		=>	'Combinar idioma',
	'lang_Merge_Language_info'	=>	'Idioma predeterminado para combinar tokens faltantes, ej. en_US. Establecer en FALSE para desactivar',
	
	'lang_Debug_Mode'			=>	'Modo Debug',
	'lang_Debug_Mode_info'		=>	'Activar el modo de Debug',
	
	'lang_PHP_Errors'			=>	'Ocultar errores PHP',
	'lang_PHP_Errors_info'		=>	'Fuerza ocultar errores PHP cuando GSDEBUG es FALSE, ignorando php.ini',
	
	'lang_Password_Hash'		=>	'Hash de contraseña',
	'lang_Password_Hash_info'	=>	'Sal adicional para proteger la contraseña',
	'lang_Generator'			=>	'Generador de Salt/Hash',
	
	'lang_Custom_Salt'			=>	'Sal personalizada',
	'lang_Custom_Salt_info'		=>	'Desactivar la generación automática de SALT y usar un valor personalizado',
	
	'lang_Disable_CSRF'			=>	'Desactivar protección CSRF',
	'lang_Disable_CSRF_info'	=>	'Activar si recibes el mensaje "CSRF error detected"',
	
	'lang_XFrame'				=>	'X-Frame-Options',
	'lang_XFrame_info'			=>	'Evitar que las páginas se carguen en frames. Valores: GSFRONT, GSBACK, GSBOTH o FALSE',
	
	'lang_Apache_Check'			=>	'Desactivar comprobación de Apache',
	'lang_Apache_Check_info'	=>	'Desactivar la comprobación del servidor Apache. Por defecto es FALSE',
	
	'lang_Email_Address'		=>	'Dirección de correo remitente',
	'lang_Email_Address_info'	=>	'Establecer la dirección de envío de correos',
	
	'lang_i18n_Language'		=>	'Idioma único i18n',
	'lang_i18n_Language_info'	=>	'Ocultar texto I18N en la pantalla "Ver todas las páginas"',
	
	'lang_i18n_Ignore'			=>	'Ignorar idioma del navegador',
	'lang_i18n_Ignore_info'		=>	'Ignorar el idioma del navegador del usuario',
	
	'lang_backupbefore_saving'	=>	'Se creará una copia de seguridad en "gsconfig.php.bak" antes de guardar',
	'lang_Save_Changes'			=>	'Guardar cambios',
	
	'lang_not_found'			=>	'gsconfig.php no se encontró en',
	'lang_not_writable'			=>	'gsconfig.php no tiene permisos de escritura &mdash; no se pueden guardar los cambios. Comprueba los permisos del archivo (chmod 644 o 666)',
	
	'lang_current_value'		=>	'El valor actual',
	'lang_not_match'			=>	'no coincide con ningún archivo de idioma en la carpeta lang. Por favor, selecciona un idioma válido — no se podrá guardar hasta hacerlo',
	'lang_lang_not_found'		=>	'no se encontró en la carpeta lang',
	
	'lang_Settings_saved'		=>	'Configuración guardada. Copia de seguridad creada en "gsconfig.php.bak"',
	'lang_Failed_to_write'		=>	'No se pudo escribir en "gsconfig.php". Comprueba los permisos del archivo.',
	
];