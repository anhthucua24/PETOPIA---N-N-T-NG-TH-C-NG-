<?php
// [MAIN] auth/me.php – Thông tin người đang đăng nhập (null nếu chưa đăng nhập)
require_once '../core/bootstrap.php';
ok(['user' => currentUser()]);
