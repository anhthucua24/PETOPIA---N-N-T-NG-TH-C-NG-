<?php
// [MAIN] api/add_comment.php – [Cộng đồng] Bình luận / trả lời bình luận (cần đăng nhập)
// Body: { postId, text, parentId? }
require_once '../core/bootstrap.php';
$u = requireLogin();

$postId   = input('postId');
$text     = input('text');
$parentId = input('parentId') ?: null;
if ($text === '') fail('Vui lòng nhập nội dung bình luận');

$post = PostDAO::find($postId);
if (!$post) fail('Không tìm thấy bài viết', 404);
if ($post['status'] !== 'approved') fail('Bài viết chưa được duyệt');

if ($parentId) {
    $parent = CommentDAO::find($parentId);
    if (!$parent || $parent['postId'] !== $postId) fail('Bình luận gốc không hợp lệ');
    // Chỉ lồng 1 cấp: trả lời 1 phản hồi -> gắn vào bình luận gốc
    if ($parent['parentId']) $parentId = $parent['parentId'];
}

$id = CommentDAO::insert($postId, $u['userId'], $parentId, $text);
ok(['comment' => [
    'commentId' => $id, 'postId' => $postId, 'parentId' => $parentId, 'text' => $text,
    'author' => $u['fullName'] ?: $u['username'], 'author_role' => $u['role'], 'created_at' => date('Y-m-d H:i:s'),
]], 'Đã gửi bình luận');
