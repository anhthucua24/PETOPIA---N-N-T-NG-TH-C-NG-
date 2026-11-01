<?php
// [MAIN] api/get_pets.php – [Thú cưng] Danh sách + lọc theo nhu cầu
// Tham số GET (đều tùy chọn):
//   q=tên  species=dog|cat  gender=Đực|Cái  age=0-1|1-3|3-99  size=small|medium|large
//   energy=low|medium|high  need=apartment,kids,senior,active,other_pets,ready
//   featured=1  limit=6  all=1 (admin/staff: xem cả bé đã được nhận nuôi)
require_once '../core/bootstrap.php';

$includeAdopted = ($_GET['all'] ?? '') === '1' && isStaff(currentUser());
ok([
    'data'            => PetDAO::search($_GET, $includeAdopted),
    'total_available' => PetDAO::countAvailable(),
]);
