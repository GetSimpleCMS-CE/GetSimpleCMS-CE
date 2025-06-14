<?php

/**
 * ملف اللغة العربية
 *
 * التاريخ: 		2009.09.10
 * المراجعة:		2023.07.23
 * الإصدار:		GetSimple 3.3.19 CE
 * المترجمون:   مجتمع GS
 *
 * @package GetSimple
 * @subpackage Language
 */

$i18n = [

    /* 
     * For: install.php
    */
    "PHPVER_ERROR"          =>  "<b>غير قادر على المتابعة:</b> يتطلب PHP 7.4 أو أعلى، لديك ",
    "SIMPLEXML_ERROR"       =>  "<b>غير قادر على المتابعة:</b> <em>SimpleXML</em> غير مثبت",
    "CURL_WARNING"          =>  "<b>تحذير:</b> <em>cURL</em> غير مثبت",
    "TZ_WARNING"            =>  "<b>تحذير:</b> <em>date_default_timezone_set</em> مفقود",
    "WEBSITENAME_ERROR"     =>  "<b>خطأ:</b> حدثت مشكلة في عنوان موقعك",
    "WEBSITEURL_ERROR"      =>  "<b>خطأ:</b> حدثت مشكلة في عنوان URL الخاص بموقعك",
    "USERNAME_ERROR"        =>  "<b>خطأ:</b> لم يتم تعيين اسم المستخدم",
    "EMAIL_ERROR"           =>  "<b>خطأ:</b> حدثت مشكلة في عنوان بريدك الإلكتروني",
    "CHMOD_ERROR"           =>  "<b>غير قادر على المتابعة:</b> تعذر كتابة ملف الإعدادات. قم بتعيين CHMOD 755 أو 777 للمجلدات <code>/data</code> و <code>/backups</code> والمجلدات الفرعية ثم حاول مرة أخرى.",
    "EMAIL_COMPLETE"        =>  "اكتمل الإعداد",
    "EMAIL_USERNAME"        =>  "اسم المستخدم الخاص بك هو",
    "EMAIL_PASSWORD"        =>  "كلمة المرور الجديدة الخاصة بك هي",
    "EMAIL_LOGIN"           =>  "تسجيل الدخول من هنا",
    "EMAIL_THANKYOU"        =>  "شكراً لاستخدامك",
    "NOTE_REGISTRATION"     =>  "تم إرسال معلومات التسجيل الخاصة بك إلى",
    "NOTE_REGERROR"         =>  "<b>خطأ:</b> حدثت مشكلة في إرسال معلومات التسجيل عبر البريد الإلكتروني. يرجى حفظ كلمة المرور أدناه",
    "NOTE_USERNAME"         =>  "اسم المستخدم الخاص بك هو",
    "NOTE_PASSWORD"         =>  "وكلمة المرور الخاصة بك هي",
    "INSTALLATION"          =>  "التثبيت",
    "LABEL_WEBSITE"         =>  "اسم الموقع",
    "LABEL_BASEURL"         =>  "عنوان URL الخاص بالموقع",
    "LABEL_SUGGESTION"      =>  "اقتراحنا هو",
    "LABEL_USERNAME"        =>  "اسم المستخدم",
    "LABEL_DISPNAME"        =>  "الاسم المعروض",
    "LABEL_EMAIL"           =>  "عنوان البريد الإلكتروني",
    "LABEL_INSTALL"         =>  "تثبيت الآن!",
    "SELECT_LANGUAGE"       =>  "اختر لغتك",
    "CONTINUE_SETUP"        =>  "متابعة الإعداد",
    "DOWNLOAD_LANG"         =>  "تنزيل اللغات",
    "SITE_UPDATED"          =>  "تم تحديث موقعك",
    "SERVICE_UNAVAILABLE"   =>  "هذه الصفحة غير متوفرة مؤقتاً",

    /* 
     * For: pages.php
    */
    "MENUITEM_SUBTITLE"     =>  "عنصر القائمة",
    "HOMEPAGE_SUBTITLE"     =>  "الصفحة الرئيسية",
    "PRIVATE_SUBTITLE"      =>  "خاص",
    "EDITPAGE_TITLE"        =>  "تحرير الصفحة",
    "VIEWPAGE_TITLE"        =>  "عرض الصفحة",
    "DELETEPAGE_TITLE"      =>  "حذف الصفحة",
    "PAGE_MANAGEMENT"       =>  "إدارة الصفحات",
    "TOGGLE_STATUS"         =>  "تبديل الحالة",
    "TOTAL_PAGES"           =>  "إجمالي الصفحات",
    "ALL_PAGES"             =>  "الصفحات",

    /* 
     * For: edit.php
    */
    "PAGE_NOTEXIST"         =>  "الصفحة المطلوبة غير موجودة",
    "BTN_SAVEPAGE"          =>  "حفظ الصفحة",
    "BTN_SAVEUPDATES"       =>  "حفظ التحديثات",
    "DEFAULT_TEMPLATE"      =>  "القالب الافتراضي",
    "NONE"                  =>  "لا شيء",
    "PAGE"                  =>  "صفحة",
    "NEW_PAGE"              =>  "صفحة جديدة",
    "PAGE_EDIT_MODE"        =>  "تحرير الصفحة",
    "CREATE_NEW_PAGE"       =>  "إضافة صفحة جديدة",
    "VIEW"                  =>  "عرض",
    "PAGE_OPTIONS"          =>  "خيارات الصفحة",
    "SLUG_URL"              =>  "عنوان URL مخصص (Slug)",
    "TAG_KEYWORDS"          =>  "العلامات والكلمات الدلالية",
    "PARENT_PAGE"           =>  "الصفحة الأم",
    "TEMPLATE"              =>  "قالب الصفحة",
    "KEEP_PRIVATE"          =>  "رؤية الصفحة",
    "ADD_TO_MENU"           =>  "إضافة هذه الصفحة إلى القائمة",
    "PRIORITY"              =>  "الأولوية",
    "MENU_TEXT"             =>  "نص القائمة",
    "LABEL_PAGEBODY"        =>  "محتوى الصفحة",
    "CANCEL"                =>  "إلغاء",
    "BACKUP_AVAILABLE"      =>  "نسخة احتياطية متوفرة",
    "MAX_FILE_SIZE"         =>  "أقصى حجم للملف",
    "LAST_SAVED"            =>  "آخر حفظ للصفحة بواسطة %s في",
    "FILE_UPLOAD"           =>  "رفع الملف",
    "OR"                    =>  "أو",
    "SAVE_AND_CLOSE"        =>  "حفظ وإغلاق",
    "PAGE_UNSAVED"          =>  "هناك تغييرات غير محفوظة في الصفحة",

    /* 
     * For: upload.php
    */
    "ERROR_UPLOAD"          =>  "حدثت مشكلة أثناء رفع الملف",
    "FILE_SUCCESS_MSG"      =>  "نجاح! موقع الملف",
    "FILE_MANAGEMENT"       =>  "إدارة الملفات",
    "UPLOADED_FILES"        =>  "الملفات المرفوعة",
    "SHOW_ALL"              =>  "عرض الكل",
    "VIEW_FILE"             =>  "عرض الملف",
    "DELETE_FILE"           =>  "حذف الملف",
    "TOTAL_FILES"           =>  "إجمالي الملفات والمجلدات",

    /* 
     * For: logout.php
    */
    "MSG_LOGGEDOUT"         =>  "لقد تم تسجيل خروجك الآن.",

    /* 
     * For: index.php
    */
    "LOGIN"                 =>  "تسجيل الدخول",
    "USERNAME"              =>  "اسم المستخدم",
    "PASSWORD"              =>  "كلمة المرور",
    "FORGOT_PWD"            =>  "هل نسيت كلمة المرور؟",
    "CONTROL_PANEL"         =>  "دخول لوحة التحكم",

    /* 
     * For: navigation.php
    */
    "CURRENT_MENU"          =>  "القائمة الحالية",
    "NO_MENU_PAGES"         =>  "لا توجد صفحات محددة للظهور في القائمة الرئيسية",

    /* 
     * For: theme-edit.php
    */
    "TEMPLATE_FILE"         =>  "تم تحديث ملف القالب <b>%s</b> بنجاح!",
    "THEME_MANAGEMENT"      =>  "إدارة القوالب",
    "EDIT_THEME"            =>  "محرر القوالب",
    "EDITING_FILE"          =>  "تحرير الملف",
    "BTN_SAVECHANGES"       =>  "حفظ التغييرات",
    "EDIT"                  =>  "تحرير",

    /* 
     * For: support.php
    */
    "SETTINGS_UPDATED"      =>  "تم تحديث إعداداتك",
    "UNDO"                  =>  "تراجع",
    "SUPPORT"               =>  "الدعم",
    "SETTINGS"              =>  "الإعدادات",
    "ERROR"                 =>  "خطأ",
    "BTN_SAVESETTINGS"      =>  "حفظ الإعدادات",
    "VIEW_FAILED_LOGIN"     =>  "عرض محاولات تسجيل الدخول الفاشلة",

    /* 
     * For: log.php
    */
    "MSG_HAS_BEEN_CLR"      =>  " تم مسحها",
    "LOGS"                  =>  "السجلات",
    "VIEWING"               =>  "عرض",
    "LOG_FILE"              =>  "ملف السجل",
    "CLEAR_ALL_DATA"        =>  "امسح جميع البيانات من",
    "CLEAR_THIS_LOG"        =>  "امسح هذا السجل",
    "LOG_FILE_ENTRY"        =>  "إدخال ملف السجل",
    "THIS_COMPUTER"         =>  "هذا الكمبيوتر",

    /* 
     * For: backup-edit.php
    */
    "BAK_MANAGEMENT"        =>  "إدارة النسخ الاحتياطية",
    "ASK_CANCEL"            =>  "إلغاء", // المفتاح: 'c'
    "ASK_RESTORE"           =>  "استعادة", // المفتاح: 'r'
    "ASK_DELETE"            =>  "حذف", // المفتاح: 'd'
    "BACKUP_OF"             =>  "نسخة احتياطية من",
    "PAGE_TITLE"            =>  "عنوان الصفحة",
    "YES"                   =>  "نعم",
    "NO"                    =>  "لا",
    "DATE"                  =>  "التاريخ",
    "PERMS"                 =>  "الأذونات",

    /* 
     * For: components.php
    */
    "COMPONENTS"            =>  "المكونات",
    "DELETE_COMPONENT"      =>  "حذف المكون",
    "EDIT"                  =>  "تحرير",
    "ADD_COMPONENT"         =>  "إضافة مكون", // المفتاح: 'a'
    "SAVE_COMPONENTS"       =>  "حفظ المكونات",

    /* 
     * For: sitemap.php
    */
    "SITEMAP_CREATED"       =>  "تم إنشاء خريطة الموقع بنجاح! كما تم إعلام 4 محركات بحث بالتحديث",
    "SITEMAP_ERRORPING"     =>  "تم إنشاء خريطة الموقع، ولكن حدث خطأ أثناء إعلام محرك بحث واحد أو أكثر",
    "SITEMAP_ERROR"         =>  "تعذر إنشاء خريطة موقعك",
    "SITEMAP_WAIT"          =>  "<b>يرجى الانتظار:</b> جاري إنشاء خريطة الموقع",

    /* 
     * For: theme.php
    */
    "THEME_CHANGED"         =>  "تم تغيير القالب بنجاح",
    "CHOOSE_THEME"          =>  "اختر قالبك",
    "ACTIVATE_THEME"        =>  "تفعيل القالب",
    "THEME_SCREENSHOT"      =>  "لقطة شاشة للقالب",
    "THEME_PATH"            =>  "مسار مجلد القالب",

    /* 
     * For: resetpassword.php
    */
    "RESET_PASSWORD"        =>  "إعادة تعيين كلمة المرور",
    "YOUR_NEW"              =>  "كلمة المرور الجديدة الخاصة بك هي",
    "PASSWORD_IS"           =>  "كلمة المرور هي",
    "ATTEMPT"               =>  "محاولة",
    "MSG_PLEASE_EMAIL"      =>  "يرجى إدخال اسم المستخدم المسجل في هذا النظام، وسنرسل كلمة مرور جديدة إلى عنوان بريده الإلكتروني.",
    "SEND_NEW_PWD"          =>  "إرسال كلمة مرور جديدة",

    /* 
     * For: settings.php
    */
    "GENERAL_SETTINGS"      =>  "الإعدادات العامة",
    "WEBSITE_SETTINGS"      =>  "إعدادات الموقع",
    "LOCAL_TIMEZONE"        =>  "المنطقة الزمنية المحلية",
    "LANGUAGE"              =>  "اللغة",
    "USE_FANCY_URLS"        =>  "استخدام عناوين URL المزينة - <b style=\"font-weight:100\">يتطلب تفعيل <code>mod_rewrite</code> على الخادم</b>",
    "ENABLE_HTML_ED"        =>  "<b>تمكين محرر HTML</b>",
    "WARN_EMAILINVALID"     =>  "تحذير: يبدو أن عنوان البريد الإلكتروني غير صالح!",
    "ONLY_NEW_PASSWORD"     =>  "اكتب كلمة مرور جديدة فقط إذا كنت ترغب بتغيير الحالية",
    "NEW_PASSWORD"          =>  "كلمة المرور الجديدة",
    "CONFIRM_PASSWORD"      =>  "تأكيد كلمة المرور",
    "PASSWORD_NO_MATCH"     =>  "كلمتا المرور غير متطابقتين",
    "PERMALINK"             =>  "هيكل الرابط الدائم المخصص",
    "MORE"                  =>  "المزيد",
    "HELP"                  =>  "مساعدة",
    "FLUSHCACHE"            =>  "مسح كل ذاكرات التخزين المؤقت",
    "FLUSHCACHE-SUCCESS"    =>  "تم مسح ذاكرات التخزين المؤقت بنجاح",
    "DISPLAY_NAME"          =>  "اسم للعرض العام مختلف عن اسم المستخدم",

    /* 
     * For: health-check.php
    */
    "WEB_HEALTH_CHECK"      =>  "فحص صحة الموقع",
    "VERSION"               =>  "الإصدار",
    "UPG_NEEDED"            =>  "يوصى بالترقية",
    "CANNOT_CHECK"          =>  "فشل في التحقق من الترقية!",
    "LATEST_VERSION"        =>  "أحدث إصدار مثبت",
    "SERVER_SETUP"          =>  "إعداد الخادم",
    "OR_GREATER_REQ"        =>  "أو أعلى مطلوب",
    "OK"                    =>  "موافق",
    "INSTALLED"             =>  "مثبت",
    "NOT_INSTALLED"         =>  "غير مثبت",
    "WARNING"               =>  "تحذير",
    "DATA_FILE_CHECK"       =>  "فحص سلامة ملف البيانات",
    "DIR_PERMISSIONS"       =>  "أذونات الدليل",
    "EXISTANCE"             =>  "وجود %s",
    "MISSING_FILE"          =>  "ملف مفقود",
    "BAD_FILE"              =>  "ملف تالف",
    "NO_FILE"               =>  "لا يوجد ملف",
    "GOOD_D_FILE"           =>  "ملف 'Deny' جيد",
    "GOOD_A_FILE"           =>  "ملف 'Allow' جيد",
    "CANNOT_DEL_FILE"       =>  "تعذر حذف الملف",
    "DOWNLOAD"              =>  "تنزيل",
    "WRITABLE"              =>  "قابل للكتابة",
    "NOT_WRITABLE"          =>  "غير قابل للكتابة",

    /* 
     * For: footer.php
    */
    "POWERED_BY"            =>  "مدعوم من",

    /* 
     * For: backups.php
    */
    "PAGE_BACKUPS"          =>  "نسخ احتياطية للصفحة",
    "ASK_DELETE_ALL"        =>  "حذف الكل",
    "DELETE_ALL_BAK"        =>  "حذف كل النسخ الاحتياطية؟",
    "TOTAL_BACKUPS"         =>  "إجمالي النسخ الاحتياطية",

    /* 
     * For: archive.php
    */
    "SUCC_WEB_ARCHIVE"      =>  "تم إنشاء أرشيف لموقعك بنجاح",
    "SUCC_WEB_ARC_DEL"      =>  "تم حذف الأرشيف المحدد بنجاح",
    "WEBSITE_ARCHIVES"      =>  "أرشيفات الموقع",
    "ARCHIVE_DELETED"       =>  "تم حذف الأرشيف بنجاح",
    "CREATE_NEW_ARC"        =>  "إنشاء أرشيف جديد",
    "ASK_CREATE_ARC"        =>  "إنشاء أرشيف جديد الآن",
    "CREATE_ARC_WAIT"       =>  "<b>يرجى الانتظار:</b> جاري إنشاء أرشيف الموقع...",
    "DOWNLOAD_ARCHIVES"     =>  "تنزيل الأرشيف",
    "DELETE_ARCHIVE"        =>  "حذف الأرشيف",
    "TOTAL_ARCHIVES"        =>  "إجمالي الأرشيفات",

    /* 
     * For: include-nav.php
    */
    "WELCOME"               =>  "مرحباً", // يستخدم في 'مرحباً USERNAME!'
    "TAB_PAGES"             =>  "الصفحات",
    "TAB_FILES"             =>  "الملفات",
    "TAB_THEME"             =>  "القالب",
    "TAB_BACKUPS"           =>  "النسخ الاحتياطية",
    "PLUGINS_NAV"           =>  "الإضافات",
    "TAB_SETTINGS"          =>  "الإعدادات",
    "TAB_SUPPORT"           =>  "الدعم",
    "TAB_LOGOUT"            =>  "تسجيل الخروج",

    /* 
     * For: sidebar-files.php
    */
    "BROWSE_COMPUTER"       =>  "تصفح جهاز الكمبيوتر الخاص بك",
    "UPLOAD"                =>  "رفع",

    /* 
     * For: sidebar-support.php
    */
    "SIDE_SUPPORT_LOG"      =>  "الدعم",
    "SIDE_HEALTH_CHK"       =>  "فحص صحة الموقع",
    "SIDE_DOCUMENTATION"    =>  "توثيق الويكي",
    "SIDE_VIEW_LOG"         =>  "عرض السجل",

    /* 
     * For: sidebar-theme.php
    */
    "SIDE_VIEW_SITEMAP"     =>  "عرض خريطة الموقع",
    "SIDE_GEN_SITEMAP"      =>  "إنشاء خريطة الموقع",
    "SIDE_COMPONENTS"       =>  "تحرير المكونات",
    "SIDE_EDIT_THEME"       =>  "تحرير القالب",
    "SIDE_CHOOSE_THEME"     =>  "اختر القالب",

    /* 
     * For: sidebar-pages.php
    */
    "SIDE_CREATE_NEW"       =>  "إنشاء صفحة جديدة",
    "SIDE_VIEW_PAGES"       =>  "عرض كل الصفحات",

    /* 
     * For: sidebar-settings.php
    */
    "SIDE_GEN_SETTINGS"     =>  "الإعدادات العامة",
    "SIDE_USER_PROFILE"     =>  "الملف الشخصي للمستخدم",

    /* 
     * For: sidebar-backups.php
    */
    "SIDE_VIEW_BAK"         =>  "عرض نسخة احتياطية للصفحة",
    "SIDE_WEB_ARCHIVES"      =>  "أرشيفات الموقع",
    "SIDE_PAGE_BAK"         =>  "نسخ الصفحات الاحتياطية",

    /* 
     * For: error_checking.php
    */
    "ER_PWD_CHANGE"         =>  "لا تنسى <a href=\"settings.php#profile\">تغيير كلمة المرور</a> من تلك التي تم توليدها عشوائياً حاليًا...",
    "ER_BAKUP_DELETED"      =>  "تم حذف النسخة الاحتياطية لـ <b>%s</b>",
    "ER_REQ_PROC_FAIL"      =>  "فشل العملية المطلوبة",
    "ER_YOUR_CHANGES"       =>  "تم حفظ التغييرات لـ <b>%s</b>",
    "ER_HASBEEN_REST"       =>  "تم استعادة <b>%s</b>",
    "ER_HASBEEN_DEL"        =>  "تم حذف <b>%s</b>",
    "ER_CANNOT_INDEX"       =>  "لا يمكنك تغيير عنوان صفحة الفهرس",
    "ER_SETTINGS_UPD"       =>  "تم تحديث إعداداتك",
    "ER_OLD_RESTORED"       =>  "تم استعادة الإعدادات القديمة الخاصة بك",
    "ER_NEW_PWD_SENT"       =>  "تم إرسال كلمة مرور جديدة إلى عنوان البريد الإلكتروني المقدم",
    "ER_SENDMAIL_ERR"       =>  "حدثت مشكلة أثناء إرسال البريد الإلكتروني. يرجى المحاولة مرة أخرى",
    "ER_FILE_DEL_SUC"       =>  "تم حذف الملف بنجاح",
    "ER_PROBLEM_DEL"        =>  "حدثت مشكلة أثناء حذف الملف",
    "ER_COMPONENT_SAVE"     =>  "تم حفظ المكونات الخاصة بك",
    "ER_COMPONENT_REST"     =>  "تم استعادة المكونات الخاصة بك",
    "ER_CANCELLED_FAIL"     =>  "<b>أُلغيت:</b> تم إلغاء هذا التحديث",

    /* 
     * For: changedata.php
    */
    "CANNOT_SAVE_EMPTY"     =>  "لا يمكنك حفظ صفحة بعنوان فارغ",
    "META_DESC"             =>  "الوصف التعريفي",

    /* 
     * For: template_functions.php
    */
    "FTYPE_COMPRESSED"      =>  "مضغوط", // نوع ملف
    "FTYPE_VECTOR"          =>  "متجه", // نوع ملف
    "FTYPE_FLASH"           =>  "فلاش", // نوع ملف
    "FTYPE_VIDEO"           =>  "فيديو", // نوع ملف
    "FTYPE_AUDIO"           =>  "صوت", // نوع ملف
    "FTYPE_WEB"             =>  "ويب", // نوع ملف
    "FTYPE_DOCUMENTS"       =>  "مستندات", // نوع ملف
    "FTYPE_SYSTEM"          =>  "النظام", // نوع ملف
    "FTYPE_MISC"            =>  "متنوع", // نوع ملف
    "IMAGES"                =>  "الصور",

    /* 
     * For: login_functions.php
    */
    "FILL_IN_REQ_FIELD"     =>  "يرجى ملء جميع الحقول المطلوبة",
    "LOGIN_FAILED"          =>  "فشل تسجيل الدخول. يرجى التحقق من اسم المستخدم وكلمة المرور",

    /* 
     * For: Date Format
    */
    "DATE_FORMAT"           =>  "M j, Y", // يجب أن يكون قصيراً
    "DATE_AND_TIME_FORMAT"  =>  "F jS, Y - g:i A", // التاريخ والوقت

    /* 
     * For: support.php
    */
    "WELCOME_MSG"           =>  "شكراً لاختيارك GetSimple كنظام إدارة المحتوى الخاص بك!",
    "WELCOME_P"             =>  "يجعل GetSimple إدارة الموقع بسيطة بقدر الإمكان بفضل واجهة المستخدم الرائعة الخاصة به. نسعى لجعل النظام سهل الاستخدام لأي شخص، ومع ذلك قوي بما يكفي للمطور لتفعيل جميع الميزات المطلوبة.</p><p><strong>بعض الخطوات الأولية التي قد تكون مفيدة:</strong></p>",
    "GETTING_STARTED"       =>  "ابدأ الآن",

    /* 
     * For: image.php
    */
    "CURRENT_THUMBNAIL"     =>  "الصورة المصغرة الحالية",
    "RECREATE"              =>  "إعادة إنشاء",
    "CREATE_ONE"            =>  "إنشاء واحدة",
    "IMG_CONTROl_PANEL"     =>  "لوحة التحكم بالصور",
    "ORIGINAL_IMG"          =>  "الصورة الأصلية",
    "CLIPBOARD_INSTR"       =>  "تحديد الكل",
    "CREATE_THUMBNAIL"      =>  "إنشاء الصورة المصغرة",
    "CROP_INSTR_NEW"        =>  "<em>ctrl-B</em> أو <em>command-B</em> لمربع",
    "SELECT_DIMENTIONS"     =>  "أبعاد الاختيار",
    "HTML_ORIG_IMG"         =>  "HTML الصورة الأصلية",
    "LINK_ORIG_IMG"         =>  "رابط الصورة الأصلية",
    "HTML_THUMBNAIL"        =>  "HTML الصورة المصغرة",
    "LINK_THUMBNAIL"        =>  "رابط الصورة المصغرة",
    "HTML_THUMB_ORIG"       =>  "HTML تحويل الصورة المصغرة إلى الصورة الأصلية",

    /* 
     * For: plugins.php
    */
    "PLUGINS_MANAGEMENT"    =>  "إدارة الإضافات",
    "PLUGINS_MANAGEMENT_INFO" => "قد تتطلب بعض الإضافات سكربتات js/css إضافية لتعمل بشكل صحيح.<br>تأكد من تفعيل إضافة 'modernScript CE' والتحقق من الإعدادات.",
    "PLUGINS_INSTALLED"     =>  "الإضافات المثبتة",
    "PLUGIN_DISABLED"       =>  "إضافة معطلة",
    "SHOW_PLUGINS"          =>  "الإضافات المثبتة",
    "PLUGIN_NAME"           =>  "الإضافة",
    "PLUGIN_DESC"           =>  "الوصف",
    "PLUGIN_VER"            =>  "الإصدار",
    "PLUGIN_UPDATED"        =>  "تم تحديث الإضافة",

    /***********************************************************************************
     * منذ الإصدار 3.0
    ***********************************************************************************/

    /* 
     * For: setup.php
    */
    "ROOT_HTACCESS_ERROR"   =>  "فشل إنشاء .htaccess في الدليل الجذر! يرجى نسخ <code>%s</code> إلى <code>.htaccess</code> وتغيير <code>%s</code> إلى <code>%s</code>",
    "REMOVE_TEMPCONFIG_ERROR" => "فشل إزالة <code>%s</code>! يرجى القيام بذلك يدوياً.",
    "MOVE_TEMPCONFIG_ERROR"   => "فشل إعادة تسمية <code>%s</code> إلى <code>%s</code>! يرجى القيام بذلك يدوياً.",
    "KILL_CANT_CONTINUE"      => "لا يمكن المتابعة. يرجى إصلاح الأخطاء والمحاولة مرة أخرى.",
    "REFRESH"                 => "تحديث",
    "BETA"                    => "بيتا / الإصدار التجريبي",

    /*
     * أعمال التنظيف المتنوعة
     */
    # جديد في 3.0 
    "HOMEPAGE_DELETE_ERROR"   => "لا يمكنك حذف الصفحة الرئيسية", // حذف ملف
    "NO_ZIPARCHIVE"           => "امتداد ZipArchive غير مثبت. لا يمكن المتابعة", // zip
    "REDIRECT_MSG"            => "إذا لم يقم المتصفح بإعادة التوجيه، اضغط <a href=\"%s\">هنا</a>", // بسيط
    "REDIRECT"                => "إعادة توجيه", // بسيط
    "DENIED"                  => "مرفوض", // خريطة الموقع
    "DEBUG_MODE"              => "وضع التصحيح", // nav-include
    "DOUBLE_CLICK_EDIT"       => "انقر نقرتين لتحرير", // المكونات
    "THUMB_SAVED"             => "تم حفظ الصورة المصغرة", // image
    "EDIT_COMPONENTS"         => "تحرير المكونات", // components
    "REQS_MORE_INFO"          => "لمزيد من المعلومات حول الوحدات المطلوبة، قم بزيارة <a href=\"%s\" target=\"_blank\" >صفحة المتطلبات</a>.", // install & health-check
    "SYSTEM_UPDATE"           => "تحديث النظام", // update.php
    "AUTHOR"                  => "المؤلف", // plugins.php
    "ENABLE"                  => "تفعيل", // plugins.php
    "DISABLE"                 => "تعطيل", // plugins.php
    "NO_THEME_SCREENSHOT"     => "لا يحتوي قالبك على معاينة لالتقاط الشاشة", // theme.php
    "UNSAVED_INFORMATION"     => "أنت على وشك مغادرة هذه الصفحة وستفقد أية معلومات غير محفوظة.", // edit.php
    "BACK_TO_WEBSITE"         => "العودة للموقع", // index & resetpassword
    "SUPPORT_FORUM"           => "منتدى الدعم", // support.php
    "FILTER"                  => "تصفية", // pages.php
    "UPLOADIFY_BUTTON"        => "رفع ملفات و/أو صور...", // upload.php
    "FILE_BROWSER"            => "متصفح الملفات", // filebrowser.php
    "SELECT_FILE"             => "اختر الملف", // filebrowser.php
    "CREATE_FOLDER"           => "إنشاء مجلد", // upload.php
    "THUMBNAIL"               => "الصورة المصغرة", // filebrowser.php
    "ERROR_FOLDER_EXISTS"     => "المجلد الذي تحاول إنشاءه موجود بالفعل", // upload.php
    "FOLDER_CREATED"          => "تم إنشاء المجلد الجديد بنجاح: <b>%s</b>", // upload.php
    "ERROR_CREATING_FOLDER"   => "حدث خطأ أثناء إنشاء المجلد الجديد", // upload.php
    "DELETE_FOLDER"           => "حذف المجلد", // upload.php
    "FILE_NAME"               => "اسم الملف", // رؤوس أعمدة متعددة
    "FILE_SIZE"               => "الحجم", // رؤوس أعمدة متعددة
    "ARCHIVE_DATE"            => "تاريخ الأرشيف", // archive.php
    "CKEDITOR_LANG"           => "en", // edit.php ؛ ضبط لغة CKEditor، لا تنسى تضمين ملف لغة CKEditor في حزمة الترجمة

    # جديد في 3.1 
    "XML_INVALID"             => "XML غير صالح", // template-functions.php
    "XML_VALID"               => "XML صالح",
    "UPDATE_AVAILABLE"        => "تحديث إلى", // plugins.php
    "STATUS"                  => "الحالة", // plugins.php
    "CLONE"                   => "استنساخ", // edit.php
    "CLONE_SUCCESS"           => "تم إنشاء %s بنجاح", // pages.php
    "COPY"                    => "نسخ", // pages.php
    "CLONE_ERROR"             => "حدثت مشكلة أثناء محاولة استنساخ <b>%s</b>",  // pages.php
    "AUTOSAVE_NOTIFY"         => "تم الحفظ التلقائي للصفحة في", // edit.php
    "MENU_MANAGER"            => "مدير القائمة", // edit.php
    "GET_PLUGINS_LINK"        => "تنزيل المزيد من الإضافات",
    "SITEMAP_REFRESHED"       => "تم تحديث خريطة الموقع", // edit.php
    "LOG_FILE_EMPTY"          => "ملف السجل فارغ", // log.php
    "SHARE"                   => "مشاركة", // footer.php
    "NO_PARENT"               => "لا يوجد صفحة أم", // edit.php
    "REMAINING"               => "الأحرف المتبقية", // edit.php
    "NORMAL"                  => "عادي", // edit.php
    "ERR_CANNOT_DELETE"       => "لا يمكن حذف %s. الرجاء القيام بذلك يدويًا.", // common.php
    "ADDITIONAL_ACTIONS"      => "إجراءات أخرى", // edit.php
    "ITEMS"                   => "عناصر", // upload.php
    "SAVE_MENU_ORDER"         => "حفظ ترتيب القائمة", // menu-manager.php
    "MENU_MANAGER_DESC"       => "اسحب وأفلت عناصر القائمة حتى تحصل على الترتيب المطلوب، ثم اضغط على زر <strong>'حفظ ترتيب القائمة'</strong>.", // menu-manager.php
    "MENU_MANAGER_SUCCESS"    => "تم حفظ ترتيب القائمة الجديد", // menu-manager.php

    /* 
     * For: api related pages
     */
    "API_ERR_MISSINGPARAM"    => "بيانات المعامل غير موجودة",
    "API_ERR_BADMETHOD"       => "الطريقة %s غير موجودة",
    "API_ERR_AUTHFAILED"      => "فشل التوثيق",
    "API_ERR_AUTHDISABLED"    => "تم تعطيل التوثيق",
    "API_ERR_NOPAGE"          => "الصفحة %s المطلوبة غير موجودة",
    "API_CONFIGURATION"       => "إعدادات الـ API",
    "API_ENABLE"              => "تفعيل الـ API",
    "API_REGENKEY"            => "إعادة توليد المفتاح",
    "API_DISCLAIMER"          => "بتمكين هذا الـ API، أنت تسمح لأي تطبيق خارجي يحمل نسختك من المفتاح بالوصول إلى بيانات موقعك. <b>شارك هذا المفتاح فقط مع التطبيقات التي تثق بها.</b>",
    "API_REGEN_DISCLAIMER"    => "عند إعادة توليد مفتاح الـ API، ستحتاج إلى إدخال المفتاح الجديد في أي تطبيق خارجي يستخدم هذا الـ API للاتصال بموقعك.",
    "API_CONFIRM"             => "هل أنت متأكد؟",
	
	// salt-shaker
	"Security_Generator" 	=> 'مولد أمان CE للملح/التجزئة',
	"More_info" 			=> 'معلومات أكثر متوفرة في',
	"Wiki" 					=> 'ويكي',
	"Security_Notice" 		=> 'تنبيه أمني',
	"Tokens_are_never" 		=> 'لا يتم عرض الرموز مطلقًا ويتم مسحها فورًا بعد المعالجة.',
	"Password_Hash" 		=> 'تجزئة كلمة المرور',
	"Custom_Salt_Hash" 		=> 'تجزئة الملح المخصص',
	"Password_Hashing" 		=> 'تجزئة كلمة المرور',
	"Used_to_enhance" 		=> 'يستخدم لتعزيز أمان كلمة مرور المستخدم. ستحتاج إلى إعادة تعيين جميع كلمات المرور بمجرد إضافة هذا.',
	"Password_Token" 		=> 'رمز كلمة المرور',
	"Any_word" 				=> 'أي كلمة تختارها...',
	"Random_string" 		=> 'سلسلة عشوائية تتضمن أحرفًا ورموزًا...',
	"System_Salt" 			=> 'ملح النظام',
	"Generate" 				=> 'توليد',
	"Security_Hashing" 		=> 'تجزئة الأمان',
	"enhance_system_wide" 	=> 'يستخدم لتعزيز الأمان على مستوى النظام، بما في ذلك:',
	"temporary_files" 		=> 'ملفات تعريف الارتباط/الملفات المؤقتة، إعادة تعيين الجلسة، حماية CSRF، تحميل الملفات، إلخ.',
	"Input_Token" 			=> 'رمز الإدخال',
	"Application_Salt" 		=> 'ملح التطبيق',
	"Generate_Hashes" 		=> 'توليد التجزئات',
	"Password_Hash_Results" => 'نتائج تجزئة كلمة المرور',
	"hidden" 				=> 'مخفي',
	"SHA1_of_Salt" 			=> 'SHA1 من الملح',
	"Your_Hash" 			=> 'تجزئة \'GSLOGINSALT\' الخاصة بك',
	"hash_copied" 			=> 'تم نسخ التجزئة!',
	"Remain_logged" 		=> 'ابقَ مسجلاً الدخول في حساب المسؤول الخاص بك.',
	"Add_hash_GSLOGINSALT" 	=> 'أضف التجزئة الجديدة إلى حقل \'GSLOGINSALT\' في gsconfig.php.',
	"Update_all" 			=> 'تحديث جميع كلمات مرور المستخدمين.',
	"Custom_Salt" 			=> 'نتائج تجزئة الملح المخصص',
	"SHA1_of_Application" 	=> 'SHA1 من ملح التطبيق',
	"Your_Custome_Hash" 	=> 'تجزئة \'GSUSECUSTOMSALT\' الخاصة بك',
	"Add_hash_GSUSECUSTOMSALT" 	=> 'أضف التجزئة الجديدة إلى حقل \'GSUSECUSTOMSALT\' في gsconfig.php.',
	"Clear_cookies" 		=> 'مسح ملفات تعريف الارتباط.',

    /*
     * التحويل الحرفي الافتراضي
     */
    "TRANSLITERATION"         => [
        // الحروف الرومانية
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
        // أحرف تشيكية خاصة مع تأثير النبر (باستثناء بعضها)
        "ě"=>"e","Ě"=>"E","š"=>"s","Š"=>"S","č"=>"c",
        "Č"=>"c","ř"=>"r","Ř"=>"r","ž"=>"z","Ž"=>"z",
        "ý"=>"y","Ý"=>"y",
        "ů"=>"u","Ů"=>"u","ť"=>"t","Ť"=>"t",
        "ď"=>"d","Ď"=>"d","ň"=>"n","Ň"=>"n",
        // أحرف سلوفاكية خاصة مع تأثير النبر (باستثناء بعضها)
        "ĺ"=>"l","ľ"=>"l","ŕ"=>"r", 
        "Ĺ"=>"l","Ľ"=>"L","Ŕ"=>"r",
        // البولندية
        "Ą"=>"a","Ć"=>"c","Ę"=>"e",
        "Ł"=>"L","Ń"=>"N","Ó"=>"O",
        "Ś"=>"s","Ź"=>"z","Ż"=>"z",
        "ą"=>"a","ć"=>"c","ę"=>"e",
        "ł"=>"l","ń"=>"n","ó"=>"o",
        "ś"=>"s","ź"=>"z","ż"=>"z",
        // الروسية
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
	"DEBUG_CONSOLE" 		=> 'Debug Console',

];

?>