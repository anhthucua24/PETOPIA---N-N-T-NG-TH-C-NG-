<?php
// [MAIN] api/delete_pet.php – [Thú cưng] Xóa (admin, staff)
require_once '../core/bootstrap.php';
requireRole('admin', 'staff');

$pet = PetDAO::find(input('id'));
if (!$pet) fail('Không tìm thấy thú cưng', 404);
PetDAO::delete($pet['id']);
deleteImage($pet['photo']);
ok([], 'Đã xoá thú cưng');
