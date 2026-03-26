<?php

$i18n = [
	
# Basics
	'lang_Menu_Title'			=>	'GS Config GUI',
	
	'lang_Page_Title'			=>	'GS Config GUI',
	'lang_Description'			=>	'<pre>gsconfig.php</pre> 設定のビジュアルエディタ',
	
# General
	'lang_Sections'				=>	'セクション',
	'lang_Site_Behavior'		=>	'サイト動作',
	'lang_Editor'				=>	'エディタ',
	'lang_Files_Permissions'	=>	'ファイルと権限',
	'lang_Localization'			=>	'ローカライゼーション',
	'lang_Debugging'			=>	'デバッグ',
	'lang_Security'				=>	'セキュリティ',
	'lang_Plugins'				=>	'プラグイン',
	
	'lang_More_info'			=>	'詳細情報',
	'lang_Salt_Config'			=>	'ソルト設定',
	
	'lang_On'					=>	'オン',
	'lang_Off'					=>	'オフ',
	'lang_Value'				=>	'値',
	
	'lang_Login_Page'			=>	'ログインページの言語',
	'lang_Login_Page_info'		=>	'管理ログインページに表示されるデフォルト言語',
	'lang_Language'				=>	'言語',
	
	'lang_Sort_Page'			=>	'ページリストの並び順',
	'lang_Sort_Page_info'		=>	'管理ページリストを「タイトル」または「メニュー」で並べ替え',
	
	'lang_Admin_Folder'			=>	'管理フォルダ名',
	'lang_Admin_Folder_info'	=>	'管理パネルのフォルダ名を変更',
	
	'lang_Canonical'			=>	'正規リダイレクト',
	'lang_Canonical_info'		=>	'正規リダイレクトを有効にする',
	
	'lang_Search_Ping'			=>	'検索エンジンピングを有効にする',
	'lang_Search_Ping_info'		=>	'サイトマップ生成時に検索エンジンにピングを送信',
	
	'lang_Disable_Sitemap'		=>	'サイトマップを無効にする',
	'lang_Disable_Sitemap_info'	=>	'サイトマップ生成と関連メニュー項目を無効にする',
	
	'lang_Auto_Meta'			=>	'自動メタディスクリプション',
	'lang_Auto_Meta_info'		=>	'空の場合にコンテンツ抜粋から自動メタディスクリプションを生成',
	
	'lang_External_API'			=>	'外部APIを有効にする',
	'lang_External_API_info'	=>	'設定ページに表示される外部APIオプションを有効にする',
	
	'lang_Editor_Toolbar'		=>	'エディタツールバー',
	'lang_Editor_Toolbar_info'	=>	'WYSIWYGツールバー: "advanced", "basic", "CEbar", "island", またはカスタム設定名',
	
	'lang_Editor_Height'		=>	'エディタの高さ',
	'lang_Editor_Height_info'	=>	'WYSIWYGエディタの高さ（ピクセル、デフォルト500）',
	
	'lang_Editor_Language'		=>	'エディタの言語',
	'lang_Editor_Language_info'	=>	'WYSIWYGエディタの言語コード（デフォルト"en"）',
	
	'lang_Editor_Options'		=>	'エディタオプション',
	'lang_Editor_Options_info'	=>	'追加のWYSIWYGエディタオプション（キー:値のペア）',
	'lang_Restore_defaults'		=>	'デフォルトに戻す',
	
	'lang_CodeMirror'			=>	'CodeMirrorテーマ',
	'lang_CodeMirror_info'		=>	'CodeMirrorテーマを設定: "blackboard" または "default"',
	
	'lang_Disable_CodeMirror'	=>	'CodeMirrorエディタを無効にする',
	'lang_Disable_CodeMirror_info'	=>	'CodeMirrorテーマエディタを無効にする',
	
	'lang_Autosave'				=>	'自動保存間隔',
	'lang_Autosave_info'		=>	'edit.php内の自動保存間隔（秒、例: 900）',
	
	'lang_Thumbnail_Width'		=>	'画像サムネイルの幅',
	'lang_Thumbnail_Width_info'	=>	'アップロード画像のデフォルトサムネイル幅（ピクセル）',
	
	'lang_CHMOD_Mode'			=>	'CHMODモードを上書き',
	'lang_CHMOD_Mode_info'		=>	'上書きCHMODモードを8進整数で設定（例: 0755）',
	
	'lang_Disable_CHMOD'		=>	'CHMOD操作を無効にする',
	'lang_Disable_CHMOD_info'	=>	'chmod操作を無効にします。無効にするにはFALSEを設定',
	
	'lang_Format_XML'			=>	'XMLファイルをフォーマット',
	'lang_Format_XML_info'		=>	'保存前にXMLファイルをフォーマットして可読性を向上',
	
	'lang_Disable_CDN'			=>	'外部CDNを無効にする',
	'lang_Disable_CDN_info'		=>	'jQueryとjQueryUIの外部CDNバージョンの読み込みを無効にする',
	
	'lang_Server_Timezone'		=>	'サーバータイムゾーン',
	'lang_Server_Timezone_info'	=>	'デフォルトのタイムゾーン文字列（例: America/Chicago または Europe/London）',
	'lang_PHP_Timezones'		=>	'PHPタイムゾーン',
	
	'lang_PHP_Locale'			=>	'PHPロケール (setlocale)',
	'lang_PHP_Locale_info'		=>	'PHPロケールを設定（例: en_US）',
	'lang_php_url'				=>	'php.net/setlocale',
	
	'lang_Merge_Language'		=>	'言語マージ',
	'lang_Merge_Language_info'	=>	'不足している言語トークンをマージするデフォルト言語（例: en_US）。無効にするにはFALSEを設定',
	
	'lang_Debug_Mode'			=>	'デバッグモード',
	'lang_Debug_Mode_info'		=>	'デバッグモードを有効にする',
	
	'lang_PHP_Errors'			=>	'PHPエラーを抑制',
	'lang_PHP_Errors_info'		=>	'GSDEBUGがFALSEの場合、php.ini設定に関係なくPHPエラーの抑制を強制する',
	
	'lang_Password_Hash'		=>	'パスワードハッシュ',
	'lang_Password_Hash_info'	=>	'パスワードを保護する追加のソルト',
	'lang_Generator'			=>	'ソルト/ハッシュ生成器',
	
	'lang_Custom_Salt'			=>	'カスタムソルト',
	'lang_Custom_Salt_info'		=>	'SALTの自動生成をオフにしてカスタム値を使用します。クッキーとアップロードセキュリティに使用',
	
	'lang_Disable_CSRF'			=>	'CSRF保護を無効にする',
	'lang_Disable_CSRF_info'	=>	'「CSRF error detected」メッセージが表示され続ける場合は有効にしてください',
	
	'lang_XFrame'				=>	'X-Frame-Options',
	'lang_XFrame_info'			=>	'ページがフレーム内で読み込まれるのを防ぎます。値: GSFRONT, GSBACK, GSBOTH, または FALSE',
	
	'lang_Apache_Check'			=>	'Apacheチェックを無効にする',
	'lang_Apache_Check_info'	=>	'Apacheウェブサーバーのチェックを無効にします。デフォルトはFALSE',
	
	'lang_Email_Address'		=>	'送信元メールアドレス',
	'lang_Email_Address_info'	=>	'送信メールの送信元アドレスを設定',
	
	'lang_i18n_Language'		=>	'i18n シングル言語',
	'lang_i18n_Language_info'	=>	'全ページ表示画面でI18Nテキストを非表示にする',
	
	'lang_i18n_Ignore'			=>	'i18n ブラウザ言語を無視',
	'lang_i18n_Ignore_info'		=>	'ユーザーのブラウザ言語設定を無視する',
	
	'lang_backupbefore_saving'	=>	'保存前に "gsconfig.php.bak" にバックアップが作成されます',
	'lang_Save_Changes'			=>	'変更を保存',
	
	'lang_not_found'			=>	'gsconfig.php が見つかりませんでした:',
	'lang_not_writable'			=>	'gsconfig.php に書き込み権限がありません &mdash; 変更を保存できません。ファイル権限を確認してください (chmod 644 または 666)',
	
	'lang_current_value'		=>	'現在の値',
	'lang_not_match'			=>	'langフォルダ内のいずれの言語ファイルとも一致しません。有効な言語を選択してください — 選択するまで保存はブロックされます',
	'lang_lang_not_found'		=>	'langフォルダ内に見つかりません',
	
	'lang_Settings_saved'		=>	'設定を保存しました。"gsconfig.php.bak" にバックアップを作成しました',
	'lang_Failed_to_write'		=>	'"gsconfig.php" の書き込みに失敗しました。ファイル権限を確認してください。',
	
];