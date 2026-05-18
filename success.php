<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pesanan Berhasil – AGGRO Premium Coffee</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="assests/variables.css" />
    <link rel="stylesheet" href="assests/product.css" />
    <script src="assests/tailwind-config.js"></script>
    <style>
      body { font-family: 'Outfit', sans-serif; background: #f5f0eb; }
      @keyframes checkmark-pop {
        0% { transform: scale(0); opacity: 0; }
        70% { transform: scale(1.2); opacity: 1; }
        100% { transform: scale(1); opacity: 1; }
      }
      .checkmark-anim { animation: checkmark-pop 0.6s cubic-bezier(.22,.68,0,1.2) 0.2s both; }
      @keyframes fade-up {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
      }
      .fade-up { animation: fade-up 0.7s ease 0.5s both; }
      .fade-up-2 { animation: fade-up 0.7s ease 0.75s both; }
    </style>
  </head>
  <body>
<?php
require_once 'db_connect.php';
$id_pesanan = isset($_GET['order']) ? (int)$_GET['order'] : 0;

// Ambil detail pesanan dari database
$pesanan = null;
if ($id_pesanan > 0) {
    $stmt = $conn->prepare("SELECT * FROM pesanan WHERE id_pesanan = ?");
    $stmt->bind_param("i", $id_pesanan);
    $stmt->execute();
    $result = $stmt->get_result();
    $pesanan = $result->fetch_assoc();
    $stmt->close();
}

if (!$pesanan) {
    header("Location: product.php");
    exit();
}

$total_fmt = 'Rp ' . number_format($pesanan['total_harga'], 0, ',', '.');
$tanggal   = date('d F Y, H:i', strtotime($pesanan['tanggal_pesanan']));
?>

    <nav class="fixed top-0 left-0 right-0 z-50 nav-fixed" id="navbar">
      <div class="max-w-[1540px] mx-auto px-6 w-full py-8 flex items-center justify-between">
        <a href="index.php" class="logo text-white text-4xl tracking-widest" style="letter-spacing: 0.12em">AGGRO</a>
        <div class="hidden md:flex items-center gap-8">
          <a href="services.php" class="text-white/80 hover:text-white text-xl font-medium transition-colors">Services</a>
          <a href="product.php" class="text-white/80 hover:text-white text-xl font-medium transition-colors">Shop</a>
          <a href="about.php" class="text-white/80 hover:text-white text-xl font-medium transition-colors">About</a>
        </div>
        <a href="cart.php" class="btn-outline text-xl">Cart (0)</a>
      </div>
    </nav>

    <section class="product-hero w-full min-h-[35vh] flex flex-col justify-end pb-12 pt-36 rounded-b-[30px] overflow-hidden relative">
      <div class="grain-overlay absolute inset-0 pointer-events-none z-10"></div>
      <div class="max-w-[1540px] mx-auto px-6 w-full relative z-20">
        <p class="product-eyebrow mb-1"><i class="fa-solid fa-shield-check mr-1 text-[#C08552]"></i> Pesanan Dikonfirmasi</p>
        <h1 class="product-hero-title text-white">Terima <span class="text-[#C08552]">Kasih!</span></h1>
      </div>
    </section>

    <section class="py-20 px-6">
      <div class="max-w-[760px] mx-auto">

        <div class="bg-white rounded-3xl border border-gray-100 shadow-md overflow-hidden fade-up">
          <!-- Header Sukses -->
          <div class="bg-gradient-to-br from-[#1a1a1a] to-[#2e1f0f] p-10 flex flex-col items-center gap-4 text-center">
            <div class="checkmark-anim w-20 h-20 rounded-full bg-[#C08552]/20 border-2 border-[#C08552] flex items-center justify-center">
              <i class="fa-solid fa-check text-[#C08552] text-3xl"></i>
            </div>
            <h2 class="font-display font-extrabold text-3xl text-white">Pesanan Berhasil Dibuat!</h2>
            <p class="font-body text-white/60 text-sm max-w-md">Pesanan Anda sedang kami proses. Tim AGGRO akan segera mempersiapkan <i>freshly roasted beans</i> Anda.</p>
          </div>

          <!-- Detail Pesanan -->
          <div class="p-8 flex flex-col gap-6">
            <div class="grid grid-cols-2 gap-4">
              <div class="bg-[#fafaf8] rounded-2xl p-5 border border-gray-100">
                <p class="font-body text-xs text-gray-400 uppercase tracking-wider mb-1">Nomor Pesanan</p>
                <p class="font-display font-bold text-xl text-[#1a1a1a]">#AGG-<?php echo str_pad($id_pesanan, 5, '0', STR_PAD_LEFT); ?></p>
              </div>
              <div class="bg-[#fafaf8] rounded-2xl p-5 border border-gray-100">
                <p class="font-body text-xs text-gray-400 uppercase tracking-wider mb-1">Total Pembayaran</p>
                <p class="font-display font-bold text-xl text-[#8C5A3C]"><?php echo $total_fmt; ?></p>
              </div>
              <div class="bg-[#fafaf8] rounded-2xl p-5 border border-gray-100">
                <p class="font-body text-xs text-gray-400 uppercase tracking-wider mb-1">Penerima</p>
                <p class="font-display font-bold text-lg text-[#1a1a1a]"><?php echo htmlspecialchars($pesanan['nama_pembeli']); ?></p>
              </div>
              <div class="bg-[#fafaf8] rounded-2xl p-5 border border-gray-100">
                <p class="font-body text-xs text-gray-400 uppercase tracking-wider mb-1">Tanggal Pesanan</p>
                <p class="font-body font-semibold text-sm text-[#1a1a1a]"><?php echo $tanggal; ?></p>
              </div>
            </div>

            <div class="bg-[#fafaf8] rounded-2xl p-5 border border-gray-100">
              <p class="font-body text-xs text-gray-400 uppercase tracking-wider mb-1">Alamat Pengiriman</p>
              <p class="font-body text-sm text-[#1a1a1a]"><?php echo htmlspecialchars($pesanan['alamat_pengiriman']); ?></p>
            </div>

            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 flex items-start gap-3">
              <i class="fa-solid fa-circle-info text-amber-500 mt-0.5"></i>
              <div>
                <p class="font-body font-semibold text-sm text-amber-800">Status Pembayaran: Menunggu Konfirmasi</p>
                <p class="font-body text-xs text-amber-700 mt-0.5">Silakan selesaikan pembayaran sesuai metode yang dipilih. Status pesanan akan diperbarui secara otomatis setelah pembayaran terverifikasi.</p>
              </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 mt-2">
              <a href="product.php" class="btn-primary-brown justify-center text-center py-4 w-full sm:w-auto sm:flex-1">
                <i class="fa-solid fa-bag-shopping mr-2"></i> Lanjut Belanja
              </a>
              <a href="index.php" class="border-2 border-[#1a1a1a] text-[#1a1a1a] font-body font-semibold px-8 py-4 rounded-full hover:bg-[#1a1a1a] hover:text-white transition-all text-center w-full sm:w-auto sm:flex-1">
                <i class="fa-solid fa-house mr-2"></i> Kembali ke Beranda
              </a>
            </div>
          </div>
        </div>

      </div>
    </section>

    <script src="assests/js/navbar-scrollbar.js"></script>
  </body>
</html>
