<?php
// [MAIN] api/list_posts.php – [Cộng đồng] Danh sách bài viết
//   (mặc định)      : bài đã duyệt, kèm bình luận + phản hồi + lượt thích
//   ?category=tips  : lọc chuyên mục (story|tips|rescue|question)
//   ?mine=1         : bài của tôi (mọi trạng thái)
//   ?manage=1       : admin/staff – tất cả bài (để duyệt), có thể thêm &status=pending
require_once '../core/bootstrap.php';

$me = currentUser();
$userId = null;

// 1. Xác định chế độ xem + kiểm tra quyền
if (($_GET['manage'] ?? '') === '1')    { requireRole('admin', 'staff'); $mode = 'manage'; }
elseif (($_GET['mine'] ?? '') === '1')  { $userId = requireLogin()['userId']; $mode = 'mine'; }
else                                    { $mode = 'public'; }

// 2. Lấy bài + gắn bình luận
$posts = PostDAO::listPosts($mode, $me['userId'] ?? null, $userId, $_GET['status'] ?? '', $_GET['category'] ?? '');
$comments = CommentDAO::groupByPosts(array_column($posts, 'postId'));
foreach ($posts as &$po) {
    $po['likes']    = (int)$po['likes'];
    $po['liked']    = (bool)$po['liked'];
    $po['comments'] = $comments[$po['postId']] ?? [];
}
ok(['data' => $posts]);
