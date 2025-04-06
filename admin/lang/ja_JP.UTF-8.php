<?php

/**
 * Japanese Language File
 *
 * Date:		2022-04-24
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
"PHPVER_ERROR"			=>	"<b>継続不能:</b> PHP 5.1.3 以降が必要です。",
"SIMPLEXML_ERROR"		=>	"<b>継続不能:</b> <em>SimpleXML</em> がインストールされていません",
"CURL_WARNING"			=>	"<b>警告:</b> <em>cURL</em> インストールされていません。",
"TZ_WARNING" => "<b>警告：</ b> <em> date_default_timezone_set </ em>がありません",
"WEBSITENAME_ERROR" => "<b>エラー：</ b>ウェブサイトのタイトルに問題がありました",
"WEBSITEURL_ERROR" => "<b>エラー：</ b>ウェブサイトのURLに問題がありました",
"USERNAME_ERROR" => "<b>エラー：</ b>ユーザー名が設定されていません",
"EMAIL_ERROR" => "<b>エラー：</ b>メールアドレスに問題がありました",
"CHMOD_ERROR" => "<b>続行できません：</b>構成ファイルを書き込めません。<em>CHMOD777 </em>フォルダ/data,/ backups,およびそれらのサブフォルダを再試行してください",
"EMAIL_COMPLETE"		=>	"セットアップ完了",
"EMAIL_USERNAME"		=>	"ユーザーネーム",
"EMAIL_PASSWORD"		=>	"パスワード",
"EMAIL_LOGIN"				=>	"ログイン",
"EMAIL_THANKYOU"		=>	"ご利用ありがとうございます",
"NOTE_REGISTRATION"	=>	"あなたの登録情報を送信しました。",
"NOTE_REGERROR"			=>	"<b>エラー:</b> 登録情報をメールで送信する際に問題が発生しました。 以下のパスワードをメモしてください",
"NOTE_USERNAME"			=>	"ユーザーネーム",
"NOTE_PASSWORD"			=>	"パスワード",
"INSTALLATION"			=>	"インストール",
"LABEL_WEBSITE"			=>	"サイト名",//"Website Name",
"LABEL_BASEURL"			=>	"サイトURL",//"Website Base URL",
    "LABEL_SUGGESTION"		=>	"Our suggestion is",
"LABEL_USERNAME"		=>	"ログイン名",//"Username",
"LABEL_DISPNAME"		=>	"表示名",
"LABEL_EMAIL"				=>	"メールアドレス",//"Email Address",
"LABEL_INSTALL"			=>	"インストールを実行する",
"SELECT_LANGUAGE"		=> "言語を選んでください",
"CONTINUE_SETUP" 		=> "次に進む",
"DOWNLOAD_LANG" 		=> "他の言語ファイルが必要な場合は",
"SITE_UPDATED"			=>	"あなたのサイトが更新されました",
"SERVICE_UNAVAILABLE"	=>	"このページは一時的に利用できません",

    /* 
     * For: pages.php
    */
"MENUITEM_SUBTITLE"	=>	"メニューアイテム",
"HOMEPAGE_SUBTITLE"	=>	"ホーム",
"PRIVATE_SUBTITLE"	=>	"プライベート",
"EDITPAGE_TITLE"		=>	"ページを編集",
"VIEWPAGE_TITLE"		=>	"ページを見る",
"DELETEPAGE_TITLE"	=>	"ページを削除",
"PAGE_MANAGEMENT"		=>	"ページ管理",
"TOGGLE_STATUS"			=>	"ステータスを表示する",
"TOTAL_PAGES"				=>	"ページ（全ページ数）",
"ALL_PAGES"					=>	"全ページ",

    /* 
     * For: edit.php
    */
"PAGE_NOTEXIST"			=>	"リクエストされたページは存在しません",//"The requested page does not exist",
"BTN_SAVEPAGE"			=>	"保存",//"Save Page",
"BTN_SAVEUPDATES"		=>	"更新",//"Save Updates",
"DEFAULT_TEMPLATE"	=>	"デフォルトテンプレート",//"Default Template",
"NONE"							=>	"None",//"None",
"PAGE"							=>	"ページ",//"Page",
"NEW_PAGE"					=>	"新しいページ",//"New Page",
"PAGE_EDIT_MODE"		=>	"",//"Page Editing Mode",
"CREATE_NEW_PAGE"		=>	"新規ページ作成",//"Create New Page",
"VIEW"							=>	"プレビュー",//"<em>V</em>iew", // 'v' is the accesskey identifier
"PAGE_OPTIONS"			=>	"オプション設定",//"Page <em>O</em>ptions", // 'o' is the accesskey identifier
"SLUG_URL"					=>	"スラッグ(URLの一部になります)",
"TAG_KEYWORDS"			=>	"キーワード(タグ)",//"Tags &amp; Keywords",
"PARENT_PAGE"				=>	"親ページ",//"Parent Page",
"TEMPLATE"					=>	"テンプレート",//"Template",
"KEEP_PRIVATE"			=>	"非公開にしておく",//"Keep Private?",
"ADD_TO_MENU"				=>	"メニューに表示",//"Add to Menu",
"PRIORITY"					=>	"表示順",//"Priority",
"MENU_TEXT"					=>	"メニューの項目名",//"Menu Text",
"LABEL_PAGEBODY"		=>	"ページコンテンツ",//"Page Body",
"CANCEL"						=>	"キャンセル",//"Cancel",
"BACKUP_AVAILABLE"	=>	"利用可能なバックアップを表示",//"Backup Available",
"MAX_FILE_SIZE"			=>	"ファイルサイズ上限",//"Max file size",
"LAST_SAVED"				=>	"最終更新日",//"Last Saved",
"FILE_UPLOAD"				=>	"アップロード",//"File Upload",
"OR"								=>	"or",//"or",
    "SAVE_AND_CLOSE"		=> "Save &amp; Close",
    "PAGE_UNSAVED"			=>	"Page has unsaved changes",

    /* 
     * For: upload.php
    */
"ERROR_UPLOAD"			=>	"ファイルのアップロードに問題がありました。",
    "FILE_SUCCESS_MSG"		=>	"Success! File location",
"FILE_MANAGEMENT"		=>	"ファイル管理",//"File Management",
"UPLOADED_FILES"		=>	"アップロードファイル",//"Uploaded Files",
"SHOW_ALL"					=>	"ALL",//"Show All",
"VIEW_FILE"					=>	"プレビュー",//"View File",
"DELETE_FILE"				=>	"削除",//"Delete File",
"TOTAL_FILES"				=>	"ファイル（全ファイル数）",//"total files",

    /* 
     * For: logout.php
    */
"MSG_LOGGEDOUT"				=>	"ログアウトしました",//"Logged Out",

    /* 
     * For: index.php
    */
"LOGIN"							=>	"ログイン",//"Login",
"USERNAME"					=>	"ログイン名",//"Username",
"PASSWORD"					=>	"パスワード",//"Password",
"FORGOT_PWD"				=>	"パスワードをお忘れですか？",//"Forgot your password?",
"CONTROL_PANEL"			=>	"サイト管理画面",//"Control Panel",

    /* 
     * For: navigation.php
    */
"CURRENT_MENU" 			=> 	"現在のメニュー",//"Current Menu",
"NO_MENU_PAGES" 		=> 	"現在メニュー登録されているものはありません",//"There are no pages that are set to appear within the main menu",

    /* 
     * For: theme-edit.php
    */
"TEMPLATE_FILE" 		=> 	"テンプレートファイル <b>%s</b> は正常に更新されました",//"Template file <b>%s</b> has successfully been updated!",
"THEME_MANAGEMENT" 	=> 	"テーマ管理",//"Theme Management",
"EDIT_THEME" 				=> 	"テーマの編集",//"Edit Theme",
"EDITING_FILE" 			=> 	"ファイル編集",//"Editing File",
"BTN_SAVECHANGES" 	=> 	"変更を保存",//"Save Changes",
"EDIT" 							=> 	"編集",//"Edit",

    /* 
     * For: support.php
    */
"SETTINGS_UPDATED"	=> 	"あなたの設定を更新しました。",//"Your settings have been updated",
"UNDO" 							=> 	"元に戻す",//"Undo",
"SUPPORT" 					=> 	"サポート",//"Support",
"SETTINGS" 					=> 	"設定",//"Settings",
"ERROR" 						=> 	"エラー",//"Error",
"BTN_SAVESETTINGS" 	=> 	"設定を保存",//"Save Settings",
    "VIEW_FAILED_LOGIN"		=> 	"View Failed Login Attempts",


    /* 
     * For: log.php
    */
"MSG_HAS_BEEN_CLR" 	=> 	"クリアされている",//" has been cleared",
"LOGS" 							=> 	"ログ",//"Logs",
"VIEWING" 					=> 	"表示",//"Viewing",
"LOG_FILE" 					=> 	"ログファイル",//"Log File",
"CLEAR_ALL_DATA" 		=> 	"すべてのデータをクリアします",//"Clear all data from",
"CLEAR_THIS_LOG" 		=> 	"Clear This Log", // 'c' is the accesskey identifier,
"LOG_FILE_ENTRY" 		=> 	"ログファイルのエントリ",//"LOG FILE ENTRY",
"THIS_COMPUTER"			=>	"このコンピュータ",//"This Computer",

    /* 
     * For: backup-edit.php
    */
"BAK_MANAGEMENT"		=>	"バックアップ管理",//"Backup Management",
"ASK_CANCEL"				=>	"キャンセル",//"<em>C</em>ancel", // 'c' is the accesskey identifier
"ASK_RESTORE"				=>	"この内容に戻す",//"<em>R</em>estore", // 'r' is the accesskey identifier
"ASK_DELETE"				=>	"削除",//"<em>D</em>elete", // 'd' is the accesskey identifier
"BACKUP_OF"					=>	"バックアップ",//"Backup of",
"PAGE_TITLE"				=>	"ページタイトル",//"Page Title",
"YES"								=>	"Yes",//"Yes",
"NO"								=>	"No",//"No",
"DATE"							=>	"日付",//"Date",
	"PERMS"					=>  "Perms",

	/* 
	 * For: components.php
	*/
"COMPONENTS"				=>	"コンポーネント",//"Components",
"DELETE_COMPONENT"	=>	"コンポーネントの削除",//"Delete Component",
"EDIT"							=>	"編集",//"Edit",
"ADD_COMPONENT"			=>	"コンポーネントの追加",//"<em>A</em>dd Component", // 'a' is the accesskey identifier
"SAVE_COMPONENTS"		=>	"コンポーネントの保存",//"Save Components",

	/* 
	 * For: sitemap.php
	*/
"SITEMAP_CREATED"		=>	"サイトマップを作成しました。また,４検索エンジンへのpingを正常に実行しました。",//"Sitemap Created! We also successfully pinged 4 search engines of the update",
"SITEMAP_ERRORPING"	=>	"サイトマップを作成しました。しかし,1つもしくは複数の検索エンジンへのpingを正常に実行できませんでした。",//"Sitemap Created, however there was an error pinging one or more of the search engines",
"SITEMAP_ERROR"			=>	"サイトマップを作成出来ませんでした",//"Your sitemap could not be generated",
"SITEMAP_WAIT"			=>	"<b>お待ちください:</b> サイトマップを作成しています",//"<b>Please Wait:</b> Creating website sitemap",

    /* 
     * For: theme.php
    */
"THEME_CHANGED"			=>	"テーマを変更しました。",//"Your theme has been changed successfully",
"CHOOSE_THEME"			=>	"テーマの選択",//"Choose Your Theme",
"ACTIVATE_THEME"		=>	"テーマを変更する",//"Activate Theme",
"THEME_SCREENSHOT"	=>	"テーマのスクリーンショット",//"Theme Screenshot",
"THEME_PATH"				=>	"現在のテーマのパス",//"Current theme path",

    /* 
     * For: resetpassword.php
    */
"RESET_PASSWORD"		=>	"パスワードをリセットする",//"Reset Password",
"YOUR_NEW"					=>	"あなたの新しい",//"Your new",
"PASSWORD_IS"				=>	"パスワード",//"password is",
"ATTEMPT"						=>	"試み",//"Attempt",
"MSG_PLEASE_EMAIL"	=>	"新しいパスワードを発行するには登録されているメールアドレスを入力して新規パスワード発行ボタンを押してください。",//"Please enter the email address registered on this system, and a new password will be sent to you",
"SEND_NEW_PWD"			=>	"新規パスワード発行",//"Send New Password",

    /* 
     * For: settings.php
    */
"GENERAL_SETTINGS"	=>	"基本設定",//"General Settings",
"WEBSITE_SETTINGS"	=>	"サイト基本設定",//"Website Settings",
"LOCAL_TIMEZONE"		=>	"タイムゾーン",//"Local Timezone",
"LANGUAGE"					=>	"言語設定",//"Language",
"USE_FANCY_URLS"		=>	"<b>Fancy URLを使用する</b>  ※mod_rewriteを有効にする必要があります",//"<b>Use Fancy URLs</b> - Requires that your host has mod_rewrite enabled",
"ENABLE_HTML_ED"		=>	"WYSIWYGエディタを有効にする",//"<b>Enable the HTML editor</b>",
"WARN_EMAILINVALID"	=>	"警告: このメールアドレスは有効ではありません",//"WARNING: This email address does not look valid!",
"ONLY_NEW_PASSWORD"	=>	"パスワードを変更する場合のみ入力",//"Only provide a password below if you want to change your current one",
"NEW_PASSWORD"			=>	"新しいパスワード",//"New Password",
"CONFIRM_PASSWORD"	=>	"パスワードの確認入力",//"Confirm Password",
"PASSWORD_NO_MATCH"	=>	"パスワードが一致しません",//"Passwords do not match",
"PERMALINK" 				=> 	"固定リンク(Permalink)のパターン",
"MORE" 							=> 	"[さらに詳しい情報]",
"HELP" 							=> 	"ヘルプ",
"FLUSHCACHE"        =>  "全てのキャッシュをクリア",
"FLUSHCACHE-SUCCESS"=>  "キャッシュをクリアしました。",
"DISPLAY_NAME"			=>  "ユーザー名ではない公開用の名前",

    /* 
     * For: health-check.php
    */
"WEB_HEALTH_CHECK"	=>	"Webサイトチェック",//"Website Health Check",
"VERSION"						=>	"バージョン",//"Version",
"UPG_NEEDED"				=>	"新しいバージョンがリリースされています",//"Upgrade needed to",
"CANNOT_CHECK"			=>	"使用中のバージョンをチェックすることができません",//"Unable to check. Your version is",
"LATEST_VERSION"		=>	"最新バージョン",//"Latest version installed",
"SERVER_SETUP"			=>	"サーバーのセットアップ",//"Server Setup",
"OR_GREATER_REQ"		=>	"以上であることが必要です",//"or greater is required",
"OK"								=>	"OK",//"OK",
"INSTALLED"					=>	"利用できます",//"Installed",
"NOT_INSTALLED"			=>	"利用できません",//"Not Installed",
"WARNING"						=>	"警告",//"Warning",
"DATA_FILE_CHECK"		=>	"データファイルの整合性チェック",//"Data File Integrity Check",
"DIR_PERMISSIONS"		=>	"ディレクトリのパーミッション",//"Directory Permissions",
"EXISTANCE"					=>	"%s Existance",//"%s Existance",
"MISSING_FILE"			=>	"ファイルが見つかりません",//"Missing file",
"BAD_FILE"					=>	"不良ファイル",//"Bad file",
"NO_FILE"						=>	"ファイルがありません",//"No file",
"GOOD_D_FILE"				=>	"外部からアクセスさせない",//"Good 'Deny' file",
"GOOD_A_FILE"				=>	"外部アクセスを許可する",//"Good 'Allow' file",
"CANNOT_DEL_FILE"		=>	"ファイルを削除できません",//"Cannot Delete File",
"DOWNLOAD"					=>	"ダウンロード",//"Download",
"WRITABLE"					=>	"書き込み可能",//"Writable",
"NOT_WRITABLE"			=>	"書き込み可能でありません",//"Not Writable",

    /* 
     * For: footer.php
    */
    "POWERED_BY"			=>	"Powered by",

    /* 
     * For: backups.php
    */
"PAGE_BACKUPS"			=>	"バックアップされたページ",//"Page Backups",
"ASK_DELETE_ALL"		=>	"全てのバックアップを削除",//"<em>D</em>elete All",
"DELETE_ALL_BAK"		=>	"全てのバックアップを削除しますか？",//"Delete all backups?",
"TOTAL_BACKUPS"			=>	"ページ(全バックアップページ数)",//"total backups",

    /* 
     * For: archive.php
    */
"SUCC_WEB_ARCHIVE"	=>	"Webサイトのアーカイブを作成しました。このデータを用いてサイトを復元できます。",//"Successful website archive!",
"SUCC_WEB_ARC_DEL"	=>	"Webサイトのアーカイブ削除に成功しました。",//"Website archive successfully deleted",
"WEBSITE_ARCHIVES"	=>	"Webサイトをアーカイブ(サイト復元に必要なデータ全て)",//"Website Archives",
"ARCHIVE_DELETED"		=>	"アーカイブの削除に成功しました。",//"Archive deleted successfully",
"CREATE_NEW_ARC"		=>	"アーカイブを新規作成",//"Create a New Archive",
"ASK_CREATE_ARC"		=>	"新たにアーカイブを作成する",//"<em>C</em>reate New Archive Now",
"CREATE_ARC_WAIT"		=>	"<b>Please Wait:</b> Webサイトのアーカイブを作成しています...",//"<b>Please Wait:</b> Creating website archive...",
"DOWNLOAD_ARCHIVES"	=>	"アーカイブのダウンロード",//"Download Archive",
"DELETE_ARCHIVE"		=>	"アーカイブの削除",//"Delete Archive",
"TOTAL_ARCHIVES"		=>	"（アーカイブ数）",//"total archives",

	/* 
	 * For: include-nav.php
	*/
"WELCOME"						=>	"ようこそ",//"Welcome", // used as 'Welcome USERNAME!'
"TAB_PAGES"					=>	"ページ",//"<em>P</em>ages",
"TAB_FILES"					=>	"ファイル",//"<em>F</em>iles",
"TAB_THEME"					=>	"テーマ",//"<em>T</em>heme",
"TAB_BACKUPS"				=>	"バックアップ",//"<em>B</em>ackups",
"PLUGINS_NAV" 			=>  "プラグイン",// "Plu<em>g</em>ins",
"TAB_SETTINGS"			=>	"設定",//"<em>S</em>ettings",
"TAB_SUPPORT"				=>	"サポート",//"Supp<em>o</em>rt",
"TAB_LOGOUT"				=>	"ログアウト",//"<em>L</em>ogout",

    /* 
     * For: sidebar-files.php
    */
"BROWSE_COMPUTER"		=>	"アップロードするファイルを選択", //"Browse Your Computer",
"UPLOAD"						=>	"アップロード", //"Upload",

    /* 
     * For: sidebar-support.php
    */
"SIDE_SUPPORT_LOG"	=>	"システムログ",//"Supp<em>o</em>rt Settings &amp; Logs",
"SIDE_HEALTH_CHK"		=>	"サーバの状態",//"Website <em>H</em>ealth Check",
"SIDE_DOCUMENTATION"=>	"ドキュメント",//"<em>D</em>ocumentation",
"SIDE_VIEW_LOG"			=>	"ログ一覧",//"View Log",

    /* 
     * For: sidebar-theme.php
    */
"SIDE_VIEW_SITEMAP"	=>	"サイトマップを表示",//"<em>V</em>iew Sitemap",
"SIDE_GEN_SITEMAP"	=>	"サイトマップ生成",//"<em>G</em>enerate Sitemap",
"SIDE_COMPONENTS"		=>	"コンポーネントを編集する",//"<em>E</em>dit Components",
"SIDE_EDIT_THEME"		=>	"テーマを編集する",//"Edit <em>T</em>heme",
"SIDE_CHOOSE_THEME"	=>	"テーマを選択する",//"Choose <em>T</em>heme",

    /* 
     * For: sidebar-pages.php
    */
"SIDE_CREATE_NEW"		=>	"ページを新規作成",//"<em>C</em>reate New Page",
"SIDE_VIEW_PAGES"		=>	"ページの一覧を表示",//"View All <em>P</em>ages",

    /* 
     * For: sidebar-settings.php
    */
"SIDE_GEN_SETTINGS"	=>	"サイト基本設定",//"General <em>S</em>ettings",
"SIDE_USER_PROFILE"	=>	"ユーザー設定",//"<em>U</em>ser Profile",

    /* 
     * For: sidebar-backups.php
    */
"SIDE_VIEW_BAK"			=>	"ページのバックアップを表示",//"View Page Backup",
"SIDE_WEB_ARCHIVES"	=>	"Webサイトをアーカイブ",//"<em>W</em>ebsite Archives",
"SIDE_PAGE_BAK"			=>	"バックアップされたページ",//"Page <em>B</em>ackups",

    /* 
     * For: error_checking.php
    */
"ER_PWD_CHANGE"			=>	"",//"Don't forget to <a href=\"settings.php#profile\">change your password</a> from that random generated one you have now...",
"ER_BAKUP_DELETED"	=>	"%s のためにバックアップは削除されました。",//"The backup has been deleted for %s",
"ER_REQ_PROC_FAIL"	=>	"要求されたプロセスが失敗しました",//"The requested process failed",
"ER_YOUR_CHANGES"		=>	"%s に保存されている内容を変更",//"Your changes to %s have been saved",
"ER_HASBEEN_REST"		=>	"%s が復元されました",//"%s has been restored",
"ER_HASBEEN_DEL"		=>	"%s が削除されました",//"%s has been deleted",
"ER_CANNOT_INDEX"		=>	"インデックスページのURLを変更することはできません",//"You cannot change the URL of the index page",
"ER_SETTINGS_UPD"		=>	"設定が更新されました",//"Your settings have been updated",
"ER_OLD_RESTORED"		=>	"旧設定が復元されました",//"Your old settings have been restored",
"ER_NEW_PWD_SENT"		=>	"新しいパスワードが指定のメールアドレスに送信されました",//"A new password has been sent to the email address provided",
"ER_SENDMAIL_ERR"		=>	"メールの送信に問題が発生しました。もう一度やり直して下さい",//"There was a problem sending the email. Please try again",
"ER_FILE_DEL_SUC"		=>	"ファイルが削除されました",//"File deleted successfully",
"ER_PROBLEM_DEL"		=>	"問題があるファイルを削除しました",//"There was a problem deleting the file",
"ER_COMPONENT_SAVE"	=>	"コンポーネントが保存されました",//"Your components have been saved",
"ER_COMPONENT_REST"	=>	"コンポーネントが復元されました",//"Your components have been restored",
"ER_CANCELLED_FAIL"	=>	"このファイルへの更新はキャンセルされました",//"<b>Cancelled:</b> The update to this file has been cancelled",

    /* 
     * For: changedata.php
    */
"CANNOT_SAVE_EMPTY"	=>	"空のページは保存できません",//"You cannot save an empty page",
"META_DESC" 				=> "Description属性(metaタグ)",

	/* 
	 * For: template_functions.php
	*/
	"FTYPE_COMPRESSED"		=>	"Compressed", //a file-type
	"FTYPE_VECTOR"			=>	"Vector", //a file-type
	"FTYPE_FLASH"			=>	"Flash", //a file-type
	"FTYPE_VIDEO"			=>	"Video", //a file-type
	"FTYPE_AUDIO"			=>	"Audio", //a file-type
	"FTYPE_WEB"				=>	"Web", //a file-type
"FTYPE_DOCUMENTS"		=>	"ドキュメント", //a file-type
"FTYPE_SYSTEM"			=>	"システム", //a file-type
"FTYPE_MISC"				=>	"音楽", //a file-type
"IMAGES"						=>	"画像",

	/* 
	 * For: login_functions.php
	*/
"FILL_IN_REQ_FIELD"	=>	"すべての必須項目に入力",//"Please fill in all the required fields",
"LOGIN_FAILED"			=>	"ログインに失敗しました。ログイン名とパスワードを確認してください。",//"Login failed. Please double check your Username and Password",

	/* 
	 * For: Date Format
	*/
"DATE_FORMAT"									=>	"Y-m-d", //please keep short
"DATE_AND_TIME_FORMAT"				=>	"Y-m-d H:i:s", //date and time

	/* 
	 * For: support.php
	*/
"WELCOME_MSG"				=>	"GetSimpleをインストールしました。",
"WELCOME_P"					=>	"GetSimpleは,使いやすい管理画面とシンプルなテンプレートシステムが特長。手頃なサイズのサイトを管理するのに適しており,説明書がなくても今日から使いこなせます。",
"GETTING_STARTED"		=>	"ここから始めましょう。",

    /* 
     * For: image.php
    */
"CURRENT_THUMBNAIL" => "現在のサムネイル",
"RECREATE" => "recreate",
"CREATE_ONE" => "作成する",
"IMG_CONTROl_PANEL" => "画像コントロールパネル",
"ORIGINAL_IMG" => "元の画像",
"CLIPBOARD_INSTR" => "すべて選択",
"CREATE_THUMBNAIL" => "サムネイルの作成",
"CROP_INSTR_NEW" => "<em> ctrl-B</em>または<em>コマンド-B</em>（正方形の場合）",
"SELECT_DIMENTIONS" => "選択次元",
"HTML_ORIG_IMG" => "元の画像のHTML",
"LINK_ORIG_IMG" => "元の画像リンク",
"HTML_THUMBNAIL" => "サムネイルHTML",
"LINK_THUMBNAIL" => "サムネイルリンク",
"HTML_THUMB_ORIG" => "サムネイルから画像へのHTML",

    /* 
     * For: plugins.php
    */
"PLUGINS_MANAGEMENT"=> "プラグイン管理",
"PLUGINS_MANAGEMENT_INFO"	=> "一部のプラグインは、正しく機能するために追加の js/css スクリプトを必要とする場合があります。<br>「modernScript CE」プラグインが有効になっていることを確認し、設定を確認してください。",
"PLUGINS_INSTALLED" => "個のプラグインがインストール済みです。",
"PLUGIN_DISABLED"   => "無効のプラグイン",
"SHOW_PLUGINS"			=> "プラグイン一覧",
"PLUGIN_NAME" 			=> "プラグイン名",
"PLUGIN_DESC" 			=> "詳細情報",
"PLUGIN_VER" 				=> "バージョン",
"PLUGIN_UPDATED"		=> "プラグイン更新",

	/***********************************************************************************
	 * SINCE Version 3.0
	***********************************************************************************/

	/* 
	 * For: setup.php
	 */
"ROOT_HTACCESS_ERROR" => "ルートに.htaccessを作成できませんでした！<b>％s</b>を<b>.htaccess</ b>にコピーし,<code>％s</code>を<code>に変更してください ％s </ code> ",
"REMOVE_TEMPCONFIG_ERROR" => "<b>％s </ b>の削除に失敗しました！手動で実行してください。",
"MOVE_TEMPCONFIG_ERROR" => "<b>％s </ b>の名前を<b>％s </ b>に変更できませんでした！手動で行ってください。",
"KILL_CANT_CONTINUE" => "続行できません。エラーを修正して,再試行してください。",
"REFRESH" => "更新",
"BETA" => "ベータ/出血エッジ",

	/*
	 * Misc Cleanup Work
	 */
	# new to 3.0 
"HOMEPAGE_DELETE_ERROR" => "ホームページを削除できません",// deletefile
"NO_ZIPARCHIVE" => "ZipArchive拡張機能がインストールされていません。続行できません",// zip
"REDIRECT_MSG" => "ブラウザがリダイレクトしない場合は,<a href=\"%s\">こちら</a>をクリックしてください",//basic
"REDIRECT"=> "リダイレクト", //basic
"DENIED"=> "Denied", //sitemap
"DEBUG_MODE"=> "デバッグモード", //nav-include
"DOUBLE_CLICK_EDIT"=> "Double Click to Edit", //components
"THUMB_SAVED"=> "Thumbnail Saved", //image
"EDIT_COMPONENTS"		=>	"コンポーネントを編集", //components
"REQS_MORE_INFO"=> "必須モジュールの詳細については要件ページ<a href=\"%s\" target=\"_blank\" >をご覧ください。</a>.", 
	"SYSTEM_UPDATE" 		=> "System Update", // update.php
"AUTHOR" 				=> "作者", 
"ENABLE" 				=> "有効", 
"DISABLE" 				=> "無効", 
"NO_THEME_SCREENSHOT" => "テーマのスクリーンショットはありません", 
"UNSAVED_INFORMATION" => "このページを閉じると,未保存の情報が失われます。", 
"BACK_TO_WEBSITE" => "Back to Website", 
"SUPPORT_FORUM" => "サポートフォーラム", 
"FILTER" => "フィルター", 
"UPLOADIFY_BUTTON" => "画像またはファイルをアップロード", 
"FILE_BROWSER" => "ファイルブラウザ", 
"SELECT_FILE" => "ファイルを選択", 
"CREATE_FOLDER" => "フォルダを新規作成", 
"THUMBNAIL" => "サムネイル", 
"ERROR_FOLDER_EXISTS" => "作成しようとしているフォルダはすでに存在しています。", 
"FOLDER_CREATED" => "新しいフォルダーが正常に作成されました。<strong>%s</strong>", 
"ERROR_CREATING_FOLDER" => "新しいフォルダの作成にエラーが発生しました", 
"DELETE_FOLDER" => "フォルダを削除", 
"FILE_NAME" => "ファイル名", 
"FILE_SIZE" => "サイズ", 
"ARCHIVE_DATE" => "アーカイブした日時", 
"CKEDITOR_LANG" => "ja",

	# new to 3.1 
"XML_INVALID" => "XML無効",
"XML_VALID" => "XML有効",
"UPDATE_AVAILABLE" => "更新先",
"STATUS" => "ステータス",
"CLONE" => "Clone",
"CLONE_SUCCESS" => "正常に作成された ％s",
"COPY" => "コピー",
"CLONE_ERROR" => "<b>％s </ b>のクローンを作成しようとして問題が発生しました",
"AUTOSAVE_NOTIFY" =>'ページが自動保存されました',
"MENU_MANAGER" =>'Menu 管理',
"GET_PLUGINS_LINK" =>'Moreプラグインをダウンロード',
"SITEMAP_REFRESHED" => "サイトマップが更新されました",
"LOG_FILE_EMPTY" => "このログファイルは空です",
"SHARE"=>"共有",
"NO_PARENT" => "親なし",
"REMAINING" => "残りの文字数",
"NORMAL" => "Normal",
"ERR_CANNOT_DELETE" => "％sを削除できません。手動で行ってください。",
"ADDITIONAL_ACTIONS" => "その他のアクション",
"ITEMS" => "items",
"SAVE_MENU_ORDER" => "メニューの順序を保存",
"MENU_MANAGER_DESC" => "必要な順序になるまでメニュー項目をドラッグアンドドロップし,<strong>[メニュー順序の保存]</ strong>ボタンをクリックします。",
"MENU_MANAGER_SUCCESS" => "新しいメニューの順序が保存されました",


    /* 
     * For: api related pages
     */
"API_ERR_MISSINGPARAM "=>'パラメータデータが存在しません',
"API_ERR_BADMETHOD" =>'メソッド％sが存在しません',
"API_ERR_AUTHFAILED" =>'認証に失敗しました',
"API_ERR_AUTHDISABLED" =>'認証が無効です',
"API_ERR_NOPAGE" =>'リクエストされたページ％sは存在しません',
"API_CONFIGURATION" =>'API構成',
"API_ENABLE" =>'APIを有効にする',
"API_REGENKEY" =>'キーの再生成',
"API_DISCLAIMER" => "このAPIを有効にすると,キーのコピーを持つすべての外部アプリケーションがWebサイトのデータにアクセスできるようになります。<b>このキーは信頼できるアプリケーションとのみ共有してください。</ b>",
"API_REGEN_DISCLAIMER" => "APIキーを再生成するときは,このAPIを使用して外部アプリケーションに新しいキーを入力してWebサイトに接続する必要があります。",
"API_CONFIRM" 			=> "ARE YOU SURE?",

    /*
     * Default transliteration
     */
    "TRANSLITERATION" 		=> [
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
		"Ą"=>"a","Ć"=>"c","Ę"=>"e",
		"Ł"=>"L","Ń"=>"N","Ó"=>"O",
		"Ś"=>"s","Ź"=>"z","Ż"=>"z",
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

	"X" 					=> "not translated",

	/*
	 * Additions for 3.1
	 */
	"DEBUG_CONSOLE" 		=> 'デバッグコンソール',

];

?>