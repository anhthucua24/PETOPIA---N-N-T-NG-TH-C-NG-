/* =====================================================================
   [UI] icons.js – Bộ icon nét mảnh (line icon, bo tròn, 1 màu theo chữ)
   Cách dùng:
     - Trong JS : gi('paw')              -> trả về chuỗi <svg>
     - Trong PHP: <i data-gi="paw"></i>  -> tự đổi thành icon khi trang tải
   Màu icon = màu chữ của khung chứa (currentColor)
   ===================================================================== */

// ===== [CHỨC NĂNG] Định nghĩa nét vẽ icon (khung 24x24) =====
const GI_SHAPES = {
  // --- Nhu cầu người dùng ---
  building:    'M4 21V5a1 1 0 0 1 1-1h9a1 1 0 0 1 1 1v16M15 10h4a1 1 0 0 1 1 1v10M3 21h18M8 8h3M8 12h3M8 16h3',
  baby:        'M12 4a3.5 3.5 0 1 1 0 7 3.5 3.5 0 0 1 0-7zM5 20c.6-3.6 3.4-6 7-6s6.4 2.4 7 6',
  clock:       'M15.5 3.7A9 9 0 1 0 20.4 8.8M12 7.5V12h4',
  bolt:        'M13 3 5 13.5h6L10 21l8-10.5h-6z',
  paw:         'M8.5 5.3a1.8 1.8 0 1 1 0 3.6 1.8 1.8 0 0 1 0-3.6zM15.5 5.3a1.8 1.8 0 1 1 0 3.6 1.8 1.8 0 0 1 0-3.6zM5 10.2a1.6 1.6 0 1 1 0 3.2 1.6 1.6 0 0 1 0-3.2zM19 10.2a1.6 1.6 0 1 1 0 3.2 1.6 1.6 0 0 1 0-3.2zM12 12c2.8 0 5.5 3.6 5.5 5.8 0 1.4-1.1 2.2-2.4 2.2-1.2 0-2-.6-3.1-.6s-1.9.6-3.1.6c-1.3 0-2.4-.8-2.4-2.2C6.5 15.6 9.2 12 12 12z',
  syringe:     'M14 4l6 6M17 7l-9 9-3-3 9-9M9 11l1.5 1.5M11.5 8.5 13 10M6.5 14.5 3 18',
  // --- Khảo sát / thông tin ---
  home:        'M3 11 12 4l9 7M5.5 9.5V20h13V9.5M10 20v-5h4v5',
  cap:         'M2 9.5 12 5l10 4.5-10 4.5zM6 11.5V16c0 1.5 2.7 3 6 3s6-1.5 6-3v-4.5M22 9.5V14',
  pin:         'M12 21s-6.5-6.2-6.5-11.5a6.5 6.5 0 0 1 13 0C18.5 14.8 12 21 12 21zM12 7.5a2 2 0 1 1 0 4 2 2 0 0 1 0-4z',
  // --- Quản trị ---
  dashboard:   'M12 21a9 9 0 1 1 0-18 9 9 0 0 1 0 18zM12 13l4-4M7.5 16.5h9',
  file:        'M6 3h9l4 4v13a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zM15 3v4h4M8.5 12h7M8.5 16h4',
  chat:        'M4 5h16a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1h-8l-3.5 3.5V16H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1zM8.7 10l-.6 1.5M12.3 10l-.6 1.5M15.9 10l-.6 1.5',
  users:       'M9 4a3.2 3.2 0 1 1 0 6.4A3.2 3.2 0 0 1 9 4zM3 19.5c.5-3.2 2.9-5.2 6-5.2s5.5 2 6 5.2M16 4.3a3 3 0 0 1 0 5.8M18 14.5c1.7.6 2.8 2.4 3 5',
  // --- Trang chủ: lý do chọn Petopia ---
  shield:      'M12 3 5 6v5.5c0 4.3 2.9 7.8 7 9.5 4.1-1.7 7-5.2 7-9.5V6zM9 12l2 2 4-4',
  checkCircle: 'M12 3a9 9 0 1 1 0 18 9 9 0 0 1 0-18zM8.5 12l2.5 2.5 4.5-5',
  team:        'M9 4a3.2 3.2 0 1 1 0 6.4A3.2 3.2 0 0 1 9 4zM3 19.5c.5-3.2 2.9-5.2 6-5.2s5.5 2 6 5.2M16 4.3a3 3 0 0 1 0 5.8M18 14.5c1.7.6 2.8 2.4 3 5',
  smile:       'M12 3a9 9 0 1 1 0 18 9 9 0 0 1 0-18zM8.5 14.5c.9 1.2 2.1 1.8 3.5 1.8s2.6-.6 3.5-1.8M9 9.5v1M15 9.5v1',
  search:      'M11 4a7 7 0 1 1 0 14 7 7 0 0 1 0-14zM16 16l4.5 4.5',
  // --- Thao tác ---
  x:           'M6 6l12 12M18 6 6 18',
  check:       'M4.5 12.5l4.5 4.5L19.5 7',
  arrow:       'M5 12h14M13 6l6 6-6 6',
  plus:        'M12 5v14M5 12h14',
  warn:        'M12 4 2.5 20h19zM12 10v4.5M12 17.2v.3',
  edit:        'M11 4H5a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-6M17.5 3.5l3 3L12 15l-3.5.5.5-3.5zM7.5 8H11',
  trash:       'M4 6.5h16M9 6.5V4h6v2.5M6 6.5l1 13.5h10l1-13.5M10 10.5v6M14 10.5v6',
  logout:      'M10 4H5a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h5M15 8l4 4-4 4M19 12H9',
  grid:        'M4 4h6v6H4zM14 4h6v6h-6zM4 14h6v6H4zM14 14h6v6h-6z',
  list:        'M9 6h11M9 12h11M9 18h11M4.5 6h.5M4.5 12h.5M4.5 18h.5',
  heart:       'M12 20s-7.5-4.7-7.5-10.2A4.3 4.3 0 0 1 12 7.2a4.3 4.3 0 0 1 7.5 2.6C19.5 15.3 12 20 12 20z',
  bar:         'M4 20h16M7 16.5V13M11 16.5V9M15 16.5v-5M19 16.5V6',
  lock:        'M7 11V8a5 5 0 0 1 10 0v3M5.5 11h13a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-13a1 1 0 0 1-1-1v-8a1 1 0 0 1 1-1zM12 15v2',
  send:        'M21 3 3 10.5l7 2.5 2.5 7zM21 3 10 13',
};

// ===== [CHỨC NĂNG] Tạo icon =====
function gi(name) {
  const d = GI_SHAPES[name];
  if (!d) return '';
  return `<svg class="gi gi-${name}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="${d}" fill="none"/></svg>`;
}

// ===== [CHỨC NĂNG] Đổi các thẻ <i data-gi="..."> trong HTML thành icon =====
document.querySelectorAll('[data-gi]').forEach(el => { el.outerHTML = gi(el.dataset.gi); });
