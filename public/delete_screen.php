<?php
// /public/delete_screen.php

session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

require_once '../config.php';
require_once '../controllers/AdminController.php';

$adminController = new AdminController($pdo);

// Validate input
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    exit('Invalid screen ID.');
}

$screen_id = (int)$_GET['id'];

// Delete screen
$adminController->deleteScreen($screen_id);

// Redirect back to admin
header('Location: admin.php');
exit;
?>
