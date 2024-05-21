<?php

# get correct id for plugin
$modernScript = basename(__FILE__, ".php");

# add in this plugin's language file
i18n_merge($modernScript) || i18n_merge($modernScript, 'en_US');

# register plugin
register_plugin(
	$modernScript, 								# ID of plugin, should be filename minus php
	i18n_r($modernScript.'/lang_Menu_Title'), 	# Title of plugin
	'1.0', 										# Plugin version
	'Multicolor',								# Plugin author
	'https://ko-fi.com/multicolorplugins', 		# Author URL
	i18n_r($modernScript.'/lang_Description'),	# Plugin Description
	'plugins',									# Page type of plugin
	'modernScript' 								# Function that displays content
);

add_action('plugins-sidebar', 'createSideMenu', array($modernScript, i18n_r($modernScript.'/lang_Menu_Title')));

add_action('header', 'modernHeader');

function modernHeader(){

	global $SITEURL;

	if (file_exists(GSDATAOTHERPATH . 'modernScript.json')) {
		$file = GSDATAOTHERPATH . 'modernScript.json';
		$fileData = json_decode(file_get_contents($file), true);

		$w3js = $fileData['w3js'];
		$w3css = $fileData['w3css'];
		$alpine = $fileData['alpine'];
		$jquery = $fileData['jquery'];
		$jqueryui = $fileData['jqueryui'];
		$jqueryold = $fileData['jqueryold'];
	};

	if (@$w3css == "true") {
		echo '<link href="' . $SITEURL . 'admin/template/css/w3/w3.css" rel="stylesheet" media="screen">';
	};

	if (@$w3js == "true") {
		echo '<script src="' . $SITEURL . 'admin/template/css/w3/w3.js"></script>';
	}

	if (@$alpine == "true") {
		echo '<script src="' . $SITEURL . 'admin/template/js/alpinejs/alpinejs.min.js"></script>';
	}

	if (@$jqueryold == "true") {
		echo '<script src="' . $SITEURL . 'admin/template/js/jquery/jquery-1.8.3.min.js"></script>';
	}

	if (@$jquery == "true") {
		echo '<script src="' . $SITEURL . 'admin/template/js/jquery/jquery-3.7.1.min.js"></script>';
	}

	if (@$jqueryui == "true") {
		echo '<script src="' . $SITEURL . 'admin/template/js/jquery/jquery-ui.min.js"></script>';
	}
}

function modernScript(){
	if (file_exists(GSDATAOTHERPATH . 'modernScript.json')) {
		$file = GSDATAOTHERPATH . 'modernScript.json';
		$fileData = json_decode(file_get_contents($file), true);

		$w3js = $fileData['w3js'];
		$w3css = $fileData['w3css'];
		$alpine = $fileData['alpine'];
		$jquery = $fileData['jquery'];
		$jqueryui = $fileData['jqueryui'];
		$jqueryold = $fileData['jqueryold'];
	};

	echo '
	<style>
		form a {text-decoration:none !important; color:grey !important;}
		form h3 {font-size:1.2rem}
		form .note {font-weight:400 !important;}
	</style>
	<h3 style="font-size:1.4rem;margin:0;margin-bottom:5px;">'.i18n_r("modernScript/lang_Page_Title").'</h3>
	<i style="display:block;">'.i18n_r("modernScript/lang_Description").'</i>
	<hr style="border:none;border-bottom:solid 1px #ddd;margin:20px 0 30px;">
	
	<form action="#" method="POST">
		<div style="padding-bottom:30px;">
			<h3>Alpine.js <span style="font-size:.85rem"> '.i18n_r("modernScript/lang_Alpine_Description").'</span> </h3>
			
			<div style="display:flex;align-items:center; justify-content:space-between;border:solid 1px #ddd;background:#fafafa;padding:10px;box-sizing:border-box;margin:5px 0">
				<label style="display:">Alpine.js v3.13.10 (<a href="https://alpinejs.dev/" target="_blank">'.i18n_r("modernScript/lang_Documentation").'</a>) <span class="note">'.i18n_r("modernScript/lang_Alpine_Note").'</span></label>
				<input type="checkbox" name="alpine" value="true" ' . (@$alpine == "true" ? 'checked' : '') . '></label>
			</div>
		</div>

		<div style="padding-bottom:30px;">
			<h3>Jquery <span style="font-size:.85rem"> '.i18n_r("modernScript/lang_Jquery_Description").'</span></h3>

			<div style="display:flex;align-items:center; justify-content:space-between;border:solid 1px #ddd;background:#fafafa;padding:10px;box-sizing:border-box;margin:5px 0">
				<label style="display:">jQuery v1.8.3 (<a href="https://jquery.com/" target="_blank">'.i18n_r("modernScript/lang_Documentation").'</a>) <span class="note">'.i18n_r("modernScript/lang_Jquery_Note").'</span></label>
				<input type="checkbox" name="jqueryold" value="true" ' . (@$jqueryold == "true" ? 'checked' : '') . '></label>
			</div>

			<div style="display:flex;align-items:center; justify-content:space-between;border:solid 1px #ddd;background:#fafafa;padding:10px;box-sizing:border-box;margin:5px 0">
				<label style="display:">jQuery v3.7.1 (<a href="https://jquery.com/" target="_blank">'.i18n_r("modernScript/lang_Documentation").'</a>) <span class="note">'.i18n_r("modernScript/lang_Jquery2_Note").'</span></label>
				<input type="checkbox" name="jquery" value="true" ' . (@$jquery == "true" ? 'checked' : '') . '></label>
			</div>

			<div style="display:flex;align-items:center; justify-content:space-between;border:solid 1px #ddd;background:#fafafa;padding:10px;box-sizing:border-box;margin:5px 0">
				<label style="display:">jQuery UI (<a href="https://jqueryui.com/" target="_blank">' . i18n_r("modernScript/lang_Documentation") . '</a>) <span class="note">' . i18n_r("modernScript/lang_Jquery2_Note") . '</span></label>
				<input type="checkbox" name="jqueryui" value="true" ' . (@$jqueryui == "true" ? 'checked' : '') . '></label>
			</div>
		 
			<br>
		</div>

		<div style="padding-bottom:10px;">
			<h3>W3 <span style="font-size:.85rem"> '.i18n_r("modernScript/lang_W3_Description").'</span></h3>

			<div style="display:flex;align-items:center; justify-content:space-between;border:solid 1px #ddd;background:#fafafa;padding:10px;box-sizing:border-box;margin:5px 0">
				<label style="display:">W3 CSS v4.15 (<a href="https://www.w3schools.com/w3css/default.asp" target="_blank">'.i18n_r("modernScript/lang_Documentation").'</a>) <span class="note">'.i18n_r("modernScript/lang_W3css_Note").'</span></label>
				<input type="checkbox" name="w3css" value="true" ' . (@$w3css == "true" ? 'checked' : '') . '></label>
			</div>

			<div style="display:flex;align-items:center; justify-content:space-between;border:solid 1px #ddd;background:#fafafa;padding:10px;box-sizing:border-box;margin:5px 0">
				<label>W3 JS v1.04 (<a href="https://w3.p2hp.com/w3js/default.asp" target="_blank">'.i18n_r("modernScript/lang_Documentation").'</a>) <span class="note">'.i18n_r("modernScript/lang_W3js_Note").'</span></label>
				<input type="checkbox" name="w3js" value="true" ' . (@$w3js == "true" ? 'checked' : '') . '>
			</div>

			<br>
			<br>
		</div>
		
		<input type="submit" name="saveModernScript" value="'.i18n_r("modernScript/lang_Save").'" class="submit">
		
		<hr style="border:none;border-bottom:solid 1px #ddd;margin:20px 0 30px;">
	</form>
	';

	echo "
	<style>.kofitext,.kofi-button{text-decoration:none !important}</style>
	<div style='margin:20px 0;width:100%;' class='kofi'>
		<script type='text/javascript' src='https://storage.ko-fi.com/cdn/widget/Widget_2.js'></script>
		<script type='text/javascript'>kofiwidget2.init('Support Me on Ko-fi', '#29abe0', 'I3I2RHQZS');kofiwidget2.draw();</script>
	</div> ";

	if (isset($_POST['saveModernScript'])) {
		$data = [];

		$data['w3js'] = $_POST['w3js'];
		$data['w3css'] = $_POST['w3css'];
		$data['alpine'] = $_POST['alpine'];
		$data['jquery'] = $_POST['jquery'];
		$data['jqueryui'] = $_POST['jqueryui'];
		$data['jqueryold'] = $_POST['jqueryold'];

		$finalData = json_encode($data);

		file_put_contents(GSDATAOTHERPATH . 'modernScript.json', $finalData);

		echo "<meta http-equiv='refresh' content='0'>";
	};
}