<?php
/**
 * SMTP Test Email
 *
 * Sends a test email to the logged-in admin user using the current SMTP config.
 * Called via AJAX from the Settings page SMTP section.
 *
 * Requires a valid admin session and a nonce to prevent CSRF.
 *
 * @package    GetSimpleCMS-CE
 * @since      v3.3.23
 */

$load['plugin'] = true;
include('common.php');   // file lives in admin/inc/, so common.php is a sibling

header('Content-Type: application/json; charset=utf-8');

// Auth check — use cookie_check() directly so we can return JSON on failure
// rather than letting login_cookie_check() issue an HTML redirect
if (!cookie_check()) {
	http_response_code(401);
	echo json_encode(['status' => 'error', 'message' => 'Session expired. Please log in again.']);
	exit;
}
create_cookie(); // refresh the cookie, mirroring what login_cookie_check() does on success

// ── CSRF check ────────────────────────────────────────────────────────────────
if (!defined('GSNOCSRF') || GSNOCSRF == false) {
	$nonce = $_POST['nonce'] ?? '';
	if (!check_nonce($nonce, 'smtp_test', 'gs-mailer-test')) {
		echo json_encode(['status' => 'error', 'message' => i18n_r('SMTP_TEST_ERROR_CSRF')]);
		exit;
	}
}

// ── Guard: gs-mailer.php must be loaded ──────────────────────────────────────
if (!function_exists('gs_load_smtp_config') || !function_exists('gs_sendmail_smtp')) {
	echo json_encode(['status' => 'error', 'message' => 'GS Mailer not available.']);
	exit;
}

// ── Load current saved SMTP config ───────────────────────────────────────────
$cfg = gs_load_smtp_config();
if ($cfg === null) {
	echo json_encode(['status' => 'error', 'message' => i18n_r('SMTP_TEST_NOT_CONFIGURED')]);
	exit;
}

// ── Resolve recipient — logged-in user's email address ───────────────────────
global $USR;
$user_data = getXML(GSUSERSPATH . _id($USR) . '.xml');
$to = $user_data ? trim((string)$user_data->EMAIL) : '';

if (empty($to) || !check_email_address($to)) {
	echo json_encode(['status' => 'error', 'message' => i18n_r('SMTP_TEST_NO_RECIPIENT')]);
	exit;
}

// ── Build test message ────────────────────────────────────────────────────────
$subject = i18n_r('SMTP_TEST_SUBJECT');
$body    = email_template(
	'<h2>' . i18n_r('SMTP_TEST_SUBJECT') . '</h2>' .
	'<p>' . i18n_r('SMTP_TEST_BODY') . '</p>'
);

$encoded_subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';

// ── Send ──────────────────────────────────────────────────────────────────────
$debug  = '';
$result = gs_sendmail_smtp($to, $encoded_subject, $body, $cfg, $debug);

if ($result === 'success') {
	echo json_encode([
		'status'  => 'success',
		'message' => sprintf(i18n_r('SMTP_TEST_SUCCESS'), htmlspecialchars($to)),
	]);
} else {
	// Strip the 'error: ' prefix for display; detail is also in the server error log
	$detail = (strpos($result, 'error: ') === 0) ? substr($result, 7) : i18n_r('SMTP_TEST_FAILED');
	echo json_encode([
		'status'  => 'error',
		'message' => htmlspecialchars($detail),
		'debug'   => htmlspecialchars(trim($debug)),
	]);
}