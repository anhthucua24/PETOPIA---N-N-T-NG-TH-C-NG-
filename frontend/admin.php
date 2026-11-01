<!DOCTYPE html>
<!-- [UI] Trang Quản trị -->
<html lang="vi">
<head>
  <meta charset="UTF-8"/><meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Petopia – Quản trị</title>
  <link rel="stylesheet" href="css/base.css"/>
  <link rel="stylesheet" href="css/components.css"/>
  <link rel="stylesheet" href="css/pages.css"/>
</head>
<body>
<div class="admin-wrap">
  <aside class="aside">
    <div class="aside-brand"><span class="dot"></span>petopia</div>
    <div class="aside-sec-lbl">Tổng quan</div>
    <button class="aside-item active" data-tab="stats" onclick="showTab('stats')">
      <i data-gi="dashboard"></i>Bảng điều khiển</button>
    <div class="aside-sec-lbl">Quản lý</div>
    <button class="aside-item" data-tab="pets" onclick="showTab('pets')">
      <i data-gi="paw"></i>Thú cưng</button>
    <button class="aside-item" data-tab="adoptions" onclick="showTab('adoptions')">
      <i data-gi="file"></i>Duyệt đơn nhận nuôi<span class="badge" id="b-pending">0</span></button>
    <button class="aside-item" data-tab="posts" onclick="showTab('posts')">
      <i data-gi="chat"></i>Duyệt bài viết<span class="badge" id="b-posts">0</span></button>
    <button class="aside-item" data-tab="users" onclick="showTab('users')" id="navUsers" style="display:none">
      <i data-gi="users"></i>Tài khoản</button>
    <div class="aside-bottom">
      <a href="index.php" class="aside-item" style="padding-left:0">Xem website</a>
      <button class="aside-item" style="padding-left:0" onclick="logout()">Đăng xuất</button>
    </div>
  </aside>

  <main class="admin-content">
    <!-- STATS -->
    <section id="tab-stats">
      <div class="admin-header"><div><h1 class="admin-title">Bảng điều khiển</h1><p class="admin-sub" id="hello">Xin chào.</p></div></div>
      <div class="stats-row">
        <div class="stat-card green"><div class="num" id="s-pets">–</div><div class="lbl">Thú cưng đang chờ nhà</div></div>
        <div class="stat-card orange"><div class="num" id="s-pending">–</div><div class="lbl">Đơn chờ duyệt</div></div>
        <div class="stat-card"><div class="num" id="s-approved">–</div><div class="lbl">Bé đã có nhà</div></div>
        <div class="stat-card purple"><div class="num" id="s-posts">–</div><div class="lbl">Bài chờ duyệt</div></div>
      </div>
      <div class="tbl-wrap">
        <div class="tbl-head"><span class="tbl-head-title">Đơn mới nhất</span><button class="btn btn-ghost btn-sm" onclick="showTab('adoptions')">Xem tất cả</button></div>
        <table><thead><tr><th>Người đăng ký</th><th>Thú cưng</th><th>SĐT</th><th>Trạng thái</th></tr></thead><tbody id="recentBody"></tbody></table>
      </div>
    </section>

    <!-- PETS -->
    <section id="tab-pets" style="display:none">
      <div class="admin-header"><div><h1 class="admin-title">Thú cưng</h1><p class="admin-sub">Thêm, sửa, xoá hồ sơ – ảnh được lưu vào thư mục <code>images/pets</code>.</p></div>
        <button class="btn btn-primary btn-sm" id="btnAddPet" onclick="openPetForm()">+ Thêm thú cưng</button></div>
      <div class="tbl-wrap"><table>
        <thead><tr><th>Ảnh</th><th>Tên</th><th>Loài / Giống</th><th>Tuổi</th><th>Kích thước</th><th>Tính cách</th><th>Trạng thái</th><th></th></tr></thead>
        <tbody id="petsBody"></tbody></table></div>
    </section>

    <!-- ADOPTIONS -->
    <section id="tab-adoptions" style="display:none">
      <div class="admin-header"><div><h1 class="admin-title">Duyệt đơn nhận nuôi</h1><p class="admin-sub">Xem khảo sát của người đăng ký, duyệt hoặc từ chối kèm ghi chú.</p></div>
        <div class="adm-filter" id="adoptFilter"></div></div>
      <div class="tbl-wrap"><table>
        <thead><tr><th>Người đăng ký</th><th>Thú cưng</th><th>Khảo sát</th><th>Lý do</th><th>Ngày gửi</th><th>Trạng thái</th><th></th></tr></thead>
        <tbody id="adoptBody"></tbody></table></div>
    </section>

    <!-- POSTS -->
    <section id="tab-posts" style="display:none">
      <div class="admin-header"><div><h1 class="admin-title">Duyệt bài viết</h1><p class="admin-sub">Bài của thành viên chỉ hiển thị ở Cộng đồng sau khi được duyệt.</p></div>
        <div class="adm-filter" id="postFilter"></div></div>
      <div class="tbl-wrap"><table>
        <thead><tr><th>Ảnh</th><th>Bài viết</th><th>Tác giả</th><th>Chuyên mục</th><th>Ngày đăng</th><th>Trạng thái</th><th></th></tr></thead>
        <tbody id="postsBody"></tbody></table></div>
    </section>

    <!-- USERS (admin) -->
    <section id="tab-users" style="display:none">
      <div class="admin-header"><div><h1 class="admin-title">Tài khoản</h1><p class="admin-sub">Chỉ Admin: phân quyền nhân viên, khoá / mở tài khoản.</p></div></div>
      <div class="tbl-wrap"><table>
        <thead><tr><th>Tài khoản</th><th>Gmail</th><th>Vai trò</th><th>Bài / Đơn</th><th>Ngày tạo</th><th>Trạng thái</th><th></th></tr></thead>
        <tbody id="usersBody"></tbody></table></div>
    </section>
  </main>
</div>

<!-- PET FORM -->
<div class="overlay" id="petFormModal">
  <div class="modal" style="max-width:680px">
    <div class="modal-hd">
      <span class="modal-hd-title" id="petFormTitle">Thêm thú cưng</span>
      <button class="modal-x" onclick="closeModal('petFormModal')"><i data-gi="x"></i></button>
    </div>
    <div class="modal-bd">
      <form id="petForm">
        <input type="hidden" name="id" id="pf-id"/>
        <div class="fg2"><label>Ảnh<span class="req">*</span></label>
          <label class="upload-box" for="pf-file"><img id="pf-preview" src="https://placehold.co/72x72/EEE8DE/7A7067?text=+" alt=""/>
            <span id="pf-fname">Bấm để chọn ảnh từ máy (tối đa 5MB)</span><input type="file" id="pf-file" name="photo_file" accept="image/*"/></label></div>
        <div class="f3">
          <div class="fg2"><label>Tên<span class="req">*</span></label><input type="text" name="name" id="pf-name" required/></div>
          <div class="fg2"><label>Loài</label><select name="species" id="pf-species"><option value="dog">Chó</option><option value="cat">Mèo</option></select></div>
          <div class="fg2"><label>Giống</label><input type="text" name="breed" id="pf-breed"/></div>
        </div>
        <div class="f3">
          <div class="fg2"><label>Tuổi (năm)</label><input type="number" name="age" id="pf-age" min="0" max="25" step="0.5" value="1"/></div>
          <div class="fg2"><label>Giới tính</label><select name="gender" id="pf-gender"><option value="Đực">Đực</option><option value="Cái">Cái</option></select></div>
          <div class="fg2"><label>Cân nặng (kg)</label><input type="number" name="weight_kg" id="pf-weight_kg" min="0" step="0.1"/></div>
        </div>
        <div class="f3">
          <div class="fg2"><label>Kích thước</label><select name="size" id="pf-size"><option value="small">Nhỏ</option><option value="medium" selected>Vừa</option><option value="large">Lớn</option></select></div>
          <div class="fg2"><label>Tính cách</label><select name="energy" id="pf-energy"><option value="low">Điềm tĩnh</option><option value="medium" selected>Vừa phải</option><option value="high">Năng động</option></select></div>
          <div class="fg2"><label>Trạng thái</label><select name="status" id="pf-status"><option value="available">Sẵn sàng</option><option value="pending">Đang có người đăng ký</option><option value="adopted">Đã có nhà</option></select></div>
        </div>
        <div class="f2">
          <div class="fg2"><label>Màu lông</label><input type="text" name="color" id="pf-color"/></div>
          <div class="fg2"><label>Khu vực</label><input type="text" name="location" id="pf-location" placeholder="Quận 3, TP.HCM"/></div>
        </div>
        <div class="fg2"><label>Đặc điểm (dùng cho lọc theo nhu cầu)</label>
          <div class="checks">
            <label><input type="checkbox" name="good_with_kids" value="1" id="pf-good_with_kids" checked/> Hợp trẻ nhỏ</label>
            <label><input type="checkbox" name="good_with_pets" value="1" id="pf-good_with_pets" checked/> Hợp thú khác</label>
            <label><input type="checkbox" name="apartment_friendly" value="1" id="pf-apartment_friendly" checked/> Nuôi được ở chung cư</label>
            <label><input type="checkbox" name="vaccinated" value="1" id="pf-vaccinated" checked/> Đã tiêm phòng</label>
            <label><input type="checkbox" name="neutered" value="1" id="pf-neutered"/> Đã triệt sản</label>
            <label><input type="checkbox" name="featured" value="1" id="pf-featured"/> Nổi bật ở trang chủ</label>
          </div></div>
        <div class="fg2"><label>Mô tả</label><textarea name="description" id="pf-description" rows="3"></textarea></div>
      </form>
    </div>
    <div class="modal-ft">
      <button class="btn btn-ghost btn-sm" onclick="closeModal('petFormModal')">Huỷ</button>
      <button class="btn btn-primary btn-sm" id="btnSavePet" onclick="savePet()">Lưu</button>
    </div>
  </div>
</div>

<!-- REVIEW (duyệt / từ chối) -->
<div class="overlay" id="reviewModal">
  <div class="modal" style="max-width:480px">
    <div class="modal-hd"><span class="modal-hd-title" id="rvTitle">Duyệt</span>
      <button class="modal-x" onclick="closeModal('reviewModal')"><i data-gi="x"></i></button></div>
    <div class="modal-bd">
      <div id="rvInfo" style="font-size:.88rem;color:var(--mid);margin-bottom:1rem"></div>
      <div class="fg2"><label for="rvNote" id="rvLabel">Ghi chú</label><textarea id="rvNote" rows="3"></textarea></div>
    </div>
    <div class="modal-ft">
      <button class="btn btn-ghost btn-sm" onclick="closeModal('reviewModal')">Huỷ</button>
      <button class="btn btn-sm" id="rvSubmit">Xác nhận</button>
    </div>
  </div>
</div>

<script src="js/ui/icons.js"></script>
<script src="js/core/api.js"></script>
<script src="js/ui/components.js"></script>
<script src="js/pages/admin.js"></script>
</body>
</html>
// D:\xampp\php\php.exe -S localhost:8000 -t frontend frontend/router.php
