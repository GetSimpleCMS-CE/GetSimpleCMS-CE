<?php 
/**
 * Archive
 *
 * Displays and starts the website archives 	
 *
 * @package GetSimple
 * @subpackage Backups
 */

// Setup inclusions
$load['plugin'] = true;

// Include common.php
include('inc/common.php');

// Variable Settings
login_cookie_check();
$table = '';

// if a backup needs to be created
if(isset($_GET['do'])) {
	
	// check for csrf
	if (!defined('GSNOCSRF') || (GSNOCSRF == FALSE) ) {
		$nonce = $_GET['nonce'];
		if(!check_nonce($nonce, "create")) {
			die("CSRF detected!");
		}
	}	
	exec_action('archive-backup');
	redirect('zip.php?s='.$SESSIONHASH.'&do=create');	
}

// if a backup has just been created
if(isset($_GET['done'])) {
	$success = i18n_r('SUCC_WEB_ARCHIVE');
}

if(isset($_GET['nozip'])) {
	$error = i18n_r('NO_ZIPARCHIVE'). ' - <a href="health-check.php">'.i18n_r('WEB_HEALTH_CHECK').'</a>';
}

get_template('header', cl($SITENAME).' &raquo; '.i18n_r('BAK_MANAGEMENT').' &raquo; '.i18n_r('WEBSITE_ARCHIVES')); 

?>
	
<?php include('template/include-nav.php'); ?>

<div class="bodycontent clearfix">
	
	<div id="maincontent">
		<div class="main" >
		<h3 class="floated"><?php i18n('WEBSITE_ARCHIVES');?></h3>
		<div class="edit-nav clearfix" >
    	<a id="waittrigger" href="archive.php?do&amp;nonce=<?php echo get_nonce("create"); ?>" accesskey="<?php echo find_accesskey(i18n_r('ASK_CREATE_ARC'));?>" title="<?php i18n('CREATE_NEW_ARC');?>" ><?php i18n('ASK_CREATE_ARC');?></a>
		</div>
		<p style="display:none" id="waiting" ><?php i18n('CREATE_ARC_WAIT');?></p>
		
		<table class="highlight paginate">
			<tr><th><?php i18n('ARCHIVE_DATE'); ?></th><th style="text-align:right;" ><?php i18n('FILE_SIZE'); ?></th><th></th></tr>
			<?php
				$count="0";
				$path = tsl(GSBACKUPSPATH .'zip/');
				
				$filenames = getFiles($path);
	
				natsort($filenames);
				rsort($filenames);
				
				foreach ($filenames as $file) {
					if($file[0] != "." ) {
						$timestamp = pathinfo($file, PATHINFO_FILENAME); // Extract filename without extension
						try {
							$date = DateTime::createFromFormat('YmdHis', $timestamp);
							if ($date === false) {
								throw new Exception('Invalid date format');
							}
							$name = $date->format('F jS, Y - g:i A');
						} catch (Exception $e) {
							$name = 'Unknown Date';
						}
						clearstatcache();
						$ss = stat($path . $file);
						$size = fSize($ss['size']);
						echo '<tr>
								<td><a title="'.i18n_r('DOWNLOAD').': '. $name .'" href="download.php?file='. $path . $file .'&amp;nonce='.get_nonce("archive", "download.php").'" style="text-decoration:none;"><svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;" width="22px" height="22px" viewBox="0 0 24 24"><path fill="#E2990C" d="M16 16h2v-2h-2v-2h2v-2h-2V8h4v10h-4zm0 0h-2v2H4V6h5.17l2 2H14v2h2v2h-2v2h2z" opacity="0.3"/><path fill="#E2990C" d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2m-4 10h2v-2h-2v-2h2v-2h-2V8h4v10h-4zm0 0h-2v2H4V6h5.17l2 2H14v2h2v2h-2v2h2z"/></svg> '.$name .'</a></td>
								<td style="width:70px;text-align:right;" ><span>'.$size.'</span></td>
								<td class="delete" ><a class="delconfirm" title="'.i18n_r('DELETE_ARCHIVE').': '. $name .'?" href="deletefile.php?zip='. $file .'&amp;nonce='.get_nonce("delete", "deletefile.php").'">&times;</a></td>
							  </tr>';
						$count++;
					}
				}
	
			?>
			</table>
			<p><em><b><span id="pg_counter"><?php echo $count; ?></span></b> <?php i18n('TOTAL_ARCHIVES');?></em></p>
		</div>
	</div>
	
	<div id="sidebar" >
		<?php include('template/sidebar-backups.php'); ?>
	</div>

</div>
<?php get_template('footer'); ?>
