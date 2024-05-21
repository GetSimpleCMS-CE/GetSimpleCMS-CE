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

# save page priority order
if (isset($_POST['menuOrder'])) {
	$menuOrder = explode(',',$_POST['menuOrder']);
	$priority = 0;
	foreach ($menuOrder as $slug) {
		$file = GSDATAPAGESPATH . $slug . '.xml';
		if (file_exists($file)) {
			$data = getXML($file);
			if ($priority != (int) $data->menuOrder) {
				unset($data->menuOrder);
				$data->addChild('menuOrder')->addCData($priority);
				XMLsave($data,$file);
			}
		}
		$priority++;
	}
	create_pagesxml('true');
	$success = i18n_r('MENU_MANAGER_SUCCESS');
}

# get pages
getPagesXmlValues();
$pagesSorted = subval_sort($pagesArray,'menuOrder');

get_template('header', cl($SITENAME).' &raquo; '.i18n_r('PAGE_MANAGEMENT').' &raquo; '.str_replace(['<em>', '</em>'], '', i18n_r('MENU_MANAGER'))); 

?>
	
<?php include('template/include-nav.php'); ?>

<div class="bodycontent clearfix">
	
	<div id="maincontent">
		<div class="main" >
			<h3><?php echo str_replace(['<em>', '</em>'], '', i18n_r('MENU_MANAGER')); ?></h3>
			<p><?php i18n('MENU_MANAGER_DESC'); ?></p>
			<?php
				if (count($pagesSorted) != 0) { 
					echo '<form method="post" action="menu-manager.php">';
					echo '<ul id="menu-order" >';
					foreach ($pagesSorted as $page) {
						$sel = '';
						if ($page['menuStatus'] != '') { 
							
							if ($page['menuOrder'] == '') { 
								$page['menuOrder'] = "N/A"; 
							} 
							if ($page['menu'] == '') { 
								$page['menu'] = $page['title']; 
							}
							echo '<li class="clearfix" rel="'.$page['slug'].'">
											<strong>#'.$page['menuOrder'].'</strong>&nbsp;&nbsp;
											'. $page['menu'] .' <em>'. $page['title'] .'</em>
										</li>';
						}
					}
					echo '</ul>';
					echo '<input type="hidden" name="menuOrder" value=""><input class="submit" type="submit" value="'. i18n_r("SAVE_MENU_ORDER").'" />';
					echo '</form>';
				} else {
					echo '<p>'.i18n_r('NO_MENU_PAGES').'.</p>';	
				}
			?>
			
			<!-- Sortable.js -->
			<script src="<?php echo $SITEURL;?>admin/template/js/Sortable.min.js"></script>

			<!-- Skrypt JavaScript -->
			<script>
				document.addEventListener('DOMContentLoaded', function () {
					var menuOrder = document.getElementById('menu-order');

					// Utwórz instancję Sortable.js dla menu-order
					new Sortable(menuOrder, {
						animation: 150,
						ghostClass: 'sortable-ghost',
						onEnd: function () {
							var order = '';
							var menuItems = menuOrder.getElementsByTagName('li');
							for (var i = 0; i < menuItems.length; i++) {
								var cat = menuItems[i].getAttribute('rel');
								order = order + ',' + cat;
							}
							document.querySelector('[name="menuOrder"]').value = order;
						}
					});

					// Wyłącz możliwość zaznaczania tekstu w menu-order
					disableTextSelection(menuOrder);
				});

				// Funkcja do wyłączania możliwości zaznaczania tekstu
				function disableTextSelection(element) {
					if (typeof element.onselectstart != 'undefined') { // IE
						element.onselectstart = function () { return false; };
					} else if (typeof element.style.MozUserSelect != 'undefined') { // Firefox
						element.style.MozUserSelect = 'none';
					} else { // All others
						element.onmousedown = function () { return false; };
					}
				}
			</script>
			
		</div>
	</div>
	
	<div id="sidebar" >
		<?php include('template/sidebar-pages.php'); ?>
	</div>

</div>
<?php get_template('footer'); ?>