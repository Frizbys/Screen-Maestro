<?php
// /public/view_screen_content_multi.php

require_once '../config.php';
require_once '../controllers/AdminController.php';

$adminController = new AdminController($pdo);

// Validate Screen ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    exit('Invalid screen ID.');
}

$screen_id = (int)$_GET['id'];

// Fetch screen settings
$screen = $adminController->getScreen($screen_id);
if (!$screen) {
    http_response_code(404);
    exit('Screen not found.');
}

// Fetch all content blocks
$stmt = $pdo->prepare("SELECT * FROM screen_contents WHERE screen_id = ? ORDER BY sort_order ASC, id ASC");
$stmt->execute([$screen_id]);
$contents = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($screen['screen_name']); ?> - Content Display</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap" rel="stylesheet">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            background: black;
            color: #00ffcc;
            font-family: 'Orbitron', Arial, sans-serif;
            overflow: hidden;
            height: 100%;
        }
        .slide {
            display: none;
            height: 100vh;
            width: 100vw;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
            animation: fadeEffect 2s;
        }
        .slide-content {
            width: 90%;
            margin: 0 auto;
        }
        @keyframes fadeEffect {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>

<?php foreach ($contents as $index => $content): ?>
    <div class="slide <?php echo ($index === 0) ? 'active' : ''; ?>">
        <div class="slide-content">
            <?php echo $content['html_content']; ?>
        </div>
    </div>
<?php endforeach; ?>

<script>
let slides = document.querySelectorAll('.slide');
let currentIndex = 0;

function showSlide(index) {
    slides.forEach((slide, i) => {
        slide.style.display = (i === index) ? 'flex' : 'none';
    });
}

function nextSlide() {
    currentIndex = (currentIndex + 1) % slides.length;
    showSlide(currentIndex);
}

showSlide(currentIndex);
setInterval(nextSlide, 8000); // Rotate every 8 seconds
</script>

</body>
</html>
