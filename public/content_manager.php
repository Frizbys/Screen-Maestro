<?php
// /public/content_manager.php

session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

define('BASE_PATH', realpath(__DIR__ . '/../'));

require_once BASE_PATH . '/config.php';
require_once BASE_PATH . '/controllers/AdminController.php';

$adminController = new AdminController($pdo);

// Validate Screen ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Invalid Screen ID.');
}

$screen_id = (int)$_GET['id'];

// Handle Add/Edit/Delete actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_content'])) {
        $html = $_POST['html_content'] ?? '';
        $stmt = $pdo->prepare("INSERT INTO screen_contents (screen_id, html_content, sort_order) VALUES (?, ?, ?)");
        $stmt->execute([$screen_id, $html, 0]);
        header("Location: content_manager.php?id=$screen_id");
        exit();
    }

    if (isset($_POST['update_content']) && isset($_POST['content_id'])) {
        $content_id = (int)$_POST['content_id'];
        $html = $_POST['html_content'] ?? '';
        $sort_order = (int)$_POST['sort_order'] ?? 0;
        $stmt = $pdo->prepare("UPDATE screen_contents SET html_content = ?, sort_order = ? WHERE id = ? AND screen_id = ?");
        $stmt->execute([$html, $sort_order, $content_id, $screen_id]);
        header("Location: content_manager.php?id=$screen_id");
        exit();
    }
}

if (isset($_GET['delete'])) {
    $delete_id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM screen_contents WHERE id = ? AND screen_id = ?");
    $stmt->execute([$delete_id, $screen_id]);
    header("Location: content_manager.php?id=$screen_id");
    exit();
}

// Fetch all content blocks for this screen
$stmt = $pdo->prepare("SELECT * FROM screen_contents WHERE screen_id = ? ORDER BY sort_order ASC, id ASC");
$stmt->execute([$screen_id]);
$contents = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Content Blocks</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
    <style>
     
    </style>
     <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<h1>📝 Manage Content Blocks for Screen #<?php echo $screen_id; ?></h1>

<h2>Add New Content Block</h2>
<form method="post">
    <textarea name="html_content" placeholder="Enter HTML content here..."></textarea>
    <button type="submit" name="add_content">➕ Add Content Block</button>
</form>

<hr>

<h2>Existing Content Blocks</h2>
<?php foreach ($contents as $content): ?>
    <div class="block">
        <form method="post">
            <input type="hidden" name="content_id" value="<?php echo (int)$content['id']; ?>">
            <label>Sort Order:</label>
            <input type="number" name="sort_order" value="<?php echo (int)$content['sort_order']; ?>">

            <label>HTML Content:</label>
            <textarea name="html_content"><?php echo htmlspecialchars($content['html_content']); ?></textarea>

            <button type="submit" name="update_content">💾 Update</button>
            <a href="content_manager.php?id=<?php echo (int)$screen_id; ?>&delete=<?php echo (int)$content['id']; ?>" onclick="return confirm('Delete this block?');" class="delete-btn">❌ Delete</a>
        </form>
    </div>
<?php endforeach; ?>

<br>
<a href="admin.php">← Back to Admin Dashboard</a>

</body>
</html>
