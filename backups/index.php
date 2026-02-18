<?php
/**
 * Security Protection for Backups Directory
 * 
 * This file provides application-level access control for the /backups/ directory.
 * It blocks all direct HTTP access to backup files, regardless of Apache .htaccess
 * configuration.
 * 
 * CRITICAL: This protection works even if AllowOverride is disabled.
 * 
 * @package GetSimple
 * @subpackage Security
 */

// Prevent any output before headers
ob_start();

// Block all direct access
http_response_code(403);
header('HTTP/1.1 403 Forbidden');
header('Content-Type: text/html; charset=utf-8');

// Clear any output buffer
ob_end_clean();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 Forbidden</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: #f5f5f5;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .error-container {
            background: white;
            border-radius: 8px;
            padding: 40px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            max-width: 500px;
            text-align: center;
        }
        h1 {
            font-size: 72px;
            margin: 0 0 20px 0;
            color: #e74c3c;
        }
        h2 {
            font-size: 24px;
            margin: 0 0 15px 0;
            font-weight: 600;
        }
        p {
            color: #666;
            line-height: 1.6;
            margin: 0;
        }
        .code {
            background: #f8f9fa;
            border-left: 3px solid #e74c3c;
            padding: 15px;
            margin: 20px 0;
            text-align: left;
            font-family: monospace;
            font-size: 14px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>403</h1>
        <h2>Access Forbidden</h2>
        <p>You don't have permission to access this directory or its contents.</p>
        <div class="code">
            This directory contains backup files and is protected by application-level security controls.
        </div>
        <p>If you need to restore from a backup, please use the admin panel.</p>
    </div>
</body>
</html>
<?php
// Ensure script terminates
exit;
?>
