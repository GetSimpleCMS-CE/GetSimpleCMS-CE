<?php 
/**
 * Edit Theme
 *
 * Allows you to edit a theme file
 *
 * @package GetSimple
 * @subpackage Theme
 */

// Setup inclusions
$load['plugin'] = true;
include('inc/common.php');

// Variable settings
login_cookie_check();
$theme_options 		= '';
$template_file 		= '';
$template 			= $TEMPLATE;
$theme_templates 	= '';

// Were changes submitted?
if (isset($_GET['t'])) {
	$_GET['t'] = strippath($_GET['t']);
	if ($_GET['t'] && is_dir(GSTHEMESPATH . $_GET['t'] . '/')) {
		$template = $_GET['t'];
	}
}
if (isset($_GET['f'])) {
	// Sanitize the file path while preserving subdirectories
	$_GET['f'] = ltrim($_GET['f'], '/'); // Remove leading slashes
	$_GET['f'] = str_replace('..', '', $_GET['f']); // Prevent directory traversal
	$_GET['f'] = filter_var($_GET['f'], FILTER_SANITIZE_URL); // Sanitize URL

	// Debugging: Log the requested file
	# error_log("Requested file: " . $_GET['f']);

	// Check if the file exists
	$fullPath = realpath(GSTHEMESPATH . $template . '/' . $_GET['f']);
	if ($fullPath && is_file($fullPath)) {
		$template_file = $_GET['f'];
		# error_log("File found: " . $fullPath); // Debugging
	} else {
		# error_log("File not found: " . GSTHEMESPATH . $template . '/' . $_GET['f']); // Debugging
	}
}

// If no template is selected, use the default
if ($template_file == '') {
	$template_file = 'template.php';
}

$themepath = GSTHEMESPATH . $template . DIRECTORY_SEPARATOR;
if (!filepath_is_safe($themepath . $template_file, GSTHEMESPATH, true)) die();

// Check for form submission
if (isset($_POST['submitsave'])) {
	# error_log("Edited file: " . $_POST['edited_file']); // Debugging
	// Check for CSRF
	if (!defined('GSNOCSRF') || (GSNOCSRF == FALSE)) {
		$nonce = $_POST['nonce'];
		if (!check_nonce($nonce, "save")) {
			die("CSRF detected!");
		}
	}

	// Save edited template file
	$SavedFile = str_replace(['..', '\\'], '', $_POST['edited_file']); // Sanitize the file path
	$FileContents = $_POST['content'];

	// Resolve and validate file path
	$allowedDirectory = realpath(GSTHEMESPATH . $template . '/');
	$fullPath = realpath($allowedDirectory . DIRECTORY_SEPARATOR . $SavedFile);

	if (!$fullPath || strpos($fullPath, $allowedDirectory) !== 0) {
		die("Invalid file path!");
	}

	// Block specific files
	$blocked_files = ['.htaccess'];
	if (in_array($SavedFile, $blocked_files)) {
		die("Editing this file is not allowed!");
	}

	// Validate file type
	$allowed_extensions = ['php', 'css', 'js', 'html', 'htm', 'json'];
	$fileExtension = pathinfo($SavedFile, PATHINFO_EXTENSION);
	if (!in_array($fileExtension, $allowed_extensions)) {
		die("Invalid file type!");
	}

	// Resolve and validate file path
	$allowedDirectory = realpath(GSTHEMESPATH . $template . '/');
	$fullPath = $allowedDirectory . DIRECTORY_SEPARATOR . $SavedFile;

	// Debugging: Log the paths for verification
	# error_log("Allowed Directory: " . $allowedDirectory);
	# error_log("Full Path: " . $fullPath);

	if (!file_exists($fullPath)) {
		die("File not found: " . $fullPath);
	}

	// Check for symlinks
	if (is_link($fullPath)) {
		die("Symlinks are not allowed!");
	}

	// Sanitize file content for non-PHP files
	if ($fileExtension !== 'php') {
		$FileContents = preg_replace('/<\?php.*?\?>/is', '', $FileContents);
	}

	// Open and write to file
	$fh = fopen($fullPath, 'w');
	if (!$fh) {
		# error_log("Failed to open file: " . $fullPath); // Log the error
		die("An error occurred while saving the file."); // Generic error message
	}
	fwrite($fh, $FileContents);
	fclose($fh);

	// Set secure file permissions
	chmod($fullPath, 0644);

	$success = sprintf(i18n_r('TEMPLATE_FILE'), $SavedFile);
}

// Create themes dropdown
$themes_path = GSTHEMESPATH;
$themes_handle = opendir($themes_path);
$theme_options .= '<select class="text" style="width:225px;" name="t" id="theme-folder" >';	
while ($file = readdir($themes_handle)) {
	$curpath = $themes_path . '/' . $file;
	if( is_dir($curpath) && $file != "." && $file != "..") {
		$theme_dir_array[] = $file;
		$sel = "";
		
		if (file_exists($curpath . '/template.php')) {
			if ($template == $file) {
				$sel = "selected";
			}
			
			$theme_options .= '<option ' . $sel . ' value="' . $file . '" >' . $file . '</option>';
		}
	}
}
$theme_options .= '</select> ';

// Check to see how many themes are available
if (count($theme_dir_array) == 1){ $theme_options = ''; }

$templates = directoryToArray(GSTHEMESPATH . $template . '/', true);
sort($templates); // Sort templates alphabetically
$theme_templates .= '<span id="themefiles"><select class="text" id="theme_files" style="width:425px;" name="f" >';
$allowed_extensions = ['php', 'css', 'js', 'html', 'htm', 'json'];
foreach ($templates as $file) {
	$extension = pathinfo($file, PATHINFO_EXTENSION);
	if (in_array($extension, $allowed_extensions)) {
		$filename = pathinfo($file, PATHINFO_BASENAME);
		$filenamefull = substr(strstr($file, '/theme/' . $template . '/'), strlen('/theme/' . $template . '/'));
		if ($template_file == $filenamefull) {
			$sel = "selected";
		} else {
			$sel = "";
		}
		if ($filename == 'template.php') {
			$templatename = i18n_r('DEFAULT_TEMPLATE');
		} else {
			$templatename = $filenamefull;
		}
		$theme_templates .= '<option ' . $sel . ' value="' . $filenamefull . '">' . $templatename . '</option>';
	}
}
$theme_templates .= "</select></span>";

if (!getDef('GSNOHIGHLIGHT',true)){
	register_script('codemirror', $SITEURL . $GSADMIN . '/template/js/codemirror/codemirror.min.js', '6.65.7', FALSE);
	register_script('codemirror-style', $SITEURL . $GSADMIN . '/template/js/codemirror/clike.min.js', '6.65.7', FALSE);
	
	register_style('codemirror-css', $SITEURL . $GSADMIN . '/template/js/codemirror/codemirror.min.css', 'screen', FALSE);
	register_style('codemirror-theme', $SITEURL . $GSADMIN . '/template/js/codemirror/blackboard.min.css', 'screen', FALSE);
	
	queue_script('codemirror', GSBACK);
	queue_script('codemirror-style', GSBACK);
	
	queue_style('codemirror-css', GSBACK);
	queue_style('codemirror-theme', GSBACK);
}

get_template('header', cl($SITENAME) . ' &raquo; ' . i18n_r('THEME_MANAGEMENT'));
?>

<?php
include('template/include-nav.php');

if (!getDef('GSNOHIGHLIGHT', true)) {

	switch (pathinfo($template_file, PATHINFO_EXTENSION)) {
		case 'css':
			$mode = 'text/css';
			break;
		case 'js':
			$mode = 'text/javascript';
			break;
		case 'html':
			$mode = 'text/html';
			break;
		default:
			$mode = 'application/x-httpd-php';
	}
?>

<script>
	// Save with ctrl+s
	document.addEventListener('keydown', function(e) {
		if ((e.ctrlKey || e.metaKey) && e.key === 's') {
			e.preventDefault();
			var saveButton = document.querySelector('input[name="submitsave"][value="<?php i18n('BTN_SAVECHANGES'); ?>"]');
			if (saveButton) {
				saveButton.click();
			}
		}
	});
</script>
<?php 
}
?>
<div class="bodycontent clearfix">
	
	<div id="maincontent">
		<div class="main">
			<h3><?php i18n('EDIT_THEME'); ?></h3>
			<form action="<?php myself(); ?>" method="get" accept-charset="utf-8">
				<p><?php echo $theme_options; ?><?php echo $theme_templates; ?>&nbsp;&nbsp;&nbsp;<input class="submit" type="submit" name="s" value="<?php i18n('EDIT'); ?>" /></p>
			</form>
			
			<p><b><?php i18n('EDITING_FILE'); ?>:</b> <code><?php echo $SITEURL . 'theme/' . tsl($template) . '<b>' . $template_file; ?></b></code></p>
			<?php $content = file_get_contents(GSTHEMESPATH . tsl($template) . $template_file); ?>

			<form action="<?php myself(); ?>?t=<?php echo $template; ?>&amp;f=<?php echo $template_file; ?>" method="post">
				<style>.CodeMirror{height:650px;margin:0 30px;font-size: 15px; }</style>
				<input id="nonce" name="nonce" type="hidden" value="<?php echo get_nonce("save"); ?>" />
				<textarea name="content" id="myTextarea" wrap='off' ><?php
					if (in_array(pathinfo($template_file, PATHINFO_EXTENSION), ['php', 'html', 'htm'])) {
						echo htmlentities($content, ENT_QUOTES, 'UTF-8');
					} else {
						echo $content;
					}
				?></textarea>
				<input type="hidden" value="<?php echo $template_file; ?>" name="edited_file" />
				
				<div style="margin:20px 0">
					<?php exec_action('theme-edit-extras'); ?>
				</div>
				
				<p id="submit_line">
					<span><input class="submit" type="submit" name="submitsave" value="<?php i18n('BTN_SAVECHANGES'); ?>" /></span> &nbsp;&nbsp;<?php i18n('OR'); ?>&nbsp;&nbsp; <a class="cancel" href="theme-edit.php?cancel"><?php i18n('CANCEL'); ?></a>
				</p>
			</form>

			<script>
				var editor = CodeMirror.fromTextArea(document.querySelector('#myTextarea'), {
					theme: "<?php echo $CMTHEME ?>",
					lineNumbers: true,
					matchBrackets: true,
					indentUnit: 4,
					indentWithTabs: true,
					lineWrapping: true,
					enterMode: "keep",
					tabMode: "shift",
					mode: 'clike',
					inlineDynamicImports: true
				});
			</script>
		</div>
	</div>
	
	<div id="sidebar">
		<?php include('template/sidebar-theme.php'); ?>
	</div>
</div>
<?php get_template('footer'); ?>