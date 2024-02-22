<?php
global $USR;

$massiveHiddenSection = GSDATAOTHERPATH . '/massiveHiddenSection/';
$filejson = $USR . '.json';
$finaljson = $massiveHiddenSection . $filejson;


if (!file_exists($massiveHiddenSection)) {
    mkdir($massiveHiddenSection, 0755);
    file_put_contents($finaljson, '');
};

$datee = @file_get_contents($finaljson);
$data = json_decode($datee);


?>

<script>
    document.body.setAttribute('data-login', '<?php echo $_COOKIE['GS_ADMIN_USERNAME']; ?>');

 
 


    if (document.querySelector("#nav_pages") !== null) {
        if ("<?php if (isset($data->hidepages)) {
                    echo $data->hidepages;
                }; ?>" == "hide") {
            document.querySelector("#nav_pages").remove()
        };
    };

    if (document.querySelector("#nav_upload") !== null) {
        if ("<?php if (isset($data->hidefiles)) {
                    echo $data->hidefiles;
                }; ?>" == "hide") {
            document.querySelector("#nav_upload").remove()
        };
    };

    if (document.querySelector("#nav_theme") !== null) {
        if ("<?php if (isset($data->hidethemes)) {
                    echo $data->hidethemes;
                }; ?>" == "hide") {
            document.querySelector("#nav_theme").remove()
        };
    };

    if (document.querySelector("#nav_plugins") !== null) {
        if ("<?php if (isset($data->hideplugin)) {
                    echo $data->hideplugin;
                }; ?>" == "hide") {
            document.querySelector("#nav_plugins").remove()
        };
    };


    if (document.querySelector("#nav_backups") !== null) {
        if ("<?php if (isset($data->hidebackup)) {
                    echo $data->hidebackup;
                } ?>" == "hide") {
            document.querySelector("#nav_backups").remove()
        };
    };


    if (document.querySelector("#nav_i18n_gallery") !== null) {
        if ("<?php if (isset($data->hidei18n)) {
                    echo $data->hidei18n;
                }; ?>" == "hide") {
            document.querySelector("#nav_i18n_gallery").remove()
        };
    };

    if (document.querySelector(".support") !== null) {
        if ("<?php if (isset($data->hidesupport)) {
                    echo $data->hidesupport;
                }; ?>" == "hide") {
            document.querySelector(".support").remove()
        };
    };

    if (document.querySelector('#sb_massiveAdmin') !== null) {
        if ("<?php if (isset($data->hidesettings)) {
                    echo $data->hidesettings;
                }; ?>" == "hide") {

            if (document.querySelector('#pages') == null) {
                document.querySelectorAll(' .snav #sb_massiveAdmin').forEach(x => {
                    x.remove();
                });
            };

        };
    };

    if (document.querySelector(`a[href="settings.php#profile"]`) !== null) {
        if ("<?php if (isset($data->hidesettings)) {
                    echo $data->hidesettings;
                }; ?>" == "hide") {
            document.querySelector('a[href="settings.php#profile"]').remove()
        };
    };
</script>