<?php
/**
 * All Plugins
 *
 * Displays all installed plugins 
 *
 * @package GetSimple
 * @subpackage Plugins
 */
 
// Setup inclusions
$load['plugin'] = true;

// Include common.php
include('inc/common.php');

$pluginid 		=  isset($_GET['set']) ? $_GET['set'] : null;
$nonce    		= isset($_GET['nonce']) ? $_GET['nonce'] : null;

if ($pluginid){
	if(check_nonce($nonce, "set", "plugins.php")) {
	  $plugin=antixss($pluginid);	
	  change_plugin($plugin);
	  redirect('plugins.php');
	}
}


// Variable settings
login_cookie_check();
$counter = 0; $table = null;

$pluginfiles = getFiles(GSPLUGINPATH);
natcasesort($pluginfiles);
$needsupdate = false;
foreach ($pluginfiles as $fi) {
	$pathExt = pathinfo($fi,PATHINFO_EXTENSION );
	$pathName = pathinfo_filename($fi);
	$setNonce='&amp;nonce='.get_nonce("set","plugins.php");
	
	if ($pathExt=="php") {
		if ($live_plugins[$fi]=='true') {
			$cls_Enabled = 'hidden';
			$cls_Disabled = '';
			$trclass='enabled';
		} else {
			$cls_Enabled = '';
			$cls_Disabled = 'hidden';
			$trclass='disabled';
		}
		$api_data = json_decode(get_api_details('plugin', $fi, getDef('GSNOPLUGINCHECK',true)));
		$updatelink = null;
		if (is_object($api_data) && $api_data->status == 'successful') {
			if ($api_data->version > $plugin_info[$pathName]['version']) {				
				$updatelink = '<br /><a class="updatelink" href="'.$api_data->path.'" target="_blank">'.i18n_r('UPDATE_AVAILABLE').' '.$api_data->version.'</a>';
				$needsupdate = true;
			}
			$plugin_title = '<a href="'.$api_data->path.'" target="_blank">'.$api_data->name.'</a>';
		} else {
			$plugin_title = $plugin_info[$pathName]['name'];
		}
		$table .= '<tr id="tr-'.$counter.'" class="'.$trclass.'" >';
		$table .= '<td style="width:150px" ><b>'.$plugin_title.'</b></td>';
		$table .= '<td><span>'.$plugin_info[$pathName]['description'];
		if ($plugin_info[$pathName]['version']!='disabled'){
			$table .= '<br /><b>'.i18n_r('PLUGIN_VER') .' '. $plugin_info[$pathName]['version'].'</b> &mdash; '.i18n_r('AUTHOR').': <a href="'.$plugin_info[$pathName]['author_url'].'" target="_blank">'.$plugin_info[$pathName]['author'].'</a></span>';
		} 
	  $table.= $updatelink.'</td><td style="width:60px;" class="status" >
	  		<a href="plugins.php?set='.$fi.$setNonce.'" class="toggleEnable '.$cls_Enabled.'" style="padding: 1px 3px;" title="'.i18n_r('ENABLE').': '.$plugin_info[$pathName]['name'] .'" >'.i18n_r('ENABLE').'</a>
	  		<a href="plugins.php?set='.$fi.$setNonce.'" class="cancel toggleEnable '.$cls_Disabled.'" title="'.i18n_r('DISABLE').': '.$plugin_info[$pathName]['name'] .'" >'.i18n_r('DISABLE').'</a>
	  	</td>';	  
		$table .= "</tr>\n";
		$counter++;
	}	
}

# set trigger for plugin update notification
if ($needsupdate) {
	touch(GSCACHEPATH.'plugin-update.trigger');	
} else {
	if (file_exists(GSCACHEPATH.'plugin-update.trigger')) {
		unlink(GSCACHEPATH.'plugin-update.trigger');
	}
}	

exec_action('plugin-hook');
get_template('header', cl($SITENAME).' &raquo; '.i18n_r('PLUGINS_MANAGEMENT')); 

?>
	
<?php include('template/include-nav.php'); ?>

<style>.link{vertical-align: middle;}.link:hover{transform: scale(1.3);}</style>
<div class="bodycontent clearfix">
	
	<div id="maincontent">
		<div class="main" >
		<h3><?php i18n('PLUGINS_MANAGEMENT'); ?></h3>
		<p style="color:#333;font-size:12px;margin-top: -15px;"><?php i18n('PLUGINS_MANAGEMENT_INFO'); ?> <a href="<?php echo $SITEURL . $GSADMIN; ?>/load.php?id=modernScript" ><svg xmlns="http://www.w3.org/2000/svg" class="link" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="#808080" d="M18.175 18H15q-.425 0-.712-.288T14 17t.288-.712T15 16h3.175l-.875-.875q-.275-.3-.288-.712t.288-.713t.7-.3t.7.3l2.6 2.6q.3.3.3.7t-.3.7l-2.6 2.6q-.3.3-.7.3t-.7-.3t-.288-.712t.288-.713zM8 10h6q.425 0 .713-.288T15 9t-.288-.712T14 8H8q-.425 0-.712.288T7 9t.288.713T8 10m0 4h3q.425 0 .713-.288T12 13t-.288-.712T11 12H8q-.425 0-.712.288T7 13t.288.713T8 14m-2 4l-2.15 2.15q-.25.25-.55.125T3 19.8V6q0-.825.588-1.412T5 4h12q.825 0 1.413.588T19 6v4.35q0 .3-.213.488t-.512.162q-1.275-.05-2.437.388T13.75 12.75q-.9.925-1.35 2.088t-.4 2.437q.025.3-.175.513T11.35 18z"/></svg></a></p>
		
		<?php if ($counter > 0) { ?>
			<table class="edittable highlight">
				<tr><th><?php i18n('PLUGIN_NAME'); ?></th><th><?php i18n('PLUGIN_DESC'); ?></th><th><?php i18n('STATUS'); ?></th></tr>
				<?php echo $table; ?>
			</table>
		<?php  } ?>
		
		
		<p><em><b><span id="pg_counter"><?php echo $counter; ?></span></b> <?php i18n('PLUGINS_INSTALLED'); ?>
		<?php 
		if ($counter == 0) { 
			echo ' - <a href="http://get-simple.info/extend/" target="_blank" >'. str_replace(['<em>', '</em>'], '', i18n_r('GET_PLUGINS_LINK')) .'</a>';
		}
		?>	
		</em></p>
		
		</div>
	</div>
	
	<script>
		// Function to hide <a> elements with class "cancel" in rows containing any of the specified words
		function hideStatusCellsContainingWords(words) {
			var rows = document.querySelectorAll('tr');
			
			rows.forEach(function(row) {
				for (var i = 0; i < words.length; i++) {
					if (row.innerHTML.indexOf(words[i]) !== -1) {
						var statusCell = row.querySelector('a.cancel');
						if (statusCell) {
							statusCell.style.display = 'none';
						}
						break;
					}
				}
			});
		}

		hideStatusCellsContainingWords(['massiveAdmin.php', 'modernScript.php']);
	</script>
	
	<div id="sidebar" >
		<?php include('template/sidebar-plugins.php'); ?>
	</div>

</div>

<?php get_template('footer'); ?>
