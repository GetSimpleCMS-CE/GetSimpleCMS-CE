<?php
/**
 * Footer Admin Template
 *
 * @package GetSimple
 */

?>
		<div id="footer">
      		<div class="footer-left" >
      		<?php 
	  		include(GSADMININCPATH ."configuration.php");
	  		if (cookie_check()) { 
	  			echo '<p><a href="pages.php">'.i18n_r('PAGE_MANAGEMENT').'</a> &nbsp;&bull;&nbsp; <a href="upload.php">'.i18n_r('FILE_MANAGEMENT').'</a> &nbsp;&bull;&nbsp; <a href="theme.php">'.i18n_r('THEME_MANAGEMENT').'</a> &nbsp;&bull;&nbsp; <a href="backups.php">'.i18n_r('BAK_MANAGEMENT').'</a> &nbsp;&bull;&nbsp; <a href="plugins.php">'.i18n_r('PLUGINS_MANAGEMENT').'</a> &nbsp;&bull;&nbsp; <a href="settings.php">'.i18n_r('GENERAL_SETTINGS').'</a> &nbsp;&bull;&nbsp; <a href="support.php">'.i18n_r('SUPPORT').'</a> </p>';
	  		}
      		
      		if(!isAuthPage()){ ?>
	      		<p>&copy; 2009-<?php echo date('Y'); ?> <a href="https://getsimple-ce.ovh/" target="_blank" >GetSimple CMS CE</a>
	      		<?php echo '&ndash; '. i18n_r('VERSION') .' '. $site_version_no;  ?>
	      		</p> 
      		</div> <!-- end .footer-left -->
	      	<div class="gslogo" >
		      	<a href="https://getsimple-ce.ovh/" target="_blank" ><img src="template/images/getsimple_logo.gif" alt="GetSimple Content Management System" /></a>
		    </div>
	      	<div class="clear"></div>
	      	<?php
		      		get_scripts_backend(TRUE);
		      		exec_action('footer'); 
	      		}
	      	?>

		</div><!-- end #footer -->
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
	
	
	
</body>
</html>