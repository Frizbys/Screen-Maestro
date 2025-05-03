<?php
$pages = [
  'https://creativecitymedia.com/public/share.php?token=14fe80df1d4d7c9ea6fd18609d1346d2',  // or full URLs like 'https://yourdomain.com/sign1.php'
  'https://creativecitymedia.com/public/share.php?token=cf740566d883cd9cd4b431448fb0baf2',
  'https://creativecitymedia.com/public/share.php?token=23d89ddc4d52eb5df94f2dc6b198efb5'
];

$current = isset($_GET['page']) ? intval($_GET['page']) : 0;
$next = ($current + 1) % count($pages);
header("Refresh: 20; url=rotation.php?page=$next"); // Refresh every 10 seconds
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="refresh" content="10;url=rotation.php?page=<?php echo $next; ?>">
  <title>Signage Rotation</title>
  <style>
    body, html {
      margin: 0;
      padding: 0;
      width: 100%;
      height: 100%;
      overflow: hidden;
      background: black;
    }
    iframe {
      width: 100%;
      height: 100%;
      border: none;
    }
  </style>
</head>
<body>
  <iframe src="<?php echo $pages[$current]; ?>"></iframe>
</body>
</html>
