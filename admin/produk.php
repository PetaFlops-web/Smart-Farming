<?php
require_once '../db_connect.php';
require_once 'auth_check.php';

// Handle delete
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    // Get image to delete file if local
    $row = $conn->query("SELECT gambar FROM produk WHERE id_produk=$id")->fetch_assoc();
    $stmt = $conn->prepare("DELETE FROM produk WHERE id_produk=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        // Delete local image if any
        if ($row && $row['gambar'] && !str_starts_with($row['gambar'], 'http') && file_exists('../' . $row['gambar'])) {
            unlink('../' . $row['gambar']);
        }
        $_SESSION['flash_success'] = 'Produk berhasil dihapus.';
    } else {
        $_SESSION['flash_error'] = 'Gagal menghapus produk.';
    }
    header('Location: produk.php');
    exit;
}

// Filters
$search = trim($_GET['search'] ?? '');
$kategori = $_GET['kategori'] ?? '';
$where = [];
$params = [];
$types = '';
if ($search) { $where[] = "(nama_produk LIKE ? OR deskripsi LIKE ?)"; $params[] = "%$search%"; $params[] = "%$search%"; $types .= 'ss'; }
if ($kategori) { $where[] = "kategori = ?"; $params[] = $kategori; $types .= 's'; }
$where_sql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$sql = "SELECT * FROM produk $where_sql ORDER BY id_produk DESC";
$stmt = $conn->prepare($sql);
if ($params) { $stmt->bind_param($types, ...$params); }
$stmt->execute();
$produk_list = $stmt->get_result();

$all_cat = $conn->query("SELECT DISTINCT kategori FROM produk ORDER BY kategori");

$page_title = 'Manajemen Produk';
$active = 'produk';
require_once 'includes/header.php';
?>

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px">
  <div>
    <h2 style="font-size:18px;font-weight:600;color:#fff">Semua Produk</h2>
    <p style="font-size:13px;color:rgba(255,255,255,0.35)"><?= $produk_list->num_rows ?> produk ditemukan</p>
  </div>
  <a href="tambah_produk.php" class="btn-primary"><i class="fas fa-plus"></i> Tambah Produk</a>
</div>

<!-- Filters -->
<div class="card" style="margin-bottom:20px">
  <div style="padding:16px 20px">
    <form method="GET" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end">
      <div style="flex:1;min-width:200px">
        <label>Cari Produk</label>
        <input type="text" name="search" class="input-field" style="width:100%" placeholder="Nama produk..." value="<?= htmlspecialchars($search) ?>"/>
      </div>
      <div style="min-width:150px">
        <label>Kategori</label>
        <select name="kategori" class="input-field" style="width:100%">
          <option value="">Semua</option>
          <?php while($c = $all_cat->fetch_assoc()): ?>
            <option value="<?= htmlspecialchars($c['kategori']) ?>" <?= $kategori===$c['kategori']?'selected':'' ?>><?= ucfirst(htmlspecialchars($c['kategori'])) ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div style="display:flex;gap:8px">
        <button type="submit" class="btn-primary"><i class="fas fa-search"></i> Filter</button>
        <a href="produk.php" class="btn-secondary"><i class="fas fa-xmark"></i> Reset</a>
      </div>
    </form>
  </div>
</div>

<!-- Table -->
<div class="card">
  <div style="overflow-x:auto">
    <table>
      <thead>
        <tr>
          <th style="width:60px">#</th>
          <th>Produk</th>
          <th>Kategori</th>
          <th>Harga</th>
          <th>Stok</th>
          <th>Cup Score</th>
          <th style="width:140px">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if($produk_list->num_rows === 0): ?>
          <tr><td colspan="7" style="text-align:center;color:rgba(255,255,255,0.25);padding:40px">
            <i class="fas fa-box-open" style="font-size:32px;display:block;margin-bottom:10px;opacity:0.3"></i>
            Tidak ada produk ditemukan
          </td></tr>
        <?php else: ?>
          <?php while($p = $produk_list->fetch_assoc()): ?>
          <tr>
            <td style="color:rgba(255,255,255,0.3);font-size:12px"><?= $p['id_produk'] ?></td>
            <td>
              <div style="display:flex;align-items:center;gap:12px">
                <?php if($p['gambar']): ?>
                  <?php $img_src = str_starts_with($p['gambar'], 'http') ? $p['gambar'] : '../' . $p['gambar']; ?>
                  <img src="<?= htmlspecialchars($img_src) ?>" alt="" style="width:40px;height:40px;border-radius:8px;object-fit:cover;border:1px solid rgba(255,255,255,0.1)"/>
                <?php else: ?>
                  <div style="width:40px;height:40px;border-radius:8px;background:rgba(255,255,255,0.05);display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,0.2)"><i class="fas fa-image"></i></div>
                <?php endif; ?>
                <div>
                  <div style="font-weight:500;font-size:14px"><?= htmlspecialchars($p['nama_produk']) ?></div>
                  <div style="font-size:11px;color:rgba(255,255,255,0.3)"><?= htmlspecialchars($p['unit']) ?></div>
                </div>
              </div>
            </td>
            <td><span class="badge badge-gray"><?= htmlspecialchars($p['kategori']) ?></span></td>
            <td style="font-weight:600;color:#C08552">Rp <?= number_format($p['harga'],0,',','.') ?></td>
            <td>
              <?php if($p['stok']==0): ?>
                <span class="badge badge-red"><i class="fas fa-circle" style="font-size:6px"></i> Habis</span>
              <?php elseif($p['stok']<=5): ?>
                <span class="badge badge-yellow"><?= $p['stok'] ?></span>
              <?php else: ?>
                <span style="color:#fff"><?= $p['stok'] ?></span>
              <?php endif; ?>
            </td>
            <td style="color:rgba(255,255,255,0.5)"><?= $p['cup_score'] ? $p['cup_score'].' pts' : '—' ?></td>
            <td>
              <div style="display:flex;gap:6px">
                <a href="edit_produk.php?id=<?= $p['id_produk'] ?>" class="btn-edit" title="Edit"><i class="fas fa-pen"></i></a>
                <a href="produk.php?delete=<?= $p['id_produk'] ?>" class="btn-danger" title="Hapus" onclick="return confirm('Yakin hapus produk ini?')"><i class="fas fa-trash"></i></a>
              </div>
            </td>
          </tr>
          <?php endwhile; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>
