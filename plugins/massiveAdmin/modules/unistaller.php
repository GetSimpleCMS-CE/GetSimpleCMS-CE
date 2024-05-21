<h3><?php echo i18n_r('massiveAdmin/UNISTALLER');?></h3>

<style>
	.plugin-uni{
		display:grid;
		list-style-type: none;
		margin: 0 !important;
		padding: 0 !important;
		width:100%;
		box-sizing: border-box;
	}
	.plugin-uni li{
		display:flex;
		padding: 10px;
		justify-content: space-between;
		box-sizing: border-box;
		align-items: center;
		border-bottom: solid 1px #ddd !important;
	}
	.plugin-uni li:nth-child(2n){
		background: #fafafa;
	}
	.plugin-uni a{
		background: red;
		color:#fff !important;
		text-decoration: none !important;
		padding:10px;
	}
</style>

<ul class="plugin-uni">
<?php 
	global $GSADMIN;
	global $SITEURL;
	$url =  $SITEURL.$GSADMIN.'/load.php?id=massiveAdmin&unistaller';

	foreach( glob(GSPLUGINPATH.'*.php') as $file) {

	$filename = pathinfo($file)['filename'];
		echo '
		<li>
			<p>'.$filename.'</p>
			<a href="'.$url.'&delPlugin='.$filename.'" onclick="return confirm(`'.i18n_r('massiveAdmin/UNISTALLQUESTION').' '.$filename.'?`);">'.i18n_r('ASK_DELETE').'</a>
		</li>';
	};
?>
</ul>

<script>
	// Function to hide <li> elements containing any of the specified words
	function hideListItemsContainingWords(words) {
		var listItems = document.querySelectorAll('li');
		
		listItems.forEach(function(item) {
			var link = item.querySelector('a');
			if (link) {
				for (var i = 0; i < words.length; i++) {
					if (link.href.indexOf(words[i]) !== -1) {
						item.style.display = 'none';
						break;
					}
				}
			}
		});
	}

	hideListItemsContainingWords(['&delPlugin=massiveAdmin', '&delPlugin=modernScript']);
</script>

<?php if(isset($_GET['delPlugin'])){
    global $MA;
    $MA->unistaller();
};?>