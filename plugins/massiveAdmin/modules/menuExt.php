<?php
$folder		= GSDATAOTHERPATH . 'massiveMenuExt/';
$filename	  = $folder . 'menuext.json';
$chmod_mode	= 0755;
$folder_exists = file_exists($folder) || mkdir($folder, $chmod_mode);
$daterJson = @file_get_contents($filename);
$daterJsonNew = json_encode($daterJson);
?>

<style>
	.form-menuext {
		width: 100%;
		display: flex;
		flex-direction: column;
		grid-gap: 10px;
		border: solid 1px #ddd;
		background: #fafafa;
		padding: 15px;
		margin-top: 10px;
	}
	.form-menuext input,
	select {
		width: 100%;
		padding: 5px;
		margin-top: 10px;
	}
	.newlink-menu {
		list-style-type: none;
		margin: 0 !important;
		padding: 0;
		border: solid 1px #ddd;
		background: #fafafa;
	}
	.newlink-menu li {
		padding: 15px;
		display: flex;
		align-items: center;
		justify-content: space-between;
		flex-wrap: wrap;
	}
	.newlink-menu li:nth-child(2n) {
		background: #ddd;
	}
	#unicons {
		display: grid;
		grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr;
		align-items: center;
		height: 300px;
		overflow-y: scroll;
	}
	#unicons input[type="checkbox"] {
		margin: 0;
		padding: 0;
		all: revert;
	}
	#unicons .uil {
		font-size: 1.2rem;
	}
</style>

<h3><?php echo i18n_r('massiveAdmin/MENUEXTERNAL'); ?></h3>

<ul class="newlink-menu">
	<?php
	$datee = @file_get_contents($filename);
	$data = json_decode($datee, true);

	if (file_exists($filename)) {
		foreach ($data as $query) {
			$oldname = $query["name"];
			$newname = str_replace(" ", "", $query["name"]);
			$newnamenew = strtolower($newname);
			echo '
			<li>
				<a href="' . $query["url"] . '">' . $query["name"] . '</a> <form action="#" method="POST"><button name="' . $newnamenew . '" style="background:red;border:none;color:#fff;font-size:1.2rem">
				<svg xmlns="http://www.w3.org/2000/svg" style="display:inline-block;width:20px;height:20px;" viewBox="0 0 24 24" id="trash"><path fill="#fff" d="M20,6H16V5a3,3,0,0,0-3-3H11A3,3,0,0,0,8,5V6H4A1,1,0,0,0,4,8H5V19a3,3,0,0,0,3,3h8a3,3,0,0,0,3-3V8h1a1,1,0,0,0,0-2ZM10,5a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1V6H10Zm7,14a1,1,0,0,1-1,1H8a1,1,0,0,1-1-1V8H17Z"></path></svg></button></form>
			</li>
			';
			if (isset($_POST[$newnamenew])) {
				$datee = file_get_contents($filename);
				$data = json_decode($datee, true);
				unset($data[$oldname]);
				$datee = json_encode($data);
				file_put_contents($filename, $datee);
				echo ("<meta http-equiv='refresh' content='0'>");
			};
		};
	}; ?>
</ul>

<form action="#" method="POST" class="form-menuext">
	<div>
		<label for=""><?php echo i18n_r('massiveAdmin/LINKNAME'); ?></label>
		<input type="text" name="linkname" required>
	</div>

	<div>
		<label for=""><?php echo i18n_r('massiveAdmin/LINKURL'); ?></label>
		<input type="text" name="linkurl" required>
	</div>

	<div>
		<label for=""><?php echo i18n_r('massiveAdmin/NEWWINDOW'); ?></label>
		<select name="linkblank">
			<option value="_self"><?php echo i18n_r('massiveAdmin/NO'); ?></option>
			<option value="_blank"><?php echo i18n_r('massiveAdmin/YES'); ?></option>
		</select>
	</div>

	<div class="buttons-save">
		<input type="submit" style="width: 100%; padding: 10px; margin-top: 20px; background: #000; color: #fff; border: none; border-radius: 5px;" name="addnew" value="<?php echo i18n_r('massiveAdmin/ADDLINK'); ?>">
	</div>
</form>

<?php
if (isset($_POST['addnew'])) {
	global $MA;
	global $folder_exists;
	$MA->createLinkMenuExt();
};
?>