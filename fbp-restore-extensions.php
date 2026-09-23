<?php
/**
 * Form Builder Pro — Restore Original Extensions
 *
 * Reads FormBuilderPro.db and makes a COPY of every uploaded file into a
 * new folder, naming each copy with its real extension (taken from the
 * original_filename stored in the database). The live site's uploads
 * folder and database are never modified — this only produces a
 * backup-ready copy, safe to FTP off the server.
 *
 * Usage — command line:
 *   php fbp-restore-extensions.php
 *
 * Usage — browser:
 *   Set $access_token below to something long and random, then visit:
 *   https://yoursite.com/path/to/fbp-restore-extensions.php?token=YOUR_TOKEN
 *
 * IMPORTANT: delete this script from the server once you're done with it.
 * It can copy every uploaded file on request, so it should not be left
 * sitting in a web-accessible folder indefinitely.
 *
 * Adjust the paths and the token below to match your install before running.
 */

// ─── Configure these ────────────────────────────────────────────────────────
$db_file      = __DIR__ . '/data/other/FormBuilderPro.db';
$source_dir   = __DIR__ . '/data/other/fbp_uploads/';
$dest_dir     = __DIR__ . '/fbp_uploads_restored/';

// Required for browser access. Leave blank to only allow running via CLI.
// Set this to a long random string (e.g. bin2hex(random_bytes(16))) before
// using this from a browser, and remove the file afterwards.
$access_token = '';
// ─────────────────────────────────────────────────────────────────────────────

$is_cli = (php_sapi_name() === 'cli');

if (!$is_cli) {
    header('Content-Type: text/plain; charset=utf-8');
    if ($access_token === '') {
        http_response_code(403);
        exit("Browser access is disabled.\nSet \$access_token at the top of this script to a long random value, then reload with ?token=YOUR_TOKEN.\n");
    }
    $supplied = $_GET['token'] ?? '';
    if (!hash_equals($access_token, $supplied)) {
        http_response_code(403);
        exit("Invalid or missing token.\n");
    }
}

if (!file_exists($db_file)) {
    exit("Database not found at: $db_file\n" .
         "Edit \$db_file at the top of this script to point to your FormBuilderPro.db.\n");
}
if (!is_dir($source_dir)) {
    exit("Uploads folder not found at: $source_dir\n" .
         "Edit \$source_dir at the top of this script.\n");
}
if (!is_dir($dest_dir) && !mkdir($dest_dir, 0755, true)) {
    exit("Could not create destination folder: $dest_dir\n");
}

$db = new SQLite3($db_file, SQLITE3_OPEN_READONLY);
$res = $db->query("
    SELECT t.token, t.safe_filename, t.original_filename, t.created,
           f.name AS form_name
    FROM fbp_upload_tokens t
    LEFT JOIN fbp_forms f ON f.id = t.form_id
    ORDER BY t.created ASC
");

$manifest = [];
$copied = 0;
$missing = 0;
$skipped_exists = 0;

while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
    $source_path = $source_dir . basename($row['safe_filename']);

    if (!file_exists($source_path)) {
        echo "MISSING on disk, skipped: {$row['safe_filename']} (was \"{$row['original_filename']}\")\n";
        $missing++;
        continue;
    }

    // Base name of the copy = the original random token name (still unique,
    // still unguessable), extension = the real one from original_filename.
    $base = pathinfo($row['safe_filename'], PATHINFO_FILENAME);
    $ext  = strtolower(pathinfo($row['original_filename'], PATHINFO_EXTENSION));
    $ext  = preg_replace('/[^a-z0-9]/', '', $ext);
    $new_filename = $base . ($ext !== '' ? '.' . $ext : '');
    $dest_path = $dest_dir . $new_filename;

    if (file_exists($dest_path)) {
        $skipped_exists++;
    } elseif (copy($source_path, $dest_path)) {
        $copied++;
    } else {
        echo "COPY FAILED: {$row['safe_filename']} -> $new_filename\n";
        continue;
    }

    $manifest[] = [
        $new_filename,
        $row['original_filename'],
        $row['form_name'] ?? 'Unknown form',
        date('Y-m-d H:i:s', (int)$row['created']),
        $row['token'],
    ];
}

// Write a CSV manifest alongside the copies
$manifest_path = $dest_dir . 'manifest.csv';
$fh = fopen($manifest_path, 'w');
fputcsv($fh, ['restored_filename', 'original_filename', 'form', 'uploaded', 'token']);
foreach ($manifest as $row) {
    fputcsv($fh, $row);
}
fclose($fh);

echo "\nDone.\n";
echo "  Copied:            $copied\n";
echo "  Already present:   $skipped_exists\n";
echo "  Missing from disk: $missing\n";
echo "  Output folder:     $dest_dir\n";
echo "  Manifest:          $manifest_path\n";
