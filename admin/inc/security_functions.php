<?php
/**
 * Security
 *
 * @package GetSimple
 * @subpackage init
 */

/*
 * File and File MIME-TYPE Blacklist arrays
 */
$mime_type_blacklist = [
	# HTML may contain cookie-stealing JavaScript and web bugs
	'text/html', 'text/javascript', 'text/x-javascript',  'application/x-shellscript',
	# PHP scripts may execute arbitrary code on the server
	'application/x-php', 'text/x-php', 'application/php', 'application/x-httpd-php', 'application/x-httpd-php-source',
	# Other types that may be interpreted by some servers
	'text/x-python', 'text/x-perl', 'text/x-bash', 'text/x-sh', 'text/x-csh',
	# Client-side hazards on Internet Explorer
	'text/scriptlet', 'application/x-msdownload',
	# Windows metafile, client-side vulnerability on some systems
	'application/x-msmetafile',
	# MS Office OpenXML and other Open Package Conventions files are zip files
	# and thus blacklisted just as other zip files
	'application/x-opc+zip'
];
$file_ext_blacklist = [
	# HTML may contain cookie-stealing JavaScript and web bugs
	'html', 'htm', 'js', 'jsb', 'mhtml', 'mht',
	# PHP scripts may execute arbitrary code on the server
	'php', 'pht', 'phtm', 'phtml', 'php3', 'php4', 'php5', 'ph3', 'ph4', 'ph5', 'phps', 'phar', 'php7', 'php8',
	# Other types that may be interpreted by some servers
	'shtml', 'jhtml', 'pl', 'py', 'cgi', 'sh', 'ksh', 'bsh', 'c', 'htaccess', 'htpasswd',
	# May contain harmful executables for Windows victims
	'exe', 'scr', 'dll', 'msi', 'vbs', 'bat', 'com', 'pif', 'cmd', 'vxd', 'cpl', 
];


/**
 * Anti-XSS
 *
 * Attempts to clean variables from XSS attacks
 * @since 2.03
 *
 * @author Martijn van der Ven
 *
 * @param string $str The string to be stripped of XSS attempts
 * @return string
 */
function antixss($str){
	$strdirty = $str;
	// attributes blacklist:
	$attr = ['style', 'on[a-z]+'];
	// elements blacklist:
	$elem = ['script', 'iframe', 'embed', 'object'];
	// extermination:
	$str = preg_replace('#<!--.*?-->?#', '', $str);
	$str = preg_replace('#<!--#', '', $str);
	$str = preg_replace('#(<[a-z]+(\s+[a-z][a-z\-]+\s*=\s*(\'[^\']*\'|"[^"]*"|[^\'">][^\s>]*))*)\s+href\s*=\s*(\'javascript:[^\']*\'|"javascript:[^"]*"|javascript:[^\s>]*)((\s+[a-z][a-z\-]*\s*=\s*(\'[^\']*\'|"[^"]*"|[^\'">][^\s>]*))*\s*>)#is', '$1$5', $str);
	foreach($attr as $a) {
	    $regex = '(<[a-z]+(\s+[a-z][a-z\-]+\s*=\s*(\'[^\']*\'|"[^"]*"|[^\'">][^\s>]*))*)\s+'.$a.'\s*=\s*(\'[^\']*\'|"[^"]*"|[^\'">][^\s>]*)((\s+[a-z][a-z\-]*\s*=\s*(\'[^\']*\'|"[^"]*"|[^\'">][^\s>]*))*\s*>)';
	    $str = preg_replace('#'.$regex.'#is', '$1$5', $str);
	}
	foreach($elem as $e) {
		$regex = '<'.$e.'(\s+[a-z][a-z\-]*\s*=\s*(\'[^\']*\'|"[^"]*"|[^\'">][^\s>]*))*\s*>.*?<\/'.$e.'\s*>';
	    $str = preg_replace('#'.$regex.'#is', '', $str);
	}

	// if($strdirty !== $str) debugLog("string cleaned: removed ". (strlen($strdirty) - strlen($str)) .' chars');
	return $str;
}

function xss_clean($data){
	$datadirty = $data;
	// Fix &entity\n;
	$data = str_replace(['&amp;', '&lt;', '&gt;'], ['&amp;amp;', '&amp;lt;', '&amp;gt;'], $data);
	$data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
	$data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
	$data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');
	
	// Remove any attribute starting with "on" or xmlns
	$data = preg_replace('#(<[^>]+?[\x00-\x20"\'/])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);
	
	// Remove javascript: and vbscript: protocols
	$data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
	$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
	$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);
	
	// Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
	$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
	$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
	$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);
	
	// Remove namespaced elements (we do not need them)
	$data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);
	
	do
	{
		// Remove really unwanted tags
		$old_data = $data;
		$data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
	}
	while ($old_data !== $data);
	
	// we are done...
	// if($datadirty !== $data) debugLog("string cleaned: removed ". (strlen($datadirty) - strlen($data)) .' chars');
	return $data;
}

/**
 * Get Nonce
 *
 * @since 2.03
 * @author tankmiche
 * @uses $USR
 * @uses $SALT
 *
 * @param string $action Id of current page
 * @param string $file Optional, default is empty string
 * @param bool $last 
 * @return string
 */
function get_nonce($action, $file = "", $last = false) {
	global $USR;
	global $SALT;
	
	if($file == "")
		$file = $_SERVER['PHP_SELF'];
	
	// using user agent since ip can change on proxys
	$uid = $_SERVER['HTTP_USER_AGENT'];
	
	// Limits Nonce to one hour
	$time = $last ? time() - 3600: time(); 
	
	// Mix with a little salt
	$hash=sha1($action.$file.$uid.$USR.$SALT.@date('YmdH',$time));
	
	return $hash;
}


/**
 * Check Nonce
 *
 * @since 2.03
 * @author tankmiche
 * @uses get_nonce
 *
 * @param string $nonce
 * @param string $action
 * @param string $file Optional, default is empty string
 * @return bool
 */	
function check_nonce($nonce, $action, $file = ""){
	return ( $nonce === get_nonce($action, $file) || $nonce === get_nonce($action, $file, true) );
}

/**
 * Validate Safe File
 * NEVER USE MIME CHECKING FROM BROWSERS, eg. $_FILES['userfile']['type'] cannot be trusted
 * @since 3.1
 * @uses file_mime_type
 * @uses $mime_type_blacklist
 * @uses $file_ext_blacklist
 *
 * @param string $file, absolute path
 * @param string $name, filename
 * @param string $mime, optional
 * @return bool
 */	
function validate_safe_file($file, $name, $mime = null){
	global $mime_type_blacklist, $file_ext_blacklist, $mime_type_whitelist, $file_ext_whitelist;

	include(GSADMININCPATH.'configuration.php');

	$file_extension = lowercase(pathinfo($name,PATHINFO_EXTENSION));
	if(!$mime)$mime = file_mime_type($file);

	if ($mime && $mime_type_whitelist && in_arrayi($mime, $mime_type_whitelist)) {
		return true;
	}
	if ($file_ext_whitelist && in_arrayi($file_extension, $file_ext_whitelist)) {
		return true;
	}

	// skip blackist checks if whitelists exist
	if($mime_type_whitelist || $file_ext_whitelist) return false;

	if ($mime && in_arrayi($mime, $mime_type_blacklist)) {
		return false;	
	} elseif (in_arrayi($file_extension, $file_ext_blacklist)) {
		return false;	
	} else {
		return true;	
	}
}

/**
 * Checks that an existing filepath is safe to use by checking canonicalized absolute pathname.
 *
 * @since 3.1.3
 *
 * @param string $path Unknown Path to file to check for safety
 * @param string $pathmatch Known Path to parent folder to check against
 * @param bool $subdir allow path to be a deeper subfolder
 * @return bool Returns true if files path resolves to your known path
 */
function filepath_is_safe($path,$pathmatch,$subdir = true){
	$realpath = realpath($path);
	$realpathmatch = realpath($pathmatch);
	if($subdir) return strpos(dirname($realpath),$realpathmatch) === 0;
	return dirname($realpath) == $realpathmatch;
}

/**
 * Checks that an existing path is safe to use by checking canonicalized absolute path
 *
 * @since 3.1.3
 *
 * @param string $path Unknown Path to check for safety
 * @param string $pathmatch Known Path to check against
 * @param bool $subdir allow path to be a deeper subfolder
 * @return bool Returns true if $path is direct subfolder of $pathmatch
 *
 */
function path_is_safe($path,$pathmatch,$subdir = true){
	$realpath = realpath($path);
	$realpathmatch = realpath($pathmatch);
	if($subdir) return strpos($realpath,$realpathmatch) === 0;
	return $realpath == $realpathmatch;
}

/**
 * Check if server is Apache
 * 
 * @returns bool
 */
function server_is_apache() {
    return( strpos(strtolower($_SERVER['SERVER_SOFTWARE']),'apache') !== false );
}

/**
 * Performs filtering on variable, falls back to htmlentities
 *
 * @since 3.3.0
 * @param  string $var    var to filter
 * @param  string $filter filter type
 * @return string         return filtered string
 */
function var_out($var,$filter = "special"){
	$var = (string)$var;

	// php 5.2 shim
	if(!defined('FILTER_SANITIZE_FULL_SPECIAL_CHARS')){
		define('FILTER_SANITIZE_FULL_SPECIAL_CHARS',522);
		if($filter == "full") return htmlspecialchars($var, ENT_QUOTES);
	}

	// php 8.1: FILTER_SANITIZE_STRING deprecated
	if(function_exists( "filter_var") && ($filter !== "string" )){
		$aryFilter = [
			"int"     => FILTER_SANITIZE_NUMBER_INT,
			"float"   => FILTER_SANITIZE_NUMBER_FLOAT,
			"url"     => FILTER_SANITIZE_URL,
			"email"   => FILTER_SANITIZE_EMAIL,
			"special" => FILTER_SANITIZE_SPECIAL_CHARS,
			"full"    => FILTER_SANITIZE_FULL_SPECIAL_CHARS
		];
		if(isset($aryFilter[$filter])) return filter_var( $var, $aryFilter[$filter]);
		return filter_var( $var, FILTER_SANITIZE_SPECIAL_CHARS);
	}
	else if ($filter === "string") {
		return htmlspecialchars($var);
	}
	else {
		return htmlentities($var);
	}
}

/**
 * Sanitize SVG Content
 *
 * Sanitizes SVG files using a strict allowlist-based approach.
 * Removes dangerous elements, attributes, and event handlers that could be exploited for XSS attacks.
 *
 * @since 3.3.23
 *
 * @param string $svg_content The raw SVG content to sanitize
 * @param bool $strip_styles Optional, whether to remove style elements and attributes (default: false)
 * @return string|false Sanitized SVG content or false on failure
 */
function sanitize_svg($svg_content, $strip_styles = false) {
	// Return false if content is empty
	if (empty($svg_content)) {
		return false;
	}
	
	// Allowlist of safe SVG elements
	$allowed_elements = [
		'svg', 'g', 'path', 'rect', 'circle', 'ellipse', 'line', 'polyline', 'polygon',
		'text', 'tspan', 'tref', 'textPath', 'defs', 'clipPath', 'mask', 'pattern',
		'linearGradient', 'radialGradient', 'stop', 'use', 'symbol', 'marker',
		'title', 'desc', 'metadata', 'image', 'switch', 'a', 'view',
		// Style element (for CSS)
		'style',
		// SMIL Animation elements (declarative, safe - no JavaScript execution)
		'animate', 'animateTransform', 'animateMotion', 'set', 'animateColor', 'mpath'
	];
	
	// Allowlist of safe SVG attributes (general + presentation attributes)
	$allowed_attributes = [
		// Core attributes
		'id', 'class', 'style', 'transform', 'data-.*',
		// Language and internationalization
		'lang', 'xml:lang', 'dir',
		// Geometry attributes
		'x', 'y', 'x1', 'y1', 'x2', 'y2', 'cx', 'cy', 'r', 'rx', 'ry',
		'width', 'height', 'd', 'points', 'viewBox', 'preserveAspectRatio',
		// Presentation attributes
		'fill', 'fill-opacity', 'fill-rule', 'stroke', 'stroke-width',
		'stroke-opacity', 'stroke-linecap', 'stroke-linejoin', 'stroke-dasharray',
		'stroke-dashoffset', 'stroke-miterlimit', 'opacity', 'color',
		'font-family', 'font-size', 'font-weight', 'font-style', 'font-variant',
		'text-anchor', 'text-decoration', 'letter-spacing', 'word-spacing',
		// Text rendering attributes
		'dominant-baseline', 'alignment-baseline', 'baseline-shift',
		'writing-mode', 'glyph-orientation-vertical', 'glyph-orientation-horizontal',
		// Gradient attributes
		'offset', 'stop-color', 'stop-opacity', 'gradientUnits', 'gradientTransform',
		'spreadMethod', 'x1', 'y1', 'x2', 'y2', 'fx', 'fy',
		// Clip/Mask attributes
		'clip-path', 'clip-rule', 'mask',
		// Link attributes (for <a> tags)
		'xlink:href', 'href', 'target',
		// Filter attributes
		'filter',
		// Pattern attributes
		'patternUnits', 'patternContentUnits', 'patternTransform',
		// Use attributes
		'xlink:href', 'href',
		// SVG specific
		'xmlns', 'xmlns:xlink', 'version', 'baseProfile',
		// Style element attributes
		'type', 'media',
		// Pointer and interaction attributes (safe ones)
		'pointer-events', 'cursor',
		// Visibility attributes
		'display', 'visibility', 'overflow',
		// Accessibility
		'aria-.*', 'role', 'tabindex', 'focusable',
		// SMIL Animation attributes (safe - declarative animation control, no JavaScript)
		'attributeName', 'attributeType', 'begin', 'dur', 'end', 'min', 'max',
		'restart', 'repeatCount', 'repeatDur', 'fill',
		'calcMode', 'values', 'keyTimes', 'keySplines', 'from', 'to', 'by',
		'additive', 'accumulate',
		// animateTransform specific
		'type',
		// animateMotion specific  
		'path', 'keyPoints', 'rotate'
	];
	
	// Elements to always remove (dangerous)
	$forbidden_elements = [
		'script', 'iframe', 'object', 'embed', 'link', 'foreignObject',
		'applet', 'base', 'frame', 'frameset', 'audio', 'video'
	];
	
	// Attributes to always remove (event handlers and dangerous attributes)
	$forbidden_attributes = [
		'on.*',  // All event handlers (onclick, onload, onmouseover, etc.)
		'xmlns:xlink.*', // Except the standard xmlns:xlink
	];
	
	// Additional forbidden patterns in attribute values
	$forbidden_protocols = [
		'javascript:', 'data:', 'vbscript:', 'file:', 'about:'
	];
	
	// Safe protocols explicitly allowed in href/xlink:href
	$safe_protocols = [
		'http://', 'https://', 'mailto:', 'tel:', 'sms:', 'ftp://', '#'
	];
	
	// If strip_styles is enabled, add style-related items to forbidden list
	if ($strip_styles) {
		$forbidden_elements[] = 'style';
		$forbidden_attributes[] = 'style';
	}
	
	// Load SVG content with DOM
	libxml_use_internal_errors(true);
	$dom = new DOMDocument();
	$dom->encoding = 'UTF-8';
	$dom->preserveWhiteSpace = true;
	$dom->formatOutput = false;
	
	// Trim leading/trailing whitespace from SVG content
	$svg_content = trim($svg_content);
	
	// Load SVG content - preserve CDATA sections for CSS in <style> tags
	if (!$dom->loadXML($svg_content, LIBXML_NONET | LIBXML_NOENT)) {
		// If loading fails, return false
		return false;
	}
	
	libxml_clear_errors();
	
	// Get the root element
	$root = $dom->documentElement;
	
	// Verify it's an SVG element
	if (!$root || $root->nodeName !== 'svg') {
		return false;
	}
	
	// Recursive function to sanitize nodes
	$sanitize_node = function($node) use (&$sanitize_node, $allowed_elements, $allowed_attributes, $forbidden_elements, $forbidden_attributes, $forbidden_protocols) {
		// Skip text nodes, comments, and CDATA sections (they contain safe text/CSS)
		if ($node->nodeType === XML_TEXT_NODE || 
		    $node->nodeType === XML_COMMENT_NODE || 
		    $node->nodeType === XML_CDATA_SECTION_NODE) {
			return true;
		}
		
		// Check if element is forbidden
		$element_name = strtolower($node->nodeName);
		foreach ($forbidden_elements as $forbidden) {
			if ($element_name === strtolower($forbidden)) {
				return false; // Mark for removal
			}
		}
		
		// Check if element is in allowlist
		$element_allowed = false;
		foreach ($allowed_elements as $allowed) {
			if ($element_name === strtolower($allowed)) {
				$element_allowed = true;
				break;
			}
		}
		
		if (!$element_allowed) {
			return false; // Mark for removal
		}
		
		// Sanitize attributes
		if ($node->hasAttributes()) {
			$attributes_to_remove = [];
			
			foreach ($node->attributes as $attr) {
				$attr_name = strtolower($attr->name);
				$attr_value = $attr->value;
				$keep_attribute = false;
				
				// Check against forbidden attributes (regex patterns)
				$is_forbidden = false;
				foreach ($forbidden_attributes as $forbidden_pattern) {
					if (preg_match('/^' . $forbidden_pattern . '$/i', $attr_name)) {
						$is_forbidden = true;
						break;
					}
				}
				
				if ($is_forbidden) {
					$attributes_to_remove[] = $attr->name;
					continue;
				}
				
				// Check against allowed attributes (regex patterns)
				foreach ($allowed_attributes as $allowed_pattern) {
					if (preg_match('/^' . $allowed_pattern . '$/i', $attr_name)) {
						$keep_attribute = true;
						break;
					}
				}
				
				if (!$keep_attribute) {
					$attributes_to_remove[] = $attr->name;
					continue;
				}
				
				// Check attribute value for dangerous protocols (only for href/xlink:href attributes)
				if (in_array($attr_name, ['href', 'xlink:href'])) {
					$is_dangerous = false;
					
					// Check for forbidden protocols at the start of the value
					foreach ($forbidden_protocols as $protocol) {
						if (stripos($attr_value, $protocol) === 0) {
							$is_dangerous = true;
							break;
						}
					}
					
					if ($is_dangerous) {
						$attributes_to_remove[] = $attr->name;
					}
				}
			}
			
			// Remove forbidden attributes
			foreach ($attributes_to_remove as $attr_name) {
				$node->removeAttribute($attr_name);
			}
		}
		
		// Recursively process child nodes
		$children_to_remove = [];
		if ($node->hasChildNodes()) {
			foreach ($node->childNodes as $child) {
				if (!$sanitize_node($child)) {
					$children_to_remove[] = $child;
				}
			}
		}
		
		// Remove forbidden children
		foreach ($children_to_remove as $child) {
			$node->removeChild($child);
		}
		
		return true;
	};
	
	// Start sanitization from root
	if (!$sanitize_node($root)) {
		return false;
	}
	
	// Return sanitized SVG
	$sanitized = $dom->saveXML($dom->documentElement);
	
	// Additional regex-based cleanup for any remaining dangerous patterns
	$sanitized = preg_replace('/<script\b[^>]*>.*?<\/script>/is', '', $sanitized);
	$sanitized = preg_replace('/on\w+\s*=\s*["\'][^"\']*["\']/i', '', $sanitized);
	$sanitized = preg_replace('/javascript:/i', '', $sanitized);
	$sanitized = preg_replace('/data:text\/html/i', '', $sanitized);
	
	return $sanitized;
}

/**
 * Sanitize SVG File
 *
 * Reads and sanitizes an SVG file, optionally saving the sanitized version back to the file.
 *
 * @since 3.3.23
 *
 * @param string $file_path Absolute path to the SVG file
 * @param bool $overwrite Optional, whether to overwrite the original file with sanitized version (default: false)
 * @param bool $strip_styles Optional, whether to remove style elements and attributes (default: false)
 * @return string|false Sanitized SVG content or false on failure
 */
function sanitize_svg_file($file_path, $overwrite = false, $strip_styles = false) {
	// Verify file exists and is readable
	if (!file_exists($file_path) || !is_readable($file_path)) {
		return false;
	}
	
	// Verify it's actually an SVG file
	$file_extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
	if ($file_extension !== 'svg') {
		return false;
	}
	
	// Read file content
	$svg_content = file_get_contents($file_path);
	if ($svg_content === false) {
		return false;
	}
	
	// Sanitize the content
	$sanitized = sanitize_svg($svg_content, $strip_styles);
	
	if ($sanitized === false) {
		return false;
	}
	
	// Optionally overwrite the original file
	if ($overwrite && is_writable($file_path)) {
		file_put_contents($file_path, $sanitized);
	}
	
	return $sanitized;
}

function validImageFilename($file){
	$image_exts = ['jpg', 'jpeg', 'gif', 'png', 'webp', 'svg'];
	return in_array(getFileExtension($file),$image_exts);
}