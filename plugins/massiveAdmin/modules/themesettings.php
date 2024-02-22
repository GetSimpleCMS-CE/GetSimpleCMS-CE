<h3>Theme Configurator</h3>

<p style="background:#fafafa;border:solid 1px #ddd;padding:15px;"><?php echo i18n_r("massiveAdmin/HOWUSETHEMECONFIG");?>

    <br>
    <br>
    <button class="button showdialog"><?php echo i18n_r("massiveAdmin/WATCHEXAMPLE");?></button>

</p>


<style>
    ::backdrop {
        background: rgba(0, 0, 0, 0.4);
        opacity: 0.75;
    }

    dialog {
        width: 80vw;
        height: 50vh;
        padding: 30px 10vw;
        padding-bottom: 20px !important;
    }

    dialog .code {
        width: 100%;
        background: #161A30;
        color: #F0ECE5;
        padding: 15px;
        font-size: 16px;

    }

    .settheme :is(input, select) {
        width: 100% !important;
        padding: 6px !important;
        background: #fff;
        border: solid 1px #ddd;
        border-radius: 0;
        margin: 5px 0 !important;
    }

    .settheme {
        box-sizing: border-box;
        padding: 10px;
        background: #fafafa;
        border: solid 1px #ddd;
    }

    .settheme p {
        font-size: 14px !important;
        font-weight: bold !important;
        margin-bottom: 10px !important;
        display: block;
    }

    .settheme .mb_img {
        display: grid;
        gap: 10px;
        grid-template-columns: 80px 1fr 50px;
        align-items: center;
        justify-content: center;
        justify-items: center;
        margin-top: 10px;
    }

    .settheme .mb_img img {
        outline: solid;
        border: none;
        outline-offset: 1px;
        outline-color: var(--main-color);
    }

    .settheme .mb_img button {
        background: var(--main-color);
        border: none;
        cursor: pointer;
        border-radius: 4px;
    }

    .settheme .mb_img svg {
        width: 23px;
        fill: #fff;
    }


    .settheme .mb_file {
        display: grid;
        gap: 10px;
        grid-template-columns: 1fr 50px;
        align-items: center;
        justify-content: center;
        justify-items: center;
        margin-top: 10px;
    }

    .settheme .mb_file button {
        background: var(--main-color);
        border: none;
        cursor: pointer;
        border-radius: 4px;
    }

    .settheme .mb_file svg {
        width: 23px;
        fill: #fff;
    }
</style>

<?php


$xml = simplexml_load_file(GSDATAOTHERPATH . 'website.xml');

$activeTemplate = $xml->TEMPLATE;

echo "Active Theme: <b>$activeTemplate</b> <br><br>";; ?>




<h3 style="margin:0"><?php echo i18n_r("massiveAdmin/SETTINGS");?></h3>
<hr>
<?php


if (file_exists(GSTHEMESPATH . $activeTemplate . '/settings.json')) {
    $data = file_get_contents(GSTHEMESPATH . $activeTemplate . '/settings.json');
    $filx =  json_decode($data);

    echo '<form class="settheme" method="post">';

    foreach ($filx->settings as $key => $loop) {


        if ($loop->type  == 'wysywig') {

            echo '<p style="margin: 0;
            margin:0;
            margin-top: 20px;
            font-weight: 400px;
            font-size: 15px;
            margin-bottom:5px;">' . $loop->title . ' :</p>
     
            <textarea id="post-content" name="' . $key . '" style="width:100%;display:block;height:250px;" class="mbinput">' . html_entity_decode($loop->value) . '</textarea>
            ';
        } elseif ($loop->type  == 'image') {

            global $SITEURL;

            echo '<span class="formedit">';
            echo '<p style="margin: 0;
                margin-top: 0px;
                margin-top: 20px;
                font-weight: 400px;
                font-size: 15px;">' . $loop->title . ' :</p>

                <div class="mb_img">';
            if ($loop->value !== 'undefined') {
                echo ' <img src="' . $loop->value . '" style="width:80px;height:80px;object-fit:cover;">';
            };

            echo '
                    <input type="text" class="mb_foto foto mbinput"  name="' . $key . '"  value="' . $loop->value . '">
                    <button class="mb_fotobtn choose-image">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="image"><path d="M19,4H5A3,3,0,0,0,2,7V17a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V7A3,3,0,0,0,19,4ZM5,18a1,1,0,0,1-1-1V14.58l3.3-3.29a1,1,0,0,1,1.4,0L15.41,18Zm15-1a1,1,0,0,1-1,1h-.77l-3.81-3.83.88-.88a1,1,0,0,1,1.4,0L20,16.58Zm0-3.24-1.88-1.87a3.06,3.06,0,0,0-4.24,0l-.88.88L10.12,9.89a3.06,3.06,0,0,0-4.24,0L4,11.76V7A1,1,0,0,1,5,6H19a1,1,0,0,1,1,1Z"></path></svg></button>
                </div>
                ';

            echo "</span>";
        } elseif ($loop->type  == 'file') {

            global $SITEURL;

            echo '<span class="formedit-file">';
            echo '<p style="margin: 0;
                margin-top: 0px;
                margin-top: 20px;
                font-weight: 400px;
                font-size: 15px;">' . $loop->title . ' :</p>

                <div class="mb_file">';

            echo '
                    <input type="text" class="mb_file file mbinput"  name="' . $key . '"  value="' . $loop->value . '">
                    <button class="mb_filebtn choose-file">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="file"><path  d="M20,8.94a1.31,1.31,0,0,0-.06-.27l0-.09a1.07,1.07,0,0,0-.19-.28h0l-6-6h0a1.07,1.07,0,0,0-.28-.19l-.09,0L13.06,2H7A3,3,0,0,0,4,5V19a3,3,0,0,0,3,3H17a3,3,0,0,0,3-3V9S20,9,20,8.94ZM14,5.41,16.59,8H14ZM18,19a1,1,0,0,1-1,1H7a1,1,0,0,1-1-1V5A1,1,0,0,1,7,4h5V9a1,1,0,0,0,1,1h5Z"></path></svg></button>
                </div>
                ';

            echo "</span>";
        } elseif ($loop->type  == 'textarea') {

            echo '<p style="margin: 0;
            margin-top: 0px;
            margin-top: 20px;
            font-weight: 400px;
            font-size: 15px;display:inline-block;">' . $loop->title . ' :</p>.
            
            <textarea class="mbinput" style="width:100%;height:250px;" name="' . $key . '" >' . html_entity_decode($loop->value) . '</textarea>';
        } elseif ($loop->type  == 'dropdown') {

            $ars = explode('||', $loop->options);

            echo '<p style="margin: 0;
            margin-top: 0px;
            margin-top: 20px;
            font-weight: 400px;
            font-size: 15px;display:inline-block;">' . $loop->title . ' :</p>';

            echo '<select style="width:100%;padding:10px;" class="' . $key . '" name="' . $key . '">';

            foreach ($ars as $sel) {
                echo '<option value="' . trim($sel) . '" >' . trim($sel)  . '</option>';
            }

            echo '</select>';

            echo '<script>
                document.querySelector("select.' . str_replace(" ", "", $key) . '").value = "' . trim($loop->value) . '"; 
            </script>';
        } elseif ($loop->type  == 'link') {

            echo '
            <p style="margin: 0;
            margin:0;
            margin-top: 20px;
            font-weight: 400px;
            font-size: 15px;">' . $loop->title . ' :</p> 
            <select style="width:100%;padding:15px;display:block;border:solid 1px #ddd; background:#fff;margin-top:10px;" class="' . $key . '" name="' . $key . '">';

            foreach (glob(GSDATAPAGESPATH . "*.{xml}", GLOB_BRACE) as $page) {

                $path_parts = pathinfo($page);

                global $SITEURL;

                echo "<option value='" . $SITEURL . $path_parts['filename'] . "'  >" . $path_parts['filename'] . "</option>";
            };

            echo '</select>';

            echo '<script> document.querySelector("select.' . $key . '").value = "' . $loop->value . '"; </script>';
        } else {

            echo '<p style="margin: 0;
            margin:0;
            margin-top: 20px;
            font-weight: 400px;
            font-size: 15px;">' . $loop->title . ' :</p>

            <input   type="' . $loop->type . '" name="' . $key . '" value="' . html_entity_decode($loop->value ?? '') . '">
            ';
        }
    };
};

echo '
    <button input="submit" name="ssettings" style="background:var(--main-color);padding:10px 15px;border:none; color:#fff;border-radius:10px;">'.i18n_r('massiveAdmin/SAVEOPTION').'</button>
    </form>';
?>


<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ssettings'])) {
    foreach ($filx->settings as $key => $loop) {
        $filx->settings->$key->value = $_POST[$key];
    }

    // Zapisz zaktualizowane dane z powrotem do pliku
    file_put_contents(GSTHEMESPATH . $activeTemplate . '/settings.json', json_encode($filx, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

    echo ("<meta http-equiv='refresh' content='0'>");
}; ?>




<script type="text/javascript" src="template/js/ckeditor/ckeditor.js?t=3.3.16"></script>

<script type="text/javascript">
    document
        .querySelectorAll(`#post-content`)
        .forEach(c => {

            var editor = CKEDITOR.replace(c, {
                skin: 'getsimple',
                forcePasteAsPlainText: true,
                language: 'en',
                defaultLanguage: 'en',
                entities: true,
                // uiColor : '#FFFFFF',
                height: '300px',
                baseHref: '<?php global $SITEURL;
                            echo $SITEURL; ?>',
                tabSpaces: 10,
                filebrowserBrowseUrl: 'filebrowser.php?type=all',
                filebrowserImageBrowseUrl: 'filebrowser.php?type=images',
                filebrowserWindowWidth: '730',
                filebrowserWindowHeight: '500',
                toolbar: 'advanced'
            });
        });
</script>

<script>
    if (document.querySelector('.mb_foto') !== null) {

        let data = 0;

        document
            .querySelectorAll('.formedit')
            .forEach((e, i) => {

                e.querySelector('.choose-image')
                    .addEventListener('click', y => {
                        y.preventDefault();

                        const url = "<?php global $SITEURL;
                                        echo $SITEURL . "plugins/massiveAdmin/files/imagebrowser.php?"; ?>&func=" + e.querySelector('input[type="text"]').getAttribute('name');

                        const win = window.open(url, "myWindow", "tolbar=no,scrollbars=no,menubar=no,width=500,height=500");

                        win.window.focus();
                    });

            })
    };



    if (document.querySelector('.mb_file') !== null) {

        let data = 0;

        document
            .querySelectorAll('.formedit-file')
            .forEach((e, i) => {

                e.querySelector('.choose-file')
                    .addEventListener('click', y => {
                        y.preventDefault();

                        const url = "<?php global $SITEURL;
                                        echo $SITEURL . "plugins/massiveAdmin/files/filebrowser.php?"; ?>&type=all&func=" + e.querySelector('input[type="text"]').getAttribute('name');

                        const win = window.open(url, "myWindow", "tolbar=no,scrollbars=no,menubar=no,width=500,height=500");

                        win.window.focus();
                    });

            })
    }
</script>



<dialog>
    <button autofocus style="background: var(--main-color);
  color: #fff;
  position: absolute;
  top: 0;
  right: 10px;
  top: 10px;
  padding: 5px;border-radius:5px;border:none;
  cursor:pointer;">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="display:inline-block;width:25px;height:25px;margin:0;padding:0 " id="times"><path fill="#fff" d="M13.41,12l4.3-4.29a1,1,0,1,0-1.42-1.42L12,10.59,7.71,6.29A1,1,0,0,0,6.29,7.71L10.59,12l-4.3,4.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l4.29,4.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z"></path></svg></button>

    <h3><?php echo i18n_r("massiveAdmin/HOWCREATETITLE");?></h3>
    <p>
    <?php echo i18n_r("massiveAdmin/TUTORIALHOWCREATESETTINGS");?>
    </p>

    <div class="code">
        {<br>
        "settings": {<br><br>
        "fieldname1": {<br>
        "type": "text",<br>
        "title": "field title 1",<br>
        "value": ""<br>
        },<br><br>
        "fieldname2": {<br>
        "type": "wysywig",<br>
        "title": "field title 2",<br>
        "value": ""<br>
        },<br><br>
        "fieldname3": {<br>
        "type": "textarea",<br>
        "title": "field title 3",<br>
        "value": ""<br>
        },<br><br>
        "fieldname4": {<br>
        "type": "color",<br>
        "title": "field title 4",<br>
        "value": ""<br>
        },<br><br>
        "fieldname5": {<br>
        "type": "date",<br>
        "title": "field title 5",<br>
        "value": ""<br>
        },<br><br>
        "fieldname6": {<br>
        "type": "image",<br>
        "title": "field title 6",<br>
        "value": ""<br>
        },<br><br>
        "fieldname7": {<br>
        "type": "file",<br>
        "title": "field title 7",<br>
        "value": ""<br>
        },<br><br>
        "fieldname8": {<br>
        "type": "link",<br>
        "title": "field title 8",<br>
        "value": ""<br>
        },<br><br>
        "fieldname9": {<br>
        "type": "dropdown",<br>
        "options": "Options 1 || Options 2",<br>
        "title": "field title 9",<br>
        "value": ""<br>
        &nbsp; &nbsp;}<br>
        &nbsp;}<br>
        }<br>
    </div>

</dialog>

<script>
    const dialog = document.querySelector("dialog");
    const showButton = document.querySelector(".showdialog");
    const closeButton = document.querySelector("dialog button");

    // "Show the dialog" button opens the dialog modally
    showButton.addEventListener("click", () => {
        dialog.showModal();
    });

    // "Close" button closes the dialog
    closeButton.addEventListener("click", () => {
        dialog.close();
    });
</script>


<?php


if (!file_exists(GSDATAOTHERPATH . 'jsonsupportadded.txt')) {
    $f = file_get_contents(GSADMINPATH . 'theme-edit.php');
    $n = str_replace("['php', 'css', 'js', 'html', 'htm']", "['php', 'css', 'js', 'html', 'htm','json']", $f);
    file_put_contents(GSDATAOTHERPATH . 'jsonsupportadded.txt', '1');
    file_put_contents(GSADMINPATH . 'theme-edit.php', $n);
}
