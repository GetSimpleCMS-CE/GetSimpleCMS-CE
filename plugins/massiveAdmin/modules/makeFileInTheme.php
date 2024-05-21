
<style>
	.makefile {
		width: 100%;
		padding: 10px;
		background: #fafafa;
		border: solid 1px #ddd;
		margin-bottom: 10px;
	}
	.main>form:nth-child(2) select {
		padding: 10px;
		width: 100% !important;
	}
	.main>form:nth-child(2) #theme_files {
		width: 100% !important;
	}
	#themefiles {
		width: 100%;
	}
	select {
		background: #fff;
		border-radius: 5px;
		border: solid 1px #ddd;
	}
	@media(min-width:968px) {
		.main>form:nth-child(2) input.submit {
			margin-left: -19px;
		}
		.themeSelector p {
			display: flex;
			flex-wrap: wrap;
			gap: 10px;
		}
		.makefile input {
			border-radius: 5px;
			border: solid 1px #ddd;
		}
		.makefile input:not(input[type="submit"]) {
			padding: 5px;

		}
		.makefile {
			display: grid;
			grid-template-columns: 1fr 1fr 1fr;
			gap: 10px;
		}
		.themeSelector p {
			width: 100% !important;
		}
		.themeSelector p select {
			width: 100% !important;
		}
	}
	.main>form:nth-child(2) {
		width: 100%;
		padding: 10px;
		background: #fafafa;
		border: solid 1px #ddd;
		margin-bottom: 10px;
	}
	.main>form>p {
		padding: 0;
		margin: 0;
	}
	@media(max-width:996px) {
		input,
		select {
			width: 100%;
			margin: 10px 0;
			padding: 10px;
			box-sizing: border-box;
		}
		.main>form:nth-child(2) input.submit {
			margin-left: 0;
		}
	}
</style>

<div class="makefile">
	<input type="hidden" name="themefolder" class="themefolder">
	<input type="text" name="foldername" placeholder="folder name (optional)">
	<input type="text" name="filename" placeholder="example.php ">
	<input type="submit" name="makefile" class="submit" value="<?php echo i18n_r('massiveAdmin/CREATENEWFILE'); ?>">
</div>

<script>
	document.querySelector('.main>form:nth-child(2)').classList.add('themeSelector');
	document.querySelector('.themefolder').value = document.querySelector('#theme-folder').value;
</script>

<?php if (isset($_POST['makefile'])) {

	if (isset($_POST['foldername'])) {

		if (!file_exists(GSTHEMESPATH . $_POST['themefolder'] . '/' . $_POST['foldername'])) {
			mkdir(GSTHEMESPATH . $_POST['themefolder'] . '/' . $_POST['foldername'], 0755);
		};

		if ($_POST['filename'] !== '') {
			file_put_contents(GSTHEMESPATH . $_POST['themefolder'] . '/' . $_POST['foldername'] . '/' . $_POST['filename'], '');
		};
	} else {
		file_put_contents(GSTHEMESPATH . $_POST['filename'], '');
	};

	echo '<div class="updated"><p>' . $_POST['filename'] . i18n_r('massiveAdmin/FILECREATED') . '</p></div>';
	echo ("<meta http-equiv='refresh' content='2'>");
}; ?>