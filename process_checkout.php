<?php
require_once 'db_connect.php';

// Pastikan ada item di keranjang & request adalah POST
if (empty($_SESSION['cart']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: product.php");
    exit();
}

// ==========================================
// 1. Ambil & Validasi Data dari Form
// ==========================================
$nama_pembeli     = trim($_POST['nama_pembeli'] ?? '');
$no_hp            = trim($_POST['no_hp'] ?? '');
$alamat_jalan     = trim($_POST['alamat'] ?? '');
$provinsi         = trim($_POST['provinsi'] ?? '');
$kota             = trim($_POST['kota'] ?? '');
$kode_pos         = trim($_POST['kode_pos'] ?? '');
$metode_pengiriman = $_POST['shipping'] ?? 'priority';
$metode_pembayaran = $_POST['payment'] ?? 'qris';

if (!$nama_pembeli || !$no_hp || !$alamat_jalan) {
    header("Location: checkout.php");
    exit();
}

// Gabungkan alamat lengkap
$alamat_lengkap = $alamat_jalan . ', ' . $kota . ', ' . $provinsi . ', ' . $kode_pos;

// ==========================================
// 2. Hitung Total Harga di Server (Aman)
// ==========================================
$subtotal = 0;
$ids = implode(',', array_map('intval', array_keys($_SESSION['cart'])));
$sql = "SELECT id_produk, harga FROM produk WHERE id_produk IN ($ids)";
$result = $conn->query($sql);
$produk_data = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $produk_data[$row['id_produk']] = $row['harga'];
        $subtotal += $row['harga'] * $_SESSION['cart'][$row['id_produk']];
    }
}
$ppn   = $subtotal * 0.11;
$total = (int)round($subtotal + $ppn);

// ==========================================
// 3. Simpan ke Tabel `pesanan`
// ==========================================
$stmt = $conn->prepare(
    "INSERT INTO pesanan (nama_pembeli, no_hp, alamat_pengiriman, total_harga) VALUES (?, ?, ?, ?)"
);
$stmt->bind_param("sssi", $nama_pembeli, $no_hp, $alamat_lengkap, $total);
$stmt->execute();
$id_pesanan = $stmt->insert_id;
$stmt->close();

// ==========================================
// 4. Simpan ke Tabel `detail_pesanan`
// ==========================================
$stmt_detail = $conn->prepare(
    "INSERT INTO detail_pesanan (id_pesanan, id_produk, jumlah, harga_satuan) VALUES (?, ?, ?, ?)"
);
foreach ($_SESSION['cart'] as $id_produk => $jumlah) {
    $harga_satuan = $produk_data[$id_produk] ?? 0;
    $stmt_detail->bind_param("iiii", $id_pesanan, $id_produk, $jumlah, $harga_satuan);
    $stmt_detail->execute();
}
$stmt_detail->close();

// ==========================================
// 5. Simpan ke Tabel `pembayaran`
// ==========================================
// Mapping pilihan form ke enum database
$map_metode = [
    'qris'     => 'qris',
    'va'       => 'transfer_bank',
    'cc'       => 'transfer_bank',
];
$metode_db = $map_metode[$metode_pembayaran] ?? 'qris';

$stmt_bayar = $conn->prepare(
    "INSERT INTO pembayaran (id_pesanan, metode_pembayaran, status_pembayaran) VALUES (?, ?, 'belum_bayar')"
);
$stmt_bayar->bind_param("is", $id_pesanan, $metode_db);
$stmt_bayar->execute();
$stmt_bayar->close();

// ==========================================
// 6. Kosongkan Keranjang
// ==========================================
$_SESSION['cart'] = [];

// ==========================================
// 7. Alihkan ke Halaman Sukses
// ==========================================
header("Location: success.php?order=" . $id_pesanan);
exit();
?>
