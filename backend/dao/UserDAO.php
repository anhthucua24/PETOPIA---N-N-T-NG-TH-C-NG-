<?php
// =====================================================================
// [DAO] UserDAO.php – Mọi câu SQL với bảng users
// =====================================================================
class UserDAO {
    const PUBLIC_COLS = 'userId, username, email, fullName, phone, avatar, role, status';

    // ----- [CHỨC NĂNG] Đăng nhập -----
    public static function findByLogin($login) {
        return q('SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1', [$login, $login])->fetch();
    }
    public static function findPublic($userId) {
        return q('SELECT ' . self::PUBLIC_COLS . ' FROM users WHERE userId = ?', [$userId])->fetch() ?: null;
    }

    // ----- [CHỨC NĂNG] Đăng ký -----
    public static function usernameExists($username) {
        return (bool)q('SELECT 1 FROM users WHERE username = ?', [$username])->fetch();
    }
    public static function emailExists($email) {
        return (bool)q('SELECT 1 FROM users WHERE email = ?', [$email])->fetch();
    }
    public static function create($username, $password, $email) {
        $id = generateId('u');
        q('INSERT INTO users (userId, username, password, email, fullName, role) VALUES (?,?,?,?,?,?)',
          [$id, $username, password_hash($password, PASSWORD_DEFAULT), $email, $username, 'customer']);
        return $id;
    }

    // ----- [CHỨC NĂNG] Cập nhật hồ sơ khi gửi đơn nhận nuôi (chỉ điền chỗ trống) -----
    public static function fillContact($userId, $phone, $fullName) {
        q('UPDATE users SET phone = COALESCE(phone, ?), fullName = IF(fullName = username OR fullName IS NULL, ?, fullName) WHERE userId = ?',
          [$phone, $fullName, $userId]);
    }

    // ----- [CHỨC NĂNG] Admin quản lý tài khoản -----
    public static function listAll() {
        return q("SELECT u.userId, u.username, u.email, u.fullName, u.phone, u.role, u.status, u.created_at,
                         (SELECT COUNT(*) FROM posts p WHERE p.userId = u.userId) AS posts,
                         (SELECT COUNT(*) FROM adoptions a WHERE a.userId = u.userId) AS adoptions
                  FROM users u ORDER BY FIELD(u.role,'admin','staff','customer'), u.created_at")->fetchAll();
    }
    public static function setRole($userId, $role) {
        q('UPDATE users SET role = ? WHERE userId = ?', [$role, $userId]);
    }
    public static function setStatus($userId, $status) {
        q('UPDATE users SET status = ? WHERE userId = ?', [$status, $userId]);
    }
}
