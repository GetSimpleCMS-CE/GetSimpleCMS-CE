<link rel="stylesheet" href="<?php global $SITEURL; echo $SITEURL; ?>plugins/massiveAdmin/css/w3.css">
<link rel="stylesheet" href="<?php global $SITEURL; echo $SITEURL; ?>plugins/massiveAdmin/css/w3-custom.css">
<style>.w3-ul li:nth-child(odd) {background: #F3F3F3;}</style>

<div class="w3-parent w3-container"><!-- Start Plug -->

<h3>Backup creator</h3>
<hr>
<div class="w3-parent w3-container">
	<form action="#" method="post">
		<select class="w3-select w3-padding w3-margin-bottom w3-border w3-round" name="folder" id="" xstyle="width:100%;padding:10px;margin-bottom:10px;background:#fff;border:solid 1px #ddd;">
			<option value="<?php echo GSPLUGINPATH; ?>">Plugins folder</option>
			<option value="<?php echo GSADMINPATH; ?>">Admin folder</option>
			<option value="<?php echo GSDATAPATH; ?>">Data folder</option>
			<option value="<?php echo GSTHEMESPATH; ?>">Themes folder</option>
			<option value="<?php echo GSDATAUPLOADPATH; ?>">Uploads folder</option>
		</select>
		
		<div class="w3-margin-top w3-center">
			<button class="w3-btn w3-large w3-round w3-green" type="submit" name="backupcreate"><?php echo i18n_r('massiveAdmin/CREATEBACKUP'); ?></button>
		</div>
	</form>
</div>

<div class="w3-container w3-margin-top">
<hr>
<?php
	echo '
	<ul class="w3-ul w3-hoverable w3-margin-top">';

	foreach (glob(GSBACKUPSPATH . 'backupCreator/*.*') as $zip) {
		global $SITEURL;
		global $GSADMIN;

		$domainurl = $SITEURL . 'backups/backupCreator/' . pathinfo($zip)['basename'];
		$url = GSBACKUPSPATH . 'backupCreator/' . pathinfo($zip)['basename'];
		$name =   pathinfo($zip)['filename'] . '.zip';

		echo '
		<li>
			<div class="w3-row">
				<div class="w3-half">
					<svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;" width="18px" height="18px" viewBox="0 0 24 24"><path fill="#E2990C" d="M16 16h2v-2h-2v-2h2v-2h-2V8h4v10h-4zm0 0h-2v2H4V6h5.17l2 2H14v2h2v2h-2v2h2z" opacity="0.3"></path><path fill="#E2990C" d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2m-4 10h2v-2h-2v-2h2v-2h-2V8h4v10h-4zm0 0h-2v2H4V6h5.17l2 2H14v2h2v2h-2v2h2z"></path></svg> 
					<a style="text-decoration:none;" href="'.$domainurl.'" download>'. $name.'</a> 
				</div>
				<div class="w3-rest w3-right-align">
					<form method="post"><input type="hidden" name="delbackup" value="'.$url.'">
						<button class="delbackupbtn w3-bar-item w3-btn w3-red w3-round w3-right" style="padding:0 5px;" type="submit">
							<svg xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24" id="trash"><path fill="#fff" d="M20,6H16V5a3,3,0,0,0-3-3H11A3,3,0,0,0,8,5V6H4A1,1,0,0,0,4,8H5V19a3,3,0,0,0,3,3h8a3,3,0,0,0,3-3V8h1a1,1,0,0,0,0-2ZM10,5a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1V6H10Zm7,14a1,1,0,0,1-1,1H8a1,1,0,0,1-1-1V8H17Z"></path></svg>
						</button>
					</form>
				</div>
			</div>
		</li>';
	};

	echo '
	</ul>';
?>
</div>

<?php
	global $MA;
	if (isset($_POST['backupcreate'])) {
		$MA->createBackupZip();
	};
	if (isset($_POST['delbackup'])) {
		$MA->deleteBackupZip();
	}; 
?>