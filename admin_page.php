<?php
session_start();
require_once 'config.php';

// Proteksi: hanya ADMIN boleh melihat halaman ini
if (!isset($_SESSION['class']) || strtoupper($_SESSION['class']) !== 'ADMIN') {
    header('Location: index.php');
    exit();
}

// Ambil daftar anggota kelas 1KA25 dari DB
$class = '1KA25';
$users = [];
$stmt = $conn->prepare("SELECT id, name, email, phone FROM users WHERE class = ? ORDER BY name");
if ($stmt) {
    $stmt->bind_param('s', $class);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res)
        $users = $res->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

// Ambil nama user dari session
$user_name = $_SESSION['user_name'] ?? $_SESSION['name'] ?? 'Admin User';
$user_email = $_SESSION['email'] ?? 'admin@payclass.local';
$user_phone = $_SESSION['phone'] ?? '';

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PayClass</title>
    <link href="https://fonts.googleapis.com/css2?family=Libertinus+Keyboard&family=Luckiest+Guy&display=swap"
        rel="stylesheet">

    <style>
        body {
            /* Nurin */
            margin: 0;
            /* supaya halaman rapih */
            background-image: url(https://i.pinimg.com/736x/b0/21/06/b0210669be120b2c1b2d2cc4f25bfcbd.jpg);
            /* gambar latar belakang */
            background-repeat: no-repeat;
            /* supaya tidak mengulang */
            background-attachment: fixed;
            /* supaya tidak bergerak */
            background-position: center;
            /* supaya di tengah*/
            background-size: cover;
            /* supaya full */
            font-family: "Times New Roman", Times, serif;
            /* font payclass */
        }

        #home {
            display: block;
            padding: 20px;
        }

        .header {
            /* alma */
            display: flex;
            /* letak header */
            justify-content: space-between;
            /* posisi profile dan badges antara payclass */
            align-items: center;
            /* posisi tengah profile dan badges */
            padding: 15px 30px;
            /* profile ga gepeng */
        }

        .profile-menu {
            /* Profile dropdown */
            position: relative;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .profile-icon {
            /* Alma */
            width: 50px;
            /* bentuk ikon profile */
            height: 50px;
            /* ketinggian ikon profile */
            border: 3px solid #2f253f;
            /* outline  ikon profile */
            border-radius: 50%;
            display: flex;
            /* letak ikon profile */
            justify-content: center;
            /* ikon profile agar menjadi png */
            align-items: center;
            /* posisi ikon profile */
            background: linear-gradient(135deg, #43085d, #961ccb);
            /* warna ikon profile */
            font-size: 22px;
            /* ukuran ikon profile */
            transition: transform 0.2s;
        }

        .profile-icon:hover {
            transform: scale(1.1);
        }

        #profilePage {
            display: none;
            min-height: 100vh;
            padding: 20px;
            background: linear-gradient(135deg, #43085d, #961ccb);
        }

        #profilePage.show {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .profile-card {
            background: white;
            border-radius: 15px;
            padding: 40px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
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

        .profile-card .user-name {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin: 10px 0;
        }

        .profile-card .user-role {
            font-size: 16px;
            color: #888;
            margin: 5px 0;
        }

        .profile-card .user-email {
            font-size: 14px;
            color: #999;
            margin: 10px 0 30px 0;
            word-break: break-word;
        }

        .profile-card .divider {
            height: 1px;
            background: #e0e0e0;
            margin: 20px 0;
        }

        .profile-card .info-section {
            text-align: left;
            margin: 20px 0;
        }

        .profile-card .info-label {
            font-size: 12px;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .profile-card .info-value {
            font-size: 16px;
            color: #333;
            word-break: break-word;
        }

        .profile-card .btn-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }

        .profile-card .btn-group button {
            flex: 1;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
            transition: all 0.3s;
        }

        .profile-card .btn-back {
            background: #f0f0f0;
            color: #333;
        }

        .profile-card .btn-back:hover {
            background: #e0e0e0;
        }

        .profile-card .btn-logout {
            background: #e53935;
            color: white;
        }

        .profile-card .btn-logout:hover {
            background: #d32f2f;
        }

        .logo {
            /* 1KA25  alma */
            text-align: center;
            /* Posisi 1KA25*/
            color: #ccc;
            /* warna 1KA25 */
        }

        .logo h1 {
            /* Nurin */
            font-size: 100px;
            /* Ukuran 1KA25 */
            margin: 0;
            /* Supaya rapih payclass */
            color: #d3d3ff;
            /* warna payclass */
            text-shadow: #000 4px 2px 4px;
            /*bayangan payclass */
            font-family: "Luckiest Guy", cursive;
            /*font payclass */
        }

        .logo p {
            /* nURIN */
            margin: 0;
            font-size: 16px;
            /* ukuran font 1KA25
            color: #fff;                /* warna 1KA25 */
            letter-spacing: 2px;
            /* spacing huruf 1KA25 */
        }

        .status {
            /* Nurin */
            text-align: right;
            /* posisi status lunas */
            font-size: x-large;
            /* ukuran status lunas */
        }

        .p2 {
            /* Nurin */
            margin: 0;
            /* supaya rapih status lunas */
            font-weight: bold;
            /* Bold status lunas */
            color: #fff;
            /* warna status lunas */
        }

        .badge {
            /* Alma */
            display: inline-block;
            /* posisi lunas */
            margin-top: 5px;
            /* jarak status lunas */
            background-color: #b2ff59;
            /* warna latar belakang lunas */
            color: #1b5e20;
            /* warna teks lunas */
            font-weight: bold;
            /* Bold teks lunas */
            padding: 5px 15px;
            /* jarak teks lunas */
            border-radius: 20px;
            /* border lunas */
            font-size: large;
            /* ukuran teks lunas */
        }

        .container {
            display: flex;
            gap: 20px;
            flex-wrap: nowrap;

        }

        .box {
            margin: 20px 10px;
            padding: 45px;
            background-color: rgb(30, 0, 99);
            color: #fff;
            font-size: 20px;
            text-align: center;
            border-style: outset;
            border-width: 10px;
            border-radius: 15px;
            display: inline-block;
            width: 30%;
            vertical-align: top;
        }

        .box .small {
            font-size: 14px;
            margin-top: 10px;
            color: #b2ff59;
        }

        .button-container {
            /* Nurin */
            display: flex;
            /* jarak button */
            flex-direction: column;
            /* posisi button */
            gap: 15px;
            /* jarak button*/
            padding: 20px;
            /* ketebalan button */
        }

        button {
            width: 100%;
            border: none;
            background: none;
            padding: 0;
            cursor: pointer;
        }

        .text3,
        .text4,
        .text5 {
            /* Nurin */
            color: rgb(42, 36, 134);
            /* warna tulisan button */
            border-style: outset;
            /* outline button */
            border-width: 12px;
            /* 3D outline oval */
            border-radius: 20px;
            /* biar oval */
            padding: 20px;
            /* biar ada background button */
            background-color: rgb(230, 230, 254);
            /* warna background button */
            font-size: x-large;
            /* ukuran tulisan button */
            text-align: center;
            /* posisi tulisan button */
        }

        #anggota,
        #pengeluaran {
            display: none;
            min-height: 100vh;
            padding: 20px;
            background: #f5f6fa;
        }

        #anggota h1,
        #pengeluaran h1 {
            text-align: center;
            color: #2f3640;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        th,

        td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        th {
            background: #522780;
            color: #fff;
        }

        tr:nth-child(even) {
            background: #f1f2f6;
        }

        input[type="date"],
        input[type="text"] {
            width: 95%;
            padding: 5px;
            border: 1px solid #aaa;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="checkbox"] {
            transform: scale(1.3);
            cursor: pointer;
        }

        /* small helper style for error highlight */
        .input-error {
            border-color: #e53935 !important;
        }

        .back-btn {
            margin: 20px 0;
            padding: 10px 20px;
            background: #522780;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .total {
            text-align: right;
            margin-top: 20px;
            font-size: 20px;
            font-weight: bold;
            color: #2e7d32;
        }

        /* QR modal styles */
        .qr-modal {
            display: none;
            position: fixed;
            z-index: 1200;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .qr-modal.show {
            display: flex;
        }

        .qr-box {
            background: #fff;
            border-radius: 12px;
            padding: 22px 28px;
            width: 380px;
            max-width: calc(100% - 40px);
            text-align: center;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.18);
        }

        .qr-box .title {
            font-weight: 700;
            margin-bottom: 8px;
        }

        .qr-box img {
            margin: 12px 0;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 4px;
            width: 220px;
            height: auto;
            background: white;
        }

        .qr-box .note {
            font-size: 13px;
            color: #666;
            margin-bottom: 12px;
        }

        .qr-box .buttons {
            display: flex;
            gap: 10px;
            justify-content: space-between;
        }

        .qr-box .buttons button {
            flex: 1;
        }
    </style>
</head>

<body>

    <!-- 🏠 HALAMAN UTAMA -->
    <div id="home">
        <header class="header"> <!-- Alma -->
            <div class="profile-menu" onclick="openProfilePage()">
                <div class="profile-icon">👤</div>
            </div>
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
            <div class="box" id="boxPengeluaranBulanan">Pengeluaran Bulan Ini: <span id="pengeluaranValue">Rp. 0</span>
            </div>
            <div class="box" id="pemasukan">Pemasukan Bulan ini: <span id="pemasukanValue">Rp. 0</span></div>
        </div>

        <div class="button-container">
            <button onclick="goToPembayaran()">
                <div class="text3">PEMBAYARAN</div>
            </button>
            <button onclick="showPengeluaran()">
                <div class="text4">PENGELUARAN</div>
            </button>
            <button onclick="window.location.href='pemasukan_bulanan.php'">
                <div class="text5">PEMASUKAN BULANAN</div>
            </button>
            <button onclick="showAnggota()">
                <div class="text3">ANGGOTA</div>
            </button>
        </div>
    </div>

    <!-- 👤 HALAMAN PROFILE -->
    <div id="profilePage">
        <div class="profile-card">
            <div class="avatar">👤</div>
            <div class="user-name"><?php echo htmlspecialchars($user_name); ?></div>
            <div class="user-role">Admin</div>
            <div class="user-email"><?php echo htmlspecialchars($user_email); ?></div>

            <div class="divider"></div>

            <div class="info-section">
                <div class="info-label">Kelas</div>
                <div class="info-value">1KA25</div>
            </div>

            <div class="info-section">
                <div class="info-label">Status</div>
                <div class="info-value">Administrator</div>
            </div>

            <?php if (!empty($user_phone)): ?>
                <div class="info-section">
                    <div class="info-label">No. Telepon</div>
                    <div class="info-value"><?php echo htmlspecialchars($user_phone); ?></div>
                </div>
            <?php endif; ?>

            <div class="btn-group">
                <button class="btn-back" onclick="closeProfilePage()">⬅ Kembali</button>
                <button class="btn-logout" onclick="logout()">🚪 Logout</button>
            </div>
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
            <?php foreach ($users as $index => $u): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td class="editable-name" data-id="<?php echo (int) $u['id']; ?>">
                        <?php echo htmlspecialchars($u['name']); ?>
                    </td>
                    <td><input type="date"><input type="checkbox"></td>
                    <td><input type="date"><input type="checkbox"></td>
                    <td><input type="date"><input type="checkbox"></td>
                    <td><input type="date"><input type="checkbox"></td>
                </tr>
            <?php endforeach; ?>
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
                <td><input type="date" onchange="simpanData()"></td>
                <td><input type="text" placeholder="Contoh: Beli spidol" onchange="simpanData()"></td>
                <td><input type="text" placeholder="25000" oninput="enforceBiayaMax(this); hitungTotal()"
                        onchange="simpanData()"></td>
            </tr>
        </table>
        <button onclick="tambahBaris()">+ Tambah Baris</button>
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
            window.location.href = 'pembayaran.php?tab=' + encodeURIComponent(tab) + '&from=admin';
        }

        document.addEventListener("DOMContentLoaded", function () {
            // Delay sebentar agar table sudah ter-render
            setTimeout(function () {
                muatData();
                hitungTotal();
                attachCheckboxListeners();
                updateSaldo();
                updatePemasukanBulanan();

                // Logic pindahan dari style block: copy pemasukan to kenaikan
                const pemasukanEl = document.getElementById('pemasukanValue');
                const kenaikanEl = document.getElementById('kenaikanValue');
                if (pemasukanEl && kenaikanEl) {
                    kenaikanEl.textContent = pemasukanEl.textContent;
                }

                // restore requested tab if passed
                const params = new URLSearchParams(window.location.search);
                const tab = params.get('tab');
                if (tab === 'anggota') showAnggota();
                else if (tab === 'pengeluaran') showPengeluaran();
                else showHome();
            }, 100);
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

        let simpanDataTimeout;
        function attachCheckboxListeners() {
            const cbs = document.querySelectorAll('#anggotaTable input[type="checkbox"]');
            cbs.forEach(cb => {
                cb.onchange = function () {
                    // Debounce: tunggu 300ms sebelum save
                    clearTimeout(simpanDataTimeout);
                    simpanDataTimeout = setTimeout(function () {
                        simpanData();
                    }, 300);
                };
            });

            // Also listen to date input changes
            const dates = document.querySelectorAll('#anggotaTable input[type="date"]');
            dates.forEach(dt => {
                dt.onchange = function () {
                    clearTimeout(simpanDataTimeout);
                    simpanDataTimeout = setTimeout(function () {
                        simpanData();
                    }, 300);
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

        // Batasi nilai biaya pengeluaran per baris maksimum 10.000.000
        function enforceBiayaMax(input) {
            if (!input) return;
            // ambil angka hanya
            let v = (input.value || '').toString().replace(/[^0-9]/g, '');
            if (v === '') { input.value = ''; return; }
            let n = parseInt(v, 10) || 0;
            const MAX = 10000000;
            if (n > MAX) {
                n = MAX;
                input.classList.add('input-error');
                // inform user once
                alert('Nilai maksimum pengeluaran per item adalah Rp 10.000.000');
            } else {
                input.classList.remove('input-error');
            }
            input.value = n.toString();
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
    <td><input type="date" onchange="simpanData()"></td>
    <td><input type="text" placeholder="Tulis pengeluaran..." onchange="simpanData()"></td>
    <td><input type="text" placeholder="Tulis biaya..." oninput="enforceBiayaMax(this); hitungTotal()" onchange="simpanData()"></td>`;
        }

        // ✅ Simpan ke DATABASE + localStorage
        function simpanData() {
            const anggotaData = [];
            document.querySelectorAll('#anggotaTable tr').forEach((row, i) => {
                if (i === 0) return;
                const nameCell = row.querySelector('.editable-name');
                const userId = nameCell ? parseInt(nameCell.getAttribute('data-id')) : null;

                // Simpan semua 4 minggu (tanggal + checkbox masing-masing)
                const weeks = [];
                for (let w = 0; w < 4; w++) {
                    const cell = row.cells[2 + w]; // cells 2, 3, 4, 5 untuk minggu 1-4
                    const dateInput = cell.querySelector('input[type="date"]');
                    const checkboxInput = cell.querySelector('input[type="checkbox"]');
                    weeks.push({
                        date: dateInput ? dateInput.value : "",
                        checked: checkboxInput ? (checkboxInput.checked === true) : false
                    });
                }
                if (userId) {
                    anggotaData.push({ user_id: userId, weeks });
                }
            });

            // Simpan ke localStorage dulu sebagai backup (ini pasti berhasil)
            localStorage.setItem("anggotaKas", JSON.stringify(anggotaData.map(a => ({ weeks: a.weeks }))));

            // Simpan ke DATABASE (non-blocking, tidak akan mengganggu jika gagal)
            if (anggotaData.length > 0) {
                try {
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'save_anggota_data.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/json');
                    xhr.onload = function () {
                        if (xhr.status !== 200) {
                            console.warn('DB save failed with status:', xhr.status);
                        }
                    };
                    xhr.onerror = function () {
                        console.warn('DB save error - data tetap tersimpan di localStorage');
                    };
                    xhr.send(JSON.stringify(anggotaData));
                } catch (e) {
                    console.error('Save error:', e);
                }
            }

            // Simpan pengeluaran ke localStorage
            const pengeluaranData = [];
            document.querySelectorAll('#pengeluaranTable tr').forEach((row, i) => {
                if (i === 0) return;
                pengeluaranData.push({
                    tanggal: row.cells[1].querySelector('input').value,
                    keterangan: row.cells[2].querySelector('input').value,
                    biaya: row.cells[3].querySelector('input').value
                });
            });
            localStorage.setItem("pengeluaranKas", JSON.stringify(pengeluaranData));

            updateSaldo();
            updatePemasukanBulanan(); // Update pemasukan setelah data disimpan
        }

        // ✅ Muat ulang dari DATABASE + localStorage (HANYA dipanggil saat page load)
        function muatData() {
            const rows = document.querySelectorAll('#anggotaTable tr');

            // Coba load dari DB dulu
            try {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', 'load_anggota_data.php', false); // synchronous
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

                    // Jika DB ada data, langsung proses. Jika tidak, load dari localStorage
                    if (!hasData) {
                        loadFromLocalStorage(rows);
                    }
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

            // Jangan panggil attachCheckboxListeners di sini, panggil di bawah
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
            m.setAttribute('aria-hidden', 'false');
        }

        function closeQRModal() {
            const m = document.getElementById('qrModal');
            if (!m) return;
            m.classList.remove('show');
            m.setAttribute('aria-hidden', 'true');
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
        document.addEventListener('click', function (e) {
            const m = document.getElementById('qrModal');
            if (!m || !m.classList.contains('show')) return;
            if (e.target === m) closeQRModal();
        });
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeQRModal(); });

        // Inline-edit names for admin: click a name to edit, Enter or blur to save
        function setupInlineEditNames() {
            const cells = document.querySelectorAll('.editable-name');
            cells.forEach(td => {
                td.style.cursor = 'pointer';
                td.addEventListener('click', function () {
                    if (td.isContentEditable) return;
                    td.contentEditable = true;
                    td.focus();
                    // remember original
                    td.setAttribute('data-original', td.textContent.trim());
                    // select content
                    try { document.getSelection().selectAllChildren(td); } catch (e) { }
                });

                td.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter') { e.preventDefault(); td.blur(); }
                    if (e.key === 'Escape') { td.textContent = td.getAttribute('data-original') || ''; td.blur(); }
                });

                td.addEventListener('blur', function () {
                    const id = td.getAttribute('data-id');
                    const newName = td.textContent.trim();
                    const orig = td.getAttribute('data-original') || '';
                    td.contentEditable = false;
                    if (newName === orig) return;
                    if (!newName) { alert('Nama tidak boleh kosong'); td.textContent = orig; return; }

                    const form = new URLSearchParams();
                    form.append('id', id);
                    form.append('name', newName);

                    fetch('update_user.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: form.toString()
                    })
                        .then(r => {
                            const ct = r.headers.get('content-type') || '';
                            if (ct.includes('application/json')) return r.json();
                            return r.text().then(t => { throw new Error('Server returned non-JSON response:\n' + t); });
                        })
                        .then(data => {
                            if (data.success) {
                                td.textContent = newName;
                            } else {
                                alert('Gagal menyimpan: ' + (data.error || 'Unknown'));
                                td.textContent = orig;
                            }
                        }).catch(err => {
                            alert('Terjadi kesalahan: ' + err.message);
                            td.textContent = orig;
                        });
                });
            });
        }

        document.addEventListener('DOMContentLoaded', function () { setupInlineEditNames(); });

        // ✅ Update pemasukan bulanan berdasarkan checkbox pembayaran
        function updatePemasukanBulanan() {
            const pemasukanBulanan = {};
            const currentDate = new Date();
            const currentMonth = currentDate.toISOString().substring(0, 7); // YYYY-MM

            // Group data by user
            const users = <?php echo json_encode($users); ?>;
            users.forEach(user => {
                pemasukanBulanan[user.id] = 0;
            });

            // Hitung dari checkbox yang dicek
            const rows = document.querySelectorAll('#anggotaTable tr');
            rows.forEach((row, i) => {
                if (i === 0) return; // skip header
                const nameCell = row.querySelector('.editable-name');
                if (!nameCell) return;

                const userId = nameCell.getAttribute('data-id');
                const checkboxes = row.querySelectorAll('input[type="checkbox"]');
                let totalPayment = 0;

                checkboxes.forEach(cb => {
                    if (cb.checked) totalPayment += 5000;
                });

                if (userId) {
                    pemasukanBulanan[userId] = totalPayment;
                }
            });

            // Simpan ke localStorage dengan struktur bulan
            let allPemasukanData = {};
            const saved = localStorage.getItem('pemasukanBulanan');
            if (saved) {
                try {
                    allPemasukanData = JSON.parse(saved);
                } catch (e) {
                    allPemasukanData = {};
                }
            }

            if (!allPemasukanData[currentMonth]) {
                allPemasukanData[currentMonth] = {};
            }

            Object.assign(allPemasukanData[currentMonth], pemasukanBulanan);
            localStorage.setItem('pemasukanBulanan', JSON.stringify(allPemasukanData));
        }

        // Profile menu toggle
        function openProfilePage() {
            document.getElementById('home').style.display = 'none';
            document.getElementById('anggota').style.display = 'none';
            document.getElementById('pengeluaran').style.display = 'none';
            document.getElementById('profilePage').classList.add('show');
        }

        function closeProfilePage() {
            document.getElementById('profilePage').classList.remove('show');
            document.getElementById('home').style.display = 'block';
        }

        // Close profile menu ketika click di tempat lain
        document.addEventListener('click', function (e) {
            const profileMenu = document.querySelector('.profile-menu');
            const dropdown = document.getElementById('profileDropdown');
            if (profileMenu && dropdown && !profileMenu.contains(e.target)) {
                dropdown.classList.remove('show');
            }
        });

        // Logout function
        function logout() {
            if (confirm('Apakah Anda yakin ingin logout?')) {
                window.location.href = 'logout.php';
            }
        }
    </script>
</body>

</html>