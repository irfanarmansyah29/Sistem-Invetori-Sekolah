<?php
session_start();
include 'koneksi.php';

if (isset($_SESSION['login'])) {
    header("Location: index.php?page=dashboard");
    exit;
}

if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = md5($_POST['password']);

    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$user' AND password='$pass'");
    if (mysqli_num_rows($query) > 0) {
        $userData = mysqli_fetch_assoc($query);
        $_SESSION['login'] = true;
        $_SESSION['username'] = $userData['username'];
        $_SESSION['nama_lengkap'] = $userData['nama_lengkap'];
        header("Location: index.php?page=dashboard");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Inventori Sekolah</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background: url('inventaris.jpeg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .overlay {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 0;
        }
        .login-box {
            position: relative;
            z-index: 1;
            background: rgba(255,255,255,0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            width: 360px;
        }
        .login-box h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #00695c;
        }
        .login-box input[type=text],
        .login-box input[type=password] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }
        .login-box button {
            width: 100%;
            background: #00695c;
            color: white;
            padding: 12px;
            border: none;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }
        .login-box button:hover {
            background: #004d40;
        }
        .login-box .error {
            background: #ffebee;
            color: #d32f2f;
            padding: 10px;
            margin-bottom: 15px;
            text-align: center;
            border-radius: 6px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="login-box">
        <h2>Login Inventori</h2>
        <?php if (isset($error)): ?>
          <div class="error"><?= $error ?></div>
        <?php endif; ?>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Masuk</button>
        </form>
    </div>
</body>
</html>
