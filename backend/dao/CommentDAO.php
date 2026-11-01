<?php
// =====================================================================
// [DAO] CommentDAO.php – Bình luận & phản hồi (bảng comments, parentId = bình luận gốc)
// =====================================================================
class CommentDAO {
    // ----- [CHỨC NĂNG] Lấy bình luận của nhiều bài, nhóm theo postId -----
    public static function groupByPosts(array $postIds) {
        if (!$postIds) return [];
        $ph = implode(',', array_fill(0, count($postIds), '?'));
        $rows = q("SELECT c.*, COALESCE(u.fullName, u.username, 'Ẩn danh') AS author, u.avatar, u.role AS author_role
                   FROM comments c LEFT JOIN users u ON u.userId = c.userId
                   WHERE c.postId IN ($ph) ORDER BY c.created_at", $postIds)->fetchAll();
        $by = [];
        foreach ($rows as $c) $by[$c['postId']][] = $c;
        return $by;
    }
    public static function find($commentId) {
        return q('SELECT postId, parentId FROM comments WHERE commentId = ?', [$commentId])->fetch();
    }

    // ----- [CHỨC NĂNG] Thêm bình luận / phản hồi -----
    public static function insert($postId, $userId, $parentId, $text) {
        $id = generateId('c');
        q('INSERT INTO comments (commentId, postId, userId, parentId, text) VALUES (?,?,?,?,?)',
          [$id, $postId, $userId, $parentId, $text]);
        return $id;
    }
}
