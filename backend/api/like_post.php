<?php
// [MAIN] api/like_post.php – [Cộng đồng] Thích / bỏ thích bài viết (cần đăng nhập)
require_once '../core/bootstrap.php';
$u = requireLogin();

$postId = input('postId');
$post = PostDAO::find($postId);
if (!$post || $post['status'] !== 'approved') fail('Không tìm thấy bài viết', 404);

$liked = LikeDAO::toggle($postId, $u['userId']);
ok(['liked' => $liked, 'likes' => LikeDAO::count($postId)]);
