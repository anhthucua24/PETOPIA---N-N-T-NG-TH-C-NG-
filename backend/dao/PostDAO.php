<?php
// =====================================================================
// [DAO] PostDAO.php – Mọi câu SQL với bảng posts
// =====================================================================
class PostDAO {
    // ----- [CHỨC NĂNG] Danh sách bài viết (kèm tác giả, người duyệt, lượt thích) -----
    // $mode: 'public' (đã duyệt) | 'mine' | 'manage'
    public static function listPosts($mode, $viewerId, $userId = null, $status = '', $category = '') {
        $where = []; $p = [];
        if ($mode === 'manage')    { if ($status !== '') { $where[] = 'p.status = ?'; $p[] = $status; } }
        elseif ($mode === 'mine')  { $where[] = 'p.userId = ?'; $p[] = $userId; }
        else                       { $where[] = "p.status = 'approved'"; }
        if ($category !== '')      { $where[] = 'p.category = ?'; $p[] = $category; }

        $sql = "SELECT p.*, u.username, COALESCE(u.fullName, u.username, 'Ẩn danh') AS author, u.avatar, u.role AS author_role,
                       r.username AS reviewer,
                       (SELECT COUNT(*) FROM post_likes l WHERE l.postId = p.postId) AS likes,
                       (SELECT COUNT(*) FROM post_likes l WHERE l.postId = p.postId AND l.userId = ?) AS liked
                FROM posts p
                LEFT JOIN users u ON u.userId = p.userId
                LEFT JOIN users r ON r.userId = p.reviewed_by"
             . ($where ? ' WHERE ' . implode(' AND ', $where) : '')
             . ' ORDER BY p.created_at DESC';
        return q($sql, [$viewerId ?? '', ...$p])->fetchAll();
    }
    public static function find($postId) {
        return q('SELECT * FROM posts WHERE postId = ?', [$postId])->fetch();
    }

    // ----- [CHỨC NĂNG] Đăng bài -----
    public static function insert($userId, $title, $content, $image, $category, $autoApprove) {
        $id = generateId('post');
        q('INSERT INTO posts (postId, userId, title, content, image, category, status, reviewed_by, reviewed_at) VALUES (?,?,?,?,?,?,?,?,?)',
          [$id, $userId, $title, $content, $image, $category,
           $autoApprove ? 'approved' : 'pending', $autoApprove ? $userId : null, $autoApprove ? date('Y-m-d H:i:s') : null]);
        return $id;
    }

    // ----- [CHỨC NĂNG] Duyệt / từ chối bài -----
    public static function review($postId, $approve, $reason, $reviewerId) {
        $st = q('UPDATE posts SET status = ?, reject_reason = ?, reviewed_by = ?, reviewed_at = NOW() WHERE postId = ?',
                [$approve ? 'approved' : 'rejected', $approve ? null : $reason, $reviewerId, $postId]);
        return $st->rowCount() > 0;
    }

    // ----- [CHỨC NĂNG] Xóa bài -----
    public static function delete($postId) {
        q('DELETE FROM posts WHERE postId = ?', [$postId]);
    }
}
