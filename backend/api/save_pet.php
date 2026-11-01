<?php
// [MAIN] api/save_pet.php – [Thú cưng] Thêm (không có id) hoặc sửa (có id)
// Gửi multipart/form-data, ảnh ở field "photo_file"
require_once '../core/bootstrap.php';
requireRole('admin', 'staff');

// 1. Đọc & chuẩn hóa dữ liệu form
$id   = input('id');
$name = input('name');
if ($name === '') fail('Vui lòng nhập tên thú cưng');

$fields = [
    'name'               => $name,
    'species'            => pick(input('species'), ['dog', 'cat'], 'dog'),
    'breed'              => input('breed'),
    'age'                => (float)input('age', 1),
    'gender'             => input('gender') === 'Cái' ? 'Cái' : 'Đực',
    'size'               => pick(input('size'), ['small', 'medium', 'large'], 'medium'),
    'energy'             => pick(input('energy'), ['low', 'medium', 'high'], 'medium'),
    'good_with_kids'     => boolInput('good_with_kids'),
    'good_with_pets'     => boolInput('good_with_pets'),
    'apartment_friendly' => boolInput('apartment_friendly'),
    'vaccinated'         => boolInput('vaccinated'),
    'neutered'           => boolInput('neutered'),
    'featured'           => boolInput('featured'),
    'color'              => input('color'),
    'weight_kg'          => input('weight_kg') === '' ? null : (float)input('weight_kg'),
    'location'           => input('location'),
    'description'        => input('description'),
    'status'             => pick(input('status'), ['available', 'pending', 'adopted'], 'available'),
];

// 2. Lưu ảnh (nếu có chọn)
$photo = saveUpload('photo_file', 'pets');

// 3. Gọi DAO
if ($id) {
    $old = PetDAO::find($id);
    if (!$old) fail('Không tìm thấy thú cưng', 404);
    if ($photo) { $fields['photo'] = $photo; deleteImage($old['photo']); }
    PetDAO::update($id, $fields);
    ok(['id' => $id], 'Đã cập nhật thú cưng');
}
if (!$photo) fail('Vui lòng chọn ảnh cho thú cưng');
$fields['photo'] = $photo;
ok(['id' => PetDAO::insert($fields)], 'Đã thêm thú cưng');
