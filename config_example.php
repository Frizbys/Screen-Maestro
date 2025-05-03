<?php
// Screen Maestro - Configuration Example

// Database connection settings
$db_host = 'localhost';         // Usually 'localhost' unless your host says otherwise
$db_name = 'your_database';     // The name of the database you created
$db_user = 'your_db_user';      // The MySQL username you assigned
$db_pass = 'your_db_password';  // The corresponding password

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Database connection failed: " . $e->getMessage());
}

// Optional: set base path if installed in subfolder (e.g. '/screenmaestro')
$basePath = '';
?>
