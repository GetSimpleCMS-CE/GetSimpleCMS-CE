<?php
/**
 * Module Name: Custom Links
 * Module ID: customlinks
 * Description: Add your own custom action buttons/links to the dashboard.
 * Version: 1.1
 * Default W: 12
 * Default H: 2
 */
if (!defined('IN_GS')) { die('You cannot load this page directly.'); }

// Add $i18n_m for i18n lang files in Modules
$i18n_m = dash_module_i18n('customlinks');

// Unique ID to avoid conflicts between modules (optional)
$cl_uid = 'cl_' . substr(md5(__FILE__), 0, 6);

// -------------------------------------------------------
// Storage helpers
// This module keeps its own data file so no changes to
// Dashboard core (layout.json / Dashboard.php) are needed.
// -------------------------------------------------------
if (!function_exists('cl_data_file')) {
	function cl_data_file() {
		return GSDATAOTHERPATH . 'dashboard/customlinks.json';
	}
}

if (!function_exists('cl_get_links')) {
	function cl_get_links() {
		$file = cl_data_file();
		if (file_exists($file)) {
			$data = json_decode(file_get_contents($file), true);
			if (is_array($data)) return $data;
		}
		return [];
	}
}

if (!function_exists('cl_save_links')) {
	function cl_save_links($links) {
		$dir = GSDATAOTHERPATH . 'dashboard/';
		if (!is_dir($dir)) mkdir($dir, 0755, true);
		file_put_contents(cl_data_file(), json_encode($links, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
	}
}

if (!function_exists('cl_allowed_types')) {
	function cl_allowed_types() {
		return ['dark', 'blue', 'orange', 'green', 'red', 'gray', 'purple', 'teal', 'pink'];
	}
}

if (!function_exists('cl_allowed_shades')) {
	function cl_allowed_shades() {
		return ['normal', 'light'];
	}
}

if (!function_exists('cl_allowed_targets')) {
	function cl_allowed_targets() {
		return ['_self', '_blank'];
	}
}

// -------------------------------------------------------
// CSRF token
// Derived from GS's own $SALT + $USR rather than a PHP
// session, since by the time this module renders, GS has
// already sent HTML output for the page - session_start()
// is unreliable that late in the request.
// -------------------------------------------------------
global $SALT, $USR;
$cl_csrf = hash('sha256', $SALT . '|' . $USR . '|customlinks');

// -------------------------------------------------------
// Handle Save
// Plain POST + re-render (no AJAX/no core changes) - inline
// handling within this include, per GS plugin convention.
// -------------------------------------------------------
$cl_just_saved = false;

if (!empty($_POST['customlinks_save']) && isset($_POST['cl_csrf']) && hash_equals($cl_csrf, (string)$_POST['cl_csrf'])) {
	$kinds   = $_POST['cl_kind']   ?? [];
	$titles  = $_POST['cl_title']  ?? [];
	$urls    = $_POST['cl_link']   ?? [];
	$types   = $_POST['cl_type']   ?? [];
	$shades  = $_POST['cl_shade']  ?? [];
	$icons   = $_POST['cl_icon']   ?? [];
	$targets = $_POST['cl_target'] ?? [];
	$allowed_types   = cl_allowed_types();
	$allowed_shades  = cl_allowed_shades();
	$allowed_targets = cl_allowed_targets();

	$new_links = [];
	foreach ($kinds as $i => $kind) {
		$kind = ($kind === 'divider') ? 'divider' : 'link';

		if ($kind === 'divider') {
			$new_links[] = ['kind' => 'divider'];
			continue;
		}

		$t = trim(strip_tags((string)($titles[$i] ?? '')));
		$u = trim((string)($urls[$i] ?? ''));
		if ($t === '' || $u === '') continue; // skip incomplete rows

		// basic safety: block javascript: / data: pseudo-protocols
		if (preg_match('/^\s*(javascript|data|vbscript)\s*:/i', $u)) continue;

		$type = (string)($types[$i] ?? 'blue');
		if (!in_array($type, $allowed_types, true)) $type = 'blue';

		$shade = (string)($shades[$i] ?? 'normal');
		if (!in_array($shade, $allowed_shades, true)) $shade = 'normal';

		$target = (string)($targets[$i] ?? '_self');
		if (!in_array($target, $allowed_targets, true)) $target = '_self';

		$icon = trim((string)($icons[$i] ?? ''));
		if ($icon !== '' && stripos($icon, '<svg') === false) $icon = '';

		$new_links[] = [
			'kind'   => 'link',
			'title'  => $t,
			'link'   => $u,
			'type'   => $type,
			'shade'  => $shade,
			'icon'   => $icon,
			'target' => $target,
		];
	}

	cl_save_links($new_links);
	$cl_just_saved = true;
}

$cl_links = cl_get_links();
global $SITEURL;
?>

<style>
#customlinks {border: none !important;}
.cl-widget-<?php echo $cl_uid; ?> { position: relative; }
.cl-widget-<?php echo $cl_uid; ?> .cl-gear {
	position: absolute; top: 0; right: 0;
	width: 26px; height: 26px;
	display: flex; align-items: center; justify-content: center;
	border-radius: 4px; cursor: pointer; color: #9aa5b1;
	background: transparent; border: none; padding: 0;
}
.cl-widget-<?php echo $cl_uid; ?> .cl-gear:hover { color: #4a90d9; background: #f0f4f9; }
.cl-widget-<?php echo $cl_uid; ?> .cl-gear svg { width: 16px; height: 16px; }

.cl-widget-<?php echo $cl_uid; ?> .cl-view { padding-right: 30px; }
.cl-widget-<?php echo $cl_uid; ?> .cl-btn-row {
	display: flex; flex-wrap: wrap; gap: 10px; justify-content: center;
}
.cl-widget-<?php echo $cl_uid; ?> .cl-btn {
	display: inline-flex; flex-direction: column; align-items: center; justify-content: center; gap: 10px;
	padding: 6px 2px; min-width: 70px; border-radius: 4px;
	text-decoration: none!important; text-align: center;
	font-size: 12px; font-weight: 600; color: #fff;
	transition: opacity .15s;
}
.cl-widget-<?php echo $cl_uid; ?> .cl-btn:hover,
.cl-widget-<?php echo $cl_uid; ?> .cl-btn:visited,
.cl-widget-<?php echo $cl_uid; ?> .cl-btn:active { color: #fff; text-decoration: none!important; opacity: .85; }
.cl-widget-<?php echo $cl_uid; ?> .cl-btn svg { width: 24px; height: 24px; flex-shrink: 0; color: #fff; }
.cl-widget-<?php echo $cl_uid; ?> .cl-btn span { color: #fff; line-height: 1.2; }

.cl-widget-<?php echo $cl_uid; ?> .cl-btn-dark   { background: #2b2f38; }
.cl-widget-<?php echo $cl_uid; ?> .cl-btn-blue   { background: #2e8fe0; }
.cl-widget-<?php echo $cl_uid; ?> .cl-btn-orange { background: #e2922e; }
.cl-widget-<?php echo $cl_uid; ?> .cl-btn-green  { background: #3fae5a; }
.cl-widget-<?php echo $cl_uid; ?> .cl-btn-red    { background: #d9534f; }
.cl-widget-<?php echo $cl_uid; ?> .cl-btn-gray   { background: #7a8794; }
.cl-widget-<?php echo $cl_uid; ?> .cl-btn-purple { background: #8e5fd1; }
.cl-widget-<?php echo $cl_uid; ?> .cl-btn-teal   { background: #17a2a0; }
.cl-widget-<?php echo $cl_uid; ?> .cl-btn-pink   { background: #e0629b; }

/* Light shade variants - pale background, colored text/icon instead of white */
.cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-dark   { background: #e8e9eb; }
.cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-blue   { background: #e3f1fc; }
.cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-orange { background: #fdf0dc; }
.cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-green  { background: #e3f7e8; }
.cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-red    { background: #fbe6e5; }
.cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-gray   { background: #eceef0; }
.cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-purple { background: #f1e9fb; }
.cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-teal   { background: #ddf5f4; }
.cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-pink   { background: #fbe6f0; }

.cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-dark,   .cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-dark svg,   .cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-dark span   { color: #23262d; }
.cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-blue,   .cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-blue svg,   .cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-blue span   { color: #1a6bb0; }
.cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-orange, .cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-orange svg, .cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-orange span { color: #a86c1a; }
.cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-green,  .cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-green svg,  .cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-green span  { color: #278a41; }
.cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-red,    .cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-red svg,    .cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-red span    { color: #b23430; }
.cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-gray,   .cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-gray svg,   .cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-gray span   { color: #5b6570; }
.cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-purple, .cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-purple svg, .cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-purple span { color: #6a3fb0; }
.cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-teal,   .cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-teal svg,   .cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-teal span   { color: #0f7a78; }
.cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-pink,   .cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-pink svg,   .cl-widget-<?php echo $cl_uid; ?> .cl-btn-light.cl-btn-pink span   { color: #c23f7c; }

.cl-widget-<?php echo $cl_uid; ?> .cl-empty { color: #999; font-size: 13px; }
.cl-widget-<?php echo $cl_uid; ?> .cl-divider {
	width: 1px; align-self: center; height: 34px;
	background: #d7dbe0; margin: 0 12px; flex-shrink: 0;
}
.cl-widget-<?php echo $cl_uid; ?> .cl-saved-msg { color: #28a745; font-size: 12px; font-weight: 600; margin-bottom: 8px; }

.cl-widget-<?php echo $cl_uid; ?> .cl-modal-backdrop {
	display: none; position: fixed; inset: 0; background: rgba(20,22,26,.5); z-index: 100000;
}
.cl-widget-<?php echo $cl_uid; ?>.cl-modal-open .cl-modal-backdrop { display: block; }

.cl-widget-<?php echo $cl_uid; ?> .cl-edit { display: none; }
.cl-widget-<?php echo $cl_uid; ?>.cl-modal-open .cl-edit {
	display: block; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
	z-index: 100001; background: #fff; border-radius: 8px; box-shadow: 0 12px 40px rgba(0,0,0,.3);
	width: min(1400px, 92vw); max-height: 86vh; overflow-y: auto; padding: 18px 20px 16px;
}
.cl-widget-<?php echo $cl_uid; ?> .cl-modal-header {
	display: flex; align-items: center; justify-content: space-between;
	margin-bottom: 12px; padding-bottom: 10px; border-bottom: 1px solid #e3e6ea;
}
.cl-widget-<?php echo $cl_uid; ?> .cl-modal-title { font-size: 14px; font-weight: 700; color: #2b2f38; }
.cl-widget-<?php echo $cl_uid; ?> .cl-modal-close {
	width: 26px; height: 26px; display: flex; align-items: center; justify-content: center;
	border: none; background: transparent; cursor: pointer; color: #9aa5b1; font-size: 18px; border-radius: 4px;
}
.cl-widget-<?php echo $cl_uid; ?> .cl-modal-close:hover { color: #d9534f; background: #f7f8fa; }

.cl-widget-<?php echo $cl_uid; ?> .cl-row {
	display: flex; gap: 6px; align-items: flex-start;
	background: #f7f8fa; border: 1px solid #e3e6ea; border-radius: 4px;
	padding: 8px; margin-bottom: 8px;
}
.cl-widget-<?php echo $cl_uid; ?> .cl-row .cl-col { display: flex; flex-direction: column; gap: 2px; }
.cl-widget-<?php echo $cl_uid; ?> .cl-row label { font-size: 10px; text-transform: uppercase; letter-spacing: .03em; color: #8a94a0; font-weight: 600; }
.cl-widget-<?php echo $cl_uid; ?> .cl-row input[type=text],
.cl-widget-<?php echo $cl_uid; ?> .cl-row select,
.cl-widget-<?php echo $cl_uid; ?> .cl-row textarea {
	border: 1px solid #d0d5dd; border-radius: 6px!important; padding: 8px 10px; font-size: 12px;
	background: #fff; font-family: inherit;
}
.div.cl-edit input {padding:5px;}
.cl-widget-<?php echo $cl_uid; ?> .cl-row textarea { font-family: monospace; resize: vertical; }
.cl-widget-<?php echo $cl_uid; ?> .cl-col-icon textarea { width: 100%; height: 68px; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px;}
.cl-widget-<?php echo $cl_uid; ?> .cl-col-icon   { width: 300px; }
.cl-widget-<?php echo $cl_uid; ?> .cl-col-type   { width: 100px;  margin: 2em 0; }
.cl-widget-<?php echo $cl_uid; ?> .cl-col-shade  { width: 100px;  margin: 2em 0; }
.cl-widget-<?php echo $cl_uid; ?> .cl-col-title  { width: 200px;  margin: 2em 0; }
.cl-widget-<?php echo $cl_uid; ?> .cl-col-target { width: 100px;  margin: 2em 0; }
.cl-widget-<?php echo $cl_uid; ?> .cl-col-link   { flex: 1; min-width: 140px;  margin: 2em 0; }
.cl-widget-<?php echo $cl_uid; ?> .cl-col-actions { flex-direction: row; align-items: flex-end; gap: 2px; padding-top: 14px; }
.cl-widget-<?php echo $cl_uid; ?> .cl-icon-btn {
	width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;
	border: 1px solid #d0d5dd; border-radius: 3px; background: #fff; cursor: pointer; color: #666; font-size: 13px;
}
.cl-widget-<?php echo $cl_uid; ?> .cl-icon-btn:hover { background: #eef1f4; }
.cl-widget-<?php echo $cl_uid; ?> .cl-icon-btn.cl-remove-btn { color: #d9534f; }

.cl-widget-<?php echo $cl_uid; ?> .cl-row-divider {
	align-items: center; justify-content: space-between; padding: 6px 10px;
	background: #eef1f4;
}
.cl-widget-<?php echo $cl_uid; ?> .cl-divider-label {
	font-size: 11px; text-transform: uppercase; letter-spacing: .04em;
	color: #8a94a0; font-weight: 700;
}
.cl-widget-<?php echo $cl_uid; ?> .cl-row-divider .cl-col-actions { padding-top: 0; }

.cl-widget-<?php echo $cl_uid; ?> .cl-edit-actions { margin-top: 4px; display: flex; align-items: center; gap: 10px; }
.cl-widget-<?php echo $cl_uid; ?> .cl-add-btn,
.cl-widget-<?php echo $cl_uid; ?> .cl-save-btn {
	padding: 6px 14px; border-radius: 4px; border: 1px solid #d0d5dd; background: #fff;
	font-size: 12px; font-weight: 600; cursor: pointer; color: #333;
}
.cl-widget-<?php echo $cl_uid; ?> .cl-save-btn { background: #4a90d9; border-color: #4a90d9; color: #fff; }
.cl-widget-<?php echo $cl_uid; ?> .cl-save-btn:hover { background: #357abd; }
.cl-widget-<?php echo $cl_uid; ?> .cl-add-btn:hover { background: #f0f4f9; }
</style>

<div class="cl-widget-<?php echo $cl_uid; ?>" id="<?php echo $cl_uid; ?>">

	<button type="button" class="cl-gear" id="<?php echo $cl_uid; ?>-gear" title="<?php echo htmlspecialchars($i18n_m('cl_lang_Edit')); ?>">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1Z"/></svg>
	</button>

	<!-- VIEW MODE -->
	<div class="cl-view">
		<?php if ($cl_just_saved): ?>
			<div class="cl-saved-msg">✓ <?php echo htmlspecialchars($i18n_m('cl_lang_Saved')); ?></div>
		<?php endif; ?>

		<?php if (empty($cl_links)): ?>
			<div class="cl-empty"><?php echo htmlspecialchars($i18n_m('cl_lang_No_links_view')); ?></div>
		<?php else: ?>
			<div class="cl-btn-row">
				<?php foreach ($cl_links as $link):
					$kind = $link['kind'] ?? 'link';
					if ($kind === 'divider'):
				?>
					<span class="cl-divider" aria-hidden="true"></span>
				<?php
						continue;
					endif;
					$type   = in_array($link['type'] ?? '', cl_allowed_types(), true) ? $link['type'] : 'blue';
					$shade  = in_array($link['shade'] ?? '', cl_allowed_shades(), true) ? $link['shade'] : 'normal';
					$href   = htmlspecialchars($link['link'] ?? '#');
					$title  = htmlspecialchars($link['title'] ?? '');
					$icon   = $link['icon'] ?? '';
					// Legacy data saved before the Target option existed had no
					// 'target' key - keep those opening externally as before.
					if (isset($link['target']) && in_array($link['target'], cl_allowed_targets(), true)) {
						$target = $link['target'];
					} else {
						$target = ((strpos($link['link'] ?? '', 'http') === 0) && (strpos($link['link'] ?? '', rtrim($SITEURL, '/')) !== 0)) ? '_blank' : '_self';
					}
					$btn_class = 'cl-btn cl-btn-' . $type . ($shade === 'light' ? ' cl-btn-light' : '');
				?>
					<a class="<?php echo $btn_class; ?>" href="<?php echo $href; ?>"<?php echo ($target === '_blank') ? ' target="_blank" rel="noopener"' : ''; ?>>
						<?php if ($icon !== ''): ?><?php echo $icon; ?><?php endif; ?>
						<span><?php echo $title; ?></span>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</div>

<!-- MODAL -->
<div class="cl-widget-<?php echo $cl_uid; ?> cl-modal-root<?php echo (empty($cl_links) ? ' cl-modal-open' : ''); ?>" id="<?php echo $cl_uid; ?>-modal-root">

	<div class="cl-modal-backdrop" id="<?php echo $cl_uid; ?>-backdrop"></div>

	<div class="cl-edit">
		<div class="cl-modal-header">
			<div class="cl-modal-title"><?php echo htmlspecialchars($i18n_m('cl_lang_Modal_Title')); ?></div>
			<button type="button" class="cl-modal-close" id="<?php echo $cl_uid; ?>-close" title="<?php echo htmlspecialchars($i18n_m('cl_lang_Close')); ?>">&times;</button>
		</div>
		<form method="post" id="<?php echo $cl_uid; ?>-form">
			<input type="hidden" name="customlinks_save" value="1">
			<input type="hidden" name="cl_csrf" value="<?php echo htmlspecialchars($cl_csrf); ?>">

			<div id="<?php echo $cl_uid; ?>-rows">
				<?php if (empty($cl_links)): ?>
					<div class="cl-empty" style="margin-bottom:8px;"><?php echo htmlspecialchars($i18n_m('cl_lang_No_links_yet')); ?></div>
				<?php else: ?>
					<?php foreach ($cl_links as $link):
						$kind = $link['kind'] ?? 'link';
						if ($kind === 'divider'):
					?>
						<div class="cl-row cl-row-divider">
							<input type="hidden" name="cl_kind[]" value="divider">
							<input type="hidden" name="cl_type[]" value="">
							<input type="hidden" name="cl_shade[]" value="">
							<input type="hidden" name="cl_icon[]" value="">
							<input type="hidden" name="cl_title[]" value="">
							<input type="hidden" name="cl_link[]" value="">
							<input type="hidden" name="cl_target[]" value="">
							<div class="cl-divider-label"><?php echo htmlspecialchars($i18n_m('cl_lang_Divider')); ?></div>
							<div class="cl-col cl-col-actions">
								<button type="button" class="cl-icon-btn cl-move-up" title="<?php echo htmlspecialchars($i18n_m('cl_lang_Move_up')); ?>">&uarr;</button>
								<button type="button" class="cl-icon-btn cl-move-down" title="<?php echo htmlspecialchars($i18n_m('cl_lang_Move_down')); ?>">&darr;</button>
								<button type="button" class="cl-icon-btn cl-remove-btn" title="<?php echo htmlspecialchars($i18n_m('cl_lang_Remove')); ?>">&times;</button>
							</div>
						</div>
					<?php
							continue;
						endif;
					?>
						<div class="cl-row">
							
							<div class="cl-col cl-col-title">
								<label><?php echo htmlspecialchars($i18n_m('cl_lang_Link_Title')); ?></label>
								<input type="text" name="cl_title[]" placeholder="<?php echo htmlspecialchars($i18n_m('cl_lang_Title_placeholder')); ?>" value="<?php echo htmlspecialchars($link['title'] ?? ''); ?>">
							</div>
							
							<div class="cl-col cl-col-link">
								<label><?php echo htmlspecialchars($i18n_m('cl_lang_Link_URL')); ?></label>
								<input type="text" name="cl_link[]" placeholder="<?php echo htmlspecialchars($i18n_m('cl_lang_Link_placeholder')); ?>" value="<?php echo htmlspecialchars($link['link'] ?? ''); ?>">
							</div>
							
							<div class="cl-col cl-col-target">
								<label><?php echo htmlspecialchars($i18n_m('cl_lang_Target')); ?></label>
								<select name="cl_target[]">
									<?php foreach (cl_allowed_targets() as $tg): ?>
									<option value="<?php echo $tg; ?>"<?php echo (($link['target'] ?? '_self') === $tg) ? ' selected' : ''; ?>><?php echo htmlspecialchars($i18n_m('cl_lang_Target_' . ($tg === '_blank' ? 'new' : 'same'))); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							
							<input type="hidden" name="cl_kind[]" value="link">
							
							<div class="cl-col cl-col-type">
								<label><?php echo htmlspecialchars($i18n_m('cl_lang_Type')); ?></label>
								<select name="cl_type[]">
									<?php foreach (cl_allowed_types() as $t): ?>
									<option value="<?php echo $t; ?>"<?php echo (($link['type'] ?? '') === $t) ? ' selected' : ''; ?>><?php echo htmlspecialchars($i18n_m('cl_lang_Type_' . $t)); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							
							<div class="cl-col cl-col-shade">
								<label><?php echo htmlspecialchars($i18n_m('cl_lang_Shade')); ?></label>
								<select name="cl_shade[]">
									<?php foreach (cl_allowed_shades() as $sh): ?>
									<option value="<?php echo $sh; ?>"<?php echo (($link['shade'] ?? 'normal') === $sh) ? ' selected' : ''; ?>><?php echo htmlspecialchars($i18n_m('cl_lang_Shade_' . $sh)); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							
							<div class="cl-col cl-col-icon">
								<label><?php echo htmlspecialchars($i18n_m('cl_lang_Icon_SVG')); ?> <a href="https://icon-sets.iconify.design/" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;" width="1.3em" height="1.3em" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path fill="currentColor" d="M11 17H7q-2.075 0-3.537-1.463T2 12t1.463-3.537T7 7h4v2H7q-1.25 0-2.125.875T4 12t.875 2.125T7 15h4zm-3-4v-2h8v2zm5 4v-2h4q1.25 0 2.125-.875T20 12t-.875-2.125T17 9h-4V7h4q2.075 0 3.538 1.463T22 12t-1.463 3.538T17 17z"/></svg></a></label>
								<textarea name="cl_icon[]" placeholder="<?php echo htmlspecialchars($i18n_m('cl_lang_Icon_placeholder')); ?>"><?php echo htmlspecialchars($link['icon'] ?? ''); ?></textarea>
							</div>
							
							<div class="cl-col cl-col-actions">
								<button type="button" class="cl-icon-btn cl-move-up" title="<?php echo htmlspecialchars($i18n_m('cl_lang_Move_up')); ?>">&uarr;</button>
								<button type="button" class="cl-icon-btn cl-move-down" title="<?php echo htmlspecialchars($i18n_m('cl_lang_Move_down')); ?>">&darr;</button>
								<button type="button" class="cl-icon-btn cl-remove-btn" title="<?php echo htmlspecialchars($i18n_m('cl_lang_Remove')); ?>">&times;</button>
							</div>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>

			<div class="cl-edit-actions">
				<button type="button" class="cl-add-btn" id="<?php echo $cl_uid; ?>-add">+ <?php echo htmlspecialchars($i18n_m('cl_lang_Add_Link')); ?></button>
				<button type="button" class="cl-add-btn" id="<?php echo $cl_uid; ?>-add-divider">+ <?php echo htmlspecialchars($i18n_m('cl_lang_Add_Divider')); ?></button>
				<button type="submit" class="cl-save-btn"><?php echo htmlspecialchars($i18n_m('cl_lang_Save')); ?></button>
				<button type="button" class="cl-add-btn" id="<?php echo $cl_uid; ?>-done"><?php echo htmlspecialchars($i18n_m('cl_lang_Done')); ?></button>
			</div>
		</form>
	</div>

	<template id="<?php echo $cl_uid; ?>-row-template">
		<div class="cl-row">
		
			<input type="hidden" name="cl_kind[]" value="link">
			
			<div class="cl-col cl-col-title">
				<label><?php echo htmlspecialchars($i18n_m('cl_lang_Link_Title')); ?></label>
				<input type="text" name="cl_title[]" placeholder="<?php echo htmlspecialchars($i18n_m('cl_lang_Title_placeholder')); ?>">
			</div>
			
			<div class="cl-col cl-col-link">
				<label><?php echo htmlspecialchars($i18n_m('cl_lang_Link_URL')); ?></label>
				<input type="text" name="cl_link[]" placeholder="<?php echo htmlspecialchars($i18n_m('cl_lang_Link_placeholder')); ?>">
			</div>
			
			<div class="cl-col cl-col-target">
				<label><?php echo htmlspecialchars($i18n_m('cl_lang_Target')); ?></label>
				<select name="cl_target[]">
					<?php foreach (cl_allowed_targets() as $tg): ?>
					<option value="<?php echo $tg; ?>"<?php echo ($tg === '_self') ? ' selected' : ''; ?>><?php echo htmlspecialchars($i18n_m('cl_lang_Target_' . ($tg === '_blank' ? 'new' : 'same'))); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			
			<div class="cl-col cl-col-type">
				<label><?php echo htmlspecialchars($i18n_m('cl_lang_Type')); ?></label>
				<select name="cl_type[]">
					<?php foreach (cl_allowed_types() as $t): ?>
					<option value="<?php echo $t; ?>"><?php echo htmlspecialchars($i18n_m('cl_lang_Type_' . $t)); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			
			<div class="cl-col cl-col-shade">
				<label><?php echo htmlspecialchars($i18n_m('cl_lang_Shade')); ?></label>
				<select name="cl_shade[]">
					<?php foreach (cl_allowed_shades() as $sh): ?>
					<option value="<?php echo $sh; ?>"><?php echo htmlspecialchars($i18n_m('cl_lang_Shade_' . $sh)); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			
			<div class="cl-col cl-col-icon">
				<label><?php echo htmlspecialchars($i18n_m('cl_lang_Icon_SVG')); ?> <a href="https://icon-sets.iconify.design/" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;" width="1.3em" height="1.3em" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path fill="currentColor" d="M11 17H7q-2.075 0-3.537-1.463T2 12t1.463-3.537T7 7h4v2H7q-1.25 0-2.125.875T4 12t.875 2.125T7 15h4zm-3-4v-2h8v2zm5 4v-2h4q1.25 0 2.125-.875T20 12t-.875-2.125T17 9h-4V7h4q2.075 0 3.538 1.463T22 12t-1.463 3.538T17 17z"/></svg></a></label>
				<textarea name="cl_icon[]" placeholder="<?php echo htmlspecialchars($i18n_m('cl_lang_Icon_placeholder')); ?>"></textarea>
			</div>
			
			<div class="cl-col cl-col-actions">
				<button type="button" class="cl-icon-btn cl-move-up" title="<?php echo htmlspecialchars($i18n_m('cl_lang_Move_up')); ?>">&uarr;</button>
				<button type="button" class="cl-icon-btn cl-move-down" title="<?php echo htmlspecialchars($i18n_m('cl_lang_Move_down')); ?>">&darr;</button>
				<button type="button" class="cl-icon-btn cl-remove-btn" title="<?php echo htmlspecialchars($i18n_m('cl_lang_Remove')); ?>">&times;</button>
			</div>
			
		</div>
	</template>

	<template id="<?php echo $cl_uid; ?>-divider-template">
		<div class="cl-row cl-row-divider">
			<input type="hidden" name="cl_kind[]" value="divider">
			<input type="hidden" name="cl_type[]" value="">
			<input type="hidden" name="cl_shade[]" value="">
			<input type="hidden" name="cl_icon[]" value="">
			<input type="hidden" name="cl_title[]" value="">
			<input type="hidden" name="cl_link[]" value="">
			<input type="hidden" name="cl_target[]" value="">
			<div class="cl-divider-label"><?php echo htmlspecialchars($i18n_m('cl_lang_Divider')); ?></div>
			<div class="cl-col cl-col-actions">
				<button type="button" class="cl-icon-btn cl-move-up" title="<?php echo htmlspecialchars($i18n_m('cl_lang_Move_up')); ?>">&uarr;</button>
				<button type="button" class="cl-icon-btn cl-move-down" title="<?php echo htmlspecialchars($i18n_m('cl_lang_Move_down')); ?>">&darr;</button>
				<button type="button" class="cl-icon-btn cl-remove-btn" title="<?php echo htmlspecialchars($i18n_m('cl_lang_Remove')); ?>">&times;</button>
			</div>
		</div>
	</template>
</div>

<script>
(function() {
	var uid = '<?php echo $cl_uid; ?>';
	var widget = document.getElementById(uid);
	var modalRoot = document.getElementById(uid + '-modal-root');
	if (!widget || !modalRoot) return;

	document.body.appendChild(modalRoot);

	var gear     = document.getElementById(uid + '-gear');
	var doneBtn  = document.getElementById(uid + '-done');
	var closeBtn = document.getElementById(uid + '-close');
	var backdrop = document.getElementById(uid + '-backdrop');
	var addBtn   = document.getElementById(uid + '-add');
	var addDividerBtn = document.getElementById(uid + '-add-divider');
	var rows     = document.getElementById(uid + '-rows');
	var tmpl     = document.getElementById(uid + '-row-template');
	var dividerTmpl = document.getElementById(uid + '-divider-template');

	function openModal()  { modalRoot.classList.add('cl-modal-open'); }
	function closeModal() { modalRoot.classList.remove('cl-modal-open'); }

	if (gear)     gear.addEventListener('click', openModal);
	if (doneBtn)  doneBtn.addEventListener('click', closeModal);
	if (closeBtn) closeBtn.addEventListener('click', closeModal);
	if (backdrop) backdrop.addEventListener('click', closeModal);

	document.addEventListener('keydown', function(e) {
		if (e.key === 'Escape' && modalRoot.classList.contains('cl-modal-open')) closeModal();
	});

	function bindRow(row) {
		var up   = row.querySelector('.cl-move-up');
		var down = row.querySelector('.cl-move-down');
		var del  = row.querySelector('.cl-remove-btn');

		if (up) up.addEventListener('click', function() {
			var prev = row.previousElementSibling;
			if (prev) rows.insertBefore(row, prev);
		});
		if (down) down.addEventListener('click', function() {
			var next = row.nextElementSibling;
			if (next) rows.insertBefore(next, row);
		});
		if (del) del.addEventListener('click', function() {
			row.parentNode.removeChild(row);
		});
	}

	rows.querySelectorAll('.cl-row').forEach(bindRow);

	function addRowFrom(sourceTmpl) {
		if (!sourceTmpl) return;
		// Remove "no links yet" placeholder if present
		var empty = rows.querySelector('.cl-empty');
		if (empty) empty.parentNode.removeChild(empty);

		var clone = sourceTmpl.content.cloneNode(true);
		rows.appendChild(clone);
		bindRow(rows.lastElementChild);
	}

	if (addBtn) addBtn.addEventListener('click', function() { addRowFrom(tmpl); });
	if (addDividerBtn) addDividerBtn.addEventListener('click', function() { addRowFrom(dividerTmpl); });
})();
</script>
