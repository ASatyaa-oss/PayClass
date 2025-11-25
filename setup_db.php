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
?>
