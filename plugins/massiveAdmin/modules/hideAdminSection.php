<?php
global $SITEURL;; ?>
<style>
	@import url('<?php echo $SITEURL; ?>plugins/massiveAdmin/css/hideAdminSection.css');
</style>

<div>

	<div class="hidetitle" id="hidetitle3">
		<h3><?php echo i18n_r("massiveAdmin/CREATENEWUSER"); ?></h3>

		<svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 24 24" id="arrow-down" style="display:inline-block;width:20px;">
			<path fill="var(--main-color)" d="M17.71,11.29a1,1,0,0,0-1.42,0L13,14.59V7a1,1,0,0,0-2,0v7.59l-3.29-3.3a1,1,0,0,0-1.42,1.42l5,5a1,1,0,0,0,.33.21.94.94,0,0,0,.76,0,1,1,0,0,0,.33-.21l5-5A1,1,0,0,0,17.71,11.29Z"></path>
		</svg>

	</div>

	<div class="hidecontent hidecontent3" id="hidecontent3">
		<form action="" method="post">
			<br>
			<?php echo i18n_r("massiveAdmin/USERNAMECREATE"); ?>
			<br>
			<input type="text" name="createuserhidden">
			<br><br>
			<?php echo i18n_r('massiveAdmin/PASSWORDCREATE'); ?>
			<br>
			<input type="password" name="createpassword">
			<br> <br>
			<?php echo i18n_r('massiveAdmin/EMAILCREATE'); ?>
			<br>
			<input type="e-mail" name="createuseremail">
			<br> <br>
			<?php echo i18n_r('massiveAdmin/LANGCREATE'); ?>
			<br><br>
			<select name="lang">
				<?php
				$files = glob("../admin/lang/*.php");
				foreach ($files as &$value) {

					$old = ["../admin/lang/", ".php"];
					$newreplace = ['', ''];
					$new = str_replace($old, $newreplace, $value);
					echo ' <option value="' . $new . '">' . $new . '</option>';
				};; ?>
			</select>

			<input type="submit" name="savecreateuser" style="width: 100%; padding: 10px; margin-top: 20px; background: #000; color: #fff; border: none; border-radius: 5px;" value="<?php echo i18n_r('massiveAdmin/CREATENEWUSER'); ?>">
		</form>
	</div>

</div>

<script>
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
};; ?>

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

<div id="hidetitle1" class="hidetitle">
	<h3><?php echo i18n_r('massiveAdmin/HIDSECTIONTITLE'); ?></h3>

	<svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 24 24" id="arrow-down" style="display:inline-block;width:20px;">
		<path fill="var(--main-color)" d="M17.71,11.29a1,1,0,0,0-1.42,0L13,14.59V7a1,1,0,0,0-2,0v7.59l-3.29-3.3a1,1,0,0,0-1.42,1.42l5,5a1,1,0,0,0,.33.21.94.94,0,0,0,.76,0,1,1,0,0,0,.33-.21l5-5A1,1,0,0,0,17.71,11.29Z"></path>
	</svg>

</div>

<div id="hidecontent1" class="hidecontent hidecontent1">

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

		<form method="POST" data-user="<?php echo pathinfo($us)['filename']; ?>" style="width:100%;height:auto; margin-top:20px;" class="hideadminsectionform">

			<div style="width:100%;padding:5px;border:solid 1px #ddd;background:var(--main-color);color:#fff;grid-column: 1/3;font-size:1.2rem;height:auto;padding:5px;">
				<p>User: <?php echo pathinfo($us)['filename']; ?></p>
			</div>

			<input type="hidden" name="user" value="<?php echo pathinfo($us)['filename']; ?>">

			<p><?php echo i18n_r('massiveAdmin/HIDEPAGES'); ?></p>
			<select name="hidepages">
				<option value="show"><?php echo i18n_r('massiveAdmin/SHOW'); ?></option>
				<option value="hide"><?php echo i18n_r('massiveAdmin/HIDE'); ?></option>
			</select>

			<p><?php echo i18n_r('massiveAdmin/HIDEFILES'); ?></p>
			<select name="hidefiles">
				<option value="show"><?php echo i18n_r('massiveAdmin/SHOW'); ?></option>
				<option value="hide"><?php echo i18n_r('massiveAdmin/HIDE'); ?></option>
			</select>

			<p><?php echo i18n_r('massiveAdmin/HIDETHEMES'); ?></p>
			<select name="hidethemes">
				<option value="show"><?php echo i18n_r('massiveAdmin/SHOW'); ?></option>
				<option value="hide"><?php echo i18n_r('massiveAdmin/HIDE'); ?></option>
			</select>

			<p><?php echo i18n_r('massiveAdmin/HIDEBACKUP'); ?></p>
			<select name="hidebackup">
				<option value="show"><?php echo i18n_r('massiveAdmin/SHOW'); ?></option>
				<option value="hide"><?php echo i18n_r('massiveAdmin/HIDE'); ?></option>
			</select>

			<p><?php echo i18n_r('massiveAdmin/HIDEPLUGIN'); ?></p>
			<select name="hideplugin">
				<option value="show"><?php echo i18n_r('massiveAdmin/SHOW'); ?></option>
				<option value="hide"><?php echo i18n_r('massiveAdmin/HIDE'); ?></option>
			</select>

			<p><?php echo i18n_r('massiveAdmin/HIDESUPPORT'); ?></p>
			<select name="hidesupport">
				<option value="show"><?php echo i18n_r('massiveAdmin/SHOW'); ?></option>
				<option value="hide"><?php echo i18n_r('massiveAdmin/HIDE'); ?></option>
			</select>

			<p><?php echo i18n_r('massiveAdmin/HIDESETTINGS'); ?></p>
			<select name="hidesettings">
				<option value="show"><?php echo i18n_r('massiveAdmin/SHOW'); ?></option>
				<option value="hide"><?php echo i18n_r('massiveAdmin/HIDE'); ?></option>
			</select>

			<p><?php echo i18n_r('massiveAdmin/HIDEI18NGALLERY'); ?></p>
			<select name="hidei18n">
				<option value="show"><?php echo i18n_r('massiveAdmin/SHOW'); ?></option>
				<option value="hide"><?php echo i18n_r('massiveAdmin/HIDE'); ?></option>
			</select>

			<br>
			<br>
			
			<input type="submit" name="submit" value="<?php echo i18n_r('massiveAdmin/SAVEOPTION'); ?>" style="grid-column:1/3" />

		</form>

		<?php 	if (file_exists($file)) :?>

		<script>
			document.querySelector('form[data-user="<?php echo pathinfo($us)['filename']; ?>"] select[name="hidepages"]').value = '<?php echo $data->hidepages ?>';
			document.querySelector('form[data-user="<?php echo pathinfo($us)['filename']; ?>"] select[name="hidefiles"]').value = '<?php echo $data->hidefiles ?>';
			document.querySelector('form[data-user="<?php echo pathinfo($us)['filename']; ?>"] select[name="hidethemes"]').value = '<?php echo $data->hidethemes ?>';
			document.querySelector('form[data-user="<?php echo pathinfo($us)['filename']; ?>"] select[name="hidebackup"]').value = '<?php echo $data->hidebackup ?>';
			document.querySelector('form[data-user="<?php echo pathinfo($us)['filename']; ?>"] select[name="hideplugin"]').value = '<?php echo $data->hideplugin ?>';
			document.querySelector('form[data-user="<?php echo pathinfo($us)['filename']; ?>"] select[name="hidesupport"]').value = '<?php echo $data->hidesupport ?>';
			document.querySelector('form[data-user="<?php echo pathinfo($us)['filename']; ?>"] select[name="hidesettings"]').value = '<?php echo $data->hidesettings ?>';
			document.querySelector('form[data-user="<?php echo pathinfo($us)['filename']; ?>"] select[name="hidei18n"]').value = '<?php echo $data->hidei18n ?>';
		</script>

		<?php endif;?>

	<?php endforeach; ?>

</div>

<script>
	document.querySelector('.hidecontent1').classList.add('hide');

	document.querySelector('#hidetitle1').addEventListener('click', () => {
		if (document.querySelector('.hidecontent1').classList.contains('hide') == true) {
			document.querySelector('.hidecontent1').classList.remove('hide');
		} else {
			document.querySelector('.hidecontent1').classList.add('hide');
		}
	});
</script>

<div class="hidetitle" id="hidetitle2">
	<h3><?php echo i18n_r('massiveAdmin/USERMANAGER'); ?></h3>

	<svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 24 24" id="arrow-down" style="display:inline-block;width:20px;">
		<path fill="var(--main-color)" d="M17.71,11.29a1,1,0,0,0-1.42,0L13,14.59V7a1,1,0,0,0-2,0v7.59l-3.29-3.3a1,1,0,0,0-1.42,1.42l5,5a1,1,0,0,0,.33.21.94.94,0,0,0,.76,0,1,1,0,0,0,.33-.21l5-5A1,1,0,0,0,17.71,11.29Z"></path>
	</svg>

</div>

<div class="hidecontent hidecontent2">
	<ul class="user-list">
		<?php
		global $MA;
		$MA->userList();; ?>
	</ul>

	<script>
		document.querySelector('.hidecontent2').classList.add('hide');

		document.querySelector('#hidetitle2').addEventListener('click', () => {
			if (document.querySelector('.hidecontent2').classList.contains('hide') == true) {
				document.querySelector('.hidecontent2').classList.remove('hide');
			} else {
				document.querySelector('.hidecontent2').classList.add('hide');
			}
		});

		document.body.setAttribute('data-nodelete', '<?php echo $_COOKIE['GS_ADMIN_USERNAME']; ?>');

		const nodelete = document.body.getAttribute('data-nodelete');

		document.querySelectorAll('.user-list li').forEach(x => {
			const name = x.querySelector('span').innerHTML;
			if (name === nodelete) {
				x.querySelector('.delete-this').remove();
			}
		})
	</script>
</div>

<?php
if (isset($_POST['submit'])) {
	global $MA;
	$MA->submitHideAdminSection();
};
?>