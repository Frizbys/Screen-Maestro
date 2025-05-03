<?php
// /public/media_manager.php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

require_once '../config.php';
require_once '../controllers/AdminController.php';

$adminController = new AdminController($pdo);

// Validate screen ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Invalid Screen ID');
}
$screen_id = (int)$_GET['id'];

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['media_file'])) {
    $file = $_FILES['media_file'];

    if ($file['error'] === 0) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'video/mp4', 'image/webp', 'video/webm'];
        if (in_array($file['type'], $allowedTypes)) {
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $newFilename = uniqid('media_', true) . '.' . $extension;

            if (!is_dir($uploads_dir)) {
                mkdir($uploads_dir, 0755, true);
            }

            $destination = $uploads_dir . '/' . $newFilename;

            if (move_uploaded_file($file['tmp_name'], $destination)) {
                $fileType = (strpos($file['type'], 'video') !== false) ? 'video' : 'image';
                $adminController->addMediaToScreen($screen_id, $newFilename, $fileType);
                header('Location: media_manager.php?id=' . $screen_id);
                exit();
            } else {
                $error = 'Failed to move uploaded file.';
            }
        } else {
            $error = 'Invalid file type. Only JPG, PNG, GIF, MP4, WEBP, WEBM allowed.';
        }
    } else {
        $error = 'File upload error.';
    }
}

// Fetch current media
$mediaItems = $adminController->getMediaForScreen($screen_id);

// Load header (contains <html><head><body><nav> etc.)
include '../views/admin/header.php';
?>
<div class="form-container">
<h1>Manage Media for Screen <?php echo $screen_id; ?></h1>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data" class="form-group">
    <label>Upload Image or Video:</label><br>
    <input type="file" name="media_file" required>
    <button type="submit" class="btn btn-success mt-2">Upload</button>
</form>
</div>
<div class="form-container">
<h2>Current Media:</h2>

<div class="media-gallery">
    <?php if ($mediaItems): ?>
        <?php foreach ($mediaItems as $media): ?>
            <div class="media-item">
                <?php if ($media['file_type'] === 'image'): ?>
                    <img src="../uploads/<?php echo htmlspecialchars($media['image_filename']); ?>" alt="Media">
                <?php else: ?>
                    <video src="../uploads/<?php echo htmlspecialchars($media['image_filename']); ?>" controls></video>
                <?php endif; ?>

                <form method="post" action="delete_media.php" style="margin-top: 5px;">
                    <input type="hidden" name="media_id" value="<?php echo (int)$media['id']; ?>">
                    <input type="hidden" name="screen_id" value="<?php echo (int)$screen_id; ?>">
                    <button type="submit" class="btn btn-danger mt-2">🗑️ Delete</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No media uploaded yet.</p>
    <?php endif; ?>
</div>

<p class="mt-4"><a href="admin.php" class="btn btn-primary">← Back to Admin Dashboard</a></p>

<?php include '../views/admin/footer.php'; ?> <!-- If you have a footer.php -->
</div>