<?php
// create_admin.php
require_once 'config.php'; // ✅ ensure $pdo is available

$username = 'admin';
$password = 'demopasswordgo';
$hash = password_hash($password, PASSWORD_BCRYPT);

$stmt = $pdo->prepare("INSERT INTO admin_users (username, password_hash) VALUES (?, ?)");
$stmt->execute([$username, $hash]);

echo "✅ Admin user created!";
