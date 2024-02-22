<?php 
/**
 * View Log
 *
 * Displays the log file passed to it 
 *
 * @package GetSimple
 * @subpackage Support
 */

// Setup inclusions
$load['plugin'] = true;
include('inc/common.php');

// Variable Settings
login_cookie_check();

$log_name = var_out(isset($_GET['log']) ? $_GET['log'] : '');
$log_path = GSDATAOTHERPATH.'logs/';

$log_file = $log_path . 'errorlog.txt';

if (!isset($log_name) || !file_exists($log_file)) {
    $log_data = false;
} else {
    $log_data = true;
}

get_template('header', cl($SITENAME).' &raquo; '.i18n_r('SUPPORT').' &raquo; '.i18n_r('LOGS')); 
?>

<?php include('template/include-nav.php'); ?>

<style>
	.log-entry {
		padding: 10px;
		border-top: solid 1px black;
	}
	.timestamp {
		padding:10px;
		color: green;
		font-weight: bold;
		text-decoration:underline;
	}

	.even {
		background-color: #f5f5f5;
	}
	.odd {
		background-color: #ffffff;
	}

	.error-line {
		color: red;
	}
	.stack-trace {
		color: orange;
	}
	.php-line {
		color: #888888;
	}
</style>

<div class="bodycontent clearfix">
    <div id="maincontent">
        <div class="main">
            
			<style type="text/css">
				#phpinfo pre{margin:0;font-family:monospace}#phpinfo a[href*="//"]::after{content:""}#phpinfo, a:link{color:#009;text-decoration:none}#phpinfo a:hover{text-decoration:underline}#phpinfo table{border-collapse:collapse;border:0;width:934px;box-shadow:1px 2px 3px #ccc}#phpinfo .center{text-align:center}#phpinfo .center table{margin:1em auto;text-align:left}#phpinfo .center th{text-align:center!important}#phpinfo td,th{border:1px solid #666;font-size:75%;vertical-align:baseline;padding:4px 5px}#phpinfo h1{font-size:150%;text-align:left}#phpinfo h2{font-size:125%;text-align:left;color:#777BB3}#phpinfo .p{text-align:left;font-size:2em;padding-top:20px}#phpinfo .e{background-color:#ccf;width:300px;font-weight:700}#phpinfo .h{background-color:#99c;font-weight:700}#phpinfo .v{background-color:#ddd;max-width:300px;overflow-x:auto;word-wrap:break-word}#phpinfo .v i{color:#999}#phpinfo img{float:right;border:0}#phpinfo hr{width:934px;background-color:#ccc;border:0;height:1px;}ul li.li-spacer::marker {content: "";}
			</style>
			
			<div id="phpinfo">
				<?php
					ob_start () ;
					phpinfo () ;
					$pinfo = ob_get_contents () ;
					ob_end_clean () ;
					
					// the name attribute "module_Zend Optimizer" of an anker-tag is not xhtml valide, so replace it with "module_Zend_Optimizer"
					echo ( str_replace ( "module_Zend Optimizer", "module_Zend_Optimizer", preg_replace ( '%^.*<body>(.*)</body>.*$%ms', '$1', $pinfo ) ) ) ;
				?>
			</div>
			
        </div>
    </div>
    <div id="sidebar" >
        <?php include('template/sidebar-support.php'); ?>
    </div>    
</div>
<?php get_template('footer'); ?>
