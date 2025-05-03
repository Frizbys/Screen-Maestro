<?php
// /public/share.php

require_once '../config.php';

if (!isset($_GET['token']) || empty($_GET['token'])) {
    http_response_code(400);
    exit('Missing token.');
}

$token = $_GET['token'];

// Lookup token
$stmt = $pdo->prepare("SELECT screen_id FROM screen_share_links WHERE token = ? AND expires_at > NOW()");
$stmt->execute([$token]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    http_response_code(404);
    exit('Invalid or expired share link.');
}

$screen_id = (int)$result['screen_id'];

// Redirect to proper screen
header("Location: view_screen.php?id=" . $screen_id);
exit();
?>
