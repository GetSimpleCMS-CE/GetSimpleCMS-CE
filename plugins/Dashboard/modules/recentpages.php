<?php
/**
 * Module Name: Recent Pages
 * Module ID: recentpages
 * Description: Lists the 10 most recently edited pages.
 * Version: 1.0
 * Default W: 8
 * Default H: 4
 */

if (!defined('IN_GS')) { die('You cannot load this page directly.'); }

// Add $i18n_m for i18n lang files in Modules
$i18n_m = dash_module_i18n('recentpages');

global $SITEURL;

// Unique ID to avoid conflicts between modules (optional)
$uid = 'rp_' . substr(md5(__FILE__), 0, 6);

$pages_path = GSDATAPAGESPATH;
$pages = array();
foreach (glob($pages_path . '*.xml') as $file) {
	$xml = @simplexml_load_file($file);
	if ($xml) {
		$pages[] = array(
			'title'   => (string)$xml->title,
			'url'	 => (string)$xml->url,
			'pubDate' => (string)$xml->pubDate,
		);
	}
}

usort($pages, function($a, $b) {
	return strtotime($b['pubDate']) - strtotime($a['pubDate']);
});
$recent = array_slice($pages, 0, 10);
?>

<style>
#<?php echo $uid ?> .dash-rp-table {
	width: 100%;
	border-collapse: collapse;
	font-size: 12px;
}
#<?php echo $uid ?> .dash-rp-table th {
	text-align: left;
	padding: 5px 8px;
	border-bottom: 2px solid #eee;
	color: #888;
	font-weight: 600;
	white-space: nowrap;
}
#<?php echo $uid ?> .dash-rp-table td {
	padding: 5px 8px;
	border-bottom: 1px solid #f3f3f3;
	vertical-align: middle;
}
#<?php echo $uid ?> .dash-rp-table tr:last-child td { border-bottom: none; }
#<?php echo $uid ?> .dash-rp-table tr:hover td { background: #fafafa; }
#<?php echo $uid ?> .dash-rp-title {
	font-weight: 500;
	color: #333;
	max-width: 200px;
	overflow: hidden;
	text-overflow: ellipsis;
	white-space: nowrap;
}
@media (max-width: 600px) {
	#<?php echo $uid ?> .dash-rp-title {
		max-width: 150px;
	}
}
#<?php echo $uid ?> .dash-rp-date { color: #aaa; white-space: nowrap; }
#<?php echo $uid ?> .dash-rp-actions { white-space: nowrap; }
#<?php echo $uid ?> .dash-rp-btn {
	display: inline-block;
	padding: 4px 6px;
	border-radius: 4px;
	font-size: 11px;
	text-decoration: none;
	margin-left: 8px;
	border: 1px solid transparent;
}
#<?php echo $uid ?> .dash-rp-btn-edit {
	background: #5EBD3E;
	border-color: #ddd;
	color: #fff;
}
#<?php echo $uid ?> .dash-rp-btn-edit:hover { background: #4B9732; }
#<?php echo $uid ?> .dash-rp-btn-view {
	background: #3CB89B;
	border-color: #ddd;
	color: #fff;
}
#<?php echo $uid ?> .dash-rp-btn-view:hover { background: #30927B; }
#<?php echo $uid ?> .dash-rp-empty { color: #bbb; font-style: italic; text-align: center; padding: 16px; }
#<?php echo $uid ?> a.dash-rp-btn.dash-rp-btn-edit { line-height: 18px !important; }
</style> 

<div id="<?php echo $uid ?>">
	<h3><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;" width="24" height="24" viewBox="0 0 24 24"><rect width="24" height="24" fill="none"/><path fill="currentColor" d="M10 19.11L12.11 17H7v-2h7v.12L16.12 13H7v-2h10v1.12l1.24-1.23c.48-.48 1.11-.75 1.8-.75c.33 0 .66.07.96.19V5a2 2 0 0 0-2-2H5c-1.11 0-2 .89-2 2v14a2 2 0 0 0 2 2h5zM7 7h10v2H7zm14.7 7.35l-1 1l-2.05-2.05l1-1a.55.55 0 0 1 .77 0l1.28 1.28c.21.21.21.56 0 .77M12 19.94l6.06-6.06l2.05 2.05L14.06 22H12z"/></svg> <?php echo $i18n_m('rp_lang_Recently_Edited'); ?></h3>

	<?php if (empty($recent)): ?>
		<p class="dash-rp-empty"><?php echo $i18n_m('rp_lang_No_pages'); ?>.</p>
	<?php else: ?>
	<table class="dash-rp-table">
		<tr>
			<th><?php echo $i18n_m('rp_lang_Title'); ?></th>
			<th><?php echo $i18n_m('rp_lang_Edited'); ?></th>
			<th style="text-align:center;"><?php echo $i18n_m('rp_lang_Action'); ?></th>
		</tr>
		<?php foreach ($recent as $page):
			$title   = htmlspecialchars($page['title']);
			$url	 = htmlspecialchars($page['url']);
			$date	= date('Y-m-d, H:i', strtotime($page['pubDate']));
			$editUrl = 'edit.php?id=' . $url;
			$viewUrl = $SITEURL . $url . '/';
		?>
		<tr>
			<td class="dash-rp-title" title="<?php echo $title; ?>"><?php echo $title; ?></td>
			<td class="dash-rp-date"><?php echo $date; ?></td>
			<td class="dash-rp-actions" style="text-align:center;">
				<a class="dash-rp-btn dash-rp-btn-edit" href="<?php echo $editUrl; ?>" title="<?php echo $i18n_m('rp_lang_Edit'); ?>"><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;" width="18" height="18" viewBox="0 0 16 16"><rect width="16" height="16" fill="none"/><path fill="#fff" d="M10.529 1.764a2.621 2.621 0 1 1 3.707 3.707l-.779.779L9.75 2.543zM9.043 3.25L2.657 9.636a2.96 2.96 0 0 0-.772 1.354l-.87 3.386a.5.5 0 0 0 .61.608l3.385-.869a2.95 2.95 0 0 0 1.354-.772l6.386-6.386z"/></svg></a>
				<a class="dash-rp-btn dash-rp-btn-view" href="<?php echo $viewUrl; ?>" target="_blank" title="<?php echo $i18n_m('rp_lang_View'); ?>"><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;" width="18" height="18" viewBox="0 0 100 100"><rect width="100" height="100" fill="none"/><path fill="#fff" d="M56.774 10.391c-17.679 0-32.001 14.329-32.001 32a31.85 31.85 0 0 0 4.588 16.517L13.846 74.423l.054.054c-1.656 1.585-2.673 3.835-2.673 6.378c-.001 4.913 3.913 8.755 8.821 8.754c2.507-.001 4.749-1.004 6.349-2.636l.039.039l16.008-16.009a31.9 31.9 0 0 0 14.33 3.388c17.68 0 31.999-14.327 31.999-32c0-17.671-14.32-32-31.999-32m.194 51.417c-11.05 0-20.001-8.954-20.001-20c0-11.044 8.951-20 20.001-20s19.999 8.955 19.999 20c.001 11.046-8.949 20-19.999 20"/></svg></a>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
	<?php endif; ?>
</div>