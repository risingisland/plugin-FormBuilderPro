<?php if (!defined('IN_GS')) { die('You cannot load this page directly.'); }

/*
Plugin Name: Form Builder Pro
Description: Drag-n-drop form builder with mail() and SMTP. (SQLite3 required)
Version: 1.2
Author: risingisland
Author URI: https://ko-fi.com/ericmontgomery
*/

i18n_merge('FormBuilderPro') || i18n_merge('FormBuilderPro', 'en_US');

// ─── Constants ───────────────────────────────────────────────────────────────
define('FormBuilderPro_DB_PATH',	 GSDATAOTHERPATH . 'FormBuilderPro.db');
define('FormBuilderPro_SLUG',		basename(__FILE__, '.php'));
define('FormBuilderPro_PLUGIN_DIR',  GSPLUGINPATH	. FormBuilderPro_SLUG . '/');
define('FormBuilderPro_PLUGIN_URL',  $SITEURL . 'plugins/' . FormBuilderPro_SLUG . '/');
define('FormBuilderPro_UPLOAD_DIR',  GSDATAOTHERPATH . 'fbp_uploads/');

// ─── Bootstrap ───────────────────────────────────────────────────────────────

register_plugin(
	FormBuilderPro_SLUG,
	'Form Builder Pro',
	'1.2',
	'risingisland',
	'https://ko-fi.com/ericmontgomery',
	'Drag-n-drop form builder with mail() and SMTP. (SQLite3 required)',
	'theme',
	'FormBuilderPro_admin_page'
);

add_action('theme-sidebar', 'createSideMenu', array(
	FormBuilderPro_SLUG,
	i18n_r('FormBuilderPro/lang_Menu_Title') . ' <svg xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;" width="22" height="22" viewBox="0 0 28 28"><path d="M0 0h28v28H0z" fill="none"/><g fill="none"><path fill="url(#SVGErK8BdUl)" d="M6.75 3A3.75 3.75 0 0 0 3 6.75v14.5A3.75 3.75 0 0 0 6.75 25h14.5A3.75 3.75 0 0 0 25 21.25V6.75A3.75 3.75 0 0 0 21.25 3z"/><path fill="url(#SVGkRQBvetf)" d="M6 12.5a2.5 2.5 0 1 1 5 0a2.5 2.5 0 0 1-5 0M8.5 17a2.5 2.5 0 1 0 0 5a2.5 2.5 0 0 0 0-5m4.5-4.75a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5a.75.75 0 0 1-.75-.75m.75 6.25a.75.75 0 0 0 0 1.5h7.5a.75.75 0 0 0 0-1.5zM6 7.25a.75.75 0 0 1 .75-.75h14.5a.75.75 0 0 1 0 1.5H6.75A.75.75 0 0 1 6 7.25"/><defs><linearGradient id="SVGErK8BdUl" x1="10.857" x2="19.286" y1="3" y2="23.814" gradientUnits="userSpaceOnUse"><stop stop-color="#b3e0ff"/><stop offset="1" stop-color="#8cd0ff"/></linearGradient><linearGradient id="SVGkRQBvetf" x1="5.2" x2="24.614" y1="5.725" y2="9.282" gradientUnits="userSpaceOnUse"><stop stop-color="#0094f0"/><stop offset="1" stop-color="#2764e7"/></linearGradient></defs></g></svg>',
	'?id=' . FormBuilderPro_SLUG
));

FormBuilderPro_init_db();

// ── Early AJAX intercept ──────────────────────────────────────────────────────
if (
	!empty($_REQUEST['fb_action']) &&
	isset($_GET['id']) && $_GET['id'] === FormBuilderPro_SLUG
) {
	FormBuilderPro_handle_ajax($_REQUEST['fb_action']);
	exit;
}

add_action('index-pretemplate', 'FormBuilderPro_process_submission');

// ─────────────────────────────────────────────────────────────────────────────
// DATABASE & AUTH
// ─────────────────────────────────────────────────────────────────────────────

function FormBuilderPro_db() {
	static $db = null;
	if ($db === null) {
		$db = new SQLite3(FormBuilderPro_DB_PATH);
		$db->busyTimeout(5000);
		$db->exec('PRAGMA journal_mode=WAL;');
	}
	return $db;
}

function FormBuilderPro_init_db() {
	$db = FormBuilderPro_db();
	$db->exec("
		CREATE TABLE IF NOT EXISTS fbp_forms (
			id			INTEGER PRIMARY KEY AUTOINCREMENT,
			name	  	TEXT	NOT NULL,
			slug	  	TEXT	NOT NULL UNIQUE,
			fields		TEXT	NOT NULL DEFAULT '[]',
			settings  	TEXT	NOT NULL DEFAULT '{}',
			created   	INTEGER NOT NULL DEFAULT (strftime('%s','now')),
			updated   	INTEGER NOT NULL DEFAULT (strftime('%s','now'))
		);
		CREATE TABLE IF NOT EXISTS fbp_submissions (
			id			INTEGER PRIMARY KEY AUTOINCREMENT,
			form_id   	INTEGER NOT NULL,
			data	  	TEXT	NOT NULL,
			ip			TEXT,
			submitted 	INTEGER NOT NULL DEFAULT (strftime('%s','now'))
		);
		CREATE TABLE IF NOT EXISTS fbp_upload_tokens (
			id				INTEGER PRIMARY KEY AUTOINCREMENT,
			token			TEXT	NOT NULL UNIQUE,
			safe_filename	TEXT	NOT NULL,
			original_filename TEXT	NOT NULL,
			form_id			INTEGER NOT NULL,
			submission_id	INTEGER NOT NULL DEFAULT 0,
			created			INTEGER NOT NULL DEFAULT (strftime('%s','now'))
		);
	");

	if (!is_dir(FormBuilderPro_UPLOAD_DIR)) {
		@mkdir(FormBuilderPro_UPLOAD_DIR, 0755, true);
	}
	$htaccess = FormBuilderPro_UPLOAD_DIR . '.htaccess';
	if (!file_exists($htaccess)) {
		@file_put_contents($htaccess, "Deny from all\n");
	}
}

function FormBuilderPro_get_token_nonce() {
	if (function_exists('get_nonce')) {
		return get_nonce('fbp_admin_action', 'fbp');
	}
	if (function_exists('create_nonce')) {
		return create_nonce('fbp_admin_action', 'fbp');
	}
	return 'fbp_nonce';
}

function FormBuilderPro_check_auth_or_die() {
	if (!function_exists('cookie_check') && defined('GSADMININCPATH') && file_exists(GSADMININCPATH . 'inc/cookie_functions.php')) {
		require_once(GSADMININCPATH . 'inc/cookie_functions.php');
	}

	$is_admin = function_exists('cookie_check') ? cookie_check() : false;
	if (!$is_admin) {
		header('Content-Type: application/json; charset=utf-8');
		http_response_code(403);
		echo json_encode(['ok' => false, 'msg' => 'Access denied: please log in.']);
		exit;
	}

	$nonce = $_POST['fb_nonce'] ?? $_GET['fb_nonce'] ?? '';
	$valid_nonce = false;

	if (function_exists('check_nonce') && !empty($nonce)) {
		try {
			$valid_nonce = check_nonce($nonce, 'fbp_admin_action', 'fbp')
						|| check_nonce($nonce, 'fbp_admin_action')
						|| check_nonce($nonce, 'load.php?id=' . FormBuilderPro_SLUG);
		} catch (\Throwable $e) {}
	}

	if (!$valid_nonce && !$is_admin) {
		header('Content-Type: application/json; charset=utf-8');
		http_response_code(403);
		echo json_encode(['ok' => false, 'msg' => 'Security check failed. Please reload.']);
		exit;
	}
}

// ─────────────────────────────────────────────────────────────────────────────
// HELPERS
// ─────────────────────────────────────────────────────────────────────────────

function FormBuilderPro_generate_token() {
	return bin2hex(random_bytes(24)); // 48 hex chars
}

function FormBuilderPro_create_token($safe, $original, $form_id, $submission_id = 0) {
	$db	= FormBuilderPro_db();
	$token = FormBuilderPro_generate_token();
	$stmt  = $db->prepare("INSERT INTO fbp_upload_tokens (token, safe_filename, original_filename, form_id, submission_id) VALUES (:t,:s,:o,:fid,:sid)");
	$stmt->bindValue(':t',   $token,		 SQLITE3_TEXT);
	$stmt->bindValue(':s',   $safe,		  SQLITE3_TEXT);
	$stmt->bindValue(':o',   $original,	  SQLITE3_TEXT);
	$stmt->bindValue(':fid', (int)$form_id,  SQLITE3_INTEGER);
	$stmt->bindValue(':sid', (int)$submission_id, SQLITE3_INTEGER);
	$stmt->execute();
	return $token;
}

function FormBuilderPro_get_token($token) {
	$db   = FormBuilderPro_db();
	$stmt = $db->prepare("SELECT * FROM fbp_upload_tokens WHERE token = :t LIMIT 1");
	$stmt->bindValue(':t', $token, SQLITE3_TEXT);
	$res  = $stmt->execute();
	return $res ? $res->fetchArray(SQLITE3_ASSOC) : null;
}

// Build the public token download URL
function FormBuilderPro_download_url($token) {
	global $SITEURL;
	return $SITEURL . 'plugins/FormBuilderPro/public/download.php?token=' . urlencode($token);
}

function FormBuilderPro_get_forms() {
	$db  = FormBuilderPro_db();
	$res = $db->query("SELECT * FROM fbp_forms ORDER BY updated DESC");
	$out = [];
	while ($row = $res->fetchArray(SQLITE3_ASSOC)) { $out[] = $row; }
	return $out;
}

function FormBuilderPro_get_form($id) {
	$db   = FormBuilderPro_db();
	$stmt = $db->prepare("SELECT * FROM fbp_forms WHERE id = :id LIMIT 1");
	$stmt->bindValue(':id', (int)$id, SQLITE3_INTEGER);
	$res  = $stmt->execute();
	return $res ? $res->fetchArray(SQLITE3_ASSOC) : null;
}

function FormBuilderPro_get_form_by_slug($slug) {
	$db   = FormBuilderPro_db();
	$stmt = $db->prepare("SELECT * FROM fbp_forms WHERE slug = :s LIMIT 1");
	$stmt->bindValue(':s', $slug, SQLITE3_TEXT);
	$res  = $stmt->execute();
	return $res ? $res->fetchArray(SQLITE3_ASSOC) : null;
}

function FormBuilderPro_slugify($str) {
	$str = strtolower(trim($str));
	$str = preg_replace('/[^a-z0-9\-]+/', '-', $str);
	return trim($str, '-');
}

function FormBuilderPro_unique_slug($name, $exclude_id = 0) {
	$db   = FormBuilderPro_db();
	$base = FormBuilderPro_slugify($name);
	$slug = $base;
	$i	= 1;
	while (true) {
		$stmt = $db->prepare("SELECT id FROM fbp_forms WHERE slug = :s AND id != :ex");
		$stmt->bindValue(':s',  $slug, SQLITE3_TEXT);
		$stmt->bindValue(':ex', (int)$exclude_id, SQLITE3_INTEGER);
		$res = $stmt->execute()->fetchArray();
		if (!$res) break;
		$slug = $base . '-' . $i++;
	}
	return $slug;
}

// ─────────────────────────────────────────────────────────────────────────────
// FORM SUBMISSION HANDLER (FRONT-END)
// ─────────────────────────────────────────────────────────────────────────────

function FormBuilderPro_process_submission() {
	if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['_fb_form_id'])) return;

	$form_id = (int)$_POST['_fb_form_id'];
	$form	= FormBuilderPro_get_form($form_id);
	if (!$form) return;

	$fields   = json_decode($form['fields'],   true) ?: [];
	$settings = json_decode($form['settings'], true) ?: [];
	$data	 = [];
	$errors   = [];

	// ── Spam checks ───────────────────────────────────────────────────────────
	if (!empty($settings['honeypot']) && !empty($_POST['_fb_hp'])) {
		FormBuilderPro_redirect_result($form_id, 'ok');
		return;
	}
	if (!empty($settings['timecheck']) && isset($_POST['_fb_ts'])) {
		$min_seconds = (int)($settings['timecheck_min'] ?? 3);
		if ((time() - (int)$_POST['_fb_ts']) < $min_seconds) {
			FormBuilderPro_redirect_result($form_id, 'ok');
			return;
		}
	}
	if (!empty($settings['turnstile_secret_key']) && ($settings['captcha_method'] ?? '') === 'turnstile') {
		$token = $_POST['cf-turnstile-response'] ?? '';
		if (!FormBuilderPro_verify_turnstile($settings['turnstile_secret_key'], $token)) {
			if (session_status() === PHP_SESSION_NONE) @session_start();
			$_SESSION['fb_errors_' . $form_id] = [i18n_r('FormBuilderPro/lang_Turnstile_Failed')];
			@session_write_close();
			FormBuilderPro_redirect_result($form_id, 'err');
			return;
		}
	}
	if (!empty($settings['hcaptcha_secret_key']) && ($settings['captcha_method'] ?? '') === 'hcaptcha') {
		$token = $_POST['h-captcha-response'] ?? '';
		if (!FormBuilderPro_verify_hcaptcha($settings['hcaptcha_secret_key'], $token)) {
			if (session_status() === PHP_SESSION_NONE) @session_start();
			$_SESSION['fb_errors_' . $form_id] = [i18n_r('FormBuilderPro/lang_HCaptcha_Failed')];
			@session_write_close();
			FormBuilderPro_redirect_result($form_id, 'err');
			return;
		}
	}
	if (!empty($settings['recaptcha2_secret_key']) && ($settings['captcha_method'] ?? '') === 'recaptcha2') {
		$token = $_POST['g-recaptcha-response'] ?? '';
		if (!FormBuilderPro_verify_recaptcha($settings['recaptcha2_secret_key'], $token)) {
			if (session_status() === PHP_SESSION_NONE) @session_start();
			$_SESSION['fb_errors_' . $form_id] = [i18n_r('FormBuilderPro/lang_Recaptcha_Failed')];
			@session_write_close();
			FormBuilderPro_redirect_result($form_id, 'err');
			return;
		}
	}
	if (!empty($settings['recaptcha3_secret_key']) && ($settings['captcha_method'] ?? '') === 'recaptcha3') {
		$token	 = $_POST['_fb_recaptcha3_token'] ?? '';
		$threshold = (float)($settings['recaptcha3_threshold'] ?? 0.5);
		if (!FormBuilderPro_verify_recaptcha3($settings['recaptcha3_secret_key'], $token, $threshold)) {
			if (session_status() === PHP_SESSION_NONE) @session_start();
			$_SESSION['fb_errors_' . $form_id] = [i18n_r('FormBuilderPro/lang_Recaptcha_Failed')];
			@session_write_close();
			FormBuilderPro_redirect_result($form_id, 'err');
			return;
		}
	}

	foreach ($fields as $f) {
		$name  = $f['name']	?? '';
		$label = $f['label']   ?? $name;
		$req   = !empty($f['required']);
		$type  = $f['type']	?? 'text';
		$val   = '';

		// Normalise library type names
		if ($type === 'radio-group')	$type = 'radio';
		if ($type === 'checkbox-group') $type = 'checkbox';

		if ($type === 'header' || $type === 'paragraph') continue;

		if ($type === 'file') {
			if (!empty($_FILES[$name]['name'])) {
				$upload_dir	= FormBuilderPro_UPLOAD_DIR;
				$original	  = basename($_FILES[$name]['name']);
				$ext		   = strtolower(pathinfo($original, PATHINFO_EXTENSION));
				$max_mb		= (float)($f['max_size'] ?? 5);
				$max_bytes	 = $max_mb * 1024 * 1024;

				// Strict dangerous extension blacklist
				$disallowed	= ['php', 'phtml', 'php3', 'php4', 'php5', 'php7', 'phps', 'cgi', 'pl', 'asp', 'aspx', 'jsp', 'sh', 'htaccess', 'phar'];
				$raw_allowed   = $f['allowed_types'] ?? 'pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif,zip';
				$allowed_exts  = array_map('trim', explode(',', strtolower($raw_allowed)));
				$allowed_exts  = array_diff(array_filter($allowed_exts), $disallowed);

				if (!in_array($ext, $allowed_exts, true) || in_array($ext, $disallowed, true)) {
					$errors[] = $label . ': file type .' . htmlspecialchars($ext) . ' is not allowed.';
				} elseif ($_FILES[$name]['size'] > $max_bytes) {
					$errors[] = $label . ': file exceeds maximum size of ' . $max_mb . ' MB.';
				} else {
					// Safe storage: append .bin so file is non-executable on any server
					$safe = bin2hex(random_bytes(16)) . '.bin';
					if (move_uploaded_file($_FILES[$name]['tmp_name'], $upload_dir . $safe)) {
						$token = FormBuilderPro_create_token($safe, $original, $form_id);
						$val   = $safe . '|' . $original . '|' . $token;
					}
				}
			}
		} elseif ($type === 'checkbox') {
			$raw  = $_POST[$name] ?? [];
			$raw  = is_array($raw) ? array_map('strip_tags', $raw) : [strip_tags((string)$raw)];
			if (in_array('other', $raw) && isset($_POST[$name . '-other'])) {
				$raw   = array_diff($raw, ['other']);
				$other = strip_tags(trim($_POST[$name . '-other']));
				if ($other !== '') $raw[] = $other;
			}
			$val = implode(', ', $raw);
		} elseif ($type === 'radio') {
			$val = strip_tags(trim($_POST[$name] ?? ''));
			if ($val === 'other' && isset($_POST[$name . '-other'])) {
				$val = strip_tags(trim($_POST[$name . '-other']));
			}
		} else {
			$val = strip_tags(trim($_POST[$name] ?? ''));
		}

		if ($req && $val === '') {
			$errors[] = $label . ' is required.';
		}
		$data[$label] = $val;
	}

	if (!empty($errors)) {
		if (session_status() === PHP_SESSION_NONE) @session_start();
		$_SESSION['fb_errors_' . $form_id] = $errors;
		$_SESSION['fb_old_'	. $form_id] = $_POST;
		@session_write_close();
		FormBuilderPro_redirect_result($form_id, 'err');
		return;
	}

	// Store submission
	$db   = FormBuilderPro_db();
	$stmt = $db->prepare("INSERT INTO fbp_submissions (form_id, data, ip) VALUES (:fid, :d, :ip)");
	$stmt->bindValue(':fid', $form_id,					  SQLITE3_INTEGER);
	$stmt->bindValue(':d',   json_encode($data),			SQLITE3_TEXT);
	$stmt->bindValue(':ip',  $_SERVER['REMOTE_ADDR'] ?? '', SQLITE3_TEXT);
	$stmt->execute();
	$submission_id = $db->lastInsertRowID();

	foreach ($data as $val) {
		$parts = explode('|', $val);
		if (count($parts) === 3) {
			$upd = $db->prepare("UPDATE fbp_upload_tokens SET submission_id=:sid WHERE token=:t");
			$upd->bindValue(':sid', (int)$submission_id, SQLITE3_INTEGER);
			$upd->bindValue(':t',   $parts[2],		   SQLITE3_TEXT);
			$upd->execute();
		}
	}

	try {
		FormBuilderPro_send_email($form, $settings, $data, $fields);
	} catch (\Throwable $e) {}

	FormBuilderPro_redirect_result($form_id, 'ok');
}

function FormBuilderPro_redirect_result($form_id, $status) {
	$url	= strtok($_SERVER['REQUEST_URI'], '?');
	$params = $_GET;
	unset($params['fb_form'], $params['fb_status']);
	$params['fb_form']   = $form_id;
	$params['fb_status'] = $status;
	header('Location: ' . $url . '?' . http_build_query($params) . '#fb-form-' . $form_id);
	exit;
}

function FormBuilderPro_verify_turnstile($secret, $token) {
	if (empty($token)) return false;

	$payload = http_build_query([
		'secret'   => $secret,
		'response' => $token,
		'remoteip' => $_SERVER['REMOTE_ADDR'] ?? '',
	]);

	if (function_exists('curl_init')) {
		$ch = curl_init('https://challenges.cloudflare.com/turnstile/v0/siteverify');
		curl_setopt_array($ch, [
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST		   => true,
			CURLOPT_POSTFIELDS	 => $payload,
			CURLOPT_TIMEOUT		=> 10,
			CURLOPT_HTTPHEADER	 => ['Content-Type: application/x-www-form-urlencoded'],
		]);
		$response = curl_exec($ch);
		curl_close($ch);
	} else {
		$response = @file_get_contents(
			'https://challenges.cloudflare.com/turnstile/v0/siteverify',
			false,
			stream_context_create(['http' => [
				'method'  => 'POST',
				'header'  => 'Content-Type: application/x-www-form-urlencoded',
				'content' => $payload,
				'timeout' => 10,
			]])
		);
	}

	if (!$response) return false;
	$data = json_decode($response, true);
	return !empty($data['success']);
}

function FormBuilderPro_verify_hcaptcha($secret, $token) {
	if (empty($token)) return false;

	$payload = http_build_query([
		'secret'   => $secret,
		'response' => $token,
		'remoteip' => $_SERVER['REMOTE_ADDR'] ?? '',
	]);

	if (function_exists('curl_init')) {
		$ch = curl_init('https://hcaptcha.com/siteverify');
		curl_setopt_array($ch, [
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST		   => true,
			CURLOPT_POSTFIELDS	 => $payload,
			CURLOPT_TIMEOUT		=> 10,
			CURLOPT_HTTPHEADER	 => ['Content-Type: application/x-www-form-urlencoded'],
		]);
		$response = curl_exec($ch);
		curl_close($ch);
	} else {
		$response = @file_get_contents(
			'https://hcaptcha.com/siteverify',
			false,
			stream_context_create(['http' => [
				'method'  => 'POST',
				'header'  => 'Content-Type: application/x-www-form-urlencoded',
				'content' => $payload,
				'timeout' => 10,
			]])
		);
	}

	if (!$response) return false;
	$data = json_decode($response, true);
	return !empty($data['success']);
}

function FormBuilderPro_verify_recaptcha($secret, $token) {
	if (empty($token)) return false;
	$payload = http_build_query([
		'secret'   => $secret,
		'response' => $token,
		'remoteip' => $_SERVER['REMOTE_ADDR'] ?? '',
	]);
	if (function_exists('curl_init')) {
		$ch = curl_init('https://www.google.com/recaptcha/api/siteverify');
		curl_setopt_array($ch, [
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST		   => true,
			CURLOPT_POSTFIELDS	 => $payload,
			CURLOPT_TIMEOUT		=> 10,
			CURLOPT_HTTPHEADER	 => ['Content-Type: application/x-www-form-urlencoded'],
		]);
		$response = curl_exec($ch);
		curl_close($ch);
	} else {
		$response = @file_get_contents('https://www.google.com/recaptcha/api/siteverify', false,
			stream_context_create(['http' => ['method' => 'POST',
				'header' => 'Content-Type: application/x-www-form-urlencoded',
				'content' => $payload, 'timeout' => 10]]));
	}
	if (!$response) return false;
	$data = json_decode($response, true);
	return !empty($data['success']);
}

function FormBuilderPro_verify_recaptcha3($secret, $token, $threshold = 0.5) {
	if (empty($token)) return false;
	$payload = http_build_query([
		'secret'   => $secret,
		'response' => $token,
		'remoteip' => $_SERVER['REMOTE_ADDR'] ?? '',
	]);
	if (function_exists('curl_init')) {
		$ch = curl_init('https://www.google.com/recaptcha/api/siteverify');
		curl_setopt_array($ch, [
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST		   => true,
			CURLOPT_POSTFIELDS	 => $payload,
			CURLOPT_TIMEOUT		=> 10,
			CURLOPT_HTTPHEADER	 => ['Content-Type: application/x-www-form-urlencoded'],
		]);
		$response = curl_exec($ch);
		curl_close($ch);
	} else {
		$response = @file_get_contents('https://www.google.com/recaptcha/api/siteverify', false,
			stream_context_create(['http' => ['method' => 'POST',
				'header' => 'Content-Type: application/x-www-form-urlencoded',
				'content' => $payload, 'timeout' => 10]]));
	}
	if (!$response) return false;
	$data = json_decode($response, true);
	return !empty($data['success']) && (float)($data['score'] ?? 0) >= $threshold;
}

function FormBuilderPro_send_email($form, $settings, $data, $fields = []) {
	$to	  = !empty($settings['email_to']) ? $settings['email_to'] : get_setting('email');
	$subject = !empty($settings['email_subject']) ? $settings['email_subject'] : 'New submission: ' . $form['name'];
	$body	= '';

	// Build email body
	foreach ($data as $k => $v) {
		$parts = explode('|', $v);
		if (count($parts) === 3) {
			$url   = FormBuilderPro_download_url($parts[2]);
			$body .= "$k: " . $parts[1] . "\n";
			$body .= "$k download link: " . $url . "\n";
		} else {
			$body .= "$k: $v\n";
		}
	}

	$reply_to = FormBuilderPro_find_reply_to($form, $data);
	$use_smtp = ($settings['mail_method'] ?? 'php') === 'smtp' && !empty($settings['smtp_host']);

	if (!$use_smtp) {
		if (empty($to)) return ['ok' => false, 'msg' => 'No recipient address configured.'];
		$from		 = FormBuilderPro_from_address($settings);
		$header_lines = [
			'From: ' . $form['name'] . ' <' . $from . '>',
			'Content-Type: text/plain; charset=UTF-8',
			'X-Mailer: Form Builder Pro',
		];
		if ($reply_to) $header_lines[] = 'Reply-To: ' . $reply_to;
		$headers = implode("\r\n", $header_lines);
		$sent	= @mail($to, $subject, $body, $headers);
		return $sent
			? ['ok' => true]
			: ['ok' => false, 'msg' => 'mail() returned false. Check your server mail configuration.'];
	}

	// Collect file paths for attachment (SMTP only)
	$attachments = [];
	if (!empty($settings['attach_files'])) {
		foreach ($data as $v) {
			$parts = explode('|', $v);
			if (count($parts) === 3) {
				$path = FormBuilderPro_UPLOAD_DIR . $parts[0];
				if (file_exists($path)) {
					$attachments[] = ['path' => $path, 'name' => $parts[1]];
				}
			}
		}
	}

	return FormBuilderPro_mailer($settings, $to, $subject, $body, $form['name'], $reply_to, $attachments);
}

// Scan field definitions for an email field with reply_to flag, return its submitted value
function FormBuilderPro_find_reply_to($form, $data) {
	$fields = json_decode($form['fields'], true) ?: [];
	foreach ($fields as $f) {
		$type	= $f['type']	?? '';
		$subtype = $f['subtype'] ?? '';
		$is_email = ($type === 'email')
			|| ($type === 'text' && $subtype === 'email');
		if ($is_email && !empty($f['reply_to'])) {
			$label = $f['label'] ?? $f['name'] ?? '';
			$val   = $data[$label] ?? '';
			if (filter_var($val, FILTER_VALIDATE_EMAIL)) return $val;
		}
	}
	return null;
}

// Returns the best available From address for mail() mode
function FormBuilderPro_from_address($settings) {
	// 1. Explicit from address set in form settings
	if (!empty($settings['email_from'])) return $settings['email_from'];
	// 2. GS site email
	if (function_exists('get_setting') && ($gs = get_setting('email'))) return $gs;
	// 3. Fallback: noreply@ + host without www.
	$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
	$host = preg_replace('/^www\./i', '', $host);
	return 'noreply@' . $host;
}

function FormBuilderPro_mailer($settings, $to, $subject, $body, $from_name = 'formBuilder', $reply_to = null, $attachments = []) {
	if (empty(trim($to ?? ''))) {
		return ['ok' => false, 'msg' => 'No recipient address configured.'];
	}

	try {
		require_once FormBuilderPro_PLUGIN_DIR . 'phpmailer/Exception.php';
		require_once FormBuilderPro_PLUGIN_DIR . 'phpmailer/PHPMailer.php';
		require_once FormBuilderPro_PLUGIN_DIR . 'phpmailer/SMTP.php';

		$mail = new PHPMailer\PHPMailer\PHPMailer(true);

		$use_smtp = !empty($settings['smtp_host']);

		if ($use_smtp) {
			$mail->isSMTP();
			$mail->Host	 = $settings['smtp_host'];
			$mail->Port	 = (int)($settings['smtp_port'] ?? 587);
			$mail->Username = $settings['smtp_user'] ?? '';
			$mail->Password = $settings['smtp_pass'] ?? '';

			$enc = $settings['smtp_enc'] ?? 'tls';
			if ($enc === 'ssl') {
				$mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
			} elseif ($enc === 'tls') {
				$mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
			} else {
				$mail->SMTPSecure  = '';
				$mail->SMTPAutoTLS = false;
			}

			$mail->SMTPAuth = !empty($mail->Username);
			$from = !empty($settings['smtp_from']) ? $settings['smtp_from'] : FormBuilderPro_from_address($settings);
		} else {
			$mail->isMail();
			$from = get_setting('email') ?: ('noreply@' . ($_SERVER['HTTP_HOST'] ?? 'localhost'));
		}

		if (empty(trim($from))) {
			$from = 'noreply@' . ($_SERVER['HTTP_HOST'] ?? 'localhost');
		}

		$mail->setFrom($from, $from_name);
		$mail->addAddress($to);
		if ($reply_to) $mail->addReplyTo($reply_to);
		foreach ($attachments as $att) {
			$mail->addAttachment($att['path'], $att['name']);
		}
		$mail->Subject = $subject;
		$mail->Body	= $body;
		$mail->CharSet = 'UTF-8';

		$mail->send();
		return ['ok' => true];

	} catch (\Throwable $e) {
		$msg = isset($mail) ? $mail->ErrorInfo : $e->getMessage();
		return ['ok' => false, 'msg' => $msg];
	}
}

// ─────────────────────────────────────────────────────────────────────────────
// SHORTCODE & TEMPLATE
// ─────────────────────────────────────────────────────────────────────────────

add_filter('content', 'FormBuilderPro_shortcode_filter');

function FormBuilderPro_shortcode_filter($content) {
	return preg_replace_callback(
		'/\[formbuilderpro\s+([^\]]+)\]/i',
		function($m) {
			preg_match_all('/(\w+)=["\']?([^"\')\s]+)["\']?/', $m[1], $attrs);
			$a = array_combine($attrs[1], $attrs[2]);
			if (!empty($a['id']))   return FormBuilderPro_render((int)$a['id']);
			if (!empty($a['slug'])) {
				$f = FormBuilderPro_get_form_by_slug($a['slug']);
				return $f ? FormBuilderPro_render((int)$f['id']) : '';
			}
			return '';
		},
		$content
	);
}

// ─────────────────────────────────────────────────────────────────────────────
// TEMPLATE TAG
// ─────────────────────────────────────────────────────────────────────────────

function get_FormBuilderPro($id_or_slug) {
	if (is_numeric($id_or_slug)) {
		echo FormBuilderPro_render((int)$id_or_slug);
	} else {
		$f = FormBuilderPro_get_form_by_slug($id_or_slug);
		if ($f) echo FormBuilderPro_render((int)$f['id']);
	}
}

// ─────────────────────────────────────────────────────────────────────────────
// FORM RENDERER  (front-end HTML output)
// ─────────────────────────────────────────────────────────────────────────────

function FormBuilderPro_render($form_id) {
	$form = FormBuilderPro_get_form($form_id);
	if (!$form) return '';

	$fields   = json_decode($form['fields'],   true) ?: [];
	$settings = json_decode($form['settings'], true) ?: [];

	$url_form   = (int)($_GET['fb_form']   ?? 0);
	$url_status = $_GET['fb_status'] ?? '';
	$is_our_form = ($url_form === (int)$form_id);

	$success = false;
	$errors  = [];
	$old	 = [];

	if ($is_our_form && $url_status === 'ok') {
		$success = !empty($settings['success_msg'])
			? $settings['success_msg']
			: 'Thank you! Your message has been sent.';
	} elseif ($is_our_form && $url_status === 'err') {
		if (session_status() === PHP_SESSION_NONE) @session_start();
		$errors = $_SESSION['fb_errors_' . $form_id] ?? [];
		$old	= $_SESSION['fb_old_'	. $form_id] ?? [];
		unset($_SESSION['fb_errors_' . $form_id], $_SESSION['fb_old_' . $form_id]);
	}

	$has_file = false;
	foreach ($fields as $f) {
		if (($f['type'] ?? '') === 'file') { $has_file = true; break; }
	}

	ob_start(); ?>
<div class="fb-form-wrap" id="fb-form-<?= $form_id ?>">
<?php if ($success): ?>
	<div class="fb-success"><?= htmlspecialchars($success) ?></div>
<?php else: ?>
<?php if ($errors): ?>
	<div class="fb-errors"><ul><?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach ?></ul></div>
<?php endif ?>
<form method="POST" class="fb-form"<?= $has_file ? ' enctype="multipart/form-data"' : '' ?>>
	<input type="hidden" name="_fb_form_id" value="<?= $form_id ?>">
	<?php if (!empty($settings['honeypot'])): ?>
	<!-- Honeypot: hidden from real users via CSS, bots fill it in -->
	<div class="fb-hp" aria-hidden="true">
		<label for="_fb_hp_<?= $form_id ?>">Leave this field empty</label>
		<input type="text" id="_fb_hp_<?= $form_id ?>" name="_fb_hp" tabindex="-1" autocomplete="off">
	</div>
	<?php endif ?>
	<?php if (!empty($settings['timecheck'])): ?>
	<input type="hidden" name="_fb_ts" value="<?= time() ?>">
	<?php endif ?>
	<?php foreach ($fields as $f):
		$type	 = $f['type']	?? 'text';
		$subtype  = $f['subtype'] ?? '';
		$name	 = htmlspecialchars($f['name']  ?? '');
		$raw_label = $f['label'] ?? ($f['name'] ?? '');
		$label	= htmlspecialchars($raw_label);
		$req	  = !empty($f['required']);
		$ph	   = htmlspecialchars($f['placeholder'] ?? '');
		$val	  = htmlspecialchars($old[$name] ?? '');
		$req_a	= $req ? ' required' : '';
		$req_s	= $req ? ' <span class="fb-req">*</span>' : '';
		$desc	 = $f['description'] ?? '';
		$help_icon = $desc ? '
			<span class="fb-help-wrap">
				<svg class="fb-help-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
				<span class="fb-help-tip">' . htmlspecialchars($desc) . '</span>
			</span>' : '';

		if ($type === 'radio-group')	$type = 'radio';
		if ($type === 'checkbox-group') $type = 'checkbox';

		$options = [];
		if (!empty($f['values']) && is_array($f['values'])) {
			foreach ($f['values'] as $v) {
				$options[] = ['label' => $v['label'] ?? '', 'value' => $v['value'] ?? $v['label'] ?? ''];
			}
		} elseif (!empty($f['options']) && is_array($f['options'])) {
			foreach ($f['options'] as $o) {
				$options[] = ['label' => $o, 'value' => $o];
			}
		}

		$input_type = $type;
		if ($type === 'text' && in_array($subtype, ['email','tel','number','password'])) {
			$input_type = $subtype;
		}
	?>
	<?php if ($type === 'header'):
		$cls = !empty($f['className']) ? ' ' . htmlspecialchars($f['className']) : '';
	?>
	<h3 class="fb-field-header<?= $cls ?>"><?= $label ?></h3>
	<?php elseif ($type === 'paragraph'):
		$cls = !empty($f['className']) ? ' ' . htmlspecialchars($f['className']) : '';
	?>
	<p class="fb-field-paragraph<?= $cls ?>"><?= html_entity_decode($raw_label, ENT_QUOTES, 'UTF-8') ?></p>
	<?php else: ?>
	<div class="fb-field fb-field-<?= $type ?><?= !empty($f['className']) ? ' ' . htmlspecialchars($f['className']) : '' ?>">
		<label><?= $label ?><?= $req_s ?><?= $help_icon ?></label>
		<?php if ($type === 'textarea'): ?>
			<textarea name="<?= $name ?>" placeholder="<?= $ph ?>"<?= $req_a ?>><?= $val ?></textarea>
		<?php elseif ($type === 'select'): ?>
			<select name="<?= $name ?>"<?= $req_a ?>>
				<option value="">- select -</option>
				<?php foreach ($options as $opt): ?>
				<option value="<?= htmlspecialchars($opt['value']) ?>"<?= ($val === $opt['value']) ? ' selected' : '' ?>><?= htmlspecialchars($opt['label']) ?></option>
				<?php endforeach ?>
			</select>
		<?php elseif ($type === 'radio'):
			$has_other	 = !empty($f['other']);
			$is_inline	 = !empty($f['inline']);
			$other_val	 = ($val === 'other') ? htmlspecialchars($old[$name . '-other'] ?? '') : '';
			$other_checked = ($val === 'other') ? ' checked' : '';
		?>
			<div class="<?= $is_inline ? 'fb-options-inline' : 'fb-options-block' ?>">
			<?php foreach ($options as $opt): ?>
			<label class="fb-inline"><input type="radio" name="<?= $name ?>" value="<?= htmlspecialchars($opt['value']) ?>"<?= ($val === $opt['value']) ? ' checked' : '' ?><?= $req_a ?>> <?= htmlspecialchars($opt['label']) ?></label>
			<?php endforeach ?>
			<?php if ($has_other): ?>
			<label class="fb-inline fb-other-wrap">
				<input type="radio" name="<?= $name ?>" value="other" id="<?= $name ?>-other-radio"<?= $other_checked ?><?= $req_a ?>>
				Other:
				<input type="text" name="<?= $name ?>-other" class="fb-other-input"
					   value="<?= $other_val ?>"
					   placeholder="Please specify"
					   <?= $other_checked ? '' : 'disabled' ?>
					   oninput="document.getElementById('<?= $name ?>-other-radio').checked=true">
			</label>
			<?php endif ?>
			</div>
		<?php elseif ($type === 'checkbox'):
			$has_other	 = !empty($f['other']);
			$is_inline	 = !empty($f['inline']);
			$is_toggle	 = !empty($f['toggle']);
			$checked_vals  = $val ? explode(', ', $val) : [];
			$other_checked = in_array('other', $checked_vals);
			$other_val	 = $other_checked ? htmlspecialchars($old[$name . '-other'] ?? '') : '';
		?>
			<div class="<?= $is_inline ? 'fb-options-inline' : 'fb-options-block' ?>">
			<?php foreach ($options as $opt):
				$checked = in_array($opt['value'], $checked_vals);
			?>
			<?php if ($is_toggle): ?>
			<label class="fb-toggle-wrap">
				<input type="checkbox" class="fb-toggle-input" name="<?= $name ?>[]" value="<?= htmlspecialchars($opt['value']) ?>"<?= $checked ? ' checked' : '' ?>>
				<span class="fb-toggle-slider"></span>
				<span class="fb-toggle-label"><?= htmlspecialchars($opt['label']) ?></span>
			</label>
			<?php else: ?>
			<label class="fb-inline"><input type="checkbox" name="<?= $name ?>[]" value="<?= htmlspecialchars($opt['value']) ?>"<?= $checked ? ' checked' : '' ?>> <?= htmlspecialchars($opt['label']) ?></label>
			<?php endif ?>
			<?php endforeach ?>
			<?php if ($has_other): ?>
			<label class="fb-inline fb-other-wrap">
				<input type="checkbox" name="<?= $name ?>[]" value="other" id="<?= $name ?>-other-cb"<?= $other_checked ? ' checked' : '' ?>>
				Other:
				<input type="text" name="<?= $name ?>-other" class="fb-other-input"
					   value="<?= $other_val ?>"
					   placeholder="Please specify"
					   <?= $other_checked ? '' : 'disabled' ?>
					   oninput="document.getElementById('<?= $name ?>-other-cb').checked=true">
			</label>
			<?php endif ?>
			</div>
		<?php elseif ($type === 'file'):
			$allowed = $f['allowed_types'] ?? 'pdf,doc,docx,xls,xlsx,jpg,jpeg,png,gif,zip';
			$accept  = implode(',', array_map(function($e) { return '.' . trim($e); }, explode(',', $allowed)));
		?>
			<input type="file" name="<?= $name ?>" accept="<?= htmlspecialchars($accept) ?>"<?= $req_a ?>>
		<?php elseif (in_array($type, ['date', 'time'])): ?>
			<input type="<?= $type ?>" name="<?= $name ?>" value="<?= $val ?>"<?= $req_a ?>>
		<?php else: // text (with optional subtype), number, date, time, etc ?>
			<input type="<?= htmlspecialchars($input_type) ?>" name="<?= $name ?>" placeholder="<?= $ph ?>" value="<?= $val ?>"<?= $req_a ?>>
		<?php endif ?>
	</div>
	<?php endif ?>
	<?php endforeach ?>
	<div class="fb-field">
		<?php if (($settings['captcha_method'] ?? '') === 'turnstile' && !empty($settings['turnstile_site_key'])): ?>
		<div class="cf-turnstile" style="margin-bottom:.75rem"
			 data-sitekey="<?= htmlspecialchars($settings['turnstile_site_key']) ?>"></div>
		<?php elseif (($settings['captcha_method'] ?? '') === 'hcaptcha' && !empty($settings['hcaptcha_site_key'])): ?>
		<div class="h-captcha" style="margin-bottom:.75rem"
			 data-sitekey="<?= htmlspecialchars($settings['hcaptcha_site_key']) ?>"></div>
		<?php elseif (($settings['captcha_method'] ?? '') === 'recaptcha2' && !empty($settings['recaptcha2_site_key'])): ?>
		<div class="g-recaptcha" style="margin-bottom:.75rem"
			 data-sitekey="<?= htmlspecialchars($settings['recaptcha2_site_key']) ?>"></div>
		<?php elseif (($settings['captcha_method'] ?? '') === 'recaptcha3' && !empty($settings['recaptcha3_site_key'])): ?>
		<input type="hidden" id="_fb_recaptcha3_<?= $form_id ?>" name="_fb_recaptcha3_token" value="">
		<?php endif ?>
		<button type="submit"><?= htmlspecialchars($settings['submit_label'] ?? 'Send') ?></button>
	</div>
</form>
<?php endif ?>
</div><!-- .fb-form-wrap -->
<script>
// Enable/disable "Other" text input when radio selection changes
document.querySelectorAll('.fb-form input[type=radio]').forEach(function(r) {
	r.addEventListener('change', function() {
		var wrap = this.closest('form');
		if (!wrap) return;
		var name = this.name;
		var otherInput = wrap.querySelector('input[name="' + name + '-other"]');
		if (!otherInput) return;
		otherInput.disabled = (this.value !== 'other');
	});
});
// Enable/disable "Other" text input when checkbox changes
document.querySelectorAll('.fb-form input[type=checkbox][value=other]').forEach(function(cb) {
	cb.addEventListener('change', function() {
		var otherInput = this.closest('label').querySelector('.fb-other-input');
		if (otherInput) otherInput.disabled = !this.checked;
	});
});
</script>
<?php if (($settings['captcha_method'] ?? '') === 'turnstile' && !empty($settings['turnstile_site_key'])): ?>
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
<?php endif ?>
<?php if (($settings['captcha_method'] ?? '') === 'hcaptcha' && !empty($settings['hcaptcha_site_key'])): ?>
<script src="https://js.hcaptcha.com/1/api.js" async defer></script>
<?php endif ?>
<?php if (($settings['captcha_method'] ?? '') === 'recaptcha2' && !empty($settings['recaptcha2_site_key'])): ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php endif ?>
<?php if (($settings['captcha_method'] ?? '') === 'recaptcha3' && !empty($settings['recaptcha3_site_key'])): ?>
<script src="https://www.google.com/recaptcha/api.js?render=<?= htmlspecialchars($settings['recaptcha3_site_key']) ?>" async defer></script>
<script>
// reCAPTCHA v3: execute on form submit, inject token before POST
document.addEventListener('DOMContentLoaded', function () {
	var form = document.querySelector('#fb-form-<?= $form_id ?> .fb-form');
	if (!form) return;
	form.addEventListener('submit', function (e) {
		e.preventDefault();
		var f = this;
		grecaptcha.ready(function () {
			grecaptcha.execute(<?= json_encode($settings['recaptcha3_site_key']) ?>, {action: 'submit'})
				.then(function (token) {
					document.getElementById('_fb_recaptcha3_<?= $form_id ?>').value = token;
					f.submit();
				});
		});
	});
});
</script>
<?php endif ?>
<style>
.fb-form-wrap{font-family:system-ui,sans-serif;max-width:600px}
.fb-form .fb-field{margin-bottom:1rem}
.fb-form label{display:block;font-weight:600;font-size:.875rem;margin-bottom:.35rem;color:#1a1a2e}
.fb-form input:not([type=radio]):not([type=checkbox]),.fb-form select,.fb-form textarea{width:100%;box-sizing:border-box;padding:.5rem .75rem;border:1px solid #d0d5dd;border-radius:5px;font-size:.9375rem;background:#fff;transition:border-color .15s}
.fb-form input:focus,.fb-form select:focus,.fb-form textarea:focus{outline:none;border-color:#2764e7;box-shadow:0 0 0 3px rgba(39,100,231,.12)}
.fb-form textarea{min-height:100px;resize:vertical}
.fb-form .fb-inline{display:inline-flex;align-items:center;gap:.35rem;font-weight:400;margin-right:.75rem}
.fb-options-block{display:flex;flex-direction:column;gap:.4rem}
.fb-options-inline{display:flex;flex-wrap:wrap;gap:.4rem .75rem}
.fb-options-inline .fb-inline,.fb-options-inline .fb-other-wrap{margin-right:0}
.fb-toggle-wrap{display:inline-flex;align-items:center;gap:.6rem;cursor:pointer;margin-bottom:.35rem}
.fb-toggle-input{position:absolute;opacity:0;width:0;height:0;pointer-events:none}
.fb-toggle-slider{position:relative;display:inline-block;width:36px;height:20px;flex-shrink:0;background:#d0d5dd;border-radius:20px;transition:background .2s}
.fb-toggle-slider::after{content:'';position:absolute;top:3px;left:3px;width:14px;height:14px;border-radius:50%;background:#fff;transition:transform .2s;box-shadow:0 1px 3px rgba(0,0,0,.2)}
.fb-toggle-input:checked + .fb-toggle-slider{background:#2764e7}
.fb-toggle-input:checked + .fb-toggle-slider::after{transform:translateX(16px)}
.fb-toggle-label{font-weight:400;font-size:.9375rem;color:#1a1a2e}
.fb-other-wrap{display:inline-flex;align-items:center;gap:.35rem;margin-right:.75rem}
.fb-other-input{width:140px!important;padding:.25rem .5rem!important;font-size:.875rem!important;border:1px solid #d0d5dd!important;border-radius:4px!important;background:#fff!important}
.fb-other-input:disabled{background:#f4f6f9!important;color:#9ca3af!important;cursor:not-allowed}
.fb-form button[type=submit]{background:#2764e7;color:#fff;border:none;padding:.6rem 1.5rem;border-radius:5px;font-size:.9375rem;font-weight:600;cursor:pointer;transition:background .15s}
.fb-form button:hover{background:#0094f0}
.fb-req{color:#e74c3c}
.fb-form-wrap .fb-field-header{margin:.5rem 0 .25rem;font-size:1.1rem;font-weight:700;color:#1a1a2e}
.fb-form-wrap .fb-field-paragraph{margin:.25rem 0 .75rem;color:#6b7280;font-size:.9375rem}
.fb-help-wrap{position:relative;display:inline-flex;align-items:center;margin-left:.3rem;vertical-align:middle}
.fb-help-icon{color:#9ca3af;cursor:pointer;flex-shrink:0;transition:color .15s}
.fb-help-wrap:hover .fb-help-icon{color:#2764e7}
.fb-help-tip{display:none;position:absolute;bottom:calc(100% + 6px);left:50%;transform:translateX(-50%);background:#1a1a2e;color:#fff;font-size:.78rem;font-weight:400;line-height:1.4;padding:.4rem .6rem;border-radius:5px;white-space:normal;width:220px;text-transform:none;letter-spacing:0;box-shadow:0 4px 12px rgba(0,0,0,.2);z-index:100;pointer-events:none}
.fb-help-tip::after{content:'';position:absolute;top:100%;left:50%;transform:translateX(-50%);border:5px solid transparent;border-top-color:#1a1a2e}
.fb-help-wrap:hover .fb-help-tip{display:block}
.fb-hp{position:absolute;left:-9999px;width:1px;height:1px;overflow:hidden;opacity:0;pointer-events:none}
.fb-errors{background:#fef2f2;border:1px solid #fca5a5;border-radius:5px;padding:.75rem 1rem;margin-bottom:1rem;color:#b91c1c;font-size:.875rem}
.fb-errors ul{margin:0;padding-left:1.25rem}
.fb-success{background:#f0fdf4;border:1px solid #86efac;border-radius:5px;padding:.75rem 1rem;color:#166534;font-size:.9375rem}
</style>
	<?php
	return ob_get_clean();
}

// ─────────────────────────────────────────────────────────────────────────────
// ADMIN PAGE
// ─────────────────────────────────────────────────────────────────────────────

function FormBuilderPro_admin_page() {
	global $USR, $USRLANG, $LANG;

	$fb_locale = 'en-US';
	if (!empty($USRLANG)) {
		$fb_locale = str_replace('_', '-', $USRLANG);
	} elseif (!empty($LANG)) {
		$fb_locale = str_replace('_', '-', $LANG);
	} elseif (!empty($USR)) {
		$user_xml = GSDATAUSERPATH . $USR . '.xml';
		if (file_exists($user_xml)) {
			$xml = @simplexml_load_file($user_xml);
			if ($xml && !empty((string)$xml->LANG)) {
				$fb_locale = str_replace('_', '-', (string)$xml->LANG);
			}
		}
	}

	$view = $_GET['fb_view'] ?? 'list';

	if ($view === 'edit') {
		require FormBuilderPro_PLUGIN_DIR . 'admin/edit-form.php';
	} else {
		require FormBuilderPro_PLUGIN_DIR . 'admin/forms-list.php';
	}
}

// ─────────────────────────────────────────────────────────────────────────────
// ADMIN AJAX ENDPOINTS
// ─────────────────────────────────────────────────────────────────────────────

function FormBuilderPro_handle_ajax($action) {
	header('Content-Type: application/json; charset=utf-8');

	// Require backend authentication for all actions except localized string lookups
	if ($action !== 'get_lang') {
		FormBuilderPro_check_auth_or_die();
	}

	$post_actions = ['save_form', 'duplicate_form', 'delete_form', 'test_email', 'delete_file'];
	if (in_array($action, $post_actions, true) && $_SERVER['REQUEST_METHOD'] !== 'POST') {
		http_response_code(405);
		echo json_encode(['ok' => false, 'msg' => 'Method Not Allowed']);
		exit;
	}

	switch ($action) {

		case 'save_form': {
			$id	   = (int)($_POST['id'] ?? 0);
			$name	 = trim(strip_tags($_POST['name'] ?? ''));
			$fields   = $_POST['fields']   ?? '[]';
			$settings = $_POST['settings'] ?? '{}';
			if (!$name) { echo json_encode(['ok' => false, 'msg' => 'Name required']); exit; }

			json_decode($fields);   if (json_last_error()) $fields   = '[]';
			json_decode($settings); if (json_last_error()) $settings = '{}';

			$db = FormBuilderPro_db();
			if ($id) {
				$slug = FormBuilderPro_unique_slug($name, $id);
				$stmt = $db->prepare("UPDATE fbp_forms SET name=:n,slug=:s,fields=:f,settings=:st,updated=strftime('%s','now') WHERE id=:id");
				$stmt->bindValue(':n',  $name,	 SQLITE3_TEXT);
				$stmt->bindValue(':s',  $slug,	 SQLITE3_TEXT);
				$stmt->bindValue(':f',  $fields,   SQLITE3_TEXT);
				$stmt->bindValue(':st', $settings, SQLITE3_TEXT);
				$stmt->bindValue(':id', $id,	   SQLITE3_INTEGER);
				$stmt->execute();
				echo json_encode(['ok' => true, 'id' => $id, 'slug' => $slug]);
			} else {
				$slug = FormBuilderPro_unique_slug($name);
				$stmt = $db->prepare("INSERT INTO fbp_forms (name,slug,fields,settings) VALUES (:n,:s,:f,:st)");
				$stmt->bindValue(':n',  $name,	 SQLITE3_TEXT);
				$stmt->bindValue(':s',  $slug,	 SQLITE3_TEXT);
				$stmt->bindValue(':f',  $fields,   SQLITE3_TEXT);
				$stmt->bindValue(':st', $settings, SQLITE3_TEXT);
				$stmt->execute();
				echo json_encode(['ok' => true, 'id' => $db->lastInsertRowID(), 'slug' => $slug]);
			}
			exit;
		}

		case 'duplicate_form': {
			$id   = (int)($_POST['id'] ?? 0);
			$form = FormBuilderPro_get_form($id);
			if (!$form) { echo json_encode(['ok' => false, 'msg' => 'Form not found']); exit; }

			$new_name = 'Copy of ' . $form['name'];
			$new_slug = FormBuilderPro_unique_slug($new_name);

			$db   = FormBuilderPro_db();
			$stmt = $db->prepare("INSERT INTO fbp_forms (name, slug, fields, settings) VALUES (:n, :s, :f, :st)");
			$stmt->bindValue(':n',  $new_name,	   SQLITE3_TEXT);
			$stmt->bindValue(':s',  $new_slug,		SQLITE3_TEXT);
			$stmt->bindValue(':f',  $form['fields'],  SQLITE3_TEXT);
			$stmt->bindValue(':st', $form['settings'], SQLITE3_TEXT);
			$stmt->execute();
			$new_id = $db->lastInsertRowID();

			echo json_encode([
				'ok'	  => true,
				'id'	  => $new_id,
				'name'	=> $new_name,
				'slug'	=> $new_slug,
				'fields'  => count(json_decode($form['fields'], true) ?: []),
				'created' => date('d M Y'),
			]);
			exit;
		}

		case 'delete_form': {
			$id   = (int)($_POST['id'] ?? 0);
			$db   = FormBuilderPro_db();
			$stmt = $db->prepare("DELETE FROM fbp_forms WHERE id=:id");
			$stmt->bindValue(':id', $id, SQLITE3_INTEGER);
			$stmt->execute();
			$stmt2 = $db->prepare("DELETE FROM fbp_submissions WHERE form_id=:id");
			$stmt2->bindValue(':id', $id, SQLITE3_INTEGER);
			$stmt2->execute();
			echo json_encode(['ok' => true]);
			exit;
		}

		case 'get_form': {
			$id   = (int)($_GET['id'] ?? 0);
			$form = FormBuilderPro_get_form($id);
			echo $form
				? json_encode(['ok' => true,  'form' => $form])
				: json_encode(['ok' => false]);
			exit;
		}

		case 'get_submissions': {
			$fid  = (int)($_GET['form_id'] ?? 0);
			$db   = FormBuilderPro_db();
			$stmt = $db->prepare("SELECT * FROM fbp_submissions WHERE form_id=:fid ORDER BY submitted DESC LIMIT 100");
			$stmt->bindValue(':fid', $fid, SQLITE3_INTEGER);
			$res  = $stmt->execute();
			$rows = [];
			while ($r = $res->fetchArray(SQLITE3_ASSOC)) $rows[] = $r;

			$json = json_encode(['ok' => true, 'rows' => $rows], JSON_INVALID_UTF8_SUBSTITUTE);
			if ($json === false) {
				http_response_code(500);
				$json = json_encode(['ok' => false, 'msg' => 'Encoding error: ' . json_last_error_msg()]);
			}
			echo $json;
			exit;
		}

		case 'download_file': {
			$safe = basename($_GET['file'] ?? '');
			if (!$safe) { echo json_encode(['ok' => false]); exit; }

			$db   = FormBuilderPro_db();
			$stmt = $db->prepare("SELECT safe_filename, original_filename FROM fbp_upload_tokens WHERE safe_filename = :safe LIMIT 1");
			$stmt->bindValue(':safe', $safe, SQLITE3_TEXT);
			$row  = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
			if (!$row) { http_response_code(403); exit; }

			$path = FormBuilderPro_UPLOAD_DIR . basename($row['safe_filename']);
			if (!file_exists($path)) { http_response_code(404); exit; }

			$original = $row['original_filename'];
			$mime = function_exists('mime_content_type') ? mime_content_type($path) : 'application/octet-stream';
			header('Content-Type: ' . $mime);
			header('Content-Disposition: attachment; filename="' . rawurlencode($original) . '"');
			header('Content-Length: ' . filesize($path));
			header('Cache-Control: no-store');
			readfile($path);
			exit;
		}

		case 'test_email': {
			$settings = json_decode($_POST['settings'] ?? '{}', true) ?: [];
			$to	   = !empty($settings['email_to']) ? $settings['email_to']
						: (function_exists('get_setting') ? get_setting('email') : '');
			if (empty($to)) {
				echo json_encode(['ok' => false, 'msg' => 'No recipient address configured. Set "Send to email" in the form settings.']);
				exit;
			}
			$subject = 'Form Builder Pro - test email';
			$body	= "This is a test email from the Form Builder Pro plugin.\n\nIf you received this, your mail settings are working correctly.";

			if (($settings['mail_method'] ?? 'php') !== 'smtp' || empty($settings['smtp_host'])) {
				$from	= FormBuilderPro_from_address($settings);
				$headers = implode("\r\n", [
					'From: Form Builder Pro <' . $from . '>',
					'Content-Type: text/plain; charset=UTF-8',
					'X-Mailer: Form Builder Pro',
				]);
				$sent = @mail($to, $subject, $body, $headers);
				echo json_encode(['ok' => (bool)$sent]);
			} else {
				echo json_encode(FormBuilderPro_mailer($settings, $to, $subject, $body, 'formBuilder'));
			}
			exit;
		}

		case 'get_files': {
			$db  = FormBuilderPro_db();
			$res = $db->query("
				SELECT t.token, t.safe_filename, t.original_filename, t.form_id, t.submission_id, t.created,
					   f.name as form_name
				FROM fbp_upload_tokens t
				LEFT JOIN fbp_forms f ON f.id = t.form_id
				ORDER BY t.created DESC
			");
			$rows = [];
			while ($r = $res->fetchArray(SQLITE3_ASSOC)) {
				$path		= FormBuilderPro_UPLOAD_DIR . $r['safe_filename'];
				$r['exists'] = file_exists($path);
				$r['size']   = $r['exists'] ? filesize($path) : 0;
				$rows[]	  = $r;
			}

			$json = json_encode(['ok' => true, 'rows' => $rows], JSON_INVALID_UTF8_SUBSTITUTE);
			if ($json === false) {
				http_response_code(500);
				$json = json_encode(['ok' => false, 'msg' => 'Encoding error: ' . json_last_error_msg()]);
			}
			echo $json;
			exit;
		}

		case 'delete_file': {
			$token = $_POST['token'] ?? '';
			if (!$token) { echo json_encode(['ok' => false, 'msg' => 'No token']); exit; }
			$db   = FormBuilderPro_db();
			$stmt = $db->prepare("SELECT * FROM fbp_upload_tokens WHERE token = :t LIMIT 1");
			$stmt->bindValue(':t', $token, SQLITE3_TEXT);
			$row  = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
			if (!$row) { echo json_encode(['ok' => false, 'msg' => 'Not found']); exit; }

			$path = FormBuilderPro_UPLOAD_DIR . basename($row['safe_filename']);
			if (file_exists($path)) @unlink($path);

			$del = $db->prepare("DELETE FROM fbp_upload_tokens WHERE token = :t");
			$del->bindValue(':t', $token, SQLITE3_TEXT);
			$del->execute();
			echo json_encode(['ok' => true]);
			exit;
		}

		case 'get_lang': {
			$locale = preg_replace('/[^a-zA-Z\-]/', '', $_GET['locale'] ?? 'en-US');
			if (!$locale || $locale === 'en-US' || $locale === 'en') {
				header('Content-Type: application/json; charset=UTF-8');
				echo json_encode([]);
				exit;
			}
			$path = FormBuilderPro_PLUGIN_DIR . 'assets/lang/' . $locale . '.lang';
			if (!file_exists($path)) {
				header('Content-Type: application/json; charset=UTF-8');
				echo json_encode([]);
				exit;
			}
			$strings = [];
			foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
				$line = trim($line);
				if ($line === '' || $line[0] === '#') continue;
				$pos = strpos($line, '=');
				if ($pos === false) continue;
				$key = trim(substr($line, 0, $pos));
				$val = trim(substr($line, $pos + 1));
				$strings[$key] = $val;
			}
			header('Content-Type: application/json; charset=UTF-8');
			echo json_encode($strings, JSON_UNESCAPED_UNICODE);
			exit;
		}

		default:
			http_response_code(400);
			echo json_encode(['ok' => false, 'msg' => 'Unknown action']);
			exit;
	}
}