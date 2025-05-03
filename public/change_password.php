<?php
// /change_password.php

session_start();

require_once '../config.php';

// Block if not logged in
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_password = trim($_POST['old_password'] ?? '');
    $new_password = trim($_POST['new_password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');

    // Validate
    if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
        $error = 'All fields are required.';
    } elseif ($new_password !== $confirm_password) {
        $error = 'New passwords do not match.';
    } else {
        // Load current admin info (assuming only 1 admin user for now)
        $stmt = $pdo->prepare("SELECT * FROM admin_users LIMIT 1");
        $stmt->execute();
        $admin = $stmt->fetch();

        if (!$admin || !password_verify($old_password, $admin['password_hash'])) {
            $error = 'Old password is incorrect.';
        } else {
            // Hash new password
            $new_hash = password_hash($new_password, PASSWORD_DEFAULT);

            // Update password
            $update = $pdo->prepare("UPDATE admin_users SET password_hash = ? WHERE id = ?");
            $update->execute([$new_hash, $admin['id']]);

            $success = 'Password changed successfully!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <style>
        body { background: #111; color: #eee; font-family: Arial, sans-serif; padding: 40px; }
        .container { max-width: 400px; margin: auto; background: #222; padding: 20px; border-radius: 8px; }
        label { display: block; margin-top: 15px; }
        input[type=password] { width: 100%; padding: 8px; margin-top: 5px; }
        button { margin-top: 20px; padding: 10px 20px; background: #00cc99; border: none; color: #fff; cursor: pointer; }
        button:hover { background: #009977; }
        .error { color: red; margin-top: 10px; }
        .success { color: limegreen; margin-top: 10px; }
        a { color: #00ccff; display: block; margin-top: 20px; }
    </style>
</head>
<body>

<div class="container">
    <h1>Change Password</h1>

    <?php if ($error): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <form method="post">
        <label>Old Password:</label>
        <input type="password" name="old_password" required>

        <label>New Password:</label>
        <input type="password" name="new_password" required>

        <label>Confirm New Password:</label>
        <input type="password" name="confirm_password" required>

        <button type="submit">Change Password</button>
    </form>

    <a href="admin.php">← Back to Dashboard</a>
</div>

</body>
</html>
