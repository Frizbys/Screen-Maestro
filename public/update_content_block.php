<?php
// /public/update_content_block.php

session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

define('BASE_PATH', realpath(__DIR__ . '/../'));
require_once BASE_PATH . '/config.php';
require_once BASE_PATH . '/controllers/AdminController.php';

$adminController = new AdminController($pdo);

// Validate input
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['block_id']) && is_numeric($_POST['block_id'])) {
    $block_id = (int)$_POST['block_id'];
    $html_content = $_POST['html_content'] ?? '';

    $adminController->updateContentBlock($block_id, $html_content);
}

// Always get screen_id from POST, not GET
$screen_id = isset($_POST['screen_id']) ? (int)$_POST['screen_id'] : 0;

// Redirect back to content editor
header('Location: content_editor.php?id=' . $screen_id);
exit();
?>
