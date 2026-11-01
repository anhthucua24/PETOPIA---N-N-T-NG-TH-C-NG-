<?php
// =====================================================================
// [DAO] LikeDAO.php – Lượt thích bài viết (bảng post_likes)
// =====================================================================
class LikeDAO {
    // ----- [CHỨC NĂNG] Thích / bỏ thích -> trả true nếu sau thao tác là "đang thích" -----
    public static function toggle($postId, $userId) {
        if (q('SELECT 1 FROM post_likes WHERE postId = ? AND userId = ?', [$postId, $userId])->fetch()) {
            q('DELETE FROM post_likes WHERE postId = ? AND userId = ?', [$postId, $userId]);
            return false;
        }
        q('INSERT INTO post_likes (postId, userId) VALUES (?, ?)', [$postId, $userId]);
        return true;
    }
    public static function count($postId) {
        return (int)q('SELECT COUNT(*) FROM post_likes WHERE postId = ?', [$postId])->fetchColumn();
    }
}
