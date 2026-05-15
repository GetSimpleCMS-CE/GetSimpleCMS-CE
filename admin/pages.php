<?php
/**
 * All Pages
 *
 * Displays all pages 
 *
 * @package GetSimple
 * @subpackage Page-Edit
 */

// Setup inclusions
$load['plugin'] = true;

// Include common.php
include('inc/common.php');

// Variable settings
login_cookie_check();
$id	  =  isset($_GET['id']) ? $_GET['id'] : null;
$ptype   = isset($_GET['type']) ? $_GET['type'] : null; 
$path	= GSDATAPAGESPATH;
$counter = '0';
$table   = '';

// Get sort parameters
$sortby = isset($_GET['sortby']) ? $_GET['sortby'] : 'menu';
$sortorder = isset($_GET['sortorder']) ? $_GET['sortorder'] : 'asc';

# clone attempt happening
if ( isset($_GET['action']) && isset($_GET['id']) && $_GET['action'] == 'clone') {

	// check for csrf
	if (!defined('GSNOCSRF') || (GSNOCSRF == FALSE) ) {
		$nonce = $_GET['nonce'];
		if(!check_nonce($nonce, "clone", "pages.php")) {
			die("CSRF detected!");  
		}
	}

	$sourceSlug = $_GET['id'];

	if (defined('GSDATABASE') && GSDATABASE == 'sqlite3') {

		// find a free slug: slug-1, slug-2, ...
		$count  = 1;
		$newurl = $sourceSlug . '-' . $count;
		while (gs_db()->querySingle("SELECT id FROM pages WHERE slug = '$newurl' LIMIT 1")) {
			$count++;
			$newurl = $sourceSlug . '-' . $count;
		}

		// fetch source row from database
		$src = gs_db()->prepare("SELECT * FROM pages WHERE slug = :slug LIMIT 1");
		$src->bindValue(':slug', $sourceSlug, SQLITE3_TEXT);
		$row = $src->execute()->fetchArray(SQLITE3_ASSOC);

		if ($row) {
			// insert cloned page with new slug, title suffix and current date
			$ins = gs_db()->prepare("
				INSERT INTO pages
					(slug, title, content, template, meta, metad,
					 menu, menu_order, menu_status, parent, private, pub_date, author)
				VALUES
					(:slug, :title, :content, :template, :meta, :metad,
					 :menu, :menu_order, :menu_status, :parent, :private, :pub_date, :author)
			");
			$ins->bindValue(':slug',		$newurl,								  SQLITE3_TEXT);
			$ins->bindValue(':title',	   $row['title'] . ' ['.i18n_r('COPY').']',  SQLITE3_TEXT);
			$ins->bindValue(':content',	 $row['content'],						  SQLITE3_TEXT);
			$ins->bindValue(':template',	$row['template'],						 SQLITE3_TEXT);
			$ins->bindValue(':author',	  $row['author'],						   SQLITE3_TEXT);
			$ins->bindValue(':meta',		$row['meta'],							 SQLITE3_TEXT);
			$ins->bindValue(':metad',	   $row['metad'],							SQLITE3_TEXT);
			$ins->bindValue(':menu',		$row['menu'],							 SQLITE3_TEXT);
			$ins->bindValue(':menu_order',  $row['menu_order'],					   SQLITE3_INTEGER);
			$ins->bindValue(':menu_status', $row['menu_status'],					  SQLITE3_TEXT);
			$ins->bindValue(':parent',	  $row['parent'],						   SQLITE3_TEXT);
			$ins->bindValue(':private',	 $row['private'],						  SQLITE3_INTEGER);
			$ins->bindValue(':pub_date',	date('r'),								SQLITE3_TEXT);
			$ins->execute();

			header('Location: pages.php?upd=clone-success&id=' . $newurl);
		} else {
			// source page not found
			$error = sprintf(i18n_r('CLONE_ERROR'), $sourceSlug);
			header('Location: pages.php?error=' . $error);
		}

	} else {

		// XML fallback — original logic unchanged
		$count   = 1;
		$newfile = GSDATAPAGESPATH . $sourceSlug . '-' . $count . '.xml';
		if (file_exists($newfile)) {
			while (file_exists($newfile)) {
				$count++;
				$newfile = GSDATAPAGESPATH . $sourceSlug . '-' . $count . '.xml';
			}
		}
		$newurl = $sourceSlug . '-' . $count;

		$status = copy($path . $sourceSlug . '.xml', $path . $newurl . '.xml');
		if ($status) {
			$newxml		  = getXML($path . $newurl . '.xml');
			$newxml->url	 = $newurl;
			$newxml->title   = $newxml->title . ' [' . i18n_r('COPY') . ']';
			$newxml->pubDate = date('r');
			$status		  = XMLsave($newxml, $path . $newurl . '.xml');
			if ($status) {
				create_pagesxml('true');
				header('Location: pages.php?upd=clone-success&id=' . $newurl);
			} else {
				$error = sprintf(i18n_r('CLONE_ERROR'), $sourceSlug);
				header('Location: pages.php?error=' . $error);
			}
		} else {
			$error = sprintf(i18n_r('CLONE_ERROR'), $sourceSlug);
			header('Location: pages.php?error=' . $error);
		}
	}
}

getPagesXmlValues(true);

// CE admin sort page 
$count = 0;
foreach ($pagesArray as $page) {
	
	if ($sortby == 'title') {
		if ($page['parent'] != '') {
			$parentTitle = returnPageField($page['parent'], "title");
			$sort = $parentTitle .' '. $page['title'];		
		} else {
			$sort = $page['title'];
		}
	} elseif ($sortby == 'date') {
		$sort = $page['pubDate'];
	} else {
		if ($page['parent'] != '') {
			$parentTitle = returnPageField($page['parent'], "menuOrder");
			$sort = $parentTitle .' '. $page['menuOrder'];		
		} else {
			$sort = $page['menuOrder'];
		}
	}
	
	$page = array_merge($page, ['sort' => $sort]);
	$pagesArray_tmp[$count] = $page;
	$count++;
}

// Sort with specified order
$pagesSorted = subval_sort($pagesArray_tmp, 'sort');
if ($sortorder == 'desc') {
	$pagesSorted = array_reverse($pagesSorted);
}

$table = get_pages_menu('','',0);

get_template('header', cl($SITENAME).' &raquo; '.i18n_r('PAGE_MANAGEMENT')); 

?>

<?php include('template/include-nav.php'); ?>
	
<div class="bodycontent clearfix">
	
	<div id="maincontent">
	<?php exec_action('pages-main'); ?>
		<div class="main">
			<h3 class="floated"><?php i18n('PAGE_MANAGEMENT'); ?></h3>
			<div class="edit-nav clearfix" >
				<a href="#" id="filtertable" accesskey="<?php echo find_accesskey(i18n_r('FILTER'));?>" ><?php i18n('FILTER'); ?></a>
				<a href="#" id="show-characters" accesskey="<?php echo find_accesskey(i18n_r('TOGGLE_STATUS'));?>" ><?php i18n('TOGGLE_STATUS'); ?></a>
			</div>
			<div id="filter-search">
				<form><input type="text" autocomplete="off" class="text" id="q" placeholder="<?php echo strip_tags(lowercase(i18n_r('FILTER'))); ?>..." /> &nbsp; <a href="pages.php" class="cancel"><?php i18n('CANCEL'); ?></a></form>
			</div>
			
			<table id="editpages" class="edittable highlight paginate">
				<tr>
					<th class="sortable" data-sort="title">
						<a href="?sortby=title&sortorder=<?php echo ($sortby == 'title' && $sortorder == 'asc') ? 'desc' : 'asc'; ?>">
							<?php i18n('PAGE_TITLE'); ?>
							<?php if ($sortby == 'title'): ?>
								<span class="sort-indicator"><?php echo $sortorder == 'asc' ? '▲' : '▼'; ?></span>
							<?php endif; ?>
						</a>
					</th>
					<th class="sortable" style="text-align:right;" data-sort="date">
						<a href="?sortby=date&sortorder=<?php echo ($sortby == 'date' && $sortorder == 'asc') ? 'desc' : 'asc'; ?>">
							<?php i18n('DATE'); ?>
							<?php if ($sortby == 'date'): ?>
								<span class="sort-indicator"><?php echo $sortorder == 'asc' ? '▲' : '▼'; ?></span>
							<?php endif; ?>
						</a>
					</th>
					<th></th>
					<th></th>
				</tr>
				<?php echo $table; ?>
			</table>
			<p><em><b><span id="pg_counter"><?php echo $count; ?></span></b> <?php i18n('TOTAL_PAGES'); ?></em></p>
			
		</div>
	</div><!-- end maincontent -->
	
	<div id="sidebar" >
		<?php include('template/sidebar-pages.php'); ?>
	</div>

</div>

<style>
.sortable {
	cursor: pointer;
	user-select: none;
}
.sortable a {
	color: #222!important;
	text-decoration: none!important;
	display: block;
	width: 100%;
}
.sortable a:hover {
	text-decoration: underline!important;
}
.sort-indicator {
	font-size: 0.8em;
	margin-left: 5px;
}
#editpages tr.l-0:nth-child(1) {
	background:#E1E1E1!important
}
.wrapper table.highlight {
	text-shadow: none;
}
</style>

<?php get_template('footer'); ?>
