<?php 
/**
 * Settings
 *
 * Displays and changes website settings 
 *
 * @package GetSimple
 * @subpackage Settings
 */

# setup inclusions
$load['plugin'] = true;
include('inc/common.php');

# variable settings
login_cookie_check();
$fullpath = suggest_site_path();
$file			= _id($USR) .'.xml';
$wfile 		= 'website.xml';
$data 		= getXML(GSUSERSPATH . $file);
$USR 			= stripslashes($data->USR);
$PASSWD 	= $data->PWD;
$EMAIL 		= $data->EMAIL;
$NAME			= $data->NAME;

$lang_array = getFiles(GSLANGPATH);

# initialize these all as null
$pwd1 = $error = $success = $pwd2 = $editorchck = $prettychck = null;

# if the flush cache command was invoked
if (isset($_GET['flushcache'])) { 
	delete_cache();
	
	// Delete additional files in cache directory
	$additionalFiles = array(
		'plugin_db.json',
		'plugin-update.trigger'
	);
	
	foreach ($additionalFiles as $file) {
		$path = GSCACHEPATH . $file;
		if (file_exists($path)) {
			unlink($path);
		}
	}

	// Delete update_info_*.html files (hash suffix varies)
	foreach (glob(GSCACHEPATH . 'update_info_*.html') as $ufile) {
		unlink($ufile);
	}
	
	$update = 'flushcache-success';
}

# if the undo command was invoked
if (isset($_GET['undo'])) { 
	
	# first check for csrf
	if (!defined('GSNOCSRF') || (GSNOCSRF == FALSE) ) {
		$nonce = $_GET['nonce'];
		if(!check_nonce($nonce, "undo")) {
			die("CSRF detected!");
		}
	}
	# perform undo
	undo($file, GSUSERSPATH, GSBACKUSERSPATH);
	undo($wfile, GSDATAOTHERPATH, GSBACKUPSPATH.'other/');
	generate_sitemap();
	
	# redirect back to yourself to show the new restored data
	redirect('settings.php?restored=true');
}

# was this page restored?
if (isset($_GET['restored'])) { 
	$restored = 'true'; 
} else {
	$restored = 'false';
}

# was the form submitted?
if(isset($_POST['submitted'])) {
	
	# first check for csrf
	if (!defined('GSNOCSRF') || (GSNOCSRF == FALSE) ) {
		$nonce = $_POST['nonce'];
		if(!check_nonce($nonce, "save_settings")) {
			die("CSRF detected!");	
		}
	}
	
	# website-specific fields
	if(isset($_POST['sitename'])) { 
		$SITENAME = htmlentities($_POST['sitename'], ENT_QUOTES, 'UTF-8'); 
	}
	if(isset($_POST['siteurl'])) { 
		$SITEURL = tsl($_POST['siteurl']); 
	}
	if(isset($_POST['permalink'])) { 
		$PERMALINK = trim($_POST['permalink']); 
	}
	if(isset($_POST['template'])) { 
		$TEMPLATE = $_POST['template']; 
	}
	if(isset($_POST['prettyurls'])) {
	  $PRETTYURLS = $_POST['prettyurls'];
	} else {
		$PRETTYURLS = '';
	}
   
	# user-specific fields
	$USR = strtolower($USR);
	
 	if(isset($_POST['name'])) { 
		$NAME = $_POST['name']; 
	} 
	if(isset($_POST['email'])) { 
		$EMAIL = $_POST['email']; 
	} 
	if(isset($_POST['timezone'])) { 
		$TIMEZONE = var_out($_POST['timezone']); 
	}
	if(isset($_POST['lang'])) { 
		$LANG = var_out($_POST['lang']); 
	}
	if(isset($_POST['show_htmleditor'])) {
	  $HTMLEDITOR = var_out($_POST['show_htmleditor']); 
	} else {
		$HTMLEDITOR = '';
	}
	
	# check to see if passwords are changing
	if(isset($_POST['sitepwd'])) { $pwd1 = $_POST['sitepwd']; }
	if(isset($_POST['sitepwd_confirm'])) { $pwd2 = $_POST['sitepwd_confirm']; }
	if ($pwd1 != $pwd2 && $pwd2 != '')	{
		#passwords do not match 
		$error = i18n_r('PASSWORD_NO_MATCH');
	} else {
		# password cannot be null
		if ( $pwd1 != '' && $pwd2 != '') { 
			$PASSWD = passhash($pwd1); 
		}	
		
		// check valid lang files
		if(!in_array($LANG.'.php', $lang_array) and !in_array($LANG.'.PHP', $lang_array)) die(); 

		# create user xml file
		createBak($file, GSUSERSPATH, GSBACKUSERSPATH);
		if (file_exists(GSUSERSPATH . _id($USR).'.xml.reset')) { unlink(GSUSERSPATH . _id($USR).'.xml.reset'); }	
		$xml = new SimpleXMLExtended('<?xml version="1.0" encoding="UTF-8"?><item></item>');		
		$xml->addChild('USR', $USR);
		$xml->addChild('NAME', var_out($NAME));
		$xml->addChild('PWD', $PASSWD);
		$xml->addChild('EMAIL', var_out($EMAIL,'email'));
		$xml->addChild('HTMLEDITOR', $HTMLEDITOR);
		$xml->addChild('TIMEZONE', $TIMEZONE);
		$xml->addChild('LANG', $LANG);
		
		exec_action('settings-user');
		
		if (! XMLsave($xml, GSUSERSPATH . $file) ) {
			$error = i18n_r('CHMOD_ERROR');
		}
		
		# create website xml file
		createBak($wfile, GSDATAOTHERPATH, GSBACKUPSPATH.'other/');
		$xmls = new SimpleXMLExtended('<?xml version="1.0" encoding="UTF-8"?><item></item>');
		$note = $xmls->addChild('SITENAME');
		$note->addCData($SITENAME);
		$note = $xmls->addChild('SITEURL');
		$note->addCData($SITEURL);
		$note = $xmls->addChild('TEMPLATE');
		$note->addCData($TEMPLATE);
		$xmls->addChild('PRETTYURLS', $PRETTYURLS);
		$xmls->addChild('PERMALINK', var_out($PERMALINK));
		
		exec_action('settings-website');
		
		if (! XMLsave($xmls, GSDATAOTHERPATH . $wfile) ) {
			$error = i18n_r('CHMOD_ERROR');
		}

		# save SMTP config if present
		if (function_exists('gs_save_smtp_config')) {
			$smtp_cfg_save = [
				'enabled'    => isset($_POST['smtp_enabled']) ? '1' : '0',
				'host'       => trim($_POST['smtp_host']       ?? ''),
				'port'       => (int)($_POST['smtp_port']       ?? 587),
				'enc'        => $_POST['smtp_enc']              ?? 'tls',
				'user'       => trim($_POST['smtp_user']        ?? ''),
				'from_email' => trim($_POST['smtp_from_email']  ?? ''),
				'from_name'  => trim($_POST['smtp_from_name']   ?? ''),
				'verify_peer'=> isset($_POST['smtp_verify_peer']) ? '1' : '0',
			];
			// Only re-encrypt if a new password was submitted; empty = keep existing
			$smtp_new_pass = $_POST['smtp_pass'] ?? '';
			if (!gs_save_smtp_config($smtp_cfg_save, $smtp_new_pass)) {
				$error = i18n_r('CHMOD_ERROR');
			}
		}

		# see new language file immediately
		include(GSLANGPATH.$LANG.'.php');
		
		if (!$error) {
			$success = i18n_r('ER_SETTINGS_UPD').'. <a href="settings.php?undo&nonce='.get_nonce("undo").'">'.i18n_r('UNDO').'</a>';
			generate_sitemap();
		}
		
	}
}

# are any of the control panel checkboxes checked?
if ($HTMLEDITOR != '' ) { $editorchck = 'checked'; }
if ($PRETTYURLS != '' ) { $prettychck = 'checked'; }

# get all available language files
if ($LANG == ''){ $LANG = 'en_US'; }

if (count($lang_array) != 0) {
	sort($lang_array);
	$sel = ''; $langs = '';
	foreach ($lang_array as $lfile){
		$lfile = basename($lfile,".php");
		if ($LANG == $lfile)	{ $sel="selected"; }
		$langs .= '<option '.$sel.' value="'.$lfile.'" >'.$lfile.'</option>';
		$sel = '';
	}
} else {
	$langs = '<option value="" selected="selected" >-- '.i18n_r('NONE').' --</option>';
}

get_template('header', cl($SITENAME).' &raquo; '.i18n_r('GENERAL_SETTINGS')); 

?>
	
<?php include('template/include-nav.php'); ?>

<div class="bodycontent clearfix">
	
	<div id="maincontent">
		<form class="largeform" action="<?php myself(); ?>" method="post" accept-charset="utf-8" >
		<input id="nonce" name="nonce" type="hidden" value="<?php echo get_nonce("save_settings"); ?>" />
		
		<div class="main">
		<h3><?php i18n('WEBSITE_SETTINGS');?></h3>
		
		<div class="leftsec">
			<p><label for="sitenameinput" ><?php i18n('LABEL_WEBSITE');?>:</label><input class="text" id="sitenameinput" name="sitename" type="text" value="<?php if(isset($SITENAME1)) { echo stripslashes($SITENAME1); } else { echo stripslashes($SITENAME); } ?>" /></p>
		</div>
		<div class="rightsec">
			<p><label for="siteurl" ><?php i18n('LABEL_BASEURL');?>:</label><input class="text" id="siteurl" name="siteurl" type="url" value="<?php if(isset($SITEURL1)) { echo $SITEURL1; } else { echo $SITEURL; } ?>" /></p>
			<?php	if ( $fullpath != $SITEURL ) {	echo '<p style="margin:-15px 0 20px 0;color:#D94136;font-size:11px;" >'.i18n_r('LABEL_SUGGESTION').': &nbsp; <code>'.$fullpath.'</code></p>';	}	?>
		</div>
		<div class="clear"></div>
		
		<p class="inline" ><input name="prettyurls" id="prettyurls" type="checkbox" value="1" <?php echo $prettychck; ?>  /> &nbsp;<label for="prettyurls" ><?php i18n('USE_FANCY_URLS');?></label></p>
				
		<div class="leftsec">
			<p><label for="permalink"  class="clearfix"><?php i18n('PERMALINK');?>: <span class="right"><a href="https://github.com/GetSimpleCMS-CE/GetSimpleCMS-CE/wiki/Settings" target="_blank" ><?php i18n('MORE');?></a></span></label><input class="text" name="permalink" id="permalink" type="text" placeholder="%parent%/%slug%/" value="<?php if(isset($PERMALINK)) { echo var_out($PERMALINK); } ?>" /></p>
		<a id="flushcache" class="button" href="?flushcache"><?php i18n('FLUSHCACHE'); ?></a>
		</div>
		<div class="clear"></div>
		

		<?php exec_action('settings-website-extras'); ?>
	
		
		<div id="profile" class="section" >
		<h3><?php i18n('SIDE_USER_PROFILE');?></h3>
		<div class="leftsec">
			<p><label for="user" ><?php i18n('LABEL_USERNAME');?>:</label><input class="text" id="user" name="user" type="text" readonly value="<?php if(isset($USR1)) { echo $USR1; } else { echo $USR; } ?>" /></p>
		</div>
		<div class="rightsec">
			<p><label for="email" ><?php i18n('LABEL_EMAIL');?>:</label><input class="text" id="email" name="email" type="email" value="<?php if(isset($EMAIL1)) { echo $EMAIL1; } else { echo var_out($EMAIL,'email'); } ?>" /></p>
			<?php if (! check_email_address($EMAIL)) {
				echo '<p style="margin:-15px 0 20px 0;color:#D94136;font-size:11px;" >'.i18n_r('WARN_EMAILINVALID').'</p>';
			}?>
		</div>
		<div class="clear"></div>
		<div class="leftsec">
			<p><label for="name" ><?php i18n('LABEL_DISPNAME');?>:</label>
			<span style="margin:0px 0 5px 0;font-size:12px;color:#999;" ><?php i18n('DISPLAY_NAME');?></span>			
			<input class="text" id="name" name="name" type="text" value="<?php if(isset($NAME1)) { echo $NAME1; } else { echo var_out($NAME); } ?>" /></p>
		</div>		
		<div class="clear"></div>		
		<div class="leftsec">
			<p><label for="timezone" ><?php i18n('LOCAL_TIMEZONE');?>:</label>
			<!-- <?php if( (isset($_POST['timezone'])) ) { $TIMEZONE = $_POST['timezone']; } ?> -->
			<?php if( (isset($_POST['timezone'])) ) { $TIMEZONE = var_out($_POST['timezone']); } ?>
			<select class="text" id="timezone" name="timezone"> 
			<?php if ($TIMEZONE == '') { echo '<option value="" selected="selected" >-- '.i18n_r('NONE').' --</option>'; } else { echo '<option selected="selected"  value="'. $TIMEZONE .'">'. $TIMEZONE .'</option>'; } ?>
			<?php include('inc/timezone_options.txt'); ?>
			</select>
			</p>
		</div>
		<div class="rightsec">
			<p><label for="lang" ><?php i18n('LANGUAGE');?>: <span class="right"><a href="https://github.com/GetSimpleCMS-CE/GetSimpleCMS-CE/wiki/Languages" target="_blank" ><?php i18n('MORE');?></a></span></label>
			<select name="lang" id="lang" class="text">
				<?php echo $langs; ?>
			</select>
			</p>
		</div>
		<div class="clear"></div>
		<p class="inline" ><input name="show_htmleditor" id="show_htmleditor" type="checkbox" value="1" <?php echo $editorchck; ?> /> &nbsp;<label for="show_htmleditor" ><?php i18n('ENABLE_HTML_ED');?></label></p>
		
		<?php exec_action('settings-user-extras'); ?>
		
		<p style="margin:0px 0 5px 0;font-size:12px;color:#999;" ><?php i18n('ONLY_NEW_PASSWORD');?>:</p>
		<div class="leftsec">
			<p><label for="sitepwd" ><?php i18n('NEW_PASSWORD');?>:</label><input autocomplete="off" class="text" id="sitepwd" name="sitepwd" type="password" value="" /></p>
		</div>
		<div class="rightsec">
			<p><label for="sitepwd_confirm" ><?php i18n('CONFIRM_PASSWORD');?>:</label><input autocomplete="off" class="text" id="sitepwd_confirm" name="sitepwd_confirm" type="password" value="" /></p>
		</div>
		<div class="clear"></div>

		</div><!-- /section -->

		<div id="smtp-settings" class="section" >
		<h3><?php i18n('SMTP_SETTINGS'); ?></h3>
		<p class="desc" style="margin:0px 0 5px 0;font-size:12px;color:#999;"><?php i18n('SMTP_SETTINGS_DESC'); ?></p>

		<?php
		// Load current SMTP config for display (password never echoed)
		$smtp_display = function_exists('gs_load_smtp_config_raw') ? gs_load_smtp_config_raw() : [];
		$smtp_enabled_chk   = !empty($smtp_display['enabled']) && $smtp_display['enabled'] === '1' ? 'checked' : '';
		$smtp_host_val      = htmlspecialchars($smtp_display['host']       ?? '');
		$smtp_port_val      = htmlspecialchars($smtp_display['port']       ?? '587');
		$smtp_user_val      = htmlspecialchars($smtp_display['user']       ?? '');
		$smtp_from_email_val= htmlspecialchars($smtp_display['from_email'] ?? '');
		$smtp_from_name_val = htmlspecialchars($smtp_display['from_name']  ?? '');
		$smtp_enc_val       = $smtp_display['enc'] ?? 'tls';
		$smtp_verify_chk    = !isset($smtp_display['verify_peer']) || $smtp_display['verify_peer'] !== '0' ? 'checked' : '';
		?>

		<div class="leftsec">
			<p class="inline">
				<input type="checkbox" name="smtp_enabled" id="smtp_enabled" value="1" <?php echo $smtp_enabled_chk; ?> />
				&nbsp;<label for="smtp_enabled"><?php i18n('SMTP_ENABLE'); ?></label>
			</p>
		</div>
		<div class="clear"></div>

		<div id="smtp_fields"<?php echo empty($smtp_enabled_chk) ? ' style="display:none"' : ''; ?>>

		<div class="leftsec">
			<p><label for="smtp_host"><?php i18n('SMTP_HOST'); ?>:</label>
			<input class="text" id="smtp_host" name="smtp_host" type="text"
				value="<?php echo $smtp_host_val; ?>" placeholder="smtp.example.com" /></p>
		</div>
		<div class="rightsec">
			<p><label for="smtp_port"><?php i18n('SMTP_PORT'); ?>:</label>
			<input class="text" id="smtp_port" name="smtp_port" type="number"
				value="<?php echo $smtp_port_val; ?>" min="1" max="65535" /></p>
		</div>
		<div class="clear"></div>

		<div class="leftsec">
			<p><label for="smtp_enc"><?php i18n('SMTP_ENCRYPTION'); ?>:</label>
			<select class="text" id="smtp_enc" name="smtp_enc">
				<option value="tls"<?php echo $smtp_enc_val === 'tls' ? ' selected' : ''; ?>>STARTTLS (587)</option>
				<option value="ssl"<?php echo $smtp_enc_val === 'ssl' ? ' selected' : ''; ?>>SSL/TLS (465)</option>
				<option value=""<?php echo $smtp_enc_val === ''    ? ' selected' : ''; ?>><?php i18n('SMTP_ENC_NONE'); ?></option>
			</select></p>
		</div>
		<div class="rightsec">
			<p><label for="smtp_user"><?php i18n('SMTP_USERNAME'); ?>:</label>
			<input class="text" id="smtp_user" name="smtp_user" type="text"
				value="<?php echo $smtp_user_val; ?>" autocomplete="off" /></p>
		</div>
		<div class="clear"></div>

		<div class="leftsec">
			<p><label for="smtp_pass"><?php i18n('SMTP_PASSWORD'); ?>:</label>
			<input class="text" id="smtp_pass" name="smtp_pass" type="password"
				value="" placeholder="<?php i18n('SMTP_PASS_PLACEHOLDER'); ?>" autocomplete="new-password" /></p>
		</div>
		<div class="rightsec">
			<p><label for="smtp_from_email"><?php i18n('SMTP_FROM_EMAIL'); ?>:</label>
			<input class="text" id="smtp_from_email" name="smtp_from_email" type="email"
				value="<?php echo $smtp_from_email_val; ?>" /></p>
		</div>
		<div class="clear"></div>

		<div class="leftsec">
			<p><label for="smtp_from_name"><?php i18n('SMTP_FROM_NAME'); ?>:</label>
			<input class="text" id="smtp_from_name" name="smtp_from_name" type="text"
				value="<?php echo $smtp_from_name_val; ?>" /></p>
		</div>
		<div class="clear"></div>

		<div class="leftsec">
			<p class="inline">
				<input type="checkbox" name="smtp_verify_peer" id="smtp_verify_peer" value="1" <?php echo $smtp_verify_chk; ?> />
				&nbsp;<label for="smtp_verify_peer"><?php i18n('SMTP_VERIFY_PEER'); ?></label>
			</p>
			<p style="margin:2px 0 0 22px;font-size:11px;color:#999;"><?php i18n('SMTP_VERIFY_PEER_DESC'); ?></p>
		</div>
		<div class="rightsec">
			<p><label><?php i18n('SMTP_TEST_LABEL'); ?>:</label>
			<button type="button" id="smtp_test_btn" class="button"><?php i18n('SMTP_TEST_BTN'); ?></button>
			<span id="smtp_test_result" style="margin-left:10px;font-size:12px;"></span></p>
			<pre id="smtp_debug_output" style="display:none;margin-top:8px;padding:8px;background:#f4f4f4;border:1px solid #ddd;font-size:11px;line-height:1.4;white-space:pre-wrap;word-break:break-all;max-height:200px;overflow-y:auto;"></pre>
		</div>
		<div class="clear"></div>

		</div><!-- /#smtp_fields -->
		</div><!-- /#smtp-settings .section -->

		<div class="section">

		<p id="submit_line" >
			<span><input class="submit" type="submit" name="submitted" value="<?php i18n('BTN_SAVESETTINGS');?>" /></span> &nbsp;&nbsp;<?php i18n('OR'); ?>&nbsp;&nbsp; <a class="cancel" href="settings.php?cancel"><?php i18n('CANCEL'); ?></a>
		</p>

		</div><!-- /section -->
		</div><!-- /main -->
	</form>
	
	</div>
	
	<div id="sidebar" >
		<?php include('template/sidebar-settings.php'); ?>		
	</div>

</div>
<script>
(function() {
	// Toggle SMTP fields visibility
	var chk = document.getElementById('smtp_enabled');
	var fields = document.getElementById('smtp_fields');
	if (chk && fields) {
		chk.addEventListener('change', function() {
			fields.style.display = this.checked ? '' : 'none';
		});
	}

	// Test button
	var btn = document.getElementById('smtp_test_btn');
	var result = document.getElementById('smtp_test_result');
	if (btn && result) {
		btn.addEventListener('click', function() {
			result.textContent = '<?php echo addslashes(i18n_r("SMTP_TEST_SENDING")); ?>...';
			result.style.color = '#999';
			var data = new FormData();
			data.append('nonce', '<?php echo get_nonce("smtp_test", "gs-mailer-test"); ?>');
			fetch('<?php echo rtrim($SITEURL, '/') . '/' . $GSADMIN; ?>/inc/gs-mailer-test.php', { method: 'POST', body: data, credentials: 'same-origin' })
				.then(function(r) {
					if (!r.ok) {
						return r.text().then(function(t) {
							throw new Error('HTTP ' + r.status + (t ? ': ' + t.substring(0, 120) : ''));
						});
					}
					return r.json();
				})
				.then(function(j) {
					result.textContent = j.message;
					result.style.color = j.status === 'success' ? '#3a3' : '#c33';
					var dbg = document.getElementById('smtp_debug_output');
					if (dbg) {
						dbg.style.display = j.debug ? '' : 'none';
						dbg.textContent   = j.debug || '';
					}
				})
				.catch(function(e) {
					result.textContent = e.message || '<?php echo addslashes(i18n_r("SMTP_TEST_ERROR")); ?>';
					result.style.color = '#c33';
				});
		});
	}
}());
</script>
<?php get_template('footer'); ?>