<style>
	#imageTable tr td {
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
	}
	#imageTable .delconfirm {
		background: none;
		color: #111 !important;
		border: solid 1px #111;
		width: 100%;
		margin: 5px;
	}
	#imageTable .rename-massive-btn,
	#imageTable .copy-massive-btn,
	#imageTable .download-massive-btn {
		all: unset;
		background: none;
		color: #111 !important;
		border: solid 1px #111;
		width: 100%;
		margin: 5px;
		border-radius: 5px;
		padding: 3px;
		transition: all 250ms linear;
		cursor: pointer;
		font-size: 19px !important;
	}
	#imageTable .rename-massive-btn:hover,
	#imageTable .copy-massive-btn:hover,
	#imageTable .download-massive-btn:hover {
		background: #000 !important;
		color: #fff !important;
	}
	.rename-fog {
		position: fixed;
		top: 0;
		left: 0;
		z-index: 99;
		width: 100%;
		height: 100%;
		display: flex;
		align-items: center;
		justify-content: center;
		background: rgba(0, 0, 0, 0.3);
	}
	.form-rename {
		width: 300px;
		height: auto;
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		background: #fff;
		padding: 15px;
		padding-top: 40px;
		position: relative;
	}
	.form-rename input {
		width: 100%;
		padding: 15px;
		margin: 10px;
	}
	.form-rename .submit {
		width: 250px;
	}
	.form-rename input {
		width: 100%;
		padding: 15px;
		margin: 10px;
	}
	.hide-fog {
		display: none;
	}
	.close-rename-fog {
		background: #00162a;
		color: #fff;
		width: 250px;
		padding: 10px;
		border-radius: 5px;
		background: #D94136;
		border: none;
		transition: all 250ms linear;
	}
	.close-rename-fog:hover {
		background: #AA190F;
	}
	.massive-error {
		background: red;
		color: #fff;
		padding: 10px;
		margin: 10px 0;
		border-radius: 5px;
		display: block;
	}
	.massive-done {
		background: green;
		color: #fff;
		padding: 10px;
		margin: 10px 0;
		border-radius: 5px;
		display: block;
	}
	.All.folder tr td {
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		margin: 0;
		padding: 0;
		text-align: center !important;
		width: 100% !important;
		flex: 40px 1 0;
		border: none;
	}
	.massive-folder-linker {
		background: #00162a;
		width: 100%;
		height: 110px;
		display: flex;
		align-items: center;
		justify-content: center;
		transition: all 250ms linear;
	}
	.massive-folder-linker i {
		color: #fff;
	}
	.All .delete {
		display: flex !important;
		flex-direction: row !important;
	}
	.All.folder a:nth-child(2) {
		margin-top: 26px;
		margin-bottom: 10px;
	}
	#imageTable .delconfirm {
		background: none;
		color: #111 !important;
		border: solid 1px #111;
		width: 100%;
		margin: 5px;
		padding: 3px;
		display: block;
		padding: 3;
		padding: 3px;
		padding: 5px !important;
	}
	.All.folder:hover .massive-folder-linker {
		background: #000409;
	}
</style>

<div class="rename-fog hide-fog">
	<div class="form-rename">
		<form class="form-form-rename" action="#" method="post">
			<input type="text" name="rename-massive-hide" style="display:none">
			<input type="text" name="rename-massive">
			<input type="submit" name="save-rename-massive" class="submit" value="<?php echo i18n_r("massiveAdmin/RENAMEFILE"); ?>">
			<input type="submit" name="copy-rename-massive" class="submit" value="<?php echo i18n_r("massiveAdmin/COPYFILE"); ?>">
			<button class="close-rename-fog">
			
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="times"><path fill="#fff" d="M13.41,12l4.3-4.29a1,1,0,1,0-1.42-1.42L12,10.59,7.71,6.29A1,1,0,0,0,6.29,7.71L10.59,12l-4.3,4.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l4.29,4.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path></svg>	

			</button>
		</form>
	</div>
</div>

<script>
	if (window.location.href.indexOf('?type=carousel') < 0) {
		window.onload = function() {
			const imageTableTd = document.querySelectorAll('#imageTable .All');

			imageTableTd.forEach(e => {
				if (e.querySelector('.imgthumb img') !== null) {
					const name = e.querySelector('#imageTable .All .imgthumb img').getAttribute('src');
					console.log(name);

					if (e.querySelector('.delete .delconfirm') !== null) {
						const deleteBtn = e.querySelector('.delete .delconfirm');
						const renameBtn = document.createElement('button');
						renameBtn.classList.add('rename-massive-btn');
						renameBtn.innerHTML = "  <i class='uil uil-folder'></i>";
						deleteBtn.insertAdjacentElement('afterend', renameBtn);

						const copyBtn = document.createElement('button');
						copyBtn.classList.add('copy-massive-btn');
						copyBtn.innerHTML = "  <i class='uil uil-copy-alt'></i>";
						deleteBtn.insertAdjacentElement('afterend', copyBtn);

						const downloadBtn = document.createElement('a');
						downloadBtn.classList.add('download-massive-btn');
						downloadBtn.setAttribute('href', name);
						downloadBtn.setAttribute('download', name);
						downloadBtn.innerHTML = " <i class='uil uil-download-alt'></i>";
						deleteBtn.insertAdjacentElement('afterend', downloadBtn);

						renameBtn.addEventListener('click', () => {
							document.querySelector('.rename-fog').classList.remove('hide-fog');
							document.querySelector('input[name="rename-massive-hide"]').value = name.substr('16');
							document.querySelector('input[name="rename-massive"]').value = name.substr('16');
							document.querySelector('input[name="save-rename-massive"]').style.display = "block";
							document.querySelector('input[name="copy-rename-massive"]').style.display = "none";
						});

						copyBtn.addEventListener('click', () => {
							document.querySelector('.rename-fog').classList.remove('hide-fog');
							document.querySelector('input[name="rename-massive-hide"]').value = name.substr('16');
							document.querySelector('input[name="rename-massive"]').value = name.substr('16');
							document.querySelector('input[name="save-rename-massive"]').style.display = "none";
							document.querySelector('input[name="copy-rename-massive"]').style.display = "block";
						});

					};
				}
			});

			const closeRename = document.querySelector('.close-rename-fog');

			closeRename.addEventListener('click', (e) => {
				e.preventDefault();
				document.querySelector('.rename-fog').classList.add('hide-fog');
			});

		};

		if (document.querySelector('.All.folder') !== null) {
			document.querySelectorAll('.All.folder').forEach(e => {
				const linker = e.querySelector('a').getAttribute('href');
				e.querySelector('img').insertAdjacentHTML('beforebegin', `<a href="' + linker + '" class="massive-folder-linker">
				
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="folder" style="display:inline-block;width:50px;"><path fill="#fff" d="M19,5.5H12.72l-.32-1a3,3,0,0,0-2.84-2H5a3,3,0,0,0-3,3v13a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V8.5A3,3,0,0,0,19,5.5Zm1,13a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V5.5a1,1,0,0,1,1-1H9.56a1,1,0,0,1,.95.68l.54,1.64A1,1,0,0,0,12,7.5h7a1,1,0,0,1,1,1Z"></path></svg>
				</a>`);

				e.querySelector('img').remove();
				e.querySelector('.imgthumb').remove();
			});
		};
	};
</script>

<?php

	if (isset($_POST['save-rename-massive'])) {

		$oldDirMassive = '../data/uploads/' . $_POST['rename-massive-hide'];
		$newDirMassive = '../data/uploads/' . $_POST['rename-massive'];

		$afterNewDir = preg_replace('/\s+/', '-', $newDirMassive);

		rename($oldDirMassive, $afterNewDir);
		echo '<div class="massive-done">' . i18n_r("massiveAdmin/FILENOW") . $afterNewDir . '</div>';

		echo ("<meta http-equiv='refresh' content='1'>");
	}

	if (isset($_POST['copy-rename-massive'])) {
		$fileIsHere = i18n_r("massiveAdmin/INFOERROR");

		$oldDirMassive = '../data/uploads/' . $_POST['rename-massive-hide'];
		$newDirMassive = '../data/uploads/' . $_POST['rename-massive'];

		$afterNewDir = preg_replace('/\s+/', '-', $newDirMassive);

		if (file_exists($afterNewDir) == 'true') {
			echo '<div class="massive-error">' . $fileIsHere . '</div>';
		} else {
			copy($oldDirMassive, $afterNewDir);
			echo ("<meta http-equiv='refresh' content='1'>");
			echo '<div class="massive-done">' . i18n_r("massiveAdmin/INFOCOPY") . $afterNewDir . '</div>';
		}
	};
?>

<script>
	document.querySelectorAll('.imgthumb').forEach(x => {
		if (x.innerHTML == '') {
			x.innerHTML = `<div class="massive-folder-linker">
			
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="file" style="display:inline-block;width:50px;"><path fill="#6563FF" d="M20,8.94a1.31,1.31,0,0,0-.06-.27l0-.09a1.07,1.07,0,0,0-.19-.28h0l-6-6h0a1.07,1.07,0,0,0-.28-.19l-.09,0L13.06,2H7A3,3,0,0,0,4,5V19a3,3,0,0,0,3,3H17a3,3,0,0,0,3-3V9S20,9,20,8.94ZM14,5.41,16.59,8H14ZM18,19a1,1,0,0,1-1,1H7a1,1,0,0,1-1-1V5A1,1,0,0,1,7,4h5V9a1,1,0,0,0,1,1h5Z"></path></svg>
			
			
			</div>`;
		}
	});

	document.querySelectorAll('.all').forEach(c => {
		if (c.querySelector('.primarylink img') !== null) {
			c.querySelector('.primarylink img').style.display = "none";
		}
	})
</script>

<div style="width:100%;padding:5px;background:var(--main-color);margin-bottom:10px;">
	<form method="post">
		<textarea style="display:none;" class="delFileList" name="delFileList"></textarea>
		<button class="delOn" style="border:solid 1px #fff;margin: 6px 5px; background: rgba(0,0,0,0.8); 
		color: rgb(255, 255, 255);   border-radius: 5px; padding: 5px; cursor: pointer;">Delete Multiple Files</button>
		<button class="delAll" style="margin: 6px 5px; background: red; color: rgb(255, 255, 255); border: medium none; border-radius: 5px; padding: 5px; cursor: pointer;">Select All</button>
		<input type="submit" onclick="return confirm('Are you sure you want to delete this items?');" class="delNow" style="margin: 6px 5px; background: red; color: rgb(255, 255, 255); border: medium none; border-radius: 5px; padding: 5px; cursor: pointer;" name="deleteFileList" value="delete">
	</form>
</div>

<script>
	let delOn = document.querySelector('.delOn');
	let deleteOn = '';
	let indexDel = 0;

	let delAllBtn = document.querySelector('.delAll');
	let delNowBtn = document.querySelector('.delNow');

	delAllBtn.style.display = "none";
	delNowBtn.style.display = "none";

	delOn.addEventListener('click', e => {
		e.preventDefault();

		delAllBtn.style.display = "inline-block";
		delNowBtn.style.display = "inline-block";

		if (deleteOn == '') {
			document.querySelectorAll('.All').forEach((c, i) => {

				const value = c.querySelector('img').getAttribute('src');

				c.insertAdjacentHTML('afterbegin', `
<input type="checkbox" class="delCheck" onclick="addToTextarea(this)" data-index="${indexDel++}" data-value="${value.replace('../data/uploads/','')}" style="margin-bottom:5px;">
`);
			});
		};

		deleteOn = 'on';
	});
	
	const delArray = [];

	function addToTextarea(item) {
		if (item.checked == true) {
			delArray.push(item.getAttribute('data-value'));
			document.querySelector('.delFileList').innerHTML = delArray.toString();
		} else {
			delArray.splice(item.getAttribute('data-index'), 1);
			document.querySelector('.delFileList').innerHTML = delArray.toString();
		}
	}

	document.querySelector('.delAll').addEventListener('click', (c) => {
		c.preventDefault();
		document.querySelectorAll('.delCheck').forEach(v => {
			v.checked = true;
			if (v.checked == true) {
				delArray.push(v.getAttribute('data-value'));
				document.querySelector('.delFileList').innerHTML = delArray.toString();
			}
		})
	})
</script>

<?php

if (isset($_POST['deleteFileList'])) {
	$list = $_POST['delFileList'];
	$ar = explode(",", $list);
	foreach ($ar as $key => $value) {
		unlink(GSDATAUPLOADPATH . $value);
		echo ("
		<meta http-equiv='refresh' content='1'>");
	}
};

?>