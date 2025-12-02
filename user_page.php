<?php
session_start();
$user_name = $_SESSION['name'] ?? 'User';
$user_email = $_SESSION['email'] ?? '';
$user_class = $_SESSION['class'] ?? '';
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
        body {                  /* Nurin */
            margin: 0;             /* supaya halaman rapih */ 
            background-image: url(https://i.pinimg.com/736x/b0/21/06/b0210669be120b2c1b2d2cc4f25bfcbd.jpg); /* gambar latar belakang */
            background-repeat: no-repeat;    /* supaya tidak mengulang */
            background-attachment: fixed;       /* supaya tidak bergerak */
            background-position: center;        /* supaya di tengah*/
            background-size: cover;            /* supaya full */  
            font-family: "Times New Roman", Times, serif;   /* font payclass */
        }

        #home {
            display: block;
            padding: 20px;
        }

        .header {           /* alma */
            display: flex;          /* letak header */
            justify-content: space-between;     /* posisi profile dan badges antara payclass */
            align-items: center;    /* posisi tengah profile dan badges */
            padding: 15px 30px;     /* profile ga gepeng */
        }
 
        .profile {          /* Alma */
            width: 60px; /* bentuk ikon profile */
            height: 60px; /* ketinggian ikon profile */
            border: 3px solid #2f253f; /* outline  ikon profile */ 
            border-radius: 50%;
            display: flex; /* letak ikon profile */
            justify-content: center; /* ikon profile agar menjadi png /            align-items: center; / posisi ikon profile */
            background: linear-gradient(135deg, #43085d, #961ccb); /* warna ikon profile */
            font-size: 25px;  /* ukuran ikon profile */
        }

        .logo {                 /* 1KA25  alma */
            text-align: center;         /* Posisi 1KA25*/ 
            color: #ccc; /* warna 1KA25 */ 
        }

        .logo h1 {                  /* Nurin */
            font-size: 100px;       /* Ukuran 1KA25 */
            margin: 0;              /* Supaya rapih payclass */
            color: #d3d3ff;        /* warna payclass */
            text-shadow: #000 4px 2px 4px; /*bayangan payclass */
            font-family: "Luckiest Guy", cursive; /*font payclass */
        }

        .logo p {                           /* nURIN */
            margin: 0;
            font-size: 16px;                /* ukuran font 1KA25
            color: #fff;                /* warna 1KA25 */
            letter-spacing: 2px;            /* spacing huruf 1KA25 */
        }

        .status {                /* Nurin */
            text-align: right;              /* posisi status lunas */
            font-size: x-large;             /* ukuran status lunas */
        }

        .p2 {                   /* Nurin */ 
            margin: 0;              /* supaya rapih status lunas */
            font-weight: bold;      /* Bold status lunas */
            color: #fff;        /* warna status lunas */
        }

        .badge {                /* Alma */
            display: inline-block;      /* posisi lunas */
            margin-top: 5px;      /* jarak status lunas */
            background-color: #b2ff59;  /* warna latar belakang lunas */
            color: #1b5e20; /* warna teks lunas */
            font-weight: bold;      /* Bold teks lunas */
            padding: 5px 15px;  /* jarak teks lunas */
            border-radius: 20px;    /* border lunas */
            font-size: large;   /* ukuran teks lunas */
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

        .button-container {     /* Nurin */
            display: flex;      /* jarak button */
            flex-direction: column;     /* posisi button */
            gap: 15px;    /* jarak button*/
            padding: 20px;      /* ketebalan button */
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
        .text5 {       /* Nurin */
            color: rgb(42, 36, 134); /* warna tulisan button */
            border-style: outset;   /* outline button */
            border-width: 12px;     /* 3D outline oval */
            border-radius: 20px;    /* biar oval */
            padding: 20px;        /* biar ada background button */
            background-color: rgb(230, 230, 254);   /* warna background button */
            font-size: x-large;  /* ukuran tulisan button */
            text-align: center;  /* posisi tulisan button */
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
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const pemasukanEl = document.getElementById('pemasukanValue');
        const kenaikanEl = document.getElementById('kenaikanValue');
        // copy pemasukan to kenaikan
        if (pemasukanEl && kenaikanEl) {
          kenaikanEl.textContent = pemasukanEl.textContent;
        }
      });
    </script>
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

        /* View Only Styles */
        input[type="date"]:disabled,
        input[type="text"]:disabled {
            background-color: #f5f5f5;
            color: #666;
            cursor: not-allowed;
            border: 1px solid #ddd;
        }

        input[type="checkbox"]:disabled {
            cursor: not-allowed;
            opacity: 0.7;
        }

        button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
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
            background: rgba(0,0,0,0.5);
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .qr-modal.show { display: flex; }
        .qr-box {
            background: #fff;
            border-radius: 12px;
            padding: 22px 28px;
            width: 380px;
            max-width: calc(100% - 40px);
            text-align: center;
            box-shadow: 0 12px 30px rgba(0,0,0,0.18);
        }
        .qr-box .title { font-weight:700; margin-bottom:8px; }
        .qr-box img { margin:12px 0; border:1px solid #ccc; border-radius:10px; padding:4px; width:220px; height:auto; background:white; }
        .qr-box .note { font-size:13px; color:#666; margin-bottom:12px; }
        .qr-box .buttons { display:flex; gap:10px; justify-content:space-between; }
        .qr-box .buttons button { flex:1; }

<style>
    /* Profile card styles (copied from admin page for consistency) */
    #profilePage {
        display: none;
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
            <button onclick="showAnggota()">
                <div class="text5">ANGGOTA</div>
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

        // ✅ Muat ulang dari localStorage
        function muatData() {
            const anggotaData = JSON.parse(localStorage.getItem("anggotaKas") || "[]");
            const rows = document.querySelectorAll('#anggotaTable tr');
            anggotaData.forEach((data, i) => {
                const row = rows[i + 1];
                if (row) {
                    row.cells[2].querySelector('input').value = data.date || "";
                    const cbs = row.querySelectorAll('input[type="checkbox"]');
                    data.checks?.forEach((v, j) => { if (cbs[j]) cbs[j].checked = v; });
                }
            });

            const pengeluaranData = JSON.parse(localStorage.getItem("pengeluaranKas") || "[]");
            const table = document.getElementById("pengeluaranTable");
            pengeluaranData.forEach((data, i) => {
                if (i >= table.rows.length - 1) tambahBaris();
                const row = table.rows[i + 1];
                row.cells[1].querySelector('input').value = data.tanggal || "";
                row.cells[2].querySelector('input').value = data.keterangan || "";
                row.cells[3].querySelector('input').value = data.biaya || "";
            });

            hitungTotal();
            attachCheckboxListeners();
            updateSaldo();
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