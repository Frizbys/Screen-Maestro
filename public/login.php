<?php
// /public/login.php
session_start();

require_once '../config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['admin'] = 1;
        header('Location: admin.php'); // Redirect to your Admin dashboard
        exit();
    } else {
        $error = 'Invalid username or password.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <style>
        body { background: #111; color: #eee; font-family: Arial, sans-serif; padding: 40px; }
        .container { max-width: 400px; margin: auto; background: #222; padding: 20px; border-radius: 8px; }
        label { display: block; margin-top: 15px; }
        input[type=text], input[type=password] { width: 100%; padding: 8px; margin-top: 5px; }
        button { margin-top: 20px; padding: 10px 20px; background: #00cc99; border: none; color: #fff; cursor: pointer; }
        button:hover { background: #009977; }
        .error { color: red; margin-top: 10px; }
    </style>
</head>
<body>

<div class="container">
    <h1>Admin Login</h1>

    <?php if ($error): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="post">
        <label>Username:</label>
        <input type="text" name="username" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>
