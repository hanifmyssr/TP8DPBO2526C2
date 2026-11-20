<?php
// Konfigurasi koneksi database menggunakan PDO
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "tp_mvc25";
    public $conn;

    // Membuka koneksi PDO dengan mode exception
    public function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname}",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Koneksi gagal: " . $e->getMessage());
        }
    }
}
