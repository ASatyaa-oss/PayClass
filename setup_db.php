<?php
session_start();
require_once 'config.php';

// Auto-create table jika belum ada
$createTableSQL = "
CREATE TABLE IF NOT EXISTS anggota_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    weeks_data JSON,
    total_payment INT DEFAULT 0,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)
";

if ($conn->query($createTableSQL)) {
    echo "✅ Tabel anggota_data berhasil dibuat/ada.";
} else {
    echo "❌ Error membuat tabel: " . $conn->error;
}

// Tambahkan kolom `phone` di tabel `users` jika belum ada
$alterUsersSQL = "ALTER TABLE users ADD COLUMN IF NOT EXISTS phone VARCHAR(20) DEFAULT ''";
if ($conn->query($alterUsersSQL)) {
    echo "\n✅ Kolom `phone` pada tabel users berhasil dibuat/ada.";
} else {
    // Jika error karena tabel users belum ada, jangan hentikan; tampilkan pesan informatif
    if (strpos($conn->error, 'doesn\'t exist') !== false || strpos($conn->error, 'does not exist') !== false) {
        echo "\n⚠️ Tabel `users` belum ditemukan. Silakan buat tabel `users` terlebih dahulu atau jalankan migrasi manual untuk menambahkan kolom `phone`.";
    } else {
        echo "\n❌ Error menambah kolom phone: " . $conn->error;
    }
}
?>
