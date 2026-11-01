<?php
// =====================================================================
// [DAO] AdoptionDAO.php – Đơn nhận nuôi (bảng adoptions)
// =====================================================================
class AdoptionDAO {
    const BASE_SELECT = "SELECT a.*, p.name AS petName, p.photo AS petPhoto, p.species, r.username AS reviewer
                         FROM adoptions a
                         LEFT JOIN pets p  ON p.id = a.petId
                         LEFT JOIN users r ON r.userId = a.reviewed_by";

    // ----- [CHỨC NĂNG] Danh sách đơn -----
    public static function listByUser($userId) {
        return q(self::BASE_SELECT . ' WHERE a.userId = ? ORDER BY a.created_at DESC', [$userId])->fetchAll();
    }
    public static function listAll() {
        return q(self::BASE_SELECT . " ORDER BY a.status = 'pending' DESC, a.created_at DESC")->fetchAll();
    }
    public static function find($requestId) {
        return q('SELECT petId, status FROM adoptions WHERE requestId = ?', [$requestId])->fetch();
    }

    // ----- [CHỨC NĂNG] Gửi đơn -----
    public static function hasPending($userId, $petId) {
        return (bool)q("SELECT 1 FROM adoptions WHERE userId = ? AND petId = ? AND status = 'pending'", [$userId, $petId])->fetch();
    }
    public static function insert(array $d) {
        $id = generateId('req');
        q('INSERT INTO adoptions (requestId, userId, petId, fullName, phone, email, address, housing_type, has_children, has_other_pets, experience, hours_alone, reason)
           VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)', [
            $id, $d['userId'], $d['petId'], $d['fullName'], $d['phone'], $d['email'], $d['address'],
            $d['housing_type'], $d['has_children'], $d['has_other_pets'], $d['experience'], $d['hours_alone'], $d['reason'],
        ]);
        return $id;
    }

    // ----- [CHỨC NĂNG] Duyệt / từ chối đơn -----
    public static function review($requestId, $approve, $note, $reviewerId) {
        q('UPDATE adoptions SET status = ?, admin_note = ?, reviewed_by = ?, reviewed_at = NOW() WHERE requestId = ?',
          [$approve ? 'approved' : 'rejected', $note ?: null, $reviewerId, $requestId]);
    }
    // Bé đã có nhà -> các đơn chờ khác của bé tự động bị từ chối
    public static function rejectOthers($petId, $reviewerId) {
        q("UPDATE adoptions SET status = 'rejected', admin_note = 'Bé đã được người khác nhận nuôi', reviewed_by = ?, reviewed_at = NOW()
           WHERE petId = ? AND status = 'pending'", [$reviewerId, $petId]);
    }
}
