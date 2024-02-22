<style>
	@import url("<?php global $SITEURL;
					echo $SITEURL . 'plugins/massiveAdmin/css/downloader.css'; ?>");
</style>

<h3 style="margin-bottom:0;">Plugin Downloader</h3>
<a href="https://getsimplecms-ce-plugins.github.io/" target="_blank" style="margin-bottom:20px;margin-top:10px;display:block;"><?php echo i18n_r('massiveAdmin/DOWNLOADERBASED'); ?></a>

<input type="text" class="searchce" placeholder="<?php echo i18n_r('massiveAdmin/SEARCHPLUGIN'); ?>">
<?php
global $GSADMIN;

$db = file_get_contents('https://getsimplecms-ce-plugins.github.io/db.json');
$jsondb = json_decode($db);

global $SITEURL;

echo '<ul class="db-list">';

foreach ($jsondb as $key => $value) {
	echo '
	<li><b class="title">' . $value->name . '</b>
		<p class="info">' . $value->info . '</p>
		<hr>
		<p class="version"><b>Version:</b> ' . $value->version . '</p>
		<p class="author">' . $value->author . '</p>
		<form action="#" method="POST">
			<input type="hidden" name="url" value="' . $value->url . '">
			<input type="submit" name="download" class="download" value="' . i18n_r('massiveAdmin/DOWNLOAD') . '">
		</form>
	</li>
	';
}

echo '</ul>'; ?>

<?php
if (isset($_POST['download'])) {
	global $MA;
	$MA->downloadPlugin();
};
?>

<script>
	document.querySelector('.searchce').addEventListener('keyup', (e) => {
		document.querySelectorAll('.db-list li').forEach(
			x => {
				x.style.display = "none";
			}
		);

		document.querySelectorAll('.db-list li').forEach(c => {
			if (c.querySelector('.title').innerHTML.toLowerCase().indexOf(document.querySelector('.searchce').value.toLowerCase()) > -1) {
				c.style.display = "block";
			}
		})
	});
</script>