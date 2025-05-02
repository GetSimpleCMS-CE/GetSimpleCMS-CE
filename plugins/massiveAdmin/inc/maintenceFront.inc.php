<?php
/** grab user data */
if (isset($_COOKIE['GS_ADMIN_USERNAME'])) {
    $cookie_user_id = _id($_COOKIE['GS_ADMIN_USERNAME']);
    if (file_exists(GSUSERSPATH . $cookie_user_id . '.xml')) {
        $datau = getXML(GSUSERSPATH . $cookie_user_id . '.xml');
        $USR = stripslashes($datau->USR);
        $HTMLEDITOR = $datau->HTMLEDITOR;
        $TIMEZONE = $datau->TIMEZONE;
        $LANG = $datau->LANG;
    } else {
        $USR = null;
    }
} else {
    $filename = GSDATAOTHERPATH . '/massiveadmin/massiveOption.json';
    if (file_exists($filename)) {
        $datee = @file_get_contents($filename);
        $data = json_decode($datee);
        
        if ($data->maintence === 'yes') {
            // Output maintenance page directly
            echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background: #fff;
            font-family: Arial, sans-serif;
			overflow:hidden;
        }
        .maintenceOn {
            font-size: 2rem;
            color: #111;
            text-align: center;
            padding: 20px;
			position:fixed;
			top:0;
			left:0;
			z-index:99999;
			background:#fff;
			display:flex;
			align-items:center;
			justify-content:center;
			height:100vh;
			width:100%;
        }
    </style>
</head>
<body>
    <div class="maintenceOn"><div class="content">' . $data->maintencecontent . '</div></div>
</body>
</html>';
            exit; // Stop further execution
        }
    }
}
?>