<?php if(!defined('IN_GS')){ die('you cannot load this page directly.'); }
/****************************************************
*
* @File:  caching_functions.php
* @Package: GetSimple
* @since 3.1
* @Action:  Plugin to create pages.xml and new functions  
*
*****************************************************/

$pagesArray = [];

add_action('index-header','getPagesXmlValues',[false]);		// make $pagesArray available to the front 
add_action('header', 'getPagesXmlValues',[get_filename_id() != 'pages']); // make $pagesArray available to the back
add_action('page-delete', 'create_pagesxml',[true]);		// Create pages.array if page deleted
add_action('page-restored', 'create_pagesxml',[true]);		// Create pages.array if page undo
add_action('changedata-aftersave', 'create_pagesxml',[true]); // Create pages.array if page is updated

/**
 * Get Page Content
 *
 * Retrieve and display the content of the requested page. 
 * As the Content is not cahed the file is read in.
 *
 * @since 2.0
 * @param $page - slug of the page to retrieve content
 *
 */
function getPageContent($page, $field = 'content') {

	// --- SQLite3 path ---
	if (defined('GSDATABASE') && GSDATABASE == 'sqlite3') {
		$stmt = gs_db()->prepare("SELECT * FROM pages WHERE slug = :slug LIMIT 1");
		$stmt->bindValue(':slug', $page, SQLITE3_TEXT);
		$row = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
		if (!$row) return;
		$content = stripslashes(htmlspecialchars_decode($row[$field] ?? '', ENT_QUOTES));
		if ($field === 'content') {
			$content = exec_filter('content', $content);
		}
		echo $content;
		return;
	}

	// --- XML path ---
	$path = GSDATAPAGESPATH . $page . '.xml';
	// Guard: file must exist before reading
	if (!file_exists($path)) return;
	$data = simplexml_load_string(file_get_contents($path));
	// Guard: bail on corrupt XML
	if (!$data) return;
	$content = stripslashes(htmlspecialchars_decode($data->$field, ENT_QUOTES));
	if ($field === 'content') {
		$content = exec_filter('content', $content);
	}
	echo $content;
}

/**
 * Get Page Field
 *
 * Retrieve and display the requested field from the given page. 
 *
 * @since 3.1
 * @param $page - slug of the page to retrieve content
 * @param $field - the Field to display
 * 
 */
function getPageField($page,$field){   
	global $pagesArray;
	if(!$pagesArray) getPagesXmlValues();	
	
	if ($field=="content"){
	  getPageContent($page);  
	} else {
		if (array_key_exists($field, $pagesArray[(string)$page])){
	  		echo strip_decode($pagesArray[(string)$page][(string)$field]);
		} else {
			getPageContent($page,$field);
		}
	} 
}

/**
 * Echo Page Field
 *
 * Retrieve and display the requested field from the given page. 
 *
 * @since 3.1
 * @param $page - slug of the page to retrieve content
 * @param $field - the Field to display
 * 
 */
function echoPageField($page,$field){
	getPageField($page,$field);
}


/**
 * Return Page Content
 *
 * Return the content of the requested page. 
 * As the Content is not cahed the file is read in.
 *
 * @since 3.1
 * @param $page - slug of the page to retrieve content
 * @param $raw false - if true return raw xml
 * @param $nofilter false - if true skip content filter execution
 *
 */
function returnPageContent($page, $field = 'content', $raw = false, $nofilter = false) {

	// --- SQLite3 path ---
	if (defined('GSDATABASE') && GSDATABASE == 'sqlite3') {
		$stmt = gs_db()->prepare("SELECT * FROM pages WHERE slug = :slug LIMIT 1");
		$stmt->bindValue(':slug', $page, SQLITE3_TEXT);
		$row = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
		if (!$row) return null;
		$content = $row[$field] ?? '';
		if (!$raw) $content = stripslashes(htmlspecialchars_decode($content, ENT_QUOTES));
		// Use && instead of 'and' — higher operator precedence
		if ($field === 'content' && !$nofilter) {
			$content = exec_filter('content', $content);
		}
		return $content;
	}

	// --- XML path ---
	$thisfile = file_get_contents(GSDATAPAGESPATH . $page . '.xml');
	$data	 = simplexml_load_string($thisfile);
	if (!$data) return null;
	$content = $data->$field;
	if (!$raw) $content = stripslashes(htmlspecialchars_decode($content, ENT_QUOTES));
	// Use && instead of 'and' — higher operator precedence
	if ($field === 'content' && !$nofilter) {
		$content = exec_filter('content', $content);
	}
	return $content;
}

/**
 * Get Page Field
 *
 * Retrieve and display the requested field from the given page. 
 * If the field is "content" it will call returnPageContent()
 *
 * @since 3.1
 * @param $page - slug of the page to retrieve content
 * @param $field - the Field to display
 * 
 */
function returnPageField($page,$field){   
	global $pagesArray;
	if(!$pagesArray) getPagesXmlValues();	

	if ($field=="content"){
	  $ret=returnPageContent($page); 
	} else {
		if (isset($pagesArray[(string)$page]) && array_key_exists($field, $pagesArray[(string)$page])){
	  		$ret=strip_decode(@$pagesArray[(string)$page][(string)$field]);
		} else {
			$ret = returnPageContent($page,$field);
		}
	} 
	return $ret;
}

/**
 * Get Page Children
 *
 * Return an Array of pages that are children of the requested page/slug
 *
 * @since 3.1
 * @param $page - slug of the page to retrieve content
 * 
 * @returns - Array of slug names 
 * 
 */
function getChildren($page){
	global $pagesArray;
	if(!$pagesArray) getPagesXmlValues();		
	$returnArray = [];
	foreach ($pagesArray as $key => $value) {
		if ($pagesArray[$key]['parent']==$page){
		  $returnArray[]=$key;
		}
	}
	return $returnArray;
}

/**
 * Get Page Children - returns multi fields
 *
 * Return an Array of pages that are children of the requested page/slug with optional fields.
 *
 * @since 3.1
 * @param $page - slug of the page to retrieve content
 * @param options - array of optional fields to return
 * 
 * @returns - Array of slug names and optional fields. 
 * 
 */

function getChildrenMulti($page,$options=[]){
	global $pagesArray;
	if(!$pagesArray) getPagesXmlValues();		
	$count=0;
	$returnArray = [];
	foreach ($pagesArray as $key => $value) {
		if ($pagesArray[$key]['parent']==$page){
		  	$returnArray[$count]=[];
			$returnArray[$count]['url']=$key;
			foreach ($options as $option){
				$returnArray[$count][$option]=returnPageField($key,$option);
			}
			$count++;
		}
	}
	return $returnArray;
}

/**
 * Get Cached Pages XML Values
 *
 * Loads the Cached XML data into the Array $pagesArray
 * If the file does not exist it is created the first time. 
 *
 * @since 3.1
 *  
 */
function getPagesXmlValues($chkcount = false) {
	global $pagesArray;

	// Always reset on explicit call (force fresh data after save)
	if ($chkcount === false) {
		$pagesArray = null;
	}

	if (!$pagesArray) {
		$pagesArray = [];

		if (defined('GSDATABASE') && GSDATABASE == 'sqlite3' && function_exists('gs_db')) {
			// --- SQLite3 path ---
			$result = gs_db()->query("SELECT * FROM pages ORDER BY menu_order ASC");
			while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
				$key			   = $row['slug'];
				$row['url']		= $row['slug'];
				$row['menuStatus'] = $row['menu_status'];
				$row['menuOrder']  = $row['menu_order'];
				$row['pubDate']	= $row['pub_date'];
				$pagesArray[$key]  = $row;
			}

		} else {
			// --- XML path ---
			$file = GSDATAOTHERPATH . "pages.xml";
			if (file_exists($file)) {
				$data  = simplexml_load_string(file_get_contents($file));
				$pages = $data->item;
				foreach ($pages as $page) {
					$key = (string) $page->url;
					$pagesArray[$key] = [];
					foreach ($page->children() as $opt => $val) {
						$pagesArray[$key][(string)$opt] = (string)$val;
					}
				}
			} else {
				// No cache file — regenerate and reload
				if (create_pagesxml(true)) getPagesXmlValues(false);
				return;
			}
		}
	}

	// Check cache vs actual files — XML only, skip for SQLite3
	if ($chkcount === true && !(defined('GSDATABASE') && GSDATABASE == 'sqlite3')) {
		$path	   = GSDATAPAGESPATH;
		$dir_handle = opendir($path);
		if ($dir_handle === false) {
			debugLog("getPagesXmlValues: Unable to open $path");
			return;
		}
		$filenames = [];
		while ($filename = readdir($dir_handle)) {
			if (substr($filename, strrpos($filename, '.') + 1) === 'xml') {
				$filenames[] = $filename;
			}
		}
		closedir($dir_handle);

		if (count($pagesArray) != count($filenames)) {
			$pagesArray = null;
			if (create_pagesxml(true)) getPagesXmlValues(false);
		}
	}
  
}

/**
 * Create the Cached Pages XML file
 *
 * Reads in each page of the site and creates a single XML file called 
 * data/pages/pages.array 
 *
 * @since 3.1
 *  
 */
function create_pagesxml($flag) {
	global $pagesArray;

	$success = '';

	// Removed $_GET['upd'] check — it was an unnecessary attack surface;
	// all legitimate callers already pass $flag = true via hooks.
	if ($flag === true || $flag == 'true') {
		$pagesArray = [];
		$filem	  = GSDATAOTHERPATH . "pages.xml";
		$path	   = GSDATAPAGESPATH;

		$dir_handle = opendir($path);
		// Guard: log and return false instead of die()
		if ($dir_handle === false) {
			debugLog("create_pagesxml: Unable to open $path");
			return false;
		}

		$filenames = [];
		while ($filename = readdir($dir_handle)) {
			if (substr($filename, strrpos($filename, '.') + 1) === 'xml') {
				$filenames[] = $filename;
			}
		}
		// Always close the directory handle
		closedir($dir_handle);

		$count = 0;
		$xml   = new SimpleXMLExtended('<?xml version="1.0" encoding="UTF-8"?><channel></channel>');

		foreach ($filenames as $file) {
			if ($file === '.' || $file === '..' || is_dir(GSDATAPAGESPATH . $file) || $file === '.htaccess') {
				continue;
			}

			$data = simplexml_load_string(file_get_contents($path . $file));
			if (!$data) {
				debugLog("create_pagesxml: page $file is corrupt");
				continue;
			}

			$count++;
			$id	= $data->url;
			$pages = $xml->addChild('item');

			foreach ($data->children() as $item => $itemdata) {
				if ($item !== 'content') {
					$note = $pages->addChild($item);
					$note->addCData($itemdata);
					$pagesArray[(string)$id][$item] = (string)$itemdata;
				}
			}

			$note = $pages->addChild('slug');
			$note->addCData($id);
			$pagesArray[(string)$id]['slug'] = (string)$id;

			$pagesArray[(string)$id]['filename'] = $file;
			$note = $pages->addChild('filename');
			$note->addCData($file);

			// --- SQLite3: sync page record from XML into DB ---
			if (defined('GSDATABASE') && GSDATABASE == 'sqlite3') {
				$stmt = gs_db()->prepare("
					INSERT INTO pages (slug, title, content, template, meta, metad, menu, menu_order, menu_status, parent, private, pub_date)
					VALUES (:slug, :title, :content, :template, :meta, :metad, :menu, :menu_order, :menu_status, :parent, :private, :pub_date)
					ON CONFLICT(slug) DO UPDATE SET
						title	   = excluded.title,
						template	= excluded.template,
						meta		= excluded.meta,
						metad	   = excluded.metad,
						menu		= excluded.menu,
						menu_order  = excluded.menu_order,
						menu_status = excluded.menu_status,
						parent	  = excluded.parent,
						private	 = excluded.private,
						pub_date	= excluded.pub_date
				");
				$stmt->bindValue(':slug',		(string) $data->url,						SQLITE3_TEXT);
				$stmt->bindValue(':title',	   (string) $data->title,					  SQLITE3_TEXT);
				$stmt->bindValue(':content',	 (string) $data->content,					SQLITE3_TEXT);
				$stmt->bindValue(':template',	(string) $data->template ?: 'template.php', SQLITE3_TEXT);
				$stmt->bindValue(':meta',		(string) $data->meta,					   SQLITE3_TEXT);
				$stmt->bindValue(':metad',	   (string) $data->metad,					  SQLITE3_TEXT);
				$stmt->bindValue(':menu',		(string) $data->menu,					   SQLITE3_TEXT);
				$stmt->bindValue(':menu_order',  (int)	$data->menuOrder,				  SQLITE3_INTEGER);
				$stmt->bindValue(':menu_status', (string) $data->menuStatus ?: 'Y',		  SQLITE3_TEXT);
				$stmt->bindValue(':parent',	  (string) $data->parent,					 SQLITE3_TEXT);
				$stmt->bindValue(':private',	 (string) $data->private ? 1 : 0,			SQLITE3_INTEGER);
				$stmt->bindValue(':pub_date',	(string) $data->pubDate,					SQLITE3_TEXT);
				$stmt->execute();
			}
		}

		// Allow plugins to modify the page cache before saving
		$xml = exec_filter('pagecache', $xml);

		if ($xml) {
			$success = XMLsave($xml, $filem);
		}

		exec_action('pagecache-aftersave');
		return $success;
	}
}

?>
