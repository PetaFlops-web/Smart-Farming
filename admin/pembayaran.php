<?php
require_once '../db_connect.php';
require_once 'auth_check.php';

// Update payment status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_bayar'])) {
    $id_pembayaran = (int)$_POST['id_pembayaran'];
    $status = $_POST['status_pembayaran'];
    $allowed = ['belum_bayar','lunas','gagal'];
    if (in_array($status, $allowed)) {
        $stmt = $conn->prepare("UPDATE pembayaran SET status_pembayaran=? WHERE id_pembayaran=?");
        $stmt->bind_param("si", $status, $id_pembayaran);
        $stmt->execute();
        // If lunas -> auto update pesanan to diproses
        if ($status === 'lunas') {
            $row = $conn->query("SELECT id_pesanan FROM pembayaran WHERE id_pembayaran=$id_pembayaran")->fetch_assoc();
            if ($row) {
                $conn->query("UPDATE pesanan SET status_pesanan='diproses' WHERE id_pesanan={$row['id_pesanan']} AND status_pesanan='pending'");
            }
        }
        $_SESSION['flash_success'] = "Status pembayaran diperbarui.";
    }
    header('Location: pembayaran.php');
    exit;
}

$filter = $_GET['filter'] ?? '';
$where  = $filter ? "WHERE pb.status_pembayaran='$filter'" : '';

$payments = $conn->query("
  SELECT pb.*, p.nama_pembeli, p.total_harga, p.status_pesanan
  FROM pembayaran pb
  JOIN pesanan p ON pb.id_pesanan = p.id_pesanan
  $where
  ORDER BY pb.tanggal_bayar DESC
");

$page_title = 'Pembayaran';
$active = 'pembayaran';
require_once 'includes/header.php';
?>

<div style="display:flex;gap:8px;margin-bottom:20px;flex-wrap:wrap">
  <?php foreach([''=>'Semua','belum_bayar'=>'Belum Bayar','lunas'=>'Lunas','gagal'=>'Gagal'] as $k=>$v): ?>
    <a href="pembayaran.php?filter=<?= $k ?>" style="padding:7px 16px;border-radius:100px;font-size:13px;font-weight:500;text-decoration:none;
      <?= $filter===$k ? 'background:rgba(140,90,60,0.2);border:1px solid rgba(140,90,60,0.4);color:#C08552' : 'background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);color:rgba(255,255,255,0.5)' ?>">
      <?= $v ?>
    </a>
  <?php endforeach; ?>
</div>

<div class="card">
  <div class="card-header">
    <div style="font-size:15px;font-weight:600;color:#fff">Riwayat Pembayaran</div>
    <div style="font-size:13px;color:rgba(255,255,255,0.35)"><?= $payments->num_rows ?> transaksi</div>
  </div>
  <div style="overflow-x:auto">
    <table>
      <thead><tr><th>#</th><th>Pembeli</th><th>Total</th><th>Metode</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr></thead>
      <tbody>
        <?php if($payments->num_rows===0): ?>
          <tr><td colspan="7" style="text-align:center;color:rgba(255,255,255,0.25);padding:40px">Tidak ada data pembayaran</td></tr>
        <?php else: ?>
          <?php while($pay = $payments->fetch_assoc()): ?>
          <tr>
            <td style="font-size:12px;color:rgba(255,255,255,0.4)">#<?= $pay['id_pembayaran'] ?></td>
            <td>
              <div style="font-weight:500"><?= htmlspecialchars($pay['nama_pembeli']) ?></div>
              <div style="font-size:12px;color:rgba(255,255,255,0.35)">Pesanan #<?= $pay['id_pesanan'] ?></div>
            </td>
            <td style="font-weight:600;color:#C08552">Rp <?= number_format($pay['total_harga'],0,',','.') ?></td>
            <td><span class="badge badge-gray" style="text-transform:capitalize"><?= str_replace('_',' ',$pay['metode_pembayaran']) ?></span></td>
            <td>
              <?php
              $sb = ['belum_bayar'=>'badge-yellow','lunas'=>'badge-green','gagal'=>'badge-red'];
              $sl = ['belum_bayar'=>'Belum Bayar','lunas'=>'Lunas','gagal'=>'Gagal'];
              ?>
              <span class="badge <?= $sb[$pay['status_pembayaran']]??'badge-gray' ?>"><?= $sl[$pay['status_pembayaran']]??$pay['status_pembayaran'] ?></span>
            </td>
            <td style="font-size:12px;color:rgba(255,255,255,0.4)"><?= date('d M Y', strtotime($pay['tanggal_bayar'])) ?></td>
            <td>
              <form method="POST" style="display:inline">
                <input type="hidden" name="update_bayar" value="1"/>
                <input type="hidden" name="id_pembayaran" value="<?= $pay['id_pembayaran'] ?>"/>
                <select name="status_pembayaran" class="input-field" style="padding:4px 8px;font-size:12px;border-radius:8px" onchange="this.form.submit()">
                  <option value="belum_bayar" <?= $pay['status_pembayaran']==='belum_bayar'?'selected':'' ?>>Belum Bayar</option>
                  <option value="lunas" <?= $pay['status_pembayaran']==='lunas'?'selected':'' ?>>Lunas</option>
                  <option value="gagal" <?= $pay['status_pembayaran']==='gagal'?'selected':'' ?>>Gagal</option>
                </select>
              </form>
            </td>
          </tr>
          <?php endwhile; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>
