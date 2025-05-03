<?php
// /public/generate_share_link.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../config.php';

session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

// Validate screen ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    exit('Invalid screen ID.');
}

$screen_id = (int)$_GET['id'];

// Generate secure random token
$token = bin2hex(random_bytes(16));

// Expire 7 days from now
$expires_at = date('Y-m-d H:i:s', strtotime('+7 days'));

// Insert into media_share_links table
$stmt = $pdo->prepare("INSERT INTO screen_share_links (screen_id, token, expires_at) VALUES (?, ?, ?)");
$stmt->execute([$screen_id, $token, $expires_at]);

// Build Share URL
$domain = 'https://screenmaestro.com'; // ✅ <-- your domain here
$shareUrl = $domain . '/public/share.php?token=' . $token;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Screen Share Link</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 40px; text-align: center; }
        textarea { width: 90%; max-width: 700px; height: 60px; margin-top: 20px; font-size: 16px; }
        .button { margin-top: 20px; padding: 10px 20px; font-size: 16px; cursor: pointer; border: none; border-radius: 5px; }
        .copy-btn { background-color: #007BFF; color: white; }
        .view-btn { background-color: #28a745; color: white; margin-left: 10px; }
    </style>
</head>
<body>


<h1>✅ Your Share Link is Ready!</h1>

<textarea id="shareLink" readonly><?php echo htmlspecialchars($shareUrl); ?></textarea>

<br>

<button class="button copy-btn" onclick="copyLink()">📋 Copy Link</button>
<a href="<?php echo htmlspecialchars($shareUrl); ?>" target="_blank" class="button view-btn">🌎 View Link</a>

<br><br>
<a class="button copy-btn" a href="admin.php">← Back to Admin Dashboard</a>

<script>
function copyLink() {
    const textarea = document.getElementById('shareLink');
    textarea.select();
    document.execCommand('copy');
    alert('✅ Link copied to clipboard!');
}
</script>

</body>
</html>
