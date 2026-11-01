<!DOCTYPE html>
<!-- [UI] Trang Nhận nuôi -->
<html lang="vi">
<head>
  <meta charset="UTF-8"/><meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Petopia – Đăng ký nhận nuôi</title>
  <meta name="description" content="Đăng ký nhận nuôi chó mèo tại Petopia."/>
  <link rel="stylesheet" href="css/base.css"/>
  <link rel="stylesheet" href="css/components.css"/>
  <link rel="stylesheet" href="css/pages.css"/>
</head>
<body>
<nav class="nav">
  <a class="nav-brand" href="index.php"><span class="dot"></span>petopia</a>
  <ul class="nav-links">
    <li><a href="index.php">Trang chủ</a></li>
    <li><a href="explore.php">Khám phá</a></li>
    <li><a href="adopt.php" class="active">Nhận nuôi</a></li>
    <li><a href="community.php">Cộng đồng</a></li>
    <li><a href="login.php" class="nav-admin">Quản trị</a></li>
  </ul>
</nav>

<div class="adopt-strip">
  <div class="adopt-strip-left">
    <div class="sec-label">Nhận nuôi</div>
    <h1>Trao một mái nhà, nhận lại cả một người bạn.</h1>
    <p>Điền thông tin bên dưới. Tình nguyện viên Petopia sẽ gọi lại cho bạn trong vòng 24 giờ để trao đổi thêm.</p>
  </div>
  <div class="adopt-steps">
    <div class="sec-label">Quy trình</div>
    <div class="step-list">
      <div class="step-row"><div class="step-num">1</div><div><b>Chọn bé</b><small>Xem danh sách ở trang Khám phá</small></div></div>
      <div class="step-row"><div class="step-num">2</div><div><b>Điền đơn</b><small>Thông tin liên hệ và lý do nhận nuôi</small></div></div>
      <div class="step-row"><div class="step-num">3</div><div><b>Chờ duyệt</b><small>Admin xem xét và liên hệ lại</small></div></div>
    </div>
  </div>
</div>

<section class="adopt-form-sec">
  <div id="successBanner" class="notice ok" style="display:none">Đã gửi đơn thành công! Chúng tôi sẽ liên hệ bạn sớm.</div>

  <div class="adopt-form-card" id="loginCard" style="display:none;text-align:center">
    <h2>Bạn cần đăng nhập</h2>
    <p>Để Petopia liên hệ và theo dõi đơn, vui lòng đăng nhập hoặc tạo tài khoản miễn phí.</p>
    <div style="display:flex;gap:10px;justify-content:center;flex-wrap:wrap">
      <a class="btn btn-primary" id="goLogin" href="login.php">Đăng nhập</a>
      <a class="btn btn-outline" href="register.php">Tạo tài khoản</a>
    </div>
  </div>

  <div class="adopt-form-card" id="formCard" style="display:none">
    <h2>Đơn đăng ký nhận nuôi</h2>
    <p>Các mục có dấu * là bắt buộc. Câu trả lời của bạn giúp chúng tôi chọn đúng bé cho đúng nhà.</p>
    <form id="adoptForm">
      <div class="fg2">
        <label for="petSelect">Thú cưng muốn nhận nuôi<span class="req">*</span></label>
        <select id="petSelect" name="petId" required><option value="">-- Chọn thú cưng --</option></select>
      </div>
      <div class="f2">
        <div class="fg2"><label for="afName">Họ và tên<span class="req">*</span></label><input type="text" id="afName" name="fullName" placeholder="Nguyễn Văn A" required/></div>
        <div class="fg2"><label for="afPhone">Số điện thoại<span class="req">*</span></label><input type="tel" id="afPhone" name="phone" placeholder="09xxxxxxxx" pattern="0[0-9]{9,10}" required/></div>
      </div>
      <div class="fg2"><label for="afEmail">Email</label><input type="email" id="afEmail" name="email" placeholder="email@gmail.com"/></div>
      <div class="fg2"><label for="afAddress">Địa chỉ<span class="req">*</span></label><input type="text" id="afAddress" name="address" placeholder="Số nhà, đường, quận, thành phố" required/></div>
      <div class="f3">
        <div class="fg2"><label for="afHousing">Loại nhà ở</label>
          <select id="afHousing" name="housing_type"><option value="apartment">Chung cư / căn hộ</option><option value="house">Nhà phố</option><option value="house_with_yard">Nhà có sân vườn</option></select></div>
        <div class="fg2"><label for="afExp">Kinh nghiệm nuôi</label>
          <select id="afExp" name="experience"><option value="none">Chưa từng nuôi</option><option value="some">Đã từng nuôi</option><option value="experienced">Nhiều kinh nghiệm</option></select></div>
        <div class="fg2"><label for="afHours">Bé ở nhà một mình (giờ/ngày)</label><input type="number" id="afHours" name="hours_alone" min="0" max="24" placeholder="vd: 6"/></div>
      </div>
      <div class="fg2"><label>Hoàn cảnh gia đình</label>
        <div class="checks">
          <label><input type="checkbox" name="has_children" value="1" id="afKids"/> Nhà có trẻ nhỏ</label>
          <label><input type="checkbox" name="has_other_pets" value="1" id="afPets"/> Đang nuôi thú cưng khác</label>
        </div></div>
      <div class="fg2"><label for="afReason">Lý do muốn nhận nuôi</label><textarea id="afReason" name="reason" rows="4" placeholder="Kể một chút về bạn và nơi bé sẽ sống..."></textarea></div>
      <button type="submit" id="adoptSubmit" class="btn btn-primary" style="width:100%;justify-content:center;padding:13px">Gửi đơn đăng ký</button>
    </form>
  </div>

  <div id="myAdoptions" style="margin-top:2rem"></div>
</section>

<footer class="footer">
  <span class="footer-brand">petopia</span>
  <span>© 2026 Petopia. Kết nối trái tim – Trao yêu thương.</span>
</footer>

<script src="js/ui/icons.js"></script>
<script src="js/core/api.js"></script>
<script src="js/ui/components.js"></script>
<script src="js/pages/adopt.js"></script>
</body>
</html>
