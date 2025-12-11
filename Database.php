<?php

class Database {
    private $host = "localhost";
    private $user = "root";
    private $pass = "12345"; 
    private $db_name = "Buku"; 
    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db_name);

        if ($this->conn->connect_error) {
            die("Koneksi gagal: " . $this->conn->connect_error);
        }
    }

    public function closeConnection() {
        $this->conn->close();
    }
}