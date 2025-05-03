<?php
// Creative City Media - Signage System Configuration

// Database connection settings
$host = '127.0.0.1';
$db   = 'demo_maestro'; // your database name
$user = 'demo_maestr_usr'; // your database user
$pass = 'Rockinsox2025#'; // your database password

// Set up PDO connection
try {
    $pdo = new PDO("mysql:host=$host;port=3306;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Throw exceptions if something fails
} catch (PDOException $e) {
    die("❌ Database connection failed: " . $e->getMessage());
}

// General site settings
$site_name = 'Creative City Media - Signage';
$uploads_dir = __DIR__ . '/uploads'; // Path for file uploads (images, videos, etc.)

// --- Admin Credentials (for login protection) ---
$admin_username = 'admin'; 
$admin_password_hash = '$2y$10$JZeVeFWc68Pxh/e/t3Su/uwRG2pkc8Sxopjp5PgTEk1SZYr0d.aki';



// 🔥 NOTE: 
// If you want to change the admin password:
// 1. Generate a new password hash:
//      echo password_hash('YOUR_NEW_PASSWORD', PASSWORD_DEFAULT);
// 2. Replace the $admin_password_hash value above with the new hash.
?>
