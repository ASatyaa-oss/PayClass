<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
require_once 'config.php';

// Pastikan request POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit();
}

// Hanya ADMIN yang boleh melakukan update (kembalikan JSON, jangan redirect)
if (!isset($_SESSION['class']) || strtoupper($_SESSION['class']) !== 'ADMIN') {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit();
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';

if ($id <= 0 || $name === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
    exit();
}

// Jika field phone dikirim, update kedua kolom, jika tidak hanya update name
if (array_key_exists('phone', $_POST)) {
    $stmt = $conn->prepare("UPDATE users SET name = ?, phone = ? WHERE id = ?");
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Prepare failed']);
        exit();
    }
    $stmt->bind_param('ssi', $name, $phone, $id);
} else {
    $stmt = $conn->prepare("UPDATE users SET name = ? WHERE id = ?");
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Prepare failed']);
        exit();
    }
    $stmt->bind_param('si', $name, $id);
}

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'DB error']);
}

$stmt->close();
exit();

?>
