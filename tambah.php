<?php
require_once 'Buku.php';
$buku_model = new Buku();
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari formulir
    $buku_model->judul = $_POST['judul'];
    $buku_model->penulis = $_POST['penulis'];
    $buku_model->tahun_terbit = $_POST['tahun_terbit'];

    // Validasi sederhana
    if (empty($buku_model->judul) || empty($buku_model->penulis) || empty($buku_model->tahun_terbit)) {
        $error = "Semua field harus diisi!";
    } elseif (!is_numeric($buku_model->tahun_terbit)) {
        $error = "Tahun Terbit harus berupa angka!";
    } else {
        // Panggil metode tambah
        if ($buku_model->tambah()) {
            header("Location: index.php?status=tambah_sukses");
            exit();
        } else {
            $error = "Gagal menambahkan data buku.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku Baru</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .container { background: #fff; padding: 30px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); border-radius: 8px; max-width: 500px; width: 100%; }
        h1 { text-align: center; color: #333; border-bottom: 2px solid #28a745; padding-bottom: 10px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; }
        input[type="text"], input[type="number"] { width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-submit { background-color: #28a745; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; float: right; }
        .btn-submit:hover { background-color: #218838; }
        .btn-back { background-color: #6c757d; color: white; padding: 10px 15px; border: none; border-radius: 4px; text-decoration: none; display: inline-block; }
        .alert-danger { color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>➕ Tambah Buku Baru</h1>
        
        <?php if ($error): ?>
            <div class="alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <label for="judul">Judul Buku:</label>
            <input type="text" id="judul" name="judul" value="<?= htmlspecialchars($buku_model->judul ?? '') ?>" required>
            
            <label for="penulis">Penulis:</label>
            <input type="text" id="penulis" name="penulis" value="<?= htmlspecialchars($buku_model->penulis ?? '') ?>" required>
            
            <label for="tahun_terbit">Tahun Terbit:</label>
            <input type="number" id="tahun_terbit" name="tahun_terbit" value="<?= htmlspecialchars($buku_model->tahun_terbit ?? '') ?>" required>
            
            <a href="index.php" class="btn-back">⬅️ Kembali</a>
            <button type="submit" class="btn-submit">Simpan Data</button>
        </form>
    </div>
</body>
</html>