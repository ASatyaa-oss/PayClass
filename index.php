<?php

session_start();

$errors = [
    'login' => $_SESSION['login_error'] ?? '',
    'register' => $_SESSION['register_error'] ?? ''
];
$active_form = $_SESSION['active_form'] ?? 'login';

session_unset();

function showerror($error) {
    return !empty($error) ? "<p class='error-message'>$error</p>" : '';
}

function isActiveForm($formname, $active_form) {
    return $formname === $active_form ? 'active' : '';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Full-Stack Login & Register Form With User & Admin Page | Codehal</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<!-- LOGIN PAGE -->
    <div class="container">
        <div class="form-box <?= isActiveForm('login', $active_form); ?>" id="login-form"> 
            <form action="login_register.php" method="post">
                <h2>Login PayClass</h2>
                <?= showerror($errors['login']) ?>
                <input type="email" name="email" placeholder="Email" required>
                <input type="tel" name="phone" placeholder="No. Telepon" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Login</button>
                <p>Belum memiliki Akun? <a href="#" onclick="showForm('register-form'); return false;">Daftar</a></p>
            </form>
<!-- END LOGIN PAGE -->

<!-- REGISTER PAGE -->
        </div>

      <div class="form-box <?= isActiveForm('register', $active_form); ?>" id="register-form"> 
            <form action="login_register.php" method="post">
                <h2>Register PayClass</h2>
                <?= showerror($errors['register']) ?>
          <input type="text" name="name" placeholder="Nama Lengkap" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <select name="class" required>
                    <option value="" disabled selected>Select Class</option>
                    <option value="1KA24">1KA24</option>
                    <option value="1KA25">1KA25</option>
                    <option value="1KA26">1KA26</option>
                    <option value="1KA27">1KA27</option>
                </select>
                <button type="submit" name="register">Register</button>
                <p>Sudah memiliki Akun? <a href="#" onclick="showForm('login-form'); return false;">Masuk</a></p>
            </form>
        </div>
<!-- END LREGISTER PAGE -->

    </div>

    <script src="script.js"></script>
</body>

</html> 