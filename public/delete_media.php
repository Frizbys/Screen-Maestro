<?php
// /public/delete_media.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../config.php';
require_once '../controllers/AdminController.php';

// Detect if POST is JSON or form-data
if ($_SERVER['CONTENT_TYPE'] === 'application/json') {
    // JSON POST
    $input = json_decode(file_get_contents('php://input'), true);
    $media_id = isset($input['id']) ? (int)$input['id'] : 0;
} else {
    // Regular form POST
    $media_id = isset($_POST['media_id']) ? (int)$_POST['media_id'] : 0;
}

// Validate
if ($media_id <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid media ID.']);
    exit;
}

// Fetch media
$stmt = $pdo->prepare("SELECT image_filename FROM signage_images WHERE id = ?");
$stmt->execute([$media_id]);
$media = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$media) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Media not found.']);
    exit;
}

// Delete file
$uploadPath = __DIR__ . '/../uploads/' . $media['image_filename'];
if (file_exists($uploadPath)) {
    unlink($uploadPath);
}

// Delete from DB
$stmt = $pdo->prepare("DELETE FROM signage_images WHERE id = ?");
if ($stmt->execute([$media_id])) {
    // If it was form POST, redirect back after delete
    if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        header('Location: media_manager.php?id=' . (int)$_POST['screen_id']);
        exit;
    } else {
        // AJAX JSON success
        echo json_encode(['success' => true, 'message' => 'Media deleted successfully.']);
    }
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to delete media.']);
}
?>
