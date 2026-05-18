-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Bulan Mei 2026 pada 12.25
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko_kopi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admins`
--

CREATE TABLE `admins` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admins`
--

INSERT INTO `admins` (`id_admin`, `username`, `password`) VALUES
(1, 'admin_kopi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_detail` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_satuan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `metode_pembayaran` enum('transfer_bank','gopay','ovo','dana','shopeepay') NOT NULL,
  `status_pembayaran` enum('belum_bayar','lunas','gagal') DEFAULT 'belum_bayar',
  `bukti_bayar` varchar(255) DEFAULT NULL,
  `tanggal_bayar` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `nama_pembeli` varchar(100) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `alamat_pengiriman` text NOT NULL,
  `total_harga` int(11) NOT NULL,
  `status_pesanan` enum('pending','diproses','dikirim','selesai','dibatalkan') DEFAULT 'pending',
  `tanggal_pesanan` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `harga` int(11) NOT NULL,
  `unit` varchar(30) NOT NULL DEFAULT 'per cup',
  `stok` int(11) NOT NULL DEFAULT 0,
  `deskripsi` text DEFAULT NULL,
  `cup_score` decimal(4,2) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `kategori`, `harga`, `unit`, `stok`, `deskripsi`, `cup_score`, `gambar`) VALUES
(1, 'Gayo Natural Process — Lot 07A', 'roasted', 485000, 'per 250g', 24, 'Arabica · Sumatra · Natural. Tasting Notes: Dark Chocolate, Caramelized Plum, Cedar, Vanilla Cream.', 89.5, 'https://images.unsplash.com/photo-1447933601403-0c6688de566e?w=900&q=80'),
(2, 'AGGRO Signature Espresso', 'roasted', 195000, 'per 250g', 50, 'Roasted · Medium-Dark. Tasting Notes: Bittersweet Chocolate, Molasses, Toasted Nut.', 85.0, 'https://images.unsplash.com/photo-1477041897914-68a9c7b4f83f?w=700&q=80'),
(3, 'Gayo Aceh — Filter Roast', 'roasted', 235000, 'per 200g', 50, 'Roasted · Light. Tasting Notes: Earl Grey, Peach Nectar, Honey.', 88.0, 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=700&q=80'),
(4, 'Toraja Arabica — Lot 03', 'green', 280000, 'per kg', 50, 'Green Bean · Arabica. Tasting Notes: Brown Sugar, Apricot, Jasmine.', 86.0, 'https://images.unsplash.com/photo-1447933601403-0c6688de566e?w=700&q=80'),
(5, 'Flores Bajawa — Washed', 'green', 310000, 'per kg', 50, 'Green Bean · Washed. Tasting Notes: Red Cherry, Lemon Zest, Hazelnut.', 87.5, 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=700&q=80'),
(6, 'Java Ijen — Natural Robusta', 'green', 145000, 'per kg', 50, 'Green Bean · Robusta. Tasting Notes: Dark Spice, Tobacco Leaf, Earthy.', 83.0, 'https://images.unsplash.com/photo-1498804103079-a6351b050096?w=700&q=80'),
(7, 'AGGRO Cold Brew Concentrate', 'extract', 125000, 'per 500ml', 50, 'Extract · Cold Brew. Tasting Notes: Dark Cherry, Rum, Cocoa Nibs.', 84.5, 'https://images.unsplash.com/photo-1510591509098-f4fdc6d0ff04?w=700&q=80'),
(8, 'AGGRO Nitro Espresso Shot', 'extract', 45000, 'per can', 50, 'Extract · Nitro Shot. Tasting Notes: Cream, Bitter Almond, Fig.', 84.0, 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=700&q=80'),
(9, 'Smart Soil Sensor Node v2', 'kit', 1200000, 'per unit', 50, 'Smart Accessories · IoT. pH + Moisture, Solar Powered, 4G/LoRa.', NULL, 'https://images.unsplash.com/photo-1584464491033-06628f3a6b7b?w=700&q=80'),
(10, 'Pro Farm Starter Pack', 'kit', 8500000, 'full bundle', 50, 'Smart Accessories · Bundle. 6 Sensor Nodes, Gateway Hub, 1yr Premium.', NULL, 'https://images.unsplash.com/photo-1603386329225-868f9b1ee6c9?w=700&q=80');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_pesanan` (`id_pesanan`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admins`
--
ALTER TABLE `admins`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_pesanan_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`);

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
