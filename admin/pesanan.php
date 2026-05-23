<?php
require_once '../db_connect.php';
require_once 'auth_check.php';

// Update status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $id_pesanan = (int)$_POST['id_pesanan'];
    $status = $_POST['status_pesanan'];
    $allowed_status = ['pending','diproses','dikirim','selesai','dibatalkan'];
    if (in_array($status, $allowed_status)) {
        $stmt = $conn->prepare("UPDATE pesanan SET status_pesanan=? WHERE id_pesanan=?");
        $stmt->bind_param("si", $status, $id_pesanan);
        $stmt->execute();
        $_SESSION['flash_success'] = "Status pesanan #$id_pesanan diperbarui.";
    }
    header('Location: pesanan.php');
    exit;
}

// Delete order
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM pesanan WHERE id_pesanan=$id");
    $_SESSION['flash_success'] = "Pesanan #$id dihapus.";
    header('Location: pesanan.php');
    exit;
}

// Filters
$filter  = $_GET['filter'] ?? '';
$search  = trim($_GET['search'] ?? '');
$where   = [];
$params  = [];
$types   = '';
if ($filter && $filter !== 'semua') { $where[] = "status_pesanan = ?"; $params[] = $filter; $types .= 's'; }
if ($search) { $where[] = "(nama_pembeli LIKE ? OR no_hp LIKE ?)"; $params[] = "%$search%"; $params[] = "%$search%"; $types .= 'ss'; }
$where_sql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$sql = "SELECT * FROM pesanan $where_sql ORDER BY tanggal_pesanan DESC";
$stmt = $conn->prepare($sql);
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute();
$orders = $stmt->get_result();

// Detail modal
$detail_pesanan = null;
$detail_items = [];
if (isset($_GET['detail']) && is_numeric($_GET['detail'])) {
    $did = (int)$_GET['detail'];
    $detail_pesanan = $conn->query("SELECT * FROM pesanan WHERE id_pesanan=$did")->fetch_assoc();
    if ($detail_pesanan) {
        $detail_items = $conn->query("SELECT dp.*, p.nama_produk, p.gambar FROM detail_pesanan dp JOIN produk p ON dp.id_produk=p.id_produk WHERE dp.id_pesanan=$did")->fetch_all(MYSQLI_ASSOC);
    }
}

$page_title = 'Manajemen Pesanan';
$active = 'pesanan';
require_once 'includes/header.php';

$status_list = ['pending','diproses','dikirim','selesai','dibatalkan'];
$status_badge = ['pending'=>'badge-yellow','diproses'=>'badge-blue','dikirim'=>'badge-blue','selesai'=>'badge-green','dibatalkan'=>'badge-red'];
?>

<!-- Filter tabs -->
<div style="display:flex;gap:8px;margin-bottom:20px;flex-wrap:wrap">
  <?php
  $tabs = ['semua'=>'Semua','pending'=>'Pending','diproses'=>'Diproses','dikirim'=>'Dikirim','selesai'=>'Selesai','dibatalkan'=>'Dibatalkan'];
  foreach($tabs as $k=>$v):
    $isActive = ($filter===$k) || ($k==='semua' && !$filter);
  ?>
    <a href="pesanan.php?filter=<?= $k ?>" style="padding:7px 16px;border-radius:100px;font-size:13px;font-weight:500;text-decoration:none;transition:all 0.2s;
      <?= $isActive ? 'background:rgba(140,90,60,0.2);border:1px solid rgba(140,90,60,0.4);color:#C08552' : 'background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);color:rgba(255,255,255,0.5)' ?>">
      <?= $v ?>
    </a>
  <?php endforeach; ?>
</div>

<!-- Search -->
<div class="card" style="margin-bottom:16px">
  <div style="padding:14px 20px">
    <form method="GET" style="display:flex;gap:10px;align-items:flex-end">
      <?php if($filter): ?><input type="hidden" name="filter" value="<?= htmlspecialchars($filter) ?>"/><?php endif; ?>
      <div style="flex:1">
        <input type="text" name="search" class="input-field" style="width:100%" placeholder="Cari nama pembeli / no HP..." value="<?= htmlspecialchars($search) ?>"/>
      </div>
      <button type="submit" class="btn-primary" style="white-space:nowrap"><i class="fas fa-search"></i> Cari</button>
      <a href="pesanan.php" class="btn-secondary"><i class="fas fa-xmark"></i></a>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <div style="font-size:15px;font-weight:600;color:#fff">Daftar Pesanan</div>
    <div style="font-size:13px;color:rgba(255,255,255,0.35)"><?= $orders->num_rows ?> pesanan</div>
  </div>
  <div style="overflow-x:auto">
    <table>
      <thead><tr><th>#ID</th><th>Pembeli</th><th>Total</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr></thead>
      <tbody>
        <?php if($orders->num_rows===0): ?>
          <tr><td colspan="6" style="text-align:center;color:rgba(255,255,255,0.25);padding:40px">Tidak ada pesanan</td></tr>
        <?php else: ?>
          <?php while($o = $orders->fetch_assoc()): ?>
          <tr>
            <td style="font-size:12px;color:rgba(255,255,255,0.4)">#<?= $o['id_pesanan'] ?></td>
            <td>
              <div style="font-weight:500"><?= htmlspecialchars($o['nama_pembeli']) ?></div>
              <div style="font-size:12px;color:rgba(255,255,255,0.35)"><?= htmlspecialchars($o['no_hp']) ?></div>
            </td>
            <td style="font-weight:600;color:#C08552">Rp <?= number_format($o['total_harga'],0,',','.') ?></td>
            <td>
              <form method="POST" style="display:inline">
                <input type="hidden" name="update_status" value="1"/>
                <input type="hidden" name="id_pesanan" value="<?= $o['id_pesanan'] ?>"/>
                <select name="status_pesanan" class="input-field" style="padding:4px 8px;font-size:12px;border-radius:8px" onchange="this.form.submit()">
                  <?php foreach($status_list as $s): ?>
                    <option value="<?= $s ?>" <?= $o['status_pesanan']===$s?'selected':'' ?>><?= ucfirst($s) ?></option>
                  <?php endforeach; ?>
                </select>
              </form>
            </td>
            <td style="font-size:12px;color:rgba(255,255,255,0.4)"><?= date('d M Y H:i', strtotime($o['tanggal_pesanan'])) ?></td>
            <td>
              <div style="display:flex;gap:6px">
                <a href="pesanan.php?detail=<?= $o['id_pesanan'] ?>" class="btn-edit" title="Detail"><i class="fas fa-eye"></i></a>
                <a href="pesanan.php?delete=<?= $o['id_pesanan'] ?>" class="btn-danger" title="Hapus" onclick="return confirm('Hapus pesanan ini?')"><i class="fas fa-trash"></i></a>
              </div>
            </td>
          </tr>
          <?php endwhile; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Detail Modal -->
<?php if($detail_pesanan): ?>
<div id="detailModal" style="position:fixed;inset:0;background:rgba(0,0,0,0.7);z-index:100;display:flex;align-items:center;justify-content:center;padding:20px" onclick="if(event.target===this)closeModal()">
  <div style="background:#131f14;border:1px solid rgba(255,255,255,0.1);border-radius:20px;width:100%;max-width:560px;max-height:90vh;overflow-y:auto">
    <div style="padding:20px 24px;border-bottom:1px solid rgba(255,255,255,0.07);display:flex;align-items:center;justify-content:space-between">
      <div style="font-size:16px;font-weight:600;color:#fff">Detail Pesanan #<?= $detail_pesanan['id_pesanan'] ?></div>
      <a href="pesanan.php" style="color:rgba(255,255,255,0.4);text-decoration:none;font-size:18px"><i class="fas fa-xmark"></i></a>
    </div>
    <div style="padding:24px">
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:20px">
        <div><div style="font-size:11px;color:rgba(255,255,255,0.35);margin-bottom:3px">PEMBELI</div><div style="font-weight:500"><?= htmlspecialchars($detail_pesanan['nama_pembeli']) ?></div></div>
        <div><div style="font-size:11px;color:rgba(255,255,255,0.35);margin-bottom:3px">NO HP</div><div><?= htmlspecialchars($detail_pesanan['no_hp']) ?></div></div>
        <div><div style="font-size:11px;color:rgba(255,255,255,0.35);margin-bottom:3px">EMAIL</div><div style="font-size:13px"><?= htmlspecialchars($detail_pesanan['email']??'-') ?></div></div>
        <div><div style="font-size:11px;color:rgba(255,255,255,0.35);margin-bottom:3px">STATUS</div>
          <span class="badge <?= $status_badge[$detail_pesanan['status_pesanan']]??'badge-gray' ?>"><?= ucfirst($detail_pesanan['status_pesanan']) ?></span>
        </div>
        <div style="grid-column:1/-1"><div style="font-size:11px;color:rgba(255,255,255,0.35);margin-bottom:3px">ALAMAT</div><div style="font-size:13px"><?= htmlspecialchars($detail_pesanan['alamat_pengiriman']) ?></div></div>
      </div>

      <?php if($detail_items): ?>
        <div style="font-size:13px;font-weight:600;color:rgba(255,255,255,0.5);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:12px">Item Pesanan</div>
        <?php foreach($detail_items as $item): ?>
          <div style="display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid rgba(255,255,255,0.05)">
            <?php if($item['gambar']): ?>
              <?php $img_src_item = str_starts_with($item['gambar'], 'http') ? $item['gambar'] : '../' . $item['gambar']; ?>
              <img src="<?= htmlspecialchars($img_src_item) ?>" style="width:36px;height:36px;border-radius:8px;object-fit:cover"/>
            <?php endif; ?>
            <div style="flex:1">
              <div style="font-size:13px;font-weight:500"><?= htmlspecialchars($item['nama_produk']) ?></div>
              <div style="font-size:12px;color:rgba(255,255,255,0.4)"><?= $item['jumlah'] ?> × Rp <?= number_format($item['harga_satuan'],0,',','.') ?></div>
            </div>
            <div style="font-weight:600;color:#C08552;font-size:13px">Rp <?= number_format($item['jumlah']*$item['harga_satuan'],0,',','.') ?></div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>

      <div style="text-align:right;margin-top:16px;font-size:16px;font-weight:700;color:#fff">
        Total: <span style="color:#C08552">Rp <?= number_format($detail_pesanan['total_harga'],0,',','.') ?></span>
      </div>
    </div>
  </div>
</div>
<script>
document.addEventListener('keydown', e => { if(e.key==='Escape') window.location='pesanan.php'; });
function closeModal(){ window.location='pesanan.php'; }
</script>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
