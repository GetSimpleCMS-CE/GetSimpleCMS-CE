<?php global $SITEURL; ?>

<link rel="stylesheet" href="<?php global $SITEURL; echo $SITEURL; ?>plugins/massiveAdmin/css/w3.css">
<link rel="stylesheet" href="<?php global $SITEURL; echo $SITEURL; ?>plugins/massiveAdmin/css/w3-custom.css">
<style>.w3-block, .w3-select, .w3-input{width:96%}</style>
<style>
	.w3-block,
	.w3-select {
		width: 96%;
		box-sizing: border-box !important;
	}
</style>
<div class="w3-parent w3-container" style="padding:10px;box-sizing:border-box;"><!-- Start Plug -->
<h3><?php echo i18n_r("massiveAdmin/HIDEMENUTITLE"); ?></h3>
<hr>

	<button onclick="myFunction('Tab1')" class="w3-button w3-xlarge w3-round w3-block w3-gray w3-text-white w3-left-align w3-margin-bottom"><?php echo i18n_r("massiveAdmin/CREATENEWUSER"); ?><span class="w3-right"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="m5 8l7 8l7-8z"/></svg></span></button>
	<div id="Tab1" class="w3-hide w3-container">
		
		<form action="" method="post" class="w3-margin-bottom" style="width:96%">
			<label><?php echo i18n_r("massiveAdmin/USERNAMECREATE"); ?></label>
			<input class="w3-input w3-padding w3-border w3-round w3-margin-bottom" type="text" name="createuserhidden" oninput="toLowercase(this)">
			
			<label><?php echo i18n_r('massiveAdmin/PASSWORDCREATE'); ?></label>
			<input class="w3-input w3-padding w3-border w3-round w3-margin-bottom" type="password" name="createpassword">

			<label><?php echo i18n_r('massiveAdmin/EMAILCREATE'); ?></label>
			<input class="w3-input w3-padding w3-border w3-round w3-margin-bottom" type="e-mail" name="createuseremail">

			<label><?php echo i18n_r('massiveAdmin/LANGCREATE'); ?></label>
			<select class="w3-select w3-padding w3-border w3-round w3-margin-bottom" name="lang">
				<?php
				$files = glob("../admin/lang/*.php");
				foreach ($files as &$value) {

					$old = ["../admin/lang/", ".php"];
					$newreplace = ['', ''];
					$new = str_replace($old, $newreplace, $value);
					echo ' <option value="' . $new . '">' . $new . '</option>';
				};; ?>
			</select>
			
			<div class="w3-margin-top w3-center">
				<button class="w3-btn w3-large w3-round w3-green" type="submit" name="savecreateuser">
					<?php echo i18n_r('massiveAdmin/CREATENEWUSER'); ?>
				</button>
			</div>
			
		</form>
		
		<script>
			function toLowercase(input) {
				input.value = input.value.toLowerCase();
			}
			document.querySelector('.hidecontent3').classList.add('hide');

			document.querySelector('#hidetitle3').addEventListener('click', () => {
				if (document.querySelector('.hidecontent3').classList.contains('hide') == true) {
					document.querySelector('.hidecontent3').classList.remove('hide');
				} else {
					document.querySelector('.hidecontent3').classList.add('hide');
				}
			});
		</script>

		<?php
		if (isset($_COOKIE['GS_ADMIN_USERNAME'])) {
			if (isset($_POST['savecreateuser'])) {
				global $MA;
				$MA->saveCreateUser();
			};
		};
		?>

		<?php
		$massiveHiddenSection = GSDATAOTHERPATH . '/massiveHiddenSection/';
		$filejson = 'userhidden.json';
		$finaljson = $massiveHiddenSection . $filejson;
		$chmod_mode	= 0755;
		$folder_exists = file_exists($massiveHiddenSection) || mkdir($massiveHiddenSection, $chmod_mode);
		if (file_exists($finaljson)) {
			$datee = file_get_contents($finaljson);
			$data = json_decode($datee);
		};
		?>
		
	</div>

	<button onclick="myFunction('Tab2')" class="w3-button w3-xlarge w3-round w3-block w3-gray w3-text-white w3-left-align w3-margin-bottom"><?php echo i18n_r('massiveAdmin/HIDSECTIONTITLE'); ?> <span class="w3-right"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="m5 8l7 8l7-8z"/></svg></span></button>
	<div id="Tab2" class="w3-hide w3-container">
	
		<?php foreach (glob(GSUSERSPATH . '*.xml') as $us) : ?>

		<?php
		$file =  GSDATAOTHERPATH . 'massiveHiddenSection/' . pathinfo($us)['filename'] . '.json';
		$data = '';
		if (file_exists($file)) {

			$data = file_get_contents($file);
			$data = json_decode($data);
		} else {
			$data = null;
		};
		?>

		<form class="w3-margin-bottom" style="width:96%" method="POST" data-user="<?php echo pathinfo($us)['filename']; ?>">

			<div class="w3-panel w3-leftbar w3-pale-blue w3-border-blue w3-padding"><h4 class="w3-margin-top">
			User: <?php echo 
			$usxml = simplexml_load_file($us);
			echo $usxml->USR;
			?></h4></div>

			<input type="hidden" name="user" value="<?php echo pathinfo($us)['filename']; ?>">

			<label><?php echo i18n_r('massiveAdmin/HIDEPAGES'); ?></label>
			<select class="w3-select w3-padding w3-border w3-round w3-margin-bottom" name="hidepages">
				<option value="show"><?php echo i18n_r('massiveAdmin/SHOW'); ?></option>
				<option value="hide"><?php echo i18n_r('massiveAdmin/HIDE'); ?></option>
			</select>

			<label><?php echo i18n_r('massiveAdmin/HIDEFILES'); ?></label>
			<select class="w3-select w3-padding w3-border w3-round w3-margin-bottom" name="hidefiles">
				<option value="show"><?php echo i18n_r('massiveAdmin/SHOW'); ?></option>
				<option value="hide"><?php echo i18n_r('massiveAdmin/HIDE'); ?></option>
			</select>

			<label><?php echo i18n_r('massiveAdmin/HIDETHEMES'); ?></label>
			<select class="w3-select w3-padding w3-border w3-round w3-margin-bottom" name="hidethemes">
				<option value="show"><?php echo i18n_r('massiveAdmin/SHOW'); ?></option>
				<option value="hide"><?php echo i18n_r('massiveAdmin/HIDE'); ?></option>
			</select>

			<label><?php echo i18n_r('massiveAdmin/HIDEBACKUP'); ?></label>
			<select class="w3-select w3-padding w3-border w3-round w3-margin-bottom" name="hidebackup">
				<option value="show"><?php echo i18n_r('massiveAdmin/SHOW'); ?></option>
				<option value="hide"><?php echo i18n_r('massiveAdmin/HIDE'); ?></option>
			</select>

			<label><?php echo i18n_r('massiveAdmin/HIDEPLUGIN'); ?></label>
			<select class="w3-select w3-padding w3-border w3-round w3-margin-bottom" name="hideplugin">
				<option value="show"><?php echo i18n_r('massiveAdmin/SHOW'); ?></option>
				<option value="hide"><?php echo i18n_r('massiveAdmin/HIDE'); ?></option>
			</select>

			<label><?php echo i18n_r('massiveAdmin/HIDESUPPORT'); ?></label>
			<select class="w3-select w3-padding w3-border w3-round w3-margin-bottom" name="hidesupport">
				<option value="show"><?php echo i18n_r('massiveAdmin/SHOW'); ?></option>
				<option value="hide"><?php echo i18n_r('massiveAdmin/HIDE'); ?></option>
			</select>

			<label><?php echo i18n_r('massiveAdmin/HIDESETTINGS'); ?></label>
			<select class="w3-select w3-padding w3-border w3-round w3-margin-bottom" name="hidesettings">
				<option value="show"><?php echo i18n_r('massiveAdmin/SHOW'); ?></option>
				<option value="hide"><?php echo i18n_r('massiveAdmin/HIDE'); ?></option>
			</select>

			<label><?php echo i18n_r('massiveAdmin/HIDEI18NGALLERY'); ?></label>
			<select class="w3-select w3-padding w3-border w3-round w3-margin-bottom" name="hidei18n">
				<option value="show"><?php echo i18n_r('massiveAdmin/SHOW'); ?></option>
				<option value="hide"><?php echo i18n_r('massiveAdmin/HIDE'); ?></option>
			</select>

			<label><?php echo i18n_r('massiveAdmin/HIDEGSSETTINGS'); ?></label>
			<select class="w3-select w3-padding w3-border w3-round w3-margin-bottom" name="hidegssettings">
				<option value="show"><?php echo i18n_r('massiveAdmin/SHOW'); ?></option>
				<option value="hide"><?php echo i18n_r('massiveAdmin/HIDE'); ?></option>
			</select>
			
			<div class="w3-margin-top w3-center">
				<button class="w3-btn w3-large w3-round w3-green" type="submit" name="submit">
					<?php echo i18n_r('massiveAdmin/SAVEOPTION'); ?>
				</button>
			</div>
			
			<hr>

		</form>

		<?php 	if (file_exists($file)) :?>

		<script>
			document.querySelector('form[data-user="<?php echo pathinfo($us)['filename']; ?>"] select[name="hidepages"]').value = '<?php echo @$data->hidepages ?>';
			document.querySelector('form[data-user="<?php echo pathinfo($us)['filename']; ?>"] select[name="hidefiles"]').value = '<?php echo @$data->hidefiles ?>';
			document.querySelector('form[data-user="<?php echo pathinfo($us)['filename']; ?>"] select[name="hidethemes"]').value = '<?php echo @$data->hidethemes ?>';
			document.querySelector('form[data-user="<?php echo pathinfo($us)['filename']; ?>"] select[name="hidebackup"]').value = '<?php echo @$data->hidebackup ?>';
			document.querySelector('form[data-user="<?php echo pathinfo($us)['filename']; ?>"] select[name="hideplugin"]').value = '<?php echo @$data->hideplugin ?>';
			document.querySelector('form[data-user="<?php echo pathinfo($us)['filename']; ?>"] select[name="hidesupport"]').value = '<?php echo @$data->hidesupport ?>';
			document.querySelector('form[data-user="<?php echo pathinfo($us)['filename']; ?>"] select[name="hidesettings"]').value = '<?php echo @$data->hidesettings ?>';
			document.querySelector('form[data-user="<?php echo pathinfo($us)['filename']; ?>"] select[name="hidei18n"]').value = '<?php echo @$data->hidei18n ?>';
			document.querySelector('form[data-user="<?php echo pathinfo($us)['filename']; ?>"] select[name="hidegssettings"]').value = '<?php echo @$data->hidegssettings ?>';
		</script>

		<?php endif;?>
		<?php endforeach; ?>
		
	</div>

	<button onclick="myFunction('Tab3')" class="w3-button w3-xlarge w3-round w3-block w3-gray w3-text-white w3-left-align w3-margin-bottom"><?php echo i18n_r('massiveAdmin/USERMANAGER'); ?> <span class="w3-right"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="m5 8l7 8l7-8z"/></svg></span></button>
	<div id="Tab3" class="w3-hide w3-container">
		<ul class="w3-ul">
			<?php
			global $MA;
			$MA->userList();; ?>
		</ul>
	</div>

	<script>
		function myFunction(id) {
		  var x = document.getElementById(id);
		  if (x.className.indexOf("w3-show") == -1) {
			x.className += " w3-show";
			x.previousElementSibling.className = 
			x.previousElementSibling.className.replace("w3-gray", "w3-gs-main");
		  } else { 
			x.className = x.className.replace(" w3-show", "");
			x.previousElementSibling.className = 
			x.previousElementSibling.className.replace("w3-gs-main", "w3-gray");
		  }
		}
	</script>

	<?php
	if (isset($_POST['submit'])) {
		global $MA;
		$MA->submitHideAdminSection();
	};
	?>