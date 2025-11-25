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

// Load semua anggota data
$stmt = $conn->prepare("SELECT user_id, weeks_data FROM anggota_data ORDER BY user_id");
if (!$stmt) {
    echo json_encode(['success' => false, 'error' => $conn->error]);
    exit();
}

$stmt->execute();
$result = $stmt->get_result();
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = [
        'user_id' => (int)$row['user_id'],
        'weeks_data' => json_decode($row['weeks_data'], true) ?: []
    ];
}

$stmt->close();

echo json_encode([
    'success' => true,
    'data' => $data
]);
?>
