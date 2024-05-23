<?php if(!defined('IN_GS')){ die('you cannot load this page directly.'); }
/**
 * Basic Functions 
 *
 * These functions are used throughout the installation of GetSimple.
 *
 * @package GetSimple
 * @subpackage Basic-Functions
 */

/**
 * Clean URL
 *
 * @since 1.0
 *
 * @param string $text
 * @return string
 */
function clean_url($text)  { 
	$text = strip_tags(lowercase($text)); 
	$code_entities_match = [' ?', ' ', '--', '&quot;', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '+', '{', '}', '|', ':', '"', '<', '>', '?', '[', ']', '\\', ';', "'", ',', '/', '*', '+', '~', '`', '=', '.']; 
	$code_entities_replace = ['', '-', '-', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '']; 
	$text = str_replace($code_entities_match, $code_entities_replace, $text); 
	$text = urlencode($text);
	$text = str_replace('--','-',$text);
	$text = rtrim($text, "-");
	return $text; 
} 

/**
 * Clean Image Name
 *
 * Mirror image of Clean URL, but it allows periods so file extentions still work
 *
 * @since 2.0
 *
 * @param string $text
 * @return string
 */
function clean_img_name($text)  {
	$text = getDef('GSUPLOADSLC',true) ? strip_tags(lowercase($text)) : strip_tags($text);
	$code_entities_match = [' ?', ' ', '--', '&quot;', '!', '#', '$', '%', '^', '&', '*', '(', ')', '+', '{', '}', '|', ':', '"', '<', '>', '?', '[', ']', '\\', ';', "'", ',', '/', '*', '+', '~', '`', '=']; 
	$code_entities_replace = ['', '-', '-', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '']; 
	$text = str_replace($code_entities_match, $code_entities_replace, $text); 
	$text = urlencode($text);
	$text = str_replace('--','-',$text);
	$text = str_replace('%40','@',$text); // ensure @ is not encoded
	$text = rtrim($text, "-");
	return $text; 
} 

/**
 * 7bit Text Converter
 *
 * Converts a string to a different encoding format
 *
 * @since 1.0
 *
 * @param string $text
 * @param string $from_enc
 * @return string 
 */
function to7bit($text,$from_enc="UTF-8") {
	if (function_exists('mb_encode_numericentity')) {
		$text = mb_encode_numericentity($text ?? "",[0x80, 0x10FFFF, 0, ~0],$from_enc);
    } else {
		$text = htmlspecialchars_decode(utf8_decode(htmlentities($text, ENT_COMPAT, 'utf-8', false)));
	}
    $text = preg_replace(
        ['/&szlig;/', '/&(..)lig;/', 
             '/&([aouAOU])uml;/','/&(.)[^;]*;/'],
        ['ss', "$1", "$1".'e', "$1"],
        $text);
    return $text;
}


/**
 * Formats Email to HTML Style
 *
 * @since 3.1
 *
 * @param string $message
 * @return string
 */
function email_template($message) {
	$data = '
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta http-equiv="X-UA-Compatible" content="IE=edge" />
			<meta name="viewport" content="width=device-width, initial-scale=1.0" />
			<style type="text/css">
				.ExternalClass,.ReadMsgBody{width:100%;background-color:#ffffff}.ExternalClass,.ExternalClass div,.ExternalClass font,.ExternalClass p,.ExternalClass span,.ExternalClass td{line-height:100%}html{width:100%}body{-webkit-text-size-adjust:none;-ms-text-size-adjust:none;margin:0;padding:0;background:#E5E5E5}table{border-spacing:0;table-layout:auto;margin:0 auto}.yshortcuts a{border-bottom:none!important}img:hover{opacity:.9!important}a{color:#d24414;text-decoration:none}.textbutton a{font-family:\'open sans\',arial,sans-serif!important}.btn-link a{color:#fff!important}@media only screen and (max-width:479px){.table-full,.table-inner{text-align:center!important}body{width:auto!important;font-family:\'Open Sans\',Arial,Sans-serif!important}.table-inner{width:90%!important}.table-full{width:100%!important;max-width:100%!important}u+.body .full{width:100vw!important}}
			</style>
		</head>
		<body class="body">
			<table class="full" width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td background=" data:image/gif;base64,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" bgcolor="#494c50" valign="top">
						<table class="table-inner" align="center" width="600" style="max-width: 600px;" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="40"></td>
							</tr>
							<tr>
								<td bgcolor="#FFFFFF" style="border-top-left-radius: 4px;border-top-right-radius: 4px;" align="center">
									<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
										<tr>
											<td height="50"></td>
										</tr>
										<!-- logo -->
										<tr>
											<td align="center" style="line-height: 0px;">
												<img style="display:block; line-height:0px; font-size:0px; border:0px;" src=" data:image/gif;base64,R0lGODlhMgAyANUAANA5BuOIadE8Cf318vjh2dxrRc82Aue/svTRxvzy7vfb0uupktu0qNZTJu61otFADvPLvdRKGtJCEOmjiv/9/NhcMtJFFd93U+B8WuWSddliOeecgdtmPv76+fHEtNE+C/XUyeaWeu+7qfvu6e2ynfrp5PTOwfC+reSOcP78+9dWKv339dA2Ae64pddYLNJDEuHFu/r6+uytmN28sOGBYN1wStdZLvnm39lfNc0vANVPINI9CdI/DOS3qP///9JEEyH/C1hNUCBEYXRhWE1QPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS42LWMxNDUgNzkuMTYzNDk5LCAyMDE4LzA4LzEzLTE2OjQwOjIyICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1wTU06T3JpZ2luYWxEb2N1bWVudElEPSJ4bXAuZGlkOjA0MGFiYWE3LTBiMDctZmM0MS04YmI0LTI0OWVjYzMzNTgyZSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpCNUEyMzA0MDE4MzUxMUVGOTdENUYxNDRDODE0MzdBRiIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpCNUEyMzAzRjE4MzUxMUVGOTdENUYxNDRDODE0MzdBRiIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ0MgMjAxOSAoV2luZG93cykiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5z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" alt="GS CE" />
											</td>
										</tr>
										<!-- end logo -->
										<tr>
											<td height="15"></td>
										</tr>
										<!-- slogan -->
										<tr>
											<td align="center" style="font-family: \'Open Sans\', Arial, sans-serif; font-size:12px; color:#3b3b3b; text-transform:uppercase; letter-spacing:2px; font-weight: normal;">- GetSimple CE - <br>Powered by a Community. </td>
										</tr>
										<!-- end slogan -->
										<tr>
											<td height="40"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td align="center" bgcolor="#f3f3f3">
									<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
										<tr>
											<td height="50"></td>
										</tr>
										<!-- title -->
										<tr>
											<td align="center" style="font-family: \'Open Sans\', Arial, sans-serif; font-size:36px; color:#3b3b3b; font-weight: bold; letter-spacing:4px;">GetSimple CE</td>
										</tr>
										<!-- end title -->
										<tr>
											<td align="center">
												<table width="25" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td height="15" style="border-bottom:2px solid #D24414;"></td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td height="20"></td>
										</tr>
										<!-- content -->
										<tr>
											<td align="center" style="font-family: \'Open Sans\', Arial, sans-serif; font-size:14px; color:#7f8c8d; line-height:29px;"> 
												'.$message.'
											</td>
										</tr>
										<!-- end content -->
										<tr>
											<td height="50"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor="#FFFFFF" style="border-bottom-left-radius: 4px;border-bottom-right-radius: 4px;" align="center">
									<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
										<tr>
											<td height="30"></td>
										</tr>
										<!-- copyright -->
										<tr>
											<td align="center" style="padding-right:5px;font-family: \'Open Sans\', Arial, sans-serif; font-size:13px; color:#7f8c8d;"> This is an automatic message. Do not reply. <br>Click <a href="https://getsimple-ce.ovh/" target="_blank">here</a> for questions. </td>
											<td align="center" style="padding-left:5px;font-family: \'Open Sans\', Arial, sans-serif; font-size:13px; color:#7f8c8d;"> © '.date('Y').' GetSimple CE, <br>All Rights Reserved. </td>
										</tr>
										<!-- end copyright -->
										<tr>
											<td height="30"></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height="25"></td>
							</tr>
							<tr>
								<td height="25"></td>
							</tr>
							<tr>
								<td height="45"></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</body>
	</html>
	';
	return $data;
}


/**
 * Send Email
 *
 * @since 1.0
 * @uses GSFROMEMAIL
 * @uses $EMAIL
 *
 * @param string $to
 * @param string $subject
 * @param string $message
 * @return string
 */
function sendmail($to,$subject,$message) {
	
	$message = email_template($message);

	if (defined('GSFROMEMAIL')){
		$fromemail = GSFROMEMAIL; 
	} else {
		if(!empty($_SERVER['SERVER_ADMIN']) && check_email_address($_SERVER['SERVER_ADMIN'])) $fromemail = $_SERVER['SERVER_ADMIN'];
		else $fromemail =  'noreply@'.$_SERVER['SERVER_NAME'];
	}

	global $EMAIL;
	$headers  ='"MIME-Version: 1.0' . PHP_EOL;
	$headers .= 'Content-Type: text/html; charset=UTF-8' . PHP_EOL;
	$headers .= 'From: '.$fromemail . PHP_EOL;
  	$headers .= 'Reply-To: '.$fromemail . PHP_EOL;
  	$headers .= 'Return-Path: '.$fromemail . PHP_EOL;
	
	if( @mail($to,'=?UTF-8?B?'.base64_encode($subject).'?=',"$message",$headers) ) {
		return 'success';
	} else {
		return 'error';
	}
}

/**
 * Sub-Array Sort
 *
 * Sorts the passed array by a subkey
 *
 * @since 1.0
 *
 * @param array $a
 * @param string $subkey Key within the array passed you want to sort by
 * @param string $order - order 'asc' ascending or 'desc' descending
 * @param bool $natural - sort using a "natural order" algorithm
 * @return array
 */
function subval_sort($a,$subkey, $order='asc',$natural = true) {
	if (count($a) != 0 || (!empty($a))) { 
		foreach($a as $k=>$v) {
			if(isset($v[$subkey])) $b[$k] = lowercase($v[$subkey]);
		}

		if(!isset($b)) return $a;

		if($natural){
			natsort($b);
			if($order=='desc') $b = array_reverse($b,true);	
		} 
		else {
			($order=='asc')? asort($b) : arsort($b);
		}
		
		foreach($b as $key=>$val) {
			$c[] = $a[$key];
		}

		return $c;
	}else {
        return array();
    }
}

/**
 * SimpleXMLExtended Class
 *
 * Extends the default PHP SimpleXMLElement class by 
 * allowing the addition of cdata
 *
 * @since 1.0
 *
 * @param string $cdata_text
 */
class SimpleXMLExtended extends SimpleXMLElement{   
  public function addCData($cdata_text){   
   $node= dom_import_simplexml($this);   
   $no = $node->ownerDocument;   
   $node->appendChild($no->createCDATASection($cdata_text));   
  } 
} 

/**
 * Is File
 *
 * @since 1.0
 * @uses tsl
 *
 * @param string $file
 * @param string $path
 * @param string $type Optiona, default is 'xml'
 * @return bool
 */
function isFile($file, $path, $type = 'xml') {
	if( is_file(tsl($path) . $file) && $file != "." && $file != ".." && (strstr($file, $type))  ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Get Files
 *
 * Returns an array of files from the passed path
 *
 * @since 1.0
 *
 * @param string $path
 * @return array
 */
function getFiles($path) {
	$handle = opendir($path) or die("getFiles: Unable to open $path");
	$file_arr = [];
	while ($file = readdir($handle)) {
		if ($file != '.' && $file != '..') {
			$file_arr[] = $file;
		}
	}
	closedir($handle);
	return $file_arr;
}

$microtime_start = null;

function get_execution_time($reset=false)
{
	GLOBAL $microtime_start;
    if($reset) $microtime_start = null;
		
    if($microtime_start === null)
    {
        $microtime_start = microtime(true);
        return 0.0; 
    }    
    return round(microtime(true) - $microtime_start,5); 
}

/**
 * Get XML Data
 *
 * Turns the XML file into an object 
 *
 * @since 1.0
 *
 * @param string $file
 * @return object
 */
function getXML($file) {
	$xml = @file_get_contents($file);
	if($xml){
		$data = simplexml_load_string($xml, 'SimpleXMLExtended', LIBXML_NOCDATA); 
		return $data;
	}	
}

/**
 * XML Save
 *
 * @since 2.0
 * @todo create and chmod file before ->asXML call (if it doesnt exist already, if so, then just chmod it.)
 *
 * @param object $xml
 * @param string $file Filename that it will be saved as
 * @return bool
 */
function XMLsave($xml, $file) {
	# get_execution_time(true);
	if(!is_object($xml)){
		debugLog(__FUNCTION__ . ' failed to save xml');
		return false;
	}	
	$data = @$xml->asXML();
	if(getDef('GSFORMATXML',true)) $data = formatXmlString($data); // format xml if config setting says so
	$data = exec_filter('xmlsave',$data); // @filter xmlsave executed before writing string to file
	$success = file_put_contents($file, $data); // LOCK_EX ?
	
	// debugLog('XMLsave: ' . $file . ' ' . get_execution_time());	
	if(getDef('GSDOCHMOD') === false) return $success;
	if (defined('GSCHMOD')) {
		return $success && chmod($file, GSCHMOD);
	} else {
		return $success && chmod($file, 0755);
	}
}

/**
 * Long Date Output
 *
 * @since 1.0
 * @uses $i18n
 * @uses i18n_r
 *
 * @param string $dt Date/Time format, default is $i18n['DATE_AND_TIME_FORMAT']
 * @return string
 */
function lngDate($dt) {
	global $i18n;
	
	if (!$dt) {
		$data = date(i18n_r('DATE_AND_TIME_FORMAT'));
	} else {
		$data = date(i18n_r('DATE_AND_TIME_FORMAT'), strtotime($dt));
	}
	return $data;
}

/**
 * Short Date Output
 *
 * @since 1.0
 * @uses $i18n
 * @uses i18n_r
 *
 * @param string $dt Date/Time format, default is $i18n['DATE_FORMAT']
 * @return string
 */
function shtDate($dt) {
	global $i18n;
	
	if (!$dt) {
		$data = date(i18n_r('DATE_FORMAT'));
	} else {
		$data = date(i18n_r('DATE_FORMAT'), strtotime($dt));
	}
	return $data;
}

/**
 * Clean Utility
 *
 * @since 1.0
 *
 * @param string $data
 * @return string
 */
function cl($data){
	$data = stripslashes(strip_tags(html_entity_decode($data, ENT_QUOTES, 'UTF-8')));
	//$data = preg_replace('/[[:cntrl:]]/', '', $data); //remove control characters that cause interface to choke
	return $data;
}

/**
 * Add Trailing Slash
 *
 * @since 1.0
 *
 * @param string $path
 * @return string
 */
function tsl($path) {
	if( substr($path, strlen($path) - 1) != '/' ) {
		$path .= '/';
	}
	return $path;
}

/**
 * Case-Insensitve In-Array
 *
 * Creates a function that PHP should already have, but doesnt
 *
 * @since 1.0
 *
 * @param string $path
 * @return string
 */
if(!function_exists('in_arrayi')) {
	function in_arrayi($needle, $haystack) {
	    return in_array(lowercase($needle), array_map('lowercase', $haystack));
	}
}

/**
 * Creates Standard URL for Pages
 *
 * Default function to create the correct url structure for each front-end page
 *
 * @since 2.0
 * @uses $PRETTYURLS
 * @uses $SITEURL
 * @uses $PERMALINK
 * @uses tsl
 *
 * @param string $slug
 * @param string $parent
 * @param string $type Default is 'full', alternative is 'relative'
 * @return string
 */
function find_url($slug, $parent, $type='full') {
	global $PRETTYURLS;
	global $SITEURL;
	global $PERMALINK;
				
	if ($type == 'full') {
		$full = $SITEURL;
	} elseif($type == 'relative') {
		$s = pathinfo(htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES));
		$full = $s['dirname'] .'/';
		$full = str_replace('//', '/', $full);
	} else {
		$full = '/';
	}
	
	if ($parent != '') {
		$parent = tsl($parent); 
	}	

	if ($PRETTYURLS == '1') {      
		if ($slug != 'index'){  
			$url = $full . $parent . $slug . '/';
		} else {
			$url = $full;
		}   
	} else {
		if ($slug != 'index'){
			$url = $full .'index.php?id='.$slug;
		} else {
			$url = $full;
		}
	}
  
	if (trim($PERMALINK) != '' && $slug != 'index'){
		$plink = str_replace('%parent%/', $parent ?? '', $PERMALINK);
		$plink = str_replace('%parent%', $parent ?? '', $plink);
		$plink = str_replace('%slug%', $slug ?? '', $plink);
		$url = $full . $plink;
	}

	return (string)$url;
}

/**
 * Strip Path
 *
 * Strips all path info from a filepath or basedir
 *
 * @since 2.0
 * @author Martijn van der Ven
 *
 * @param string $path
 * @return string
 */
function strippath($path) {
	$pathparts = pathinfo($path);
	if(isset($pathparts['extension'])) return $pathparts['filename'].'.'.$pathparts['extension'];
	return $pathparts['basename'];
}

/**
 * Strip Quotes
 *
 * @since 2.0
 *
 * @param string $text
 * @return string
 */
function strip_quotes($text)  { 
	$text = strip_tags($text); 
	$code_entities_match = ['"', '\'', '&quot;']; 
	$text = str_replace($code_entities_match, '', $text); 
	return trim($text); 
}

/**
 * Encode Quotes
 *
 * @since 3.0
 *
 * @param string $text
 * @return string
 */
function encode_quotes($text)  { 
	$text = strip_tags($text);
	if (version_compare(PHP_VERSION, "7.2")  >= 0) {	
		$text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8', false);
	} else {	
		$text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
	}
	return trim($text); 
} 

/**
 * Redirect URL
 *
 * @since 3.0
 * @author schlex
 *
 * @param string $url
 */
function redirect($url) {
	global $i18n;

	// handle expired sessions for ajax requests
	if(requestIsAjax() && !cookie_check()){
		header('HTTP/1.1 401 Unauthorized', true, 401);
		header('WWW-Authenticate: FormBased');
		die();
	}	

	if (!headers_sent($filename, $linenum)) {
		header('Location: '.var_out($url,"url"));
	} else {
		echo "<html><head><title>".i18n_r('REDIRECT')."</title></head><body>";
		if ( !isDebug() ) {
			echo '<script type="text/javascript">';
			echo 'window.location.href="'.var_out($url,"url").'";'; // @todo sanitize url
			echo '</script>';
			echo '<noscript>';
			echo '<meta http-equiv="refresh" content="0;url='.var_out($url,"url").'" />';
			echo '</noscript>';
		}
		echo i18n_r('ERROR').": Headers already sent in ".$filename." on line ".$linenum."\n";
		printf(i18n_r('REDIRECT_MSG'), $url);
		echo "</body></html>";
	}
	
	exit;
}

/**
 * Display i18n
 *
 * Displays the default language's tranlation, but if it 
 * does not exist, it falls back to the en_US one.
 *
 * @since 3.0
 * @author ccagle8
 * @uses GSLANGPATH
 * @uses $i18n
 * @uses $LANG
 *
 * @param string $name
 * @param bool $echo Optional, default is true
 */
function i18n($name, $echo=true) {
	global $i18n;
	global $LANG;

	if(isset($i18n)){

		if (isset($i18n[$name])) {
			$myVar = $i18n[$name];
		} else {
			$myVar = '{'.$name.'}';
		}
	}
	else {
		$myVar = '{'.$name.'}'; // if $i18n doesnt exist yet return something
	}

	if (!$echo) {
		return $myVar;
	} else {
		echo $myVar;
	}
}

/**
 * Return i18n
 *
 * Same as i18n, but returns instead of echos
 *
 * @since 3.0
 * @author ccagle8
 *
 * @param string $name
 */
function i18n_r($name) {
	return i18n($name, false);
}

/**
 * i18n Merge
 *
 * Merges a plugin's language file with the global $i18n language
 * This is the function that plugin developers will call to initiate the language merge
 *
 * @since 3.0
 * @author mvlcek
 * @uses i18n_merge_impl
 * @uses $i18n
 * @uses $LANG
 *
 * @param string $plugin
 * @param string $language, default=null
 * @return bool
 */
function i18n_merge($plugin, $language=null) {
	global $i18n, $LANG;
	return i18n_merge_impl($plugin, $language ?: $LANG, $i18n);
}

/**
 * i18n Merge Implementation
 *
 * Does the merging of a plugin's language file with the global $i18n language
 *
 * @since 3.0
 * @author mvlcek
 * @uses GSPLUGINPATH
 *
 * @param string $plugin null if merging in core langs
 * @param string $lang
 * @param string $globali18n
 * @return bool
 */
function i18n_merge_impl($plugin, $lang, &$globali18n) { 

	$i18n = []; // local from file
	if(!isset($globali18n)) $globali18n = []; //global ref to $i18n

	$path     = ($plugin ? GSPLUGINPATH.$plugin.'/lang/' : GSLANGPATH);
	$filename = $path.$lang.'.php';
	$prefix   = $plugin ? $plugin.'/' : '';

	if (!filepath_is_safe($filename,$path) || !file_exists($filename)) {
		return false;
	}

  include($filename); 
  
	// if core lang and glboal is empty assign
	if(!$plugin && !$globali18n && count($i18n) > 0){
		$globali18n = $i18n;
		return true;
	}

	// replace on per key basis
	if (count($i18n) > 0){
		foreach ($i18n as $code => $text) {
			if (!array_key_exists($prefix.$code, $globali18n)) {
				$globali18n[$prefix.$code] = $text;
			}
		}
	}
	return true;
}

/**
 * Safe AddSlashes HTML
 *
 * @since 2.04
 * @author ccagle8
 *
 * @param string $text
 * @return string
 */
function safe_slash_html($text) {

/*	// PHP 8, no get_magic_quotes_gpc()
	if (get_magic_quotes_gpc()==0) {
		$text = addslashes(htmlspecialchars($text, ENT_QUOTES, 'UTF-8'));
	} else {
		$text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
	}
	
	return xmlFilterChars($text);
	*/

	// replacement
	$text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
	return xmlFilterChars($text);
}

/**
 * xmlFilterChars
 *
 * @since  3.3.3
 * @param  str $str string to prepare for xml cdata
 * @return str      filtered string
 */
function xmlFilterChars($str){
	$chr = getRegexUnicode();
	// filter only xml allowed characters
	return preg_replace ('/[^'.$chr['ht'].$chr['lf'].$chr['cr'].$chr['lower'].$chr['upper'].']+/u', ' ', $str);
}

/**
 * getRegexUnicode
 * defines unicode char and char ranges for use in regex filters
 *
 * @since  3.3.3
 * @param  str $id key to return from char range array
 * @return mixed     array or str if id specified of regex char strings
 */
function getRegexUnicode($id = null){
	$chars = [
		'null'       => '\x{0000}',            // 0 null
		'ht'         => '\x{0009}',            // 9 horizontal tab
		'lf'         => '\x{000a}',            // 10 line feed
		'vt'         => '\x{000b}',            // 11 vertical tab
		'FF'         => '\x{000c}',            // 12 form feed
		'cr'         => '\x{000d}',            // 13 carriage return
		'cntrl'      => '\x{0001}-\x{0019}',   // 1-31 control codes
		'cntrllow'   => '\x{0001}-\x{000c}',   // 1-12 low end control codes
		'cntrlhigh'  => '\x{000e}-\x{0019}',   // 14-31 high end control codes
		'bom'        => '\x{FEFF}',            // 65279 BOM byte order mark
		'lower'      => '\x{0020}-\x{D7FF}',   // 32 - 55295
		'surrogates' => '\x{D800}-\x{DFFF}',   // 55296 - 57343
		'upper'      => '\x{E000}-\x{FFFD}',   // 57344 - 65533
		'nonchars'   => '\x{FFFE}-\x{FFFF}',   // 65534 - 65535
		'privateb'   => '\x{10000}-\x{10FFFD}', // 65536 - 1114109
 	];

	if(isset($id)) return $chars[$id];
	return $chars;
}

/**
 * Safe StripSlashes HTML Decode
 *
 * @since 2.04
 * @author ccagle8
 *
 * @param string $text
 * @return string
 */
function safe_strip_decode($text) {

/*	// PHP 8, no get_magic_quotes_gpc()

	if (get_magic_quotes_gpc()==0) {
		$text = htmlspecialchars_decode($text, ENT_QUOTES);
	} else {
		$text = stripslashes(htmlspecialchars_decode($text, ENT_QUOTES));
	}
	return $text;
*/	
		// replacement
	$text = stripslashes(htmlspecialchars_decode($text, ENT_QUOTES));
	
	return $text;
}

/**
 * StripSlashes HTML Decode
 *
 * @since 2.04
 * @author ccagle8
 *
 * @param string $text
 * @return string
 */
function strip_decode($text) {
	$text = stripslashes(htmlspecialchars_decode($text, ENT_QUOTES));
	return $text;
}

/**
 * Safe Pathinfo Filename
 *
 * for backwards compatibility for before PHP 5.2
 *
 * @since 3.0
 * @author madvic
 *
 * @param string $file
 * @return string
 */
function pathinfo_filename($file) {
	if (defined('PATHINFO_FILENAME')) return pathinfo($file,PATHINFO_FILENAME);
	$path_parts = pathinfo($file);

	if(isset($path_parts['extension']) && ($file!='..')){
		return substr($path_parts['basename'],0 ,strlen($path_parts['basename'])-strlen($path_parts['extension'])-1);
	} else{
		return $path_parts['basename'];
	}
}


function getFileExtension($file){
	return lowercase(pathinfo($file,PATHINFO_EXTENSION));
}

/**
 * Suggest Site Path
 *
 * Suggestion function for SITEURL variable
 *
 * @since 2.04
 * @uses $GSAMIN
 * @uses http_protocol
 * @author ccagle8
 *
 * @param bool $parts 
 * @return string
 */
function suggest_site_path($parts=false, $protocolRelative = false) {
	global $GSADMIN;
	$protocol   = $protocolRelative ? '' : http_protocol().':';
	$path_parts = pathinfo(htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES));
	$path_parts = str_replace("/".$GSADMIN, "", $path_parts['dirname']);
	$port       = ($p=$_SERVER['SERVER_PORT'])!='80'&&$p!='443'?':'.$p:'';
	
	if($path_parts == '/') {
		$fullpath = $protocol."//". htmlentities($_SERVER['SERVER_NAME'], ENT_QUOTES) . $port . "/";
	} else {
		$fullpath = $protocol."//". htmlentities($_SERVER['SERVER_NAME'], ENT_QUOTES) . $port . $path_parts ."/";
	}
		
	if ($parts) {
		return $path_parts;
	} else {
		return $fullpath;
	}
}

/**
 * Myself 
 *
 * Returns the page itself 
 *
 * @since 2.04
 * @author ccagle8
 *
 * @param bool $echo
 * @return string
*/
function myself($echo=true) {
	return myself_new($echo);
	if ($echo) {
		echo htmlentities(basename($_SERVER['PHP_SELF']), ENT_QUOTES);
	} else {
		return htmlentities(basename($_SERVER['PHP_SELF']), ENT_QUOTES);
	}
}

function myself_new($echo=true) {
	if ($echo) {
		echo htmlentities(basename($_SERVER['SCRIPT_NAME']), ENT_QUOTES);
	} else {
		return htmlentities(basename($_SERVER['SCRIPT_NAME']), ENT_QUOTES);
	}
}

/**
 * Get Available Themes 
 *
 * @since 2.04
 * @uses GSTHEMESPATH
 * @author ccagle8
 *
 * @param string $temp
 * @return array
 */
function get_themes($temp) {
	$themes_path = GSTHEMESPATH . $temp .'/';
	$themes_handle = opendir($themes_path);
	while ($file = readdir($themes_handle))	{
		if( is_file($themes_path . $file) && $file != "." && $file != ".." ) {
			$templates[] = $file;
		}
	}
	sort($templates);	
	return $templates;
}


/**
 * HTML Decode 
 *
 * @since 2.04
 * @author ccagle8
 *
 * @param string $text
 * @return string
 */
function htmldecode($text) {
	return html_entity_decode($text, ENT_QUOTES, 'UTF-8');
}

/**
 * Safe to LowerCase 
 *
 * @since 2.04
 * @author ccagle8
 *
 * @param string $text
 * @return string
 */
function lowercase($text) {
	if (function_exists('mb_strtolower')) {
		$text = mb_strtolower($text, 'UTF-8'); 
	} else {
		$text = strtolower($text); 
	}
	
	return $text;
}

/**
 * Find AccessKey
 *
 * Provides a simple way to find the accesskey defined by translators as
 * accesskeys are language dependent.
 * 
 * @param string $string, text from the i18n array
 * @return string
 */
function find_accesskey($string) {
	$found = [];
	$matched = preg_match('/<em>([a-zA-Z])<\/em>/', $string, $found);
	if ($matched != 1) {
		return null;
	}
	return strtolower($found[1]);
}

/**
 * Clean ID
 *
 * Removes characters that don't work in URLs or IDs
 * 
 * @param string $text
 * @return string
 */
function _id($text) {
	$text = to7bit($text, "UTF-8");
	$text = clean_url($text);
	$text = preg_replace('/[[:cntrl:]]/', '', $text); //remove control characters that cause interface to choke
	return lowercase($text);
}

/**
 * Defined Array
 *
 * Checks an array of PHP constants and verifies they are defined
 * 
 * @param array $constants
 * @return bool
 */
function defined_array($constants) {
	$defined = true;
	foreach ($constants as $constant) {
		if (!defined($constant)) {
			$defined = false;
			break;
		}
	}
	return $defined;
}


/**
 * Is Folder Empty
 *
 * Check to see if a folder is empty or not
 * 
 * @param string $folder
 * @return bool
 */
function check_empty_folder($folder) {
	$files = [];
	if ( $handle = opendir ( $folder ) ) {
		while ( false !== ( $file = readdir ( $handle ) ) ) {
			if ( $file != "." && $file != ".." ) {
				$files [] = $file;
			}
		}
		closedir ( $handle );
	}
	return ( count ( $files ) > 0 ) ? FALSE : TRUE;
}


/**
 * Folder Items
 *
 * Return the amount of items within the given folder
 * 
 * @param string $folder
 * @return string
 */
function folder_items($folder) {
	$files = [];
	if ( $handle = opendir ( $folder ) ) {
		while ( false !== ( $file = readdir ( $handle ) ) ) {
			if ( $file != "." && $file != ".." ) {
				$files [] = $file;
			}
		}
		closedir($handle);
	}
	return count($files);
}

/**
 * Validate a URL String
 * 
 * @param string $u
 * @return bool
 */
function validate_url($u) {
	return filter_var($u,FILTER_VALIDATE_URL);
}


/**
 * Format XML to Formatted String
 * 
 * @param string $xml
 * @return string
 */
function formatXmlString_legacy($xml) {  
  
	// add marker linefeeds to aid the pretty-tokeniser (adds a linefeed between all tag-end boundaries)
	$xml = preg_replace('/(>)(<)(\/*)/', "$1\n$2$3", $xml);

	// now indent the tags
	$token      = strtok($xml, "\n");
	$result     = ''; // holds formatted version as it is built
	$pad        = 0; // initial indent
	$matches    = []; // returns from preg_matches()
  
	// scan each line and adjust indent based on opening/closing tags
	while ($token !== false) : 

    // test for the various tag states

    // 1. open and closing tags on same line - no change
    if (preg_match('/.+<\/\w[^>]*>$/', $token, $matches)) : 
		$indent=0;
    // 2. closing tag - outdent now
    elseif (preg_match('/^<\/\w/', $token, $matches)) :
		$pad--;
    // 3. opening tag - don't pad this one, only subsequent tags
    elseif (preg_match('/^<\w[^>]*[^\/]>.*$/', $token, $matches)) :
		$indent=1;
    // 4. no indentation needed
    else :
		$indent = 0; 
    endif;

    // pad the line with the required number of leading spaces
    $line    = str_pad($token, strlen($token)+$pad, ' ', STR_PAD_LEFT);
    $result .= $line . "\n"; // add to the cumulative result, with linefeed
    $token   = strtok("\n"); // get the next token
    $pad    += $indent; // update the pad size for subsequent lines    
	endwhile; 
  
	return $result;
}

/**
	* formats the xml output readable, accepts simplexmlobject or string
	* @param mixed  $data instance of SimpleXmlObject or string
	* @return string of indented xml-elements
	*/
	function formatXmlString($data){
 
		if(gettype($data) === 'object') $data = $data->asXML();

		//Format XML to save indented tree rather than one line
		$dom = new DOMDocument('1.0');
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom->loadXML($data);
	 
		$ret = $dom->saveXML();
		return $ret;
	}

/**
 * Check Server Protocol
 * 
 * Checks to see if the website should be served using HTTP or HTTPS
 *
 * @since 3.1
 * @return string
 */
function http_protocol() {
	if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) {
		return 'https';
	} else {
		return 'http';
	}
}

/**
 * Get File Mime-Type
 *
 * @since 3.1
 * @param $file, absolute path
 * @return string/bool
 */
function file_mime_type($file) {
	if (!file_exists($file)) {
		return false;
		exit;
	}
	if(function_exists('finfo_open')) {
		# http://www.php.net/manual/en/function.finfo-file.php
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$mimetype = finfo_file($finfo, $file);
		finfo_close($finfo);
		
	} elseif(function_exists('mime_content_type')) {
		# Depreciated: http://php.net/manual/en/function.mime-content-type.php
		$mimetype = mime_content_type($file);
	} else {
		return false;
		exit;	
	}
	return $mimetype;
}


/**
 * Check Is FrontEnd
 * 
 * Checks to see if the you are on the frontend or not
 *
 * @since 3.1
 * @return bool
 */
function is_frontend() {
  GLOBAL $base;
	if(isset($base)) {
		return true;
	} else {
		return false;
	}
}

/**
 * Get Installed GetSimple Version
 *
 * This will return the version of GetSimple that is installed
 *
 * @since 1.0
 * @uses GSVERSION
 *
 * @param bool $echo Optional, default is true. False will 'return' value
 * @return string Echos or returns based on param $echo
 */
function get_site_version($echo=true) {
	include(GSADMININCPATH.'configuration.php');
	if ($echo) {
		echo GSVERSION;
	} else {
		return GSVERSION;
	}
}


/**
 * Get GetSimple Language
 *
 * @since 3.1
 * @uses $LANG
 *
 * @param string
 */
function get_site_lang($short=false) {
	global $LANG;
	if ($short) {
		$LANG_header = preg_replace('/(?:(?<=([a-z]{2}))).*/', '', $LANG);
		return $LANG_header;
	} else {
		return $LANG;
	}
}

/**
 * Convert to Bytes
 *
 * @since 3.0
 *
 * @param $str string
 * @return string
 */
function toBytes($str){
	$val = trim($str);
	$last = strtolower($str[strlen($str)-1]);
		switch($last) {
			case 'g': @$val *= 1024;
			case 'm': @$val *= 1024;
			case 'k': @$val *= 1024;
		}
	return $val;
}

/**
 * Remove Relative Paths
 *
 * @since 3.1
 *
 * @param $file string
 * @return string
 */
function removerelativepath($file) {
	while(strpos($file,'../')!==false) { 
		$file = str_replace('../','',$file);
	}
	return $file;
}

/**
 * Return a directory of files and folders
 *
 * @since 3.1
 *
 * @param $directory string directory to scan
 * @param $recursive boolean whether to do a recursive scan or not. 
 * @return array or files and folders
 */
function directoryToArray($directory, $recursive) {
	$array_items = [];
	if ($handle = opendir($directory)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				if (is_dir($directory. "/" . $file)) {
					if($recursive) {
						$array_items = array_merge($array_items, directoryToArray($directory. "/" . $file, $recursive));
					}
					$file = $directory . "/" . $file;
					$array_items[] = preg_replace("/\/\//si", "/", $file);
				} else {
					$file = $directory . "/" . $file;
					$array_items[] = preg_replace("/\/\//si", "/", $file);
				}
			}
		}
		closedir($handle);
	}
	return $array_items;
}


/**
 * Returns definition safely
 * 
 * @since 3.1.3
 * 
 * @param str $id 
 * @param bool $isbool treat definition as boolean and cast it
 * @return * returns definition or null if not defined
 */
function getDef($id,$isbool = false){
	if( defined($id) ) {
		if($isbool) return (bool) constant($id);
		return constant($id);
	}
}

/**
 * Alias for checking for debug constant
 * @since 3.2.1
 * @return  bool true if debug enabled
 */
function isDebug(){
	return getDef('GSDEBUG',true);
}

/**
 * check gs version is Beta
 *
 * @since  3.3.0
 * @return boolean true if beta release
 */
function isBeta(){
	return strPos(get_site_version(false),"b");
}

/**
 * Check if request is an ajax request
 * @since  3.3.0
 * @return bool true if ajax
 */
function requestIsAjax(){
	return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') || isset($_GET['ajax']);
}

/**
 * check if array is multidimensional
 * @since 3.3.2
 * @param  mixed $ary
 * @return bool true if $ary is a multidimensional array
 */
function arrayIsMultid($ary){
	return is_array($ary) && ( count($ary) != count($ary,COUNT_RECURSIVE) );
}

/**
 * normalizes toolbar setting, always returns js array string syntax
 * @since 3.3.2
 * 
 * @param mixed $var string or array var to convert to js array syntax
 */
function returnJsArray($var){
	
	if(!$var) return;

	if(!is_array($var)) {
		// if looks like an array string try to parse as array
		if(strrpos($var, '[') !==false){
			// normalize array strings
			$var = stripslashes($var);         // remove escaped quotes
			$var = trim(trim($var),',');       // remove trailing commas
			$var = str_replace('\'','"',$var); // replace single quotes with double (for json)
			
			$ary = json_decode($var);
			
			// add primary nest if missing
			if(!is_array($ary) || !arrayIsMultid($ary) ) $ary = json_decode('['.$var.']');
			
			// if proper array use it
			if(is_array($ary) ) $var = json_encode($ary);
			else $var = "'".trim($var,"\"'")."'"; 
		} 
		else{
			// else quote wrap string, trim to avoid double quoting
			$var = "'".trim($var,"\"'")."'";
		}	
	} 
	else {
		// convert php array to js array
		$var = json_encode($var);
	}

	return $var;
}


/**
 * sends an x-frame-options heaeder
 * @since  3.4
 * @param  string $value header value to send, default `DENY`
 */
function header_xframeoptions($value = null){
	if(!isset($value)){
		if(getDef('GSNOFRAMEDEFAULT',true)) $value = getDef('GSNOFRAMEDEFAULT');
		else $value = 'DENY';
	}	
	header('X-Frame-Options: ' . $value); // FF 3.6.9+ Chrome 4.1+ IE 8+ Safari 4+ Opera 10.5+
}


/**
 * strip non printing white space from string
 * replaces various newlines and tab chars with replacement character
 * then cleans up multiple replacement characters
 * 
 * eg. strip_whitespace("Line   1\n\tLine 2\r\t\tLine 3  \r\n\t\t\tLine 4\n  "," ");
 * @since 3.3.6
 * @param  str $str     input string
 * @param  string $replace replacement character
 * @return str          new string
 */
function strip_whitespace($str,$replace = ' '){
	$chars = ["\r\n", "\n", "\r", "\t"];
	$str   = str_replace($chars, $replace, $str);
	return preg_replace('/['.$replace.']+/', $replace, $str);
}

/**
 * strip shortcodes based on pattern
 * @since  3.3.6
 * @param  str $str     input string
 * @param  string $pattern regex pattern to strip
 * @return str          new string
 */
function strip_content($str, $pattern = '/[({]%.*?%[})]/'){
	if(getDef('GSCONTENTSTRIPPATTERN',true)) $pattern = getDef('GSCONTENTSTRIPPATTERN');
	return 	preg_replace($pattern, '', $str);
}

/**
 * perform transliteration conversion on string
 * @since  3.3.11
 * @param  str $str string to convert
 * @return str      str after transliteration replacement array ran on it
 */
function doTransliteration($str){
	if (getTransliteration() && is_array($translit=getTransliteration()) && count($translit)>0) {
		$str = str_replace(array_keys($translit),array_values($translit),$str);
	}
	return $str;
}

/**
 * get transliteration set as defined in i18n
 * @since 3.3.11
 * @return str
 */
function getTransliteration(){
	return i18n_r("TRANSLITERATION");
}

?>