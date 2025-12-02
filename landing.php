<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayClass - Pembayaran Kas Kelas Online</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            overflow: hidden;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .container {
            width: 100%;
            height: 100vh;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 40px;
        }

        /* Wave SVG Background */
        .wave-bg {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            opacity: 0.1;
        }

        /* Logo */
        .logo {
            width: 120px;
            position: absolute;
            top: 25px;
            left: 40px;
            z-index: 3;
            animation: slideInLeft 0.6s ease-out;
        }

        /* Content Section */
        .content {
            position: relative;
            z-index: 4;
            width: 50%;
            color: white;
            animation: slideInLeft 0.8s ease-out 0.2s both;
        }

        .content h1 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 24px;
            line-height: 1.2;
        }

        .content p {
            font-size: 18px;
            line-height: 1.8;
            margin-bottom: 40px;
            opacity: 0.95;
            color: rgba(255, 255, 255, 0.9);
        }

        .features {
            list-style: none;
            margin-bottom: 40px;
        }

        .features li {
            font-size: 16px;
            margin-bottom: 12px;
            padding-left: 28px;
            position: relative;
        }

        .features li:before {
            content: "✓";
            position: absolute;
            left: 0;
            font-weight: bold;
            color: #4ade80;
        }

        /* Tombol */
        .btn-group {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 14px 40px;
            border-radius: 28px;
            border: none;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background: linear-gradient(90deg, #b249ff, #b429ff);
            color: #fff;
            box-shadow: 0 4px 16px rgba(178, 73, 255, 0.4);
        }

        .btn-primary:hover {
            box-shadow: 0 6px 24px rgba(178, 73, 255, 0.6);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: transparent;
            color: #fff;
            border: 2px solid #fff;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        /* Right Section - Illustration */
        .illustration {
            position: relative;
            z-index: 2;
            width: 45%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: slideInRight 0.8s ease-out 0.2s both;
        }

        .illustration-box {
            width: 100%;
            max-width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            font-size: 120px;
        }

        /* Animations */
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
                flex-direction: column;
                justify-content: center;
            }

            .logo {
                width: 100px;
                top: 20px;
                left: 20px;
            }

            .content {
                width: 100%;
                text-align: center;
            }

            .content h1 {
                font-size: 32px;
            }

            .content p {
                font-size: 16px;
            }

            .illustration {
                width: 100%;
                height: auto;
                margin-top: 40px;
            }

            .illustration-box {
                max-width: 300px;
                height: 300px;
                font-size: 80px;
            }

            .btn-group {
                justify-content: center;
            }
        }
    </style>
</head>
<body>

    <svg class="wave-bg" viewBox="0 0 1200 120" preserveAspectRatio="none">
        <path d="M0,50 Q300,0 600,50 T1200,50 L1200,120 L0,120 Z" fill="white"></path>
    </svg>

    <div class="container">
        <!-- Left Content -->
        <div class="content">
            <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200'%3E%3Ccircle cx='100' cy='100' r='90' fill='%23fff' opacity='0.15'/%3E%3Ctext x='50%' y='50%' dominant-baseline='middle' text-anchor='middle' font-size='60' font-weight='bold' fill='%23fff'%3EPC%3C/text%3E%3C/svg%3E" class="logo" alt="PayClass Logo">
            
            <h1>Selamat Datang di PayClass</h1>
            
            <p>
                Solusi pembayaran kas kelas yang modern, aman, dan transparan. 
                Kelola keuangan kelas dengan mudah tanpa repot.
            </p>

            <ul class="features">
                <li>Pembayaran kas kelas langsung dari website</li>
                <li>Pantau saldo dan riwayat pembayaran</li>
                <li>Laporan keuangan real-time yang transparan</li>
                <li>Sistem keamanan berlapis untuk data Anda</li>
            </ul>

            <div class="btn-group">
                <a href="login_register.php" class="btn btn-primary">Mulai Sekarang</a>
                <a href="#" onclick="document.querySelector('.features').scrollIntoView({behavior: 'smooth'}); return false;" class="btn btn-secondary">Pelajari Lebih</a>
            </div>
        </div>

        <!-- Right Illustration -->
        <div class="illustration">
            <div class="illustration-box">💳</div>
        </div>
    </div>

</body>
</html>
