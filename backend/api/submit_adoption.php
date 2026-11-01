<?php
// [MAIN] api/submit_adoption.php – [Nhận nuôi] Khách gửi đơn (cần đăng nhập)
require_once '../core/bootstrap.php';
$u = requireLogin();

// 1. Đọc & kiểm tra dữ liệu
$petId    = input('petId');
$fullName = input('fullName');
$phone    = preg_replace('/\D/', '', input('phone'));
$address  = input('address');

if ($fullName === '' || $address === '')       fail('Vui lòng nhập họ tên và địa chỉ');
if (!preg_match('/^0\d{9,10}$/', $phone))       fail('Số điện thoại không hợp lệ');
$pet = PetDAO::find($petId);
if (!$pet)                                      fail('Vui lòng chọn thú cưng');
if ($pet['status'] === 'adopted')               fail('Bé ' . $pet['name'] . ' đã có nhà mới rồi');
if (AdoptionDAO::hasPending($u['userId'], $petId)) fail('Bạn đã gửi đơn cho bé này, vui lòng chờ duyệt');

// 2. Lưu đơn (kèm khảo sát)
$id = AdoptionDAO::insert([
    'userId'         => $u['userId'],
    'petId'          => $petId,
    'fullName'       => $fullName,
    'phone'          => $phone,
    'email'          => input('email') ?: $u['email'],
    'address'        => $address,
    'housing_type'   => pick(input('housing_type'), ['apartment', 'house', 'house_with_yard'], 'apartment'),
    'has_children'   => boolInput('has_children'),
    'has_other_pets' => boolInput('has_other_pets'),
    'experience'     => pick(input('experience'), ['none', 'some', 'experienced'], 'none'),
    'hours_alone'    => input('hours_alone') === '' ? null : max(0, min(24, (int)input('hours_alone'))),
    'reason'         => input('reason'),
]);

// 3. Bé chuyển sang "đang có người đăng ký" + lưu SĐT/họ tên vào hồ sơ
PetDAO::markPending($petId);
UserDAO::fillContact($u['userId'], $phone, $fullName);

ok(['requestId' => $id], 'Đã gửi đơn nhận nuôi thành công!');
