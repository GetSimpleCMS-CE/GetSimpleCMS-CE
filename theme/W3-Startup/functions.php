<?php


function get_custom_navigation($currentpage = "",$classPrefix = "") {

	$menu = '';

	global $pagesArray,$id;
	if(empty($currentpage)) $currentpage = $id;
	
	$pagesSorted = subval_sort($pagesArray,'menuOrder');
	if (count($pagesSorted) != 0) { 
		foreach ($pagesSorted as $page) {
			$sel = ''; $classes = '';
			$url_nav = $page['url'];
			
			if ($page['menuStatus'] == 'Y') { 
				$parentClass = !empty($page['parent']) ? $classPrefix.$page['parent'] . " " : "";
				$classes = trim( $parentClass.$classPrefix.$url_nav);
				if ($currentpage == $url_nav) $classes .= " current active";
				if ($page['menu'] == '') { $page['menu'] = $page['title']; }
				if ($page['title'] == '') { $page['title'] = $page['menu']; }
				$menu .= '<a href="'. find_url($page['url'],$page['parent']) . '" title="'. encode_quotes(cl($page['title'])) .'" class="w3-bar-item w3-button '. $classes .'">'.strip_decode($page['menu']).'</a>'."\n";
			}
		}
	}
	echo exec_filter('menuitems',$menu);
}
