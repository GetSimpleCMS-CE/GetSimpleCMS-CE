<?php global $SITEURL; ?>

<link rel="stylesheet" href="<?php echo $SITEURL; ?>plugins/massiveAdmin/css/codemirror.min.css" />
<link rel="stylesheet" href="<?php echo $SITEURL; ?>plugins/massiveAdmin/css/blackboard.min.css" />
<script src="<?php echo $SITEURL; ?>plugins/massiveAdmin/js/codemirror.min.js"></script>
<script src="<?php echo $SITEURL; ?>plugins/massiveAdmin/js/clike.min.js"></script>

<style type="text/css">
    .CodeMirror {
        font-size: 15px;
        width: 100%;
        height: 500px;
        border:solid 1px #ccc;
    }
</style>

<button onclick="toggleTab('Tab7')" style="margin-top:10px"
    class=" w3-button w3-xlarge w3-round w3-block w3-gray w3-text-white w3-left-align w3-margin-bottom">
    <?php echo i18n_r('massiveAdmin/GSCONFIGTITLE'); ?> <span class="w3-right"><svg xmlns="http://www.w3.org/2000/svg"
            width="22" height="22" viewBox="0 0 24 24">
            <path fill="currentColor" fill-rule="evenodd" d="m5 8l7 8l7-8z" />
        </svg></span>
</button>
<div id="Tab7" class="w3-hide w3-container">
    <form action="#" method="Post">
        <textarea name="content" id="myTextarea" wrap='off'><?php echo file_get_contents(GSROOTPATH . 'gsconfig.php'); ?></textarea>

        <div class="w3-center" style="margin-top:30px">
            <button class="w3-btn w3-large w3-round w3-green" type="submit"
                value="<?php echo i18n_r('massiveAdmin/GSCONFIGSAVE'); ?>"
                name="editGSConfig"><?php echo i18n_r('massiveAdmin/GSCONFIGSAVE'); ?></button>
        </div>
    </form>
</div>

<?php $CMTHEME = defined('GSCMTHEME') ? constant('GSCMTHEME') : 'blackboard'; ?>

<script>
    var editor = null; // Globalna zmienna dla edytora

    function toggleTab(tabId) {
        var tab = document.getElementById(tabId);
        
        // Przełącz widoczność taba
        if (tab.classList.contains('w3-hide')) {
            // Pokaż tab
            tab.classList.remove('w3-hide');
            
            // Inicjalizacja lub odświeżenie CodeMirror
            if (!editor) {
                // Pierwsza inicjalizacja
                editor = CodeMirror.fromTextArea(document.getElementById('myTextarea'), {
                    theme: "<?php echo $CMTHEME; ?>",
                    lineNumbers: true,
                    matchBrackets: true,
                    indentUnit: 4,
                    indentWithTabs: true,
                    enterMode: "keep",
                    tabMode: "shift",
                    mode: 'clike',
                    inlineDynamicImports: true
                });
            } else {
                // Odśwież edytor po pokazaniu taba
                setTimeout(function() {
                    editor.refresh();
                    editor.focus(); // Opcjonalnie: ustawia fokus na edytorze
                }, 50); // Krótsze opóźnienie
            }
        } else {
            // Ukryj tab
            tab.classList.add('w3-hide');
        }
    }


    // Save with ctrl+s
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            var saveButton = document.querySelector('button[name="editGSConfig"]');
            if (saveButton) {
                saveButton.click();
            }
        }
    });
</script>

<?php
if (isset($_POST['editGSConfig'])) {
    global $MA;
    $MA->gsConfigEdit();
    echo '<div class="doneMassive" style="background:green;width:100%;text-align:center;padding:10px;border-radius:3px;color:#fff;">Done</div>';
    echo ("<meta http-equiv='refresh' content='1'>");
}
?>