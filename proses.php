<?php
include 'config.php';
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_barang = $_POST['nama_barang'] ?? '';
    $kegunaan = $_POST['kegunaan'] ?? '';
    $alasan = $_POST['alasan'] ?? '';
    $anggaran = (int)($_POST['anggaran'] ?? 0);
    $masa_aktif = $_POST['masa_aktif'] ?? '';

    // Pastikan semua input wajib ada
    if (!$nama_barang || !$kegunaan || !$alasan || !$anggaran || !$masa_aktif || !isset($_FILES['gambar'])) {
        die("Data tidak lengkap!");
    }

    // Upload gambar
    $gambar_name = $_FILES['gambar']['name'];
    $gambar_tmp = $_FILES['gambar']['tmp_name'];
    $target_dir = "uploads/";

    // Buat folder uploads jika belum ada
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . basename($gambar_name);

    if (move_uploaded_file($gambar_tmp, $target_file)) {
        // Simpan data ke database
        $stmt = $conn->prepare("INSERT INTO barang (nama_barang, gambar, kegunaan, alasan, anggaran, masa_aktif, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        // binding param: s = string, d = double (float), tapi anggaran int juga bisa pakai d
        $stmt->bind_param("ssssds", $nama_barang, $gambar_name, $kegunaan, $alasan, $anggaran, $masa_aktif);

        if ($stmt->execute()) {
            $stmt->close();
            header("Location: data.php"); // redirect setelah sukses
            exit();
        } else {
            die("Execute failed: " . $stmt->error);
        }
    } else {
        die("Upload gambar gagal.");
    }
} else {
    header("Location: data.php");
    exit();
}
if (isset($_POST['update'])) {
    // jalankan update barang
} elseif (isset($_POST['tambah'])) {
    // jalankan tambah barang
}
