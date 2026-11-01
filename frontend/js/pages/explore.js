// [UI] Trang Khám phá (explore.php) – chuyển nguyên từ script inline
// Cần: js/core/api.js, js/ui/components.js

// ===== [CHỨC NĂNG] Trạng thái & cấu hình bộ lọc =====
let allPets=[], needs=new Set(), timer=null;
const F = ['sName','sSpecies','sAge','sGender','sSize','sEnergy'];
const KEY = {sName:'q',sSpecies:'species',sAge:'age',sGender:'gender',sSize:'size',sEnergy:'energy'};

// ===== [CHỨC NĂNG] Lọc theo nhu cầu (đọc tham số URL) =====
// Nút nhu cầu + đọc tham số từ URL (vd: explore.php?need=apartment,kids&species=cat)
const url = new URLSearchParams(location.search);
(url.get('need')||'').split(',').filter(Boolean).forEach(n=>needs.add(n));
if(url.get('species')) document.getElementById('sSpecies').value = url.get('species');
document.getElementById('needChips').innerHTML = NEEDS.map(n =>
  `<button class="need-chip ${needs.has(n.key)?'on':''}" data-need="${n.key}" id="chip-${n.key}"><span class="ni">${n.icon}</span><b>${n.title}</b></button>`).join('');
document.querySelectorAll('#needChips .need-chip').forEach(b => b.onclick = () => {
  needs.has(b.dataset.need) ? needs.delete(b.dataset.need) : needs.add(b.dataset.need);
  b.classList.toggle('on'); doFilter();
});

// ===== [CHỨC NĂNG] Tìm kiếm / lọc & tải dữ liệu =====
function doFilter(){ clearTimeout(timer); timer = setTimeout(load, 200); }
async function load(){
  const qs = new URLSearchParams();
  F.forEach(id => { const v = document.getElementById(id).value.trim(); if(v) qs.set(KEY[id], v); });
  if(needs.size) qs.set('need', [...needs].join(','));
  history.replaceState(null, '', '?' + qs);
  try{
    const res = await apiGet('/api/get_pets.php?' + qs);
    allPets = res.data || []; renderPets(allPets);
  }catch{
    document.getElementById('petGrid').innerHTML='<div style="padding:2rem;text-align:center;color:var(--warm-gray)">Không kết nối được server.</div>';
  }
}
function resetF(){
  F.forEach(i=>document.getElementById(i).value='');
  needs.clear(); document.querySelectorAll('#needChips .need-chip').forEach(b=>b.classList.remove('on'));
  load();
}

// ===== [CHỨC NĂNG] Hiển thị danh sách =====
function renderPets(pets){
  document.getElementById('rCount').textContent=`Tìm thấy ${pets.length} thú cưng`;
  document.getElementById('petGrid').innerHTML=pets.length
    ?pets.map(p=>petCardHTML(p)).join('')
    :'<div class="empty" style="grid-column:1/-1">'+gi('search')+'<p>Không tìm thấy kết quả phù hợp.</p></div>';
}

// ===== [CHỨC NĂNG] Xem chi tiết thú cưng (modal) =====
function showPetDetail(id){
  const p=allPets.find(x=>x.id===id);if(!p)return;
  document.getElementById('mName').textContent=p.name;
  document.getElementById('mImg').src=imgUrl(p.photo);
  document.getElementById('mImg').alt=p.name;
  document.getElementById('mInfo').innerHTML=petDetailHTML(p);
  document.getElementById('mAdoptBtn').onclick=()=>{
    closeModal('petModal');
    location.href=`adopt.php?petId=${p.id}`;
  };
  openModal('petModal');
}

// ===== [CHỨC NĂNG] Khởi động =====
load();
