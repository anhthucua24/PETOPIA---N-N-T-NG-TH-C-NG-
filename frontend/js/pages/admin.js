// [UI] Trang Quản trị (admin.php) – chuyển nguyên từ script inline
// Cần: js/core/api.js, js/ui/components.js

// ===== [CHỨC NĂNG] Hằng số, helper hiển thị & trạng thái =====
const empty = (n, t) => `<tr><td colspan="${n}" style="text-align:center;color:var(--warm-gray);padding:2rem">${t}</td></tr>`;
const pill = s => ({pending:'<span class="pill pill-wait">Chờ duyệt</span>', approved:'<span class="pill pill-ok">Đã duyệt</span>', rejected:'<span class="pill pill-no">Từ chối</span>'}[s] || '');
const petPill = s => ({available:'<span class="pill pill-ok">Sẵn sàng</span>', pending:'<span class="pill pill-wait">Có người đăng ký</span>', adopted:'<span class="pill pill-av" style="background:var(--sand);color:var(--mid)">Đã có nhà</span>'}[s]);
const HOUSING = {apartment:'Chung cư', house:'Nhà phố', house_with_yard:'Nhà có sân'};
const EXP = {none:'Chưa từng nuôi', some:'Đã từng nuôi', experienced:'Nhiều kinh nghiệm'};
let allPets = [], allAdoptions = [], allPosts = [], allUsers = [], adoptF = 'pending', postF = 'pending';

// ===== [CHỨC NĂNG] Bảo vệ trang (chỉ admin/staff) =====
// Bảo vệ trang: chỉ admin/staff
authReady.then(u => {
  if(!u) return location.href = 'login.php?next=admin.php';
  if(!isStaff()){ alert('Bạn không có quyền truy cập trang quản trị.'); return location.href = 'index.php'; }
  document.getElementById('hello').textContent = `Xin chào, ${u.fullName || u.username} (${ROLE[u.role]}).`;
  if(u.role === 'admin') document.getElementById('navUsers').style.display = '';
  const tab = location.hash.slice(1); if(tab) showTab(tab);
  loadAll();
});

// ===== [CHỨC NĂNG] Bộ lọc trạng thái (đơn / bài) =====
function filterBtns(id, cur, setter){
  document.getElementById(id).innerHTML = [['pending','Chờ duyệt'],['approved','Đã duyệt'],['rejected','Từ chối'],['','Tất cả']]
    .map(([k,v]) => `<button class="cat-tab ${k===cur?'on':''}" onclick="${setter}('${k}')">${v}</button>`).join('');
}
function setAdoptF(v){ adoptF = v; renderAdoptions(); }
function setPostF(v){ postF = v; renderPosts(); }

// ===== [CHỨC NĂNG] Thống kê – tải dữ liệu & chuyển tab =====
async function loadAll(){
  try{
    const reqs = [apiGet('/api/get_pets.php?all=1'), apiGet('/api/list_adoptions.php'), apiGet('/api/list_posts.php?manage=1')];
    if(ME.role === 'admin') reqs.push(apiGet('/api/users.php'));
    const [pr, ar, po, us] = await Promise.all(reqs);
    allPets = pr.data || []; allAdoptions = ar.data || []; allPosts = po.data || []; allUsers = us?.data || [];
    const pend = allAdoptions.filter(a => a.status === 'pending').length;
    const pendPosts = allPosts.filter(p => p.status === 'pending').length;
    s('s-pets', allPets.filter(p => p.status !== 'adopted').length); s('s-pending', pend); s('b-pending', pend);
    s('s-approved', allPets.filter(p => p.status === 'adopted').length); s('s-posts', pendPosts); s('b-posts', pendPosts);
    renderAll();
  }catch{ showToast('Không kết nối được server', 'error'); }
}
function s(id, v){ document.getElementById(id).textContent = v; }
function showTab(tab){
  if(tab === 'users' && ME?.role !== 'admin') return;
  ['stats','pets','adoptions','posts','users'].forEach(t => document.getElementById('tab-'+t).style.display = t === tab ? 'block' : 'none');
  document.querySelectorAll('.aside-item[data-tab]').forEach(b => b.classList.toggle('active', b.dataset.tab === tab));
  history.replaceState(null, '', '#' + tab);
}

// ===== [CHỨC NĂNG] Hiển thị bảng: thống kê + thú cưng =====
function renderAll(){
  document.getElementById('recentBody').innerHTML = allAdoptions.length ? allAdoptions.slice(0,5).map(a =>
    `<tr><td><b>${esc(a.fullName)}</b></td><td>${esc(a.petName || '–')}</td><td>${esc(a.phone)}</td><td>${pill(a.status)}</td></tr>`).join('') : empty(4, 'Chưa có đơn.');
  document.getElementById('petsBody').innerHTML = allPets.length ? allPets.map(p => `<tr>
    <td><img src="${imgUrl(p.photo)}" class="pet-thumb" alt=""/></td>
    <td><b>${esc(p.name)}</b>${p.featured ? ' <span title="Nổi bật">⭐</span>' : ''}<br/><small style="color:var(--warm-gray)">${esc(p.location || '')}</small></td>
    <td>${p.species === 'dog' ? 'Chó' : 'Mèo'} · ${esc(p.breed || '–')}</td><td>${ageText(p.age)}</td>
    <td>${SIZE[p.size]}</td><td>${ENERGY[p.energy]}</td><td>${petPill(p.status)}</td>
    <td style="white-space:nowrap"><button class="btn btn-ghost btn-sm" onclick="openPetForm('${p.id}')">Sửa</button>
    <button class="btn btn-red btn-sm" onclick="deletePet('${p.id}')">Xoá</button></td></tr>`).join('') : empty(8, 'Chưa có thú cưng.');
  renderAdoptions(); renderPosts(); renderUsers();
}

// ===== [CHỨC NĂNG] Duyệt đơn nhận nuôi – danh sách =====
function renderAdoptions(){
  filterBtns('adoptFilter', adoptF, 'setAdoptF');
  const list = allAdoptions.filter(a => !adoptF || a.status === adoptF);
  document.getElementById('adoptBody').innerHTML = list.length ? list.map(a => `<tr>
    <td><b>${esc(a.fullName)}</b><br/><small style="color:var(--warm-gray)">${esc(a.phone)} · ${esc(a.email || '')}</small><br/><small style="color:var(--warm-gray)">${esc(a.address)}</small></td>
    <td><div style="display:flex;gap:8px;align-items:center"><img src="${imgUrl(a.petPhoto)}" class="pet-thumb" alt=""/>${esc(a.petName || '–')}</div></td>
    <td style="font-size:.82rem;color:var(--mid);white-space:nowrap">${gi('home')} ${HOUSING[a.housing_type]}<br/>${gi('cap')} ${EXP[a.experience]}<br/>${gi('clock')} ${a.hours_alone ?? '?'}h một mình
      ${a.has_children ? '<br/>'+gi('baby')+' Có trẻ nhỏ' : ''}${a.has_other_pets ? '<br/>'+gi('paw')+' Có thú cưng khác' : ''}</td>
    <td><div class="td-clip">${esc(a.reason || '–')}</div>${a.admin_note ? `<small style="color:var(--green)">Ghi chú: ${esc(a.admin_note)}</small>` : ''}</td>
    <td style="white-space:nowrap">${fmtTime(a.created_at)}</td>
    <td>${pill(a.status)}${a.reviewer ? `<br/><small style="color:var(--warm-gray)">bởi ${esc(a.reviewer)}</small>` : ''}</td>
    <td style="white-space:nowrap">${a.status === 'pending' ? `<button class="btn btn-success btn-sm" onclick="review('adoption','approve','${a.requestId}')">Duyệt</button>
      <button class="btn btn-red btn-sm" onclick="review('adoption','reject','${a.requestId}')">Từ chối</button>` : ''}</td></tr>`).join('') : empty(7, 'Không có đơn.');
}

// ===== [CHỨC NĂNG] Duyệt bài viết – danh sách =====
function renderPosts(){
  filterBtns('postFilter', postF, 'setPostF');
  const list = allPosts.filter(p => !postF || p.status === postF);
  document.getElementById('postsBody').innerHTML = list.length ? list.map(p => `<tr>
    <td>${p.image ? `<img src="${imgUrl(p.image)}" class="pet-thumb" alt=""/>` : '–'}</td>
    <td><b>${esc(p.title)}</b><div class="td-clip">${esc(p.content)}</div>
      ${p.reject_reason ? `<small style="color:var(--red)">Lý do: ${esc(p.reject_reason)}</small>` : ''}</td>
    <td>${esc(p.author)}</td><td>${CATEGORY[p.category]}</td>
    <td style="white-space:nowrap">${fmtTime(p.created_at)}</td>
    <td>${pill(p.status)}${p.reviewer ? `<br/><small style="color:var(--warm-gray)">bởi ${esc(p.reviewer)}</small>` : ''}</td>
    <td style="white-space:nowrap">${p.status === 'pending' ? `<button class="btn btn-success btn-sm" onclick="review('post','approve','${p.postId}')">Duyệt</button>
      <button class="btn btn-red btn-sm" onclick="review('post','reject','${p.postId}')">Từ chối</button>` :
      `<button class="btn btn-ghost btn-sm" onclick="deletePost('${p.postId}')">Xoá</button>`}</td></tr>`).join('') : empty(7, 'Không có bài viết.');
}

// ===== [CHỨC NĂNG] Tài khoản – danh sách (chỉ admin) =====
function renderUsers(){
  if(ME.role !== 'admin') return;
  document.getElementById('usersBody').innerHTML = allUsers.map(u => `<tr>
    <td><b>${esc(u.username)}</b><br/><small style="color:var(--warm-gray)">${esc(u.fullName || '')}</small></td>
    <td>${esc(u.email)}</td>
    <td>${u.userId === ME.userId ? `<span class="role-chip role-${u.role}">${ROLE[u.role]}</span>` :
      `<select onchange="updateUser('${u.userId}',{role:this.value})" style="padding:6px 10px;border-radius:8px;border:1px solid var(--border)">
        ${['customer','staff','admin'].map(r => `<option value="${r}" ${r===u.role?'selected':''}>${ROLE[r]}</option>`).join('')}</select>`}</td>
    <td>${u.posts} / ${u.adoptions}</td><td style="white-space:nowrap">${fmtTime(u.created_at)}</td>
    <td>${u.status === 'active' ? '<span class="pill pill-ok">Hoạt động</span>' : '<span class="pill pill-no">Đã khoá</span>'}</td>
    <td>${u.userId === ME.userId ? '' : `<button class="btn btn-${u.status==='active'?'red':'ghost'} btn-sm" onclick="updateUser('${u.userId}',{status:'${u.status==='active'?'locked':'active'}'})">${u.status==='active'?'Khoá':'Mở khoá'}</button>`}</td></tr>`).join('');
}

// ===== [CHỨC NĂNG] Thú cưng – thêm / sửa / xoá =====
/* ── Thú cưng ── */
function openPetForm(id){
  const f = document.getElementById('petForm'); f.reset();
  document.getElementById('pf-id').value = '';
  document.getElementById('pf-preview').src = 'https://placehold.co/72x72/EEE8DE/7A7067?text=+';
  document.getElementById('pf-fname').textContent = 'Bấm để chọn ảnh từ máy (tối đa 5MB)';
  document.getElementById('petFormTitle').textContent = 'Thêm thú cưng';
  if(id){
    const p = allPets.find(x => x.id === id); if(!p) return;
    document.getElementById('petFormTitle').textContent = 'Sửa: ' + p.name;
    document.getElementById('pf-id').value = p.id;
    ['name','species','breed','age','gender','weight_kg','size','energy','status','color','location','description']
      .forEach(k => document.getElementById('pf-' + k).value = p[k] ?? '');
    ['good_with_kids','good_with_pets','apartment_friendly','vaccinated','neutered','featured']
      .forEach(k => document.getElementById('pf-' + k).checked = !!+p[k]);
    document.getElementById('pf-preview').src = imgUrl(p.photo);
    document.getElementById('pf-fname').textContent = 'Giữ ảnh hiện tại, hoặc bấm để chọn ảnh mới';
  }
  openModal('petFormModal');
}
document.getElementById('pf-file').onchange = e => {
  const f = e.target.files[0]; if(!f) return;
  document.getElementById('pf-preview').src = URL.createObjectURL(f);
  document.getElementById('pf-fname').textContent = f.name;
};
async function savePet(){
  const f = document.getElementById('petForm'); if(!f.reportValidity()) return;
  const btn = document.getElementById('btnSavePet'); btn.disabled = true;
  const fd = new FormData(f);
  // checkbox bỏ chọn sẽ không có trong FormData -> gửi 0
  ['good_with_kids','good_with_pets','apartment_friendly','vaccinated','neutered','featured'].forEach(k => { if(!fd.has(k)) fd.set(k, '0'); });
  try{
    const d = await apiForm('/api/save_pet.php', fd);
    if(d.status === 'ok'){ closeModal('petFormModal'); showToast(d.message, 'success'); loadAll(); }
    else showToast(d.message || 'Lỗi', 'error');
  }catch{ showToast('Lỗi kết nối', 'error'); }
  btn.disabled = false;
}
async function deletePet(id){
  const p = allPets.find(x => x.id === id);
  if(!confirm(`Xoá "${p?.name}"? Ảnh của bé cũng sẽ bị xoá.`)) return;
  const d = await apiPost('/api/delete_pet.php', {id});
  d.status === 'ok' ? (showToast('Đã xoá', 'success'), loadAll()) : showToast(d.message, 'error');
}

// ===== [CHỨC NĂNG] Duyệt đơn / duyệt bài (modal xác nhận) =====
/* ── Duyệt đơn / bài ── */
function review(type, action, id){
  const isApprove = action === 'approve';
  const item = type === 'adoption' ? allAdoptions.find(a => a.requestId === id) : allPosts.find(p => p.postId === id);
  document.getElementById('rvTitle').textContent = (isApprove ? 'Duyệt ' : 'Từ chối ') + (type === 'adoption' ? 'đơn nhận nuôi' : 'bài viết');
  document.getElementById('rvInfo').innerHTML = type === 'adoption'
    ? `<b>${esc(item.fullName)}</b> muốn nhận nuôi <b>${esc(item.petName)}</b>.${isApprove ? '<br/>Các đơn khác cho bé này sẽ tự động bị từ chối.' : ''}`
    : `<b>${esc(item.title)}</b> – ${esc(item.author)}`;
  document.getElementById('rvLabel').textContent = isApprove ? 'Ghi chú (tùy chọn)' : 'Lý do từ chối (bắt buộc – người dùng sẽ thấy)';
  document.getElementById('rvNote').value = '';
  const btn = document.getElementById('rvSubmit');
  btn.className = 'btn btn-sm ' + (isApprove ? 'btn-success' : 'btn-red');
  btn.textContent = isApprove ? 'Duyệt' : 'Từ chối';
  btn.onclick = async () => {
    const note = document.getElementById('rvNote').value.trim();
    if(!isApprove && !note) return showToast('Vui lòng nhập lý do', 'error');
    const d = type === 'adoption'
      ? await apiPost('/api/review_adoption.php', {requestId: id, action, note})
      : await apiPost('/api/review_post.php', {postId: id, action, reason: note});
    if(d.status === 'ok'){ closeModal('reviewModal'); showToast(d.message, 'success'); loadAll(); }
    else showToast(d.message, 'error');
  };
  openModal('reviewModal');
}
async function deletePost(postId){
  if(!confirm('Xoá bài viết này?')) return;
  const d = await apiPost('/api/delete_post.php', {postId});
  d.status === 'ok' ? (showToast('Đã xoá', 'success'), loadAll()) : showToast(d.message, 'error');
}

// ===== [CHỨC NĂNG] Tài khoản – phân quyền / khoá =====
async function updateUser(userId, change){
  const d = await apiPost('/api/users.php', {userId, ...change});
  d.status === 'ok' ? (showToast(d.message, 'success'), loadAll()) : showToast(d.message, 'error');
}
