<?php
require_once '../db_connect.php';
require_once 'auth_check.php';

// Stats
$total_produk    = $conn->query("SELECT COUNT(*) c FROM produk")->fetch_assoc()['c'];
$total_pesanan   = $conn->query("SELECT COUNT(*) c FROM pesanan")->fetch_assoc()['c'];
$pending_pesanan = $conn->query("SELECT COUNT(*) c FROM pesanan WHERE status_pesanan='pending'")->fetch_assoc()['c'];
$total_revenue   = $conn->query("SELECT COALESCE(SUM(total_harga),0) s FROM pesanan WHERE status_pesanan IN ('selesai','dikirim')")->fetch_assoc()['s'];
$stok_habis      = $conn->query("SELECT COUNT(*) c FROM produk WHERE stok=0")->fetch_assoc()['c'];
$stok_rendah     = $conn->query("SELECT COUNT(*) c FROM produk WHERE stok>0 AND stok<=5")->fetch_assoc()['c'];

// Recent orders
$recent_orders = $conn->query("SELECT * FROM pesanan ORDER BY tanggal_pesanan DESC LIMIT 8");

// Recent products
$recent_products = $conn->query("SELECT * FROM produk ORDER BY id_produk DESC LIMIT 5");

$page_title = 'Dashboard';
$active = 'dashboard';
require_once 'includes/header.php';
?>

<!-- Stats Grid -->
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:28px">
  <div class="stat-card">
    <div class="icon-box" style="background:rgba(140,90,60,0.15);color:#C08552"><i class="fas fa-box"></i></div>
    <div style="font-size:28px;font-weight:700;color:#fff"><?= $total_produk ?></div>
    <div style="font-size:13px;color:rgba(255,255,255,0.4);margin-top:2px">Total Produk</div>
    <?php if($stok_habis>0): ?>
      <div style="margin-top:10px"><span class="badge badge-red"><i class="fas fa-circle" style="font-size:7px"></i> <?= $stok_habis ?> stok habis</span></div>
    <?php endif; ?>
  </div>
  <div class="stat-card">
    <div class="icon-box" style="background:rgba(59,130,246,0.15);color:#93c5fd"><i class="fas fa-receipt"></i></div>
    <div style="font-size:28px;font-weight:700;color:#fff"><?= $total_pesanan ?></div>
    <div style="font-size:13px;color:rgba(255,255,255,0.4);margin-top:2px">Total Pesanan</div>
    <?php if($pending_pesanan>0): ?>
      <div style="margin-top:10px"><span class="badge badge-yellow"><i class="fas fa-clock" style="font-size:9px"></i> <?= $pending_pesanan ?> pending</span></div>
    <?php endif; ?>
  </div>
  <div class="stat-card">
    <div class="icon-box" style="background:rgba(34,197,94,0.15);color:#4ade80"><i class="fas fa-coins"></i></div>
    <div style="font-size:26px;font-weight:700;color:#fff">Rp <?= number_format($total_revenue,0,',','.') ?></div>
    <div style="font-size:13px;color:rgba(255,255,255,0.4);margin-top:2px">Total Revenue</div>
    <div style="margin-top:10px"><span class="badge badge-green">Pesanan selesai</span></div>
  </div>
  <div class="stat-card">
    <div class="icon-box" style="background:rgba(234,179,8,0.15);color:#facc15"><i class="fas fa-triangle-exclamation"></i></div>
    <div style="font-size:28px;font-weight:700;color:#fff"><?= $stok_rendah + $stok_habis ?></div>
    <div style="font-size:13px;color:rgba(255,255,255,0.4);margin-top:2px">Perlu Restock</div>
    <div style="margin-top:10px"><span class="badge badge-yellow"><?= $stok_rendah ?> rendah</span></div>
  </div>
</div>

<!-- Two column layout -->
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">

  <!-- Recent Orders -->
  <div class="card" style="grid-column:1/-1">
    <div class="card-header">
      <div>
        <div style="font-size:15px;font-weight:600;color:#fff">Pesanan Terbaru</div>
        <div style="font-size:12px;color:rgba(255,255,255,0.35);margin-top:2px">8 pesanan terakhir</div>
      </div>
      <a href="pesanan.php" class="btn-secondary" style="font-size:13px;padding:7px 14px">Lihat Semua</a>
    </div>
    <div style="overflow-x:auto">
      <table>
        <thead>
          <tr>
            <th>#ID</th><th>Pembeli</th><th>Total</th><th>Status</th><th>Tanggal</th><th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php while($o = $recent_orders->fetch_assoc()): ?>
          <tr>
            <td style="color:rgba(255,255,255,0.4);font-size:12px">#<?= $o['id_pesanan'] ?></td>
            <td>
              <div style="font-weight:500"><?= htmlspecialchars($o['nama_pembeli']) ?></div>
              <div style="font-size:12px;color:rgba(255,255,255,0.35)"><?= htmlspecialchars($o['no_hp']) ?></div>
            </td>
            <td style="font-weight:600;color:#C08552">Rp <?= number_format($o['total_harga'],0,',','.') ?></td>
            <td>
              <?php
              $sb = ['pending'=>'badge-yellow','diproses'=>'badge-blue','dikirim'=>'badge-blue','selesai'=>'badge-green','dibatalkan'=>'badge-red'];
              $sc = $sb[$o['status_pesanan']] ?? 'badge-gray';
              ?>
              <span class="badge <?= $sc ?>"><?= ucfirst($o['status_pesanan']) ?></span>
            </td>
            <td style="color:rgba(255,255,255,0.4);font-size:12px"><?= date('d M Y', strtotime($o['tanggal_pesanan'])) ?></td>
            <td>
              <a href="pesanan.php?detail=<?= $o['id_pesanan'] ?>" class="btn-edit" style="padding:5px 10px;font-size:12px"><i class="fas fa-eye"></i></a>
            </td>
          </tr>
          <?php endwhile; ?>
          <?php if($total_pesanan==0): ?>
          <tr><td colspan="6" style="text-align:center;color:rgba(255,255,255,0.25);padding:32px">Belum ada pesanan</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Low Stock Products -->
  <div class="card">
    <div class="card-header">
      <div style="font-size:15px;font-weight:600;color:#fff">Stok Rendah / Habis</div>
    </div>
    <div style="overflow-x:auto">
      <table>
        <thead><tr><th>Produk</th><th>Stok</th><th></th></tr></thead>
        <tbody>
          <?php
          $low = $conn->query("SELECT * FROM produk WHERE stok <= 10 ORDER BY stok ASC LIMIT 6");
          while($p = $low->fetch_assoc()):
          ?>
          <tr>
            <td><?= htmlspecialchars($p['nama_produk']) ?></td>
            <td>
              <?php if($p['stok']==0): ?>
                <span class="badge badge-red">Habis</span>
              <?php elseif($p['stok']<=5): ?>
                <span class="badge badge-yellow"><?= $p['stok'] ?></span>
              <?php else: ?>
                <span class="badge badge-gray"><?= $p['stok'] ?></span>
              <?php endif; ?>
            </td>
            <td><a href="edit_produk.php?id=<?= $p['id_produk'] ?>" class="btn-edit" style="padding:4px 10px;font-size:12px"><i class="fas fa-pen"></i></a></td>
          </tr>
          <?php endwhile; ?>
          <?php $low->data_seek(0); if($low->num_rows===0): ?>
          <tr><td colspan="3" style="text-align:center;color:rgba(255,255,255,0.25);padding:24px">Semua stok aman ✓</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Quick Actions -->
  <div class="card">
    <div class="card-header"><div style="font-size:15px;font-weight:600;color:#fff">Aksi Cepat</div></div>
    <div class="card-body" style="display:flex;flex-direction:column;gap:10px">
      <a href="tambah_produk.php" class="btn-primary"><i class="fas fa-plus"></i> Tambah Produk Baru</a>
      <a href="produk.php" class="btn-secondary"><i class="fas fa-boxes-stacked"></i> Kelola Semua Produk</a>
      <a href="pesanan.php?filter=pending" class="btn-secondary"><i class="fas fa-clock"></i> Pesanan Pending (<?= $pending_pesanan ?>)</a>
      <a href="pembayaran.php" class="btn-secondary"><i class="fas fa-wallet"></i> Cek Pembayaran</a>
    </div>
  </div>

</div>

<?php require_once 'includes/footer.php'; ?>
