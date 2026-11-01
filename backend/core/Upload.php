<?php
// =====================================================================
// [CORE] Upload.php – Lưu / xóa ảnh trong C:\PETOPIA\images\<pets|posts|avatars>
// =====================================================================
define('IMAGE_DIR', realpath(__DIR__ . '/../../images') ?: __DIR__ . '/../../images');

// ----- [CHỨC NĂNG] Lưu ảnh tải lên -> trả "pets/abc.jpg" hoặc null nếu không chọn file -----
function saveUpload($field, $subdir) {
    if (empty($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) return null;
    $f = $_FILES[$field];
    if ($f['error'] !== UPLOAD_ERR_OK)       fail('Tải ảnh thất bại (mã lỗi ' . $f['error'] . ')');
    if ($f['size'] > 5 * 1024 * 1024)        fail('Ảnh tối đa 5MB');
    $mime = mime_content_type($f['tmp_name']);
    $exts = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp', 'image/gif' => 'gif'];
    if (!isset($exts[$mime]))                fail('Chỉ nhận ảnh JPG, PNG, WEBP, GIF');
    if (!in_array($subdir, ['pets', 'posts', 'avatars'], true)) fail('Thư mục ảnh không hợp lệ');

    $dir = IMAGE_DIR . DIRECTORY_SEPARATOR . $subdir;
    if (!is_dir($dir)) mkdir($dir, 0777, true);
    $name = date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $exts[$mime];
    if (!move_uploaded_file($f['tmp_name'], $dir . DIRECTORY_SEPARATOR . $name)) fail('Không lưu được ảnh');
    return "$subdir/$name";
}

// ----- [CHỨC NĂNG] Xóa ảnh cũ (chỉ trong thư mục images) -----
function deleteImage($rel) {
    if (!$rel || preg_match('#^https?://#', $rel)) return;
    $path = realpath(IMAGE_DIR . DIRECTORY_SEPARATOR . $rel);
    if ($path && str_starts_with($path, IMAGE_DIR) && is_file($path)) @unlink($path);
}
