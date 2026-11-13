<?php
/**
 * Storage Backend
 *
 * Switch between XML (default) and SQLite3 storage.
 *
 * @package GetSimple
 * @subpackage Settings
 */
$load['plugin'] = true;
include('inc/common.php');
login_cookie_check();

$mode = gs_storage_mode();
$msg = '';
$err = '';

if (isset($_POST['storage_submit'])) {
    if (!check_nonce($_POST['storage_nonce'] ?? '', 'storage_switch')) {
        $err = i18n_r('STORAGE_ERR_TOKEN');
    } else {
        $newMode = (isset($_POST['storage_mode']) && $_POST['storage_mode'] === 'sqlite') ? 'sqlite' : 'xml';
        if ($newMode === 'sqlite' && (!extension_loaded('sqlite3') || !class_exists('SQLite3'))) {
            $err = i18n_r('STORAGE_ERR_SQLITE');
        } else {
            $cfgPath = GSROOTPATH . 'gsconfig.php';
            $cfg = file_exists($cfgPath) ? file_get_contents($cfgPath) : '';
            if (strpos($cfg, "define('GSDATABASE'") !== false) {
                $cfg = preg_replace("/define\('GSDATABASE',\s*'(xml|sqlite)'\);/", "define('GSDATABASE', '" . $newMode . "');", $cfg);
            } else {
                $cfg = str_replace('?>', "define('GSDATABASE', '" . $newMode . "');\n?>", $cfg);
            }
            if (file_put_contents($cfgPath, $cfg, LOCK_EX) !== false) {
                if ($newMode === 'sqlite') {
                    if (!isset($GLOBALS['GS_STORAGE_SQLITE'])) {
                        require_once(GSADMININCPATH . 'storage_sqlite.php');
                        $GLOBALS['GS_STORAGE_SQLITE'] = new GS_Storage_SQLite(GSDATAOTHERPATH . 'database.sqlite');
                    }
                    $n = $GLOBALS['GS_STORAGE_SQLITE']->migrateFromDisk(GSDATAPATH);
                    $msg = sprintf(i18n_r('STORAGE_SWITCHED_SQLITE'), $n);
                } else {
                    $msg = i18n_r('STORAGE_SWITCHED_XML');
                }
                $mode = $newMode;
            } else {
                $err = i18n_r('STORAGE_ERR_WRITE');
            }
        }
    }
}
?>
<?php get_template('header', cl($SITENAME) . ' &raquo; ' . i18n_r('STORAGE_BACKEND')); ?>
<div class="bodycontent clearfix">
    <div id="maincontent">
        <div class="main">
            <h3><?php i18n('STORAGE_BACKEND'); ?></h3>
            <?php if ($msg) { ?>
                <div class="updated"><?php echo htmlspecialchars($msg, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php } ?>
            <?php if ($err) { ?>
                <div class="error"><?php echo htmlspecialchars($err, ENT_QUOTES, 'UTF-8'); ?></div>
            <?php } ?>
            <p><?php echo i18n_r('STORAGE_MODE'); ?>: <strong><?php echo htmlspecialchars(ucfirst($mode), ENT_QUOTES, 'UTF-8'); ?></strong></p>
            <form method="post" action="" class="largeform">
                <input type="hidden" name="storage_nonce" value="<?php echo get_nonce('storage_switch'); ?>">
                <p>
                    <label><input type="radio" name="storage_mode" value="xml" <?php echo ($mode === 'xml' ? 'checked' : ''); ?> /> <?php echo i18n_r('STORAGE_XML'); ?></label><br />
                    <label><input type="radio" name="storage_mode" value="sqlite" <?php echo ($mode === 'sqlite' ? 'checked' : ''); ?> /> <?php echo i18n_r('STORAGE_SQLITE'); ?></label>
                </p>
                <p><input class="submit" type="submit" name="storage_submit" value="<?php echo i18n_r('STORAGE_APPLY'); ?>" /></p>
            </form>
            <p class="hint"><?php echo i18n_r('STORAGE_HINT'); ?></p>
        </div>
    </div>
    <div id="sidebar">
        <?php include('template/sidebar-settings.php'); ?>
    </div>
</div>
<?php get_template('footer'); ?>
