<?php
$checkTurnOn = @file_get_contents(GSDATAOTHERPATH . 'massiveToperSettings/turnon.txt');
$styleFile = @file_get_contents(GSDATAOTHERPATH . 'massiveToperSettings/style.txt');

?>

<form action="#" method="POST">
    <h3>FrontEnd Settings</h3>
    <label for="" style="display:flex;flex-direction:row;justify-content:space-between"><?php echo i18n_r("massiveAdmin/TURNONMTOPER"); ?>
        <input type="checkbox" name="turnon" <?php echo ($checkTurnOn == 'on' ? 'checked' : ''); ?> value="on">
    </label>
    <br>
    <label for=""><?php echo  i18n_r("massiveAdmin/STYLEINFO"); ?></label>


    <select name="style" class="style" style="width:100%;padding:10px; margin-top:10px;border-radius:0;border:solid 1px #ddd;background:#fff;" id="">
        <?php

        foreach (glob(GSPLUGINPATH . 'massiveAdmin/toper-theme/*.css') as $style) {

            $name = pathinfo($style)['filename'];

            echo '<option value="' . $name . '" >' . $name . '</option>';
        };; ?>
    </select>

    <input type="submit" style="background:var(--main-color);color:#fff;padding:10px;margin-top:10px;border:none;" name="savesettings" value="<?php echo i18n_r('massiveAdmin/SAVEOPTION'); ?>">
</form>

<?php if (file_exists(GSDATAOTHERPATH . 'massiveToperSettings/style.txt')) : ?>

    <script>
        document.querySelector('.style').value = '<?php echo $styleFile; ?>';
    </script>

<?php endif; ?>

<?php

if (isset($_POST['savesettings'])) {

    global $MA;
    $MA->mtoperSetting();
};

?>