<?php
// =====================================================================
// [DAO] PetDAO.php – Mọi câu SQL với bảng pets
// =====================================================================
class PetDAO {
    // Bộ lọc theo nhu cầu người dùng (need=...)
    const NEEDS = [
        'apartment'  => "apartment_friendly = 1 AND size <> 'large'",   // Sống ở chung cư
        'kids'       => "good_with_kids = 1 AND energy <> 'high'",      // Nhà có trẻ nhỏ
        'senior'     => "energy = 'low'",                               // Người lớn tuổi / ít thời gian
        'active'     => "energy = 'high'",                              // Thích vận động
        'other_pets' => "good_with_pets = 1",                           // Đã có thú cưng khác
        'ready'      => "vaccinated = 1 AND neutered = 1",              // Sẵn sàng về nhà
    ];

    // ----- [CHỨC NĂNG] Danh sách + lọc -----
    // $f: q, species, gender, size, energy, age ("1-3"), need ("kids,apartment"), featured, limit
    public static function search(array $f, $includeAdopted = false) {
        $where = []; $p = [];
        if (!$includeAdopted)       $where[] = "status <> 'adopted'";
        if (!empty($f['q']))       { $where[] = 'name LIKE ?'; $p[] = '%' . $f['q'] . '%'; }
        foreach (['species', 'gender', 'size', 'energy'] as $col) {
            if (!empty($f[$col]))  { $where[] = "$col = ?";    $p[] = $f[$col]; }
        }
        if (!empty($f['age']) && preg_match('/^(\d+(?:\.\d+)?)-(\d+(?:\.\d+)?)$/', $f['age'], $m)) {
            $where[] = 'age >= ? AND age < ?'; $p[] = (float)$m[1]; $p[] = (float)$m[2];
        }
        if (!empty($f['need'])) {
            foreach (explode(',', $f['need']) as $n) {
                if (isset(self::NEEDS[$n])) $where[] = '(' . self::NEEDS[$n] . ')';
            }
        }
        if (($f['featured'] ?? '') === '1') $where[] = 'featured = 1';

        $sql = 'SELECT * FROM pets' . ($where ? ' WHERE ' . implode(' AND ', $where) : '')
             . ' ORDER BY featured DESC, created_at DESC';
        if (!empty($f['limit'])) $sql .= ' LIMIT ' . max(1, min(100, (int)$f['limit']));

        $rows = q($sql, $p)->fetchAll();
        foreach ($rows as &$r) {
            $r['age'] = (float)$r['age'];
            $r['weight_kg'] = $r['weight_kg'] !== null ? (float)$r['weight_kg'] : null;
        }
        return $rows;
    }
    public static function countAvailable() {
        return (int)q("SELECT COUNT(*) FROM pets WHERE status <> 'adopted'")->fetchColumn();
    }
    public static function find($id) {
        return q('SELECT * FROM pets WHERE id = ?', [$id])->fetch();
    }

    // ----- [CHỨC NĂNG] Thêm / sửa / xóa (admin, staff) -----
    public static function insert(array $fields) {
        $fields['id'] = generateId('pet');
        $cols = implode(', ', array_map(fn($k) => "`$k`", array_keys($fields)));
        $ph   = implode(', ', array_fill(0, count($fields), '?'));
        q("INSERT INTO pets ($cols) VALUES ($ph)", array_values($fields));
        return $fields['id'];
    }
    public static function update($id, array $fields) {
        $set = implode(', ', array_map(fn($k) => "`$k` = ?", array_keys($fields)));
        q("UPDATE pets SET $set WHERE id = ?", [...array_values($fields), $id]);
    }
    public static function delete($id) {
        q('DELETE FROM pets WHERE id = ?', [$id]);
    }

    // ----- [CHỨC NĂNG] Đổi trạng thái theo đơn nhận nuôi -----
    public static function markPending($id) {
        q("UPDATE pets SET status = 'pending' WHERE id = ? AND status = 'available'", [$id]);
    }
    public static function markAdopted($id) {
        q("UPDATE pets SET status = 'adopted' WHERE id = ?", [$id]);
    }
    // Không còn đơn chờ nào -> bé trở lại "sẵn sàng"
    public static function releaseIfNoPending($id) {
        q("UPDATE pets SET status = 'available' WHERE id = ? AND status = 'pending'
           AND NOT EXISTS (SELECT 1 FROM adoptions WHERE petId = ? AND status = 'pending')", [$id, $id]);
    }
}
