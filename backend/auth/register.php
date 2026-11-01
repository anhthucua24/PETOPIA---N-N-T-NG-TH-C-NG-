<?php
// [MAIN] auth/register.php – Tạo tài khoản khách hàng: tên đăng nhập, mật khẩu, Gmail
require_once '../core/bootstrap.php';

// 1. Đọc dữ liệu
$username = input('username');
$password = input('password');
$confirm  = input('confirm');
$email    = strtolower(input('email'));

// 2. Kiểm tra hợp lệ
if (!preg_match('/^[a-zA-Z0-9_.]{4,30}$/', $username)) fail('Tên đăng nhập 4–30 ký tự, chỉ gồm chữ không dấu, số, dấu _ hoặc .');
if (strlen($password) < 6)                               fail('Mật khẩu tối thiểu 6 ký tự');
if ($password !== $confirm)                              fail('Mật khẩu nhập lại không khớp');
if (!filter_var($email, FILTER_VALIDATE_EMAIL))          fail('Email không hợp lệ');
if (!str_ends_with($email, '@gmail.com'))                fail('Vui lòng dùng địa chỉ Gmail (@gmail.com)');
if (UserDAO::usernameExists($username))                  fail('Tên đăng nhập đã tồn tại');
if (UserDAO::emailExists($email))                        fail('Gmail này đã được đăng ký');

// 3. Lưu vào DB rồi đăng nhập luôn
$id = UserDAO::create($username, $password, $email);
loginSession($id);
ok(['user' => currentUser(), 'redirect' => 'index.php'], 'Tạo tài khoản thành công');
