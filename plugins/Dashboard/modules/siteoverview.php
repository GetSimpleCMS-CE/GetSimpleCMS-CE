<?php
/**
 * Module Name: Site Overview
 * Module ID: siteoverview
 * Description: Displays page, upload, and user count at a glance.
 * Version: 1.0
 * Default W: 12
 * Default H: 2
 */
 
if (!defined('IN_GS')) { die('You cannot load this page directly.'); }

// Add $i18n_m for i18n lang files in Modules
$i18n_m = dash_module_i18n('siteoverview');

// Unique ID to avoid conflicts between modules (optional)
$uid = 'sov_' . substr(md5(__FILE__), 0, 6);

// ── Counts ────────────────────────────────────────────────
$page_count   = defined('GSDATAPAGESPATH') ? count(glob(GSDATAPAGESPATH . '*.xml') ?: array()) : 0;
$upload_files = defined('GSDATAUPLOADPATH') ? (glob(GSDATAUPLOADPATH . '{*,*/*,*/*/*}', GLOB_BRACE) ?: array()) : array();
$upload_count = count(array_filter($upload_files, 'is_file'));
$user_count   = defined('GSUSERSPATH') ? count(glob(GSUSERSPATH . '*.xml') ?: array()) : 0;

$stats = array(
	array(
		'label' => $i18n_m('so_lang_Pages'),
		'value' => $page_count,
		'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><rect width="32" height="32" fill="none"/><path fill="currentColor" d="M26 5.75a3.25 3.25 0 0 1 2 3v14.5A6.75 6.75 0 0 1 21.25 30h-10.5a3.25 3.25 0 0 1-3-2h13.5A4.75 4.75 0 0 0 26 23.25zM21.25 2a3.25 3.25 0 0 1 3.25 3.25v18a3.25 3.25 0 0 1-3.25 3.25h-14A3.25 3.25 0 0 1 4 23.25v-18A3.25 3.25 0 0 1 7.25 2zm-14 2C6.56 4 6 4.56 6 5.25v18c0 .69.56 1.25 1.25 1.25h14c.69 0 1.25-.56 1.25-1.25v-18c0-.69-.56-1.25-1.25-1.25zM19 19a1 1 0 1 1 0 2H9.5a1 1 0 1 1 0-2zm0-6a1 1 0 1 1 0 2H9.5a1 1 0 1 1 0-2zm0-6a1 1 0 1 1 0 2H9.5a1 1 0 0 1 0-2z"/></svg>',
		'color' => '#4a90d9',
		'glow'  => 'rgba(74,144,217,0.35)',
	),
	array(
		'label' => $i18n_m('so_lang_Uploads'),
		'value' => $upload_count,
		'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect width="24" height="24" fill="none"/><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M20 5a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h2.5a1.5 1.5 0 0 1 1.2.6l.6.8a1.5 1.5 0 0 0 1.2.6z"/><path d="M3 8.268a2 2 0 0 0-1 1.738V19a2 2 0 0 0 2 2h11a2 2 0 0 0 1.732-1"/></g></svg>',
		'color' => '#e8a838',
		'glow'  => 'rgba(232,168,56,0.35)',
	),
	array(
		'label' => $i18n_m('so_lang_Users'),
		'value' => $user_count,
		'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><rect width="24" height="24" fill="none"/><path fill="currentColor" d="M12.3 12.22A4.92 4.92 0 0 0 14 8.5a5 5 0 0 0-10 0a4.92 4.92 0 0 0 1.7 3.72A8 8 0 0 0 1 19.5a1 1 0 0 0 2 0a6 6 0 0 1 12 0a1 1 0 0 0 2 0a8 8 0 0 0-4.7-7.28M9 11.5a3 3 0 1 1 3-3a3 3 0 0 1-3 3m9.74.32A5 5 0 0 0 15 3.5a1 1 0 0 0 0 2a3 3 0 0 1 3 3a3 3 0 0 1-1.5 2.59a1 1 0 0 0-.5.84a1 1 0 0 0 .45.86l.39.26l.13.07a7 7 0 0 1 4 6.38a1 1 0 0 0 2 0a9 9 0 0 0-4.23-7.68"/></svg>',
		'color' => '#5cb85c',
		'glow'  => 'rgba(92,184,92,0.35)',
	),
);

?>
<style>
#<?php echo $uid ?> {
	display: flex;
	gap: 14px;
	padding: 2px 0;
	width: 95%;
	box-sizing: border-box;
	align-items: center;
}
#<?php echo $uid ?> .sov-card {
	flex: 1;
	border-radius: 10px;
	padding: 14px 18px;
	display: flex;
	align-items: center;
	justify-content: space-between;
	gap: 16px;
	color: #fff;
	position: relative;
	overflow: hidden;
	min-width: 0;
	transition: transform 0.18s ease, box-shadow 0.18s ease;
}
#<?php echo $uid ?> .sov-card:hover {
	transform: translateY(-2px);
}
#<?php echo $uid ?> .sov-card::before {
	content: '';
	position: absolute;
	inset: 0;
	background: rgba(255,255,255,0.08);
	border-radius: inherit;
}
#<?php echo $uid ?> .sov-icon {
	flex-shrink: 0;
	width: 50px;
	height: 50px;
	background: rgba(255,255,255,0.18);
	border-radius: 50%;
	display: flex;
	align-items: center;
	justify-content: center;
}
#<?php echo $uid ?> .sov-icon svg {
	width: 36px;
	height: 36px;
	fill: #fff;
}
#<?php echo $uid ?> .sov-body {
	min-width: 0;
	text-align: center;
}
#<?php echo $uid ?> .sov-value {
	font-size: 1.9rem;
	font-weight: 700;
	line-height: 1;
	letter-spacing: -0.02em;
}
#<?php echo $uid ?> .sov-label {
	font-size: 0.72rem;
	font-weight: 500;
	letter-spacing: 0.08em;
	text-transform: uppercase;
	opacity: 0.85;
	margin-top: 3px;
	white-space: nowrap;
	overflow: hidden;
	text-overflow: ellipsis;
}
@media (max-width: 600px) {
	#<?php echo $uid ?> { flex-direction: column; }
	#siteoverview {display: block!important;}
}
@media (max-width: 800px) {
	#maincontent .main #<?php echo $uid ?> div { width: auto; }
	#<?php echo $uid ?> {width: 100%!important;}
}

#siteoverview {display: flex; justify-content: center; align-items: center;}
</style>

<div id="<?php echo $uid ?>">
<?php foreach ($stats as $stat): ?>
	<div class="sov-card" style="background:<?php echo $stat['color'] ?>; box-shadow: 0 4px 18px <?php echo $stat['glow'] ?>;">
		<div class="sov-icon"><?php echo $stat['icon'] ?></div>
		<div class="sov-body">
			<div class="sov-value"><?php echo $stat['value'] ?></div>
			<div class="sov-label"><?php echo $stat['label'] ?></div>
		</div>
	</div>
<?php endforeach; ?>
</div>