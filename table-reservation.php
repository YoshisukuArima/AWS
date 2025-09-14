<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Đặt bàn — Nhà hàng</title>
  <style>
    :root{--accent:#0d9488;--muted:#6b7280;--bg:#f8fafc}
    *{box-sizing:border-box}
    body{font-family:Inter,system-ui,Segoe UI,Roboto,'Helvetica Neue',Arial;line-height:1.4;margin:0;background:var(--bg);color:#0f172a}
    .container{max-width:920px;margin:28px auto;padding:20px}
    header{display:flex;align-items:center;gap:16px;margin-bottom:18px}
    .logo{width:64px;height:64px;border-radius:12px;background:linear-gradient(135deg,var(--accent),#06b6d4);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700}
    h1{font-size:20px;margin:0}
    p.lead{color:var(--muted);margin:6px 0 24px}

    .card{background:#fff;border-radius:12px;box-shadow:0 6px 18px rgba(8,15,26,0.06);padding:18px}
    form .grid{display:grid;grid-template-columns:1fr 1fr;gap:12px}
    label{display:block;font-size:13px;color:#111827;margin-bottom:6px}
    input[type=text], input[type=tel], input[type=email], input[type=date], input[type=time], select, textarea{width:100%;padding:10px;border:1px solid #e6e9ee;border-radius:8px;font-size:14px}
    textarea{min-height:90px;resize:vertical}
    .full{grid-column:1/-1}
    .actions{display:flex;gap:10px;align-items:center;justify-content:flex-end;margin-top:14px}
    button{background:var(--accent);border:none;color:#fff;padding:10px 14px;border-radius:10px;font-weight:600;cursor:pointer}
    button.secondary{background:#fff;color:var(--accent);border:1px solid #e6e9ee}
    .note{font-size:13px;color:var(--muted)}

    .summary{margin-top:18px;padding:14px;border-radius:10px;background:#ecfeff;border:1px solid rgba(6,182,212,0.12)}
    .summary h3{margin:0 0 8px}
    .row {display:flex;gap:12px;flex-wrap:wrap}
    .chip{background:#fff;padding:6px 10px;border-radius:999px;border:1px solid #e6e9ee;font-size:13px}

    @media (max-width:720px){.grid{grid-template-columns:1fr}.actions{justify-content:stretch;flex-direction:column}button{width:100%}}
  </style>
</head>
<body>
  <div class="container">
    <header>
      <div class="logo">NH</div>
      <div>
        <h1>Đặt bàn — Nhà hàng Minh</h1>
        <p class="lead">Chọn ngày, giờ và thông tin của bạn để chúng tôi chuẩn bị chỗ ngồi tốt nhất.</p>
      </div>
    </header>

    <div class="card">
      <form id="bookingForm" novalidate>
        <div class="grid">
          <div>
            <label for="fullname">Họ và tên</label>
            <input id="fullname" name="fullname" type="text" placeholder="Nguyễn Văn A" required>
          </div>
          <div>
            <label for="phone">Số điện thoại</label>
            <input id="phone" name="phone" type="tel" placeholder="+84 912 345 678" required>
          </div>

          <div>
            <label for="email">Email (tùy chọn)</label>
            <input id="email" name="email" type="email" placeholder="email@domain.com">
          </div>
          <div>
            <label for="party">Số lượng khách</label>
            <select id="party" name="party" required>
              <option value="">Chọn số lượng</option>
              <option>1</option>
              <option>2</option>
              <option>3</option>
              <option>4</option>
              <option>5</option>
              <option>6</option>
              <option>7</option>
              <option>8+</option>
            </select>
          </div>

          <div>
            <label for="date">Ngày</label>
            <input id="date" name="date" type="date" required>
          </div>
          <div>
            <label for="time">Giờ</label>
            <input id="time" name="time" type="time" required>
          </div>

          <div>
            <label for="seating">Yêu cầu chỗ ngồi</label>
            <select id="seating" name="seating">
              <option value="">Không yêu cầu</option>
              <option>Gần cửa sổ</option>
              <option>Bàn riêng</option>
              <option>Sân thượng</option>
              <option>Gần bếp</option>
            </select>
          </div>
          <div>
            <label for="occasion">Dịp</label>
            <select id="occasion" name="occasion">
              <option value="">Không</option>
              <option>Sinh nhật</option>
              <option>Kỷ niệm</option>
              <option>Họp nhóm</option>
            </select>
          </div>

          <div class="full">
            <label for="note">Ghi chú / Yêu cầu đặc biệt</label>
            <textarea id="note" name="note" placeholder="Ví dụ: cần ghế cho trẻ em, dị ứng thực phẩm..."></textarea>
          </div>

          <div class="full">
            <label for="promo">Mã khuyến mãi (nếu có)</label>
            <input id="promo" name="promo" type="text" placeholder="PROMO2025">
          </div>
        </div>

        <div class="actions">
          <button type="button" id="saveBtn" class="secondary">Lưu nháp</button>
          <button type="submit" id="submitBtn">Xác nhận đặt bàn</button>
        </div>

        <p class="note">Chúng tôi sẽ gọi xác nhận trong vòng 30 phút (hoặc gửi email nếu bạn cung cấp).</p>
      </form>

      <div id="result" class="summary" style="display:none" aria-live="polite"></div>
    </div>

    <div style="margin-top:12px;text-align:center;color:var(--muted);font-size:13px">Bạn có thể xuất danh sách đặt bàn đã lưu hoặc kết nối với API của riêng bạn.</div>

  </div>

  <script>
    // Thiết lập ngày tối thiểu là hôm nay
    (function setMinDate(){
      const dateIn = document.getElementById('date');
      const today = new Date();
      const yyyy = today.getFullYear();
      const mm = String(today.getMonth()+1).padStart(2,'0');
      const dd = String(today.getDate()).padStart(2,'0');
      dateIn.min = `${yyyy}-${mm}-${dd}`;
    })();

    const form = document.getElementById('bookingForm');
    const result = document.getElementById('result');

    function validatePhone(v){
      // đơn giản: chỉ chấp nhận 9-15 ký tự số, có thể có + và khoảng trắng
      return /^\+?[0-9\s]{9,15}$/.test(v.trim());
    }

    function showSummary(data){
      result.style.display='block';
      result.innerHTML = `
        <h3>Đặt bàn đã lưu</h3>
        <div class="row">
          <div class="chip"><strong>Tên:</strong> ${escapeHtml(data.fullname)}</div>
          <div class="chip"><strong>SDT:</strong> ${escapeHtml(data.phone)}</div>
          <div class="chip"><strong>Khách:</strong> ${escapeHtml(data.party)}</div>
          <div class="chip"><strong>Ngày:</strong> ${escapeHtml(data.date)} ${escapeHtml(data.time)}</div>
        </div>
        <p style="margin-top:10px">Ghi chú: ${escapeHtml(data.note || '-')}</p>
        <div style="margin-top:8px;display:flex;gap:8px;flex-wrap:wrap">
          <button id="exportBtn" class="secondary">Xuất CSV</button>
          <button id="downloadIcs" class="secondary">Tạo file lịch (.ics)</button>
        </div>
      `;

      document.getElementById('exportBtn').addEventListener('click', ()=> exportCSV([data]));
      document.getElementById('downloadIcs').addEventListener('click', ()=> downloadICS(data));
    }

    function escapeHtml(s){ if(!s) return ''; return String(s).replace(/[&<>\"']/g, function(c){return {'&':'&amp;','<':'&lt;','>':'&gt;','\"':'&quot;','\'':'&#39;'}[c]}); }

    form.addEventListener('submit', function(e){
      e.preventDefault();
      const data = Object.fromEntries(new FormData(form).entries());

      // validation
      if(!data.fullname.trim()){alert('Vui lòng nhập họ tên');return}
      if(!validatePhone(data.phone)){alert('Số điện thoại không hợp lệ');return}
      if(!data.party){alert('Chọn số lượng khách');return}
      if(!data.date){alert('Chọn ngày');return}
      if(!data.time){alert('Chọn giờ');return}

      // Hiển thị tóm tắt
      showSummary(data);

      // Lưu vào LocalStorage (demo)
      const saved = JSON.parse(localStorage.getItem('bookings')||'[]');
      saved.push(Object.assign({created: new Date().toISOString()}, data));
      localStorage.setItem('bookings', JSON.stringify(saved));

      // Gửi tới API (đoạn này là ví dụ — thay /api/book bằng endpoint thực tế)
      fetch('/api/book', {
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body: JSON.stringify(data)
      }).then(r=>{
        if(!r.ok) throw new Error('Không gửi được (đây là demo)');
        return r.json();
      }).then(resp=>{
        console.log('Server response', resp);
      }).catch(err=>{
        // Đây không phải lỗi nghiêm trọng — backend có thể chưa có
        console.warn(err.message);
      });
    });

    document.getElementById('saveBtn').addEventListener('click', ()=>{
      const data = Object.fromEntries(new FormData(form).entries());
      localStorage.setItem('booking_draft', JSON.stringify(data));
      alert('Đã lưu nháp vào trình duyệt');
    });

    // Nếu có nháp, gợi ý nạp
    window.addEventListener('load', ()=>{
      const draft = localStorage.getItem('booking_draft');
      if(draft){
        if(confirm('Tìm thấy nháp đặt bàn. Nạp vào biểu mẫu?')){
          const obj = JSON.parse(draft);
          for(const k in obj){ if(form.elements[k]) form.elements[k].value = obj[k]; }
        }
      }
    });

    function exportCSV(items){
      if(!items || !items.length) return alert('Không có dữ liệu để xuất');
      const keys = Object.keys(items[0]);
      const lines = [keys.join(',')].concat(items.map(it=>keys.map(k=>`"${String(it[k]||'').replace(/"/g,'""')}"`).join(',')));
      const blob = new Blob([lines.join('\n')], {type:'text/csv;charset=utf-8;'});
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a'); a.href = url; a.download = 'bookings.csv'; document.body.appendChild(a); a.click(); a.remove(); URL.revokeObjectURL(url);
    }

    function downloadICS(data){
      // Tạo file .ics đơn giản
      const dt = data.date + 'T' + data.time.replace(':','') + '00';
      const uid = 'booking-' + (Date.now());
      const content = [
        'BEGIN:VCALENDAR',
        'VERSION:2.0',
        'CALSCALE:GREGORIAN',
        'BEGIN:VEVENT',
        `UID:${uid}`,
        `DTSTAMP:${new Date().toISOString().replace(/[-:]/g,'').split('.')[0]}Z`,
        `DTSTART:${dt}`,
        `SUMMARY:Đặt bàn - ${data.fullname}`,
        `DESCRIPTION:Khách ${data.fullname} - ${data.phone}\\nGhi chú: ${data.note || '-'} `,
        'END:VEVENT',
        'END:VCALENDAR'
      ].join('\r\n');

      const blob = new Blob([content], {type:'text/calendar;charset=utf-8;'});
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a'); a.href = url; a.download = 'booking.ics'; document.body.appendChild(a); a.click(); a.remove(); URL.revokeObjectURL(url);
    }
  </script>
</body>
</html>
