<?php
// [MAIN] api/users.php – [Tài khoản] Chỉ ADMIN: xem danh sách / đổi vai trò / khóa tài khoản
//   GET                         -> danh sách
//   POST { userId, role }       -> đổi vai trò (admin|staff|customer)
//   POST { userId, status }     -> active | locked
require_once '../core/bootstrap.php';
$me = requireRole('admin');

if ($_SERVER['REQUEST_METHOD'] === 'GET') ok(['data' => UserDAO::listAll()]);

$id = input('userId');
if ($id === $me['userId']) fail('Không thể tự thay đổi tài khoản của chính mình');
if (input('role') !== '') {
    if (!in_array(input('role'), ['admin', 'staff', 'customer'], true)) fail('Vai trò không hợp lệ');
    UserDAO::setRole($id, input('role'));
}
if (input('status') !== '') {
    if (!in_array(input('status'), ['active', 'locked'], true)) fail('Trạng thái không hợp lệ');
    UserDAO::setStatus($id, input('status'));
}
ok([], 'Đã cập nhật tài khoản');
