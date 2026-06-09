<?php
/**
 * Reset Password
 *
 * Resets the password for GetSimple control panel access
 *
 * @package GetSimple
 * @subpackage Login
 */

$load['plugin'] = true;
include('inc/common.php');

define('GS_RESET_TOKEN_EXPIRY', 3600); // 1 hour

if (isset($_POST['submitted'])) {

	// CSRF check
	if (!defined('GSNOCSRF') || GSNOCSRF == FALSE) {
		$nonce = isset($_POST['nonce']) ? $_POST['nonce'] : '';
		if (!check_nonce($nonce, 'reset_password')) {
			die('CSRF detected!');
		}
	}

	$randSleep = random_int(250000, 2000000);

	if (isset($_POST['username']) && !empty($_POST['username'])) {

		$file = _id($_POST['username']) . '.xml';

		if (filepath_is_safe(GSUSERSPATH . $file, GSUSERSPATH)) {
			$data = simplexml_load_file(GSUSERSPATH . $file);
			$USR   = strtolower((string)$data->USR);
			$EMAIL = (string)$data->EMAIL;

			if (strtolower($_POST['username']) === $USR) {

				// Generate a cryptographically secure token
				$rawToken   = bin2hex(random_bytes(32)); // 64 hex chars, 256-bit
				$tokenHash  = hash('sha256', $rawToken);
				$expiry	 = time() + GS_RESET_TOKEN_EXPIRY;

				// Store hash + expiry in a sidecar reset file (never the live XML)
				$resetFile  = GSUSERSPATH . _id($USR) . '.xml.resettoken';
				$resetData  = $tokenHash . '|' . $expiry;
				file_put_contents($resetFile, $resetData, LOCK_EX);

				// Build the reset link
				$resetLink = $SITEURL . $GSADMIN . '/resetpassword_confirm.php'
						   . '?user=' . urlencode($USR)
						   . '&token=' . urlencode($rawToken);

				// Send email with link (NOT the token raw password)
				$subject = $site_full_name . ' ' . i18n_r('RESET_PASSWORD') . ' ' . i18n_r('ATTEMPT');
				$message  = '<h2>' . cl($SITENAME) . ' ' . i18n_r('RESET_PASSWORD') . ' ' . i18n_r('ATTEMPT') . '</h2>';
				$message .= '<p>' . i18n_r('LABEL_USERNAME') . ': <strong>' . htmlspecialchars($USR, ENT_QUOTES, 'UTF-8') . '</strong></p>';
				$message .= '<p>' . i18n_r('Click_the_link') . '</p>';
				$message .= '<p><a href="' . htmlspecialchars($resetLink, ENT_QUOTES, 'UTF-8') . '">' . i18n_r('This_link_expires') . '</a></p>';

				exec_action('resetpw-success');
				sendmail($EMAIL, $subject, $message);
			}
			// Fall through — always show success (no user enumeration)
		}

		usleep($randSleep);
		redirect('resetpassword.php?upd=pwd-success');

	} else {
		redirect('resetpassword.php?upd=pwd-error');
	}
}

get_template('header', cl($SITENAME) . ' &raquo; ' . i18n_r('RESET_PASSWORD'));
?>
</div>
</div>
<div class="wrapper clearfix">

	<?php include('template/error_checking.php'); ?>

	<div id="maincontent">
		<div class="main">
		
			<h3><?php i18n('RESET_PASSWORD'); ?></h3>
			<p class="desc"><?php i18n('MSG_PLEASE_EMAIL'); ?></p>

			<form class="login" action="<?php myself(); ?>" method="post">
				<input name="nonce" id="nonce" type="hidden" value="<?php echo get_nonce('reset_password'); ?>"/>
				<p><b><?php i18n('LABEL_USERNAME'); ?>:</b><br /><input class="text" name="username" type="text" value="" /></p>
				<p><input class="submit" type="submit" name="submitted" value="<?php echo i18n('SEND_NEW_PWD'); ?>" /></p>
			</form>

			<p class="cta"><b>&laquo;</b> <a href="<?php echo $SITEURL; ?>"><?php i18n('BACK_TO_WEBSITE'); ?></a> &nbsp;|&nbsp; <a href="index.php"><?php i18n('CONTROL_PANEL'); ?></a> &raquo;</p>
		</div>
		
	</div>

<?php get_template('footer'); ?>