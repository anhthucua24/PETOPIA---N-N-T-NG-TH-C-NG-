<?php
// img.php – Trả ảnh từ thư mục C:\PETOPIA\images
// Cách dùng: http://localhost:8080/img.php?f=pets/dog_01.jpg
$base = realpath(__DIR__ . '/../images');
$rel  = str_replace('\\', '/', $_GET['f'] ?? '');
$path = $base ? realpath($base . '/' . $rel) : false;

if (!$path || !str_starts_with($path, $base) || !is_file($path)) {
    http_response_code(404);
    exit('Not found');
}
$types = ['jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'webp' => 'image/webp', 'gif' => 'image/gif'];
$ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
if (!isset($types[$ext])) { http_response_code(403); exit; }

header('Content-Type: ' . $types[$ext]);
header('Content-Length: ' . filesize($path));
header('Cache-Control: public, max-age=86400');
readfile($path);
