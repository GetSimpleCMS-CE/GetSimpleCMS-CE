<?php

#snippet functions

function get_snippet($item)
{
    $file = GSDATAOTHERPATH . 'snippetMassive/snippet.xml';
    $readed = simplexml_load_file($file);
    echo htmlspecialchars_decode($readed->$item->content);
};

#themeSettings function
function mats($field)
{

    $xml = simplexml_load_file(GSDATAOTHERPATH . 'website.xml');

    $activeTemplate = $xml->TEMPLATE;

    if (file_exists(GSTHEMESPATH . $activeTemplate . '/settings.json')) {
        $data = file_get_contents(GSTHEMESPATH . $activeTemplate . '/settings.json');
        $filx = json_decode($data);
        if ($filx->settings->$field->type !== 'wysywig') {
            echo $filx->settings->$field->value;
        } else {
            echo html_entity_decode($filx->settings->$field->value);
        }
    } else {
        echo i18n_r('massiveAdmin/NOSETTINGSCREATED');
    }
};

function r_mats($field)
{
    $xml = simplexml_load_file(GSDATAOTHERPATH . 'website.xml');
    $activeTemplate = $xml->TEMPLATE;
    if (file_exists(GSTHEMESPATH . $activeTemplate . '/settings.json')) {
        $data = file_get_contents(GSTHEMESPATH . $activeTemplate . '/settings.json');
        $filx = json_decode($data);
        if ($filx->settings->$field->type !== 'wysywig') {
            return $filx->settings->$field->value;
        } else {
            return html_entity_decode($filx->settings->$field->value);
        }
    } else {
        echo i18n_r('massiveAdmin/NOSETTINGSCREATED');
    }
};

# massive Maintence on frontened
function massivemaintence()
{
	include(GSPLUGINPATH . 'massiveAdmin/inc/maintenceFront.inc.php');
};

?>