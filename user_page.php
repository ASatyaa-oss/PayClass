<?php
session_start();
require_once 'config.php';

// Ambil data user dari session
$user_name = $_SESSION['name'] ?? 'User';
$user_email = $_SESSION['email'] ?? '';
$user_phone = $_SESSION['phone'] ?? '';
// Gunakan kelas user jika ada, fallback ke 1KA25 agar sesuai konteks admin
$class = $_SESSION['class'] ?? '1KA25';

// 1. Ambil daftar anggota kelas (Read-Only)
$users = [];
$stmt = $conn->prepare("SELECT id, name, email, phone FROM users WHERE class = ? ORDER BY name");
if ($stmt) {
    $stmt->bind_param('s', $class);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res) {
        $users = $res->fetch_all(MYSQLI_ASSOC);
    }
    $stmt->close();
}

// 2. Ambil data pembayaran (Read-Only)
// Kita ambil semua data pembayaran untuk kelas ini
$paymentData = [];
// Ambil ID user yang ada di kelas ini
$userIds = array_column($users, 'id');
if (!empty($userIds)) {
    // Buat string placeholder (?,?,?)
    $types = str_repeat('i', count($userIds));
    $placeholders = implode(',', array_fill(0, count($userIds), '?'));

    $sql = "SELECT user_id, weeks_data FROM anggota_data WHERE user_id IN ($placeholders)";
    $stmtPay = $conn->prepare($sql);
    if ($stmtPay) {
        $stmtPay->bind_param($types, ...$userIds);
        $stmtPay->execute();
        $resPay = $stmtPay->get_result();
        while ($row = $resPay->fetch_assoc()) {
            $paymentData[$row['user_id']] = json_decode($row['weeks_data'], true);
        }
        $stmtPay->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PayClass - User View</title>
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
        <header class="header">
            <div class="profile-menu" onclick="openProfilePage()">
                <div class="profile-icon">👤</div>
            </div>
            <div class="logo">
                <h1>PayClass</h1>
                <p><?php echo htmlspecialchars($class); ?></p>
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
            <div class="user-role">User</div>
            <div class="user-email"><?php echo htmlspecialchars($user_email); ?></div>

            <div class="divider"></div>

            <div class="info-section">
                <div class="info-label">Kelas</div>
                <div class="info-value"><?php echo htmlspecialchars($class); ?></div>
            </div>

            <div class="info-section">
                <div class="info-label">Status</div>
                <div class="info-value">Anggota Kelas</div>
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

    <!-- QR Modal (Untuk lihat saja, atau bisa bayar) -->
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

    <!-- 👥 HALAMAN ANGGOTA (READ ONLY) -->
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
            <?php
            if (empty($users)) {
                echo "<tr><td colspan='6'>Belum ada data anggota untuk kelas ini.</td></tr>";
            } else {
                foreach ($users as $index => $u):
                    $uid = $u['id'];
                    $weeks = $paymentData[$uid] ?? []; // Ambil data weeks dari array yang sudah diload
                    ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td style="text-align:left; padding-left:20px;"><?php echo htmlspecialchars($u['name']); ?></td>
                        <!-- Loop 4 minggu -->
                        <?php for ($i = 0; $i < 4; $i++):
                            $dateVal = $weeks[$i]['date'] ?? '';
                            $isChecked = !empty($weeks[$i]['checked']);
                            ?>
                            <td>
                                <input type="date" value="<?php echo htmlspecialchars($dateVal); ?>" disabled>
                                <input type="checkbox" <?php echo $isChecked ? 'checked' : ''; ?> disabled>
                            </td>
                        <?php endfor; ?>
                    </tr>
                <?php endforeach;
            }
            ?>
        </table>
    </div>

    <!-- 📉 HALAMAN PENGELUARAN (READ ONLY) -->
    <div id="pengeluaran">
        <button class="back-btn" onclick="showHome()">⬅ Kembali</button>
        <h1>📉 Tabel Pengeluaran Uang Kas</h1>
        <div style="text-align:center; color:#666; font-style:italic; padding:10px;">
            (Data pengeluaran ditampilkan dari perangkat lokal. Jika kosong, berarti data tersimpan di perangkat Admin)
        </div>
        <table id="pengeluaranTable">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Pengeluaran</th>
                <th>Biaya (Rp)</th>
            </tr>
            <!-- Baris placeholder / kosong karena data pengeluaran ada di localStorage admin -->
            <tr>
                <td>1</td>
                <td><input type="date" disabled></td>
                <td><input type="text" placeholder="-" disabled></td>
                <td><input type="text" placeholder="0" disabled></td>
            </tr>
        </table>
        <!-- Tombol tambah baris dihilangkan untuk user -->
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
            // User hanya boleh view, tapi kita arahkan ke halaman pembayaran jika ada
            window.location.href = 'pembayaran.php?tab=' + encodeURIComponent(tab) + '&from=user';
        }

        document.addEventListener("DOMContentLoaded", function () {
            // Kita hitung saldo saat load berdasarkan checkbox yang tercentang (rendered by PHP)
            updateSaldo();

            // Coba load pengeluaran dari localStorage (mungkin user pernah buka di device ini?)
            // Meskipun kecil kemungkinan, kita tetap coba baca
            loadPengeluaranLocal();

            const params = new URLSearchParams(window.location.search);
            const tab = params.get('tab');
            if (tab === 'anggota') showAnggota();
            else if (tab === 'pengeluaran') showPengeluaran();
            else showHome();
        });

        function showAnggota() { document.getElementById("home").style.display = "none"; document.getElementById("anggota").style.display = "block"; document.getElementById("pengeluaran").style.display = "none"; }
        function showPengeluaran() { document.getElementById("home").style.display = "none"; document.getElementById("anggota").style.display = "none"; document.getElementById("pengeluaran").style.display = "block"; }
        function showHome() { document.getElementById("anggota").style.display = "none"; document.getElementById("pengeluaran").style.display = "none"; document.getElementById("home").style.display = "block"; updateSaldo(); }

        // ✅ Hitung saldo dari checkbox yang sudah ter-render
        function updateSaldo() {
            const rows = document.querySelectorAll('#anggotaTable tr');
            let total = 0;
            rows.forEach((row, i) => {
                if (i === 0) return; // skip header
                const checkboxes = row.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(cb => { if (cb.checked) total += 5000; });
            });
            totalPembayaran = total;
            const pemasukanEl = document.getElementById("pemasukan");
            const pemasukanVal = document.getElementById("pemasukanValue");
            const kenaikanVal = document.getElementById("kenaikanValue");

            if (pemasukanVal) pemasukanVal.textContent = "Rp. " + totalPembayaran.toLocaleString("id-ID");
            if (kenaikanVal) kenaikanVal.textContent = "Rp. " + totalPembayaran.toLocaleString("id-ID");

            updateSaldoTerkini();
        }

        // ✅ Hitung total pengeluaran
        function hitungTotalPengeluaran() {
            let total = 0;
            document.querySelectorAll('#pengeluaranTable td:last-child input').forEach(input => {
                const nilai = parseInt(input.value.replace(/[^0-9]/g, '')) || 0;
                total += nilai;
            });
            totalPengeluaran = total;
            const totalBiayaEl = document.getElementById("totalBiaya");
            if (totalBiayaEl) totalBiayaEl.textContent = "Total Pengeluaran: Rp " + total.toLocaleString("id-ID");

            const extBox = document.getElementById("pengeluaranValue");
            if (extBox) extBox.textContent = "Rp " + total.toLocaleString("id-ID");

            updateSaldoTerkini();
        }

        // ✅ Update saldo akhir
        function updateSaldoTerkini() {
            let saldo = totalPembayaran - totalPengeluaran;
            if (saldo < 0) saldo = 0;
            const saldoEl = document.getElementById("saldoValue");
            if (saldoEl) saldoEl.textContent = "Rp. " + saldo.toLocaleString("id-ID");
        }

        // Load pengeluaran dari localStorage (Read Only mode, tidak bisa menambah)
        function loadPengeluaranLocal() {
            const stored = localStorage.getItem("pengeluaranKas");
            if (stored) {
                try {
                    const data = JSON.parse(stored);
                    if (Array.isArray(data) && data.length > 0) {
                        const table = document.getElementById("pengeluaranTable");
                        // Hapus baris placeholder (baris ke-2, index 1)
                        if (table.rows.length > 1) {
                            for (let i = table.rows.length - 1; i > 0; i--) {
                                table.deleteRow(i);
                            }
                        }

                        // Render data
                        data.forEach((item, index) => {
                            const row = table.insertRow();
                            row.innerHTML = `
                                <td>${index + 1}</td>
                                <td><input type="date" value="${item.tanggal || ''}" disabled></td>
                                <td><input type="text" value="${item.keterangan || ''}" disabled></td>
                                <td><input type="text" value="${item.biaya || ''}" disabled></td>
                            `;
                        });
                        hitungTotalPengeluaran();
                    }
                } catch (e) { console.error("Error loading local storage", e); }
            }
        }

        // Profile & QR Modal Functions
        function openProfilePage() {
            const page = document.getElementById('profilePage');
            page.classList.add('show');
            page.style.display = 'flex'; // maksa tampil
            document.getElementById('home').style.display = 'none';
        }

        function closeProfilePage() {
            const page = document.getElementById('profilePage');
            page.classList.remove('show');
            page.style.display = 'none';
            document.getElementById('home').style.display = 'block';
        }

        function logout() {
            if (confirm("Apakah anda yakin ingin logout?")) {
                window.location.href = 'logout.php';
            }
        }

        function closeQRModal() {
            document.getElementById('qrModal').classList.remove('show');
        }

        function downloadQR() {
            const link = document.createElement('a');
            link.href = 'qris.jpg';
            link.download = 'qris_payclass.jpg';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
        // Expose close to window for onclick
        window.closeQRModal = closeQRModal;
        window.downloadQR = downloadQR;
    </script>
</body>

</html>