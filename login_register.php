<?php

session_start();
require_once 'config.php';

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $class = $_POST['class'];
    $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $_SESSION['register_error'] = "Email sudah terdaftar!";
            $_SESSION['active_form'] = 'register';
            $stmt->close();
            header("Location: index.php");
            exit();
        }
        $stmt->close();
    } else {
        $_SESSION['register_error'] = "Terjadi kesalahan. Silakan coba lagi.";
        $_SESSION['active_form'] = 'register';
        header("Location: index.php");
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, class) VALUES (?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param('ssss', $name, $email, $password, $class);
        if (!$stmt->execute()) {
            $_SESSION['register_error'] = "Gagal mendaftar. Silakan coba lagi.";
            $_SESSION['active_form'] = 'register';
        }
        $stmt->close();
    } else {
        $_SESSION['register_error'] = "Gagal menyiapkan query. Silakan hubungi admin.";
        $_SESSION['active_form'] = 'register';
    }

    header("Location: index.php");
    exit();
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['name'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                // Simpan 'class' dari tabel users ke session.
                // Di tabel pendaftaran kolom dinamai 'class' (bukan 'role'),
                // jadi periksa nilai itu untuk menentukan ke mana redirect.
                $_SESSION['class'] = isset($user['class']) ? $user['class'] : '';
                if (!empty($_SESSION['class']) && strtoupper($_SESSION['class']) === 'ADMIN') {
                    header("Location: admin_page.php");
                } else {
                    header("Location: user_page.php");
                }
                $stmt->close();
                exit();
            }
        }
        $stmt->close();
    }

    $_SESSION['login_error'] = "Email atau Password salah!";
    $_SESSION['active_form'] = 'login';
    header("Location: index.php");
    exit();
}

?>