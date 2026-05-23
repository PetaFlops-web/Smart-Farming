<?php
require_once '../db_connect.php';
require_once 'auth_check.php';

$id = (int)($_GET['id'] ?? 0);
if (!$id) { header('Location: produk.php'); exit; }

$produk = $conn->query("SELECT * FROM produk WHERE id_produk=$id")->fetch_assoc();
if (!$produk) { $_SESSION['flash_error'] = 'Produk tidak ditemukan.'; header('Location: produk.php'); exit; }

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama      = trim($_POST['nama_produk'] ?? '');
    $kategori  = trim($_POST['kategori'] ?? '');
    $harga     = (int)($_POST['harga'] ?? 0);
    $unit      = trim($_POST['unit'] ?? 'per cup');
    $stok      = (int)($_POST['stok'] ?? 0);
    $deskripsi = trim($_POST['deskripsi'] ?? '');
    $cup_score = ($_POST['cup_score'] !== '') ? (float)$_POST['cup_score'] : null;
    $gambar    = trim($_POST['gambar'] ?? $produk['gambar']);

    if (!$nama) $errors[] = 'Nama produk wajib diisi.';
    if (!$kategori) $errors[] = 'Kategori wajib dipilih.';
    if ($harga <= 0) $errors[] = 'Harga harus lebih dari 0.';

    // Handle file upload
    if (!empty($_FILES['gambar_file']['name'])) {
        $ext = strtolower(pathinfo($_FILES['gambar_file']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','webp'];
        if (!in_array($ext, $allowed)) {
            $errors[] = 'Format gambar tidak didukung.';
        } elseif ($_FILES['gambar_file']['size'] > 5*1024*1024) {
            $errors[] = 'Ukuran gambar maksimal 5MB.';
        } else {
            $upload_dir = '../assests/img/produk/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
            $filename = 'produk_' . time() . '_' . rand(1000,9999) . '.' . $ext;
            if (move_uploaded_file($_FILES['gambar_file']['tmp_name'], $upload_dir . $filename)) {
                // Delete old local image
                if ($produk['gambar'] && !str_starts_with($produk['gambar'], 'http') && file_exists('../' . $produk['gambar'])) {
                    @unlink('../' . $produk['gambar']);
                }
                $gambar = 'assests/img/produk/' . $filename;
            } else {
                $errors[] = 'Gagal upload gambar.';
            }
        }
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE produk SET nama_produk=?, kategori=?, harga=?, unit=?, stok=?, deskripsi=?, cup_score=?, gambar=? WHERE id_produk=?");
        $stmt->bind_param("ssisisdsi", $nama, $kategori, $harga, $unit, $stok, $deskripsi, $cup_score, $gambar, $id);
        if ($stmt->execute()) {
            $_SESSION['flash_success'] = "Produk berhasil diperbarui.";
            header('Location: produk.php');
            exit;
        } else {
            $errors[] = 'Gagal menyimpan: ' . $conn->error;
        }
    }
    // Repopulate for re-render
    $produk = array_merge($produk, $_POST);
}

$page_title = 'Edit Produk';
$active = 'produk';
require_once 'includes/header.php';
?>

<div style="max-width:720px">
  <div style="margin-bottom:20px">
    <a href="produk.php" style="color:rgba(255,255,255,0.4);font-size:13px;text-decoration:none"><i class="fas fa-arrow-left"></i> Kembali ke Produk</a>
  </div>

  <?php if($errors): ?>
    <div class="alert-error" style="flex-direction:column;align-items:flex-start;gap:6px">
      <strong><i class="fas fa-circle-exclamation"></i> Terdapat kesalahan:</strong>
      <ul style="margin:0;padding-left:18px">
        <?php foreach($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <div class="card">
    <div class="card-header">
      <div style="font-size:15px;font-weight:600;color:#fff"><i class="fas fa-pen" style="color:#93c5fd;margin-right:8px"></i>Edit Produk #<?= $id ?></div>
    </div>
    <div class="card-body">
      <form method="POST" enctype="multipart/form-data">

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px">
          <div class="form-group" style="grid-column:1/-1">
            <label>Nama Produk *</label>
            <input type="text" name="nama_produk" class="input-field" style="width:100%" value="<?= htmlspecialchars($produk['nama_produk']) ?>" required/>
          </div>

          <div class="form-group">
            <label>Kategori *</label>
            <select name="kategori" class="input-field" style="width:100%" required>
              <?php foreach(['roasted','green','extract','kit'] as $cat): ?>
                <option value="<?= $cat ?>" <?= $produk['kategori']===$cat?'selected':'' ?>><?= ucfirst($cat) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label>Unit</label>
            <input type="text" name="unit" class="input-field" style="width:100%" value="<?= htmlspecialchars($produk['unit']) ?>"/>
          </div>

          <div class="form-group">
            <label>Harga (Rp) *</label>
            <input type="number" name="harga" class="input-field" style="width:100%" min="0" value="<?= htmlspecialchars($produk['harga']) ?>" required/>
          </div>

          <div class="form-group">
            <label>Stok</label>
            <input type="number" name="stok" class="input-field" style="width:100%" min="0" value="<?= htmlspecialchars($produk['stok']) ?>"/>
          </div>

          <div class="form-group">
            <label>Cup Score (opsional)</label>
            <input type="number" name="cup_score" class="input-field" style="width:100%" step="0.1" min="0" max="100" value="<?= htmlspecialchars($produk['cup_score']??'') ?>"/>
          </div>

          <div class="form-group" style="grid-column:1/-1">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="input-field" style="width:100%"><?= htmlspecialchars($produk['deskripsi']??'') ?></textarea>
          </div>

          <div class="form-group" style="grid-column:1/-1">
            <label>Gambar Saat Ini</label>
            <?php if($produk['gambar']): ?>
              <?php $img_src_edit = str_starts_with($produk['gambar'], 'http') ? $produk['gambar'] : '../' . $produk['gambar']; ?>
              <img src="<?= htmlspecialchars($img_src_edit) ?>" alt="" style="width:80px;height:80px;border-radius:10px;object-fit:cover;border:1px solid rgba(255,255,255,0.1);display:block;margin-bottom:10px"/>
            <?php endif; ?>
            <label>URL Gambar Baru</label>
            <input type="url" name="gambar" class="input-field" style="width:100%;margin-bottom:8px" placeholder="https://..." value="<?= htmlspecialchars($produk['gambar']??'') ?>"/>
            <label>Atau Upload File</label>
            <input type="file" name="gambar_file" accept="image/*" class="input-field" style="width:100%;padding:8px"/>
          </div>
        </div>

        <div style="display:flex;gap:10px;margin-top:8px">
          <button type="submit" class="btn-primary"><i class="fas fa-floppy-disk"></i> Simpan Perubahan</button>
          <a href="produk.php" class="btn-secondary">Batal</a>
          <a href="produk.php?delete=<?= $id ?>" class="btn-danger" style="margin-left:auto" onclick="return confirm('Yakin hapus produk ini?')"><i class="fas fa-trash"></i> Hapus</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>
