// [UI] Trang Nhận nuôi (adopt.php) – chuyển nguyên từ script inline
// Cần: js/core/api.js, js/ui/components.js

// ===== [CHỨC NĂNG] Tham số & nhãn trạng thái đơn =====
const params = new URLSearchParams(location.search);
const ST = {pending:'<span class="pill pill-wait">Chờ duyệt</span>', approved:'<span class="pill pill-ok">Đã duyệt</span>', rejected:'<span class="pill pill-no">Từ chối</span>'};

// ===== [CHỨC NĂNG] Kiểm tra đăng nhập & tự điền khảo sát =====
authReady.then(async () => {
  if(!ME){
    document.getElementById('loginCard').style.display = 'block';
    document.getElementById('goLogin').href = loginUrl();
    return;
  }
  document.getElementById('formCard').style.display = 'block';
  // Tự điền từ tài khoản
  if(ME.fullName && ME.fullName !== ME.username) document.getElementById('afName').value = ME.fullName;
  document.getElementById('afPhone').value = ME.phone || '';
  document.getElementById('afEmail').value = ME.email || '';
  loadPets(); loadMine();
});

// ===== [CHỨC NĂNG] Chọn thú cưng =====
async function loadPets(){
  try{
    const res = await apiGet('/api/get_pets.php');
    const sel = document.getElementById('petSelect');
    (res.data || []).forEach(p => {
      const o = document.createElement('option');
      o.value = p.id;
      o.textContent = `${p.name} – ${p.species==='dog'?'Chó':'Mèo'} ${p.breed||''} (${ageText(p.age)})${p.status==='pending'?' · đang có người đăng ký':''}`;
      if(p.id === params.get('petId')) o.selected = true;
      sel.appendChild(o);
    });
  }catch{ showToast('Không kết nối được server', 'error'); }
}

// ===== [CHỨC NĂNG] Đơn của tôi =====
async function loadMine(){
  const res = await apiGet('/api/list_adoptions.php?mine=1');
  const list = res.data || [];
  document.getElementById('myAdoptions').innerHTML = list.length ? `
    <h2 class="sec-title" style="font-size:1.5rem">Đơn của tôi</h2>
    <div class="mini-list">${list.map(a => `
      <div class="mini-item">
        <img src="${imgUrl(a.petPhoto)}" alt=""/>
        <div class="mi-body"><div class="mi-title">${esc(a.petName || 'Thú cưng đã xoá')}</div>
          <div class="mi-sub">Gửi lúc ${fmtTime(a.created_at)}${a.admin_note ? ' · Ghi chú: ' + esc(a.admin_note) : ''}</div></div>
        ${ST[a.status]}
      </div>`).join('')}</div>` : '';
}

// ===== [CHỨC NĂNG] Gửi đơn (khảo sát nhận nuôi) =====
document.getElementById('adoptForm').addEventListener('submit', async function(e){
  e.preventDefault();
  if(!this.reportValidity()) return;
  const btn = document.getElementById('adoptSubmit'); btn.disabled = true;
  const payload = Object.fromEntries(new FormData(this));
  try{
    const data = await apiPost('/api/submit_adoption.php', payload);
    if(data.status === 'ok'){
      document.getElementById('successBanner').style.display = 'block';
      document.getElementById('afReason').value = '';
      window.scrollTo({top:0, behavior:'smooth'});
      showToast('Đã gửi đơn', 'success'); loadMine();
    } else showToast(data.message || 'Có lỗi xảy ra', 'error');
  }catch{ showToast('Không thể kết nối server', 'error'); }
  btn.disabled = false;
});
