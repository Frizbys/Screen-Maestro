<?php
// /public/qr_generator.php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../libs/phpqrcode/qrlib.php'; // Correct path to the library

if (!isset($_GET['data']) || empty($_GET['data'])) {
    http_response_code(400);
    exit('No QR data provided.');
}

$qrData = urldecode($_GET['data']);
$size = isset($_GET['size']) ? (int)$_GET['size'] : 5;

if ($size < 1 || $size > 10) {
    $size = 5;
}

// Set content type header
header('Content-Type: image/png');

// Generate and output the QR code
QRcode::png($qrData, false, QR_ECLEVEL_L, $size);
?>
