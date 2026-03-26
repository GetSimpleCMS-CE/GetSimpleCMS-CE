<?php

$i18n = [
	
# Basics
	'lang_Menu_Title'			=>	'Interface GS Config',
	
	'lang_Page_Title'			=>	'Interface GS Config',
	'lang_Description'			=>	'Éditeur visuel pour les paramètres de configuration de <pre>gsconfig.php</pre>',
	
# General
	'lang_Sections'				=>	'Sections',
	'lang_Site_Behavior'		=>	'Comportement du site',
	'lang_Editor'				=>	'Éditeur',
	'lang_Files_Permissions'	=>	'Fichiers et permissions',
	'lang_Localization'			=>	'Localisation',
	'lang_Debugging'			=>	'Débogage',
	'lang_Security'				=>	'Sécurité',
	'lang_Plugins'				=>	'Extensions',
	
	'lang_More_info'			=>	'Plus d’infos',
	'lang_Salt_Config'			=>	'Configuration du sel',
	
	'lang_On'					=>	'Activé',
	'lang_Off'					=>	'Désactivé',
	'lang_Value'				=>	'Valeur',
	
	'lang_Login_Page'			=>	'Langue de la page de connexion',
	'lang_Login_Page_info'		=>	'Langue par défaut affichée sur la page de connexion admin',
	'lang_Language'				=>	'Langue',
	
	'lang_Sort_Page'			=>	'Trier la liste des pages par',
	'lang_Sort_Page_info'		=>	'Trier la liste des pages admin par "titre" ou "menu"',
	
	'lang_Admin_Folder'			=>	'Nom du dossier admin',
	'lang_Admin_Folder_info'	=>	'Modifier le nom du dossier du panneau d’administration',
	
	'lang_Canonical'			=>	'Redirections canoniques',
	'lang_Canonical_info'		=>	'Activer les redirections canoniques',
	
	'lang_Search_Ping'			=>	'Activer le ping des moteurs de recherche',
	'lang_Search_Ping_info'		=>	'Pinger les moteurs de recherche lors de la génération du plan du site',
	
	'lang_Disable_Sitemap'		=>	'Désactiver le plan du site',
	'lang_Disable_Sitemap_info'	=>	'Désactiver la génération du plan du site et les éléments de menu associés',
	
	'lang_Auto_Meta'			=>	'Méta-descriptions automatiques',
	'lang_Auto_Meta_info'		=>	'Activer les méta-descriptions automatiques à partir des extraits de contenu quand ils sont vides',
	
	'lang_External_API'			=>	'Activer l’API externe',
	'lang_External_API_info'	=>	'Activer l’option API externe affichée sur la page des paramètres',
	
	'lang_Editor_Toolbar'		=>	'Barre d’outils de l’éditeur',
	'lang_Editor_Toolbar_info'	=>	'Barres d’outils WYSIWYG : "advanced", "basic", "CEbar", "island" ou nom de configuration personnalisé',
	
	'lang_Editor_Height'		=>	'Hauteur de l’éditeur',
	'lang_Editor_Height_info'	=>	'Hauteur de l’éditeur WYSIWYG en pixels (par défaut 500)',
	
	'lang_Editor_Language'		=>	'Langue de l’éditeur',
	'lang_Editor_Language_info'	=>	'Code de langue de l’éditeur WYSIWYG (par défaut "en")',
	
	'lang_Editor_Options'		=>	'Options de l’éditeur',
	'lang_Editor_Options_info'	=>	'Options supplémentaires de l’éditeur WYSIWYG sous forme de paires clé:valeur',
	'lang_Restore_defaults'		=>	'Restaurer les valeurs par défaut',
	
	'lang_CodeMirror'			=>	'Thème CodeMirror',
	'lang_CodeMirror_info'		=>	'Définir le thème CodeMirror : "blackboard" ou "default"',
	
	'lang_Disable_CodeMirror'	=>	'Désactiver l’éditeur CodeMirror',
	'lang_Disable_CodeMirror_info'	=>	'Désactiver l’éditeur de thème CodeMirror',
	
	'lang_Autosave'				=>	'Intervalle de sauvegarde automatique',
	'lang_Autosave_info'		=>	'Intervalle de sauvegarde automatique en secondes dans edit.php (ex. 900)',
	
	'lang_Thumbnail_Width'		=>	'Largeur des miniatures',
	'lang_Thumbnail_Width_info'	=>	'Largeur par défaut des images téléchargées en pixels',
	
	'lang_CHMOD_Mode'			=>	'Mode CHMOD personnalisé',
	'lang_CHMOD_Mode_info'		=>	'Définir le mode CHMOD comme un entier octal, ex. 0755',
	
	'lang_Disable_CHMOD'		=>	'Désactiver les opérations CHMOD',
	'lang_Disable_CHMOD_info'	=>	'Désactiver les opérations chmod. Mettre à FALSE pour désactiver',
	
	'lang_Format_XML'			=>	'Formater les fichiers XML',
	'lang_Format_XML_info'		=>	'Formater les fichiers XML avant de les enregistrer pour une source lisible',
	
	'lang_Disable_CDN'			=>	'Désactiver le CDN externe',
	'lang_Disable_CDN_info'		=>	'Désactiver le chargement des versions CDN externes de jQuery et jQueryUI',
	
	'lang_Server_Timezone'		=>	'Fuseau horaire du serveur',
	'lang_Server_Timezone_info'	=>	'Chaîne du fuseau horaire par défaut, ex. America/Chicago ou Europe/London',
	'lang_PHP_Timezones'		=>	'Fuseaux horaires PHP',
	
	'lang_PHP_Locale'			=>	'Locale PHP (setlocale)',
	'lang_PHP_Locale_info'		=>	'Définir la locale PHP, ex. en_US',
	'lang_php_url'				=>	'php.net/setlocale',
	
	'lang_Merge_Language'		=>	'Fusion de langue',
	'lang_Merge_Language_info'	=>	'Langue par défaut pour la fusion des jetons de langue manquants, ex. en_US. Mettre à FALSE pour désactiver',
	
	'lang_Debug_Mode'			=>	'Mode débogage',
	'lang_Debug_Mode_info'		=>	'Activer le mode débogage',
	
	'lang_PHP_Errors'			=>	'Supprimer les erreurs PHP',
	'lang_PHP_Errors_info'		=>	'Force la suppression des erreurs PHP lorsque GSDEBUG est FALSE, indépendamment des paramètres php.ini',
	
	'lang_Password_Hash'		=>	'Hash du mot de passe',
	'lang_Password_Hash_info'	=>	'Sel supplémentaire pour sécuriser votre mot de passe',
	'lang_Generator'			=>	'Générateur de sel/hash',
	
	'lang_Custom_Salt'			=>	'Sel personnalisé',
	'lang_Custom_Salt_info'		=>	'Désactiver la génération automatique du SALT et utiliser une valeur personnalisée. Utilisé pour les cookies et la sécurité des téléchargements',
	
	'lang_Disable_CSRF'			=>	'Désactiver la protection CSRF',
	'lang_Disable_CSRF_info'	=>	'Activer si vous recevez toujours le message "CSRF error detected"',
	
	'lang_XFrame'				=>	'Options X-Frame',
	'lang_XFrame_info'			=>	'Éviter que les pages ne soient chargées dans des cadres. Valeurs : GSFRONT, GSBACK, GSBOTH ou FALSE',
	
	'lang_Apache_Check'			=>	'Désactiver la vérification Apache',
	'lang_Apache_Check_info'	=>	'Désactiver la vérification du serveur web Apache. La valeur par défaut est FALSE',
	
	'lang_Email_Address'		=>	'Adresse e-mail de l’expéditeur',
	'lang_Email_Address_info'	=>	'Définir l’adresse d’expédition pour les e-mails sortants',
	
	'lang_i18n_Language'		=>	'i18n langue unique',
	'lang_i18n_Language_info'	=>	'Masquer le texte I18N sur l’écran Voir toutes les pages',
	
	'lang_i18n_Ignore'			=>	'i18n ignorer la langue du navigateur',
	'lang_i18n_Ignore_info'		=>	'Ignorer le paramètre de langue du navigateur de l’utilisateur',
	
	'lang_backupbefore_saving'	=>	'Une sauvegarde sera écrite dans "gsconfig.php.bak" avant l’enregistrement',
	'lang_Save_Changes'			=>	'Enregistrer les modifications',
	
	'lang_not_found'			=>	'gsconfig.php n’a pas été trouvé dans',
	'lang_not_writable'			=>	'gsconfig.php n’est pas accessible en écriture &mdash; les modifications ne peuvent pas être enregistrées. Vérifiez les permissions du fichier (chmod 644 ou 666)',
	
	'lang_current_value'		=>	'La valeur actuelle',
	'lang_not_match'			=>	'ne correspond à aucun fichier de langue dans le dossier lang. Veuillez sélectionner une langue valide — l’enregistrement sera bloqué jusqu’à ce que vous le fassiez',
	'lang_lang_not_found'		=>	'introuvable dans le dossier lang',
	
	'lang_Settings_saved'		=>	'Paramètres enregistrés. Sauvegarde écrite dans "gsconfig.php.bak"',
	'lang_Failed_to_write'		=>	'Échec de l’écriture de "gsconfig.php". Vérifiez les permissions du fichier.',
	
];