<?php

	/** grab user data */
	if (isset($_COOKIE['GS_ADMIN_USERNAME'])) {
		$cookie_user_id = _id($_COOKIE['GS_ADMIN_USERNAME']);
		if (file_exists(GSUSERSPATH . $cookie_user_id . '.xml')) {
			$datau = getXML(GSUSERSPATH  . $cookie_user_id . '.xml');
			$USR = stripslashes($datau->USR);
			$HTMLEDITOR = $datau->HTMLEDITOR;
			$TIMEZONE = $datau->TIMEZONE;
			$LANG = $datau->LANG;
		} else {
			$USR = null;
		}
	} else {

		$filename = GSDATAOTHERPATH . '/massiveadmin/massiveOption.json';
		$datee = file_get_contents($filename);
		$data = json_decode($datee);

		if (file_exists($filename)) {
			if ($data->maintence == 'yes') {
				echo '
				<script>
					window.onload = ()=>{
						document.getElementsByTagName("body")[0].innerHTML = `<div class="maintenceOn" style=" position:fixed;
						top:0;
						left:0;
						width:100%;
						height:100vh;
						display:flex;
						align-items:center;
						justify-content:center;
						background:#fff;
						z-index:99999999999999;"><span style="font-size:2rem;
						color:#111;
						text-align:center;">' . $data->maintencecontent  . '</span></div>`;
					};
				</script>
				';
			};
		};
};