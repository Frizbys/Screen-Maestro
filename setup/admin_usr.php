<?php
// DB CONFIG
$db_host = 'localhost';
$db_name = 'db_name';
$db_user = 'db_username';
$db_pass = 'yourpassword';

// Admin account info
$username = 'admin';
$password = 'CHANGEMENOW'; // Plain password
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if user already exists
    $check = $pdo->prepare("SELECT COUNT(*) FROM admin_users WHERE username = ?");
    $check->execute([$username]);
    if ($check->fetchColumn() > 0) {
        die("❌ User '$username' already exists.\n");
    }

    // Insert new admin user
    $stmt = $pdo->prepare("INSERT INTO admin_users (username, password_hash) VALUES (?, ?)");
    $stmt->execute([$username, $hashedPassword]);

    echo "✅ Admin user '$username' created successfully.\n";
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage();
}
