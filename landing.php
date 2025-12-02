<?php
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayClass</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            overflow: hidden;
        }

        .container {
            width: 100%;
            height: 100vh;
            position: relative;
        }

        /* Background kampus */
        .bg {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 1;
        }

        /* Wave overlay - full width, covering entire background */
        .wave {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 2;
        }

        /* Logo */
        .logo {
            width: 140px;
            position: absolute;
            top: 25px;
            left: 25px;
            z-index: 3;
        }

        /* Konten Teks */
        .content {
            position: absolute;
            bottom: 40px;
            right: 40px;
            width: 35%;
            color: white;
            z-index: 4;
        }

        .content h1 {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #fff;
        }

        .content p {
            font-size: 16px;
            line-height: 1.8;
            margin-bottom: 32px;
            color: rgba(255, 255, 255, 0.95);
        }

        /* Tombol */
        .btn {
            background: linear-gradient(90deg, #b249ff), #b429ff;
            padding: 14px 40px;
            border-radius: 28px;
            border: none;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            color: #fff;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(198, 3, 232, 0.4);
            text-decoration: none;
            display: inline-block;
        }

        .btn:hover {
            box-shadow: 0 6px 24px rgba(198, 3, 232, 0.4);
            transform: translateY(-2px);
        }

    </style>
</head>
<body>

    <div class="container">

        <img src="kampus.jpg" class="bg">
        <img src="wave.jpg" class="wave">
        <img src="logo.jpg" class="logo">
        
        <div class="content">
            <h1>Selamat Datang di PayClass</h1>
            <p>
                Kamu bisa membayar kas kelas langsung dari website tanpa repot. 
                Pantau saldo, cek riwayat pembayaran, dan lihat laporan keuangan kelas 
                secara transparan dan real time. Praktis, aman, dan bikin keuangan kelas 
                jadi lebih tertata!
            </p>
            <a href="login.php" class="btn">Get Started</a>
        </div>
    </div>

</body>
</html>