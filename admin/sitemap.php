<?php
/**
 * View Sitemap
 *
 * Displays your site's sitemap
 *
 * @package GetSimple
 * @subpackage Theme
 */
 
// Setup inclusions
$load['plugin'] = true;
include('inc/common.php');
login_cookie_check();

$sitemap = generate_sitemap();
if ($sitemap !== true) {
	$error = $sitemap;
} else {
	if (isset($_GET['refresh'])) {
		$success = i18n_r('SITEMAP_REFRESHED');
	}
}

get_template('header', cl($SITENAME).' &raquo; '.strip_tags(i18n_r('SIDE_VIEW_SITEMAP'))); 

?>
	
<?php include('template/include-nav.php'); ?>

<div class="bodycontent clearfix">
	<div id="maincontent">
		<div class="main" >
			<h3 class="floated"><?php echo i18n('SIDE_VIEW_SITEMAP'); ?></h3>
			<div class="edit-nav clearfix" >
				<a href="../sitemap.xml" target="_blank" accesskey="<?php echo find_accesskey(i18n_r('VIEW'));?>" ><?php i18n('VIEW'); ?></a>
				<a href="sitemap.php?refresh" accesskey="<?php echo find_accesskey(i18n_r('REFRESH'));?>" ><?php i18n('REFRESH'); ?></a>
			</div>
					
			<?php
			if (file_exists('../sitemap.xml')) {

				$xml = simplexml_load_file('../sitemap.xml');
				$xml->registerXPathNamespace('sm', 'http://www.sitemaps.org/schemas/sitemap/0.9');
				$urlNodes = $xml->xpath('//sm:url');

				$urls = [];
				foreach ($urlNodes as $url) {
					$urls[] = [
						'loc'        => (string)$url->loc,
						'lastmod'    => (string)$url->lastmod,
						'changefreq' => (string)$url->changefreq,
						'priority'   => (string)$url->priority,
					];
				}

				usort($urls, function ($a, $b) {
					return strtotime($b['lastmod']) <=> strtotime($a['lastmod']);
				});
			?>

			<style>
				.gs-sitemap-table {
					width: 100%;
					border-collapse: collapse;
					margin-top: 15px;
					font-size: 13px;
				}
				.gs-sitemap-table a{
					text-decoration:none!important;
				}
				.gs-sitemap-table a:hover{
					text-decoration:underline!important;
				}
				.gs-sitemap-table th,
				.gs-sitemap-table td {
					padding: 8px 10px;
					border-bottom: 1px solid #ddd;
					text-align: left;
					vertical-align: top;
				}
				.gs-sitemap-table th {
					background: #f4f4f4;
					font-weight: 600;
				}
				.gs-sitemap-table tr:hover {
					background: #f9f9f9;
				}
				.row-404 {
					background: #fff3f3;
				}
				.row-system {
					background: #fffbe6;
				}
				.gs-label {
					font-size: 11px;
					padding: 3px 7px;
					border-radius: 3px;
					font-weight: 600;
					display: inline-block;
				}
				.label-normal {
					background: #5cb85c;
					color: #fff!important;
				}
				.label-404 {
					background: #d9534f;
					color: #fff!important;
				}
				.label-system {
					background: #f0ad4e;
					color: #fff!important;
				}
			</style>

			<table class="gs-sitemap-table">
				<thead>
					<tr>
						<th>URL</th>
						<th>Type</th>
						<th>Last Modified</th>
						<th>Change</th>
						<th>Priority</th>
					</tr>
				</thead>
				<tbody>

			<?php foreach ($urls as $url):

				$loc = $url['loc'];

				$is404 = (strpos($loc, 'id=404') !== false);
				$isSystem = (!$is404 && strpos($loc, 'index.php?id=') !== false);

				if ($is404) {
					$typeLabel = '404 page';
					$labelClass = 'label-404';
					$rowClass = 'row-404';
				} elseif ($isSystem) {
					$typeLabel = 'System URL';
					$labelClass = 'label-system';
					$rowClass = 'row-system';
				} else {
					$typeLabel = 'Normal';
					$labelClass = 'label-normal';
					$rowClass = '';
				}
			?>

				<tr class="<?php echo $rowClass; ?>">
					<td>
						<a href="<?php echo htmlspecialchars($loc); ?>" target="_blank">
							<?php echo htmlspecialchars($loc); ?>
						</a>
					</td>
					<td>
						<span class="gs-label <?php echo $labelClass; ?>">
							<?php echo $typeLabel; ?>
						</span>
					</td>
					<td><?php echo htmlspecialchars($url['lastmod']); ?></td>
					<td><?php echo htmlspecialchars($url['changefreq']); ?></td>
					<td><strong><?php echo htmlspecialchars($url['priority']); ?></strong></td>
				</tr>

			<?php endforeach; ?>

				</tbody>
			</table>

			<?php } ?>
		
		</div>
	</div>
	
	<div id="sidebar" >
	<?php include('template/sidebar-theme.php'); ?>
	</div>	

</div>
<?php get_template('footer'); ?>
