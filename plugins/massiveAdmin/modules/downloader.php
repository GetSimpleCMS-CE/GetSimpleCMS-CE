<link rel="stylesheet" href="<?php global $SITEURL; echo $SITEURL; ?>plugins/massiveAdmin/css/w3.css">
<link rel="stylesheet" href="<?php global $SITEURL; echo $SITEURL; ?>plugins/massiveAdmin/css/w3-custom.css">
<style>
	.wrapper a:link, .wrapper .w3-bar-item a:visited {text-decoration: none;}
	.scroll{overflow-y: auto; height: 600px;}
	.info{height:60px;}
	
	.w3-main{display: table;}
	.w3-third .w3-row{height:35px}
	.w3-third .w3-row a{color:#CF3805}
	.w3-third{box-sizing:border-box; display: table-cell;}
	.w3-input{height:25px; width:98%; margin-bottom:30px}
</style>
  
<div class="w3-parent w3-container"><!-- Start Plug -->

	<h3>Plugin Downloader</h3>
	<p><a href="https://getsimple-ce.ovh/ce-plugins/" target="_blank"><?php echo i18n_r('massiveAdmin/DOWNLOADERBASED'); ?> <svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle" width="1.2em" height="1.2em" viewBox="0 0 32 32"><g fill="black"><path d="M27.527 4.318c-3.09-3.09-8.12-3.09-11.21 0l-4 4c-.227.23-.437.47-.63.72a9.1 9.1 0 0 1 3.84-.131c.258.045.515.102.77.17l.009.062l2.421-2.421a4.52 4.52 0 0 1 6.4 0c1.76 1.77 1.77 4.64 0 6.4l-4 4c-.76.76-1.73 1.17-2.72 1.28c-1.31.14-2.68-.27-3.68-1.28a4.493 4.493 0 0 1-1.24-2.417a3.253 3.253 0 0 0-1.886.91l-1.086 1.087a7.858 7.858 0 0 0 1.812 2.82a7.859 7.859 0 0 0 4.21 2.19a7.99 7.99 0 0 0 7-2.2l4-4c3.08-3.07 3.08-8.1-.01-11.19"/><path d="M19.528 23.538c.233-.237.449-.485.646-.742a9.254 9.254 0 0 1-3.851.143h-.001a9.123 9.123 0 0 1-.83-.186l-2.375 2.375a4.52 4.52 0 0 1-6.4 0a4.52 4.52 0 0 1 0-6.4l4-4c.76-.76 1.73-1.17 2.72-1.28c1.31-.14 2.68.27 3.68 1.28a4.493 4.493 0 0 1 1.242 2.416a3.254 3.254 0 0 0 1.885-.91l1.086-1.087a7.856 7.856 0 0 0-1.812-2.82a7.859 7.859 0 0 0-4.21-2.19a7.88 7.88 0 0 0-4.61.56c-.86.38-1.67.92-2.38 1.63l-4 4c-3.09 3.09-3.09 8.12 0 11.21c3.09 3.09 8.12 3.09 11.21 0z"/></g></svg></a></p>

	<hr>

	<input type="text" id="search-plugins" class="w3-input w3-border w3-round" placeholder="🔎 <?php echo i18n_r('massiveAdmin/SEARCHPLUGIN'); ?> ">
	<?php
	global $GSADMIN;

	$db = file_get_contents('https://getsimplecms-ce-plugins.github.io/db.json');
	$jsondb = json_decode($db);

	global $SITEURL;

	echo '
	<div class="scroll">
		<div class="w3-main">';

	foreach ($jsondb as $key => $value) {
		echo '
			<div class="w3-third w3-margin-bottom w3-row-padding ce-plugin">
				<div class="w3-light-grey w3-padding-small w3-round w3-border" style="min-width:285px">
					<h4 class="title w3-gs-main w3-round w3-padding-small s-name" style="height:35px;overflow-y:hidden">' . $value->name . '</h4>
					<p class="info s-info">' . $value->info . '</p>
					
					<hr>
					
					<div class="w3-row">
						 <div class="w3-third w3-center w3-text-gs-main s-tags" data-tags="' . htmlspecialchars($value->tags) . '"><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="black" d="M19 21q-.975 0-1.75-.562T16.175 19H11q-1.65 0-2.825-1.175T7 15t1.175-2.825T11 11h2q.825 0 1.413-.587T15 9t-.587-1.412T13 7H7.825q-.325.875-1.088 1.438T5 9q-1.25 0-2.125-.875T2 6t.875-2.125T5 3q.975 0 1.738.563T7.825 5H13q1.65 0 2.825 1.175T17 9t-1.175 2.825T13 13h-2q-.825 0-1.412.588T9 15t.588 1.413T11 17h5.175q.325-.875 1.088-1.437T19 15q1.25 0 2.125.875T22 18t-.875 2.125T19 21M5 7q.425 0 .713-.288T6 6t-.288-.712T5 5t-.712.288T4 6t.288.713T5 7"/></svg> <a href="' . $value->repo . '" target="_blank">' . $value->version . '</a></div>
						
						<div class="w3-third w3-center w3-text-gs-main s-author"><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="black" d="m21.7 13.35l-1 1l-2.05-2.05l1-1a.55.55 0 0 1 .77 0l1.28 1.28c.21.21.21.56 0 .77M12 18.94l6.06-6.06l2.05 2.05L14.06 21H12zM12 14c-4.42 0-8 1.79-8 4v2h6v-1.89l4-4c-.66-.08-1.33-.11-2-.11m0-10a4 4 0 0 0-4 4a4 4 0 0 0 4 4a4 4 0 0 0 4-4a4 4 0 0 0-4-4"/></svg> <b>' . $value->author . '</b></div>';
						
						if (!empty($value->wiki)) { echo '
						<div class="w3-third w3-center w3-text-gs-main"><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle" width="1.5em" height="1.5em" viewBox="0 0 512 512"><rect width="512" height="512" fill="none"/><path fill="#000" d="M202.24 74C166.11 56.75 115.61 48.3 48 48a31.36 31.36 0 0 0-17.92 5.33A32 32 0 0 0 16 79.9V366c0 19.34 13.76 33.93 32 33.93c71.07 0 142.36 6.64 185.06 47a4.11 4.11 0 0 0 6.94-3V106.82a15.9 15.9 0 0 0-5.46-12A143 143 0 0 0 202.24 74m279.68-20.7A31.33 31.33 0 0 0 464 48c-67.61.3-118.11 8.71-154.24 26a143.3 143.3 0 0 0-32.31 20.78a15.93 15.93 0 0 0-5.45 12v337.13a3.93 3.93 0 0 0 6.68 2.81c25.67-25.5 70.72-46.82 185.36-46.81a32 32 0 0 0 32-32v-288a32 32 0 0 0-14.12-26.61"/></svg> <a href="' . $value->wiki . '" target="_blank">Wiki</a></div>';
						} echo '
					</div>
					
					<form action="#" method="POST" class="w3-center" style="margin:10px 0">
						<input type="hidden" name="url" value="' . $value->url . '">
						<button type="submit" name="download" class="w3-btn w3-green w3-round w3-center download" value="' . i18n_r('massiveAdmin/DOWNLOAD') . '">' . i18n_r('massiveAdmin/DOWNLOAD') . '</button>
					</form>
				</div>
			</div>
		';
	}

	echo '
		</div>
	</div>'; ?>

	<?php
	if (isset($_POST['download'])) {
		global $MA;
		$MA->downloadPlugin();
	};
	?>

	<script>
	document.getElementById('search-plugins').addEventListener('input', function() {
		const query = this.value.toLowerCase();
		const plugins = document.querySelectorAll('.ce-plugin');

		plugins.forEach(plugin => {
			const name = plugin.querySelector('.s-name').textContent.toLowerCase();
			const info = plugin.querySelector('.s-info').textContent.toLowerCase();
			const author = plugin.querySelector('.s-author').textContent.toLowerCase();
			const tags = plugin.querySelector('.s-tags').dataset.tags.toLowerCase();

			if (tags.includes(query) || name.includes(query) || info.includes(query) || author.includes(query)) {
				plugin.style.display = ''; // Show the plugin
			} else {
				plugin.style.display = 'none'; // Hide the plugin
			}
		});
	});
	</script>