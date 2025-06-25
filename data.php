<?php
include 'config.php';
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit();
}

// Ambil semua data dari database
$data = $conn->query("SELECT * FROM barang ORDER BY created_at DESC");
$barangList = [];
while ($row = $data->fetch_assoc()) {
    $barangList[] = $row;
}

// Inisialisasi variabel form biar gak undefined
$nama_barang = "";
$kegunaan = "";
$alasan = "";
$anggaran = "";
$masa_aktif = "";
$id = "";
$gambar_lama = "";

// Cek kalau mode edit
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $edit = $conn->query("SELECT * FROM barang WHERE id = $id")->fetch_assoc();
    if ($edit) {
        $nama_barang = $edit['nama_barang'];
        $kegunaan = $edit['kegunaan'];
        $alasan = $edit['alasan'];
        $anggaran = $edit['anggaran'];
        $masa_aktif = $edit['masa_aktif'];
        $gambar_lama = $edit['gambar'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Rekap Data</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f3f3f3;
    }

    .container {
      display: flex;
    }

    .sidebar {
      width: 200px;
      background: #2e2e2e;
      color: #fff;
      padding: 20px;
      height: 100vh;
    }

    .nav-btn {
      display: block;
      margin: 10px 0;
      padding: 10px;
      background: #8000ff;
      color: white;
      text-align: center;
      text-decoration: none;
      border-radius: 5px;
      margin-bottom: 20px;
    }

    .nav-btn.logout {
      background: #8000ff;
    }

    .content {
      flex-grow: 1;
      padding: 20px;
    }

    h1 {
      margin-top: 0;
      margin-left: 38%;
      margin-bottom: 40px;
    }

    .input-form {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-bottom: 20px;
    }

    .input-form input, .input-form button {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .input-form button {
      background: grey;
      color: white;
      cursor: pointer;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
    }

    table th, table td {
      padding: 10px;
      border: 1px solid #ccc;
      text-align: center;
    }

    table thead {
      background: grey;
      color: white;
    }

    img {
      max-width: 50px;
      height: auto;
    }

    .action-btn {
      padding: 6px 12px;
      border-radius: 4px;
      text-decoration: none;
      font-size: 14px;
      color: white;
      margin: 0 2px;
    }

    .btn-edit {
      background-color: #00aaff;
    }

    .btn-delete {
      background-color: #ff4444;
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <h2>TEKNOPHONSEL</h2>
      <a href="dashboard.php" class="nav-btn">Dashboard</a>
      <a href="data.php" class="nav-btn">Rekap Data</a>
      <a href="logout.php" class="nav-btn logout" onclick="return confirm('Anda yakin mau keluar?')">Logout</a>
    </aside>

    <!-- Main Content -->
    <main class="content">
      <h1>Rekap Data</h1>

      <!-- Form Tambah / Edit Data -->
      <form class="input-form" method="POST" action="proses.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
        <input type="hidden" name="gambar_lama" value="<?= htmlspecialchars($gambar_lama) ?>">
        <input type="text" name="nama_barang" placeholder="Nama Barang" value="<?= htmlspecialchars($nama_barang) ?>" required>
        <input type="text" name="kegunaan" placeholder="Kegunaan" value="<?= htmlspecialchars($kegunaan) ?>" required>
        <input type="text" name="alasan" placeholder="Alasan" value="<?= htmlspecialchars($alasan) ?>" required>
        <input type="number" name="anggaran" placeholder="Anggaran : Rp" value="<?= htmlspecialchars($anggaran) ?>" required>
        <input type="text" name="masa_aktif" placeholder="Masa Aktif" value="<?= htmlspecialchars($masa_aktif) ?>" required>
        <input type="file" name="gambar">

        <!-- Tombol -->
        <?php if (!empty($id)): ?>
            <button type="submit" name="update">Update</button>
        <?php else: ?>
            <button type="submit" name="tambah">Tambahkan</button>
        <?php endif; ?>
      </form>

      <!-- Tabel Data -->
      <table>
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Gambar</th>
            <th>Kegunaan</th>
            <th>Alasan</th>
            <th>Anggaran</th>
            <th>Masa Aktif</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          foreach ($barangList as $row) {
              echo "<tr>";
              echo "<td>" . $no++ . "</td>";
              echo "<td>" . htmlspecialchars($row['nama_barang']) . "</td>";
              echo "<td><img src='uploads/" . htmlspecialchars($row['gambar']) . "'></td>";
              echo "<td>" . htmlspecialchars($row['kegunaan']) . "</td>";
              echo "<td>" . htmlspecialchars($row['alasan']) . "</td>";
              echo "<td>Rp " . number_format($row['anggaran'], 0, ',', '.') . "</td>";
              echo "<td>" . htmlspecialchars($row['masa_aktif']) . "</td>";
              echo "<td>
                    <a class='action-btn btn-edit' href='data.php?id=" . $row['id'] . "'>✏️ Edit</a>
                    <a class='action-btn btn-delete' href='hapus.php?id=" . $row['id'] . "' onclick='return confirm(\"Yakin mau hapus?\")'>🗑️ Hapus</a>
                  </td>";
              echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    </main>
  </div>
</body>
</html>
