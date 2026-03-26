<?php

$i18n = [
	
# Basics
	'lang_Menu_Title'			=>	'Interface GS Config',
	
	'lang_Page_Title'			=>	'Interface GS Config',
	'lang_Description'			=>	'Editor visual para as definições de configuração do <pre>gsconfig.php</pre>',
	
# General
	'lang_Sections'				=>	'Secções',
	'lang_Site_Behavior'		=>	'Comportamento do Site',
	'lang_Editor'				=>	'Editor',
	'lang_Files_Permissions'	=>	'Ficheiros e Permissões',
	'lang_Localization'			=>	'Localização',
	'lang_Debugging'			=>	'Depuração',
	'lang_Security'				=>	'Segurança',
	'lang_Plugins'				=>	'Plugins',
	
	'lang_More_info'			=>	'Mais informações',
	'lang_Salt_Config'			=>	'Configuração do Salt',
	
	'lang_On'					=>	'Ativado',
	'lang_Off'					=>	'Desativado',
	'lang_Value'				=>	'Valor',
	
	'lang_Login_Page'			=>	'Idioma da Página de Login',
	'lang_Login_Page_info'		=>	'Idioma padrão exibido na página de login da administração',
	'lang_Language'				=>	'Idioma',
	
	'lang_Sort_Page'			=>	'Ordenar Lista de Páginas Por',
	'lang_Sort_Page_info'		=>	'Ordenar a lista de páginas da administração por "título" ou "menu"',
	
	'lang_Admin_Folder'			=>	'Nome da Pasta Admin',
	'lang_Admin_Folder_info'	=>	'Alterar o nome da pasta do painel administrativo',
	
	'lang_Canonical'			=>	'Redirecionamentos Canónicos',
	'lang_Canonical_info'		=>	'Ativar redirecionamentos canónicos',
	
	'lang_Search_Ping'			=>	'Ativar Ping dos Motores de Busca',
	'lang_Search_Ping_info'		=>	'Enviar ping aos motores de busca ao gerar o sitemap',
	
	'lang_Disable_Sitemap'		=>	'Desativar Sitemap',
	'lang_Disable_Sitemap_info'	=>	'Desativar a geração do sitemap e itens de menu relacionados',
	
	'lang_Auto_Meta'			=>	'Meta Descrições Automáticas',
	'lang_Auto_Meta_info'		=>	'Ativar meta descrições automáticas a partir de excertos de conteúdo quando vazios',
	
	'lang_External_API'			=>	'Ativar API Externa',
	'lang_External_API_info'	=>	'Ativar a opção de API Externa mostrada na página de definições',
	
	'lang_Editor_Toolbar'		=>	'Barra de Ferramentas do Editor',
	'lang_Editor_Toolbar_info'	=>	'Barras de ferramentas WYSIWYG: "advanced", "basic", "CEbar", "island" ou nome de configuração personalizado',
	
	'lang_Editor_Height'		=>	'Altura do Editor',
	'lang_Editor_Height_info'	=>	'Altura do editor WYSIWYG em píxeis (padrão 500)',
	
	'lang_Editor_Language'		=>	'Idioma do Editor',
	'lang_Editor_Language_info'	=>	'Código de idioma do editor WYSIWYG (padrão "en")',
	
	'lang_Editor_Options'		=>	'Opções do Editor',
	'lang_Editor_Options_info'	=>	'Opções adicionais do editor WYSIWYG como pares chave:valor',
	'lang_Restore_defaults'		=>	'Restaurar padrões',
	
	'lang_CodeMirror'			=>	'Tema CodeMirror',
	'lang_CodeMirror_info'		=>	'Definir tema CodeMirror: "blackboard" ou "default"',
	
	'lang_Disable_CodeMirror'	=>	'Desativar Editor CodeMirror',
	'lang_Disable_CodeMirror_info'	=>	'Desativar o editor de tema CodeMirror',
	
	'lang_Autosave'				=>	'Intervalo de Gravação Automática',
	'lang_Autosave_info'		=>	'Intervalo de gravação automática em segundos no edit.php (ex. 900)',
	
	'lang_Thumbnail_Width'		=>	'Largura das Miniaturas',
	'lang_Thumbnail_Width_info'	=>	'Largura padrão das miniaturas de imagens enviadas em píxeis',
	
	'lang_CHMOD_Mode'			=>	'Substituir Modo CHMOD',
	'lang_CHMOD_Mode_info'		=>	'Definir o modo CHMOD como um inteiro octal, ex. 0755',
	
	'lang_Disable_CHMOD'		=>	'Desativar Operações CHMOD',
	'lang_Disable_CHMOD_info'	=>	'Desativar operações chmod. Defina como FALSE para desativar',
	
	'lang_Format_XML'			=>	'Formatar Ficheiros XML',
	'lang_Format_XML_info'		=>	'Formatar ficheiros XML antes de guardar para um código legível',
	
	'lang_Disable_CDN'			=>	'Desativar CDN Externo',
	'lang_Disable_CDN_info'		=>	'Desativar o carregamento de versões CDN externas do jQuery e jQueryUI',
	
	'lang_Server_Timezone'		=>	'Fuso Horário do Servidor',
	'lang_Server_Timezone_info'	=>	'String de fuso horário padrão, ex. America/Chicago ou Europe/London',
	'lang_PHP_Timezones'		=>	'Fusos Horários PHP',
	
	'lang_PHP_Locale'			=>	'Locale PHP (setlocale)',
	'lang_PHP_Locale_info'		=>	'Definir locale PHP, ex. en_US',
	'lang_php_url'				=>	'php.net/setlocale',
	
	'lang_Merge_Language'		=>	'Idioma de Fusão',
	'lang_Merge_Language_info'	=>	'Idioma padrão para fusão de tokens de idioma em falta, ex. en_US. Defina como FALSE para desativar',
	
	'lang_Debug_Mode'			=>	'Modo de Depuração',
	'lang_Debug_Mode_info'		=>	'Ativar modo de depuração',
	
	'lang_PHP_Errors'			=>	'Suprimir Erros PHP',
	'lang_PHP_Errors_info'		=>	'Força a supressão de erros PHP quando GSDEBUG é FALSE, independentemente das definições do php.ini',
	
	'lang_Password_Hash'		=>	'Hash da Palavra-passe',
	'lang_Password_Hash_info'	=>	'Salt extra para proteger a sua palavra-passe',
	'lang_Generator'			=>	'Gerador de Salt/Hash',
	
	'lang_Custom_Salt'			=>	'Salt Personalizado',
	'lang_Custom_Salt_info'		=>	'Desativar a geração automática de SALT e usar um valor personalizado. Usado para cookies e segurança de uploads',
	
	'lang_Disable_CSRF'			=>	'Desativar Proteção CSRF',
	'lang_Disable_CSRF_info'	=>	'Ative se continuar a receber a mensagem "CSRF error detected"',
	
	'lang_XFrame'				=>	'Opções X-Frame',
	'lang_XFrame_info'			=>	'Impedir que páginas sejam carregadas em frames. Valores: GSFRONT, GSBACK, GSBOTH ou FALSE',
	
	'lang_Apache_Check'			=>	'Desativar Verificação Apache',
	'lang_Apache_Check_info'	=>	'Desativar a verificação do servidor web Apache. O padrão é FALSE',
	
	'lang_Email_Address'		=>	'Endereço de E-mail do Remetente',
	'lang_Email_Address_info'	=>	'Definir o endereço de remetente para e-mails enviados',
	
	'lang_i18n_Language'		=>	'i18n Idioma Único',
	'lang_i18n_Language_info'	=>	'Ocultar texto I18N no ecrã Ver Todas as Páginas',
	
	'lang_i18n_Ignore'			=>	'i18n Ignorar Idioma do Navegador',
	'lang_i18n_Ignore_info'		=>	'Ignorar a definição de idioma do navegador do utilizador',
	
	'lang_backupbefore_saving'	=>	'Será escrito um backup para "gsconfig.php.bak" antes de guardar',
	'lang_Save_Changes'			=>	'Guardar Alterações',
	
	'lang_not_found'			=>	'gsconfig.php não foi encontrado em',
	'lang_not_writable'			=>	'gsconfig.php não tem permissão de escrita &mdash; as alterações não podem ser guardadas. Verifique as permissões do ficheiro (chmod 644 ou 666)',
	
	'lang_current_value'		=>	'O valor atual',
	'lang_not_match'			=>	'não corresponde a nenhum ficheiro de idioma na pasta lang. Por favor, selecione um idioma válido — a gravação será bloqueada até o fazer',
	'lang_lang_not_found'		=>	'não encontrado na pasta lang',
	
	'lang_Settings_saved'		=>	'Definições guardadas. Backup escrito para "gsconfig.php.bak"',
	'lang_Failed_to_write'		=>	'Falha ao escrever "gsconfig.php". Verifique as permissões do ficheiro.',
	
];