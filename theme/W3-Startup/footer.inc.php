<?php if (!defined('IN_GS')) {
    die('you cannot load this page directly.');
}
/****************************************************
 *
 * @File: 		footer.inc.php
 * @Package:	W3 Startup
 * @Action:		W3 Startup for GetSimple CMS CE
 *
 *****************************************************/
?>

<!-- Footer -->
<footer class="w3-center w3-black w3-padding-64">
	<a href="#home" class="w3-button w3-light-grey"><i class="fa fa-arrow-up w3-margin-right"></i>To the top</a>
	<div class="w3-xlarge w3-section">
		<i class="fa-brands fa-square-facebook w3-hover-opacity"></i>
		<i class="fa-brands fa-instagram w3-hover-opacity"></i>
		<i class="fa-brands fa-square-snapchat w3-hover-opacity"></i>
		<i class="fa-brands fa-pinterest-p w3-hover-opacity"></i>
		<i class="fa-brands fa-twitter w3-hover-opacity"></i>
		<i class="fa-brands fa-linkedin w3-hover-opacity"></i>
	</div>
	<p>Powered by <a href="https://getsimple-ce.ovh/" title="W3.CSS" target="_blank" class="w3-hover-text-green"><?php echo $site_full_name; ?> v<?php echo get_site_version(); ?></a> & <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-text-green">w3.css</a></p>
</footer>
 
<script>
	// Modal Image Gallery
	function onClick(element) {
	  document.getElementById("img01").src = element.src;
	  document.getElementById("modal01").style.display = "block";
	  var captionText = document.getElementById("caption");
	  captionText.innerHTML = element.alt;
	}

	// Toggle between showing and hiding the sidebar when clicking the menu icon
	var mySidebar = document.getElementById("mySidebar");

	function w3_open() {
	  if (mySidebar.style.display === 'block') {
		mySidebar.style.display = 'none';
	  } else {
		mySidebar.style.display = 'block';
	  }
	}

	// Close the sidebar with the close button
	function w3_close() {
		mySidebar.style.display = "none";
	}
</script>

<?php get_footer(); ?> <!-- ## required in all themes ##-->
