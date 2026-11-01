<?php
// [MAIN] api/list_adoptions.php – [Nhận nuôi] Admin/staff: tất cả đơn. ?mine=1 – khách: đơn của tôi
require_once '../core/bootstrap.php';

if (($_GET['mine'] ?? '') === '1') {
    $rows = AdoptionDAO::listByUser(requireLogin()['userId']);
} else {
    requireRole('admin', 'staff');
    $rows = AdoptionDAO::listAll();
}
ok(['data' => $rows]);
