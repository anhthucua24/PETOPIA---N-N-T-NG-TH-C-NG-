// [UI] Trang Đăng ký (register.php) – chuyển nguyên từ script inline
// Cần: js/core/api.js, js/ui/components.js

// ===== [CHỨC NĂNG] Kiểm tra & gửi form đăng ký =====
document.getElementById('regForm').addEventListener('submit', async function(e){
  e.preventDefault();
  const fd = new FormData(this), err = document.getElementById('regError'), btn = document.getElementById('regBtn');
  const show = m => { err.textContent = m; err.style.display = 'block'; };
  err.style.display = 'none';
  // Kiểm tra nhanh phía trình duyệt (server vẫn kiểm tra lại)
  if(!/^[a-zA-Z0-9_.]{4,30}$/.test(fd.get('username'))) return show('Tên đăng nhập 4–30 ký tự, chỉ gồm chữ không dấu, số, _ hoặc .');
  if(!/^[^\s@]+@gmail\.com$/i.test(fd.get('email')))     return show('Vui lòng nhập đúng địa chỉ Gmail (@gmail.com).');
  if(fd.get('password').length < 6)                       return show('Mật khẩu tối thiểu 6 ký tự.');
  if(fd.get('password') !== fd.get('confirm'))            return show('Mật khẩu nhập lại không khớp.');

  btn.disabled = true; btn.textContent = 'Đang tạo...';
  try{
    const d = await apiPost('/auth/register.php', Object.fromEntries(fd));
    if(d.status === 'ok'){ showToast('Tạo tài khoản thành công!', 'success'); setTimeout(() => location.href = 'index.php', 700); return; }
    show(d.message || 'Có lỗi xảy ra');
  }catch{ show('Không kết nối được server (cổng 8080).'); }
  btn.disabled = false; btn.textContent = 'Tạo tài khoản';
});
