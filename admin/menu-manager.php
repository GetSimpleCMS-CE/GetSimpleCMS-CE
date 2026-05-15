<?php 
/**
 * Menu Manager
 *
 * Allows you to edit the current main menu hierarchy  
 *
 * @package GetSimple
 * @subpackage Page-Edit
 */

# Setup
$load['plugin'] = true;
include('inc/common.php');
login_cookie_check();

# save page priority order and parent relationships
if (isset($_POST['menuOrder'])) {
	$menuOrder = explode(',', $_POST['menuOrder']);
	// Remove empty first element caused by leading comma
	$menuOrder = array_filter($menuOrder);
	$priority  = 0;

	if (defined('GSDATABASE') && GSDATABASE == 'sqlite3' && function_exists('gs_db')) {
		foreach ($menuOrder as $slug) {
			$slug_safe = gs_db()->escapeString(trim($slug));
			$newParent = gs_db()->escapeString($_POST['parent_' . $slug] ?? '');
			gs_db()->exec("UPDATE pages SET menu_order = $priority, parent = '$newParent' WHERE slug = '$slug_safe'");
			$priority++;
		}
	} else {
		foreach ($menuOrder as $slug) {
			$slug = trim($slug);
			$file = GSDATAPAGESPATH . $slug . '.xml';
			if (file_exists($file)) {
				$data = getXML($file);

				if ($priority != (int) $data->menuOrder) {
					unset($data->menuOrder);
					$data->addChild('menuOrder')->addCData($priority);
				}

				$newParent = $_POST['parent_' . $slug] ?? '';

				if ((string) $data->parent !== $newParent) {
					unset($data->parent);
					$data->addChild('parent')->addCData($newParent);
				}

				XMLsave($data, $file);
			}
			$priority++;
		}
	}

	// Rebuild pages.xml cache
	create_pagesxml('true');
	$success = i18n_r('MENU_MANAGER_SUCCESS');
}

# get pages
getPagesXmlValues();
$pagesSorted = subval_sort($pagesArray, 'menuOrder');

get_template('header', cl($SITENAME) . ' &raquo; ' . i18n_r('PAGE_MANAGEMENT') . ' &raquo; ' . str_replace(['<em>', '</em>'], '', i18n_r('MENU_MANAGER')));

?>

<?php include('template/include-nav.php'); ?>

<style>
	#menu-order li { padding-bottom: 0 !important; }
	#menu-order ul.sortable-child { padding-left: 30px; list-style-type: none; }
	ul.sortable.ui-sortable { margin-bottom: 0 !important; }
</style>

<div class="bodycontent clearfix">

	<div id="maincontent">
		<div class="main">
			<h3><?php echo str_replace(['<em>', '</em>'], '', i18n_r('MENU_MANAGER')); ?></h3>
			<p><?php i18n('MENU_MANAGER_DESC'); ?></p>

			<?php if (count($pagesSorted) != 0): ?>
				<form method="post" action="menu-manager.php">
					<ul id="menu-order" class="sortable">
						<?php foreach ($pagesSorted as $page): ?>
							<?php if ($page['menuStatus'] != '' && $page['parent'] == ''): ?>
								<?php
								$menuOrder_display = ($page['menuOrder'] == '') ? 'N/A' : $page['menuOrder'];
								$menuLabel		 = ($page['menu'] == '')	  ? $page['title'] : $page['menu'];
								?>
								<li class="clearfix" rel="<?php echo htmlspecialchars($page['slug']); ?>">
									<strong>#<?php echo $menuOrder_display; ?></strong>&nbsp;&nbsp;
									<?php echo htmlspecialchars($menuLabel); ?>
									<em><?php echo htmlspecialchars($page['title']); ?></em>
									<ul class="sortable">
										<?php renderChildPages($pagesSorted, $page['slug']); ?>
										<li class="sortable-placeholder"></li>
									</ul>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
					<input type="hidden" name="menuOrder" value="" />
					<input class="submit" type="submit" value="<?php echo i18n_r('SAVE_MENU_ORDER'); ?>" />
				</form>
			<?php else: ?>
				<p><?php echo i18n_r('NO_MENU_PAGES'); ?>.</p>
			<?php endif; ?>

			<script>
				$(function() {
					$(".sortable").sortable({
						cursor: 'move',
						placeholder: "placeholder-menu",
						items: "li:not(.sortable-placeholder)",
						connectWith: ".sortable",
				 update: function(event, ui) {
	 if (this.id !== 'menu-order') return;

	var order   = '';
	var parents = {};

	$('#menu-order li').each(function() {
		if (!$(this).hasClass('sortable-placeholder')) {
			var slug = $(this).attr('rel');
			order += ',' + slug;
			parents[slug] = $(this).parent('ul').closest('li').attr('rel') || '';
		}
	});

	$('[name=menuOrder]').val(order);

	$('input[name^="parent_"]').remove();

	$.each(parents, function(slug, parentSlug) {
		$('<input>').attr({
			type:  'hidden',
			name:  'parent_' + slug,
			value: parentSlug
		}).appendTo('form');
	});
}
					}).disableSelection();
				});
			</script>

		</div>
	</div>

	<div id="sidebar">
		<?php include('template/sidebar-pages.php'); ?>
	</div>

</div>
<?php get_template('footer'); ?>

<?php
// Helper function to recursively render child pages
function renderChildPages($pages, $parentSlug) {
	$childPages = array_filter($pages, function($page) use ($parentSlug) {
		return $page['parent'] === $parentSlug && $page['menuStatus'] != '';
	});

	foreach ($childPages as $childPage) {
		$menuOrder_display = ($childPage['menuOrder'] == '') ? 'N/A' : $childPage['menuOrder'];
		$menuLabel		 = ($childPage['menu'] == '')	  ? $childPage['title'] : $childPage['menu'];

		echo '<li class="clearfix" rel="' . htmlspecialchars($childPage['slug']) . '">';
		echo '<strong>#' . $menuOrder_display . '</strong>&nbsp;&nbsp;';
		echo htmlspecialchars($menuLabel);
		echo ' <em>' . htmlspecialchars($childPage['title']) . '</em>';
		echo '<ul class="sortable">';
		renderChildPages($pages, $childPage['slug']);
		echo '<li class="sortable-placeholder"></li>';
		echo '</ul>';
		echo '</li>';
	}
}
?>