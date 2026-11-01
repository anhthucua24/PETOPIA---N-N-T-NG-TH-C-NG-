<!DOCTYPE html>
<!-- [UI] Trang Đăng ký -->
<html lang="vi">
<head>
  <meta charset="UTF-8"/><meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Petopia – Tạo tài khoản</title>
  <meta name="description" content="Tạo tài khoản Petopia miễn phí để nhận nuôi thú cưng và tham gia cộng đồng."/>
  <link rel="stylesheet" href="css/base.css"/>
  <link rel="stylesheet" href="css/components.css"/>
  <link rel="stylesheet" href="css/pages.css"/>
</head>
<body>
<main class="login-page">
  <div class="login-left">
    <div class="ll-tag">Thành viên mới</div>
    <h2>Bắt đầu hành trình<br/><span>yêu thương</span><br/>cùng Petopia.</h2>
    <p>Chỉ cần tên đăng nhập, mật khẩu và Gmail. Sau khi tạo, bạn có thể gửi đơn nhận nuôi, đăng bài và bình luận ngay.</p>
  </div>
  <div class="login-right">
    <div class="login-box">
      <div class="brand">petopia<span class="dot">.</span></div>
      <h1 class="sub" style="font-size:.92rem;font-weight:400">Tạo tài khoản miễn phí</h1>
      <div class="login-err" id="regError"></div>
      <form id="regForm" novalidate>
        <div class="fg2">
          <label for="rgUser">Tên đăng nhập<span class="req">*</span></label>
          <input type="text" id="rgUser" name="username" placeholder="vd: thu_nguyen" required minlength="4" maxlength="30" pattern="[a-zA-Z0-9_.]{4,30}" autocomplete="username"/>
          <small style="font-size:.74rem;color:var(--warm-gray)">4–30 ký tự, chữ không dấu, số, dấu _ hoặc .</small>
        </div>
        <div class="fg2">
          <label for="rgEmail">Gmail<span class="req">*</span></label>
          <input type="email" id="rgEmail" name="email" placeholder="ten@gmail.com" required pattern=".+@gmail\.com" autocomplete="email"/>
        </div>
        <div class="f2">
          <div class="fg2"><label for="rgPass">Mật khẩu<span class="req">*</span></label><input type="password" id="rgPass" name="password" placeholder="Tối thiểu 6 ký tự" required minlength="6" autocomplete="new-password"/></div>
          <div class="fg2"><label for="rgConfirm">Nhập lại<span class="req">*</span></label><input type="password" id="rgConfirm" name="confirm" placeholder="••••••" required autocomplete="new-password"/></div>
        </div>
        <button type="submit" id="regBtn" class="btn btn-dark" style="width:100%;justify-content:center;padding:12px;margin-top:.25rem">Tạo tài khoản</button>
      </form>
      <p class="auth-switch">Đã có tài khoản? <a href="login.php" id="toLogin">Đăng nhập</a></p>
      <p style="margin-top:1rem;font-size:.82rem;text-align:center"><a href="index.php" style="color:var(--warm-gray);font-weight:600">← Về trang chủ</a></p>
    </div>
  </div>
</main>
<script src="js/ui/icons.js"></script>
<script src="js/core/api.js"></script>
<script src="js/ui/components.js"></script>
<script src="js/pages/register.js"></script>
</body>
</html>
