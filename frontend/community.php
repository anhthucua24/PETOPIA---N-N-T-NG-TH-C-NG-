<!DOCTYPE html>
<!-- [UI] Trang Cộng đồng -->
<html lang="vi">
<head>
  <meta charset="UTF-8"/><meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Petopia – Cộng đồng</title>
  <meta name="description" content="Cộng đồng Petopia – chia sẻ câu chuyện, mẹo chăm sóc, hỏi đáp và kêu gọi cứu hộ thú cưng."/>
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
    <li><a href="adopt.php">Nhận nuôi</a></li>
    <li><a href="community.php" class="active">Cộng đồng</a></li>
    <li><a href="login.php" class="nav-admin">Quản trị</a></li>
  </ul>
</nav>

<section class="sec">
  <div class="posts">
    <div class="sec-label">Cộng đồng</div>
    <div style="display:flex;justify-content:space-between;align-items:flex-end;gap:1rem;flex-wrap:wrap;margin-bottom:1.5rem">
      <div>
        <h1 class="sec-title">Góc chia sẻ</h1>
        <p class="sec-sub" style="margin-bottom:0">Kể chuyện về bé nhà bạn, hỏi kinh nghiệm, hoặc kêu gọi cứu hộ.</p>
      </div>
      <button class="btn btn-dark" id="btnNewPost" onclick="openNewPost()">+ Viết bài</button>
    </div>
    <div class="cat-tabs" id="catTabs"></div>
    <div id="myPosts"></div>
    <div id="postList"><div class="empty">Đang tải...</div></div>
  </div>
</section>

<div class="overlay" id="newPostModal">
  <div class="modal">
    <div class="modal-hd">
      <span class="modal-hd-title">Bài viết mới</span>
      <button class="modal-x" onclick="closeModal('newPostModal')"><i data-gi="x"></i></button>
    </div>
    <form id="newPostForm">
      <div class="modal-bd">
        <div class="notice wait" id="reviewNote">Bài viết sẽ được nhân viên Petopia duyệt trước khi hiển thị.</div>
        <div class="fg2"><label for="npCat">Chuyên mục</label>
          <select id="npCat" name="category"><option value="story">Câu chuyện</option><option value="tips">Mẹo chăm sóc</option><option value="question">Hỏi đáp</option><option value="rescue">Cứu hộ</option></select></div>
        <div class="fg2"><label for="npTitle">Tiêu đề<span class="req">*</span></label><input type="text" id="npTitle" name="title" maxlength="255" placeholder="Hôm nay bé nhà mình..." required/></div>
        <div class="fg2"><label for="npContent">Nội dung<span class="req">*</span></label><textarea id="npContent" name="content" rows="5" required></textarea></div>
        <div class="fg2"><label>Ảnh (tùy chọn)</label>
          <label class="upload-box" for="npImage"><img id="npPreview" src="https://placehold.co/72x72/EEE8DE/7A7067?text=+" alt=""/><span id="npImgName">Bấm để chọn ảnh từ máy (JPG, PNG, WEBP – tối đa 5MB)</span>
            <input type="file" id="npImage" name="image_file" accept="image/*"/></label></div>
      </div>
      <div class="modal-ft">
        <button type="button" class="btn btn-ghost btn-sm" onclick="closeModal('newPostModal')">Huỷ</button>
        <button type="submit" class="btn btn-primary btn-sm" id="npSubmit">Gửi bài</button>
      </div>
    </form>
  </div>
</div>

<footer class="footer">
  <span class="footer-brand">petopia</span>
  <span>© 2026 Petopia. Kết nối trái tim – Trao yêu thương.</span>
</footer>

<script src="js/ui/icons.js"></script>
<script src="js/core/api.js"></script>
<script src="js/ui/components.js"></script>
<script src="js/pages/community.js"></script>
</body>
</html>
