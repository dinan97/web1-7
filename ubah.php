<?php
require_once 'Buku.php';
$buku_model = new Buku();
$error = '';
$id_buku = $_GET['id'] ?? null;

// Pastikan ID ada dan ambil data buku
if (!$id_buku || !$buku_model->tampilkanSatu($id_buku)) {
    header("Location: index.php?status=data_tidak_ditemukan");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari formulir
    $buku_model->id = $id_buku; // Pastikan ID tetap
    $buku_model->judul = $_POST['judul'];
    $buku_model->penulis = $_POST['penulis'];
    $buku_model->tahun_terbit = $_POST['tahun_terbit'];

    // Validasi sederhana
    if (empty($buku_model->judul) || empty($buku_model->penulis) || empty($buku_model->tahun_terbit)) {
        $error = "Semua field harus diisi!";
    } elseif (!is_numeric($buku_model->tahun_terbit)) {
        $error = "Tahun Terbit harus berupa angka!";
    } else {
        // Panggil metode ubah
        if ($buku_model->ubah()) {
            header("Location: index.php?status=ubah_sukses");
            exit();
        } else {
            $error = "Gagal mengubah data buku.";
        }
    }
}
// Jika bukan POST, data buku sudah dimuat oleh tampilkanSatu()
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Buku: <?= htmlspecialchars($buku_model->judul) ?></title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .container { background: #fff; padding: 30px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); border-radius: 8px; max-width: 500px; width: 100%; }
        h1 { text-align: center; color: #333; border-bottom: 2px solid #ffc107; padding-bottom: 10px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; }
        input[type="text"], input[type="number"] { width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-submit { background-color: #ffc107; color: #333; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; float: right; }
        .btn-submit:hover { background-color: #e0a800; }
        .btn-back { background-color: #6c757d; color: white; padding: 10px 15px; border: none; border-radius: 4px; text-decoration: none; display: inline-block; }
        .alert-danger { color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>✏️ Ubah Data Buku</h1>
        
        <?php if ($error): ?>
            <div class="alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($buku_model->id) ?>">

            <label for="judul">Judul Buku:</label>
            <input type="text" id="judul" name="judul" value="<?= htmlspecialchars($buku_model->judul) ?>" required>
            
            <label for="penulis">Penulis:</label>
            <input type="text" id="penulis" name="penulis" value="<?= htmlspecialchars($buku_model->penulis) ?>" required>
            
            <label for="tahun_terbit">Tahun Terbit:</label>
            <input type="number" id="tahun_terbit" name="tahun_terbit" value="<?= htmlspecialchars($buku_model->tahun_terbit) ?>" required>
            
            <a href="index.php" class="btn-back">⬅️ Kembali</a>
            <button type="submit" class="btn-submit">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>