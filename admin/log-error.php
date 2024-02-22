<?php 
/**
 * View Log
 *
 * Displays the log file passed to it 
 *
 * @package GetSimple
 * @subpackage Support
 */

// Setup inclusions
$load['plugin'] = true;
include('inc/common.php');

// Variable Settings
login_cookie_check();

$log_name = var_out(isset($_GET['log']) ? $_GET['log'] : '');
$log_path = GSDATAOTHERPATH.'logs/';

$log_file = $log_path . 'errorlog.txt';

if (!isset($log_name) || !file_exists($log_file)) {
    $log_data = false;
} else {
    $log_data = true;
}

get_template('header', cl($SITENAME).' &raquo; '.i18n_r('SUPPORT').' &raquo; '.i18n_r('LOGS')); 
?>

<?php include('template/include-nav.php'); ?>

<style>
	.log-entry {
		padding: 10px;
		border-top: solid 1px black;
	}
	.timestamp {
		padding:10px;
		color: green;
		font-weight: bold;
		text-decoration:underline;
	}

	.even {
		background-color: #f5f5f5;
	}
	.odd {
		background-color: #ffffff;
	}

	.error-line {
		color: red;
	}
	.stack-trace {
		color: orange;
	}
	.php-line {
		color: grey;
	}
	.scrollable-div {
		max-height: 85vh;
		overflow-y: auto;
		border: solid 1px #ccc;
		border-radius:5px;
	}
</style>

<div class="bodycontent clearfix">
    <div id="maincontent">
        <div class="main">
            <h3 class="floated"><?php i18n('VIEWING');?> <?php i18n('LOG_FILE');?>: &lsquo;<em><?php echo $log_name; ?></em>&rsquo;</h3>
            <div class="edit-nav" >
                <!--a href="log-error.php?log=<?php echo $log_name; ?>&action=delete&nonce=<?php echo get_nonce("delete"); ?>" accesskey="<?php echo find_accesskey(i18n_r('CLEAR_ALL_DATA'));?>" title="<?php i18n('CLEAR_ALL_DATA');?> <?php echo $log_name; ?>?" /><?php i18n('CLEAR_THIS_LOG');?></a-->
                <div class="clear"></div>
            </div>
            <?php if (!$log_data) echo '<p><em>'.i18n_r('LOG_FILE_EMPTY').'</em></p>'; ?>
            <div class="log-entries scrollable-div">
                <?php 
                $count = 1;

                if ($log_data) {
                    // Read the error log file
                    $logContent = file_get_contents($log_file);

                    // Split log content into individual lines
                    $logLines = explode("\n", $logContent);

                    // Format and display each error log entry
                    $entryLines = [];
                    $lastTimestamp = null;
                    foreach ($logLines as $line) {
                        // Trim any leading or trailing whitespace
                        $line = trim($line);

                        // Skip empty lines
                        if (empty($line)) {
                            continue;
                        }

                        // Extract the timestamp from the line
                        preg_match('/^\[(.*?)\]/', $line, $matches);
                        $timestamp = isset($matches[1]) ? $matches[1] : '';

                        // Check if the line is the start of a new entry
                        if ($timestamp !== $lastTimestamp) {
                            // Add previous entry lines to the output
                            if (!empty($entryLines)) {
                                echo '<div class="log-entry ' . (($count % 2 === 0) ? 'even' : 'odd') . '">';
                                echo '<div class="timestamp">' . $lastTimestamp . '</div>';
                                echo implode('<br>', $entryLines);
                                echo '</div>';
                                $entryLines = [];
                                $count++;
                            }
                            $lastTimestamp = $timestamp;
                        }

                        // Add the current line to the entry lines
                        $entryLines[] = formatLogLine($line);
                    }

                    // Output the last entry if there are any remaining lines
                    if (!empty($entryLines)) {
                        echo '<div class="log-entry ' . (($count % 2 === 0) ? 'even' : 'odd') . '">';
                        echo '<div class="timestamp">' . $lastTimestamp . '</div>';
                        echo implode('<br>', $entryLines);
                        echo '</div>';
                    }
                }

                // Helper function to format log lines
                function formatLogLine($line) {
                    if (strpos($line, 'PHP Warning') !== false) {
                        return '<div class="error-line">' . $line . '</div>';
                    } elseif (strpos($line, 'PHP Stack trace') !== false) {
                        return '<div class="stack-trace">' . $line . '</div>';
                    } elseif (preg_match('/^\[.*?\] PHP\s+\d+/', $line)) {
                        return '<div class="php-line">' . $line . '</div>';
                    } else {
                        return $line;
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <div id="sidebar" >
        <?php include('template/sidebar-support.php'); ?>
    </div>    
</div>
<?php get_template('footer'); ?>
