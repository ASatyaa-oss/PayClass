<?php
session_start();
require_once 'config.php';

// Hanya ADMIN boleh
if (!isset($_SESSION['class']) || strtoupper($_SESSION['class']) !== 'ADMIN') {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit();
}

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid JSON']);
    exit();
}

// Data berisi: [ { user_id, weeks: [ {date, checked}, ... ] }, ... ]
$success = true;
$errors = [];

foreach ($data as $item) {
    $userId = (int)($item['user_id'] ?? 0);
    if (!$userId) continue;

    // Hitung total pembayaran (5000 per checkbox yang dicek)
    $totalPayment = 0;
    if (isset($item['weeks']) && is_array($item['weeks'])) {
        foreach ($item['weeks'] as $week) {
            if ($week['checked'] ?? false) {
                $totalPayment += 5000;
            }
        }
    }

    // Simpan atau update data pembayaran ke DB
    // Struktur tabel: anggota_data (id, user_id, weeks_data, total_payment, updated_at)
    // Jika tabel belum ada, create terlebih dahulu
    
    $weeksJson = json_encode($item['weeks'] ?? []);
    
    // Check apakah record sudah ada
    $checkStmt = $conn->prepare("SELECT id FROM anggota_data WHERE user_id = ?");
    if (!$checkStmt) {
        $errors[] = "DB error: " . $conn->error;
        $success = false;
        continue;
    }
    
    $checkStmt->bind_param('i', $userId);
    $checkStmt->execute();
    $checkRes = $checkStmt->get_result();
    $exists = $checkRes->num_rows > 0;
    $checkStmt->close();

    if ($exists) {
        // UPDATE
        $stmt = $conn->prepare("UPDATE anggota_data SET weeks_data = ?, total_payment = ?, updated_at = NOW() WHERE user_id = ?");
        if (!$stmt) {
            $errors[] = "Prepare error: " . $conn->error;
            $success = false;
            continue;
        }
        $stmt->bind_param('sii', $weeksJson, $totalPayment, $userId);
    } else {
        // INSERT
        $stmt = $conn->prepare("INSERT INTO anggota_data (user_id, weeks_data, total_payment, updated_at) VALUES (?, ?, ?, NOW())");
        if (!$stmt) {
            $errors[] = "Prepare error: " . $conn->error;
            $success = false;
            continue;
        }
        $stmt->bind_param('isi', $userId, $weeksJson, $totalPayment);
    }

    if (!$stmt->execute()) {
        $errors[] = "Execute error for user $userId: " . $stmt->error;
        $success = false;
    }
    $stmt->close();
}

echo json_encode([
    'success' => $success,
    'errors' => $errors
]);
?>
