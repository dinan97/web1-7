<?php
require_once 'Database.php';

class Buku {
    private $db;
    private $table_name = "buku";
    public $id;
    public $judul;
    public $penulis;
    public $tahun_terbit;

    public function __construct() {
        $database = new Database();
        $this->db = $database->conn;
    }

    // Metode untuk menampilkan semua data buku (CREATE)
    public function tampilkanSemua() {
        $query = "SELECT id, judul, penulis, tahun_terbit FROM " . $this->table_name . " ORDER BY judul ASC";
        $result = $this->db->query($query);
        return $result; 
    }

    // Metode untuk menampilkan satu data buku berdasarkan ID (READ One)
    public function tampilkanSatu($id) {
        $query = "SELECT id, judul, penulis, tahun_terbit FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id); // "i" for integer
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $this->id = $row['id'];
            $this->judul = $row['judul'];
            $this->penulis = $row['penulis'];
            $this->tahun_terbit = $row['tahun_terbit'];
            return true;
        }
        return false;
    }

    // Metode untuk menambah data buku baru (CREATE)
    public function tambah() {
        $query = "INSERT INTO " . $this->table_name . " (judul, penulis, tahun_terbit) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);

        // Membersihkan data
        $this->judul=htmlspecialchars(strip_tags($this->judul));
        $this->penulis=htmlspecialchars(strip_tags($this->penulis));
        $this->tahun_terbit=htmlspecialchars(strip_tags($this->tahun_terbit));

        $stmt->bind_param("ssi", $this->judul, $this->penulis, $this->tahun_terbit); // "ssi" for string, string, integer

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Metode untuk mengubah data buku (UPDATE)
    public function ubah() {
        $query = "UPDATE " . $this->table_name . " SET judul = ?, penulis = ?, tahun_terbit = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);

        // Membersihkan data
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->judul=htmlspecialchars(strip_tags($this->judul));
        $this->penulis=htmlspecialchars(strip_tags($this->penulis));
        $this->tahun_terbit=htmlspecialchars(strip_tags($this->tahun_terbit));

        $stmt->bind_param("ssii", $this->judul, $this->penulis, $this->tahun_terbit, $this->id); // "ssii" for string, string, integer, integer

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Metode untuk menghapus data buku (DELETE)
    public function hapus($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>