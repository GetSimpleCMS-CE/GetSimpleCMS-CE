<?php
/**
 * Configuration File
 *
 * @package GetSimple
 * @subpackage Config
 */

$site_full_name     = 'GetSimple CE';
$site_version_no    = '3.3.23 2026.03.26 Beta';
$name_url_clean     = lowercase(str_replace(' ','-',$site_full_name));
$ver_no_clean       = str_replace('.','',$site_version_no);
$site_link_back_url = 'https://getsimple-ce.ovh/';

// cookie config
$cookie_name        = lowercase($name_url_clean) .'_cookie_'. $ver_no_clean; // non-hashed name of cookie
$cookie_login       = 'index.php'; // login redirect
$cookie_time        = '10800';     // in seconds, 3 hours
$cookie_path        = '/';         // cookie path
$cookie_domain      = null;        // cookie domain
$cookie_secure      = null;        // cookie secure only
$cookie_httponly    = true;        // cookie http only

$api_url            = 'https://getsimple-ce.ovh/api/#';
# $api_timeout        = 800; // time in ms defaults to 500
# $debugApi           = true;

$cookie_redirect = 'pages.php';

// If the Dashboard plugin is installed and enabled, redirect there instead
$plugins_xml_path = dirname(__FILE__) . '/../../data/other/plugins.xml';
if (file_exists($plugins_xml_path)) {
    $plugins_data = simplexml_load_file($plugins_xml_path);
    if ($plugins_data) {
        foreach ($plugins_data->item as $item) {
            if ((string)$item->plugin === 'Dashboard.php' && (string)$item->enabled === 'true') {
                $cookie_redirect = 'load.php?id=Dashboard';
                break;
            }
        }
    }
}

if (!defined('GSVERSION')) define('GSVERSION', $site_version_no);

?>
