<?php
// /public/view_screen.php

require_once '../config.php';
require_once '../controllers/AdminController.php';

$adminController = new AdminController($pdo);

// Validate screen ID input
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    exit('Invalid screen ID');
}

$screen_id = (int)$_GET['id'];

// Fetch screen
$screen = $adminController->getScreen($screen_id);
if (!$screen) {
    http_response_code(404);
    exit('Screen not found');
}

// Fetch media
$mediaItems = $adminController->getMediaForScreen($screen_id);

// Detect override
$overrideImage = null;
foreach ($mediaItems as $media) {
    if (!empty($media['image_filename']) && stripos($media['image_filename'], 'override_static') !== false) {
        $overrideImage = $media;
        break;
    }
}



// Load correct view
switch ($screen['layout_mode']) {
    case 'content':
        include 'view_screen_content.php';
        break;
    case 'media':
        include 'view_screen_media.php';
        break;
    case 'mix':
        include 'view_screen_mix.php';
        break;
    default:
        http_response_code(500);
        exit('Invalid layout mode configured.');
}
exit;
?>
