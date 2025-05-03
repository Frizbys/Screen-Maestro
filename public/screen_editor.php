<?php
// /public/screen_editor.php

session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

define('BASE_PATH', realpath(__DIR__ . '/../'));
require_once BASE_PATH . '/config.php';
require_once BASE_PATH . '/controllers/AdminController.php';

$adminController = new AdminController($pdo);

// Validate screen ID
if (!isset($_GET['id'])) {
    die('Invalid Screen ID.');
}

$screen_id_raw = $_GET['id'];
$isNewScreen = ($screen_id_raw === 'new');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($isNewScreen) {
        $adminController->createScreen($_POST);
    } else {
        $screen_id = (int)$screen_id_raw;
        $adminController->updateScreen($screen_id, $_POST);

        if ($_POST['layout_mode'] === 'content' && isset($_POST['html_content'])) {
            $adminController->saveScreenContent($screen_id, $_POST['html_content']);
        }
    }
    header('Location: admin.php');
    exit();
}

// Load screen data
if ($isNewScreen) {
    $screen = [
        'screen_number' => '',
        'screen_name' => '',
        'screen_group' => '',
        'ticker_text' => '',
        'qr_link' => '',
        'theme' => 'default',
        'ticker_speed' => 'medium',
        'ticker_direction' => 'left',
        'ticker_font_size' => '16px',
        'ticker_font' => 'Arial',
        'ticker_color' => '#FFFFFF',
        'ticker_bg_color' => '#000000',
        'ticker_enabled' => 1,
        'rotation_interval' => 8,
        'layout_mode' => 'media'
    ];
} else {
    $screen_id = (int)$screen_id_raw;
    $screen = $adminController->getScreen($screen_id);
    if (!$screen) {
        die('Screen not found.');
    }
}

include '../views/admin/header.php';
?>

<!-- Admin Content Starts -->
<div class="admin-content">

    <div class="form-container">
        <h1 class="text-center"><?php echo $isNewScreen ? 'Create New Screen' : 'Edit Screen: ' . htmlspecialchars($screen['screen_name']); ?></h1>

        <form method="post" action="screen_editor.php?id=<?php echo htmlspecialchars($screen_id_raw); ?>">

            <div class="form-group">
                <label>Screen Layout Mode</label>
                <select name="layout_mode" required>
                    <option value="media" <?php if ($screen['layout_mode'] === 'media') echo 'selected'; ?>>Media Rotation (Images/Videos)</option>
                    <option value="content" <?php if ($screen['layout_mode'] === 'content') echo 'selected'; ?>>Content Block Mode (Content Only)</option>
                    <option value="mix" <?php if ($screen['layout_mode'] === 'mix') echo 'selected'; ?>>Mixed Mode (Images + Content)</option>
                </select>
            </div>

            <div class="form-group">
                <label>Screen Number</label>
                <input type="number" name="screen_number" value="<?php echo htmlspecialchars($screen['screen_number']); ?>" required>
            </div>

            <div class="form-group">
                <label>Screen Name</label>
                <input type="text" name="screen_name" value="<?php echo htmlspecialchars($screen['screen_name']); ?>" required>
            </div>

            <div class="form-group">
                <label>Screen Group</label>
                <input type="text" name="screen_group" value="<?php echo htmlspecialchars($screen['screen_group']); ?>">
            </div>

            <div class="form-group">
                <label>QR Link</label>
                <input type="text" name="qr_link" value="<?php echo htmlspecialchars($screen['qr_link']); ?>">
            </div>

            <div class="form-group">
                <label>Theme</label>
                <input type="text" name="theme" value="<?php echo htmlspecialchars($screen['theme']); ?>">
            </div>

            <div class="form-group">
                <label>Ticker Text</label>
                <textarea name="ticker_text"><?php echo htmlspecialchars($screen['ticker_text']); ?></textarea>
            </div>

            <div class="form-group">
                <label>Ticker Speed</label>
                <select name="ticker_speed">
                    <option value="slow" <?php if ($screen['ticker_speed'] === 'slow') echo 'selected'; ?>>Slow</option>
                    <option value="medium" <?php if ($screen['ticker_speed'] === 'medium') echo 'selected'; ?>>Medium</option>
                    <option value="fast" <?php if ($screen['ticker_speed'] === 'fast') echo 'selected'; ?>>Fast</option>
                </select>
            </div>

            <div class="form-group">
                <label>Ticker Direction</label>
                <select name="ticker_direction">
                    <option value="left" <?php if ($screen['ticker_direction'] === 'left') echo 'selected'; ?>>Left</option>
                    <option value="right" <?php if ($screen['ticker_direction'] === 'right') echo 'selected'; ?>>Right</option>
                </select>
            </div>

            <div class="form-group">
                <label>Ticker Font Size</label>
                <input type="text" name="ticker_font_size" value="<?php echo htmlspecialchars($screen['ticker_font_size']); ?>">
            </div>

            <div class="form-group">
                <label>Ticker Font</label>
                <input type="text" name="ticker_font" value="<?php echo htmlspecialchars($screen['ticker_font']); ?>">
            </div>

            <div class="form-group">
                <label>Ticker Text Color</label>
                <input type="color" name="ticker_color" value="<?php echo htmlspecialchars($screen['ticker_color']); ?>">
            </div>

            <div class="form-group">
                <label>Ticker Background Color</label>
                <input type="color" name="ticker_bg_color" value="<?php echo htmlspecialchars($screen['ticker_bg_color']); ?>">
            </div>

            <div class="form-group">
                <label>Rotation Interval (Seconds)</label>
                <input type="number" name="rotation_interval" value="<?php echo htmlspecialchars($screen['rotation_interval']); ?>" min="1" required>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="ticker_enabled" value="1" <?php if ($screen['ticker_enabled']) echo 'checked'; ?>>
                    Enable Ticker
                </label>
            </div>

            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary"><?php echo $isNewScreen ? 'Create Screen' : 'Save Changes'; ?></button>
            </div>

        </form>

        <p class="text-center mt-4">
            <a href="admin.php" class="btn btn-link">← Back to Dashboard</a>
        </p>
    </div>

</div> <!-- admin-content -->

<?php include '../views/admin/footer.php'; ?>
