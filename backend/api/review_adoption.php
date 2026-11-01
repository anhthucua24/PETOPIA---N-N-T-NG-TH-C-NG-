<?php
// [MAIN] api/review_adoption.php – [Nhận nuôi] Admin/staff duyệt / từ chối đơn
// Body: { requestId, action: "approve" | "reject", note }
require_once '../core/bootstrap.php';
$u = requireRole('admin', 'staff');

// 1. Kiểm tra dữ liệu
$id     = input('requestId');
$action = input('action');
$note   = input('note');
if (!in_array($action, ['approve', 'reject'], true)) fail('Thao tác không hợp lệ');
if ($action === 'reject' && $note === '') fail('Vui lòng nhập lý do từ chối');

$a = AdoptionDAO::find($id);
if (!$a) fail('Không tìm thấy đơn', 404);
if ($a['status'] !== 'pending') fail('Đơn này đã được xử lý');

// 2. Cập nhật trong 1 transaction (đơn + trạng thái thú cưng)
$pdo = db();
$pdo->beginTransaction();
AdoptionDAO::review($id, $action === 'approve', $note, $u['userId']);
if ($action === 'approve') {
    PetDAO::markAdopted($a['petId']);
    AdoptionDAO::rejectOthers($a['petId'], $u['userId']);
} else {
    PetDAO::releaseIfNoPending($a['petId']);
}
$pdo->commit();
ok([], $action === 'approve' ? 'Đã duyệt đơn' : 'Đã từ chối đơn');
