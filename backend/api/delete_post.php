<?php
// [MAIN] api/delete_post.php – [Cộng đồng] Admin/staff xóa bất kỳ bài nào; khách chỉ xóa bài của mình
require_once '../core/bootstrap.php';
$u = requireLogin();

$post = PostDAO::find(input('postId'));
if (!$post) fail('Không tìm thấy bài viết', 404);
if ($post['userId'] !== $u['userId'] && !isStaff($u)) fail('Bạn không có quyền xoá bài này', 403);
PostDAO::delete($post['postId']);
deleteImage($post['image']);
ok([], 'Đã xoá bài viết');
