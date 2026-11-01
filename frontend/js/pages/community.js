// [UI] Trang Cộng đồng (community.php) – chuyển nguyên từ script inline
// Cần: js/core/api.js, js/ui/components.js

// ===== [CHỨC NĂNG] Trạng thái trang =====
let category = '', posts = [];
const HEART = gi('heart');

// ===== [CHỨC NĂNG] Lọc chuyên mục =====
// Tabs chuyên mục
document.getElementById('catTabs').innerHTML = [['', 'Tất cả'], ...Object.entries(CATEGORY)]
  .map(([k, v]) => `<button class="cat-tab ${k === '' ? 'on' : ''}" data-cat="${k}" id="cat-${k || 'all'}">${v}</button>`).join('');
document.querySelectorAll('#catTabs .cat-tab').forEach(b => b.onclick = () => {
  document.querySelectorAll('#catTabs .cat-tab').forEach(x => x.classList.toggle('on', x === b));
  category = b.dataset.cat; loadPosts();
});

// ===== [CHỨC NĂNG] Tải bài viết =====
authReady.then(() => { loadPosts(); loadMine(); });

async function loadPosts(){
  try{
    const res = await apiGet('/api/list_posts.php' + (category ? '?category=' + category : ''));
    posts = res.data || []; renderPosts();
  }catch{ document.getElementById('postList').innerHTML = '<div class="empty">Không kết nối được server.</div>'; }
}
// Bài của tôi đang chờ duyệt / bị từ chối
async function loadMine(){
  const el = document.getElementById('myPosts');
  if(!ME) { el.innerHTML = ''; return; }
  const res = await apiGet('/api/list_posts.php?mine=1');
  const mine = (res.data || []).filter(p => p.status !== 'approved');
  el.innerHTML = mine.map(p => p.status === 'pending'
    ? `<div class="notice wait">⏳ Bài "<b>${esc(p.title)}</b>" của bạn đang chờ duyệt.</div>`
    : `<div class="notice no">${gi('x')} Bài "<b>${esc(p.title)}</b>" bị từ chối: ${esc(p.reject_reason || '')}</div>`).join('');
}

// ===== [CHỨC NĂNG] Hiển thị bài viết =====
function avatar(name, cls = 'p-avatar'){ return `<div class="${cls}">${esc((name || 'A')[0].toUpperCase())}</div>`; }
function staffTag(role){ return role === 'admin' || role === 'staff' ? `<span class="staff-tag">${ROLE[role]}</span>` : ''; }

function renderPosts(){
  const el = document.getElementById('postList');
  if(!posts.length){ el.innerHTML = '<div class="empty"><p>Chưa có bài viết nào trong mục này.</p></div>'; return; }
  el.innerHTML = posts.map(p => {
    const roots = p.comments.filter(c => !c.parentId);
    return `<article class="post" id="post-${p.postId}">
      ${p.image ? `<img src="${imgUrl(p.image)}" alt="${esc(p.title)}" class="post-img" loading="lazy"/>` : ''}
      <div class="post-body">
        <div class="post-meta">${avatar(p.author)}
          <div><div class="p-name">${esc(p.author)}${staffTag(p.author_role)}</div><div class="p-time">${fmtTime(p.created_at)}</div></div>
          <span class="cat-badge">${CATEGORY[p.category]}</span>
        </div>
        <h2 class="p-title">${esc(p.title)}</h2>
        <p class="p-content">${esc(p.content)}</p>
        <div class="post-actions">
          <button class="like-btn ${p.liked ? 'on' : ''}" id="like-${p.postId}" onclick="toggleLike('${p.postId}')">${HEART}<span>${p.likes}</span></button>
          <span style="font-size:.82rem;color:var(--warm-gray)">${p.comments.length} bình luận</span>
        </div>
        <div class="cmts">
          <div id="cmts-${p.postId}">${roots.map(c => cmtHTML(c, p)).join('')}</div>
          ${ME ? `<form class="cmt-form" onsubmit="postComment(event,'${p.postId}')">
              <input type="text" name="text" placeholder="Viết bình luận với tên ${esc(ME.fullName || ME.username)}..." required/>
              <button type="submit" class="btn btn-green btn-sm">Gửi</button></form>`
            : `<div class="login-hint"><a href="${loginUrl()}">Đăng nhập</a> để bình luận và thích bài viết.</div>`}
        </div>
      </div>
    </article>`;
  }).join('');
}

// ===== [CHỨC NĂNG] Bình luận – phản hồi =====
function cmtHTML(c, p){
  const replies = p.comments.filter(r => r.parentId === c.commentId);
  return `<div class="cmt">${avatar(c.author, 'c-av')}
      <div style="flex:1"><div class="c-bubble"><div class="c-who">${esc(c.author)}${staffTag(c.author_role)}</div><div class="c-txt">${esc(c.text)}</div></div>
      <div class="c-meta"><span>${fmtTime(c.created_at)}</span>${ME ? `<button onclick="openReply('${p.postId}','${c.commentId}')">Trả lời</button>` : ''}</div></div></div>
    <div class="c-replies" id="rep-${c.commentId}">${replies.map(r => `<div class="cmt">${avatar(r.author, 'c-av')}
      <div style="flex:1"><div class="c-bubble"><div class="c-who">${esc(r.author)}${staffTag(r.author_role)}</div><div class="c-txt">${esc(r.text)}</div></div>
      <div class="c-meta"><span>${fmtTime(r.created_at)}</span></div></div></div>`).join('')}</div>
    <div id="rf-${c.commentId}"></div>`;
}
function openReply(postId, cid){
  const box = document.getElementById('rf-' + cid);
  if(box.innerHTML){ box.innerHTML = ''; return; }
  box.innerHTML = `<form class="cmt-form reply-form" onsubmit="postComment(event,'${postId}','${cid}')">
    <input type="text" name="text" placeholder="Viết phản hồi..." required autofocus/><button type="submit" class="btn btn-green btn-sm">Trả lời</button></form>`;
  box.querySelector('input').focus();
}
async function postComment(e, postId, parentId = null){
  e.preventDefault(); const f = e.target;
  try{
    const d = await apiPost('/api/add_comment.php', {postId, text: f.text.value, parentId});
    if(d.status !== 'ok') return showToast(d.message, 'error');
    const p = posts.find(x => x.postId === postId); p.comments.push(d.comment);
    renderPosts(); showToast('Đã gửi bình luận', 'success');
  }catch{ showToast('Lỗi kết nối', 'error'); }
}

// ===== [CHỨC NĂNG] Thích bài viết =====
async function toggleLike(postId){
  if(!ME) return location.href = loginUrl();
  const d = await apiPost('/api/like_post.php', {postId});
  if(d.status !== 'ok') return showToast(d.message, 'error');
  const b = document.getElementById('like-' + postId);
  b.classList.toggle('on', d.liked); b.querySelector('span').textContent = d.likes;
  const p = posts.find(x => x.postId === postId); p.liked = d.liked; p.likes = d.likes;
}

// ===== [CHỨC NĂNG] Đăng bài =====
function openNewPost(){
  if(!ME) return location.href = loginUrl();
  document.getElementById('reviewNote').style.display = isStaff() ? 'none' : 'block';
  openModal('newPostModal');
}
document.getElementById('npImage').onchange = e => {
  const f = e.target.files[0]; if(!f) return;
  document.getElementById('npPreview').src = URL.createObjectURL(f);
  document.getElementById('npImgName').textContent = f.name;
};
document.getElementById('newPostForm').addEventListener('submit', async function(e){
  e.preventDefault(); const btn = document.getElementById('npSubmit'); btn.disabled = true;
  try{
    const d = await apiForm('/api/add_post.php', new FormData(this));
    if(d.status === 'ok'){
      closeModal('newPostModal'); this.reset();
      document.getElementById('npPreview').src = 'https://placehold.co/72x72/EEE8DE/7A7067?text=+';
      document.getElementById('npImgName').textContent = 'Bấm để chọn ảnh từ máy (JPG, PNG, WEBP – tối đa 5MB)';
      showToast(d.message, 'success'); loadPosts(); loadMine();
    } else showToast(d.message || 'Lỗi', 'error');
  }catch{ showToast('Lỗi kết nối', 'error'); }
  btn.disabled = false;
});
