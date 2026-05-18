<?php
require_once 'db_connect.php';
// cart.php
$activePage = 'cart';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle Add to Cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add' && isset($_POST['id_produk'])) {
        $id = (int)$_POST['id_produk'];
        $qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;
        
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] += $qty;
        } else {
            $_SESSION['cart'][$id] = $qty;
        }
        
        header("Location: cart.php");
        exit();
    }
    
    // Handle Remove from Cart
    if ($_POST['action'] === 'remove' && isset($_POST['id_produk'])) {
        $id = (int)$_POST['id_produk'];
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        header("Location: cart.php");
        exit();
    }
    
    // Handle Update Qty
    if ($_POST['action'] === 'update' && isset($_POST['id_produk']) && isset($_POST['qty'])) {
        $id = (int)$_POST['id_produk'];
        $qty = (int)$_POST['qty'];
        if ($qty > 0) {
            $_SESSION['cart'][$id] = $qty;
        } else {
            unset($_SESSION['cart'][$id]);
        }
        header("Location: cart.php");
        exit();
    }
}

// Calculate totals early for header
$total_items_in_cart = array_sum($_SESSION['cart']);
?>
<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Your Cart – AGGRO Premium Coffee</title>
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
  </head>

  <body class="bg-[#f5f0eb]">
    <nav class="fixed top-0 left-0 right-0 z-50 nav-fixed" id="navbar">
      <div
        class="max-w-[1540px] mx-auto px-6 w-full py-8 flex items-center justify-between"
      >
        <a
          href="index.php"
          class="logo text-white text-4xl tracking-widest"
          style="letter-spacing: 0.12em"
          >AGGRO</a
        >
        <div class="hidden md:flex items-center gap-8">
          <a
            href="services.php"
            class="text-white/80 hover:text-white text-xl font-medium transition-colors"
            >Services</a
          >
          <a
            href="product.php"
            class="text-white/80 hover:text-white text-xl font-medium transition-colors"
            >Shop</a
          >
          <a
            href="about.php"
            class="text-white/80 hover:text-white text-xl font-medium transition-colors"
            >About</a
          >
        </div>
        <a href="cart.php" class="btn-outline text-xl">Cart (<?php echo $total_items_in_cart; ?>)</a>
      </div>
    </nav>

    <section
      class="product-hero w-full min-h-[50vh] flex flex-col justify-end pb-16 pt-36 rounded-b-[30px] overflow-hidden relative"
    >
      <div
        class="grain-overlay absolute inset-0 pointer-events-none z-10"
      ></div>

      <div class="max-w-[1540px] mx-auto px-6 w-full relative z-20">
        <div class="flex flex-col gap-4">
          <div class="anim-1">
            <p class="product-eyebrow mb-2">Review Your Order</p>
            <h1 class="product-hero-title anim-2 text-white">
              Shopping <span class="text-[#C08552]">Cart.</span>
            </h1>
          </div>
          <div class="anim-3 max-w-xl">
            <p class="product-hero-sub text-white/60">
              Pastikan pilihan <i>roast profile</i>, varietas biji hijau, atau
              kuantitas <i>smart accessories</i> Anda sudah sesuai sebelum
              melanjutkan ke tahap pembayaran.
            </p>
          </div>
        </div>
      </div>
    </section>

    <section class="py-24 px-6">
      <div class="max-w-[1540px] mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-[7fr_4fr] gap-12 items-start">
          <div class="flex flex-col gap-6 reveal">
            <div
              class="border-b border-gray-200 pb-4 flex justify-between items-end"
            >
              <h2
                class="font-display font-extrabold text-[#1a1a1a] text-2xl md:text-3xl"
              >
                Selected Products
              </h2>
              <p class="font-body text-sm text-gray-400"><?php echo $total_items_in_cart; ?> Items in your bag</p>
            </div>

            <div class="flex flex-col gap-4">
<?php
$subtotal = 0;
$total_items = 0;

if (empty($_SESSION['cart'])) {
    echo "<div class='bg-white p-10 rounded-2xl border border-gray-100 shadow-sm text-center'>";
    echo "<p class='text-gray-500 font-body text-lg'>Keranjang Anda kosong.</p>";
    echo "</div>";
} else {
    $ids = implode(',', array_map('intval', array_keys($_SESSION['cart'])));
    $sql = "SELECT * FROM produk WHERE id_produk IN ($ids)";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row['id_produk'];
            $qty = $_SESSION['cart'][$id];
            $subtotal += $row['harga'] * $qty;
            $total_items += $qty;
            
            $cat = htmlspecialchars($row['kategori']);
            $nama = htmlspecialchars($row['nama_produk']);
            $harga = number_format($row['harga'], 0, ',', '.');
            $unit = htmlspecialchars($row['unit']);
            $gambar = htmlspecialchars($row['gambar']);
?>
              <div
                class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6"
              >
                <div class="flex gap-5 items-center">
                  <div
                    class="w-20 h-20 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0"
                  >
                    <img
                      src="<?php echo $gambar; ?>"
                      alt="<?php echo $nama; ?>"
                      class="w-full h-full object-cover"
                    />
                  </div>
                  <div>
                    <span
                      class="text-xs font-body font-semibold text-[#C08552] uppercase tracking-wider"
                      ><?php echo $cat; ?></span
                    >
                    <h3
                      class="font-display font-bold text-lg text-[#1a1a1a] mt-0.5"
                    >
                      <?php echo $nama; ?>
                    </h3>
                    <p class="text-gray-400 text-xs font-body mt-0.5">
                      <?php echo $unit; ?>
                    </p>
                  </div>
                </div>
                <div
                  class="flex sm:flex-col justify-between items-end w-full sm:w-auto border-t sm:border-t-0 border-gray-100 pt-4 sm:pt-0"
                >
                  <span class="font-display font-bold text-[#1a1a1a] text-lg"
                    >Rp <?php echo $harga; ?></span
                  >
                  <div class="flex items-center gap-4 mt-2">
                    <div
                      class="flex items-center border border-gray-200 rounded-lg bg-[#fafaf8]"
                    >
                      <form action="cart.php" method="POST" class="inline m-0 p-0">
                          <input type="hidden" name="action" value="update">
                          <input type="hidden" name="id_produk" value="<?php echo $id; ?>">
                          <input type="hidden" name="qty" value="<?php echo $qty - 1; ?>">
                          <button type="submit" class="px-3 py-1 text-gray-500 hover:text-black font-body font-bold">-</button>
                      </form>
                      <span class="px-3 py-1 text-sm font-body font-semibold text-gray-800"><?php echo $qty; ?></span>
                      <form action="cart.php" method="POST" class="inline m-0 p-0">
                          <input type="hidden" name="action" value="update">
                          <input type="hidden" name="id_produk" value="<?php echo $id; ?>">
                          <input type="hidden" name="qty" value="<?php echo $qty + 1; ?>">
                          <button type="submit" class="px-3 py-1 text-gray-500 hover:text-black font-body font-bold">+</button>
                      </form>
                    </div>
                    <form action="cart.php" method="POST" class="inline m-0 p-0">
                        <input type="hidden" name="action" value="remove">
                        <input type="hidden" name="id_produk" value="<?php echo $id; ?>">
                        <button type="submit" class="text-gray-400 hover:text-red-500 text-sm transition-colors">
                          <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </form>
                  </div>
                </div>
              </div>
<?php
        }
    }
}

$ppn = $subtotal * 0.11;
$total = $subtotal + $ppn;
?>
            </div>

            <div class="mt-4">
              <a
                href="product.php"
                class="text-sm font-body font-semibold text-[#primary] hover:text-[#C08552] inline-flex items-center gap-2 transition-colors"
              >
                <i class="fa-solid fa-arrow-left-long"></i> Continue Shopping
              </a>
            </div>
          </div>

          <div
            class="bg-white p-8 rounded-3xl border border-gray-100 shadow-md flex flex-col gap-6 reveal"
          >
            <div>
              <span class="section-tag">Total Summary</span>
              <h3 class="font-display font-bold text-2xl text-[#1a1a1a] mt-1">
                Order Summary
              </h3>
            </div>

            <div class="flex flex-col gap-2 border-b border-gray-100 pb-6">
              <label
                class="font-body text-xs font-semibold text-gray-400 uppercase tracking-wider"
                >Have a promo code?</label
              >
              <div class="flex gap-2">
                <input
                  type="text"
                  placeholder="AGGROBEANS"
                  class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-[#C08552] bg-[#fafaf8] font-body text-sm text-gray-800 uppercase tracking-wider transition-colors"
                />
                <button
                  type="button"
                  class="bg-[#1a1a1a] text-white font-body font-semibold text-xs px-5 rounded-xl hover:bg-[#C08552] transition-colors uppercase"
                >
                  Apply
                </button>
              </div>
            </div>

            <div
              class="flex flex-col gap-3 font-body text-sm text-gray-600 border-b border-gray-100 pb-6"
            >
              <div class="flex justify-between">
                <span>Subtotal (<?php echo $total_items; ?> items)</span>
                <span class="font-semibold text-[#1a1a1a]">Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></span>
              </div>
              <div class="flex justify-between">
                <span>Estimasi Pengiriman (Shipping)</span>
                <span class="font-semibold text-green-600">FREE</span>
              </div>
              <div class="flex justify-between">
                <span>Pajak (PPN 11%)</span>
                <span class="font-semibold text-[#1a1a1a]">Rp <?php echo number_format($ppn, 0, ',', '.'); ?></span>
              </div>
            </div>

            <div class="flex justify-between items-baseline">
              <span class="font-display font-bold text-lg text-[#1a1a1a]"
                >Total Pembayaran</span
              >
              <span class="font-display font-extrabold text-[#8C5A3C] text-3xl"
                >Rp <?php echo number_format($total, 0, ',', '.'); ?></span
              >
            </div>

            <div class="flex flex-col gap-3 mt-4">
              <a
                href="checkout.php"
                class="btn-primary-brown w-full justify-center text-center py-4 cursor-pointer"
              >
                <i class="fa-solid fa-lock mr-2 text-xs"></i> Proceed to
                Checkout
              </a>
              <p class="text-center font-body text-[0.72rem] text-gray-400">
                <i class="fa-solid fa-shield-halved mr-1 text-[#C08552]"></i>
                Secure SSL checkout powered by midtrans/QRIS.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <footer class="py-11 px-6 md:px-10">
      <div class="max-w-[1540px] mx-auto">
        <div
          class="grid grid-cols-2 md:grid-cols-[2fr_1fr_1fr_1fr_1fr] gap-x-8 gap-y-10"
        >
          <div class="col-span-2 md:col-span-1 flex flex-col gap-3">
            <h2
              class="logo text-[2.6rem] tracking-tight text-black leading-none"
            >
              AGGRO
            </h2>
            <p
              class="font-body text-[0.82rem] text-[#6b6b6b] leading-relaxed max-w-[200px]"
            >
              Menjaga tradisi, merangkul <i>modern innovations</i> untuk
              industri kopi yang lebih baik.
            </p>
            <div class="flex gap-4 mt-2">
              <a href="#" class="social-icon"
                ><i
                  class="fa-brands fa-instagram text-[#6b6b6b] hover:text-[#C08552]"
                ></i
              ></a>
              <a href="#" class="social-icon"
                ><i
                  class="fa-brands fa-linkedin text-[#6b6b6b] hover:text-[#C08552]"
                ></i
              ></a>
              <a href="#" class="social-icon"
                ><i
                  class="fa-brands fa-x-twitter text-[#6b6b6b] hover:text-[#C08552]"
                ></i
              ></a>
            </div>
          </div>
          <div class="flex flex-col gap-3">
            <h3 class="font-body font-semibold text-[0.9rem] text-black">
              Shop
            </h3>
            <ul class="flex flex-col gap-2">
              <li>
                <a href="#" class="nav-link text-black font-body text-sm"
                  >All Coffee</a
                >
              </li>
              <li>
                <a href="#" class="nav-link text-black font-body text-sm"
                  >Subscriptions</a
                >
              </li>
              <li>
                <a href="#" class="nav-link text-black font-body text-sm"
                  >Smart Accessories</a
                >
              </li>
            </ul>
          </div>
          <div class="flex flex-col gap-3">
            <h3 class="font-body font-semibold text-[0.9rem] text-black">
              Company
            </h3>
            <ul class="flex flex-col gap-2">
              <li>
                <a
                  href="about.php"
                  class="nav-link text-black font-body text-sm"
                  >About Us</a
                >
              </li>
              <li>
                <a
                  href="contact.php"
                  class="nav-link text-black font-body text-sm"
                  >Contact</a
                >
              </li>
              <li>
                <a href="#" class="nav-link text-black font-body text-sm"
                  >Careers</a
                >
              </li>
            </ul>
          </div>
          <div class="flex flex-col gap-3">
            <h3 class="font-body font-semibold text-[0.9rem] text-black">
              Services
            </h3>
            <ul class="flex flex-col gap-2">
              <li>
                <a href="#" class="nav-link text-black font-body text-sm"
                  >Wholesale B2B</a
                >
              </li>
              <li>
                <a href="#" class="nav-link text-black font-body text-sm"
                  >Private Label</a
                >
              </li>
              <li>
                <a href="#" class="nav-link text-black font-body text-sm"
                  >Barista Training</a
                >
              </li>
            </ul>
          </div>
          <div class="flex flex-col gap-3">
            <h3 class="font-body font-semibold text-[0.9rem] text-black">
              Support
            </h3>
            <ul class="flex flex-col gap-2">
              <li>
                <a href="#" class="nav-link text-black font-body text-sm"
                  >Shipping Policy</a
                >
              </li>
              <li>
                <a href="#" class="nav-link text-black font-body text-sm"
                  >Help Center</a
                >
              </li>
              <li>
                <a href="#" class="nav-link text-black font-body text-sm"
                  >Return Policy</a
                >
              </li>
            </ul>
          </div>
        </div>
        <div
          class="border-t border-gray-200 mt-10 pt-6 flex flex-col md:flex-row items-center justify-between gap-4"
        >
          <p class="font-body text-xs text-gray-400">
            © 2026 AGGRO. All rights reserved.
          </p>
          <div class="flex gap-6">
            <a
              href="#"
              class="font-body text-xs text-gray-400 hover:text-gray-600 transition-colors"
              >Privacy Policy</a
            >
            <a
              href="#"
              class="font-body text-xs text-gray-400 hover:text-gray-600 transition-colors"
              >Terms of Service</a
            >
          </div>
        </div>
      </div>
    </footer>

    <script src="assests/js/navbar-scrollbar.js"></script>
  </body>
</html>