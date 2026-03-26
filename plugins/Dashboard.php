<?php
if (!defined('IN_GS')) { die('You cannot load this page directly.'); }

$Dashboard = basename(__FILE__, ".php");

# add in this plugin's language file
i18n_merge($Dashboard) || i18n_merge($Dashboard, 'en_US');

register_plugin(
	$Dashboard,
	'Dashboard',
	'1.0',
	'risingisland',
	'https://www.getsimple-ce.ovh/',
	'Customizable admin dashboard shown after login.',
	dash_page_type(),
	'dash_router'
);

// -------------------------------------------------------
// Module header parser
// -------------------------------------------------------
function dash_get_modules() {
	$module_path = GSPLUGINPATH . 'Dashboard/modules/';
	$modules = array();
	if (!is_dir($module_path)) return $modules;
	foreach (glob($module_path . '*.php') as $file) {
		$headers = array(
			'Module Name' => '',
			'Module ID'   => '',
			'Description' => '',
			'Version'	 => '',
			'Default W'   => '4',
			'Default H'   => '2',
		);
		$contents = file_get_contents($file);
		foreach ($headers as $key => $val) {
			if (preg_match('/' . preg_quote($key, '/') . ':\s*(.+)/i', $contents, $match)) {
				$headers[$key] = trim($match[1]);
			}
		}
		if ($headers['Module ID']) {
			$headers['file'] = basename($file);
			$modules[$headers['Module ID']] = $headers;
		}
	}
	return $modules;
}

// -------------------------------------------------------
// Layout data helpers
// -------------------------------------------------------
function dash_layout_file() {
	return GSDATAOTHERPATH . 'dashboard/layout.json';
}

function dash_get_layout() {
	$file = dash_layout_file();
	if (file_exists($file)) {
		$data = json_decode(file_get_contents($file), true);
		if (is_array($data)) return $data;
	}
	return array('enabled' => array(), 'grid' => array());
}

function dash_save_layout($data) {
	$dir = GSDATAOTHERPATH . 'dashboard/';
	if (!is_dir($dir)) mkdir($dir, 0755, true);
	file_put_contents(dash_layout_file(), json_encode($data));
}

// -------------------------------------------------------
// Include i18n for Modules
// -------------------------------------------------------
function dash_module_i18n($module_id) {
    i18n_merge('Dashboard/modules/' . $module_id)
        || i18n_merge('Dashboard/modules/' . $module_id, 'en_US');
    $prefix = 'Dashboard/modules/' . $module_id . '/';
    return function($key) use ($prefix) { return i18n_r($prefix . $key); };
}

// -------------------------------------------------------
// Page type
// -------------------------------------------------------
function dash_page_type() {
	if (isset($_GET['dashboard-settings'])) return 'settings';
	return 'dashboard';
}

add_action('nav-tab', 'createNavTab', array('dashboard', $Dashboard,
	'<span title="' . i18n_r('Dashboard/lang_Title') . '"><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;" width="24" height="24" viewBox="0 0 24 24"><rect width="24" height="24" fill="none"/><path fill="currentColor" d="M6.25 3A3.25 3.25 0 0 0 3 6.25v11.5A3.25 3.25 0 0 0 6.25 21h5.772a6.5 6.5 0 0 1-.709-1.5H6.25a1.75 1.75 0 0 1-1.75-1.75V15.5h6.813a6.5 6.5 0 0 1 .709-1.5H10v-4h9.5v1.313a6.5 6.5 0 0 1 1.5.709V6.25A3.25 3.25 0 0 0 17.75 3zM4.5 6.25c0-.966.784-1.75 1.75-1.75H14v4H4.5zm0 3.75h4v4h-4zm15-1.5h-4v-4h2.25c.966 0 1.75.784 1.75 1.75zm-5.223 5.476a2 2 0 0 1-1.441 2.496l-.584.145a5.7 5.7 0 0 0 .006 1.807l.54.13a2 2 0 0 1 1.45 2.51l-.187.631c.44.386.94.7 1.485.922l.493-.519a2 2 0 0 1 2.899 0l.499.526a5.3 5.3 0 0 0 1.482-.913l-.198-.686a2 2 0 0 1 1.442-2.496l.583-.145a5.7 5.7 0 0 0-.006-1.807l-.54-.13a2 2 0 0 1-1.449-2.51l.186-.631a5.3 5.3 0 0 0-1.484-.922l-.493.518a2 2 0 0 1-2.9 0l-.498-.525c-.544.22-1.044.53-1.483.913zM17.5 19c-.8 0-1.45-.671-1.45-1.5c0-.828.65-1.5 1.45-1.5s1.45.672 1.45 1.5c0 .829-.65 1.5-1.45 1.5"/></svg></span>'
));

add_action('settings-sidebar', 'createSideMenu', array($Dashboard, i18n_r('Dashboard/lang_Settings') . ' <svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;" width="20" height="20" viewBox="0 0 24 24"><rect width="24" height="24" fill="none"/><path fill="currentColor" d="M6.25 3A3.25 3.25 0 0 0 3 6.25v11.5A3.25 3.25 0 0 0 6.25 21h5.772a6.5 6.5 0 0 1-.709-1.5H6.25a1.75 1.75 0 0 1-1.75-1.75V15.5h6.813a6.5 6.5 0 0 1 .709-1.5H10v-4h9.5v1.313a6.5 6.5 0 0 1 1.5.709V6.25A3.25 3.25 0 0 0 17.75 3zM4.5 6.25c0-.966.784-1.75 1.75-1.75H14v4H4.5zm0 3.75h4v4h-4zm15-1.5h-4v-4h2.25c.966 0 1.75.784 1.75 1.75zm-5.223 5.476a2 2 0 0 1-1.441 2.496l-.584.145a5.7 5.7 0 0 0 .006 1.807l.54.13a2 2 0 0 1 1.45 2.51l-.187.631c.44.386.94.7 1.485.922l.493-.519a2 2 0 0 1 2.899 0l.499.526a5.3 5.3 0 0 0 1.482-.913l-.198-.686a2 2 0 0 1 1.442-2.496l.583-.145a5.7 5.7 0 0 0-.006-1.807l-.54-.13a2 2 0 0 1-1.449-2.51l.186-.631a5.3 5.3 0 0 0-1.484-.922l-.493.518a2 2 0 0 1-2.9 0l-.498-.525c-.544.22-1.044.53-1.483.913zM17.5 19c-.8 0-1.45-.671-1.45-1.5c0-.828.65-1.5 1.45-1.5s1.45.672 1.45 1.5c0 .829-.65 1.5-1.45 1.5"/></svg>', 'dashboard-settings'));

add_action('header', 'dash_reorder_tab');

add_action('successful-login-end', 'dash_login_redirect');

if (isset($_POST['dash_save_layout']) && isset($_POST['layout'])) {
	$raw  = stripslashes($_POST['layout']);
	$data = json_decode($raw, true);
	if (is_array($data)) {
		dash_save_layout($data);
		header('Content-Type: application/json');
		echo json_encode(array('status' => 'ok'));
	} else {
		header('Content-Type: application/json');
		echo json_encode(array('status' => 'error'));
	}
	exit();
}

if (isset($_POST['dash_load_mstore'])) {
	require_once(GSPLUGINPATH . 'Dashboard/classes/ModuleInstaller.php');
	header('Content-Type: application/json');
	ob_start();
	ModuleInstaller::renderPanel();
	$html = ob_get_clean();
	echo json_encode(array('status' => 'ok', 'html' => $html));
	exit();
}

if (isset($_POST['dash_load_modules'])) {
	header('Content-Type: application/json');
	echo json_encode(array('status' => 'ok', 'modules' => dash_get_modules()));
	exit();
}

if (isset($_POST['dash_install_module'])) {
	require_once(GSPLUGINPATH . 'Dashboard/classes/ModuleInstaller.php');
	ModuleInstaller::install();
	exit();
}

// -------------------------------------------------------
// Login redirect
// -------------------------------------------------------
function dash_login_redirect() {
	global $SITEURL;
	echo '<script type="text/javascript">window.location.href="' . $SITEURL . 'admin/load.php?id=Dashboard";</script>';
	exit();
}

// -------------------------------------------------------
// Reorder tab to first position
// -------------------------------------------------------
function dash_reorder_tab() {
	?>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		var $dashTab = $('#nav_Dashboard');
		var $pages = $('#nav_pages');
		if ($dashTab.length && $pages.length) {
			$dashTab.insertBefore($pages);
		}
	});
	</script>
	<?php
}

// -------------------------------------------------------
// Router
// -------------------------------------------------------
function dash_router() {
	// Handle AJAX layout save from settings page
	if (isset($_POST['dash_save_layout'])) {
		dash_handle_save();
		return;
	}
	if (isset($_GET['dashboard-settings'])) {
		dash_settings();
	} else {
		dash_main();
	}
}

function dash_handle_save() {
	$raw = isset($_POST['layout']) ? $_POST['layout'] : '{}';
	$data = json_decode(stripslashes($raw), true);
	if (is_array($data)) {
		dash_save_layout($data);
		echo json_encode(array('status' => 'ok'));
	} else {
		echo json_encode(array('status' => 'error'));
	}
	exit();
}

// -------------------------------------------------------
// Main Dashboard Page
// -------------------------------------------------------
function dash_main() {
	global $SITEURL, $USR;

	$displayName = $USR ? htmlspecialchars($USR) : 'User';
	if ($USR && defined('GSUSERSPATH')) {
		$userFile = GSUSERSPATH . (function_exists('_id') ? _id($USR) : $USR) . '.xml';
		$raw = @file_get_contents($userFile);
		if ($raw !== false) {
			libxml_use_internal_errors(true);
			$userData = simplexml_load_string($raw);
			libxml_clear_errors();
			if ($userData) {
				$name = (string)$userData->NAME[0];
				if ($name !== '') $displayName = htmlspecialchars($name);
			}
		}
	}

	$layout  = dash_get_layout();
	$enabled = isset($layout['enabled']) ? $layout['enabled'] : array();
	$grid	= isset($layout['grid'])	? $layout['grid']	: array();

	// Build a lookup of saved positions by module id
	$positions = array();
	foreach ($grid as $item) {
		if (isset($item['id'])) $positions[$item['id']] = $item;
	}

	$modules = dash_get_modules();
	?>
	<link rel="stylesheet" href="<?php echo $SITEURL ?>plugins/Dashboard/assets/css/gridstack.min.css"/>
	<link rel="stylesheet" href="<?php echo $SITEURL ?>plugins/Dashboard/assets/css/pure-min.css"/>
	<style>
		#sidebar {display:none;}
		.bodycontent { display: inline; }
		h2, span#dashGreeting{color:#607D8B!important;}
		h3{color:#607D8B; margin:0 0 10px 0;}
		.grid-stack-item-content h3 {opacity:.80;}
		.grid-stack-item-content {
			background: #fff;
			border: 1px solid #ddd;
			border-radius: 4px;
			padding: 12px;
			overflow: auto;
			/* Scrollbar styling */
			scrollbar-width: thin;
			scrollbar-color: #4E98FF #f5f5f5;
		}
		.grid-stack-item-content::-webkit-scrollbar {
			width: 5px;
			height: 5px;
		}
		.grid-stack-item-content::-webkit-scrollbar-track {
			background: #f5f5f5;
			border-radius: 3px;
		}
		.grid-stack-item-content::-webkit-scrollbar-thumb {
			background: #4E98FF;
			border-radius: 3px;
		}
		.grid-stack-item-content::-webkit-scrollbar-thumb:hover {
			background: #aaa;
		}
		.main-dash h3{
			font-family: Arial, Helvetica, sans-serif;
			font-style: normal; 
			font-weight: 600 !important;
		}
		
		.grid-stack-item-content {
			background: #fff;
			border: 1px solid #ddd;
			border-radius: 4px;
			padding: 12px;
			overflow: auto;
		}
		.gs-module-title {
			/*font-weight: 600;
			margin-bottom: 8px;
			font-size: 13px;
			color: #555;
			border-bottom: 1px solid #eee;
			padding-bottom: 6px;*/
			display:none;
		}
		hr.style-one {
			border: 0;
			border-top: 1px dotted #8c8c8c;
			border-bottom: 1px dotted #fff;
		}
		span#dashGreeting {
			// display: flex;
			// align-items: center;
			// justify-content: space-between;
			font-size: 1.2rem;
			font-weight: 500;
			color: #666;
			// margin-bottom: 20px;
		}

		.dash-icon svg{
			// font-size: 1.4rem;
			// display: block;
			opacity: 0.85;
			width:28px;
			height:28px;
			vertical-align:middle;
		}
	</style>

	<div class="bodycontent main-dash">
		<div class="maincontent">
			<header style="padding:10px 0 14px;">
				<div class="pure-g">
					<div class="pure-u-12-24">
						<h3>
							<svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:bottom;" width="1.2em" height="1.2em" viewBox="0 0 24 24"><rect width="24" height="24" fill="none"/><path fill="currentColor" d="M6.25 3A3.25 3.25 0 0 0 3 6.25v11.5A3.25 3.25 0 0 0 6.25 21h5.772a6.5 6.5 0 0 1-.709-1.5H6.25a1.75 1.75 0 0 1-1.75-1.75V15.5h6.813a6.5 6.5 0 0 1 .709-1.5H10v-4h9.5v1.313a6.5 6.5 0 0 1 1.5.709V6.25A3.25 3.25 0 0 0 17.75 3zM4.5 6.25c0-.966.784-1.75 1.75-1.75H14v4H4.5zm0 3.75h4v4h-4zm15-1.5h-4v-4h2.25c.966 0 1.75.784 1.75 1.75zm-5.223 5.476a2 2 0 0 1-1.441 2.496l-.584.145a5.7 5.7 0 0 0 .006 1.807l.54.13a2 2 0 0 1 1.45 2.51l-.187.631c.44.386.94.7 1.485.922l.493-.519a2 2 0 0 1 2.899 0l.499.526a5.3 5.3 0 0 0 1.482-.913l-.198-.686a2 2 0 0 1 1.442-2.496l.583-.145a5.7 5.7 0 0 0-.006-1.807l-.54-.13a2 2 0 0 1-1.449-2.51l.186-.631a5.3 5.3 0 0 0-1.484-.922l-.493.518a2 2 0 0 1-2.9 0l-.498-.525c-.544.22-1.044.53-1.483.913zM17.5 19c-.8 0-1.45-.671-1.45-1.5c0-.828.65-1.5 1.45-1.5s1.45.672 1.45 1.5c0 .829-.65 1.5-1.45 1.5"/></svg>
							<?php echo i18n_r('Dashboard/lang_Title'); ?>
						</h3>
					</div>
					<div class="pure-u-12-24 text-right">
						<div class="dash-greeting">
							<h2><span id="dashGreeting"></span>
							<span id="dashIcon" class="dash-icon"></span></h2>
						</div>
					</div>
				</div>
				<hr class="style-one">
			</header>

			<?php if (empty($enabled)): ?>
				<p style="color:#888;">No modules are enabled. Visit <a href="load.php?id=Dashboard&dashboard-settings">Dashboard Settings</a> to add some.</p>
			<?php else: ?>
				<div class="grid-stack">
				<?php foreach ($enabled as $id):
					if (!isset($modules[$id])) continue;
					$mod = $modules[$id];
					$pos = isset($positions[$id]) ? $positions[$id] : array();
					$x = isset($pos['x']) ? (int)$pos['x'] : 0;
					$y = isset($pos['y']) ? (int)$pos['y'] : 0;
					$w = isset($pos['w']) ? (int)$pos['w'] : (int)$mod['Default W'];
					$h = isset($pos['h']) ? (int)$pos['h'] : (int)$mod['Default H'];
				?>
					<div class="grid-stack-item" gs-id="<?php echo htmlspecialchars($id); ?>"
						 gs-x="<?php echo $x; ?>" gs-y="<?php echo $y; ?>"
						 gs-w="<?php echo $w; ?>" gs-h="<?php echo $h; ?>">
						<div class="grid-stack-item-content" id="<?php echo htmlspecialchars($id); ?>">
							<div class="gs-module-title"><?php echo htmlspecialchars($mod['Module Name']); ?></div>
							<?php include(GSPLUGINPATH . 'Dashboard/modules/' . $mod['file']); ?>
						</div>
					</div>
				<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<script src="<?php echo $SITEURL ?>plugins/Dashboard/assets/js/svg-loader.min.js" async></script>
	<script src="<?php echo $SITEURL ?>plugins/Dashboard/assets/js/gridstack-all.js"></script>
	<script>
	GridStack.init({ 
		staticGrid: true, 
		cellHeight: 80,
		columnOpts: {
			breakpoints: [
				{ w: 1024, c: 2 },  // 2 columns on medium screens
				{ w: 768,  c: 1 }   // 1 column on small screens
			]
		}
	});
	</script>
	
	<script>
	function updateGreeting() {
		const now = new Date();
		const hour = now.getHours();
		const name = "<?php echo $displayName; ?>";

		let greeting, icon;

		if (hour < 4) {
			greeting = "<?php echo i18n_r('Dashboard/lang_midnight_oil'); ?>";
			icon = lateIcon();
		} else if (hour < 7) {
			greeting = "<?php echo i18n_r('Dashboard/lang_in_bed'); ?>";
			icon = tooearlyIcon();
		} else if (hour < 12) {
			greeting = "<?php echo i18n_r('Dashboard/lang_Good_morning'); ?>";
			icon = morningIcon();
		} else if (hour < 17) {
			greeting = "<?php echo i18n_r('Dashboard/lang_Good_afternoon'); ?>";
			icon = afternoonIcon();
		} else if (hour < 21) {
			greeting = "<?php echo i18n_r('Dashboard/lang_Good_evening'); ?>";
			icon = eveningIcon();
		} else {
			greeting = "<?php echo i18n_r('Dashboard/lang_Good_night'); ?>";
			icon = nightIcon();
		}

		document.getElementById("dashGreeting").textContent =
			greeting + (name ? ", " + name : "");

		document.getElementById("dashIcon").innerHTML = icon;
	}

	function lateIcon() {
		return `<svg data-src="<?php echo $SITEURL ?>plugins/Dashboard/assets/img/lateIcon.svg" style="vertical-align:middle; width:36px; height:36px;"></svg>`;
	}

	function toolateIcon() {
		return `<svg data-src="<?php echo $SITEURL ?>plugins/Dashboard/assets/img/tooearlyIcon.svg" style="vertical-align:middle; width:36px; height:36px;"></svg>`;
	}

	function morningIcon() {
		return `<svg data-src="<?php echo $SITEURL ?>plugins/Dashboard/assets/img/morningIcon.svg" style="vertical-align:middle; width:36px; height:36px;"></svg>`;
	}

	function afternoonIcon() {
		return `<svg data-src="<?php echo $SITEURL ?>plugins/Dashboard/assets/img/afternoonIcon.svg" style="vertical-align:middle; width:36px; height:36px;"></svg>`;
	}

	function eveningIcon() {
		return `<svg data-src="<?php echo $SITEURL ?>plugins/Dashboard/assets/img/eveningIcon.svg" style="vertical-align:middle; width:36px; height:36px;"></svg>`;
	}

	function nightIcon() {
		return `<svg data-src="<?php echo $SITEURL ?>plugins/Dashboard/assets/img/nightIcon.svg" style="vertical-align:middle; width:36px; height:36px;"></svg>`;
	}

	updateGreeting();
	</script>
	
	<?php
}

// -------------------------------------------------------
// Settings page (two tabs: Layout + Module Repo)
// -------------------------------------------------------
function dash_settings() {
	global $SITEURL;

	$modules = dash_get_modules();
	$layout  = dash_get_layout();
	$enabled = isset($layout['enabled']) ? $layout['enabled'] : array();
	$grid	= isset($layout['grid'])	? $layout['grid']	: array();

	$positions = array();
	foreach ($grid as $item) {
		if (isset($item['id'])) $positions[$item['id']] = $item;
	}
	?>
	<link rel="stylesheet" href="<?php echo $SITEURL ?>plugins/Dashboard/assets/css/gridstack.min.css"/>
	<style>
		#sidebar { display: none; }
		.bodycontent { display: inline; }
		h3 { font-style: normal; font-weight: 600 !important; }

		/* Tab bar */
		.dash-tabs {
			display: flex;
			gap: 4px;
			border-bottom: 2px solid #e0e0e0;
			margin-bottom: 20px;
		}
		.dash-tab {
			padding: 8px 18px;
			font-size: 13px;
			font-weight: 600;
			color: #888;
			cursor: pointer;
			border: 1px solid transparent;
			border-bottom: none;
			border-radius: 4px 4px 0 0;
			background: none;
			margin-bottom: -2px;
		}
		.dash-tab:hover { color: #4a90d9; }
		.dash-tab.active {
			color: #333;
			background: #fff;
			border-color: #e0e0e0;
			border-bottom-color: #fff;
		}
		.dash-tab-panel { display: none; }
		.dash-tab-panel.active { display: block; }

		/* Layout tab */
		.dash-module-list { margin-bottom: 20px; }
		.dash-module-item {
			display: inline-flex;
			align-items: center;
			gap: 8px;
			background: #f5f5f5;
			border: 1px solid #ddd;
			border-radius: 4px;
			padding: 6px 12px;
			margin: 4px;
			cursor: pointer;
			font-size: 13px;
		}
		.dash-module-item.active {
			background: #d4edda;
			border-color: #28a745;
		}
		.grid-stack-item-content {
			background: #fff;
			border: 1px solid #86E29B;
			border-radius: 4px;
			padding: 10px;
			font-size: 12px;
			color: #555;
			display: flex;
			align-items: center;
			justify-content: center;
			font-weight: 600;
		}
		#dash-save-btn {
			margin-top: 16px;
			padding: 8px 20px;
			background: #4a90d9;
			color: #fff;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			font-size: 13px;
		}
		#dash-save-btn:hover { background: #357abd; }
		#dash-save-status { margin-left: 12px; font-size: 14px; color: #28a745; font-weight:600; }
		.gs-settings-hint { font-size: 12px; color: #888; margin-bottom: 10px; }
		#dash-settings-grid {border: #7EACDA solid 1px; border-radius: 5px;}
	</style>

	<div class="bodycontent">
		<div class="maincontent">
			<header style="padding:10px 0 14px; border-bottom:1px solid #eee; margin-bottom:16px;">
				<h3><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:bottom;" width="1.2em" height="1.2em" viewBox="0 0 24 24"><rect width="24" height="24" fill="none"/><path fill="currentColor" d="M6.25 3A3.25 3.25 0 0 0 3 6.25v11.5A3.25 3.25 0 0 0 6.25 21h5.772a6.5 6.5 0 0 1-.709-1.5H6.25a1.75 1.75 0 0 1-1.75-1.75V15.5h6.813a6.5 6.5 0 0 1 .709-1.5H10v-4h9.5v1.313a6.5 6.5 0 0 1 1.5.709V6.25A3.25 3.25 0 0 0 17.75 3zM4.5 6.25c0-.966.784-1.75 1.75-1.75H14v4H4.5zm0 3.75h4v4h-4zm15-1.5h-4v-4h2.25c.966 0 1.75.784 1.75 1.75zm-5.223 5.476a2 2 0 0 1-1.441 2.496l-.584.145a5.7 5.7 0 0 0 .006 1.807l.54.13a2 2 0 0 1 1.45 2.51l-.187.631c.44.386.94.7 1.485.922l.493-.519a2 2 0 0 1 2.899 0l.499.526a5.3 5.3 0 0 0 1.482-.913l-.198-.686a2 2 0 0 1 1.442-2.496l.583-.145a5.7 5.7 0 0 0-.006-1.807l-.54-.13a2 2 0 0 1-1.449-2.51l.186-.631a5.3 5.3 0 0 0-1.484-.922l-.493.518a2 2 0 0 1-2.9 0l-.498-.525c-.544.22-1.044.53-1.483.913zM17.5 19c-.8 0-1.45-.671-1.45-1.5c0-.828.65-1.5 1.45-1.5s1.45.672 1.45 1.5c0 .829-.65 1.5-1.45 1.5"/></svg> <?php echo i18n_r("Dashboard/lang_Dashboard_Settings");?></h3>
				<p><?php echo i18n_r("Dashboard/lang_Description");?></p>
			</header>

			<!-- Tab bar -->
			<div class="dash-tabs">
				<button class="dash-tab active" data-tab="layout"><svg data-src="<?php echo $SITEURL ?>plugins/Dashboard/assets/img/layout.svg" style="vertical-align:middle; width:24px; height:24px;"></svg> <?php echo i18n_r("Dashboard/lang_Layout");?></button>
				<button class="dash-tab" data-tab="modules"><svg data-src="<?php echo $SITEURL ?>plugins/Dashboard/assets/img/download.svg" style="vertical-align:middle; width:24px; height:24px;"></svg> <?php echo i18n_r("Dashboard/lang_Model_Repo");?></button>
			</div>

			<!-- Tab 1: Layout -->
			<div class="dash-tab-panel active" id="dash-panel-layout">
				<?php if (empty($modules)): ?>
					<p style="color:#888;"><?php echo i18n_r("Dashboard/lang_No_modules_found");?> <code>plugins/Dashboard/modules/</code>.</p>
				<?php else: ?>
					<p><strong><?php echo i18n_r("Dashboard/lang_Available_Modules");?></strong> — <?php echo i18n_r("Dashboard/lang_Click_to_enable");?>:</p>
					<div class="dash-module-list">
					<?php foreach ($modules as $id => $mod): ?>
						<span class="dash-module-item <?php echo in_array($id, $enabled) ? 'active' : ''; ?>"
							  data-id="<?php echo htmlspecialchars($id); ?>"
							  title="<?php echo htmlspecialchars($mod['Description']); ?>">
							<?php echo htmlspecialchars($mod['Module Name']); ?> <sup>v<?php echo htmlspecialchars($mod['Version']); ?></sup>
						</span>
					<?php endforeach; ?>
					</div>

					<p class="gs-settings-hint"><?php echo i18n_r("Dashboard/lang_Drag_and_resize");?>.</p>

					<div class="grid-stack" id="dash-settings-grid">
					<?php foreach ($enabled as $id):
						if (!isset($modules[$id])) continue;
						$mod = $modules[$id];
						$pos = isset($positions[$id]) ? $positions[$id] : array();
						$x = isset($pos['x']) ? (int)$pos['x'] : 0;
						$y = isset($pos['y']) ? (int)$pos['y'] : 0;
						$w = isset($pos['w']) ? (int)$pos['w'] : (int)$mod['Default W'];
						$h = isset($pos['h']) ? (int)$pos['h'] : (int)$mod['Default H'];
					?>
						<div class="grid-stack-item" gs-id="<?php echo htmlspecialchars($id); ?>"
							 gs-x="<?php echo $x; ?>" gs-y="<?php echo $y; ?>"
							 gs-w="<?php echo $w; ?>" gs-h="<?php echo $h; ?>">
							<div class="grid-stack-item-content">
								<?php echo htmlspecialchars($mod['Module Name']); ?>
							</div>
						</div>
					<?php endforeach; ?>
					</div>

					<button id="dash-save-btn"><?php echo i18n_r("Dashboard/lang_Save");?></button>
					<span id="dash-save-status"></span>
				<?php endif; ?>
			</div>

			<!-- Tab 2: Module Repo -->
			<div class="dash-tab-panel" id="dash-panel-modules">
				<div id="mstore-container">
					<p style="color:#aaa; font-size:13px;"><?php echo i18n_r("Dashboard/lang_Click_to_load");?>...</p>
				</div>
			</div>

		</div>
	</div>
	
	<script src="<?php echo $SITEURL ?>plugins/Dashboard/assets/js/svg-loader.min.js" async></script>
	<script src="<?php echo $SITEURL ?>plugins/Dashboard/assets/js/gridstack-all.js"></script>
	<script>
	var grid = GridStack.init({ cellHeight: 80, margin: 6 }, '#dash-settings-grid');

	// All module metadata
	var allModules = <?php echo json_encode($modules); ?>;
	var enabledIds = <?php echo json_encode($enabled); ?>;

	// Toggle enable/disable when clicking a module badge
	function handleModuleBadgeClick() {
		var id = this.dataset.id;
		var idx = enabledIds.indexOf(id);
		if (idx === -1) {
		// Enable: add to grid
			enabledIds.push(id);
			this.classList.add('active');
			var mod = allModules[id];
			grid.addWidget({
				id: id,
				w: parseInt(mod['Default W']) || 4,
				h: parseInt(mod['Default H']) || 2,
				content: mod['Module Name']
			});
		} else {
		// Disable: remove from grid
			enabledIds.splice(idx, 1);
			this.classList.remove('active');
			var items = grid.engine.nodes;
			for (var i = 0; i < items.length; i++) {
				if (items[i].id === id) {
					grid.removeWidget(items[i].el);
					break;
				}
			}
		}
	}

	document.querySelectorAll('.dash-module-item').forEach(function(el) {
		el.addEventListener('click', handleModuleBadgeClick);
	});

// -------------------------------------------------------
// Save layout via AJAX POST
// -------------------------------------------------------
	document.getElementById('dash-save-btn') && document.getElementById('dash-save-btn').addEventListener('click', function() {
		var nodes = grid.engine.nodes;
		var gridData = nodes.map(function(n) {
			return { id: n.id, x: n.x, y: n.y, w: n.w, h: n.h };
		});
		var payload = JSON.stringify({ enabled: enabledIds, grid: gridData });
		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'load.php?id=Dashboard&dashboard-settings');
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.onload = function() {
			var status = document.getElementById('dash-save-status');
			try {
				var res = JSON.parse(xhr.responseText);
				status.textContent = res.status === 'ok' ? '✓ <?php echo i18n_r("Dashboard/lang_Saved");?>' : '✗ <?php echo i18n_r("Dashboard/lang_Error_saving");?>';
			} catch(e) {
				status.textContent = '✗ <?php echo i18n_r("Dashboard/lang_Unexpected_response");?>';
			}
			setTimeout(function(){ status.textContent = ''; }, 3000);
		};
		xhr.send('dash_save_layout=1&layout=' + encodeURIComponent(payload));
	});

	// Tab switching with lazy-load for Module Store
	var mstoreLoaded = false;
	var initialTab = (window.location.search.indexOf('tab=modules') !== -1) ? 'modules' : 'layout';

	function activateTab(tabName) {
		document.querySelectorAll('.dash-tab').forEach(function(t) { t.classList.remove('active'); });
		document.querySelectorAll('.dash-tab-panel').forEach(function(p) { p.classList.remove('active'); });
		var tabEl = document.querySelector('.dash-tab[data-tab="' + tabName + '"]');
		var panelEl = document.getElementById('dash-panel-' + tabName);
		if (tabEl) tabEl.classList.add('active');
		if (panelEl) panelEl.classList.add('active');
	}

	document.querySelectorAll('.dash-tab').forEach(function(tab) {
		tab.addEventListener('click', function() {
			activateTab(this.dataset.tab);
			loadMstoreIfNeeded(this.dataset.tab);
			if (this.dataset.tab === 'layout') refreshLayoutModules();
		});
	});

	function refreshLayoutModules() {
		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'load.php?id=Dashboard&dashboard-settings');
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.onload = function() {
			try {
				var res = JSON.parse(xhr.responseText);
				if (res.status === 'ok') {
					allModules = res.modules;
					// Re-render the module badge list so newly installed modules appear
					var list = document.querySelector('.dash-module-list');
					if (!list) return;
					list.innerHTML = '';
					Object.keys(allModules).forEach(function(id) {
						var mod = allModules[id];
						var span = document.createElement('span');
						span.className = 'dash-module-item' + (enabledIds.indexOf(id) !== -1 ? ' active' : '');
						span.dataset.id = id;
						span.title = mod['Description'] || '';
						span.innerHTML = mod['Module Name'] + ' <sup>v' + mod['Version'] + '</sup>';
						span.addEventListener('click', handleModuleBadgeClick);
						list.appendChild(span);
					});
				}
			} catch(e) {}
		};
		xhr.send('dash_load_modules=1');
	}

	function loadMstoreIfNeeded(tabName) {
		if (tabName !== 'modules' || mstoreLoaded) return;
		mstoreLoaded = true;
		var container = document.getElementById('mstore-container');
		container.innerHTML = '<p style="color:#aaa; font-size:13px;"><?php echo i18n_r("Dashboard/lang_Loading_modules");?>...</p>';
		var xhr = new XMLHttpRequest();
		xhr.open('POST', 'load.php?id=Dashboard&dashboard-settings');
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.onload = function() {
			try {
				var res = JSON.parse(xhr.responseText);
				if (res.status === 'ok') {
					container.innerHTML = res.html;
					bindInstallButtons();
					bindMstoreSearch();
				} else {
					container.innerHTML = '<p style="color:#e74c3c;"><?php echo i18n_r("Dashboard/lang_Failed_to_load");?>.</p>';
				}
			} catch(e) {
				container.innerHTML = '<p style="color:#e74c3c;"><?php echo i18n_r("Dashboard/lang_Unexpected_error_loading");?>.</p>';
			}
		};
		xhr.onerror = function() {
			container.innerHTML = '<p style="color:#e74c3c;"><?php echo i18n_r("Dashboard/lang_Network_error");?>.</p>';
		};
		xhr.send('dash_load_mstore=1');
	}

	// Auto-open correct tab on load
	activateTab(initialTab);
	loadMstoreIfNeeded(initialTab);

	function bindInstallButtons() {
		document.querySelectorAll('.mstore-btn-install:not([data-bound])').forEach(function(btn) {
			btn.setAttribute('data-bound', '1');
			btn.addEventListener('click', function() {
				var id	   = this.dataset.id;
				var url	  = this.dataset.url;
				var msg	  = document.getElementById('mstore-msg-' + id);
				var self	 = this;
				var isUpdate = self.classList.contains('mstore-btn-update');

				self.disabled = true;
				self.textContent = isUpdate ? '<?php echo i18n_r("Dashboard/lang_Updating");?>...' : '<?php echo i18n_r("Dashboard/lang_Installing");?>...';
				if (msg) msg.textContent = '';

				var xhr = new XMLHttpRequest();
				xhr.open('POST', 'load.php?id=Dashboard&dashboard-settings');
				xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				xhr.onload = function() {
					try {
						var res = JSON.parse(xhr.responseText);
						if (res.status === 'ok') {
							self.className = 'mstore-btn mstore-btn-installed';
							self.textContent = isUpdate ? '✓ <?php echo i18n_r("Dashboard/lang_Updated");?>' : '✓ <?php echo i18n_r("Dashboard/lang_Installed");?>';
							self.disabled = true;
							if (msg) {
								msg.className = 'mstore-msg ok';
								var secs = 3;
								msg.textContent = '<?php echo i18n_r("Dashboard/lang_Reloading");?> ' + secs + 's...';
								var timer = setInterval(function() {
									secs--;
									if (secs <= 0) {
										clearInterval(timer);
										window.location.href = 'load.php?id=Dashboard&dashboard-settings&tab=modules';
									} else {
										msg.textContent = '<?php echo i18n_r("Dashboard/lang_Reloading");?> ' + secs + 's...';
									}
								}, 1000);
							}
						} else {
							self.disabled = false;
							self.textContent = isUpdate ? '↑ <?php echo i18n_r("Dashboard/lang_Updated");?>' : '<?php echo i18n_r("Dashboard/lang_Install");?>';
							if (msg) { msg.className = 'mstore-msg error'; msg.textContent = res.message; }
						}
					} catch(e) {
						self.disabled = false;
						self.textContent = isUpdate ? '↑ <?php echo i18n_r("Dashboard/lang_Update");?>' : '<?php echo i18n_r("Dashboard/lang_Install");?>';
						if (msg) { msg.className = 'mstore-msg error'; msg.textContent = '<?php echo i18n_r("Dashboard/lang_Unexpected_error");?>.'; }
					}
				};
				xhr.onerror = function() {
					self.disabled = false;
					self.textContent = isUpdate ? '↑ <?php echo i18n_r("Dashboard/lang_Update");?>' : '<?php echo i18n_r("Dashboard/lang_Install");?>';
					if (msg) { msg.className = 'mstore-msg error'; msg.textContent = '<?php echo i18n_r("Dashboard/lang_Network_error");?>.'; }
				};
				xhr.send('dash_install_module=1&id=' + encodeURIComponent(id) + '&url=' + encodeURIComponent(url));
			});
		});
	}

	function bindMstoreSearch() {
		var searchEl = document.getElementById('mstore-search');
		if (searchEl) {
			searchEl.addEventListener('input', function() {
				var q = this.value.toLowerCase();
				document.querySelectorAll('.mstore-card').forEach(function(card) {
					var match = card.dataset.name.includes(q) ||
								card.dataset.info.includes(q) ||
								card.dataset.author.includes(q);
					card.style.display = match ? '' : 'none';
				});
			});
		}
	}
	</script>
	<?php
}
?>