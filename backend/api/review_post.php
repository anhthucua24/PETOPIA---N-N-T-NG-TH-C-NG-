<?php
// [MAIN] api/review_post.php – [Cộng đồng] Admin/staff duyệt hoặc từ chối bài
// Body: { postId, action: "approve" | "reject", reason }
require_once '../core/bootstrap.php';
$u = requireRole('admin', 'staff');

$action = input('action');
$reason = input('reason');
if (!in_array($action, ['approve', 'reject'], true)) fail('Thao tác không hợp lệ');
if ($action === 'reject' && $reason === '') fail('Vui lòng nhập lý do từ chối');

if (!PostDAO::review(input('postId'), $action === 'approve', $reason, $u['userId'])) fail('Không tìm thấy bài viết', 404);
ok([], $action === 'approve' ? 'Đã duyệt bài viết' : 'Đã từ chối bài viết');
