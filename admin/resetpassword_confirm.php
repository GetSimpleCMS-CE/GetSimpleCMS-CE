<?php
/**
 * Reset Password — Token Confirmation
 *
 * Validates a single-use reset token and allows the user to set a new password.
 *
 * @package GetSimple
 * @subpackage Login
 */

$load['plugin'] = true;
include('inc/common.php');

define('GS_RESET_TOKEN_EXPIRY', 3600); // 1 hour

$user  = isset($_GET['user'])  ? _id($_GET['user'])  : '';
$token = isset($_GET['token']) ? trim($_GET['token']) : '';

$tokenValid = false;
$tokenError = '';

if ($user && $token) {
	$resetFile = GSUSERSPATH . $user . '.xml.resettoken';

	if (file_exists($resetFile) && filepath_is_safe($resetFile, GSUSERSPATH)) {
		$contents = file_get_contents($resetFile);
		list($storedHash, $expiry) = explode('|', $contents, 2);

		$providedHash = hash('sha256', $token);

		if (time() > (int)$expiry) {
			$tokenError = i18n_r('RESET_PASSWORD');
			unlink($resetFile); // clean up expired token
		} elseif (!hash_equals($storedHash, $providedHash)) {
			$tokenError = i18n_r('Invalid_already_used');
		} else {
			$tokenValid = true;
		}
	} else {
		$tokenError = i18n_r('Invalid_already_used');
	}
}

// No valid token and not a POST — redirect appropriately
if (!$tokenValid && !isset($_POST['submitted'])) {
	if ($tokenError || !$user || !$token) {
		redirect('resetpassword.php?upd=pwd-error');
	}
}

// Handle the new-password form submission
if (isset($_POST['submitted'])) {

	// Re-validate token on POST (token is passed via GET even on POST)
	if (!$tokenValid) {
		redirect('resetpassword.php?upd=pwd-error');
	}

	// CSRF check
	if (!defined('GSNOCSRF') || GSNOCSRF == FALSE) {
		$nonce = isset($_POST['nonce']) ? $_POST['nonce'] : '';
		if (!check_nonce($nonce, 'reset_password_confirm')) {
			die('CSRF detected!');
		}
	}

	$newPwd  = isset($_POST['newpwd'])  ? $_POST['newpwd']  : '';
	$newPwd2 = isset($_POST['newpwd2']) ? $_POST['newpwd2'] : '';

	$pwdError = '';

	if (strlen($newPwd) < 8) {
		$pwdError = i18n_r('must_be_8_characters');
	} elseif ($newPwd !== $newPwd2) {
		$pwdError = i18n_r('Passwords_do_not_match');
	}

	if (!$pwdError) {
		// Validation passed — save the new password
		$file = GSUSERSPATH . $user . '.xml';

		if (filepath_is_safe($file, GSUSERSPATH) && file_exists($file)) {
			$data = simplexml_load_file($file);

			// Backup before modifying
			createBak($user . '.xml', GSUSERSPATH, GSBACKUSERSPATH);

			$data->PWD = passhash($newPwd);
			XMLsave($data, $file);

			// Invalidate token immediately (single-use)
			$resetFile = GSUSERSPATH . $user . '.xml.resettoken';
			if (file_exists($resetFile)) {
				unlink($resetFile);
			}

			redirect('index.php?upd=success');
		}
	}

	// Validation failed — re-render the form with error and back button
	get_template('header', cl($SITENAME) . ' &raquo; ' . i18n_r('RESET_PASSWORD'));
?>
</div>
</div>
<div class="wrapper clearfix">

	<div id="maincontent">
		<div class="main">

			<h3><?php i18n('RESET_PASSWORD'); ?></h3>

			<p class="error"><?php echo htmlspecialchars($pwdError, ENT_QUOTES, 'UTF-8'); ?></p>

			<form class="login" action="<?php myself(); ?>?user=<?php echo urlencode($user); ?>&amp;token=<?php echo urlencode($token); ?>" method="post">
				<input name="nonce" id="nonce" type="hidden" value="<?php echo get_nonce('reset_password_confirm'); ?>"/>
				<p><b><?php i18n('New_Password'); ?>:</b><br />
				<input class="text" name="newpwd" type="password" value="" /></p>
				<p><b><?php i18n('Confirm_New_Password'); ?>:</b><br />
				<input class="text" name="newpwd2" type="password" value="" /></p>
				<p><input class="submit" type="submit" name="submitted" value="<?php i18n('Set_New_Password'); ?>" /></p>
			</form>

			<p class="cta"><b>&laquo;</b> <a href="<?php echo $SITEURL; ?>"><?php i18n('BACK_TO_WEBSITE'); ?></a></p>

		</div>
	</div>

<?php
	get_template('footer');
	exit;
}

// Token is valid and no POST yet — show the initial set-password form
get_template('header', cl($SITENAME) . ' &raquo; ' . i18n_r('RESET_PASSWORD'));
?>
</div>
</div>
<div class="wrapper clearfix">

	<div id="maincontent">
		<div class="main">

			<h3><?php i18n('RESET_PASSWORD'); ?></h3>
			<p class="desc"><?php i18n('Enter_and_confirm'); ?></p>

			<form class="login" action="<?php myself(); ?>?user=<?php echo urlencode($user); ?>&amp;token=<?php echo urlencode($token); ?>" method="post">
				<input name="nonce" id="nonce" type="hidden" value="<?php echo get_nonce('reset_password_confirm'); ?>"/>
				<p><b><?php i18n('New_Password'); ?>:</b><br />
				<input class="text" name="newpwd" type="password" value="" /></p>
				<p><b><?php i18n('Confirm_New_Password'); ?>:</b><br />
				<input class="text" name="newpwd2" type="password" value="" /></p>
				<p><input class="submit" type="submit" name="submitted" value="<?php i18n('Set_New_Password'); ?>" /></p>
			</form>

			<p class="cta"><b>&laquo;</b> <a href="<?php echo $SITEURL; ?>"><?php i18n('BACK_TO_WEBSITE'); ?></a></p>

		</div>
	</div>

<?php get_template('footer'); ?>