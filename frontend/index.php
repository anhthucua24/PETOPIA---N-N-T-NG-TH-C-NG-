<!DOCTYPE html>
<!-- [UI] Trang chủ -->
<html lang="vi">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Petopia – Nhận nuôi thú cưng</title>
  <meta name="description" content="Petopia – kết nối thú cưng cần mái ấm với những gia đình yêu thương tại Việt Nam."/>
  <link rel="stylesheet" href="css/base.css"/>
  <link rel="stylesheet" href="css/components.css"/>
  <link rel="stylesheet" href="css/pages.css"/>
</head>
<body>

<nav class="nav">
  <a class="nav-brand" href="index.php">
    <span class="dot"></span>petopia
  </a>
  <ul class="nav-links">
    <li><a href="index.php" class="active">Trang chủ</a></li>
    <li><a href="explore.php">Khám phá</a></li>
    <li><a href="adopt.php">Nhận nuôi</a></li>
    <li><a href="community.php">Cộng đồng</a></li>
    <li><a href="login.php" class="nav-admin">Quản trị</a></li>
  </ul>
</nav>

<!-- HERO -->
<div class="hero">
  <div class="hero-left">
    <div class="hero-eyebrow"><span></span>Nền tảng nhận nuôi thú cưng</div>
    <h1>Tìm thấy yêu thương,<br/><em>trao đi mái nhà</em></h1>
    <p class="hero-desc">Hàng trăm chú chó mèo đang chờ một gia đình thực sự. Petopia giúp bạn tìm và kết nối với các bé một cách minh bạch, có trách nhiệm.</p>
    <div class="hero-cta">
      <a href="explore.php" class="btn btn-primary">Tìm thú cưng</a>
      <a href="adopt.php" class="btn btn-outline">Đăng ký nhận nuôi</a>
    </div>
    <div class="hero-nums">
      <div class="hn"><div class="n" id="stat-total">–</div><div class="l">đang chờ nhận nuôi</div></div>
      <div class="hn"><div class="n">120+</div><div class="l">đã tìm được nhà</div></div>
      <div class="hn"><div class="n">500+</div><div class="l">thành viên cộng đồng</div></div>
    </div>
  </div>
  <div class="hero-right">
    <div class="hero-photo">
      <img src="http://localhost:8080/img.php?f=pets/dog_01.jpg" alt="Chó Poodle đáng yêu"/>
    </div>
    <div class="hero-photo">
      <img src="http://localhost:8080/img.php?f=pets/cat_01.jpg" alt="Mèo Anh lông ngắn"/>
    </div>
  </div>
</div>

<!-- MATCH BY NEED -->
<section class="sec" id="match">
  <div class="sec-label">Gợi ý theo nhu cầu</div>
  <div style="display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:1.5rem;flex-wrap:wrap;gap:1rem">
    <div>
      <h2 class="sec-title" id="matchTitle">Thú cưng đang chờ bạn</h2>
      <div class="sec-sub" style="margin:0">Chọn hoàn cảnh của bạn – Petopia gợi ý những bé phù hợp nhất. Có thể chọn nhiều mục.</div>
    </div>
    <a href="explore.php" class="btn btn-outline btn-sm" id="seeAll">Xem tất cả</a>
  </div>
  <div class="need-grid" id="needGrid"></div>
  <div class="cat-tabs" id="speciesTabs">
    <button class="cat-tab on" data-sp="">Tất cả</button>
    <button class="cat-tab" data-sp="dog">Chó</button>
    <button class="cat-tab" data-sp="cat">Mèo</button>
  </div>
  <p id="matchCount" style="font-size:.82rem;color:var(--warm-gray);font-weight:600;margin-bottom:1rem"></p>
  <div class="pet-grid" id="featuredPets">
    <div style="padding:2rem;text-align:center;color:var(--warm-gray)">Đang tải...</div>
  </div>
</section>

<!-- PET DETAIL -->
<div class="overlay" id="petModal">
  <div class="modal" style="max-width:520px">
    <div class="modal-hd">
      <span class="modal-hd-title" id="mName">Chi tiết</span>
      <button class="modal-x" onclick="closeModal('petModal')"><i data-gi="x"></i></button>
    </div>
    <div class="modal-bd"><img id="mImg" src="" alt=""/><div id="mInfo"></div></div>
    <div class="modal-ft">
      <button class="btn btn-ghost btn-sm" onclick="closeModal('petModal')">Đóng</button>
      <button class="btn btn-primary btn-sm" id="mAdoptBtn">Đăng ký nhận nuôi</button>
    </div>
  </div>
</div>

<!-- CAMPAIGNS -->
<section class="sec">
  <div class="sec-label">Hoạt động</div>
  <div style="display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:1.5rem;flex-wrap:wrap;gap:1rem">
    <div>
      <div class="sec-title">Chiến dịch cứu hộ</div>
      <div class="sec-sub" style="margin:0">Petopia phối hợp cùng các trạm cứu hộ để bảo vệ động vật.</div>
    </div>
  </div>
  <div class="campaign-row">
    <div class="campaign-item">
      <img class="campaign-img" src="https://images.unsplash.com/photo-1601758125946-6ec2ef64daf8?w=600&q=80" alt="Cứu hộ tháng 11"/>
      <div class="campaign-body">
        <div class="c-tag live">Đang diễn ra</div>
        <div class="c-name">Cứu hộ tháng 11 – TP.HCM</div>
        <p class="c-desc">Giải cứu hơn 50 bé bị bỏ rơi trước mùa mưa lạnh, cần người nhận nuôi ngay.</p>
      </div>
    </div>
    <div class="campaign-item">
      <img class="campaign-img" src="https://images.unsplash.com/photo-1548199973-03cce0bbc87b?w=600&q=80" alt="Tiêm phòng miễn phí"/>
      <div class="campaign-body">
        <div class="c-tag upcoming">Sắp diễn ra</div>
        <div class="c-name">Tiêm phòng miễn phí – Tháng 12</div>
        <p class="c-desc">Vắc-xin dại miễn phí cho thú cưng tại 5 điểm ở TP.HCM và Hà Nội.</p>
      </div>
    </div>
    <div class="campaign-item">
      <img class="campaign-img" src="https://images.unsplash.com/photo-1450778869180-41d0601e046e?w=600&q=80" alt="Mùa đông ấm áp"/>
      <div class="campaign-body">
        <div class="c-tag special">Sự kiện đặc biệt</div>
        <div class="c-name">Nhận nuôi mùa đông ấm áp</div>
        <p class="c-desc">Mang về nhà một người bạn nhỏ để cùng chia sẻ hơi ấm mùa đông năm nay.</p>
      </div>
    </div>
  </div>
</section>

<!-- ABOUT -->
<div class="about-block">
  <div class="about-left">
    <div class="sec-label">Về chúng tôi</div>
    <div class="sec-title" style="color:var(--white)">Tại sao chọn <span style="color:var(--orange-2)">Petopia?</span></div>
    <p style="margin-top:1rem">Chúng tôi là cầu nối giúp những chú chó mèo cần yêu thương tìm được gia đình phù hợp. Minh bạch, có trách nhiệm và luôn đặt sức khoẻ thú cưng lên hàng đầu.</p>
    <a href="adopt.php" class="btn btn-primary" style="margin-top:1.5rem">Bắt đầu ngay</a>
  </div>
  <div class="about-right">
    <div class="feat-list">
      <div class="feat-item">
        <div class="feat-icon">
          <i data-gi="shield"></i>
        </div>
        <div class="feat-text"><h4>Kiểm tra sức khoẻ</h4><p>Mỗi bé được thú y kiểm tra trước khi nhận nuôi</p></div>
      </div>
      <div class="feat-item">
        <div class="feat-icon">
          <i data-gi="checkCircle"></i>
        </div>
        <div class="feat-text"><h4>Tiêm phòng đầy đủ</h4><p>Hồ sơ y tế và vắc-xin được lưu đầy đủ</p></div>
      </div>
      <div class="feat-item">
        <div class="feat-icon">
          <i data-gi="team"></i>
        </div>
        <div class="feat-text"><h4>Hỗ trợ sau nhận nuôi</h4><p>Tư vấn chăm sóc thú cưng lâu dài</p></div>
      </div>
      <div class="feat-item">
        <div class="feat-icon">
          <i data-gi="smile"></i>
        </div>
        <div class="feat-text"><h4>Cộng đồng yêu thú cưng</h4><p>Chia sẻ và học hỏi từ hàng trăm người nuôi</p></div>
      </div>
    </div>
  </div>
</div>

<footer class="footer">
  <span class="footer-brand">petopia</span>
  <span>© 2026 Petopia. Kết nối trái tim – Trao yêu thương.</span>
  <a href="admin.php" style="color:rgba(255,255,255,.3);font-size:.75rem">Quản trị</a>
</footer>

<script src="js/ui/icons.js"></script>
<script src="js/core/api.js"></script>
<script src="js/ui/components.js"></script>
<script src="js/pages/home.js"></script>
</body>
</html>
