<?php
// =====================================================================
// [CORE] Auth.php – Phiên đăng nhập & phân quyền (admin / staff / customer)
// =====================================================================

// ----- [CHỨC NĂNG] Khởi tạo phiên (cookie dùng chung 8000 và 8080) -----
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params(['path' => '/', 'httponly' => true, 'samesite' => 'Lax']);
    session_start();
}

// ----- [CHỨC NĂNG] Lưu / xóa người đăng nhập -----
function loginSession($userId) {
    session_regenerate_id(true);
    $_SESSION['userId'] = $userId;
}
function logoutSession() {
    $_SESSION = [];
    session_destroy();
}

// ----- [CHỨC NĂNG] Lấy người đang đăng nhập -----
function currentUser() {
    static $user = false;
    if ($user !== false) return $user;
    $user = null;
    if (!empty($_SESSION['userId'])) {
        $user = UserDAO::findPublic($_SESSION['userId']);
        if ($user && $user['status'] !== 'active') { $user = null; session_destroy(); }
    }
    return $user;
}

// ----- [CHỨC NĂNG] Kiểm tra quyền -----
function isStaff($u)  { return $u && in_array($u['role'], ['admin', 'staff'], true); }
function requireLogin() {
    $u = currentUser();
    if (!$u) fail('Bạn cần đăng nhập để thực hiện thao tác này', 401);
    return $u;
}
function requireRole(...$roles) {
    $u = requireLogin();
    if (!in_array($u['role'], $roles, true)) fail('Bạn không có quyền thực hiện thao tác này', 403);
    return $u;
}
