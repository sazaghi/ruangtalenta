<x-app-layout>
@push("styles")
  <style>
    * { font-family: 'Inter', sans-serif; box-sizing: border-box; }
    body {
      margin: 0;
      background: #C0C2C9 !important;
      color: #000;
    }

    .title {
      font-size: 24px;
      font-weight: 700;
      color: white;
    }
    .search-box {
      margin-top: 10px;
      display: flex;
      align-items: center;
      background: white;
      border-radius: 20px;
      padding: 5px 15px;
      width: 300px;
    }
    .search-box svg {
      width: 18px;
      height: 18px;
      margin-right: 10px;
      stroke: #888;
    }
    .search-box input {
      border: none;
      outline: none;
      width: 100%;
    }
    .card {
      background: white;
      width: 600px;
      margin: auto;
      padding: 30px;
      border-radius: 10px;
      margin-top: 40px;
    }
    .card h2 {
      font-size: 18px;
      font-weight: 700;
      text-align: center;
      margin-bottom: 25px;
    }
    .form-group {
      margin-bottom: 18px;
    }
    .form-label {
      font-weight: 600;
      margin: 10px 0 8px 0;
      display: flex;
      align-items: center;
      font-size: 14px;
    }
    .form-label svg {
      width: 16px;
      height: 16px;
      margin-right: 6px;
      stroke: #000;
      fill: none;
    }
    input, select, textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 14px;
    }
    textarea {
      resize: vertical;
    }
    .inline-group {
      display: flex;
      gap: 10px;
    }
    .inline-group input {
      flex: 1;
    }
    .status-actions-area {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      margin-top: 25px;
      gap: 10px;
    }
    .status-container {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
    }
    .status-label {
      display: flex;
      align-items: center;
      font-weight: 600;
      margin-bottom: 6px;
      font-size: 14px;
    }
    .status-label svg {
      width: 16px;
      height: 16px;
      margin-right: 5px;
      stroke: #000;
      fill: none;
    }
    .status-btn {
      background: #E1E1E1;
      border: none;
      padding: 6px 12px;
      border-radius: 6px;
      font-weight: 600;
    }
    .btn-submit {
      background: #3B63E3;
      color: white;
      border: none;
      padding: 8px 16px;
      border-radius: 6px;
      font-size: 13px;
      font-weight: 500;
      cursor: pointer;
    }
    .btn-cancel {
      background: transparent;
      border: 1px solid #aaa;
      color: #000;
      font-weight: 500;
      padding: 8px 14px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 14px;
    }
    .actions {
      display: flex;
      gap: 10px;
    }
  </style>
@endpush

<body>
  <div class="top-bar">
    <div class="title">Candidates</div>
    <div class="search-box">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
      </svg>
      <input type="text" placeholder="Search">
    </div>
  </div>
  
  <div class="card">
    <h2>Tambahkan Undangan Untuk Kandidat</h2>
    <div class="form-group">
      <label class="form-label">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 16 16">
          <path d="M5 8a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5A.5.5 0 0 1 5 8zm0 2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
          <path d="M3 2.5a.5.5 0 0 1 .5-.5H14a.5.5 0 0 1 .5.5v11a.5.5 0 0 1-.5.5H3.5a.5.5 0 0 1-.5-.5v-11zM14 1H3.5A1.5 1.5 0 0 0 2 2.5v11A1.5 1.5 0 0 0 3.5 15H14a1 1 0 0 0 1-1v-11a1 1 0 0 0-1-1z"/>
        </svg>
        Jenis Undangan
      </label>
      <select>
        <option selected>Tes</option>
        <option>Interview</option>
      </select>
    </div>

    <div class="form-group">
      <label class="form-label">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
          <path d="M8 2v4M16 2v4M3 10h18M5 4h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"/>
        </svg>          
        Tanggal & Waktu
      </label>
      <div class="inline-group">
        <input type="date" value="2025-04-16">
        <input type="time" value="10:00">
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
          <path d="M2 12h20M12 2a10 10 0 0 0 0 20a10 10 0 0 0 0-20zm0 0c2.5 2 4 5.5 4 10s-1.5 8-4 10m0 0c-2.5-2-4-5.5-4-10s1.5-8 4-10"/>
        </svg>
        Metode
      </label>
      <select>
        <option selected>Online</option>
        <option>Offline</option>
      </select>
      <input type="text" placeholder="https://zoom.us/...">
    </div>

    <div class="form-group">
      <label class="form-label">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
          <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
          <path d="M14 2v6h6"/>
        </svg>
        Catatan Tambahan
      </label>
      <textarea>Silakan hadir 10 menit lebih awal</textarea>
    </div>

    <div class="status-actions-area">
      <div class="status-container">
        <div class="status-label">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path d="M12 20h9"/>
            <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/>
          </svg>
          Status
        </div>
        <button class="status-btn">Dijadwalkan</button>
      </div>
      <div class="actions">
        <button class="btn-cancel">Batal</button>
        <button class="btn-submit">Kirim Undangan</button>
      </div>
    </div>
  </div>
</body>
</x-app-layout>
