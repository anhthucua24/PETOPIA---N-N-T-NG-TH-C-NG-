<?php
// [MAIN] auth/login.php – Đăng nhập bằng tên đăng nhập HOẶC email, phân luồng theo vai trò
require_once '../core/bootstrap.php';

// 1. Đọc & kiểm tra dữ liệu
$login    = input('username');
$password = input('password');
if ($login === '' || $password === '') fail('Vui lòng nhập tài khoản và mật khẩu');

// 2. Gọi DAO tìm tài khoản, so khớp mật khẩu đã mã hóa
$u = UserDAO::findByLogin($login);
if (!$u || !password_verify($password, $u['password'])) fail('Sai tài khoản hoặc mật khẩu', 401);
if ($u['status'] !== 'active') fail('Tài khoản đã bị khóa. Vui lòng liên hệ quản trị viên.', 403);

// 3. Lưu phiên + phân luồng: admin/staff -> trang quản trị, customer -> trang chủ
loginSession($u['userId']);
$redirect = isStaff($u) ? 'admin.php' : 'index.php';
unset($u['password']);
ok(['user' => $u, 'redirect' => $redirect], 'Đăng nhập thành công');
