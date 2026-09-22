<?php
/**
 * Form Builder Pro — Public file download endpoint
 */

// Traverse upward from /plugins/FormBuilderPro/public/ to find the GS root
$dir = dirname(__DIR__, 3);
$db_file = $dir . '/data/other/FormBuilderPro.db';
$upload_dir = $dir . '/data/other/fbp_uploads/';

if (!file_exists($db_file)) {
    http_response_code(500);
    exit('Database not found.');
}

$token = isset($_GET['token']) ? preg_replace('/[^a-f0-9]/i', '', $_GET['token']) : '';
if (!$token) {
    http_response_code(400);
    exit('Invalid token.');
}

try {
    $db   = new SQLite3($db_file);
    $stmt = $db->prepare("SELECT safe_filename, original_filename FROM fbp_upload_tokens WHERE token = :t LIMIT 1");
    $stmt->bindValue(':t', $token, SQLITE3_TEXT);
    $row  = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
} catch (\Throwable $e) {
    http_response_code(500);
    exit('Database error.');
}

if (!$row) {
    http_response_code(404);
    exit('File not found.');
}

$path = $upload_dir . basename($row['safe_filename']);
if (!file_exists($path)) {
    http_response_code(404);
    exit('Physical file missing.');
}

$original = $row['original_filename'];
$mime = function_exists('mime_content_type') ? mime_content_type($path) : 'application/octet-stream';

while (ob_get_level() > 0) ob_get_clean();
header('Content-Type: ' . $mime);
header('Content-Disposition: attachment; filename="' . rawurlencode($original) . '"');
header('Content-Length: ' . filesize($path));
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');
readfile($path);
exit;