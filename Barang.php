<?php
require_once 'config.php'; // koneksi database

class Barang {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function tampilData() {
        $query = "SELECT nama_barang, anggaran FROM barang";
        $result = mysqli_query($this->conn, $query);

        $data = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }
}
?>
