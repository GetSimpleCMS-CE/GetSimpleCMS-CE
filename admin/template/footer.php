<?php
/**
 * Footer Admin Template
 *
 * @package GetSimple
 */

?>
			<footer id="footer" class="gs-footer tw-mt-8">
				<div class="gs-footer-inner tw-flex tw-flex-wrap tw-items-center tw-justify-between tw-gap-4">
					<div class="gs-footer-left">
					<?php 
					include(GSADMININCPATH ."configuration.php");
					if (cookie_check()) { 
						echo '<p class="gs-footer-links"><a href="pages.php">'.i18n_r('PAGE_MANAGEMENT').'</a><span></span><a href="upload.php">'.i18n_r('FILE_MANAGEMENT').'</a><span></span><a href="theme.php">'.i18n_r('THEME_MANAGEMENT').'</a><span></span><a href="backups.php">'.i18n_r('BAK_MANAGEMENT').'</a><span></span><a href="plugins.php">'.i18n_r('PLUGINS_MANAGEMENT').'</a><span></span><a href="settings.php">'.i18n_r('GENERAL_SETTINGS').'</a><span></span><a href="support.php">'.i18n_r('SUPPORT').'</a></p>';
					}
					
					if(!isAuthPage()){ ?>
						<p class="gs-footer-meta">&copy; 2009-<?php echo date('Y'); ?> <a href="https://getsimple-ce.ovh/" target="_blank" rel="noopener">GetSimple CMS CE</a>
						<?php echo '&ndash; '. i18n_r('VERSION') .' '. $site_version_no;  ?>
						</p> 
					</div> <!-- end .footer-left -->
					<div class="gslogo" >
						<a href="https://getsimple-ce.ovh/" target="_blank" rel="noopener"><img src="template/images/getsimple_logo.gif" alt="GetSimple Content Management System" /></a>
					</div>
					<div class="clear"></div>
					<?php
							get_scripts_backend(TRUE);
							exec_action('footer'); 
						}
					?>
				</div><!-- end .gs-footer-inner -->
			</footer><!-- end #footer -->
	<?php 
	if(!isAuthPage()) {
		if (isDebug()){
			global $GS_debug;
			echo '<h2>'.i18n_r('DEBUG_CONSOLE').'</h2><div id="gsdebug">';
			echo '<pre>';
			foreach ($GS_debug as $log){
				if(is_array($log)) print_r($log).'<br/>';
				else print($log.'<br/>');
			}
			echo '</pre>';	
			echo '</div>';
		}
	}
	?>
	</div><!-- end .wrapper -->

	<link rel="stylesheet" type="text/css" href="template/css/admin-modern.css?v=<?php echo GSVERSION; ?>" media="screen" />
	<script type="text/javascript" src="template/js/admin-theme.js?v=<?php echo GSVERSION; ?>"></script>
</body>
</html>
