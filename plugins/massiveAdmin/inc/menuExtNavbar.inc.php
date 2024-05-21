<?php

$folder        = GSDATAOTHERPATH . '/massiveMenuExt/';
$filename      = $folder . 'menuext.json';
$chmod_mode    = 0755;
$folder_exists = file_exists($folder) || mkdir($folder, $chmod_mode);
$datee = @file_get_contents($filename);
$data = json_decode($datee, true);

if (file_exists($filename)) {

    foreach ($data as $query) {

        echo '<li><a href="' . $query["url"] . '" target="' . $query["linkblank"] . '">

<i class="gg-add "></i>
' . $query["name"] . '</a></li>';
    };
};;