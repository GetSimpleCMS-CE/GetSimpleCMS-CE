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
        $err = 'Invalid security token.';
    } else {
        $newMode = (isset($_POST['storage_mode']) && $_POST['storage_mode'] === 'sqlite') ? 'sqlite' : 'xml';
        if ($newMode === 'sqlite' && (!extension_loaded('sqlite3') || !class_exists('SQLite3'))) {
            $err = 'SQLite3 extension is not available.';
        } else {
            // Update gsconfig.php
            $cfgPath = GSROOTPATH . 'gsconfig.php';
            $cfg = file_exists($cfgPath) ? file_get_contents($cfgPath) : '';
            if (strpos($cfg, "define('GSDATABASE'") !== false) {
                $cfg = preg_replace("/define\('GSDATABASE',\s*'(xml|sqlite)'\);/", "define('GSDATABASE', '" . $newMode . "');", $cfg);
            } else {
                $cfg = str_replace('?>', "define('GSDATABASE', '" . $newMode . "');\n?>", $cfg);
            }
            if (file_put_contents($cfgPath, $cfg, LOCK_EX) !== false) {
                // If switching to sqlite, migrate existing XML data into the DB.
                if ($newMode === 'sqlite') {
                    if (!isset($GLOBALS['GS_STORAGE_SQLITE'])) {
                        require_once(GSADMININCPATH . 'storage_sqlite.php');
                        $GLOBALS['GS_STORAGE_SQLITE'] = new GS_Storage_SQLite(GSDATAOTHERPATH . 'database.sqlite');
                    }
                    $n = $GLOBALS['GS_STORAGE_SQLITE']->migrateFromDisk(GSDATAPATH);
                    $msg = 'Switched to SQLite3. Migrated ' . $n . ' files into the database.';
                } else {
                    $msg = 'Switched to XML file storage.';
                }
                $mode = $newMode;
            } else {
                $err = 'Failed to update gsconfig.php.';
            }
        }
    }
}
?>
<?php get_template('header', cl($SITENAME) . ' &raquo; Storage Backend'); ?>
<div class="bodycontent clearfix">
    <div id="maincontent">
        <div class="main">
            <h3>Storage Backend</h3>
            <p>Current storage mode: <strong><?php echo htmlspecialchars($mode, ENT_QUOTES, 'UTF-8'); ?></strong></p>
            <?php if ($msg) { echo '<p style="color:green;">' . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . '</p>'; } ?>
            <?php if ($err) { echo '<p style="color:red;">' . htmlspecialchars($err, ENT_QUOTES, 'UTF-8') . '</p>'; } ?>
            <form method="post" action="">
                <input type="hidden" name="storage_nonce" value="<?php echo get_nonce('storage_switch'); ?>">
                <p>
                    <label><input type="radio" name="storage_mode" value="xml" <?php echo ($mode === 'xml' ? 'checked' : ''); ?>> XML files (default, full plugin compatibility)</label><br>
                    <label><input type="radio" name="storage_mode" value="sqlite" <?php echo ($mode === 'sqlite' ? 'checked' : ''); ?>> SQLite3 database</label>
                </p>
                <p><button type="submit" name="storage_submit" class="submit">Apply</button></p>
            </form>
            <p><small>Switching to SQLite3 keeps an XML mirror on disk for plugin compatibility. Default XML mode preserves full compatibility with all plugins.</small></p>
        </div>
    </div>
</div>
<?php get_template('footer'); ?>
