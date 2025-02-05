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
	$priority = 0;

	foreach ($menuOrder as $slug) {
		$file = GSDATAPAGESPATH . $slug . '.xml';
		if (file_exists($file)) {
			$data = getXML($file);

			// Update menuOrder
			if ($priority != (int) $data->menuOrder) {
				unset($data->menuOrder);
				$data->addChild('menuOrder')->addCData($priority);
			}

			// Update parent if the page has been moved into or out of a nested position
			$newParent = '';
			$parentLi = $_POST['parent_' . $slug] ?? '';
			if ($parentLi) {
				$newParent = $parentLi;
			}

			if ((string) $data->parent !== $newParent) {
				unset($data->parent);
				$data->addChild('parent')->addCData($newParent);
			}

			// Save the changes
			XMLsave($data, $file);
		}
		$priority++;
	}

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
	#menu-order li {padding-bottom:0!important}
	#menu-order ul.sortable-child {padding-left: 30px; list-style-type: none;}
	ul.sortable.ui-sortable {margin-bottom:0!important}
	/*ul.sortable.ui-sortable li.sortable-placeholder {border:1px solid #F6F6F6!important}*/
</style>

<div class="bodycontent clearfix">

	<div id="maincontent">
		<div class="main">
			<h3><?php echo str_replace(['<em>', '</em>'], '', i18n_r('MENU_MANAGER')); ?></h3>
			<p><?php i18n('MENU_MANAGER_DESC'); ?></p>
			<?php
			if (count($pagesSorted) != 0) {
				echo '<form method="post" action="menu-manager.php">';
				echo '<ul id="menu-order" class="sortable">';
				foreach ($pagesSorted as $page) {
					// Only show top-level pages (no parent) that are marked for display in the menu
					if ($page['menuStatus'] != '' && $page['parent'] == '') {
						if ($page['menuOrder'] == '') {
							$page['menuOrder'] = "N/A";
						}
						if ($page['menu'] == '') {
							$page['menu'] = $page['title'];
						}
						echo '<li class="clearfix" rel="' . $page['slug'] . '">
								<strong>#' . $page['menuOrder'] . '</strong>&nbsp;&nbsp;
								' . $page['menu'] . ' <em>' . $page['title'] . '</em>';
						// Always render a <ul> container for child pages (even if empty)
						echo '<ul class="sortable">';
						renderChildPages($pagesSorted, $page['slug']);
						echo '<li class="sortable-placeholder"></li>'; // Hidden placeholder <li>
						echo '</ul>';
						echo '</li>';
					}
				}
				echo '</ul>';
				echo '<input type="hidden" name="menuOrder" value=""><input class="submit" type="submit" value="' . i18n_r("SAVE_MENU_ORDER") . '" />';
				echo '</form>';
			} else {
				echo '<p>' . i18n_r('NO_MENU_PAGES') . '.</p>';
			}
			?>

			<script>
				$(function() {
					$(".sortable").sortable({
						cursor: 'move',
						placeholder: "placeholder-menu",
						items: "li:not(.sortable-placeholder)", // Exclude the placeholder <li> from being draggable
						connectWith: ".sortable", // Allow dragging between nested lists
						update: function(event, ui) {
							var order = '';
							var parents = {};

							$('#menu-order li').each(function(index) {
								// Skip the placeholder <li> when generating the order
								if (!$(this).hasClass('sortable-placeholder')) {
									var slug = $(this).attr('rel');
									order = order + ',' + slug;

									// Determine the new parent for each page
									var parentLi = $(this).parent('ul').closest('li').attr('rel') || '';
									parents[slug] = parentLi;
								}
							});

							$('[name=menuOrder]').val(order);

							// Add hidden inputs for parent relationships
							for (var slug in parents) {
								$('<input>').attr({
									type: 'hidden',
									name: 'parent_' + slug,
									value: parents[slug]
								}).appendTo('form');
							}
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
		if ($childPage['menuOrder'] == '') {
			$childPage['menuOrder'] = "N/A";
		}
		if ($childPage['menu'] == '') {
			$childPage['menu'] = $childPage['title'];
		}
		echo '<li class="clearfix" rel="' . $childPage['slug'] . '">
				<strong>#' . $childPage['menuOrder'] . '</strong>&nbsp;&nbsp;
				' . $childPage['menu'] . ' <em>' . $childPage['title'] . '</em>';
		// Recursively render nested child pages
		echo '<ul class="sortable">';
		renderChildPages($pages, $childPage['slug']);
		echo '<li class="sortable-placeholder"></li>'; // Hidden placeholder <li>
		echo '</ul>';
		echo '</li>';
	}
}
?>
