<?php 
/**
 * Support
 *
 * @package GetSimple
 * @subpackage Support
 */

# Setup inclusions
$load['plugin'] = true;
include('inc/common.php');
login_cookie_check();

get_template('header', cl($SITENAME).' &raquo; '.i18n_r('SUPPORT') ); 

?>
	
<?php include('template/include-nav.php'); ?>

<style>
	.support-links{list-style-type: none;}
	.support-links a{text-decoration: none !important;}
	.support-links li{margin: 5px 0;}
	.support-links svg{vertical-align:middle;width:18px;height:18px;}
</style>

<div class="bodycontent clearfix">
	
	<div id="maincontent">
		<div class="main">
			
			<h3><?php i18n('SUPPORT');?></h3>
			<ul class="support-links">
				<li> <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="#333" d="M10 3L8 5v2H5C3.85 7 3.12 8 3 9L2 19c-.12 1 .54 2 2 2h16c1.46 0 2.12-1 2-2L21 9c-.12-1-.94-2-2-2h-3V5l-2-2zm0 2h4v2h-4zm1 5h2v3h3v2h-3v3h-2v-3H8v-2h3z"/></svg> <a href="health-check.php"><?php i18n('WEB_HEALTH_CHECK'); ?></a></li>
				<li> <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="#333" d="M13 8a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4a4 4 0 0 1 4 4m4 10v2H1v-2c0-2.21 3.58-4 8-4s8 1.79 8 4m3.5-3.5V16H19v-1.5zm-2-5H17V9a3 3 0 0 1 3-3a3 3 0 0 1 3 3c0 .97-.5 1.88-1.29 2.41l-.3.19c-.57.4-.91 1.01-.91 1.7v.2H19v-.2c0-1.19.6-2.3 1.59-2.95l.29-.19c.39-.26.62-.69.62-1.16A1.5 1.5 0 0 0 20 7.5A1.5 1.5 0 0 0 18.5 9z"/></svg> <a href="log.php?log=failedlogins.log"><?php i18n('VIEW_FAILED_LOGIN');?></a></li>
				<li> <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="#333" d="M13 14h-2V9h2m0 9h-2v-2h2M1 21h22L12 2z"/></svg> <a href="log-error.php?log=errorlog.txt"><?php i18n('VIEW');?> ErrorLog</a></li>
				<li> <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="#333" d="M13 9h-2V7h2m0 10h-2v-6h2m-1-9A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2"/></svg> <a href="phpinfo.php"><?php i18n('VIEW');?> phpInfo</a></p></li>
				<?php exec_action('support-extras'); ?>
			</ul>
	
			<h3><?php i18n('GETTING_STARTED');?></h3>
			
			<ul>
				<li><a href="https://github.com/GetSimpleCMS-CE/GetSimpleCMS-CE" target="_blank">Github SVN</a></li>
				<li><a href="http://get-simple.info/docs/" target="_blank" ><?php i18n('SIDE_DOCUMENTATION'); ?></a></li>
				<li><a href="http://get-simple.info/forum/" target="_blank" ><?php i18n('SUPPORT_FORUM'); ?></a></li>
				<li><a href="https://getsimple-ce.ovh/" target="_blank" ><?php echo str_replace(['<em>', '</em>'], '', i18n_r('GET_PLUGINS_LINK')); ?></a></li>
				<!-- li><a href="share.php?term=<?php i18n('SHARE'); ?>" rel="facybox" ><?php i18n('SHARE'); ?> GetSimple</a></li -->
			</ul>
			
			<p><?php i18n('WELCOME_MSG'); ?> <?php i18n('WELCOME_P'); ?></p>
			
			<ul>
				<li><a href="edit.php"><?php i18n('CREATE_NEW_PAGE'); ?></a></li>
				<li><a href="upload.php"><?php i18n('UPLOADIFY_BUTTON'); ?></a></li>
				<li><a href="settings.php"><?php i18n('GENERAL_SETTINGS'); ?></a></li>
				<li><a href="theme.php"><?php i18n('CHOOSE_THEME'); ?></a></li>
				<?php exec_action('welcome-link'); ?>
				<?php exec_action('welcome-doc-link'); ?>
			</ul>

		</div>
	</div>
	
	<div id="sidebar" >
		<?php include('template/sidebar-support.php'); ?>
	</div>

</div>
<?php get_template('footer'); ?>
