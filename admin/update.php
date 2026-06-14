<?php 
/**
 * Update
 *
 * Provides any updating to the system the first time it is run
 *
 * @package GetSimple
 * @subpackage Init
 */

$load['plugin'] = true;
include('inc/common.php');

/* delete caches */
delete_cache();

/* 
 * Updates below here 
 */

$message = null;

// redirect to health check or login and show updated notice
$redirect = cookie_check() ? "health-check.php?updated=1" : "index.php?updated=1";

// If no errors or messages, then we did nothing, just continue automatically
if(!isset($error) && !isset($message)) redirect($redirect);

// we already showed a notice, pass updated so it gets deleted, no indication, 
$redirect = cookie_check() ? "health-check.php?updated=2" : "index.php?updated=2";

// show errors or messages
if(isset($error)) $message.= i18n_r('ER_REQ_PROC_FAIL');
else $message.= "<p><div class=\"notify notify_ok\">".i18n_r('SITE_UPDATED')."</div></p>";

get_template('header', $site_full_name.' &raquo; '. i18n_r('SYSTEM_UPDATE')); 

?>

	<h1><?php echo $site_full_name; ?></h1>
</div> 
</div><!-- Closes header -->
<div class="wrapper">
	<?php // include('template/error_checking.php'); ?>

	<div id="maincontent">
		<div class="main" >
			<h3><?php i18n('SYSTEM_UPDATE'); ?></h3>

			<?php 
				echo "$message";
				echo '<p><a href="'.$redirect.'">'.i18n_r('CONTINUE_SETUP').'</a></p>';
			?>

		</div>
	</div>
	<div class="clear"></div>
	<?php get_template('footer'); ?> 