<?php
// admin/includes/header.php
// $page_title must be set before including this
$page_title = $page_title ?? 'Dashboard';
$active = $active ?? '';
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= htmlspecialchars($page_title) ?> — AGGRO Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link rel="stylesheet" href="../assests/variables.css"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; }
    body { font-family: 'Outfit', sans-serif; background: #0d1a0e; color: #fff; min-height: 100vh; display: flex; }

    /* Sidebar */
    .sidebar {
      width: 260px; min-height: 100vh;
      background: rgba(255,255,255,0.03);
      border-right: 1px solid rgba(255,255,255,0.07);
      display: flex; flex-direction: column;
      position: fixed; top: 0; left: 0; bottom: 0; z-index: 50;
      transition: transform 0.3s ease;
    }
    .sidebar.hidden-mobile { transform: translateX(-100%); }
    .sidebar-logo {
      font-family: 'Bebas Neue', sans-serif;
      letter-spacing: 0.2em; font-size: 26px; color: #fff;
      padding: 28px 24px 10px;
      display: flex; align-items: center; gap: 10px;
    }
    .sidebar-logo small {
      font-family: 'Outfit', sans-serif;
      font-size: 10px; letter-spacing: 0.15em;
      color: #C08552; background: rgba(140,90,60,0.2);
      border: 1px solid rgba(140,90,60,0.35);
      padding: 2px 8px; border-radius: 100px;
      font-weight: 600; text-transform: uppercase;
    }
    .sidebar-divider { border-color: rgba(255,255,255,0.07); margin: 12px 24px; }
    .nav-section-label {
      font-size: 10px; font-weight: 600; letter-spacing: 0.15em;
      color: rgba(255,255,255,0.25); text-transform: uppercase;
      padding: 8px 24px 4px;
    }
    .nav-item {
      display: flex; align-items: center; gap: 12px;
      padding: 11px 24px;
      color: rgba(255,255,255,0.55);
      text-decoration: none;
      border-radius: 0; font-size: 14px; font-weight: 500;
      transition: all 0.2s; position: relative;
    }
    .nav-item i { width: 18px; text-align: center; font-size: 15px; }
    .nav-item:hover { color: #fff; background: rgba(255,255,255,0.04); }
    .nav-item.active {
      color: #C08552;
      background: rgba(140,90,60,0.12);
    }
    .nav-item.active::before {
      content: ''; position: absolute; left: 0; top: 0; bottom: 0;
      width: 3px; background: #8C5A3C; border-radius: 0 2px 2px 0;
    }
    .sidebar-footer {
      margin-top: auto; padding: 16px 24px;
      border-top: 1px solid rgba(255,255,255,0.07);
    }
    .user-badge {
      display: flex; align-items: center; gap: 10px;
      background: rgba(255,255,255,0.04);
      border: 1px solid rgba(255,255,255,0.08);
      border-radius: 12px; padding: 10px 14px;
    }
    .user-avatar {
      width: 34px; height: 34px; border-radius: 50%;
      background: linear-gradient(135deg, #8C5A3C, #C08552);
      display: flex; align-items: center; justify-content: center;
      font-size: 14px; font-weight: 600; color: #fff; flex-shrink: 0;
    }
    .logout-link {
      display: flex; align-items: center; gap: 8px;
      color: rgba(239,68,68,0.7); font-size: 13px; font-weight: 500;
      text-decoration: none; margin-top: 10px; padding: 6px 0;
      transition: color 0.2s;
    }
    .logout-link:hover { color: #f87171; }

    /* Main content */
    .main-content { margin-left: 260px; flex: 1; min-height: 100vh; display: flex; flex-direction: column; }
    .topbar {
      background: rgba(255,255,255,0.02);
      border-bottom: 1px solid rgba(255,255,255,0.06);
      padding: 16px 32px; display: flex; align-items: center; justify-content: space-between;
      position: sticky; top: 0; z-index: 40; backdrop-filter: blur(10px);
    }
    .page-title-bar h1 { font-size: 20px; font-weight: 600; color: #fff; }
    .page-title-bar p { font-size: 13px; color: rgba(255,255,255,0.35); margin-top: 1px; }
    .content-area { padding: 32px; flex: 1; }

    /* Cards & UI */
    .card {
      background: rgba(255,255,255,0.04);
      border: 1px solid rgba(255,255,255,0.08);
      border-radius: 16px; overflow: hidden;
    }
    .card-header {
      padding: 20px 24px; border-bottom: 1px solid rgba(255,255,255,0.06);
      display: flex; align-items: center; justify-content: space-between;
    }
    .card-body { padding: 24px; }
    .stat-card {
      background: rgba(255,255,255,0.04);
      border: 1px solid rgba(255,255,255,0.08);
      border-radius: 16px; padding: 24px; position: relative; overflow: hidden;
    }
    .stat-card .icon-box {
      width: 44px; height: 44px; border-radius: 12px;
      display: flex; align-items: center; justify-content: center;
      font-size: 18px; margin-bottom: 16px;
    }
    .btn-primary {
      display: inline-flex; align-items: center; gap: 7px;
      background: linear-gradient(135deg, #8C5A3C, #C08552);
      color: #fff; border: none; cursor: pointer;
      padding: 9px 18px; border-radius: 10px;
      font-family: 'Outfit', sans-serif; font-size: 14px; font-weight: 600;
      text-decoration: none; transition: all 0.2s;
    }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(140,90,60,0.35); }
    .btn-secondary {
      display: inline-flex; align-items: center; gap: 7px;
      background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.1);
      color: rgba(255,255,255,0.8); cursor: pointer;
      padding: 9px 18px; border-radius: 10px;
      font-family: 'Outfit', sans-serif; font-size: 14px; font-weight: 500;
      text-decoration: none; transition: all 0.2s;
    }
    .btn-secondary:hover { background: rgba(255,255,255,0.1); color: #fff; }
    .btn-danger {
      display: inline-flex; align-items: center; gap: 7px;
      background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.25);
      color: #f87171; cursor: pointer;
      padding: 7px 14px; border-radius: 8px;
      font-family: 'Outfit', sans-serif; font-size: 13px; font-weight: 500;
      text-decoration: none; transition: all 0.2s;
    }
    .btn-danger:hover { background: rgba(239,68,68,0.2); }
    .btn-edit {
      display: inline-flex; align-items: center; gap: 7px;
      background: rgba(59,130,246,0.1); border: 1px solid rgba(59,130,246,0.25);
      color: #93c5fd; cursor: pointer;
      padding: 7px 14px; border-radius: 8px;
      font-family: 'Outfit', sans-serif; font-size: 13px; font-weight: 500;
      text-decoration: none; transition: all 0.2s;
    }
    .btn-edit:hover { background: rgba(59,130,246,0.2); }
    .badge {
      display: inline-flex; align-items: center; gap: 5px;
      padding: 3px 10px; border-radius: 100px;
      font-size: 12px; font-weight: 600;
    }
    .badge-green { background: rgba(34,197,94,0.12); color: #4ade80; border: 1px solid rgba(34,197,94,0.25); }
    .badge-yellow { background: rgba(234,179,8,0.12); color: #facc15; border: 1px solid rgba(234,179,8,0.25); }
    .badge-red { background: rgba(239,68,68,0.12); color: #f87171; border: 1px solid rgba(239,68,68,0.25); }
    .badge-blue { background: rgba(59,130,246,0.12); color: #93c5fd; border: 1px solid rgba(59,130,246,0.25); }
    .badge-gray { background: rgba(255,255,255,0.06); color: rgba(255,255,255,0.5); border: 1px solid rgba(255,255,255,0.1); }
    table { width: 100%; border-collapse: collapse; }
    thead tr { border-bottom: 1px solid rgba(255,255,255,0.06); }
    thead th { padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: rgba(255,255,255,0.35); letter-spacing: 0.06em; text-transform: uppercase; }
    tbody tr { border-bottom: 1px solid rgba(255,255,255,0.04); transition: background 0.15s; }
    tbody tr:hover { background: rgba(255,255,255,0.02); }
    tbody tr:last-child { border-bottom: none; }
    td { padding: 14px 16px; font-size: 14px; color: rgba(255,255,255,0.8); vertical-align: middle; }
    .input-field {
      background: rgba(255,255,255,0.05);
      border: 1px solid rgba(255,255,255,0.1);
      color: #fff; padding: 10px 14px; border-radius: 10px;
      font-family: 'Outfit', sans-serif; font-size: 14px; outline: none; transition: all 0.2s;
    }
    .input-field:focus { border-color: rgba(140,90,60,0.5); box-shadow: 0 0 0 3px rgba(140,90,60,0.1); }
    .input-field::placeholder { color: rgba(255,255,255,0.25); }
    select.input-field option { background: #1a2e1b; }
    textarea.input-field { resize: vertical; min-height: 90px; }
    label { display: block; font-size: 13px; font-weight: 500; color: rgba(255,255,255,0.5); margin-bottom: 6px; }
    .form-group { margin-bottom: 18px; }
    .alert-success {
      background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.25);
      color: #4ade80; padding: 12px 16px; border-radius: 10px;
      font-size: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;
    }
    .alert-error {
      background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3);
      color: #fca5a5; padding: 12px 16px; border-radius: 10px;
      font-size: 14px; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;
    }
    /* Mobile overlay */
    .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 45; }
    @media (max-width: 768px) {
      .sidebar { transform: translateX(-100%); }
      .sidebar.open { transform: translateX(0); }
      .main-content { margin-left: 0; }
      .sidebar-overlay.show { display: block; }
    }
  </style>
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
  <div class="sidebar-logo">
    AGGRO <small>Admin</small>
  </div>
  <hr class="sidebar-divider"/>

  <span class="nav-section-label">Overview</span>
  <a href="dashboard.php" class="nav-item <?= $active==='dashboard'?'active':'' ?>">
    <i class="fas fa-chart-pie"></i> Dashboard
  </a>

  <span class="nav-section-label" style="margin-top:8px">Katalog</span>
  <a href="produk.php" class="nav-item <?= $active==='produk'?'active':'' ?>">
    <i class="fas fa-box"></i> Manajemen Produk
  </a>
  <a href="tambah_produk.php" class="nav-item <?= $active==='tambah_produk'?'active':'' ?>">
    <i class="fas fa-plus-circle"></i> Tambah Produk
  </a>

  <span class="nav-section-label" style="margin-top:8px">Transaksi</span>
  <a href="pesanan.php" class="nav-item <?= $active==='pesanan'?'active':'' ?>">
    <i class="fas fa-receipt"></i> Pesanan
  </a>
  <a href="pembayaran.php" class="nav-item <?= $active==='pembayaran'?'active':'' ?>">
    <i class="fas fa-wallet"></i> Pembayaran
  </a>
  <span class="nav-section-label" style="margin-top:8px">AI Fitur</span>
  <a href="chatbot.php" class="nav-item <?= $active==='chatbot'?'active':'' ?>">
    <i class="fas fa-robot"></i> Chatbot AI
  </a>

  <div class="sidebar-footer">
    <div class="user-badge">
      <div class="user-avatar"><?= strtoupper(substr($_SESSION['admin_user']??'A',0,1)) ?></div>
      <div>
        <div style="font-size:13px;font-weight:600;color:#fff"><?= htmlspecialchars($_SESSION['admin_user']??'Admin') ?></div>
        <div style="font-size:11px;color:rgba(255,255,255,0.35)">Administrator</div>
      </div>
    </div>
    <a href="logout.php" class="logout-link"><i class="fas fa-right-from-bracket"></i> Keluar</a>
  </div>
</aside>

<!-- Main -->
<div class="main-content">
  <!-- Topbar -->
  <header class="topbar">
    <div style="display:flex;align-items:center;gap:16px">
      <button onclick="toggleSidebar()" style="display:none;background:none;border:none;color:rgba(255,255,255,0.6);font-size:18px;cursor:pointer" id="menuBtn"><i class="fas fa-bars"></i></button>
      <div class="page-title-bar">
        <h1><?= htmlspecialchars($page_title) ?></h1>
        <p>AGGRO Admin Panel</p>
      </div>
    </div>
    <div style="display:flex;align-items:center;gap:12px">
      <a href="../index.php" target="_blank" class="btn-secondary" style="font-size:13px;padding:7px 14px">
        <i class="fas fa-arrow-up-right-from-square"></i> Lihat Toko
      </a>
    </div>
  </header>

  <!-- Flash messages (session-based) -->
  <?php if (!empty($_SESSION['flash_success'])): ?>
    <div style="padding:16px 32px 0">
      <div class="alert-success"><i class="fas fa-circle-check"></i> <?= htmlspecialchars($_SESSION['flash_success']) ?></div>
    </div>
    <?php unset($_SESSION['flash_success']); ?>
  <?php endif; ?>
  <?php if (!empty($_SESSION['flash_error'])): ?>
    <div style="padding:16px 32px 0">
      <div class="alert-error"><i class="fas fa-circle-exclamation"></i> <?= htmlspecialchars($_SESSION['flash_error']) ?></div>
    </div>
    <?php unset($_SESSION['flash_error']); ?>
  <?php endif; ?>

  <div class="content-area">
