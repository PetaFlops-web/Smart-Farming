<?php
require_once '../db_connect.php';
require_once 'auth_check.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama    = trim($_POST['nama_produk'] ?? '');
    $kategori= trim($_POST['kategori'] ?? '');
    $harga   = (int)($_POST['harga'] ?? 0);
    $unit    = trim($_POST['unit'] ?? 'per cup');
    $stok    = (int)($_POST['stok'] ?? 0);
    $deskripsi = trim($_POST['deskripsi'] ?? '');
    $cup_score = $_POST['cup_score'] !== '' ? (float)$_POST['cup_score'] : null;
    $gambar  = trim($_POST['gambar'] ?? '');

    if (!$nama) $errors[] = 'Nama produk wajib diisi.';
    if (!$kategori) $errors[] = 'Kategori wajib dipilih.';
    if ($harga <= 0) $errors[] = 'Harga harus lebih dari 0.';

    // Handle file upload
    if (!empty($_FILES['gambar_file']['name'])) {
        $ext = strtolower(pathinfo($_FILES['gambar_file']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','webp'];
        if (!in_array($ext, $allowed)) {
            $errors[] = 'Format gambar tidak didukung. Gunakan JPG, PNG, atau WebP.';
        } elseif ($_FILES['gambar_file']['size'] > 5*1024*1024) {
            $errors[] = 'Ukuran gambar maksimal 5MB.';
        } else {
            $upload_dir = '../assests/img/produk/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
            $filename = 'produk_' . time() . '_' . rand(1000,9999) . '.' . $ext;
            if (move_uploaded_file($_FILES['gambar_file']['tmp_name'], $upload_dir . $filename)) {
                $gambar = 'assests/img/produk/' . $filename;
            } else {
                $errors[] = 'Gagal upload gambar.';
            }
        }
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO produk (nama_produk, kategori, harga, unit, stok, deskripsi, cup_score, gambar) VALUES (?,?,?,?,?,?,?,?)");
        $stmt->bind_param("ssisisds", $nama, $kategori, $harga, $unit, $stok, $deskripsi, $cup_score, $gambar);
        if ($stmt->execute()) {
            $_SESSION['flash_success'] = "Produk \"$nama\" berhasil ditambahkan.";
            header('Location: produk.php');
            exit;
        } else {
            $errors[] = 'Gagal menyimpan produk: ' . $conn->error;
        }
    }
}

$page_title = 'Tambah Produk';
$active = 'tambah_produk';
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
      <div style="font-size:15px;font-weight:600;color:#fff"><i class="fas fa-plus-circle" style="color:#C08552;margin-right:8px"></i>Tambah Produk Baru</div>
    </div>
    <div class="card-body">
      <form method="POST" enctype="multipart/form-data">

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px">
          <div class="form-group" style="grid-column:1/-1">
            <label>Nama Produk *</label>
            <input type="text" name="nama_produk" class="input-field" style="width:100%" placeholder="Contoh: Gayo Natural Process" value="<?= htmlspecialchars($_POST['nama_produk']??'') ?>" required/>
          </div>

          <div class="form-group">
            <label>Kategori *</label>
            <select name="kategori" class="input-field" style="width:100%" required>
              <option value="">-- Pilih Kategori --</option>
              <?php foreach(['roasted','green','extract','kit'] as $cat): ?>
                <option value="<?= $cat ?>" <?= ($_POST['kategori']??'')===$cat?'selected':'' ?>><?= ucfirst($cat) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label>Unit</label>
            <input type="text" name="unit" class="input-field" style="width:100%" placeholder="per 250g / per cup / per kg" value="<?= htmlspecialchars($_POST['unit']??'per cup') ?>"/>
          </div>

          <div class="form-group">
            <label>Harga (Rp) *</label>
            <input type="number" name="harga" class="input-field" style="width:100%" placeholder="0" min="0" value="<?= htmlspecialchars($_POST['harga']??'') ?>" required/>
          </div>

          <div class="form-group">
            <label>Stok</label>
            <input type="number" name="stok" class="input-field" style="width:100%" placeholder="0" min="0" value="<?= htmlspecialchars($_POST['stok']??'0') ?>"/>
          </div>

          <div class="form-group">
            <label>Cup Score (opsional)</label>
            <input type="number" name="cup_score" class="input-field" style="width:100%" placeholder="85.0" step="0.1" min="0" max="100" value="<?= htmlspecialchars($_POST['cup_score']??'') ?>"/>
          </div>

          <div class="form-group" style="grid-column:1/-1">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="input-field" style="width:100%" placeholder="Tasting notes, asal biji, proses..."><?= htmlspecialchars($_POST['deskripsi']??'') ?></textarea>
          </div>

          <div class="form-group" style="grid-column:1/-1">
            <label>URL Gambar (atau upload file)</label>
            <input type="url" name="gambar" id="gambarUrl" class="input-field" style="width:100%;margin-bottom:8px" placeholder="https://..." value="<?= htmlspecialchars($_POST['gambar']??'') ?>"/>
            <input type="file" name="gambar_file" id="gambarFile" accept="image/*" class="input-field" style="width:100%;padding:8px"/>
            <p style="font-size:12px;color:rgba(255,255,255,0.3);margin-top:6px">Upload file akan menggantikan URL. Maks 5MB, format JPG/PNG/WebP.</p>
          </div>
        </div>

        <div style="display:flex;gap:10px;margin-top:8px">
          <button type="submit" class="btn-primary"><i class="fas fa-floppy-disk"></i> Simpan Produk</button>
          <a href="produk.php" class="btn-secondary">Batal</a>
        </div>

      </form>
    </div>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>
