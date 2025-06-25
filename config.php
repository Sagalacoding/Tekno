<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "rekap"; // <- ini harus sesuai dengan database lo

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
