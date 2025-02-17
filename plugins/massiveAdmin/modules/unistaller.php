<link rel="stylesheet" href="<?php global $SITEURL; echo $SITEURL; ?>plugins/massiveAdmin/css/w3.css">
<link rel="stylesheet" href="<?php global $SITEURL; echo $SITEURL; ?>plugins/massiveAdmin/css/w3-custom.css">
<style>
.w3-ul{margin-left:0!important}
p.w3-bar-item {font-weight:600;}
.w3-ul li:nth-child(odd) {background: #F3F3F3;}
</style>
  
<div class="w3-parent w3-container"><!-- Start Plug -->

<h3><?php echo i18n_r('massiveAdmin/UNISTALLER');?></h3>
<hr>
<div class="w3-container">
	<ul class="w3-ul w3-hoverable">
		<?php 
			global $GSADMIN;
			global $SITEURL;
			$url =  $SITEURL.$GSADMIN.'/load.php?id=massiveAdmin&unistaller';

			foreach( glob(GSPLUGINPATH.'*.php') as $file) {

			$filename = pathinfo($file)['filename'];
				echo '
		<li class="w3-bar">
			<p class="w3-bar-item" style="padding-bottom:0">'.$filename.'</p>
			<a href="'.$url.'&delPlugin='.$filename.'" title="'.i18n_r('ASK_DELETE').'" onclick="return confirm(`'.i18n_r('massiveAdmin/UNISTALLQUESTION').' '.$filename.'?`);" class="w3-bar-item w3-btn w3-red w3-round w3-right" style="margin-top:5px; padding: 2px 5px;"><svg xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24" id="trash"><path fill="#fff" d="M20,6H16V5a3,3,0,0,0-3-3H11A3,3,0,0,0,8,5V6H4A1,1,0,0,0,4,8H5V19a3,3,0,0,0,3,3h8a3,3,0,0,0,3-3V8h1a1,1,0,0,0,0-2ZM10,5a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1V6H10Zm7,14a1,1,0,0,1-1,1H8a1,1,0,0,1-1-1V8H17Z"></path></svg></a>
		</li>';
			};
		?>
	</ul>
</div>
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
	hideListItemsContainingWords(['&delPlugin=massiveAdmin', '&delPlugin=modernScript', '&delPlugin=UpdateCE', '&delPlugin=gsconfigGUI']);
</script>

<?php
if(isset($_GET['delPlugin'])){
    global $MA;
    $MA->unistaller();
};
?>
