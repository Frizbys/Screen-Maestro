<?php
// /public/admin.php

session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

// Define your base path
define('BASE_PATH', realpath(__DIR__ . '/../'));

// Load Config, Controller, Header
require_once BASE_PATH . '/config.php'; 
require_once BASE_PATH . '/controllers/AdminController.php';
include BASE_PATH . '/views/admin/header.php';

// Initialize AdminController
$adminController = new AdminController($pdo);

// Fetch all screens
$screens = $adminController->getScreens();

// Group screens by screen_group
$groups = [];
foreach ($screens as $screen) {
    $groupName = $screen['screen_group'] ?: 'Ungrouped';
    $groups[$groupName][] = $screen;
}

// Load the Admin Index view
require_once BASE_PATH . '/views/admin/index.php';
?>

</div> <!-- end of admin-content -->
</body>
</html>
