<?php
require_once '../db_connect.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username && $password) {
        $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $admin = $result->fetch_assoc();

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_id']   = $admin['id_admin'];
            $_SESSION['admin_user'] = $admin['username'];
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Username atau password salah.';
        }
    } else {
        $error = 'Mohon isi semua field.';
    }
}

// Redirect if already logged in
if (!empty($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Login — AGGRO</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link rel="stylesheet" href="../assests/variables.css"/>
  <style>
    * { box-sizing: border-box; }
    body {
      font-family: 'Outfit', sans-serif;
      background: #0d1a0e;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }
    .bg-grid {
      position: fixed; inset: 0; z-index: 0;
      background-image:
        linear-gradient(rgba(140,90,60,0.06) 1px, transparent 1px),
        linear-gradient(90deg, rgba(140,90,60,0.06) 1px, transparent 1px);
      background-size: 48px 48px;
    }
    .bg-glow {
      position: fixed;
      width: 500px; height: 500px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(140,90,60,0.18) 0%, transparent 70%);
      top: -100px; left: -100px;
      pointer-events: none;
    }
    .bg-glow-2 {
      position: fixed;
      width: 400px; height: 400px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(192,133,82,0.12) 0%, transparent 70%);
      bottom: -80px; right: -80px;
      pointer-events: none;
    }
    .login-card {
      position: relative; z-index: 10;
      background: rgba(255,255,255,0.04);
      border: 1px solid rgba(255,255,255,0.08);
      backdrop-filter: blur(20px);
      border-radius: 24px;
      padding: 48px 40px;
      width: 100%; max-width: 420px;
      box-shadow: 0 24px 64px rgba(0,0,0,0.4);
    }
    .logo-text {
      font-family: 'Bebas Neue', sans-serif;
      letter-spacing: 0.2em;
      color: #fff;
    }
    .admin-badge {
      display: inline-flex; align-items: center; gap: 6px;
      background: rgba(140,90,60,0.2);
      border: 1px solid rgba(140,90,60,0.4);
      color: #C08552;
      padding: 4px 14px; border-radius: 100px;
      font-size: 13px; font-weight: 500;
    }
    .input-group {
      position: relative; margin-bottom: 16px;
    }
    .input-group i {
      position: absolute; left: 16px; top: 50%; transform: translateY(-50%);
      color: rgba(255,255,255,0.3); font-size: 15px; pointer-events: none;
    }
    .input-field {
      width: 100%;
      background: rgba(255,255,255,0.05);
      border: 1px solid rgba(255,255,255,0.1);
      color: #fff;
      padding: 14px 16px 14px 44px;
      border-radius: 12px;
      font-family: 'Outfit', sans-serif;
      font-size: 15px;
      transition: all 0.2s;
      outline: none;
    }
    .input-field:focus {
      border-color: rgba(140,90,60,0.6);
      background: rgba(255,255,255,0.07);
      box-shadow: 0 0 0 3px rgba(140,90,60,0.12);
    }
    .input-field::placeholder { color: rgba(255,255,255,0.3); }
    .btn-login {
      width: 100%;
      background: linear-gradient(135deg, #8C5A3C, #C08552);
      color: #fff;
      border: none; cursor: pointer;
      padding: 14px;
      border-radius: 12px;
      font-family: 'Outfit', sans-serif;
      font-size: 16px; font-weight: 600;
      letter-spacing: 0.04em;
      transition: all 0.2s;
      margin-top: 8px;
    }
    .btn-login:hover {
      transform: translateY(-1px);
      box-shadow: 0 8px 24px rgba(140,90,60,0.4);
    }
    .btn-login:active { transform: translateY(0); }
    .error-box {
      background: rgba(239,68,68,0.1);
      border: 1px solid rgba(239,68,68,0.3);
      color: #fca5a5;
      padding: 12px 16px; border-radius: 10px;
      font-size: 14px; margin-bottom: 20px;
      display: flex; align-items: center; gap: 8px;
    }
    .divider { border-color: rgba(255,255,255,0.07); margin: 24px 0; }
    .password-toggle {
      position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
      color: rgba(255,255,255,0.3); cursor: pointer; font-size: 15px;
      transition: color 0.2s;
    }
    .password-toggle:hover { color: rgba(255,255,255,0.6); }
  </style>
</head>
<body>
  <div class="bg-grid"></div>
  <div class="bg-glow"></div>
  <div class="bg-glow-2"></div>

  <div class="login-card">
    <div class="text-center mb-8">
      <a href="../index.php" class="logo-text text-3xl block mb-3">AGGRO</a>
      <span class="admin-badge"><i class="fas fa-shield-halved"></i> Admin Panel</span>
      <p class="text-white/40 text-sm mt-3">Masuk untuk mengelola toko</p>
    </div>

    <?php if ($error): ?>
      <div class="error-box"><i class="fas fa-circle-exclamation"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="input-group">
        <i class="fas fa-user"></i>
        <input type="text" name="username" class="input-field" placeholder="Username admin" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required autofocus/>
      </div>
      <div class="input-group" style="position:relative;">
        <i class="fas fa-lock"></i>
        <input type="password" name="password" id="passwordField" class="input-field" placeholder="Password" required/>
        <span class="password-toggle" onclick="togglePassword()"><i class="fas fa-eye" id="eyeIcon"></i></span>
      </div>
      <button type="submit" class="btn-login">
        <i class="fas fa-arrow-right-to-bracket mr-2"></i> Masuk ke Dashboard
      </button>
    </form>

    <hr class="divider"/>
    <p class="text-center text-white/25 text-xs">
      &copy; <?= date('Y') ?> AGGRO Admin — Akses Terbatas
    </p>
  </div>

  <script>
    function togglePassword() {
      const f = document.getElementById('passwordField');
      const i = document.getElementById('eyeIcon');
      if (f.type === 'password') {
        f.type = 'text';
        i.classList.replace('fa-eye','fa-eye-slash');
      } else {
        f.type = 'password';
        i.classList.replace('fa-eye-slash','fa-eye');
      }
    }
  </script>
</body>
</html>
