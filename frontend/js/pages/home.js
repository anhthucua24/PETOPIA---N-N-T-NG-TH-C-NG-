// [UI] Trang chủ (index.php) – chuyển nguyên từ script inline
// Cần: js/core/api.js, js/ui/components.js

// ===== [CHỨC NĂNG] Trạng thái trang =====
let needs = new Set(), species = '', shown = [];

// ===== [CHỨC NĂNG] Lọc theo nhu cầu & loài =====
// Nút nhu cầu
document.getElementById('needGrid').innerHTML = NEEDS.map(n =>
  `<button class="need-chip" data-need="${n.key}" id="need-${n.key}"><span class="ni">${n.icon}</span><b>${n.title}</b><small>${n.sub}</small></button>`).join('');
document.querySelectorAll('.need-chip').forEach(b => b.onclick = () => {
  needs.has(b.dataset.need) ? needs.delete(b.dataset.need) : needs.add(b.dataset.need);
  b.classList.toggle('on'); loadPets();
});
document.querySelectorAll('#speciesTabs .cat-tab').forEach(b => b.onclick = () => {
  document.querySelectorAll('#speciesTabs .cat-tab').forEach(x => x.classList.toggle('on', x === b));
  species = b.dataset.sp; loadPets();
});

// ===== [CHỨC NĂNG] Tải danh sách thú cưng gợi ý =====
async function loadPets(){
  const el = document.getElementById('featuredPets');
  const filtering = needs.size || species;
  // Chưa chọn gì -> hiện "Nổi bật tuần này"; đã chọn -> gợi ý theo nhu cầu
  const qs = new URLSearchParams({limit: filtering ? 8 : 6});
  if (!filtering) qs.set('featured', '1');
  if (needs.size) qs.set('need', [...needs].join(','));
  if (species) qs.set('species', species);
  try{
    const res = await apiGet('/api/get_pets.php?' + qs);
    shown = res.data || [];
    document.getElementById('stat-total').textContent = (res.total_available ?? shown.length) + '';
    document.getElementById('matchTitle').textContent = filtering ? 'Gợi ý dành riêng cho bạn' : 'Nổi bật tuần này';
    document.getElementById('matchCount').textContent = filtering ? `Tìm thấy ${shown.length} bé phù hợp` : '';
    document.getElementById('seeAll').href = 'explore.php?' + new URLSearchParams({need:[...needs].join(','), species});
    el.innerHTML = shown.length ? shown.map(petCardHTML).join('')
      : '<div class="empty"><p>Chưa có bé nào khớp tất cả tiêu chí. Thử bỏ bớt một lựa chọn nhé!</p></div>';
  }catch{
    el.innerHTML = '<div style="padding:2rem;text-align:center;color:var(--warm-gray)">Không kết nối được server (localhost:8080).</div>';
  }
}

// ===== [CHỨC NĂNG] Xem chi tiết thú cưng (modal) =====
function showPetDetail(id){
  const p = shown.find(x => x.id === id); if(!p) return;
  document.getElementById('mName').textContent = p.name;
  document.getElementById('mImg').src = imgUrl(p.photo);
  document.getElementById('mInfo').innerHTML = petDetailHTML(p);
  document.getElementById('mAdoptBtn').onclick = () => location.href = `adopt.php?petId=${p.id}`;
  openModal('petModal');
}

// ===== [CHỨC NĂNG] Khởi động =====
loadPets();
