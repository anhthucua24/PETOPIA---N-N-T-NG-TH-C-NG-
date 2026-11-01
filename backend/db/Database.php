<?php
// =====================================================================
// [DB] Database.php – Kết nối MySQL bằng PDO
//   db()            : trả về đối tượng kết nối (chỉ tạo 1 lần)
//   q($sql, $params): chạy câu SQL có tham số (chống SQL injection)
// =====================================================================
require_once __DIR__ . '/config.php';

function db() {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            jsonResponse(['status' => 'error', 'message' => 'Không kết nối được MySQL: ' . $e->getMessage()], 500);
        }
    }
    return $pdo;
}

function q($sql, $params = []) {
    $st = db()->prepare($sql);
    $st->execute($params);
    return $st;
}

// Tạo mã ngẫu nhiên cho khóa chính, vd: pet_a1b2c3d4e5
function generateId($prefix = 'id') { return $prefix . '_' . bin2hex(random_bytes(5)); }
