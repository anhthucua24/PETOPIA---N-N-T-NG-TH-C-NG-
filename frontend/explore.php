<!DOCTYPE html>
<!-- [UI] Trang Khám phá -->
<html lang="vi">
<head>
  <meta charset="UTF-8"/><meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Petopia – Khám phá thú cưng</title>
  <link rel="stylesheet" href="css/base.css"/>
  <link rel="stylesheet" href="css/components.css"/>
  <link rel="stylesheet" href="css/pages.css"/>
</head>
<body>
<nav class="nav">
  <a class="nav-brand" href="index.php"><span class="dot"></span>petopia</a>
  <ul class="nav-links">
    <li><a href="index.php">Trang chủ</a></li>
    <li><a href="explore.php" class="active">Khám phá</a></li>
    <li><a href="adopt.php">Nhận nuôi</a></li>
    <li><a href="community.php">Cộng đồng</a></li>
    <li><a href="login.php" class="nav-admin">Quản trị</a></li>
  </ul>
</nav>

<section class="sec">
  <div class="sec-label">Danh sách</div>
  <h1 class="sec-title">Khám phá thú cưng</h1>
  <p class="sec-sub">Tìm kiếm người bạn bốn chân phù hợp với gia đình bạn.</p>

  <div class="filter-bar">
    <div class="fg" style="flex:2">
      <label>Tìm theo tên</label>
      <input type="text" id="sName" placeholder="Nhập tên..." oninput="doFilter()"/>
    </div>
    <div class="fg">
      <label>Loài</label>
      <select id="sSpecies" onchange="doFilter()">
        <option value="">Tất cả</option>
        <option value="dog">Chó</option>
        <option value="cat">Mèo</option>
      </select>
    </div>
    <div class="fg">
      <label>Độ tuổi</label>
      <select id="sAge" onchange="doFilter()">
        <option value="">Tất cả</option>
        <option value="0-1">Dưới 1 tuổi</option>
        <option value="1-3">1–3 tuổi</option>
        <option value="3-99">Từ 3 tuổi</option>
      </select>
    </div>
    <div class="fg">
      <label>Giới tính</label>
      <select id="sGender" onchange="doFilter()">
        <option value="">Tất cả</option>
        <option value="Đực">Đực</option>
        <option value="Cái">Cái</option>
      </select>
    </div>
    <div class="fg">
      <label>Kích thước</label>
      <select id="sSize" onchange="doFilter()">
        <option value="">Tất cả</option>
        <option value="small">Nhỏ</option>
        <option value="medium">Vừa</option>
        <option value="large">Lớn</option>
      </select>
    </div>
    <div class="fg">
      <label>Tính cách</label>
      <select id="sEnergy" onchange="doFilter()">
        <option value="">Tất cả</option>
        <option value="low">Điềm tĩnh</option>
        <option value="medium">Vừa phải</option>
        <option value="high">Năng động</option>
      </select>
    </div>
    <button class="btn btn-ghost btn-sm" id="btnReset" onclick="resetF()">Đặt lại</button>
  </div>
  <div class="need-chips-sm" id="needChips"></div>

  <p id="rCount" style="font-size:.8rem;color:var(--warm-gray);font-weight:600;margin-bottom:1rem"></p>
  <div class="pet-grid" id="petGrid"><div style="padding:2rem;text-align:center;color:var(--warm-gray)">Đang tải...</div></div>
</section>

<!-- DETAIL MODAL -->
<div class="overlay" id="petModal">
  <div class="modal" style="max-width:500px">
    <div class="modal-hd">
      <span class="modal-hd-title" id="mName">Chi tiết</span>
      <button class="modal-x" onclick="closeModal('petModal')">
        <i data-gi="x"></i>
      </button>
    </div>
    <div class="modal-bd">
      <img id="mImg" src="" alt=""/>
      <div id="mInfo"></div>
    </div>
    <div class="modal-ft">
      <button class="btn btn-primary btn-sm" id="mAdoptBtn">Đăng ký nhận nuôi</button>
      <button class="btn btn-ghost btn-sm" onclick="closeModal('petModal')">Đóng</button>
    </div>
  </div>
</div>

<footer class="footer">
  <span class="footer-brand">petopia</span>
  <span>© 2026 Petopia. Kết nối trái tim – Trao yêu thương.</span>
</footer>

<script src="js/ui/icons.js"></script>
<script src="js/core/api.js"></script>
<script src="js/ui/components.js"></script>
<script src="js/pages/explore.js"></script>
</body>
</html>
