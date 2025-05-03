<?php
// /public/view_screen_content.php
// $adminController, $screen, and $screen_id are already available

$contentHtml = $adminController->getScreenContentHtml($screen_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($screen['screen_name']) ?> - Content Screen</title>
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <meta http-equiv="refresh" content="300"> <!-- Optional: auto-refresh every 5 minutes -->

    <style>
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            background: #000;
            color: #fff;
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
        }

        .content-wrapper {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 4vw;
            box-sizing: border-box;
            overflow: auto;
        }

        .content-wrapper * {
            max-width: 100%;
            word-break: break-word;
            font-size: clamp(1.5rem, 3vw, 3rem);
        }

        .content-wrapper img,
        .content-wrapper video {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        @media (max-width: 600px) {
            .content-wrapper {
                padding: 6vw;
            }

            .content-wrapper * {
                font-size: clamp(1.25rem, 5vw, 2rem);
            }
        }
    </style>
</head>
<body>
    <div class="content-wrapper">
        <?= $contentHtml ?>
    </div>
</body>
</html>
