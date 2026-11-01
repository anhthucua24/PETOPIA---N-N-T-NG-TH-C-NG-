/* [UI] ui/components.js – PETOPIA
   Các hàm dựng HTML & tương tác giao diện dùng chung: nav, icon, thẻ thú cưng, modal, toast, menu mobile.
   Cần js/core/api.js nạp trước. */

// ===== [CHỨC NĂNG] Thanh điều hướng theo trạng thái đăng nhập =====
function renderNavAuth(){
  const li = document.querySelector('.nav-links .nav-admin')?.closest('li');
  if(!li) return;
  if(!ME){
    li.outerHTML = `<li><a href="${loginUrl()}" class="nav-ghost" id="navLogin">Đăng nhập</a></li>
                    <li><a href="register.php" class="nav-admin" id="navRegister">Đăng ký</a></li>`;
    return;
  }
  const name = ME.fullName || ME.username;
  li.outerHTML = `<li class="nav-user">
      ${isStaff() ? '<a href="admin.php" class="nav-admin" id="navAdmin">Quản trị</a>' : ''}
      <span class="nu-name"><span class="nu-av">${esc(name[0].toUpperCase())}</span>${esc(name)}
        ${ME.role !== 'customer' ? `<span class="nu-role">${ROLE[ME.role]}</span>` : ''}</span>
      <button class="nav-link-btn" id="navLogout" onclick="logout()">Đăng xuất</button></li>`;
}
authReady.then(renderNavAuth);

// ===== [CHỨC NĂNG] Bộ icon SVG =====
/* SVG Icons – simple & geometric, không emoji */
const IC = {
  close:gi('x'), check:gi('check'), x:gi('x'), warn:gi('warn'), arrow:gi('arrow'), plus:gi('plus'),
  edit:gi('edit'), trash:gi('trash'), logout:gi('logout'), grid:gi('grid'), list:gi('list'), heart:gi('heart'),
  file:gi('file'), bar:gi('bar'), lock:gi('lock'), send:gi('send'),
};  // icon glass, xem js/ui/icons.js

// ===== [CHỨC NĂNG] Thẻ thú cưng =====
/* ── Pet card ── */
function petCardHTML(p) {
  const dog = p.species === 'dog';
  return `<div class="pet-item" onclick="typeof showPetDetail==='function'&&showPetDetail('${p.id}')">
    <div class="pet-img-wrap">
      <img class="pet-img" src="${imgUrl(p.photo)}" alt="${esc(p.name)}" loading="lazy"
        onerror="this.src='https://placehold.co/400x300/F0E6D3/8A7968?text=Petopia'"/>
      <span class="pet-kind">${dog ? 'Chó' : 'Mèo'}</span>
      ${p.status === 'pending' ? '<span class="pet-status">Đang có người đăng ký</span>' : ''}
    </div>
    <div class="pet-info">
      <div class="pet-name">${esc(p.name)}</div>
      <div class="pet-breed">${esc(p.breed || 'Không rõ giống')} · ${esc(p.location || '')}</div>
      <div class="pet-tags">
        <span class="tag orange">${ageText(p.age)}</span>
        <span class="tag green">${esc(p.gender || 'N/A')}</span>
        <span class="tag">${SIZE[p.size] || ''}</span>
        <span class="tag">${ENERGY[p.energy] || ''}</span>
      </div>
      <button class="btn btn-outline btn-sm" style="width:100%;justify-content:center"
        onclick="event.stopPropagation();typeof showPetDetail==='function'&&showPetDetail('${p.id}')">
        Xem chi tiết ${IC.arrow}
      </button>
    </div>
  </div>`;
}

// ===== [CHỨC NĂNG] Chi tiết thú cưng =====
/* ── Chi tiết thú cưng (dùng chung trang chủ + khám phá) ── */
function petDetailHTML(p){
  const t = (ok, label) => `<span class="${ok ? 'yes' : 'no'}">${label}</span>`;
  return `
    <div class="pet-tags" style="margin:10px 0 4px">
      <span class="tag orange">${ageText(p.age)}</span>
      <span class="tag">${p.species==='dog'?'Chó':'Mèo'} · ${esc(p.breed||'Không rõ')}</span>
      <span class="tag green">${esc(p.gender)}</span>
      <span class="tag">${SIZE[p.size]} · ${p.weight_kg ?? '?'} kg</span>
      <span class="tag">${esc(p.color||'')}</span>
    </div>
    <div class="trait-list">
      ${t(p.good_with_kids,'Hợp trẻ nhỏ')}${t(p.good_with_pets,'Hợp thú cưng khác')}
      ${t(p.apartment_friendly,'Nuôi được ở chung cư')}${t(p.vaccinated,'Đã tiêm phòng')}
      ${t(p.neutered,'Đã triệt sản')}<span>${gi('bolt')} ${ENERGY[p.energy]}</span>
    </div>
    <p style="font-size:.8rem;color:var(--warm-gray);margin-bottom:6px">${gi('pin')} ${esc(p.location||'')}</p>
    <p style="color:var(--mid);line-height:1.7;font-size:.9rem">${esc(p.description)}</p>`;
}

// ===== [CHỨC NĂNG] Modal =====
/* ── Modal ── */
function openModal(id){document.getElementById(id)?.classList.add('open')}
function closeModal(id){document.getElementById(id)?.classList.remove('open')}
document.addEventListener('click',e=>{
  if(e.target.classList.contains('overlay'))e.target.classList.remove('open')
})
document.addEventListener('keydown',e=>{
  if(e.key==='Escape')document.querySelectorAll('.overlay.open').forEach(m=>m.classList.remove('open'))
})

// ===== [CHỨC NĂNG] Thông báo toast =====
/* ── Toast ── */
function showToast(msg,type='success'){
  const t=document.createElement('div')
  t.className=`toast ${type}`
  const ic=type==='success'?IC.check:type==='error'?IC.x:IC.warn
  t.innerHTML=ic+' '+msg
  document.body.appendChild(t)
  setTimeout(()=>t.remove(),3200)
}

// ===== [CHỨC NĂNG] Menu mobile & hiệu ứng cuộn =====
/* ── UI enhancements: mobile nav + scroll reveal ── */
document.addEventListener('DOMContentLoaded',()=>{
  const nav=document.querySelector('.nav')
  if(nav&&!nav.querySelector('.nav-toggle')){
    const b=document.createElement('button')
    b.className='nav-toggle';b.id='navToggle';b.setAttribute('aria-label','Mở menu')
    b.innerHTML='<span></span><span></span><span></span>'
    b.onclick=()=>nav.classList.toggle('open')
    nav.appendChild(b)
    addEventListener('scroll',()=>nav.classList.toggle('scrolled',scrollY>8),{passive:true})
  }
  const els=document.querySelectorAll('.sec-label,.sec-title,.sec-sub,.campaign-item,.feat-item,.about-left,.adopt-form-card,.filter-bar')
  if('IntersectionObserver' in window){
    const io=new IntersectionObserver(es=>es.forEach(e=>{if(e.isIntersecting){e.target.classList.add('in');io.unobserve(e.target)}}),{threshold:.12})
    els.forEach(el=>{el.classList.add('reveal');io.observe(el)})
  }
})
