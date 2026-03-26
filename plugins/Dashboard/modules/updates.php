<?php
/**
 * Module Name: GS Updates
 * Module ID: updates
 * Description: Shows available system and plugin updates.
 * Version: 1.0
 * Default W: 4
 * Default H: 2
 */
if (!defined('IN_GS')) { die('You cannot load this page directly.'); }

// Add $i18n_m for i18n lang files in Modules
$i18n_m = dash_module_i18n('updates');

// Unique ID to avoid conflicts between modules (optional)
$uid = 'upd_' . substr(md5(__FILE__), 0, 6);

global $site_version_no, $plugin_info, $live_plugins;

// ── System update check ───────────────────────────────────
$system_update = null;
try {
	$ctx = stream_context_create(array('http' => array('timeout' => 5)));
	$raw = @file_get_contents('https://getsimplecms-ce.github.io/upgrade.json', false, $ctx);
	if ($raw) {
		foreach (json_decode($raw) as $entry) {
			if (version_compare($entry->version, $site_version_no, '>')) {
				$system_update = $entry->version;
				break;
			}
		}
	}
} catch (Exception $e) {}

// ── Plugin update check ───────────────────────────────────
$plugin_updates = 0;
$plugin_update_names = array();
try {
	$ctx = stream_context_create(array('http' => array('timeout' => 5)));
	$raw = @file_get_contents('https://getsimplecms-ce-plugins.github.io/db.json', false, $ctx);
	if ($raw) {
		$db = array();
		foreach (json_decode($raw, true) as $p) {
			$db[strtolower($p['id'])] = $p;
		}
		// Only check .php files directly in GSPLUGINPATH, not subdirectories
		foreach (glob(GSPLUGINPATH . '*.php') ?: array() as $filepath) {
			$fi   = basename($filepath);
			$name = pathinfo($fi, PATHINFO_FILENAME);
			$key  = strtolower($name);
			if (!isset($db[$key])) continue;
			// Must be an active/enabled plugin — same check as plugins.php
			if (!isset($live_plugins[$fi]) || $live_plugins[$fi] !== 'true') continue;
			$local = isset($plugin_info[$name]['version']) ? $plugin_info[$name]['version'] : '0';
			// Skip if version is 'disabled' (internal GS marker)
			if ($local === 'disabled') continue;
			if (version_compare($db[$key]['version'], $local, '>')) {
				$plugin_updates++;
				$plugin_update_names[] = $name . ' (local: ' . $local . ', db: ' . $db[$key]['version'] . ')';
			}
		}
	}
} catch (Exception $e) {}
?>

<style>
#<?php echo $uid ?> .upd-line {
	display: flex;
	align-items: center;
	gap: 8px;
	padding: 6px 0;
	font-size: 13px;
	border-bottom: 1px solid #f3f3f3;
}
#<?php echo $uid ?> .upd-line:last-child { border-bottom: none; }
#<?php echo $uid ?> .upd-text { flex: 1; }
#<?php echo $uid ?> .upd-link {
	font-size: 11px;
	color: #4a90d9;
	text-decoration: none;
	white-space: nowrap;
}
#<?php echo $uid ?> .upd-link:hover { text-decoration: underline; }
</style>

<div id="<?php echo $uid ?>">
	<h3><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;" width="24" height="24" viewBox="0 0 20 20"><rect width="20" height="20" fill="none"/><path fill="currentColor" d="M5.7 9c.4-2 2.2-3.5 4.3-3.5c1.5 0 2.7.7 3.5 1.8l1.7-2C14 3.9 12.1 3 10 3C6.5 3 3.6 5.6 3.1 9H1l3.5 4L8 9zm9.8-2L12 11h2.3c-.5 2-2.2 3.5-4.3 3.5c-1.5 0-2.7-.7-3.5-1.8l-1.7 1.9C6 16.1 7.9 17 10 17c3.5 0 6.4-2.6 6.9-6H19z"/></svg> <?php echo $i18n_m('gsu_lang_Pages'); ?></h3>
	<!-- System -->
	<div class="upd-line">
		<svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;flex-shrink:0;color:<?php echo $system_update ? '#FF9900' : '#28a745'; ?>;" width="18" height="18" viewBox="0 0 24 24"><rect width="24" height="24" fill="none"/><path fill="currentColor" d="M12 15.5A3.5 3.5 0 0 1 8.5 12A3.5 3.5 0 0 1 12 8.5a3.5 3.5 0 0 1 3.5 3.5a3.5 3.5 0 0 1-3.5 3.5m7.43-2.53c.04-.32.07-.64.07-.97s-.03-.66-.07-1l2.11-1.63c.19-.15.24-.42.12-.64l-2-3.46c-.12-.22-.39-.31-.61-.22l-2.49 1c-.52-.39-1.06-.73-1.69-.98l-.37-2.65A.506.506 0 0 0 14 2h-4c-.25 0-.46.18-.5.42l-.37 2.65c-.63.25-1.17.59-1.69.98l-2.49-1c-.22-.09-.49 0-.61.22l-2 3.46c-.13.22-.07.49.12.64L4.57 11c-.04.34-.07.67-.07 1s.03.65.07.97l-2.11 1.66c-.19.15-.25.42-.12.64l2 3.46c.12.22.39.3.61.22l2.49-1.01c.52.4 1.06.74 1.69.99l.37 2.65c.04.24.25.42.5.42h4c.25 0 .46-.18.5-.42l.37-2.65c.63-.26 1.17-.59 1.69-.99l2.49 1.01c.22.08.49 0 .61-.22l2-3.46c.12-.22.07-.49-.12-.64z"/></svg>
		<span class="upd-text">
			<?php if ($system_update): ?>
				<?php echo $i18n_m('gsu_lang_System_update'); ?> &mdash; v<?php echo htmlspecialchars($system_update); ?>
			<?php else: ?>
				<?php echo $i18n_m('gsu_lang_System_no_update'); ?>
			<?php endif; ?>
		</span>
		<?php if ($system_update): ?>
			<a class="upd-link" href="load.php?id=UpdateCE"><?php echo $i18n_m('gsu_Update_Now'); ?></a>
		<?php endif; ?>
	</div>

	<!-- Plugins -->
	<div class="upd-line">
		<svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;flex-shrink:0;color:<?php echo $plugin_updates > 0 ? '#FF9900' : '#28a745'; ?>;" width="18" height="18" viewBox="0 0 24 24"><rect width="24" height="24" fill="none"/><path fill="currentColor" d="M16 8V3a1 1 0 0 0-2 0v5h-4V3a1 1 0 0 0-2 0v5H5v4a6.99 6.99 0 0 0 4 6.317V22h6v-3.683A6.99 6.99 0 0 0 19 12V8z"/></svg>
		<span class="upd-text">
			<?php if ($plugin_updates > 0): ?>
				<?php echo $plugin_updates; ?> <?php echo $i18n_m('gsu_lang_plugin_update'); ?><?php echo $plugin_updates > 1 ? 's' : ''; ?> <?php echo $i18n_m('gsu_lang_available'); ?>
			<?php else: ?>
				<?php echo $i18n_m('gsu_lang_plugin_no_updates'); ?>
			<?php endif; ?>
		</span>
		<?php if ($plugin_updates > 0): ?>
			<a class="upd-link" href="plugins.php"><?php echo $i18n_m('gsu_Update_Now'); ?></a>
		<?php endif; ?>
	</div>
</div>

<?php if (!empty($plugin_update_names)): ?>
<p style="font-size:11px;color:#999;margin-top:6px;margin-left:24px;">
	<b>Info:</b> <br><?php echo implode(', <br>', $plugin_update_names); ?>
</p>
<?php endif; ?>