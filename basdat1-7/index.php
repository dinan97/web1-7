<?php
require_once 'Buku.php';
$buku_model = new Buku();

// Logika Hapus
if (isset($_GET['action']) && $_GET['action'] == 'hapus' && isset($_GET['id'])) {
    $id_hapus = $_GET['id'];
    if ($buku_model->hapus($id_hapus)) {
        // Redirect untuk menghilangkan parameter GET setelah penghapusan
        header("Location: index.php?status=hapus_sukses");
        exit();
    } else {
        header("Location: index.php?status=hapus_gagal");
        exit();
    }
}

$data_buku = $buku_model->tampilkanSemua();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku Perpustakaan (Tugas OOP PHP)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
        }
        .container {
            max-width: 1000px; /* Lebarkan container */
            margin: auto;
            background: #fff;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        .btn-tambah {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 15px;
            display: inline-block;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .btn-aksi {
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            border-radius: 3px;
            margin-right: 5px;
            text-decoration: none;
            display: inline-block;
        }
        .btn-ubah {
            background-color: #ffc107;
            color: #333;
        }
        .btn-hapus {
            background-color: #dc3545;
            color: white;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
    </style>
    <script>
        function konfirmasiHapus(id, judul) {
            // Persyaratan 4: Pop-up konfirmasi
            if (confirm("Apakah Anda yakin ingin menghapus buku: \"" + judul + "\"?")) {
                window.location.href = 'index.php?action=hapus&id=' + id;
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>📚 Daftar Buku Perpustakaan</h1>
        
        <?php
        // Notifikasi Status
        if (isset($_GET['status'])) {
            if ($_GET['status'] == 'tambah_sukses') {
                echo "<div class='alert alert-success'>Data buku berhasil ditambahkan!</div>";
            } elseif ($_GET['status'] == 'ubah_sukses') {
                echo "<div class='alert alert-success'>Data buku berhasil diubah!</div>";
            } elseif ($_GET['status'] == 'hapus_sukses') {
                echo "<div class='alert alert-success'>Data buku berhasil dihapus!</div>";
            }
        }
        ?>

        <a href="tambah.php" class="btn-tambah">➕ Tambah Buku Baru</a>
        
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Tahun Terbit</th>
                    <th>Aksi</th> </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if ($data_buku->num_rows > 0) {
                    while($row = $data_buku->fetch_assoc()) {
                        $judul_buku = htmlspecialchars($row['judul']);
                        $id_buku = htmlspecialchars($row['id']);
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . $judul_buku . "</td>";
                        echo "<td>" . htmlspecialchars($row['penulis']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['tahun_terbit']) . "</td>";
                        // Persyaratan 2 & 3: Tombol Ubah dan Hapus
                        echo "<td>";
                        echo "<a href='ubah.php?id=" . $id_buku . "' class='btn-aksi btn-ubah'>✏️ Ubah</a>";
                        // Panggil fungsi Javascript untuk konfirmasi
                        echo "<button onclick=\"konfirmasiHapus(" . $id_buku . ", '" . addslashes($judul_buku) . "')\" class='btn-aksi btn-hapus'>🗑️ Hapus</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Tidak ada data buku yang ditemukan.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        
    </div>
</body>
</html>