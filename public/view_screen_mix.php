<?php
// /public/view_screen_mix.php

// Enable error reporting (for now, during development)
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../config.php';
require_once '../controllers/AdminController.php';

$adminController = new AdminController($pdo);

// Validate input
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    exit('Invalid screen ID');
}

$screen_id = (int)$_GET['id'];

// Fetch screen info
$screen = $adminController->getScreen($screen_id);
if (!$screen) {
    http_response_code(404);
    exit('Screen not found');
}

// Fetch media items
$mediaItems = $adminController->getMediaForScreen($screen_id);

// Fetch ALL content blocks (✅ correct method name!)
$contentBlocks = $adminController->getContentBlocks($screen_id);

// Combine everything into one array
$slides = [];

// Add media files to slides
foreach ($mediaItems as $media) {
    $slides[] = [
        'type' => $media['file_type'],
        'filename' => $media['image_filename']
    ];
}

// Add content blocks to slides
foreach ($contentBlocks as $block) {
    $slides[] = [
        'type' => 'content',
        'html' => $block['content_html']
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($screen['screen_name']); ?> - Frizbys Display</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            background: black;
            overflow: hidden;
            font-family: 'Orbitron', Arial, sans-serif;
            color: #00ffcc;
        }
        .slideshow-container {
            position: relative;
            width: 100vw;
            height: 100vh;
        }
        .slide {
            position: absolute;
            width: 100%;
            height: 100%;
            display: none;
            justify-content: center;
            align-items: center;
            text-align: center;
            background-size: cover;
            background-position: center;
            animation: fadeEffect 1s;
        }
        .content-block {
            padding: 20px;
            max-width: 90%;
            color: #00ffcc;
            font-size: 1.5rem;
        }
        video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        @keyframes fadeEffect {
            from {opacity: 0;}
            to {opacity: 1;}
        }
    </style>
</head>

<body>

<div class="slideshow-container">
<?php if (!empty($slides)): ?>
    <?php foreach ($slides as $item): ?>
        <?php if ($item['type'] === 'image'): ?>
            <div class="slide" style="background-image: url('/uploads/<?php echo htmlspecialchars($item['filename']); ?>');"></div>
        <?php elseif ($item['type'] === 'video'): ?>
            <div class="slide">
                <video src="/uploads/<?php echo htmlspecialchars($item['filename']); ?>" autoplay loop muted playsinline></video>
            </div>
        <?php elseif ($item['type'] === 'content'): ?>
            <div class="slide" style="background-color: black;">
                <div class="content-block">
                    <?php echo $item['html']; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
<?php else: ?>
    <div class="slide" style="background-color: black; display: flex; justify-content: center; align-items: center;">
        <h1 style="color: #00ffcc;">No content available</h1>
    </div>
<?php endif; ?>
</div>

<?php if (!empty($slides)): ?>
<script>
let slideIndex = 0;
showSlides();

function showSlides() {
    let slides = document.getElementsByClassName("slide");
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slideIndex++;
    if (slideIndex > slides.length) {slideIndex = 1}
    slides[slideIndex-1].style.display = "flex";
    setTimeout(showSlides, 8000); // Rotate every 8 seconds
}
</script>
<?php endif; ?>

</body>
</html>
