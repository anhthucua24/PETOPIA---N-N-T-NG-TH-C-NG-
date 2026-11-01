-- =====================================================================
-- seed.sql – Dữ liệu mẫu PETOPIA (import SAU schema.sql)
-- Tài khoản demo:
--   admin   / Petopia123  (admin)
--   staff01 / Staff@123   (staff – duyệt đơn + duyệt bài)
--   lananh, minhduc, thuha, hoangnam / Khach@123  (customer)
-- =====================================================================
USE petopia;

-- ---------------------------------------------------------------------
-- USERS
-- ---------------------------------------------------------------------
INSERT INTO users (userId, username, password, email, fullName, phone, role, created_at) VALUES
('u_admin',   'admin',    '$2y$10$8yiU4b88OPsw6lKK1qroMebRU0md5JomfNdeOly7INtrJz4KKzQfe', 'admin@petopia.vn',        'Quản trị viên',   '0900000001', 'admin',    '2026-09-01 08:00:00'),
('u_staff01', 'staff01',  '$2y$10$8yiU4b88OPsw6lKK1qroMebRU0md5JomfNdeOly7INtrJz4KKzQfe', 'staff01@petopia.vn',      'Đặng Thị Thu',    '0900000002', 'staff',    '2026-09-05 08:00:00'),
('u_lananh',  'lananh',   '$2y$10$8yiU4b88OPsw6lKK1qroMebRU0md5JomfNdeOly7INtrJz4KKzQfe', 'lananh.nguyen@gmail.com', 'Nguyễn Lan Anh',  '0912345678', 'customer', '2026-09-20 10:15:00'),
('u_minhduc', 'minhduc',  '$2y$10$8yiU4b88OPsw6lKK1qroMebRU0md5JomfNdeOly7INtrJz4KKzQfe', 'minhduc.tran@gmail.com',  'Trần Minh Đức',   '0987654321', 'customer', '2026-09-25 19:40:00'),
('u_thuha',   'thuha',    '$2y$10$8yiU4b88OPsw6lKK1qroMebRU0md5JomfNdeOly7INtrJz4KKzQfe', 'thuha.pham@gmail.com',    'Phạm Thu Hà',     '0938111222', 'customer', '2026-10-02 21:05:00'),
('u_hoangnam','hoangnam', '$2y$10$8yiU4b88OPsw6lKK1qroMebRU0md5JomfNdeOly7INtrJz4KKzQfe', 'hoangnam.le@gmail.com',   'Lê Hoàng Nam',    '0909333444', 'customer', '2026-10-10 07:30:00');

-- ---------------------------------------------------------------------
-- PETS (12 chó + 12 mèo) – ảnh nằm ở C:\PETOPIA\images\pets\
-- ---------------------------------------------------------------------
INSERT INTO pets (id, name, species, breed, age, gender, size, energy, good_with_kids, good_with_pets, apartment_friendly, vaccinated, neutered, color, weight_kg, location, photo, description, featured, created_at) VALUES
-- CHÓ
('pet_001','Mochi',  'dog','Poodle',              2.0,'Đực','small', 'medium',1,1,1,1,1,'Nâu kem',     5.5,'Quận 3, TP.HCM',     'pets/dog_01.jpg','Mochi thông minh, vui vẻ, rất dễ huấn luyện. Lông xoăn ít rụng – hợp người bị dị ứng nhẹ.',1,'2026-10-01 09:00:00'),
('pet_002','Buddy',  'dog','Golden Retriever',    3.0,'Đực','large', 'high',  1,1,0,1,1,'Vàng',        30.0,'TP. Thủ Đức',        'pets/dog_02.jpg','Buddy cực kỳ thân thiện, mê trẻ con và thích chạy bộ buổi sáng. Cần sân rộng để vận động.',1,'2026-10-03 09:00:00'),
('pet_003','Rex',    'dog','Husky',               4.0,'Đực','large', 'high',  1,0,0,1,1,'Xám trắng',   24.0,'Quận 7, TP.HCM',     'pets/dog_03.jpg','Rex năng động, hay "nói chuyện". Hợp chủ thích vận động, nhà mát. Nên là thú cưng duy nhất.',0,'2026-10-04 09:00:00'),
('pet_004','Bông',   'dog','Beagle',              1.5,'Cái','medium','high',  1,1,0,1,0,'Vàng trắng',  10.0,'Bình Thạnh, TP.HCM', 'pets/dog_04.jpg','Bông mũi thính, tò mò, cực kỳ hòa đồng với chó mèo khác. Hơi hay sủa khi ở một mình.',1,'2026-10-05 09:00:00'),
('pet_005','Mập',    'dog','Pug',                 5.0,'Đực','small', 'low',   1,1,1,1,1,'Vàng mơ',     8.0,'Gò Vấp, TP.HCM',     'pets/dog_05.jpg','Mập hiền lành, lười vận động, thích nằm cạnh chủ. Rất hợp người lớn tuổi hoặc ở chung cư.',0,'2026-10-06 09:00:00'),
('pet_006','Bơ',     'dog','Bulldog Pháp',        2.0,'Cái','small', 'low',   1,1,1,1,1,'Kem',         11.0,'Quận 1, TP.HCM',     'pets/dog_06.jpg','Bơ điềm tĩnh, ít sủa, ngủ nhiều. Lựa chọn tuyệt vời cho căn hộ nhỏ.',1,'2026-10-07 09:00:00'),
('pet_007','Tiêu',   'dog','Jack Russell lai',    1.0,'Đực','small', 'high',  1,1,1,1,0,'Tam thể',     6.5,'Tân Bình, TP.HCM',   'pets/dog_07.jpg','Tiêu nhanh nhẹn, lanh lợi, học lệnh rất nhanh. Cần được chơi đùa mỗi ngày.',0,'2026-10-08 09:00:00'),
('pet_008','Cam',    'dog','Chó lai Retriever',   2.5,'Cái','medium','high',  1,1,0,1,1,'Nâu đỏ',      18.0,'Quận 2, TP.HCM',     'pets/dog_08.jpg','Cam được cứu từ bãi biển Vũng Tàu, mê nước và bơi lội. Rất trung thành.',0,'2026-10-09 09:00:00'),
('pet_009','Lúa',    'dog','Corgi',               0.5,'Đực','small', 'medium',1,1,1,1,0,'Vàng trắng',  4.0,'Phú Nhuận, TP.HCM',  'pets/dog_09.jpg','Lúa mới 6 tháng, chân ngắn tai to, siêu đáng yêu. Đang học đi vệ sinh đúng chỗ.',1,'2026-10-10 09:00:00'),
('pet_010','Socola', 'dog','Labrador',            6.0,'Đực','large', 'medium',1,1,0,1,1,'Nâu socola',  32.0,'Quận 9, TP.HCM',     'pets/dog_10.jpg','Socola hiền, nghe lời, từng là chó gia đình. Hợp nhà có trẻ nhỏ và sân vườn.',0,'2026-10-11 09:00:00'),
('pet_011','Mực',    'dog','Chó ta lai',          3.0,'Đực','medium','medium',1,0,1,1,1,'Trắng đen',   13.0,'Quận 12, TP.HCM',    'pets/dog_11.jpg','Mực được giải cứu từ lò mổ, giờ đã khỏe mạnh, rất biết ơn và quấn chủ.',0,'2026-10-12 09:00:00'),
('pet_012','Vàng',   'dog','Golden Retriever',    8.0,'Cái','large', 'low',   1,1,0,1,1,'Vàng',        28.0,'Hóc Môn, TP.HCM',    'pets/dog_12.jpg','Vàng đã lớn tuổi, điềm đạm, chỉ cần một góc ấm và người bầu bạn những năm cuối đời.',0,'2026-10-13 09:00:00'),
-- MÈO
('pet_013','Luna',   'cat','Mèo Anh lông ngắn',   1.0,'Cái','small', 'low',   1,1,1,1,1,'Xám mướp',    3.5,'Quận 1, TP.HCM',     'pets/cat_01.jpg','Luna hiền lành, thích được vuốt ve, hòa đồng tốt với trẻ em và thú nuôi khác.',1,'2026-10-02 10:00:00'),
('pet_014','Coco',   'cat','Mèo Ba Tư',           2.0,'Cái','small', 'low',   0,1,1,1,1,'Trắng kem',   4.0,'Quận 3, TP.HCM',     'pets/cat_02.jpg','Coco sang chảnh, điềm tĩnh, thích yên tĩnh. Cần chải lông thường xuyên.',0,'2026-10-03 10:00:00'),
('pet_015','Kitty',  'cat','Mèo Ragdoll',         1.0,'Cái','medium','low',   1,1,1,1,0,'Trắng xám',   4.5,'Quận 10, TP.HCM',    'pets/cat_03.jpg','Kitty mềm như bông, thích nằm trong lòng chủ, rất hợp gia đình có bé nhỏ.',1,'2026-10-04 10:00:00'),
('pet_016','Xám',    'cat','Scottish Fold',       3.0,'Đực','small', 'low',   1,1,1,1,1,'Xám tro',     5.0,'Bình Thạnh, TP.HCM', 'pets/cat_04.jpg','Xám tai cụp, "ngầu" nhưng cực kỳ tình cảm. Thích ngủ bên cửa sổ.',0,'2026-10-05 10:00:00'),
('pet_017','Gừng',   'cat','Maine Coon',          2.0,'Đực','large', 'medium',1,1,1,1,1,'Cam vằn',     7.5,'TP. Thủ Đức',        'pets/cat_05.jpg','Gừng là "gã khổng lồ hiền lành", thích chơi cần câu mèo và theo chủ khắp nhà.',1,'2026-10-06 10:00:00'),
('pet_018','Mật',    'cat','Mèo Anh lông dài vàng',0.5,'Cái','small','high',  1,1,1,1,0,'Vàng ánh kim', 2.0,'Phú Nhuận, TP.HCM',  'pets/cat_06.jpg','Mật mới 6 tháng, nghịch ngợm, mê đồ chơi. Cần người có thời gian chơi cùng.',0,'2026-10-07 10:00:00'),
('pet_019','Bướm',   'cat','Mèo lông dài lai',    4.0,'Cái','medium','low',   0,1,1,1,1,'Tam thể',     4.2,'Quận 5, TP.HCM',     'pets/cat_07.jpg','Bướm nhút nhát lúc đầu, cần thời gian làm quen, phù hợp nhà yên tĩnh không có trẻ nhỏ.',0,'2026-10-08 10:00:00'),
('pet_020','Mướp',   'cat','Mèo ta',              1.5,'Đực','small', 'high',  1,1,1,1,1,'Mướp trắng',  4.0,'Gò Vấp, TP.HCM',     'pets/cat_08.jpg','Mướp lúc nào cũng "cười", tinh nghịch và bắt chuột giỏi. Rất dễ nuôi.',1,'2026-10-09 10:00:00'),
('pet_021','Sọc',    'cat','Mèo ta',              2.0,'Đực','small', 'medium',1,1,1,1,1,'Mướp xám',    4.3,'Tân Phú, TP.HCM',    'pets/cat_09.jpg','Sọc điềm đạm, sạch sẽ, tự biết dùng khay cát. Hợp người đi làm cả ngày.',0,'2026-10-10 10:00:00'),
('pet_022','Mây',    'cat','Scottish Fold',       1.0,'Cái','small', 'medium',1,1,1,1,0,'Bạc mướp',    3.2,'Quận 7, TP.HCM',     'pets/cat_10.jpg','Mây hay trốn trong chăn, thích chơi trốn tìm với chủ. Đáng yêu vô cùng.',0,'2026-10-11 10:00:00'),
('pet_023','Bánh Bao','cat','Mèo Exotic',         3.0,'Đực','medium','low',   1,0,1,1,1,'Vàng trắng',  5.5,'Quận 4, TP.HCM',     'pets/cat_11.jpg','Bánh Bao mặt tịt, "khó ở" nhưng thật ra rất hiền. Thích làm thú cưng duy nhất.',0,'2026-10-12 10:00:00'),
('pet_024','Nghệ',   'cat','Mèo ta',              5.0,'Cái','small', 'low',   1,1,1,1,1,'Vàng cam',    4.0,'Nhà Bè, TP.HCM',     'pets/cat_12.jpg','Nghệ lớn tuổi, thích phơi nắng và ngủ. Một người bạn hoàn hảo cho người lớn tuổi.',0,'2026-10-13 10:00:00');

-- ---------------------------------------------------------------------
-- POSTS (8 bài: 6 đã duyệt, 1 chờ duyệt, 1 bị từ chối)
-- ---------------------------------------------------------------------
INSERT INTO posts (postId, userId, title, content, image, category, status, reject_reason, reviewed_by, reviewed_at, created_at) VALUES
('post_001','u_lananh','Hành trình nhận nuôi bé Milo 🐶',
 'Tháng trước mình nhận nuôi Milo từ PETOPIA và cuộc sống thay đổi hoàn toàn! Bé ngoan, thông minh, mỗi tối đều chờ mình ở cửa. Cảm ơn đội ngũ đã hỗ trợ suốt quá trình.',
 'posts/post_02.jpg','story','approved',NULL,'u_staff01','2026-10-28 11:00:00','2026-10-28 10:30:00'),
('post_002','u_hoangnam','5 mẹo chăm mèo con mới về nhà 🐱',
 '1) Tạo góc riêng yên tĩnh cho bé. 2) Cho ăn đúng giờ, chia nhiều bữa nhỏ. 3) Đừng bế quá nhiều những ngày đầu. 4) Đặt khay cát xa chỗ ăn. 5) Đưa bé đi khám & tẩy giun trong tuần đầu.',
 'posts/post_04.jpg','tips','approved',NULL,'u_staff01','2026-10-29 15:00:00','2026-10-29 14:00:00'),
('post_003','u_staff01','Chiến dịch cứu hộ chó mèo tháng 11 🐾',
 'PETOPIA đang phối hợp với các trạm cứu hộ để giải cứu hơn 50 bé bị bỏ rơi trước mùa mưa lạnh. Cần tình nguyện viên tạm nuôi và người nhận nuôi lâu dài. Hãy chia sẻ bài viết này!',
 'posts/post_01.jpg','rescue','approved',NULL,'u_admin','2026-10-30 09:05:00','2026-10-30 09:00:00'),
('post_004','u_thuha','Hỏi: Mèo con 2 tháng nên ăn hạt gì?',
 'Mình mới nhận một bé mèo ta 2 tháng tuổi. Nên cho ăn hạt loại nào, có cần ngâm mềm không, một ngày mấy bữa ạ? Cảm ơn mọi người!',
 NULL,'question','approved',NULL,'u_staff01','2026-10-30 20:30:00','2026-10-30 20:10:00'),
('post_005','u_minhduc','Bé Rex nhà mình sau 1 năm',
 'Một năm trước Rex gầy gò, sợ người. Giờ thì ngày nào cũng đòi đi chạy 5km 😂. Ai đang phân vân nhận nuôi Husky thì cứ hỏi mình nhé.',
 'posts/post_05.jpg','story','approved',NULL,'u_staff01','2026-10-31 08:20:00','2026-10-31 08:00:00'),
('post_006','u_lananh','Lịch tiêm phòng cơ bản cho chó con',
 '6–8 tuần: mũi 5 bệnh lần 1. 10–12 tuần: mũi 7 bệnh lần 2. 14–16 tuần: mũi 7 bệnh lần 3 + dại. Sau đó nhắc lại mỗi năm. Nhớ tẩy giun 2 tuần trước khi tiêm nhé!',
 'posts/post_03.jpg','tips','approved',NULL,'u_admin','2026-10-31 12:00:00','2026-10-31 11:30:00'),
('post_007','u_hoangnam','Tìm người tạm nuôi 3 bé mèo con ở Gò Vấp',
 'Mình nhặt được 3 bé mèo khoảng 1 tháng tuổi trong thùng giấy. Hiện không đủ điều kiện nuôi lâu dài, ai ở gần Gò Vấp có thể tạm nuôi 2 tuần không ạ?',
 'posts/post_06.jpg','rescue','pending',NULL,NULL,NULL,'2026-11-01 07:45:00'),
('post_008','u_minhduc','Bán chó Husky thuần chủng giá rẻ',
 'Cần bán gấp 2 bé Husky, liên hệ Zalo ...',
 NULL,'story','rejected','Petopia không cho phép mua bán thú cưng. Vui lòng chỉ chia sẻ câu chuyện hoặc kêu gọi nhận nuôi.','u_staff01','2026-11-01 08:10:00','2026-11-01 08:00:00');

-- ---------------------------------------------------------------------
-- COMMENTS (có phản hồi lồng: parentId)
-- ---------------------------------------------------------------------
INSERT INTO comments (commentId, postId, userId, parentId, text, created_at) VALUES
('c001','post_001','u_minhduc', NULL,  'Bé dễ thương quá! Chúc mừng bạn nhé 🎉',                         '2026-10-28 11:30:00'),
('c002','post_001','u_thuha',   NULL,  'Milo trông khỏe và vui lắm, bạn chăm tốt quá!',                  '2026-10-28 12:15:00'),
('c003','post_001','u_lananh',  'c002','Cảm ơn Hà nha, hôm nào dẫn bé đi cà phê chó mèo chung nhé 😄',    '2026-10-28 13:00:00'),
('c004','post_002','u_thuha',   NULL,  'Cảm ơn bạn đã chia sẻ, rất hữu ích cho người mới như mình!',      '2026-10-29 15:30:00'),
('c005','post_002','u_lananh',  NULL,  'Bổ sung: nên cho bé ăn pate xen kẽ để uống đủ nước nữa nha.',     '2026-10-29 16:10:00'),
('c006','post_002','u_hoangnam','c005','Đúng rồi, mèo ít uống nước nên pate rất cần thiết 👍',             '2026-10-29 16:40:00'),
('c007','post_003','u_lananh',  NULL,  'Mình đăng ký làm tình nguyện viên tạm nuôi được không ạ?',        '2026-10-30 09:30:00'),
('c008','post_003','u_staff01', 'c007','Được nhé Lan Anh! Bạn để lại SĐT qua tin nhắn, bên mình sẽ gọi.', '2026-10-30 10:00:00'),
('c009','post_003','u_minhduc', NULL,  'Đã chia sẻ! Mong các bé sớm có nhà.',                             '2026-10-30 10:20:00'),
('c010','post_004','u_lananh',  NULL,  'Bạn chọn hạt dành cho kitten, ngâm mềm 10 phút trong 2 tuần đầu.','2026-10-30 20:40:00'),
('c011','post_004','u_hoangnam',NULL,  'Ngày 4 bữa nhỏ nha, và luôn có nước sạch.',                       '2026-10-30 21:00:00'),
('c012','post_004','u_staff01', NULL,  'Nên đưa bé đi khám tổng quát và tẩy giun trước khi đổi thức ăn.','2026-10-30 21:15:00'),
('c013','post_004','u_thuha',   'c012','Dạ em cảm ơn chị, cuối tuần em đưa bé đi khám ạ.',                 '2026-10-30 21:30:00'),
('c014','post_005','u_thuha',   NULL,  'Husky chạy 5km mỗi ngày thật luôn hả 😱',                          '2026-10-31 08:30:00'),
('c015','post_005','u_minhduc', 'c014','Thật đó, không cho chạy là bé phá nhà liền 🤣',                    '2026-10-31 08:45:00'),
('c016','post_005','u_lananh',  NULL,  'Rex đẹp trai quá, khác hẳn hồi mới về.',                          '2026-10-31 09:10:00'),
('c017','post_006','u_minhduc', NULL,  'Lưu lại ngay, cảm ơn bạn!',                                        '2026-10-31 12:10:00'),
('c018','post_006','u_hoangnam',NULL,  'Mũi dại có cần tiêm nhắc mỗi năm không ạ?',                       '2026-10-31 12:30:00'),
('c019','post_006','u_staff01', 'c018','Có nhé, dại nhắc lại hằng năm theo khuyến cáo của thú y.',         '2026-10-31 13:00:00');

-- ---------------------------------------------------------------------
-- LIKES
-- ---------------------------------------------------------------------
INSERT INTO post_likes (postId, userId) VALUES
('post_001','u_minhduc'),('post_001','u_thuha'),('post_001','u_hoangnam'),('post_001','u_staff01'),
('post_002','u_thuha'),('post_002','u_lananh'),
('post_003','u_lananh'),('post_003','u_minhduc'),('post_003','u_thuha'),('post_003','u_hoangnam'),
('post_004','u_lananh'),
('post_005','u_lananh'),('post_005','u_thuha'),
('post_006','u_minhduc'),('post_006','u_hoangnam'),('post_006','u_thuha');

-- ---------------------------------------------------------------------
-- ADOPTIONS (3 chờ duyệt, 2 đã duyệt, 1 từ chối)
-- ---------------------------------------------------------------------
INSERT INTO adoptions (requestId, userId, petId, fullName, phone, email, address, housing_type, has_children, has_other_pets, experience, hours_alone, reason, status, admin_note, reviewed_by, reviewed_at, created_at) VALUES
('req_001','u_lananh',  'pet_009','Nguyễn Lan Anh','0912345678','lananh.nguyen@gmail.com','45 Lê Văn Sỹ, Phú Nhuận, TP.HCM','apartment',0,1,'experienced',4,
 'Mình đã nuôi chó 5 năm, nhà có 1 bé Poodle hiền, muốn tìm bạn cho bé.','approved','Đã gọi xác minh, chủ có kinh nghiệm. Hẹn nhận bé thứ 7.','u_staff01','2026-10-26 10:00:00','2026-10-25 09:00:00'),
('req_002','u_minhduc', 'pet_003','Trần Minh Đức','0987654321','minhduc.tran@gmail.com','12 Nguyễn Thị Thập, Quận 7, TP.HCM','house_with_yard',0,0,'some',6,
 'Nhà có sân rộng, mình chạy bộ mỗi sáng, muốn có bạn đồng hành.','approved','Nhà có sân, phù hợp giống Husky.','u_staff01','2026-10-20 15:00:00','2026-10-19 20:00:00'),
('req_003','u_thuha',   'pet_013','Phạm Thu Hà','0938111222','thuha.pham@gmail.com','88 Cách Mạng Tháng 8, Quận 3, TP.HCM','apartment',0,1,'some',8,
 'Mình ở chung cư, đã có 1 bé mèo ta, muốn nhận thêm Luna làm bạn.','pending',NULL,NULL,NULL,'2026-10-31 19:30:00'),
('req_004','u_hoangnam','pet_005','Lê Hoàng Nam','0909333444','hoangnam.le@gmail.com','27 Quang Trung, Gò Vấp, TP.HCM','house',1,0,'none',3,
 'Bố mẹ mình đã nghỉ hưu, ở nhà cả ngày, muốn có một bé hiền để bầu bạn.','pending',NULL,NULL,NULL,'2026-11-01 07:00:00'),
('req_005','u_lananh',  'pet_017','Nguyễn Lan Anh','0912345678','lananh.nguyen@gmail.com','45 Lê Văn Sỹ, Phú Nhuận, TP.HCM','apartment',0,1,'experienced',4,
 'Rất thích mèo Maine Coon, nhà có ban công lưới an toàn.','pending',NULL,NULL,NULL,'2026-11-01 08:15:00'),
('req_006','u_thuha',   'pet_002','Phạm Thu Hà','0938111222','thuha.pham@gmail.com','88 Cách Mạng Tháng 8, Quận 3, TP.HCM','apartment',0,1,'some',10,
 'Mình rất thích Golden.','rejected','Golden cần không gian rộng và vận động nhiều; căn hộ nhỏ + vắng nhà 10 tiếng/ngày chưa phù hợp. Gợi ý bạn xem bé Bơ hoặc Mập.','u_staff01','2026-10-22 09:00:00','2026-10-21 22:00:00');

-- Bé đã được duyệt nhận nuôi -> cập nhật trạng thái
UPDATE pets SET status = 'adopted' WHERE id IN ('pet_009','pet_003');
UPDATE pets SET status = 'pending' WHERE id IN ('pet_013','pet_005','pet_017');
