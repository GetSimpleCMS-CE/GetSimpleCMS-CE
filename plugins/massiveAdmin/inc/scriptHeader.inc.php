<?php
global $SITEURL;
$themeChecker = @file_get_contents(GSDATAOTHERPATH . 'massiveTheme/option.txt') ? file_get_contents(GSDATAOTHERPATH . 'massiveTheme/option.txt') : 'massive';

echo '<link rel="stylesheet" href="' . $SITEURL . 'plugins/massiveAdmin/theme/' . $themeChecker . '.css?v=10">';

echo '
<svg xmlns="http://www.w3.org/2000/svg" style="width:80px;margin-bottom:10px;" data-name="Layer 1" viewBox="0 0 24 24" id="user-circle"><path fill="var(--main-color)" d="M12,2A10,10,0,0,0,4.65,18.76h0a10,10,0,0,0,14.7,0h0A10,10,0,0,0,12,2Zm0,18a8,8,0,0,1-5.55-2.25,6,6,0,0,1,11.1,0A8,8,0,0,1,12,20ZM10,10a2,2,0,1,1,2,2A2,2,0,0,1,10,10Zm8.91,6A8,8,0,0,0,15,12.62a4,4,0,1,0-6,0A8,8,0,0,0,5.09,16,7.92,7.92,0,0,1,4,12a8,8,0,0,1,16,0A7.92,7.92,0,0,1,18.91,16Z"></path></svg>';
echo ' <meta name="viewport" content="width=device-width, initial-scale=1.0">';;
