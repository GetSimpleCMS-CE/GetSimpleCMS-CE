<?php 
/**
 * Settings
 *
 * Displays and changes website settings 
 *
 * @package GetSimple
 * @subpackage Settings
 */

# setup inclusions
$load['plugin'] = true;
include('inc/common.php');

# variable settings
login_cookie_check();
$fullpath = suggest_site_path();
$file     = _id($USR) . '.xml';
$wfile    = 'website.xml';

if (defined('GSDATABASE') && GSDATABASE == 'sqlite3' && function_exists('gs_db')) {
$u = gs_db()->escapeString(strtolower((string)($USR ?? '')));

$row = gs_db()->querySingle("SELECT username, password, email, name, htmleditor, timezone, lang FROM users WHERE LOWER(username) = '$u' LIMIT 1", true);
    if ($row) {
        $USR        = stripslashes($row['username']);
        $PASSWD     = $row['password']    ?? '';
        $EMAIL      = $row['email']       ?? '';
        $NAME       = $row['name']        ?? '';
        $HTMLEDITOR = $row['htmleditor']  ?? '';
        $TIMEZONE   = $row['timezone']    ?? '';
        $LANG       = $row['lang']        ?? 'en_US';
    } else {
        $PASSWD = $EMAIL = $NAME = $HTMLEDITOR = $TIMEZONE = '';
        $LANG   = 'en_US';
    }
} else {
    $data   = getXML(GSUSERSPATH . $file);
    $USR    = stripslashes($data->USR);
    $PASSWD = $data->PWD;
    $EMAIL  = $data->EMAIL  ?? '';
    $NAME   = $data->NAME   ?? '';
    $HTMLEDITOR = $data->HTMLEDITOR ?? '';
    $TIMEZONE   = $data->TIMEZONE   ?? '';
    $LANG       = $data->LANG       ?? 'en_US';
}

$lang_array = getFiles(GSLANGPATH);

# initialize these all as null
$pwd1 = $error = $success = $pwd2 = $editorchck = $prettychck = null;

# if the flush cache command was invoked
if (isset($_GET['flushcache'])) {
    delete_cache();
    foreach (['plugin_db.json', 'plugin-update.trigger'] as $cf) {
        $cp = GSCACHEPATH . $cf;
        if (file_exists($cp)) unlink($cp);
    }
    foreach (glob(GSCACHEPATH . 'update_info_*.html') as $ufile) {
        unlink($ufile);
    }
    $update = 'flushcache-success';
}

# if the undo command was invoked
if (isset($_GET['undo'])) {
    if (!defined('GSNOCSRF') || GSNOCSRF == FALSE) {
        $nonce = $_GET['nonce'];
        if (!check_nonce($nonce, "undo")) die("CSRF detected!");
    }
    undo($file, GSUSERSPATH, GSBACKUSERSPATH);
    undo($wfile, GSDATAOTHERPATH, GSBACKUPSPATH . 'other/');
    generate_sitemap();
    redirect('settings.php?restored=true');
}

if (isset($_GET['restored'])) {
    $restored = 'true';
} else {
    $restored = 'false';
}

# ===================== USER MANAGEMENT =====================

// --- DELETE USER ---
if (isset($_POST['delete_user'])) {
    if (!defined('GSNOCSRF') || GSNOCSRF == FALSE) {
        if (!check_nonce($_POST['nonce'], "save_settings")) die("CSRF detected!");
    }
    $del_usr = strtolower(trim($_POST['delete_username']));
    $cur_usr = strtolower($USR);
    if ($del_usr === $cur_usr) {
        $error = 'You cannot delete the currently logged-in user.';
    } else {
        if (defined('GSDATABASE') && GSDATABASE == 'sqlite3' && function_exists('gs_db')) {
            $del_safe = gs_db()->escapeString($del_usr);
            gs_db()->exec("DELETE FROM users WHERE LOWER(username) = '$del_safe'");
        } else {
            $del_file = GSUSERSPATH . _id($del_usr) . '.xml';
            if (file_exists($del_file)) unlink($del_file);
        }
        $success = 'User has been deleted.';
    }
}

// --- ADD USER ---
if (isset($_POST['add_user'])) {
    if (!defined('GSNOCSRF') || GSNOCSRF == FALSE) {
        if (!check_nonce($_POST['nonce'], "save_settings")) die("CSRF detected!");
    }
    $new_usr  = strtolower(trim(var_out($_POST['new_username'] ?? '')));
    $new_name = var_out($_POST['new_name'] ?? '');
    $new_email= var_out($_POST['new_email'] ?? '', 'email');
    $new_pwd  = $_POST['new_password'] ?? '';
    $new_lang = var_out($_POST['new_lang'] ?? 'en_US');

    if (empty($new_usr) || empty($new_pwd)) {
        $error = 'Username and password are required.';
    } else {
        $user_exists = false;
        if (defined('GSDATABASE') && GSDATABASE == 'sqlite3' && function_exists('gs_db')) {
            $nu_safe = gs_db()->escapeString($new_usr);
            $user_exists = (bool) gs_db()->querySingle("SELECT id FROM users WHERE LOWER(username) = '$nu_safe'");
        } else {
            $user_exists = file_exists(GSUSERSPATH . _id($new_usr) . '.xml');
        }

        if ($user_exists) {
            $error = 'A user with that username already exists.';
        } else {
            $hashed = passhash($new_pwd);
            if (defined('GSDATABASE') && GSDATABASE == 'sqlite3' && function_exists('gs_db')) {
                $nu_safe = gs_db()->escapeString($new_usr);
                $nn_safe = gs_db()->escapeString($new_name);
                $np_safe = gs_db()->escapeString($hashed);
                $ne_safe = gs_db()->escapeString($new_email);
                $nl_safe = gs_db()->escapeString($new_lang);
                $ok = gs_db()->exec("INSERT INTO users (username, name, password, email, lang, htmleditor, timezone)
                                     VALUES ('$nu_safe','$nn_safe','$np_safe','$ne_safe','$nl_safe','','')");
                if ($ok) { $success = 'User has been added.'; } else { $error = 'Error while adding user.'; }
            } else {
                $xml_new = new SimpleXMLExtended('<?xml version="1.0" encoding="UTF-8"?><item></item>');
                $xml_new->addChild('USR', $new_usr);
                $xml_new->addChild('NAME', $new_name);
                $xml_new->addChild('PWD', $hashed);
                $xml_new->addChild('EMAIL', $new_email);
                $xml_new->addChild('HTMLEDITOR', '');
                $xml_new->addChild('TIMEZONE', '');
                $xml_new->addChild('LANG', $new_lang);
                if (XMLsave($xml_new, GSUSERSPATH . _id($new_usr) . '.xml')) {
                    $success = 'User has been added.';
                } else {
                    $error = 'Error while saving user file.';
                }
            }
        }
    }
}

// --- EDIT OTHER USER ---
if (isset($_POST['edit_user'])) {
    if (!defined('GSNOCSRF') || GSNOCSRF == FALSE) {
        if (!check_nonce($_POST['nonce'], "save_settings")) die("CSRF detected!");
    }
    $edit_usr   = strtolower(trim($_POST['edit_username'] ?? ''));
    $edit_name  = var_out($_POST['edit_name'] ?? '');
    $edit_email = var_out($_POST['edit_email'] ?? '', 'email');
    $edit_lang  = var_out($_POST['edit_lang'] ?? 'en_US');
    $edit_pwd   = $_POST['edit_password'] ?? '';

    if (defined('GSDATABASE') && GSDATABASE == 'sqlite3' && function_exists('gs_db')) {
        $eu_safe = gs_db()->escapeString($edit_usr);
        $en_safe = gs_db()->escapeString($edit_name);
        $ee_safe = gs_db()->escapeString($edit_email);
        $el_safe = gs_db()->escapeString($edit_lang);
        $upd = "UPDATE users SET name='$en_safe', email='$ee_safe', lang='$el_safe'";
        if (!empty($edit_pwd)) {
            $ep_safe = gs_db()->escapeString(passhash($edit_pwd));
            $upd .= ", password='$ep_safe'";
        }
        $upd .= " WHERE LOWER(username) = '$eu_safe'";
        gs_db()->exec($upd);
    } else {
        $edit_file = GSUSERSPATH . _id($edit_usr) . '.xml';
        if (file_exists($edit_file)) {
            $xedit = getXML($edit_file);
            $xedit->NAME  = $edit_name;
            $xedit->EMAIL = $edit_email;
            $xedit->LANG  = $edit_lang;
            if (!empty($edit_pwd)) $xedit->PWD = passhash($edit_pwd);
            XMLsave($xedit, $edit_file);
        }
    }
    $success = 'User settings have been updated.';
}

// --- LOAD USER LIST ---
$all_users = [];
if (defined('GSDATABASE') && GSDATABASE == 'sqlite3' && function_exists('gs_db')) {
    $ures = gs_db()->query("SELECT username, name, email, lang FROM users ORDER BY username");
    while ($ur = $ures->fetchArray(SQLITE3_ASSOC)) {
        $all_users[] = $ur;
    }
} else {
    $ufiles = getFiles(GSUSERSPATH);
    foreach ($ufiles as $ufile) {
        if (substr($ufile, -4) !== '.xml') continue;
        $ud = getXML(GSUSERSPATH . $ufile);
        if ($ud) {
            $all_users[] = [
                'username' => (string) $ud->USR,
                'name'     => (string) $ud->NAME,
                'email'    => (string) $ud->EMAIL,
                'lang'     => (string) $ud->LANG,
            ];
        }
    }
}

# ===================== END USER MANAGEMENT =====================

# was the main settings form submitted?
if (isset($_POST['submitted'])) {
    if (!defined('GSNOCSRF') || GSNOCSRF == FALSE) {
        $nonce = $_POST['nonce'];
        if (!check_nonce($nonce, "save_settings")) die("CSRF detected!");
    }

    if (isset($_POST['sitename']))   { $SITENAME   = htmlentities($_POST['sitename'], ENT_QUOTES, 'UTF-8'); }
    if (isset($_POST['siteurl']))    { $SITEURL    = tsl($_POST['siteurl']); }
    if (isset($_POST['permalink']))  { $PERMALINK  = trim($_POST['permalink']); }
    if (isset($_POST['template']))   { $TEMPLATE   = $_POST['template']; }
    $PRETTYURLS = isset($_POST['prettyurls']) ? $_POST['prettyurls'] : '';

    $USR = strtolower($USR ?? '');
    if (isset($_POST['name']))           { $NAME       = $_POST['name']; }
    if (isset($_POST['email']))          { $EMAIL      = $_POST['email']; }
    if (isset($_POST['timezone']))       { $TIMEZONE   = var_out($_POST['timezone']); }
    if (isset($_POST['lang']))           { $LANG       = var_out($_POST['lang']); }
    $HTMLEDITOR = isset($_POST['show_htmleditor']) ? var_out($_POST['show_htmleditor']) : '';

    if (isset($_POST['sitepwd']))         { $pwd1 = $_POST['sitepwd']; }
    if (isset($_POST['sitepwd_confirm'])) { $pwd2 = $_POST['sitepwd_confirm']; }

    if ($pwd1 != $pwd2 && $pwd2 != '') {
        $error = i18n_r('PASSWORD_NO_MATCH');
    } else {
        if ($pwd1 != '' && $pwd2 != '') { $PASSWD = passhash($pwd1); }

        if (!in_array($LANG . '.php', $lang_array) && !in_array($LANG . '.PHP', $lang_array)) die();

        exec_action('settings-user');

        if (defined('GSDATABASE') && GSDATABASE == 'sqlite3' && function_exists('gs_db')) {
            $u  = gs_db()->escapeString(strtolower($USR));
            $n  = gs_db()->escapeString(var_out($NAME));
            $p  = gs_db()->escapeString($PASSWD);
            $e  = gs_db()->escapeString(var_out($EMAIL, 'email'));
            $he = gs_db()->escapeString($HTMLEDITOR);
            $tz = gs_db()->escapeString($TIMEZONE);
            $lg = gs_db()->escapeString($LANG);
            $ok = gs_db()->exec("UPDATE users SET name='$n', password='$p', email='$e', htmleditor='$he', timezone='$tz', lang='$lg' WHERE LOWER(username)='$u'");
            if (!$ok) { $error = i18n_r('CHMOD_ERROR'); }
        } else {
            createBak($file, GSUSERSPATH, GSBACKUSERSPATH);
            if (file_exists(GSUSERSPATH . _id($USR) . '.xml.reset')) unlink(GSUSERSPATH . _id($USR) . '.xml.reset');
            $xml = new SimpleXMLExtended('<?xml version="1.0" encoding="UTF-8"?><item></item>');
            $xml->addChild('USR', $USR);
            $xml->addChild('NAME', var_out($NAME));
            $xml->addChild('PWD', $PASSWD);
            $xml->addChild('EMAIL', var_out($EMAIL, 'email'));
            $xml->addChild('HTMLEDITOR', $HTMLEDITOR);
            $xml->addChild('TIMEZONE', $TIMEZONE);
            $xml->addChild('LANG', $LANG);
            if (!XMLsave($xml, GSUSERSPATH . $file)) { $error = i18n_r('CHMOD_ERROR'); }
        }

        exec_action('settings-website');

        if (defined('GSDATABASE') && GSDATABASE == 'sqlite3' && function_exists('gs_db')) {
            $settings = [
                'sitename'   => gs_db()->escapeString($SITENAME),
                'siteurl'    => gs_db()->escapeString($SITEURL),
                'template'   => gs_db()->escapeString($TEMPLATE),
                'prettyurls' => gs_db()->escapeString($PRETTYURLS),
                'permalink'  => gs_db()->escapeString(var_out($PERMALINK)),
            ];
            foreach ($settings as $key => $val) {
                gs_db()->exec("INSERT INTO settings (key, value, updated_at)
                                   VALUES ('$key', '$val', datetime('now'))
                               ON CONFLICT(key) DO UPDATE SET
                                   value      = '$val',
                                   updated_at = datetime('now')");
            }
        } else {
            createBak($wfile, GSDATAOTHERPATH, GSBACKUPSPATH . 'other/');
            $xmls = new SimpleXMLExtended('<?xml version="1.0" encoding="UTF-8"?><item></item>');
            $note = $xmls->addChild('SITENAME'); $note->addCData($SITENAME);
            $note = $xmls->addChild('SITEURL');  $note->addCData($SITEURL);
            $note = $xmls->addChild('TEMPLATE'); $note->addCData($TEMPLATE);
            $xmls->addChild('PRETTYURLS', $PRETTYURLS);
            $xmls->addChild('PERMALINK', var_out($PERMALINK));
            if (!XMLsave($xmls, GSDATAOTHERPATH . $wfile)) { $error = i18n_r('CHMOD_ERROR'); }
        }

        include(GSLANGPATH . $LANG . '.php');

        if (!$error) {
            $success = i18n_r('ER_SETTINGS_UPD') . '. <a href="settings.php?undo&nonce=' . get_nonce("undo") . '">' . i18n_r('UNDO') . '</a>';
            generate_sitemap();
        }
    }
}

if ($HTMLEDITOR != '') { $editorchck = 'checked'; }
if ($PRETTYURLS != '')  { $prettychck = 'checked'; }
if ($LANG == '')        { $LANG = 'en_US'; }

if (count($lang_array) != 0) {
    sort($lang_array);
    $sel = ''; $langs = '';
    foreach ($lang_array as $lfile) {
        $lfile = basename($lfile, ".php");
        if ($LANG == $lfile) { $sel = "selected"; }
        $langs .= '<option ' . $sel . ' value="' . $lfile . '" >' . $lfile . '</option>';
        $sel = '';
    }
} else {
    $langs = '<option value="" selected="selected" >-- ' . i18n_r('NONE') . ' --</option>';
}

get_template('header', cl($SITENAME) . ' &raquo; ' . i18n_r('GENERAL_SETTINGS'));
?>

<?php include('template/include-nav.php'); ?>

<div class="bodycontent clearfix">

    <div id="maincontent">
        <form class="largeform" action="<?php myself(); ?>" method="post" accept-charset="utf-8">
        <input id="nonce" name="nonce" type="hidden" value="<?php echo get_nonce("save_settings"); ?>" />

        <div class="main">
        <h3><?php i18n('WEBSITE_SETTINGS'); ?></h3>

        <div class="leftsec">
            <p><label for="sitenameinput"><?php i18n('LABEL_WEBSITE'); ?>:</label>
            <input class="text" id="sitenameinput" name="sitename" type="text"
                   value="<?php echo stripslashes(isset($SITENAME1) ? $SITENAME1 : $SITENAME); ?>" /></p>
        </div>
        <div class="rightsec">
            <p><label for="siteurl"><?php i18n('LABEL_BASEURL'); ?>:</label>
            <input class="text" id="siteurl" name="siteurl" type="url"
                   value="<?php echo isset($SITEURL1) ? $SITEURL1 : $SITEURL; ?>" /></p>
            <?php if ($fullpath != $SITEURL) {
                echo '<p style="margin:-15px 0 20px 0;color:#D94136;font-size:11px;">' . i18n_r('LABEL_SUGGESTION') . ': &nbsp; <code>' . $fullpath . '</code></p>';
            } ?>
        </div>
        <div class="clear"></div>

        <p class="inline"><input name="prettyurls" id="prettyurls" type="checkbox" value="1" <?php echo $prettychck; ?> />
        &nbsp;<label for="prettyurls"><?php i18n('USE_FANCY_URLS'); ?></label></p>

        <div class="leftsec">
            <p><label for="permalink" class="clearfix"><?php i18n('PERMALINK'); ?>:
            <span class="right"><a href="https://github.com/GetSimpleCMS-CE/GetSimpleCMS-CE/wiki/Settings" target="_blank"><?php i18n('MORE'); ?></a></span></label>
            <input class="text" name="permalink" id="permalink" type="text" placeholder="%parent%/%slug%/"
                   value="<?php if (isset($PERMALINK)) echo var_out($PERMALINK); ?>" /></p>
            <a id="flushcache" class="button" href="?flushcache"><?php i18n('FLUSHCACHE'); ?></a>
        </div>
        <div class="clear"></div>

        <?php exec_action('settings-website-extras'); ?>

        <div id="profile" class="section">
        <h3><?php i18n('SIDE_USER_PROFILE'); ?></h3>
        <div class="leftsec">
            <p><label for="user"><?php i18n('LABEL_USERNAME'); ?>:</label>
            <input class="text" id="user" name="user" type="text" readonly
                   value="<?php echo $USR; ?>" /></p>
        </div>
        <div class="rightsec">
            <p><label for="email"><?php i18n('LABEL_EMAIL'); ?>:</label>
            <input class="text" id="email" name="email" type="email"
                   value="<?php echo isset($EMAIL1) ? $EMAIL1 : var_out($EMAIL, 'email'); ?>" /></p>
            <?php if (!check_email_address($EMAIL)) {
                echo '<p style="margin:-15px 0 20px 0;color:#D94136;font-size:11px;">' . i18n_r('WARN_EMAILINVALID') . '</p>';
            } ?>
        </div>
        <div class="clear"></div>
        <div class="leftsec">
            <p><label for="name"><?php i18n('LABEL_DISPNAME'); ?>:</label>
            <span style="margin:0px 0 5px 0;font-size:12px;color:#999;"><?php i18n('DISPLAY_NAME'); ?></span>
            <input class="text" id="name" name="name" type="text"
                   value="<?php echo isset($NAME1) ? $NAME1 : var_out($NAME); ?>" /></p>
        </div>
        <div class="clear"></div>
        <div class="leftsec">
            <p><label for="timezone"><?php i18n('LOCAL_TIMEZONE'); ?>:</label>
            <?php if (isset($_POST['timezone'])) { $TIMEZONE = var_out($_POST['timezone']); } ?>
            <select class="text" id="timezone" name="timezone">
            <?php if ($TIMEZONE == '') {
                echo '<option value="" selected="selected">-- ' . i18n_r('NONE') . ' --</option>';
            } else {
                echo '<option selected="selected" value="' . $TIMEZONE . '">' . $TIMEZONE . '</option>';
            } ?>
            <?php include('inc/timezone_options.txt'); ?>
            </select></p>
        </div>
        <div class="rightsec">
            <p><label for="lang"><?php i18n('LANGUAGE'); ?>:
            <span class="right"><a href="https://github.com/GetSimpleCMS-CE/GetSimpleCMS-CE/wiki/Languages" target="_blank"><?php i18n('MORE'); ?></a></span></label>
            <select name="lang" id="lang" class="text"><?php echo $langs; ?></select></p>
        </div>
        <div class="clear"></div>
        <p class="inline"><input name="show_htmleditor" id="show_htmleditor" type="checkbox" value="1" <?php echo $editorchck; ?> />
        &nbsp;<label for="show_htmleditor"><?php i18n('ENABLE_HTML_ED'); ?></label></p>

        <?php exec_action('settings-user-extras'); ?>

        <p style="margin:0px 0 5px 0;font-size:12px;color:#999;"><?php i18n('ONLY_NEW_PASSWORD'); ?>:</p>
        <div class="leftsec">
            <p><label for="sitepwd"><?php i18n('NEW_PASSWORD'); ?>:</label>
            <input autocomplete="off" class="text" id="sitepwd" name="sitepwd" type="password" value="" /></p>
        </div>
        <div class="rightsec">
            <p><label for="sitepwd_confirm"><?php i18n('CONFIRM_PASSWORD'); ?>:</label>
            <input autocomplete="off" class="text" id="sitepwd_confirm" name="sitepwd_confirm" type="password" value="" /></p>
        </div>
        <div class="clear"></div>

        <p id="submit_line">
            <span><input class="submit" type="submit" name="submitted" value="<?php i18n('BTN_SAVESETTINGS'); ?>" /></span>
            &nbsp;&nbsp;<?php i18n('OR'); ?>&nbsp;&nbsp;
            <a class="cancel" href="settings.php?cancel"><?php i18n('CANCEL'); ?></a>
        </p>

        </div><!-- /section -->
        </div><!-- /main -->
        </form>

        <!-- ===================== USER MANAGEMENT ===================== -->
        <div id="user-management" class="main" style="margin-top:20px;">
            <h3>User Management</h3>

            <?php if (!empty($error)): ?>
                <div class="error"><p><?php echo $error; ?></p></div>
            <?php endif; ?>
            <?php if (!empty($success) && (isset($_POST['delete_user']) || isset($_POST['add_user']) || isset($_POST['edit_user']))): ?>
                <div class="updated"><p><?php echo $success; ?></p></div>
            <?php endif; ?>

            <?php if (!empty($all_users)): ?>
            <table class="tbl" width="100%">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Display Name</th>
                        <th>E-mail</th>
                        <th>Language</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($all_users as $u_row): ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($u_row['username']); ?></strong></td>
                    <td><?php echo htmlspecialchars($u_row['name']); ?></td>
                    <td><?php echo htmlspecialchars($u_row['email']); ?></td>
                    <td><?php echo htmlspecialchars($u_row['lang']); ?></td>
                    <td>
                        <button type="button" class="button"
                            onclick="gsUserEditToggle('<?php echo htmlspecialchars($u_row['username']); ?>')">Edit</button>
                        <?php if (strtolower($u_row['username'] ?? '') !== strtolower($USR ?? '')): ?>
                        <form method="post" action="<?php myself(); ?>" style="display:inline"
                              onsubmit="return confirm('Delete user <?php echo htmlspecialchars($u_row['username']); ?>?');">
                            <input type="hidden" name="nonce" value="<?php echo get_nonce("save_settings"); ?>" />
                            <input type="hidden" name="delete_username" value="<?php echo htmlspecialchars($u_row['username']); ?>" />
                            <input class="submit" type="submit" name="delete_user" value="Delete" />
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr id="edit-row-<?php echo htmlspecialchars($u_row['username']); ?>" style="display:none;background:#f9f9f9;">
                    <td colspan="5">
                        <form method="post" action="<?php myself(); ?>" style="padding:10px 0;">
                            <input type="hidden" name="nonce" value="<?php echo get_nonce("save_settings"); ?>" />
                            <input type="hidden" name="edit_username" value="<?php echo htmlspecialchars($u_row['username']); ?>" />
                            <strong>Editing: <?php echo htmlspecialchars($u_row['username']); ?></strong><br><br>
                            <label>Display Name:</label>
                            <input class="text" type="text" name="edit_name"
                                   value="<?php echo htmlspecialchars($u_row['name']); ?>" style="width:180px;" />&nbsp;&nbsp;
                            <label>E-mail:</label>
                            <input class="text" type="email" name="edit_email"
                                   value="<?php echo htmlspecialchars($u_row['email']); ?>" style="width:180px;" />&nbsp;&nbsp;
                            <label>Language:</label>
                            <input class="text" type="text" name="edit_lang"
                                   value="<?php echo htmlspecialchars($u_row['lang']); ?>" style="width:70px;" />&nbsp;&nbsp;
                            <label>New Password (optional):</label>
                            <input class="text" type="password" name="edit_password"
                                   autocomplete="off" style="width:140px;" />&nbsp;&nbsp;
                            <input class="submit" type="submit" name="edit_user" value="Save" />
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>

            <h4 style="margin-top:20px;">Add New User</h4>
            <form method="post" action="<?php myself(); ?>">
                <input type="hidden" name="nonce" value="<?php echo get_nonce("save_settings"); ?>" />
                <div class="leftsec">
                    <p><label>Username:</label>
                    <input class="text" type="text" name="new_username" required style="width:180px;" /></p>
                </div>
                <div class="rightsec">
                    <p><label>Display Name:</label>
                    <input class="text" type="text" name="new_name" style="width:180px;" /></p>
                </div>
                <div class="clear"></div>
                <div class="leftsec">
                    <p><label>E-mail:</label>
                    <input class="text" type="email" name="new_email" style="width:180px;" /></p>
                </div>
                <div class="rightsec">
                    <p><label>Password:</label>
                    <input class="text" type="password" name="new_password" required
                           autocomplete="off" style="width:180px;" /></p>
                </div>
                <div class="clear"></div>
                <div class="leftsec">
                    <p><label>Language:</label>
                    <select name="new_lang" class="text"><?php echo $langs; ?></select></p>
                </div>
                <div class="clear"></div>
                <p><input class="submit" type="submit" name="add_user" value="Add User" /></p>
            </form>
        </div>
        <!-- ===================== END USER MANAGEMENT ===================== -->

    </div><!-- /maincontent -->

    <div id="sidebar">
        <?php include('template/sidebar-settings.php'); ?>
    </div>

</div>

<script>
function gsUserEditToggle(username) {
    var row = document.getElementById('edit-row-' + username);
    row.style.display = (row.style.display === 'none') ? 'table-row' : 'none';
}
</script>

<?php get_template('footer'); ?>