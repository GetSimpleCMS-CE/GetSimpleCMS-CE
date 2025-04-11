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
$nonce			= isset($_GET['nonce']) ? $_GET['nonce'] : null;

if ($pluginid){
	if(check_nonce($nonce, "set", "plugins.php")) {
	  $plugin=antixss($pluginid);	
	  change_plugin($plugin);
	  redirect('plugins.php');
	}
}

// Variable settings
login_cookie_check();
$counter = 0; 
$table = null;

// Plugin database setup
$plugin_db_url = 'https://getsimplecms-ce-plugins.github.io/db.json';
$plugin_db_cache = GSCACHEPATH . 'plugin_db.json';
$plugin_db_data = array();

// Try to get cached version first (valid for 24 hours)
if (file_exists($plugin_db_cache)) {
	$cache_time = filemtime($plugin_db_cache);
	if ((time() - $cache_time) < 86400) {
		$plugin_db_data = json_decode(file_get_contents($plugin_db_cache), true);
	}
}

// If cache doesn't exist or is expired, fetch fresh data with timeout
if (empty($plugin_db_data)) {
	try {
		if (function_exists('curl_init')) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $plugin_db_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 5); // 5 second timeout
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3); // 3 second connection timeout
			curl_setopt($ch, CURLOPT_FAILONERROR, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			$db_content = curl_exec($ch);
			
			if (curl_errno($ch)) {
				debugLog("cURL error fetching plugin database: " . curl_error($ch));
			}
			
			curl_close($ch);
		} else {
			// Fall back to file_get_contents with timeout if cURL not available
			$context = stream_context_create([
				'http' => [
					'timeout' => 5 // 5 second timeout
				]
			]);
			$db_content = @file_get_contents($plugin_db_url, false, $context);
		}
		
		if ($db_content !== false) {
			$plugin_db_data = json_decode($db_content, true);
			if (json_last_error() === JSON_ERROR_NONE) {
				file_put_contents($plugin_db_cache, $db_content);
			} else {
				debugLog("Invalid JSON received from plugin database");
			}
		}
	} catch (Exception $e) {
		// Silently fail - we'll just not show updates
		debugLog("Failed to fetch plugin database: " . $e->getMessage());
	}
}

// Convert the array to an id-indexed array for easier lookup
$plugin_db = array();
if (is_array($plugin_db_data)) {
	foreach ($plugin_db_data as $plugin) {
		$lower_id = strtolower($plugin['id']);
		$plugin_db[$lower_id] = $plugin;
	}
}

$pluginfiles = getFiles(GSPLUGINPATH);
natcasesort($pluginfiles);
$needsupdate = false;

foreach ($pluginfiles as $fi) {
	$pathExt = pathinfo($fi, PATHINFO_EXTENSION);
	$pathName = pathinfo_filename($fi);
	$lower_pathName = strtolower($pathName); // Convert to lowercase for matching
	$setNonce = '&amp;nonce='.get_nonce("set", "plugins.php");
	
	if ($pathExt == "php") {
		if ($live_plugins[$fi] == 'true') {
			$cls_Enabled = 'hidden';
			$cls_Disabled = '';
			$trclass = 'enabled';
		} else {
			$cls_Enabled = '';
			$cls_Disabled = 'hidden';
			$trclass = 'disabled';
		}

		$updatelink = null;
		$plugin_title = isset($plugin_info[$pathName]['name']) ? $plugin_info[$pathName]['name'] : $pathName;
		$plugin_version = isset($plugin_info[$pathName]['version']) ? $plugin_info[$pathName]['version'] : '0';

		// Check if plugin exists in the database (case-insensitive)
		if (isset($plugin_db[$lower_pathName])) {
			$db_plugin = $plugin_db[$lower_pathName];
			
			// Use name from database (with icon if present)
			$plugin_title = '<a href="'.$db_plugin['repo'].'" target="_blank">'.$db_plugin['name'].'</a>';
			
			// Enhance description with info from database if available
			if (!empty($db_plugin['info'])) {
				$plugin_info[$pathName]['description'] = $db_plugin['info'];
			}
			
			// Ensure author info is populated
			if (empty($plugin_info[$pathName]['author']) && !empty($db_plugin['author'])) {
				$plugin_info[$pathName]['author'] = $db_plugin['author'];
				$plugin_info[$pathName]['author_url'] = $db_plugin['repo'];
			}
			
			// Compare versions only if plugin is enabled
			if ($live_plugins[$fi] == 'true' && version_compare($db_plugin['version'], $plugin_version, '>')) {
				$updatelink = '<a class="updatelink" href="'.$db_plugin['url'].'" title="'.i18n_r('UPDATE_AVAILABLE').' v'.$db_plugin['version'].'" target="_blank">'.i18n_r('UPDATE_AVAILABLE').' v'.$db_plugin['version'].'</a>';
				$needsupdate = true;
			}
		}

		$table .= '<tr id="tr-'.$counter.'" class="'.$trclass.'" >';
		$table .= '<td><b>'.$plugin_title.'</b></td>';
		$table .= '<td><span>'.$plugin_info[$pathName]['description'];
		if ($plugin_info[$pathName]['version']!='disabled'){
			$table .= '<br /><b>'.i18n_r('PLUGIN_VER') .' '. $plugin_info[$pathName]['version'].'</b> &mdash; '.i18n_r('AUTHOR').': <a href="'.$plugin_info[$pathName]['author_url'].'" target="_blank">'.$plugin_info[$pathName]['author'].'</a></span>';
		} 
		$table .= '</td><td class="status" >
		<div style="display: flex; justify-content: space-between; align-items: center;">
			<div class="col1">
				<a href="plugins.php?set='.$fi.$setNonce.'" class="toggleEnable '.$cls_Enabled.'" style="padding: 1px 3px;" title="'.i18n_r('ENABLE').': '.$plugin_info[$pathName]['name'] .'" >'.i18n_r('ENABLE').'</a>
				<a href="plugins.php?set='.$fi.$setNonce.'" class="cancel toggleEnable '.$cls_Disabled.'" title="'.i18n_r('DISABLE').': '.$plugin_info[$pathName]['name'] .'" >'.i18n_r('DISABLE').'</a>
			</div>
			<div class="col2">
				'.$updatelink.'
			</div>
			<div class="col3">
				<a title="Repo" href="'.$db_plugin['repo'].'" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24"><rect width="24" height="24" fill="none"/><g fill="none"><g clip-path="url(#akarIconsGithubFill0)"><path fill="#333" fill-rule="evenodd" d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385c.6.105.825-.255.825-.57c0-.285-.015-1.23-.015-2.235c-3.015.555-3.795-.735-4.035-1.41c-.135-.345-.72-1.41-1.23-1.695c-.42-.225-1.02-.78-.015-.795c.945-.015 1.62.87 1.845 1.23c1.08 1.815 2.805 1.305 3.495.99c.105-.78.42-1.305.765-1.605c-2.67-.3-5.46-1.335-5.46-5.925c0-1.305.465-2.385 1.23-3.225c-.12-.3-.54-1.53.12-3.18c0 0 1.005-.315 3.3 1.23c.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23c.66 1.65.24 2.88.12 3.18c.765.84 1.23 1.905 1.23 3.225c0 4.605-2.805 5.625-5.475 5.925c.435.375.81 1.095.81 2.22c0 1.605-.015 2.895-.015 3.3c0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12" clip-rule="evenodd" stroke-width="0.5" stroke="#333"/></g><defs><clipPath id="akarIconsGithubFill0"><path fill="#fff" d="M0 0h24v24H0z"/></clipPath></defs></g></svg></a> '.(!empty($db_plugin['wiki']) ? ' <a style="padding-left:10px" title="Wiki" href="'.$db_plugin['wiki'].'" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 48 48"><rect width="48" height="48" fill="none"/><circle cx="24" cy="24" r="21" fill="#2196f3" stroke-width="1" stroke="#2196f3"/><path fill="#fff" d="M22 22h4v11h-4z" stroke-width="1" stroke="#fff"/><circle cx="24" cy="16.5" r="2.5" fill="#fff" stroke-width="1" stroke="#fff"/></svg></a>' : '').'
			</div>
		</div>
	  		
	  	</td>';	  
		$table .= "</tr>\n";
		$counter++;
	}	
}

// Set trigger for plugin update notification
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

<style>
	.enabled td b a{font-weight:600!important; text-decoration:none!important;}
	.disabled td b a{text-decoration:none!important;}
	.link{vertical-align: middle;}.link:hover{transform: scale(1.3);}
	.wrapper table.highlight tr:nth-child(2n+1) {background:none;}
	table tr.disabled {background:none; }
	table tr.disabled a.updatelink:link, a.updatelink:visited {opacity: 0.75;}
	a.updatelink:link, a.updatelink:visited {
		background: #808080 !important;
		color: #fff !important;
		text-shadow: none !important;
		text-decoration: none !important;
		font-weight:400!important;
		padding: 5px 10px !important;
		border-radius: 5px !important;
	}
</style>

<div class="bodycontent clearfix">
	
	<div id="maincontent">
		<div class="main" >
		<h3><?php i18n('PLUGINS_MANAGEMENT'); ?></h3>
		<!--p style="color:#333;font-size:12px;margin-top: -15px;"><?php i18n('PLUGINS_MANAGEMENT_INFO'); ?> <a href="<?php echo $SITEURL . $GSADMIN; ?>/load.php?id=modernScript" ><svg xmlns="http://www.w3.org/2000/svg" class="link" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="#808080" d="M18.175 18H15q-.425 0-.712-.288T14 17t.288-.712T15 16h3.175l-.875-.875q-.275-.3-.288-.712t.288-.713t.7-.3t.7.3l2.6 2.6q.3.3.3.7t-.3.7l-2.6 2.6q-.3.3-.7.3t-.7-.3t-.288-.712t.288-.713zM8 10h6q.425 0 .713-.288T15 9t-.288-.712T14 8H8q-.425 0-.712.288T7 9t.288.713T8 10m0 4h3q.425 0 .713-.288T12 13t-.288-.712T11 12H8q-.425 0-.712.288T7 13t.288.713T8 14m-2 4l-2.15 2.15q-.25.25-.55.125T3 19.8V6q0-.825.588-1.412T5 4h12q.825 0 1.413.588T19 6v4.35q0 .3-.213.488t-.512.162q-1.275-.05-2.437.388T13.75 12.75q-.9.925-1.35 2.088t-.4 2.437q.025.3-.175.513T11.35 18z"/></svg></a></p-->
		
		<?php if ($counter > 0) { ?>
			<table class="edittable highlight">
				<tr><th><?php i18n('PLUGIN_NAME'); ?></th><th><?php i18n('PLUGIN_DESC'); ?></th><th><?php i18n('STATUS'); ?></th></tr>
				<?php echo $table; ?>
			</table>
		<?php  } ?>
		
		
		<p><em><b><span id="pg_counter"><?php echo $counter; ?></span></b> <?php i18n('PLUGINS_INSTALLED'); ?>
		<?php 
		if ($counter == 0) { 
			echo ' - <a href="https://github.com/orgs/GetSimpleCMS-CE-plugins/repositories" target="_blank" >'. str_replace(['<em>', '</em>'], '', i18n_r('GET_PLUGINS_LINK')) .'</a>';
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
		hideStatusCellsContainingWords(['xmassiveAdmin.php', 'xUpdateCE.php']);
		
		// Function to hide Installed Plugins containing any of the specified words
		function hideRowsBasedOnConditions(words) {
			var rows = document.querySelectorAll('tbody tr');
			
			rows.forEach(function(row) {
				var rowClass = row.classList.contains('enabled');
				var shouldHide = false;
				if (rowClass) {
					for (var i = 0; i < words.length; i++) {
						if (row.innerHTML.indexOf(words[i]) !== -1) {
							shouldHide = true;
							break;
						}
					}
				}
				if (shouldHide) {
					row.style.display = 'none';
				}
			});
		}
		hideRowsBasedOnConditions(['xUpdateCE.php']);
	</script>
	
	<div id="sidebar" >
		<?php include('template/sidebar-plugins.php'); ?>
	</div>

</div>

<?php get_template('footer'); ?>
