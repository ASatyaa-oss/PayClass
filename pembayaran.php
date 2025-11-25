<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Pembayaran - PayClass</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --purple-1: #3b0f66;
            --purple-2: #7a2fa6
        }

        * {
            box-sizing: border-box
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Poppins, system-ui, Segoe UI, Roboto, Arial;
            background: linear-gradient(180deg, #5a2194f2, #5a2194f2);
            color: #fff;
        }

        .wrap {
            width: 100%;
            max-width: 720px;
            padding: 28px;
            border-radius: 14px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.06), rgba(255, 255, 255, 0.03));
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.35);
            text-align: center
        }

        h1 {
            margin: 0 0 6px;
            font-size: 20px;
            letter-spacing: 0.6px
        }

        p.sub {
            margin: 0 0 18px;
            color: rgba(255, 255, 255, 0.85)
        }

        .qr {
            background: #fff;
            padding: 14px;
            border-radius: 10px;
            display: inline-block
        }

        .qr img {
            display: block;
            max-width: 320px;
            width: 76vw;
            height: auto;
            border-radius: 8px
        }

        .note {
            margin: 12px 0;
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 14px
        }

        .actions a,
        .actions button {
            flex: 1;
            padding: 12px 14px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 600
        }

        .btn-back {
            background: linear-gradient(90deg, var(--purple-1), var(--purple-2));
            color: #fff
        }

        .btn-download {
            background: linear-gradient(90deg, var(--purple-1), var(--purple-2));
            color: #fff
        }

        @media(min-width:900px) {
            .qr img {
                width: 320px
            }
        }
    </style>
</head>

<body>
    <div class="wrap" role="main">
        <h1>QR Pembayaran</h1>
        <p class="sub">Silakan scan QR di bawah untuk membayar kas atau unduh untuk dibagikan</p>

        <div class="qr" aria-hidden="false">
            <img id="qrisImg" src="qris.jpg" alt="QR Pembayaran" onerror="this.style.opacity=0.6">
        </div>

        <div class="note">Gunakan aplikasi e-wallet Anda (OVO, GoPay, Dana, dll.) untuk memindai.</div>

        <div class="actions">
            <a class="btn-back" href="user_page.php">Kembali</a>
            <button class="btn-download" id="downloadBtn">Download</button>
        </div>
    </div>

    <script>
        document.getElementById('downloadBtn').addEventListener('click', function () {
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
        });
    </script>
</body>

</html>