<?php
// [MAIN] auth/logout.php – Đăng xuất
require_once '../core/bootstrap.php';
logoutSession();
ok([], 'Đã đăng xuất');
