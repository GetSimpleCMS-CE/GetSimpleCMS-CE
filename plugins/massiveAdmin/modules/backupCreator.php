<style>
    .backuplist {
        margin: 10px 0 !important;
        padding: 0 !important;
        list-style-type: none;
    }
    .backuplist li {
        padding: 10px;
        border-bottom: solid 1px #ddd;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .backuplist li:nth-child(2n) {
        background: #fafafa;
    }
    .delbackupbtn {
        cursor: pointer;
        background: var(--main-color);
        border: none;
    }
    .delbackupbtn svg {
        stroke: #fff !important;
    }
</style>

<h3>Backup creator</h3>

<form action="#" method="post">
    <select name="folder" id="" style="width:100%;padding:10px;margin-bottom:10px;background:#fff;border:solid 1px #ddd;">
        <option value="<?php echo GSPLUGINPATH; ?>">Plugins folder</option>
        <option value="<?php echo GSADMINPATH; ?>">Admin folder</option>
        <option value="<?php echo GSDATAPATH; ?>">Data folder</option>
        <option value="<?php echo GSTHEMESPATH; ?>">Themes folder</option>
        <option value="<?php echo GSDATAUPLOADPATH; ?>">Uploads folder</option>
    </select>
	
    <button class="button" name="backupcreate" style="padding:10px 15px"><?php echo i18n_r('massiveAdmin/CREATEBACKUP'); ?></button>
</form>

<?php

echo '<ul class="backuplist">';

foreach (glob(GSBACKUPSPATH . 'backupCreator/*.*') as $zip) {
    global $SITEURL;
    global $GSADMIN;

    $domainurl = $SITEURL . 'backups/backupCreator/' . pathinfo($zip)['basename'];
    $url = GSBACKUPSPATH . 'backupCreator/' . pathinfo($zip)['basename'];
    $name =   pathinfo($zip)['filename'] . '.zip';

    echo "<li><a href='$domainurl' download>$name</a> <form method='post'><form method='post'><input type='hidden' name='delbackup' value='$url'><button class='delbackupbtn' type='submit'><svg width='20px' height='20px' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
    <path d='M18 6L17.1991 18.0129C17.129 19.065 17.0939 19.5911 16.8667 19.99C16.6666 20.3412 16.3648 20.6235 16.0011 20.7998C15.588 21 15.0607 21 14.0062 21H9.99377C8.93927 21 8.41202 21 7.99889 20.7998C7.63517 20.6235 7.33339 20.3412 7.13332 19.99C6.90607 19.5911 6.871 19.065 6.80086 18.0129L6 6M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/>
    </svg></button></form>";
};

echo '</ul>';; ?>

<?php

global $MA;

if (isset($_POST['backupcreate'])) {
    $MA->createBackupZip();
};

if (isset($_POST['delbackup'])) {
    $MA->deleteBackupZip();
}; ?>