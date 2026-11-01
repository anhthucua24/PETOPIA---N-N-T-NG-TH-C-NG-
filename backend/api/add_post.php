<?php
// [MAIN] api/add_post.php – [Cộng đồng] Đăng bài (cần đăng nhập). Ảnh ở field "image_file"
// Khách hàng: bài vào "Chờ duyệt". Admin/staff: tự duyệt.
require_once '../core/bootstrap.php';
$u = requireLogin();

$title    = input('title');
$content  = input('content');
$category = pick(input('category'), ['story', 'tips', 'rescue', 'question'], 'story');
if ($title === '' || $content === '') fail('Vui lòng nhập tiêu đề và nội dung');
if (mb_strlen($title) > 255) fail('Tiêu đề quá dài');

$image   = saveUpload('image_file', 'posts');
$isStaff = isStaff($u);
$id      = PostDAO::insert($u['userId'], $title, $content, $image, $category, $isStaff);

ok(['postId' => $id, 'pending' => !$isStaff],
   $isStaff ? 'Đã đăng bài' : 'Đã gửi bài! Bài viết sẽ hiển thị sau khi được duyệt.');
