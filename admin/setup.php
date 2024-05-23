<?php 
/**
 * Setup
 *
 * Second step of installation (install.php). Sets up initial files & structure
 *
 * @package GetSimple
 * @subpackage Installation
 */

# setup inclusions
$load['plugin'] = true;
if(isset($_POST['lang']) && trim($_POST['lang']) != '') { $LANG = $_POST['lang']; }
include('inc/common.php');

# default variables
if(defined('GSLOGINSALT')) { $logsalt = GSLOGINSALT;} else { $logsalt = null; }
$kill = ''; // fatal error kill submission reshow form
$status = ''; 
$err = null; // used for errors, show form alow resubmision
$message = null; // message to show user
$random = null;
$success = false; // success true show message if message
$fullpath = suggest_site_path();	
$path_parts = suggest_site_path(true);   

# if the form was submitted, continue
if(isset($_POST['submitted'])) {
	if($_POST['sitename'] != '') { 
		$SITENAME = htmlentities($_POST['sitename'], ENT_QUOTES, 'UTF-8'); 
	} else { 
		$err .= i18n_r('WEBSITENAME_ERROR') .'<br />'; 
	}
	
	$urls = $_POST['siteurl']; 
	if(preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $urls)) {
		$SITEURL = tsl($_POST['siteurl']); 
	} else {
		$err .= i18n_r('WEBSITEURL_ERROR') .'<br />'; 
	}
	
	if($_POST['user'] != '') { 
		$USR = strtolower($_POST['user']);
	} else {
		$err .= i18n_r('USERNAME_ERROR') .'<br />'; 
	}
	
	if (! check_email_address($_POST['email'])) {
		$err .= i18n_r('EMAIL_ERROR') .'<br />'; 
	} else {
		$EMAIL = $_POST['email'];
	}

	# if there were no errors, continue setting up the site
	if ($err == '')	{
		
		# create new password
		$random = createRandomPassword();
		$PASSWD = passhash($random);
		
		# create user xml file
		$file = _id($USR).'.xml';
		createBak($file, GSUSERSPATH, GSBACKUSERSPATH);
		$xml = new SimpleXMLElement('<item></item>');
		$xml->addChild('USR', $USR);
		$xml->addChild('PWD', $PASSWD);
		$xml->addChild('EMAIL', $EMAIL);
		$xml->addChild('HTMLEDITOR', '1');
		$xml->addChild('TIMEZONE', $TIMEZONE);
		$xml->addChild('LANG', $LANG);
		if (! XMLsave($xml, GSUSERSPATH . $file) ) {
			$kill = i18n_r('CHMOD_ERROR');
		}
		
		# create password change trigger file
		$flagfile = GSUSERSPATH . _id($USR).".xml.reset";
		copy(GSUSERSPATH . $file, $flagfile);
		
		# create new website.xml file
		$file = 'website.xml';
		$xmls = new SimpleXMLExtended('<?xml version="1.0" encoding="UTF-8"?><item></item>');		
		$note = $xmls->addChild('SITENAME');
		$note->addCData($SITENAME);
		$note = $xmls->addChild('SITEURL');
		$note->addCData($SITEURL);
		$xmls->addChild('TEMPLATE', 'ResponsiveCE');
		$xmls->addChild('PRETTYURLS', '');
		$xmls->addChild('PERMALINK', '');
		if (! XMLsave($xmls, GSDATAOTHERPATH . $file) ) {
			$kill = i18n_r('CHMOD_ERROR');
		}
		
		# create default index.xml page
		$init = GSDATAPAGESPATH.'index.xml'; 
		$temp = GSADMININCPATH.'tmp/tmp-index.xml';
		if (! file_exists($init))	{
			copy($temp,$init);
			$xml = simplexml_load_file($init); 
			$xml->pubDate = date('r');
			$xml->asXML($init);
		}

		# create default components.xml page
		$init = GSDATAOTHERPATH.'components.xml';
		$temp = GSADMININCPATH.'tmp/tmp-components.xml'; 
		if (! file_exists($init)) {
			copy($temp,$init);
		}
		
		# create default 404.xml page
		$init = GSDATAOTHERPATH.'404.xml';
		$temp = GSADMININCPATH.'tmp/tmp-404.xml'; 
		if (! file_exists($init)) {
			copy($temp,$init);
		}

		# create root .htaccess file
		 if ( !function_exists('apache_get_modules') or in_arrayi('mod_rewrite',apache_get_modules())) {
		 	$temp = GSROOTPATH .'temp.htaccess';
		 	$init = GSROOTPATH.'.htaccess';
			
			if(file_exists($temp)) {				
				$temp_data = file_get_contents(GSROOTPATH .'temp.htaccess');
				$temp_data = str_replace('**REPLACE**',tsl($path_parts), $temp_data);
				$fp = fopen($init, 'w');
				fwrite($fp, $temp_data);
				fclose($fp);
				if (!file_exists($init)) {
					$err .= sprintf(i18n_r('ROOT_HTACCESS_ERROR'), 'temp.htaccess', '**REPLACE**', tsl($path_parts)) . '<br />';
				} else if(file_exists($temp)){
					unlink($temp);
				}
			}	
		} 
	
		# create gsconfig.php if it doesn't exist yet.
		$init = GSROOTPATH.'gsconfig.php';
		$temp = GSROOTPATH.'temp.gsconfig.php';
		if (file_exists($init)) {
			if(file_exists($temp)) unlink($temp);
			if (file_exists($temp)) {
				$err .= sprintf(i18n_r('REMOVE_TEMPCONFIG_ERROR'), 'temp.gsconfig.php') . '<br />';
			}
		} else {
			rename($temp, $init);
			if (!file_exists($init)) {
				$err .= sprintf(i18n_r('MOVE_TEMPCONFIG_ERROR'), 'temp.gsconfig.php', 'gsconfig.php') . '<br />';
			}
		}
		
		# send email to new administrator
		$subject  = $site_full_name .' '. i18n_r('EMAIL_COMPLETE');
		$message .= '<h2>'. cl($SITENAME) .' '. i18n_r('EMAIL_COMPLETE').'</h2>';
		$message .= '<p>'. i18n_r('EMAIL_USERNAME') . ': <strong>'. stripslashes($_POST['user']).'</strong>';
		$message .= '<br>'. i18n_r('EMAIL_PASSWORD') .': <strong>'. $random.'</strong>';
		$message .= '<br>'. i18n_r('EMAIL_LOGIN') .': <a href="'.$SITEURL.$GSADMIN.'/">'.$SITEURL.$GSADMIN.'/</a></p>';
		$message .= '<p><em>'. i18n_r('EMAIL_THANKYOU') .' '.$site_full_name.'!</em></p>';
		$status   = sendmail($EMAIL,$subject,$message);
		# activate default plugins
		change_plugin('massiveAdmin.php',true);
		change_plugin('modernScript.php',true);

		# set the login cookie, then redirect user to secure panel
		create_cookie();
		$success = true;
	}
}

get_template('header', $site_full_name.' &raquo; '. i18n_r('INSTALLATION'));

?>
	
	<style>
		#maincontent .main {border: 2px solid #cf3805;
		box-shadow: 0 15px 25px -4px rgba(0, 0, 0, 0.5), inset 0 -3px 4px -1px rgba(0, 0, 0, 0.2), 0 -10px 15px -1px rgba(255, 255, 255, 0.6), inset 0 3px 4px -1px rgba(255, 255, 255, 0.2), inset 0 0 5px 1px rgba(255, 255, 255, 0.8), inset 0 20px 30px 0 rgba(255, 255, 255, 0.2) !important;
		-webkit-animation:flip-in-hor-bottom .5s cubic-bezier(.25,.46,.45,.94) 1s both;animation:flip-in-hor-bottom .5s cubic-bezier(.25,.46,.45,.94) 1s both}
		@-webkit-keyframes flip-in-hor-bottom{0%{-webkit-transform:rotateX(80deg);transform:rotateX(80deg);opacity:0}100%{-webkit-transform:rotateX(0);transform:rotateX(0);opacity:1}}@keyframes flip-in-hor-bottom{0%{-webkit-transform:rotateX(80deg);transform:rotateX(80deg);opacity:0}100%{-webkit-transform:rotateX(0);transform:rotateX(0);opacity:1}
		}
		body{
			background-color: #f6f6f6;
			background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 304 304' width='600' height='600'%3E%3Cpath fill='%23cf3805' fill-opacity='0.4' d='M44.1 224a5 5 0 1 1 0 2H0v-2h44.1zm160 48a5 5 0 1 1 0 2H82v-2h122.1zm57.8-46a5 5 0 1 1 0-2H304v2h-42.1zm0 16a5 5 0 1 1 0-2H304v2h-42.1zm6.2-114a5 5 0 1 1 0 2h-86.2a5 5 0 1 1 0-2h86.2zm-256-48a5 5 0 1 1 0 2H0v-2h12.1zm185.8 34a5 5 0 1 1 0-2h86.2a5 5 0 1 1 0 2h-86.2zM258 12.1a5 5 0 1 1-2 0V0h2v12.1zm-64 208a5 5 0 1 1-2 0v-54.2a5 5 0 1 1 2 0v54.2zm48-198.2V80h62v2h-64V21.9a5 5 0 1 1 2 0zm16 16V64h46v2h-48V37.9a5 5 0 1 1 2 0zm-128 96V208h16v12.1a5 5 0 1 1-2 0V210h-16v-76.1a5 5 0 1 1 2 0zm-5.9-21.9a5 5 0 1 1 0 2H114v48H85.9a5 5 0 1 1 0-2H112v-48h12.1zm-6.2 130a5 5 0 1 1 0-2H176v-74.1a5 5 0 1 1 2 0V242h-60.1zm-16-64a5 5 0 1 1 0-2H114v48h10.1a5 5 0 1 1 0 2H112v-48h-10.1zM66 284.1a5 5 0 1 1-2 0V274H50v30h-2v-32h18v12.1zM236.1 176a5 5 0 1 1 0 2H226v94h48v32h-2v-30h-48v-98h12.1zm25.8-30a5 5 0 1 1 0-2H274v44.1a5 5 0 1 1-2 0V146h-10.1zm-64 96a5 5 0 1 1 0-2H208v-80h16v-14h-42.1a5 5 0 1 1 0-2H226v18h-16v80h-12.1zm86.2-210a5 5 0 1 1 0 2H272V0h2v32h10.1zM98 101.9V146H53.9a5 5 0 1 1 0-2H96v-42.1a5 5 0 1 1 2 0zM53.9 34a5 5 0 1 1 0-2H80V0h2v34H53.9zm60.1 3.9V66H82v64H69.9a5 5 0 1 1 0-2H80V64h32V37.9a5 5 0 1 1 2 0zM101.9 82a5 5 0 1 1 0-2H128V37.9a5 5 0 1 1 2 0V82h-28.1zm16-64a5 5 0 1 1 0-2H146v44.1a5 5 0 1 1-2 0V18h-26.1zm102.2 270a5 5 0 1 1 0 2H98v14h-2v-16h124.1zM242 149.9V160h16v34h-16v62h48v48h-2v-46h-48v-66h16v-30h-16v-12.1a5 5 0 1 1 2 0zM53.9 18a5 5 0 1 1 0-2H64V2H48V0h18v18H53.9zm112 32a5 5 0 1 1 0-2H192V0h50v2h-48v48h-28.1zm-48-48a5 5 0 0 1-9.8-2h2.07a3 3 0 1 0 5.66 0H178v34h-18V21.9a5 5 0 1 1 2 0V32h14V2h-58.1zm0 96a5 5 0 1 1 0-2H137l32-32h39V21.9a5 5 0 1 1 2 0V66h-40.17l-32 32H117.9zm28.1 90.1a5 5 0 1 1-2 0v-76.51L175.59 80H224V21.9a5 5 0 1 1 2 0V82h-49.59L146 112.41v75.69zm16 32a5 5 0 1 1-2 0v-99.51L184.59 96H300.1a5 5 0 0 1 3.9-3.9v2.07a3 3 0 0 0 0 5.66v2.07a5 5 0 0 1-3.9-3.9H185.41L162 121.41v98.69zm-144-64a5 5 0 1 1-2 0v-3.51l48-48V48h32V0h2v50H66v55.41l-48 48v2.69zM50 53.9v43.51l-48 48V208h26.1a5 5 0 1 1 0 2H0v-65.41l48-48V53.9a5 5 0 1 1 2 0zm-16 16V89.41l-34 34v-2.82l32-32V69.9a5 5 0 1 1 2 0zM12.1 32a5 5 0 1 1 0 2H9.41L0 43.41V40.6L8.59 32h3.51zm265.8 18a5 5 0 1 1 0-2h18.69l7.41-7.41v2.82L297.41 50H277.9zm-16 160a5 5 0 1 1 0-2H288v-71.41l16-16v2.82l-14 14V210h-28.1zm-208 32a5 5 0 1 1 0-2H64v-22.59L40.59 194H21.9a5 5 0 1 1 0-2H41.41L66 216.59V242H53.9zm150.2 14a5 5 0 1 1 0 2H96v-56.6L56.6 162H37.9a5 5 0 1 1 0-2h19.5L98 200.6V256h106.1zm-150.2 2a5 5 0 1 1 0-2H80v-46.59L48.59 178H21.9a5 5 0 1 1 0-2H49.41L82 208.59V258H53.9zM34 39.8v1.61L9.41 66H0v-2h8.59L32 40.59V0h2v39.8zM2 300.1a5 5 0 0 1 3.9 3.9H3.83A3 3 0 0 0 0 302.17V256h18v48h-2v-46H2v42.1zM34 241v63h-2v-62H0v-2h34v1zM17 18H0v-2h16V0h2v18h-1zm273-2h14v2h-16V0h2v16zm-32 273v15h-2v-14h-14v14h-2v-16h18v1zM0 92.1A5.02 5.02 0 0 1 6 97a5 5 0 0 1-6 4.9v-2.07a3 3 0 1 0 0-5.66V92.1zM80 272h2v32h-2v-32zm37.9 32h-2.07a3 3 0 0 0-5.66 0h-2.07a5 5 0 0 1 9.8 0zM5.9 0A5.02 5.02 0 0 1 0 5.9V3.83A3 3 0 0 0 3.83 0H5.9zm294.2 0h2.07A3 3 0 0 0 304 3.83V5.9a5 5 0 0 1-3.9-5.9zm3.9 300.1v2.07a3 3 0 0 0-1.83 1.83h-2.07a5 5 0 0 1 3.9-3.9zM97 100a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-48 32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm32 48a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm32-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0-32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm32 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16-64a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 96a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16-144a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16-32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-96 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16-32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm96 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16-64a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-32 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM49 36a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-32 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm32 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM33 68a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16-48a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 240a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16-64a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16-32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm80-176a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm32 48a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0-32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm112 176a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-16 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM17 180a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0-32a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM17 84a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm32 64a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm16-16a3 3 0 1 0 0-6 3 3 0 0 0 0 6z'%3E%3C/path%3E%3C/svg%3E");
			height:100vh;
			width:100%;
			display: flex;
			align-items: center;
			justify-content: center;
		}
	</style>

		<h1><?php echo $site_full_name; ?></h1>
	</div>
</div>
<div class="wrapper">
	<div id="maincontent">
		<?php
			# display error or success messages
			if ($status == 'success') {
				echo '<div class="updated">'. i18n_r('NOTE_REGISTRATION') .' '. $_POST['email'] .'</div>';
			}
			elseif ($status == 'error') {
				echo '<div class="error">'. i18n_r('NOTE_REGERROR') .'.</div>';
			}
			if ($kill != '') {
				$success = false;
				echo '<div class="error">'. $kill .'</div>';
			}
			if ($err != '') {
				// $success = false;
				echo '<div class="error">'. $err .'</div>';
			}
			if ($random != ''){
				echo '<div class="updated">'.i18n_r('NOTE_USERNAME').' <b>'. stripslashes($_POST['user']) .'</b> '.i18n_r('NOTE_PASSWORD').' <b>'. $random .'</b> &nbsp&raquo;&nbsp; <a href="support.php?updated=2">'.i18n_r('EMAIL_LOGIN').'</a></div>';
				$_POST = null;
			}

	if (!$success) { ?>
		<div class="main" >
			<h3><?php echo $site_full_name .' '. i18n_r('INSTALLATION'); ?></h3>
			<form action="<?php myself(); ?>" method="post" accept-charset="utf-8" >
				<input name="siteurl" type="hidden" value="<?php echo $fullpath; ?>" />
				<input name="lang" type="hidden" value="<?php echo $LANG; ?>" />
				<p><label for="sitename" ><?php i18n('LABEL_WEBSITE'); ?>:</label><input class="text" id="sitename" name="sitename" type="text" value="<?php if(isset($_POST['sitename'])) { echo $_POST['sitename']; } ?>" /></p>
				<p><label for="user" ><?php i18n('LABEL_USERNAME'); ?>:</label><input class="text" name="user" id="user" type="text" value="<?php if(isset($_POST['user'])) { echo $_POST['user']; } ?>" /></p>
				<p><label for="email" ><?php i18n('LABEL_EMAIL'); ?>:</label><input class="text" name="email" id="email" type="email" value="<?php if(isset($_POST['email'])) { echo $_POST['email']; } ?>" /></p>
				<p><input class="submit" type="submit" name="submitted" value="<?php i18n('LABEL_INSTALL'); ?>" /></p>
			</form>
		</div>
</div>

<div class="clear"></div>
<?php get_template('footer'); ?>

<?php } ?>

<!--  create default theme -->
<?php 
	if(isset($_POST['continue'])){
		$folder =GSDATAOTHERPATH.'massiveTheme/';
		if(!file_exists($folder)){
			mkdir($folder,0755);
		}

		file_put_contents($folder.'option.txt',$_POST['theme']);
	};
;?>