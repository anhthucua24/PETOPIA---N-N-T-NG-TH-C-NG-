<!DOCTYPE html>
<!-- [UI] Trang Đăng nhập -->
<html lang="vi">
<head>
  <meta charset="UTF-8"/><meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Petopia – Đăng nhập</title>
  <meta name="description" content="Đăng nhập Petopia để nhận nuôi thú cưng, đăng bài và bình luận trong cộng đồng."/>
  <link rel="stylesheet" href="css/base.css"/>
  <link rel="stylesheet" href="css/components.css"/>
  <link rel="stylesheet" href="css/pages.css"/>
</head>
<body>
<main class="login-page">
  <div class="login-left">
    <div class="ll-tag">Chào mừng trở lại</div>
    <h2>Mỗi hồ sơ là<br/>một <span>cơ hội</span><br/>được về nhà.</h2>
    <p>Đăng nhập để gửi đơn nhận nuôi, chia sẻ câu chuyện và trò chuyện cùng cộng đồng yêu thú cưng.</p>
  </div>
  <div class="login-right">
    <div class="login-box">
      <div class="brand">petopia<span class="dot">.</span></div>
      <h1 class="sub" style="font-size:.92rem;font-weight:400">Đăng nhập bằng tên đăng nhập hoặc Gmail</h1>
      <div class="login-err" id="loginError"></div>
      <form id="loginForm">
        <div class="fg2"><label for="lgUser">Tên đăng nhập / Gmail</label><input type="text" id="lgUser" name="username" placeholder="vd: lananh" required autocomplete="username"/></div>
        <div class="fg2"><label for="lgPass">Mật khẩu</label><input type="password" id="lgPass" name="password" placeholder="••••••••" required autocomplete="current-password"/></div>
        <button type="submit" id="loginBtn" class="btn btn-dark" style="width:100%;justify-content:center;padding:12px;margin-top:.5rem">Đăng nhập</button>
      </form>
      <p class="auth-switch">Chưa có tài khoản? <a href="register.php" id="toRegister">Tạo tài khoản mới</a></p>
      <p style="margin-top:1.25rem;font-size:.82rem;text-align:center"><a href="index.php" style="color:var(--warm-gray);font-weight:600">← Về trang chủ</a></p>
    </div>
  </div>
</main>
<script src="js/ui/icons.js"></script>
<script src="js/core/api.js"></script>
<script src="js/ui/components.js"></script>
<script src="js/pages/login.js"></script>
</body>
</html>
