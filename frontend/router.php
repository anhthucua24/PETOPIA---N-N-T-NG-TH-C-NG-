<?php
// router.php – dùng cho PHP built-in server: tự chuyển *.html cũ sang *.php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (preg_match('#^/(.+)\.html$#', $path, $m) && file_exists(__DIR__ . '/' . $m[1] . '.php')) {
    $qs = $_SERVER['QUERY_STRING'] ?? '';
    header('Location: /' . $m[1] . '.php' . ($qs ? "?$qs" : ''), true, 301);
    exit;
}
return false; // phục vụ file bình thường
