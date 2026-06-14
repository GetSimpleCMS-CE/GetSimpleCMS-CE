<?php
/**
 * GS Mailer — SMTP abstraction for GetSimpleCMS-CE
 *
 * Loaded by basic.php via a guarded require_once.
 * Provides a drop-in SMTP path for sendmail(), driven by data/other/smtp.xml.
 * Falls back transparently to PHP mail() when smtp.xml is absent or disabled.
 *
 * Public API
 * ----------
 * gs_load_smtp_config()      — decrypt + return config array, or null
 * gs_load_smtp_config_raw()  — return config array without password (for UI display)
 * gs_save_smtp_config()      — encrypt + write smtp.xml, chmod 0600
 * gs_sendmail_smtp()         — send via PHPMailer; returns 'success' or 'error'
 * gs_smtp_encrypt()          — AES-256-CBC encrypt a string
 * gs_smtp_decrypt()          — AES-256-CBC decrypt a string
 *
 * PHPMailer
 * ---------
 * Expects PHPMailer 7.x source files at:
 *   admin/inc/phpmailer/src/Exception.php
 *   admin/inc/phpmailer/src/SMTP.php
 *   admin/inc/phpmailer/src/PHPMailer.php
 *
 * @package    GetSimpleCMS-CE
 * @since      v3.3.23
 */

// ── PHPMailer loader ──────────────────────────────────────────────────────────

/**
 * Require PHPMailer 7.x source files exactly once.
 * Returns true on success, false if any file is missing.
 *
 * @return bool
 */
function gs_phpmailer_load(): bool {
	static $loaded = false;
	if ($loaded) return true;

	$base = GSADMININCPATH . 'phpmailer/src/';
	// Exception must be loaded before SMTP and PHPMailer
	foreach (['Exception.php', 'SMTP.php', 'PHPMailer.php'] as $file) {
		if (!file_exists($base . $file)) {
			error_log('GS Mailer: PHPMailer file not found — ' . $base . $file);
			return false;
		}
		require_once $base . $file;
	}

	$loaded = true;
	return true;
}

// ── Config I/O ────────────────────────────────────────────────────────────────

/**
 * Load smtp.xml, decrypt the password, and return the config array.
 * Returns null when the file does not exist or SMTP is disabled —
 * sendmail() uses this as the signal to fall back to PHP mail().
 *
 * @return array|null
 */
function gs_load_smtp_config(): ?array {
	$file = GSDATAOTHERPATH . 'smtp.xml';
	if (!file_exists($file)) return null;

	$xml = @simplexml_load_file($file);
	if (!$xml) return null;

	// Not enabled — return null so sendmail() uses mail()
	if ((string)$xml->enabled !== '1') return null;

	return [
		'host'       => (string)$xml->host,
		'port'       => (int)$xml->port ?: 587,
		'enc'        => (string)$xml->enc,        // 'tls', 'ssl', or ''
		'user'       => (string)$xml->user,
		'pass'       => gs_smtp_decrypt((string)$xml->pass),
		'from_email' => (string)$xml->from_email,
		'from_name'  => (string)$xml->from_name,
		'verify_peer'=> isset($xml->verify_peer) && (string)$xml->verify_peer === '0' ? '0' : '1',
	];
}

/**
 * Load smtp.xml for UI display — password field is intentionally omitted
 * so the decrypted value is never sent to the browser.
 * Returns an empty array when the file does not exist.
 *
 * @return array
 */
function gs_load_smtp_config_raw(): array {
	$file = GSDATAOTHERPATH . 'smtp.xml';
	if (!file_exists($file)) return [];

	$xml = @simplexml_load_file($file);
	if (!$xml) return [];

	return [
		'enabled'    => (string)$xml->enabled,
		'host'       => (string)$xml->host,
		'port'       => (string)$xml->port,
		'enc'        => (string)$xml->enc,
		'user'       => (string)$xml->user,
		'from_email' => (string)$xml->from_email,
		'from_name'  => (string)$xml->from_name,
		'verify_peer'=> isset($xml->verify_peer) && (string)$xml->verify_peer === '0' ? '0' : '1',
		// 'pass' deliberately absent — never expose to the UI
	];
}

/**
 * Write smtp.xml and enforce 0600 permissions.
 *
 * Pass $newpass = '' to preserve the existing encrypted password (e.g. when
 * the settings form password field was left blank). Pass a non-empty string
 * to replace it with a freshly encrypted value.
 *
 * The chmod(0600) call is intentionally not delegated to XMLsave() /
 * GSCHMOD, because smtp.xml contains a credential and must never be
 * world-readable regardless of the host's general file permission policy.
 *
 * @param  array  $cfg      Config values (enabled, host, port, enc, user,
 *                          from_email, from_name). Do not include 'pass'.
 * @param  string $newpass  Plaintext password to encrypt, or '' to keep existing.
 * @return bool             True on success.
 */
function gs_save_smtp_config(array $cfg, string $newpass = ''): bool {
	$file = GSDATAOTHERPATH . 'smtp.xml';

	// Resolve the encrypted password to store
	if ($newpass !== '') {
		$encpass = gs_smtp_encrypt($newpass);
	} elseif (file_exists($file)) {
		// Preserve existing encrypted value
		$existing = @simplexml_load_file($file);
		$encpass  = $existing ? (string)$existing->pass : '';
	} else {
		$encpass = '';
	}

	$xml = new SimpleXMLExtended('<?xml version="1.0" encoding="UTF-8"?><smtp></smtp>');
	$xml->addChild('enabled',    !empty($cfg['enabled']) && $cfg['enabled'] === '1' ? '1' : '0');
	$xml->addChild('host',       htmlspecialchars(trim($cfg['host']       ?? ''), ENT_XML1, 'UTF-8'));
	$xml->addChild('port',       max(1, min(65535, (int)($cfg['port']     ?? 587))));
	$xml->addChild('enc',        in_array($cfg['enc'] ?? '', ['tls', 'ssl', ''], true) ? $cfg['enc'] : 'tls');
	$xml->addChild('user',       htmlspecialchars(trim($cfg['user']       ?? ''), ENT_XML1, 'UTF-8'));
	$xml->addChild('pass',       $encpass);
	$xml->addChild('from_email', htmlspecialchars(trim($cfg['from_email'] ?? ''), ENT_XML1, 'UTF-8'));
	$xml->addChild('from_name',  htmlspecialchars(trim($cfg['from_name']  ?? ''), ENT_XML1, 'UTF-8'));
	$xml->addChild('verify_peer', ($cfg['verify_peer'] ?? '1') === '0' ? '0' : '1');

	// XMLsave handles file_put_contents + its own chmod via GSCHMOD
	$ok = XMLsave($xml, $file);

	// Security override: always enforce 0600 for this file, regardless of GSCHMOD.
	// smtp.xml contains an encrypted credential; it must not be world-readable.
	if (file_exists($file)) {
		chmod($file, 0600);
	}

	return (bool)$ok;
}

// ── SMTP send ─────────────────────────────────────────────────────────────────

/**
 * Send an email via PHPMailer / SMTP.
 *
 * The $subject string must already be base64/UTF-8 encoded by the caller
 * (sendmail() in basic.php handles this to stay consistent with the mail()
 * path). The $message body should be the HTML output of email_template().
 *
 * Mirrors the GSFROMEMAIL override behaviour of the legacy mail() path.
 *
 * @param  string $to
 * @param  string $subject  UTF-8 encoded subject (=?UTF-8?B?...?= format)
 * @param  string $message  HTML message body
 * @param  array  $cfg      Config array from gs_load_smtp_config()
 * @param  string &$debug   Optional. Pass a variable by reference to capture the
 *                          full SMTP connection transcript (for the test endpoint).
 * @return string           'success', or 'error: <message>' on failure
 */
function gs_sendmail_smtp(string $to, string $subject, string $message, array $cfg, string &$debug = ''): string {
	if (!gs_phpmailer_load()) {
		return 'error: PHPMailer files not found in ' . GSADMININCPATH . 'phpmailer/src/';
	}

	// Honour GSFROMEMAIL constant override — matches the mail() path in sendmail()
	// check_email_address() is defined in template_functions.php, loaded by common.php
	if (defined('GSFROMEMAIL') && function_exists('check_email_address') && check_email_address(GSFROMEMAIL)) {
		$from_email = GSFROMEMAIL;
	} elseif (!empty($cfg['from_email'])) {
		$from_email = $cfg['from_email'];
	} else {
		$from_email = 'noreply@' . ($_SERVER['SERVER_NAME'] ?? 'localhost');
	}
	$from_name = $cfg['from_name'] ?? '';

	$mail = new PHPMailer\PHPMailer\PHPMailer(true); // true = throw exceptions

	// Capture debug transcript if caller passed a $debug reference
	if (func_num_args() >= 5) {
		$mail->SMTPDebug   = 3; // 3 = connection + commands + data
		$mail->Debugoutput = function(string $str, int $level) use (&$debug) {
			$debug .= $str . "\n";
		};
	}

	try {
		$mail->isSMTP();
		$mail->Host = $cfg['host'];
		$mail->Port = $cfg['port'];

		// Encryption
		if ($cfg['enc'] === 'ssl') {
			$mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
		} elseif ($cfg['enc'] === 'tls') {
			$mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
		} else {
			// No encryption — disable auto-TLS so PHPMailer does not try to upgrade
			$mail->SMTPSecure  = '';
			$mail->SMTPAutoTLS = false;
		}

		// Authentication — only enable when credentials are provided
		// SSL certificate verification — disable only for local/dev environments
		// using self-signed certificates. Always leave enabled in production.
		if (($cfg['verify_peer'] ?? '1') === '0') {
			$mail->SMTPOptions = [
				'ssl' => [
					'verify_peer'       => false,
					'verify_peer_name'  => false,
					'allow_self_signed' => true,
				],
			];
		}

		$mail->SMTPAuth = !empty($cfg['user']) && !empty($cfg['pass']);
		if ($mail->SMTPAuth) {
			$mail->Username = $cfg['user'];
			$mail->Password = $cfg['pass'];
		}

		$mail->CharSet = PHPMailer\PHPMailer\PHPMailer::CHARSET_UTF8;
		$mail->setFrom($from_email, $from_name);
		$mail->addAddress($to);

		// Subject is already encoded by sendmail() — pass as-is
		$mail->Subject = $subject;
		$mail->isHTML(true);
		$mail->Body    = $message;

		$mail->send();
		return 'success';

	} catch (PHPMailer\PHPMailer\Exception $e) {
		error_log('GS Mailer SMTP error: ' . $e->getMessage());
		return 'error: ' . $e->getMessage();
	}
}

// ── Encryption helpers ────────────────────────────────────────────────────────

/**
 * Derive a 32-byte AES key from the site's $SALT global.
 *
 * $SALT is available globally after common.php loads (sourced from either
 * GSUSECUSTOMSALT in gsconfig.php or data/other/authorization.xml).
 * The 'gs-smtp' suffix is a domain separator so this key is distinct from
 * any other future AES usage derived from the same salt.
 *
 * @return string 32 raw bytes
 */
function gs_smtp_key(): string {
	global $SALT;
	return hash('sha256', $SALT . 'gs-smtp', true);
}

/**
 * Encrypt a plaintext string with AES-256-CBC.
 * Output format: base64( IV[16] . ciphertext )
 *
 * @param  string $plain
 * @return string Base64-encoded ciphertext, or '' for empty input
 */
function gs_smtp_encrypt(string $plain): string {
	if ($plain === '') return '';
	$iv  = random_bytes(16);
	$enc = openssl_encrypt($plain, 'AES-256-CBC', gs_smtp_key(), OPENSSL_RAW_DATA, $iv);
	return base64_encode($iv . $enc);
}

/**
 * Decrypt a value produced by gs_smtp_encrypt().
 * Returns '' on failure rather than false, so callers need no type checks.
 *
 * @param  string $stored Base64-encoded ciphertext from smtp.xml
 * @return string Plaintext password, or '' on any error
 */
function gs_smtp_decrypt(string $stored): string {
	if (empty($stored)) return '';
	$raw = base64_decode($stored, true);
	// Minimum valid length: 16-byte IV + at least 1 byte of ciphertext
	if ($raw === false || strlen($raw) < 17) return '';
	$dec = openssl_decrypt(
		substr($raw, 16),
		'AES-256-CBC',
		gs_smtp_key(),
		OPENSSL_RAW_DATA,
		substr($raw, 0, 16)
	);
	return $dec === false ? '' : $dec;
}