/* [MAIN] core/api.js – PETOPIA
   Hằng số, helper gọi API, nhãn hiển thị và trạng thái đăng nhập (dùng chung mọi trang).
   Nạp TRƯỚC js/ui/components.js và js/pages/*.js (script thường, không phải module). */

// ===== [CHỨC NĂNG] Cấu hình API =====
const API = 'http://localhost:8080';

// ===== [CHỨC NĂNG] Helper: escape HTML, URL ảnh, gọi API =====
/* ── Helpers ── */
const esc = s => String(s ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
// Ảnh: tên file trong C:\PETOPIA\images -> qua backend/img.php; link http giữ nguyên
const imgUrl = f => !f ? 'https://placehold.co/400x300/F0E6D3/8A7968?text=Petopia' : /^https?:\/\//.test(f) ? f : `${API}/img.php?f=${encodeURIComponent(f)}`;
const apiGet  = (url) => fetch(API + url, {credentials:'include'}).then(r => r.json());
const apiPost = (url, body) => fetch(API + url, {method:'POST', credentials:'include', headers:{'Content-Type':'application/json'}, body:JSON.stringify(body)}).then(r => r.json());
const apiForm = (url, formData) => fetch(API + url, {method:'POST', credentials:'include', body:formData}).then(r => r.json());

// ===== [CHỨC NĂNG] Nhãn hiển thị (nhu cầu, kích thước, tính cách, vai trò, chuyên mục) =====
/* ── Nhãn hiển thị ── */
const NEEDS = [
  {key:'apartment',  icon:gi('building'), title:'Sống ở chung cư',       sub:'Nhỏ gọn, ít ồn'},
  {key:'kids',       icon:gi('baby'), title:'Nhà có trẻ nhỏ',        sub:'Hiền, kiên nhẫn với bé'},
  {key:'senior',     icon:gi('clock'), title:'Ít thời gian / lớn tuổi', sub:'Điềm tĩnh, ít vận động'},
  {key:'active',     icon:gi('bolt'), title:'Thích vận động',         sub:'Năng lượng dồi dào'},
  {key:'other_pets', icon:gi('paw'), title:'Đã có thú cưng khác',   sub:'Hòa đồng với chó mèo'},
  {key:'ready',      icon:gi('syringe'), title:'Sẵn sàng về nhà',       sub:'Đã tiêm & triệt sản'},
];
const SIZE   = {small:'Nhỏ', medium:'Vừa', large:'Lớn'};
const ENERGY = {low:'Điềm tĩnh', medium:'Vừa phải', high:'Năng động'};
const ROLE   = {admin:'Admin', staff:'Nhân viên', customer:'Thành viên'};
const CATEGORY = {story:'Câu chuyện', tips:'Mẹo chăm sóc', rescue:'Cứu hộ', question:'Hỏi đáp'};
const ageText = a => a < 1 ? `${Math.round(a*12)} tháng` : `${+a} tuổi`;

// ===== [CHỨC NĂNG] Đăng nhập / đăng xuất =====
/* ── Đăng nhập: ME = người đang đăng nhập (null nếu chưa) ── */
let ME = null;
const authReady = apiGet('/auth/me.php').then(r => (ME = r.user || null)).catch(() => null);
const isStaff = () => ME && (ME.role === 'admin' || ME.role === 'staff');
function loginUrl(){ return 'login.php?next=' + encodeURIComponent(location.pathname.split('/').pop() + location.search); }
async function logout(){ try{ await apiGet('/auth/logout.php'); }catch{} location.href = 'index.php'; }
// Lưu ý: authReady.then(renderNavAuth) nằm trong js/ui/components.js (nơi định nghĩa renderNavAuth)

// ===== [CHỨC NĂNG] Định dạng thời gian =====
/* ── Format time ── */
function fmtTime(ts){
  if(!ts)return''
  const d=new Date(String(ts).replace(' ','T'))
  return d.toLocaleDateString('vi-VN')+' · '+d.toLocaleTimeString('vi-VN',{hour:'2-digit',minute:'2-digit'})
}
