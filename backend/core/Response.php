<?php
// =====================================================================
// [CORE] Response.php – Đọc dữ liệu gửi lên & trả kết quả JSON
// =====================================================================

// ----- [CHỨC NĂNG] CORS: cho phép frontend (cổng 8000) gọi backend (cổng 8080) -----
define('FRONTEND_ORIGIN', 'http://localhost:8000');
header('Access-Control-Allow-Origin: ' . FRONTEND_ORIGIN);
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'OPTIONS') { http_response_code(204); exit; }

// ----- [CHỨC NĂNG] Trả kết quả -----
function jsonResponse($data, $status = 200) {
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}
function ok($data = [], $message = 'OK') { jsonResponse(['status' => 'ok', 'message' => $message] + $data); }
function fail($message, $status = 400)   { jsonResponse(['status' => 'error', 'message' => $message], $status); }

// ----- [CHỨC NĂNG] Đọc dữ liệu: JSON hoặc form (multipart khi có ảnh) -----
function getInput() {
    static $data = null;
    if ($data !== null) return $data;
    $json = json_decode(file_get_contents('php://input'), true);
    $data = is_array($json) ? $json : $_POST;
    return $data;
}
function input($key, $default = '') {
    $v = getInput()[$key] ?? $default;
    return is_string($v) ? trim($v) : $v;
}
function boolInput($key) { return in_array(input($key, '0'), ['1', 1, true, 'true', 'on'], true) ? 1 : 0; }

// Chọn giá trị trong danh sách cho phép, sai thì lấy mặc định
function pick($value, array $allowed, $default) { return in_array($value, $allowed, true) ? $value : $default; }
