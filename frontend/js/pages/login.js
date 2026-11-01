// [UI] Trang Đăng nhập (login.php) – chuyển nguyên từ script inline
// Cần: js/core/api.js, js/ui/components.js

// ===== [CHỨC NĂNG] Tài khoản demo & chuyển hướng nếu đã đăng nhập =====
const next = new URLSearchParams(location.search).get('next');
document.querySelectorAll('.demo-acc code').forEach(c => c.onclick = () => {
  document.getElementById('lgUser').value = c.dataset.u; document.getElementById('lgPass').value = c.dataset.p;
});
// Đã đăng nhập rồi thì chuyển trang luôn
authReady.then(u => { if(u) location.href = (u.role === 'customer' ? (next || 'index.php') : 'admin.php'); });

// ===== [CHỨC NĂNG] Gửi form đăng nhập =====
document.getElementById('loginForm').addEventListener('submit', async function(e){
  e.preventDefault();
  const fd = new FormData(this), err = document.getElementById('loginError'), btn = document.getElementById('loginBtn');
  err.style.display = 'none'; btn.disabled = true; btn.textContent = 'Đang đăng nhập...';
  try{
    const d = await apiPost('/auth/login.php', {username: fd.get('username'), password: fd.get('password')});
    if(d.status === 'ok'){
      // Phân luồng: admin/staff -> trang quản trị; khách -> trang trước đó hoặc trang chủ
      location.href = d.user.role === 'customer' ? (next || d.redirect) : d.redirect;
      return;
    }
    err.textContent = d.message || 'Sai tài khoản hoặc mật khẩu.'; err.style.display = 'block';
  }catch{ err.textContent = 'Không kết nối được server (cổng 8080).'; err.style.display = 'block'; }
  btn.disabled = false; btn.textContent = 'Đăng nhập';
});
