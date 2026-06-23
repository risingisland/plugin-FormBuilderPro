<?php
/**
 * Form Builder Pro — Public file download endpoint
 * No login required. Validates a permanent token before serving the file.
 *
 * Usage: /plugins/FormBuilderPro/public/download.php?token=abc123...
 */

// Bootstrap just enough of GetSimple to reach the DB
$gs_root = rtrim(str_repeat('../', 3), '/') . '/';
if (!file_exists($gs_root . 'admin/inc/common.php')) {
    // Try one level up (some GS installs have plugins one level deeper)
    $gs_root = rtrim(str_repeat('../', 4), '/') . '/';
}

// We only need GSDATAOTHERPATH — derive it without loading full GS
// Standard GS path: {root}/data/other/
define('FB_DATA_PATH', realpath($gs_root . 'data/other') . '/');
define('FB_DB_PATH',   FB_DATA_PATH . 'FormBuilderPro.db');
define('FB_UPLOAD_DIR', FB_DATA_PATH . 'fbp_uploads/');

// ── Validate token ────────────────────────────────────────────────────────────
$token = isset($_GET['token']) ? preg_replace('/[^a-f0-9]/i', '', $_GET['token']) : '';

if (!$token) {
    http_response_code(400);
    exit('Invalid request.');
}

if (!file_exists(FB_DB_PATH)) {
    http_response_code(500);
    exit('Database not found.');
}

try {
    $db   = new SQLite3(FB_DB_PATH);
    $stmt = $db->prepare("SELECT * FROM fbp_upload_tokens WHERE token = :t LIMIT 1");
    $stmt->bindValue(':t', $token, SQLITE3_TEXT);
    $row  = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
} catch (Exception $e) {
    http_response_code(500);
    exit('Database error.');
}

if (!$row) {
    http_response_code(404);
    exit('File not found.');
}

$path = FB_UPLOAD_DIR . basename($row['safe_filename']);

if (!file_exists($path)) {
    http_response_code(404);
    exit('File not found.');
}

// ── Serve file ────────────────────────────────────────────────────────────────
$original = $row['original_filename'];
$mime     = function_exists('mime_content_type')
    ? mime_content_type($path)
    : 'application/octet-stream';

header('Content-Type: ' . $mime);
header('Content-Disposition: attachment; filename="' . rawurlencode($original) . '"');
header('Content-Length: ' . filesize($path));
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');
readfile($path);
exit;