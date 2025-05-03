<?php
// /public/fix_layout_modes.php

session_start();

// Only allow admins
if (!isset($_SESSION['admin'])) {
    die('Access denied.');
}

require_once '../config.php'; // Load your DB connection

try {
    $pdo->beginTransaction();

    // Find any screens where layout_mode is NULL or empty
    $stmt = $pdo->query("SELECT id, layout_mode FROM signage_screens");
    $screens = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $fixed = 0;

    foreach ($screens as $screen) {
        if (empty($screen['layout_mode']) || !in_array($screen['layout_mode'], ['media', 'content', 'mix'])) {
            $update = $pdo->prepare("UPDATE signage_screens SET layout_mode = 'media' WHERE id = ?");
            $update->execute([$screen['id']]);
            $fixed++;
        }
    }

    $pdo->commit();

    echo "<h1>✅ Fix Complete!</h1>";
    echo "<p>{$fixed} screens were updated to layout_mode = 'media'.</p>";
    echo '<p><a href="admin.php">← Back to Admin Dashboard</a></p>';

} catch (Exception $e) {
    $pdo->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
