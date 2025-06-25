<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Login sederhana
    if ($username === "Tekno_" && $password === "Cibeber123") {
        $_SESSION['login'] = true;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Login gagal, coba lagi.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <style>
* {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: url('bg.jpg') no-repeat center center fixed;
      background-size: cover;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    .login-bg {
      background-color: rgba(0, 0, 0, 0.6); /* semi transparan hitam */
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 0;
    }

    .login-box {
      position: relative;
      z-index: 1;
      background-color: rgba(255, 255, 255, 0.95);
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
      width: 100%;
      max-width: 400px;
      text-align: center;
    }


    input[type="text"],

    input[type="password"] {
      width: 100%;
      padding: 12px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      transition: 0.3s ease;
    }

    button:hover {
      background-color: #45a049;
    }

    .login-footer {
      margin-top: 20px;
      font-size: 14px;
      color: #666;
    }

    @media (max-width: 500px) {
      .login-container {
        padding: 30px 20px;
      }
    }
    .login-box h2{

        margin-bottom: 40px;
    }
    </style>
</head>
<body class="login-bg">
    <div class="login-box">
        <h2>LOG-IN</h2>
        <?php if (!empty($error)) echo "<p style='color:red'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="username" required autofocus>
            <input type="password" name="password" placeholder="password" required>
            <button type="submit">Sign In</button>
        </form>
    </div>
</body>
</html>
