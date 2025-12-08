    <!-- 👥 HALAMAN ANGGOTA (view-only, data dari DB) -->
    <div id="anggota">
        <button class="back-btn" onclick="showHome()">⬅ Kembali</button>
        <h1>📊 Tabel Pembayaran Uang Kas</h1>
        <table id="anggotaTable">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Minggu 1</th>
                <th>Minggu 2</th>
                <th>Minggu 3</th>
                <th>Minggu 4</th>
            </tr>
            <?php foreach ($users as $index => $u): ?>
            <tr>
                <td><?php echo $index + 1; ?></td>
                <td class="editable-name" data-id="<?php echo (int)$u['id']; ?>"><?php echo htmlspecialchars($u['name']); ?></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
        min-height: 100vh;
        padding: 20px;
        background: linear-gradient(135deg, #43085d, #961ccb);
    }

    #profilePage.show, #profilePage[style*="display:flex"] { display: flex; flex-direction: column; align-items: center; justify-content: center; }

    .profile-card {
        background: white;
        border-radius: 15px;
        padding: 40px;
        width: 100%;
        max-width: 500px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.3);
        text-align: center;
    }

    .profile-card .avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, #43085d, #961ccb);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 50px;
        margin: 0 auto 20px;
        border: 4px solid #522780;
    }

    .profile-card .user-name { font-size: 28px; font-weight: bold; color: #333; margin: 10px 0; }
    .profile-card .user-role { font-size: 16px; color: #888; margin: 5px 0; }
    .profile-card .user-email { font-size: 14px; color: #999; margin: 10px 0 10px 0; word-break: break-word; }
    .profile-card .info-section { text-align: left; margin: 12px 0; }
    .profile-card .info-label { font-size: 12px; color: #888; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px; }
    .profile-card .info-value { font-size: 16px; color: #333; word-break: break-word; }
    .profile-card .btn-group { display:flex; gap:10px; margin-top:18px; }
    .profile-card .btn-back { background:#f0f0f0; color:#333; padding:10px 18px; border-radius:8px; border:none; }
    .profile-card .btn-logout { background:#e53935; color:white; padding:10px 18px; border-radius:8px; border:none; }
</style>
</head>

<body>

    <!-- 🏠 HALAMAN UTAMA -->      
    <div id="home">
        <header class="header">  <!-- Alma -->
            <div class="profile" onclick="openProfilePage()">👤</div>       
            <div class="logo"> 
                <h1>PayClass</h1>
                <p>1KA25</p>
            </div>
            <div class="status">
                <p class="p2">Status Kas</p>
                <div class="badge">LUNAS</div>
            </div>
        </header>
        <div class="container">
            <div class="box" id="saldo">Saldo Terkini: <span id="saldoValue">Rp. 0</span>
                <div class="small">Kenaikan: <span id="kenaikanValue">Rp. 0</span></div>
            </div>
            <div class="box" id="boxPengeluaranBulanan">Pengeluaran Bulan Ini: <span id="pengeluaranValue">Rp. 0</span></div>
            <div class="box" id="pemasukan">Pemasukan Bulan ini: <span id="pemasukanValue">Rp. 0</span></div>
        </div>

        <div class="button-container">
            <button onclick="goToPembayaran()">
                <div class="text3">PEMBAYARAN</div>
            </button>
            <button onclick="showPengeluaran()">
                <div class="text4">PENGELUARAN</div>
            </button>
            <button onclick="window.location.href='pemasukan_bulanan_user.php'">
                <div class="text5">PEMASUKAN BULANAN</div>
            </button>
            <button onclick="showAnggota()">
                <div class="text3">ANGGOTA</div>
            </button>
        </div>
    </div>

    <!-- QR Modal -->
    <div id="qrModal" class="qr-modal" aria-hidden="true">
        <div class="qr-box" role="dialog" aria-modal="true" aria-labelledby="qrTitle">
            <div class="title" id="qrTitle">QR PEMBAYARAN</div>
            <div class="subtitle">Silakan scan QR ini untuk membayar KAS</div>
            <img id="qrisImg" src="qris.jpg" alt="QR Pembayaran" onerror="this.style.opacity=0.6;">
            <div class="note">Scan QR ini menggunakan aplikasi e-wallet Anda</div>
            <div class="buttons">
                <button class="btn-back" onclick="closeQRModal()">⬅ Tutup</button>
                <button class="btn-download" onclick="downloadQR()">⬇ Download</button>
            </div>
        </div>
    </div>

    <!-- 👤 HALAMAN PROFILE -->
    <div id="profilePage" style="display:none; min-height:100vh; padding:20px; background: linear-gradient(135deg, #43085d, #961ccb);">
        <div class="profile-card" style="background:white; border-radius:15px; padding:40px; max-width:500px; margin:0 auto; text-align:center;">
            <div class="avatar">👤</div>
            <div class="user-name"><?php echo htmlspecialchars($user_name); ?></div>
            <div class="user-role">User</div>
            <div class="user-email"><?php echo htmlspecialchars($user_email); ?></div>
            
            <div class="divider" style="height:1px; background:#e0e0e0; margin:20px 0;"></div>
            
            <div class="info-section">
                <div class="info-label">Kelas</div>
                <div class="info-value"><?php echo htmlspecialchars($user_class); ?></div>
            </div>
            
            <div class="info-section">
                <div class="info-label">Status</div>
                <div class="info-value">User</div>
            </div>
            
            <?php if (!empty($user_phone)): ?>
            <div class="info-section">
                <div class="info-label">No. Telepon</div>
                <div class="info-value"><?php echo htmlspecialchars($user_phone); ?></div>
            </div>
            <?php endif; ?>
            <div style="margin-top:18px; display:flex; gap:10px; justify-content:center;">
                <button class="btn-back" onclick="closeProfilePage()">⬅ Kembali</button>
                <button class="btn-logout" onclick="logout()">🚪 Logout</button>
            </div>
        </div>
    </div>

    <!-- 👥 HALAMAN ANGGOTA -->
    <div id="anggota">
        <button class="back-btn" onclick="showHome()">⬅ Kembali</button>
        <h1>📊 Tabel Pembayaran Uang Kas</h1>
        <table id="anggotaTable">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Minggu 1</th>
                <th>Minggu 2</th>
                <th>Minggu 3</th>
                <th>Minggu 4</th>
            </tr>
            <tr>
                <td>1</td>
                <td>ABI SATYA ERLANGGA</td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled>
            </tr>
            <tr>
                <td>2</td>
                <td>AHMEDO DECO ARDIANO</td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled>
            </tr>
            <tr>
                <td>3</td>
                <td>ALMIRA BRYNA ROSEMYDAR</td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled>
            </tr>
            <tr>
                <td>4</td>
                <td>ANANDA DWIKI PRAYOGO</td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled>
            </tr>
            <tr>
                <td>5</td>
                <td>ARYA SATYA PRADIPA</td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled>
            </tr>
            <tr>
                <td>6</td>
                <td>DANAR EKA MAHESWARA</td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled>
            </tr>
            <tr>
                <td>7</td>
                <td>DESKA BINTANG EKA HARPUTRA</td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled>
            </tr>
            <tr>
                <td>8</td>
                <td>DEVINA RESTI FAUZI</td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled>
            </tr>
            <tr>
                <td>9</td>
                <td>ELANG TAMA SAMSOMA</td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled>
            </tr>
            <tr>
                <td>10</td>
                <td>FARHANNUDIN</td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled>
            </tr>
            <tr>
                <td>11</td>
                <td>FATHIN DZIKRA BASKARA</td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled>
            </tr>
            <tr>
                <td>12</td>
                <td>GALIH PRASETIO</td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled>
            </tr>
            <tr>
                <td>13</td>
                <td>GUSTIARA DAVINA PUTERI</td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled>
            </tr>
            <tr>
                <td>14</td>
                <td>HEKHA RAHMAT RAMADHAN</td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled>
            </tr>
            <tr>
                <td>15</td>
                <td>ILHAM RADITE PAMUNGKAS</td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled>
            </tr>
            <tr>
                <td>16</td>
                <td>MAULANA SYAHRIAN PRASETIA</td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled>
            </tr>
            <tr>
                <td>17</td>
                <td>MUHAMAD AYIP</td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled>
            </tr>
            <tr>
                <td>18</td>
                <td>MUHAMMAD ADELARD NAWWAF</td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled>
            </tr>
            <tr>
                <td>19</td>
                <td>MUHAMMAD FATHIR ADITYA</td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled>
            </tr>
            <tr>
                <td>20</td>
                <td>MUHAMMAD IRFAN MAULANA</td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled>
            </tr>
            <tr>
                <td>21</td>
                <td>MUHAMMAD RAFLY SYAHPUTRA</td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled>
            </tr>
            <tr>
                <td>22</td>
                <td>MUHAMMAD ZIDANE FEBRIAN</td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled>
            </tr>
            <tr>
                <td>23</td>
                <td>NADIA PUTRI SALSABILA</td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled>
            </tr>
            <tr>
                <td>24</td>
                <td>NURIN RAMADHANI RAWUHADI</td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled>
            </tr>
            <tr>
                <td>25</td>
                <td>OKTASYAH BINTANG RAMADHAN</td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled>
            </tr>
            <tr>
                <td>26</td>
                <td>RAFIE RESTU RAMADHANI</td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled>
            </tr>
            <tr>
                <td>27</td>
                <td>RAFLI</td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled>
            </tr>
            <tr>
                <td>28</td>
                <td>RANGGA PASYA YUANZA</td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled>
            </tr>
            <tr>
                <td>29</td>
                <td>REISYA AHMAD PRIYATAMA</td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled>
            </tr>
            <tr>
                <td>30</td>
                <td>RYANDIKA ZAEROBY</td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled>
            </tr>
            <tr>
                <td>31</td>
                <td>SHINTA AMELINDA SALSABILA</td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled>
            </tr>
            <tr>
                <td>32</td>
                <td>STEVEN JOSHUA WIDJAYA</td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled>
            </tr>
            <tr>
                <td>33</td>
                <td>TASYA AMELIA</td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled>
            </tr>
            <tr>
                <td>34</td>
                <td>VALLEN SALVADORE SILABAN</td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled>
            </tr>
            <tr>
                <td>35</td>
                <td>WINNI ASSYIFA</td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled></td>
                <td><input type="date" disabled><input type="checkbox" disabled>
            </tr>
        </table>
    </div>

    <!-- 📉 HALAMAN PENGELUARAN -->
    <div id="pengeluaran">
        <button class="back-btn" onclick="showHome()">⬅ Kembali</button>
        <h1>📉 Tabel Pengeluaran Uang Kas</h1>
        <table id="pengeluaranTable">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Pengeluaran</th>
                <th>Biaya (Rp)</th>
            </tr>
            <tr>
                <td>1</td>
                <td><input type="date" disabled></td>
                <td><input type="text" placeholder="Contoh: Beli spidol" disabled></td>
                <td><input type="text" placeholder="25000" disabled></td>
            </tr>
        </table>
        <button onclick="tambahBaris()" disabled>+ Tambah Baris</button>
        <div class="total" id="totalBiaya">Total Pengeluaran: Rp 0</div>
    </div>

    <script>
        let totalPembayaran = 0;
        let totalPengeluaran = 0;

        function goToPembayaran() {
            const anggotaEl = document.getElementById('anggota');
            const pengeluaranEl = document.getElementById('pengeluaran');
            let tab = 'home';
            if (anggotaEl && getComputedStyle(anggotaEl).display !== 'none') tab = 'anggota';
            else if (pengeluaranEl && getComputedStyle(pengeluaranEl).display !== 'none') tab = 'pengeluaran';
            window.location.href = 'pembayaran.php?tab=' + encodeURIComponent(tab) + '&from=user';
        }

        document.addEventListener("DOMContentLoaded", function () {
            muatData();
            const params = new URLSearchParams(window.location.search);
            const tab = params.get('tab');
            if (tab === 'anggota') showAnggota();
            else if (tab === 'pengeluaran') showPengeluaran();
            else showHome();
        });

        function showAnggota() { document.getElementById("home").style.display = "none"; document.getElementById("anggota").style.display = "block"; document.getElementById("pengeluaran").style.display = "none"; }
        function showPengeluaran() { document.getElementById("home").style.display = "none"; document.getElementById("anggota").style.display = "none"; document.getElementById("pengeluaran").style.display = "block"; }
        function showHome() { document.getElementById("anggota").style.display = "none"; document.getElementById("pengeluaran").style.display = "none"; document.getElementById("home").style.display = "block"; updateSaldo(); }

        // ✅ Hitung saldo dari checkbox
        function updateSaldo() {
            const rows = document.querySelectorAll('#anggotaTable tr');
            let total = 0;
            rows.forEach((row, i) => {
                if (i === 0) return;
                const checkboxes = row.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(cb => { if (cb.checked) total += 5000; });
            });
            totalPembayaran = total;
            const pemasukanEl = document.getElementById("pemasukan");
            if (pemasukanEl) pemasukanEl.textContent = "Pemasukan Bulan ini: Rp. " + totalPembayaran.toLocaleString("id-ID");
            updateSaldoTerkini();
        }

        function attachCheckboxListeners() {
            const cbs = document.querySelectorAll('#anggotaTable input[type="checkbox"]');
            cbs.forEach(cb => {
                cb.onchange = function () {
                    simpanData();
                };
            });
        }

        // ✅ Hitung total pengeluaran
        function hitungTotal() {
            let total = 0;
            document.querySelectorAll('#pengeluaranTable td:last-child input').forEach(input => {
                const nilai = parseInt(input.value.replace(/[^0-9]/g, '')) || 0;
                total += nilai;
            });
            totalPengeluaran = total;
            const totalBiayaEl = document.getElementById("totalBiaya");
            if (totalBiayaEl) totalBiayaEl.textContent = "Total Pengeluaran: Rp " + total.toLocaleString("id-ID");

            const extBox = document.getElementById("boxPengeluaranBulanan");
            if (extBox) extBox.textContent = "Pengeluaran Bulan Ini: Rp " + total.toLocaleString("id-ID");

            updateSaldoTerkini();
            simpanData();
        }

        // ✅ Update saldo akhir
        function updateSaldoTerkini() {
            let saldo = totalPembayaran - totalPengeluaran;
            if (saldo < 0) saldo = 0;
            const saldoEl = document.getElementById("saldo");
            if (saldoEl) saldoEl.textContent = "Saldo Terkini: Rp. " + saldo.toLocaleString("id-ID");
        }

        // ✅ Tambah baris pengeluaran
        function tambahBaris() {
            const table = document.getElementById("pengeluaranTable");
            const rowCount = table.rows.length;
            const row = table.insertRow(rowCount);
            row.innerHTML = `<td>${rowCount}</td>
    <td><input type="date" disabled></td>
    <td><input type="text" placeholder="Tulis pengeluaran..." disabled></td>
    <td><input type="text" placeholder="Tulis biaya..." disabled></td>`;
        }

        // ✅ Simpan ke localStorage
        function simpanData() {
            const anggotaData = [];
            document.querySelectorAll('#anggotaTable tr').forEach((row, i) => {
                if (i === 0) return;
                const date = row.cells[2].querySelector('input').value;
                const checks = [...row.querySelectorAll('input[type="checkbox"]')].map(c => c.checked);
                anggotaData.push({ date, checks });
            });

            const pengeluaranData = [];
            document.querySelectorAll('#pengeluaranTable tr').forEach((row, i) => {
                if (i === 0) return;
                pengeluaranData.push({
                    tanggal: row.cells[1].querySelector('input').value,
                    keterangan: row.cells[2].querySelector('input').value,
                    biaya: row.cells[3].querySelector('input').value
                });
            });

            localStorage.setItem("anggotaKas", JSON.stringify(anggotaData));
            localStorage.setItem("pengeluaranKas", JSON.stringify(pengeluaranData));
            updateSaldo();
        }

        // ✅ Muat ulang dari DATABASE (read-only endpoint untuk user) + localStorage
        function muatData() {
            const rows = document.querySelectorAll('#anggotaTable tr');

            // Coba load dari server (read-only endpoint untuk user)
            try {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', 'load_anggota_data_user.php', false); // synchronous
                xhr.send();

                if (xhr.status === 200) {
                    const dbData = JSON.parse(xhr.responseText);

                    // Buat map data dari DB berdasarkan user_id
                    const dbMap = {};
                    if (dbData.success && dbData.data && Array.isArray(dbData.data)) {
                        dbData.data.forEach(item => {
                            dbMap[item.user_id] = item.weeks_data;
                        });
                    }

                    // Restore data ke table dari DB
                    let hasData = false;
                    rows.forEach((row, i) => {
                        if (i === 0) return;
                        const nameCell = row.querySelector('.editable-name');
                        const userId = nameCell ? parseInt(nameCell.getAttribute('data-id')) : null;

                        if (userId && dbMap[userId] && Array.isArray(dbMap[userId])) {
                            hasData = true;
                            const weeks = dbMap[userId];
                            for (let w = 0; w < 4; w++) {
                                const cell = row.cells[2 + w];
                                const dateInput = cell.querySelector('input[type="date"]');
                                const checkboxInput = cell.querySelector('input[type="checkbox"]');
                                if (weeks[w]) {
                                    if (dateInput) dateInput.value = weeks[w].date || "";
                                    if (checkboxInput) checkboxInput.checked = weeks[w].checked === true;
                                }
                            }
                        }
                    });

                    // Jika DB tidak ada data, load dari localStorage sebagai fallback
                    if (!hasData) {
                        loadFromLocalStorage(rows);
                    }
                } else {
                    loadFromLocalStorage(rows);
                }
            } catch (e) {
                console.error('DB load failed:', e);
                loadFromLocalStorage(rows);
            }

            // Load pengeluaran dari localStorage
            const pengeluaranData = JSON.parse(localStorage.getItem("pengeluaranKas") || "[]");
            const table = document.getElementById("pengeluaranTable");
            if (table && pengeluaranData.length > 0) {
                pengeluaranData.forEach((data, i) => {
                    if (i >= table.rows.length - 1) tambahBaris();
                    const row = table.rows[i + 1];
                    if (row) {
                        const tCell = row.cells[1]?.querySelector('input');
                        const kCell = row.cells[2]?.querySelector('input');
                        const bCell = row.cells[3]?.querySelector('input');
                        if (tCell) tCell.value = data.tanggal || "";
                        if (kCell) kCell.value = data.keterangan || "";
                        if (bCell) bCell.value = data.biaya || "";
                    }
                });
            }

            hitungTotal();
            updateSaldo();
        }

        // Helper: load dari localStorage
        function loadFromLocalStorage(rows) {
            const anggotaData = JSON.parse(localStorage.getItem("anggotaKas") || "[]");
            anggotaData.forEach((data, i) => {
                const row = rows[i + 1];
                if (row && data.weeks && Array.isArray(data.weeks)) {
                    for (let w = 0; w < 4; w++) {
                        const cell = row.cells[2 + w];
                        const dateInput = cell.querySelector('input[type="date"]');
                        const checkboxInput = cell.querySelector('input[type="checkbox"]');
                        if (data.weeks[w]) {
                            if (dateInput) dateInput.value = data.weeks[w].date || "";
                            if (checkboxInput) checkboxInput.checked = data.weeks[w].checked === true;
                        }
                    }
                }
            });
        }

        // QR modal functions
        function openQRModal() {
            const m = document.getElementById('qrModal');
            if (!m) return;
            m.classList.add('show');
            m.setAttribute('aria-hidden','false');
        }

        function closeQRModal() {
            const m = document.getElementById('qrModal');
            if (!m) return;
            m.classList.remove('show');
            m.setAttribute('aria-hidden','true');
        }

        function downloadQR() {
            const img = document.getElementById('qrisImg');
            if (!img) return;
            const src = img.src;
            const filename = src.substring(src.lastIndexOf('/') + 1) || 'qris.jpg';
            const a = document.createElement('a');
            a.href = src;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            a.remove();
        }

        // close QR modal when clicking outside box or pressing Escape
        document.addEventListener('click', function(e){
            const m = document.getElementById('qrModal');
            if (!m || !m.classList.contains('show')) return;
            if (e.target === m) closeQRModal();
        });
        document.addEventListener('keydown', function(e){ if (e.key === 'Escape') closeQRModal(); });
        
        // Profile page functions (open/close)
        function openProfilePage() {
            const home = document.getElementById('home');
            const profile = document.getElementById('profilePage');
            if (home) home.style.display = 'none';
            if (profile) profile.style.display = 'flex';
        }

        function closeProfilePage() {
            const home = document.getElementById('home');
            const profile = document.getElementById('profilePage');
            if (profile) profile.style.display = 'none';
            if (home) home.style.display = 'block';
        }

        // Logout function
        function logout() {
            if (confirm('Apakah Anda yakin ingin logout?')) {
                window.location.href = 'logout.php';
            }
        }
    </script>
</body>

</html>