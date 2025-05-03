<?php
// /public/content_editor.php

session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

define('BASE_PATH', realpath(__DIR__ . '/../'));
require_once BASE_PATH . '/config.php';
require_once BASE_PATH . '/controllers/AdminController.php';
include BASE_PATH . '/views/admin/header.php';

$adminController = new AdminController($pdo);

// Validate screen
$screen_id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : null;
if (!$screen_id) {
    die('Invalid screen ID.');
}

$screen = $adminController->getScreen($screen_id);
if (!$screen) {
    die('Screen not found.');
}

// Handle POST Add
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_block'])) {
    $html_content = $_POST['html_content'] ?? '';
    $adminController->addContentBlock($screen_id, $html_content);
    header('Location: content_editor.php?id=' . $screen_id);
    exit();
}

// Handle Delete
if (isset($_GET['delete_block']) && is_numeric($_GET['delete_block'])) {
    $block_id = (int)$_GET['delete_block'];
    $adminController->deleteContentBlock($block_id);
    header('Location: content_editor.php?id=' . $screen_id);
    exit();
}

$contentBlocks = $adminController->getContentBlocks($screen_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Content - <?php echo htmlspecialchars($screen['screen_name']); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1100px;
            margin: auto;
        }
        h1, h2 {
            color: #343a40;
            margin-bottom: 20px;
        }
        .content-block {
            background: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        textarea {
            width: 100%;
            min-height: 200px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
            margin-top: 10px;
            resize: vertical;
        }
        .button-group {
            margin-top: 15px;
            display: flex;
            gap: 10px;
        }
        .btn {
            padding: 10px 18px;
            font-size: 14px;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: 0.2s;
        }
        .btn-primary {
            background: #007bff;
            color: white;
        }
        .btn-primary:hover {
            background: #0056b3;
        }
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        .btn-danger:hover {
            background: #c82333;
        }
        .btn-add {
            background: #28a745;
            color: white;
        }
        .btn-add:hover {
            background: #218838;
        }
        .back-link {
            margin-top: 30px;
            display: inline-block;
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        .no-blocks {
            padding: 20px;
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
            border-radius: 6px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>📝 Edit Content: <em><?php echo htmlspecialchars($screen['screen_name']); ?></em></h1>

    <section>
        <h2>Existing Content Blocks</h2>

        <?php if (!empty($contentBlocks)): ?>
            <?php foreach ($contentBlocks as $block): ?>
                <div class="content-block">
                    <form method="post" action="update_content_block.php">
    <input type="hidden" name="block_id" value="<?php echo (int)$block['id']; ?>">
    <input type="hidden" name="screen_id" value="<?php echo (int)$screen_id; ?>">
    <textarea name="html_content"><?php echo htmlspecialchars($block['content_html']); ?></textarea>

    <div class="button-group">
        <button type="submit" class="btn btn-primary">💾 Save Changes</button>
        <a href="content_editor.php?id=<?php echo (int)$screen_id; ?>&delete_block=<?php echo (int)$block['id']; ?>" class="btn btn-danger" onclick="return confirm('Delete this block?')">🗑️ Delete Block</a>
    </div>
</form>

                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-blocks">No content blocks yet. Create one below! 🚀</div>
        <?php endif; ?>
    </section>

    <hr>

    <section>
        <h2>Add New Content Block</h2>
        <form method="post" action="">
            <textarea name="html_content" placeholder="Enter HTML content here..."></textarea>
            <button type="submit" name="add_block" class="btn btn-add">➕ Add New Block</button>
        </form>
    </section>

    <p><a href="admin.php" class="back-link">← Back to Dashboard</a></p>

</div>

</body>
</html>
