<?php
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "rekap");

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil data berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM barang WHERE id = $id";
    $result = $koneksi->query($query);
    $data = $result->fetch_assoc();
} else {
    echo "ID tidak ditemukan di URL.";
    exit;
}

// Update data
if (isset($_POST['update'])) {
    $nama = $_POST['nama_barang'];
    $kategori = $_POST['kategori'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];

    $stmt = $koneksi->prepare("UPDATE barang SET nama_barang=?, kategori=?, stok=?, harga=? WHERE id=?");
    $stmt->bind_param("ssiii", $nama, $kategori, $stok, $harga, $id);
    $update = $stmt->execute();
    $stmt->close();

    if ($update) {
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal update data!";
    }
    if (!$data) {
        echo "Data tidak ditemukan.";
        exit;
    }
    
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Barang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Edit Data Barang</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" value="<?= htmlspecialchars($data['nama_barang']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Kategori</label>
            <input type="text" name="kategori" class="form-control" value="<?= $data['kategori'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stok" class="form-control" value="<?= $data['stok'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" value="<?= $data['harga'] ?>" required>
        </div>
        <button type="submit" name="update" class="btn btn-success">Simpan Perubahan</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</body>
</html>
