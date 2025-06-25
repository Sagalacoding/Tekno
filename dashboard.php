<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

require_once 'Barang.php';
$barang = new Barang();
$dataBarang = $barang->tampilData();

$label_array = [];
$data_array = [];
foreach ($dataBarang as $item) {
    $label_array[] = $item['nama_barang'];
    $data_array[] = (int)$item['anggaran'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
    }

    .container {
      display: flex;
      min-height: 100vh;
    }

    .sidebar {
      width: 200px;
      background: #2e2e2e;
      color: white;
      padding: 20px;
    }

    .nav-btn {
      display: block;
      margin: 10px 0;
      padding: 10px;
      background: #8000ff;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      text-align: center;
      margin-bottom: 20px;
    }

    .content {
      flex-grow: 1;
      padding: 30px;
      background: #f4f4f4;
    }

    .chart-container {
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      max-width: 800px;
      margin: auto;
    }

    canvas {
      width: 100% !important;
      height: auto !important;
    }
  .chart-container {
  width: 100%;
  height: 500px;
  max-width: 1000px;
  margin: auto;
  }

  .chart-container canvas {
    width: 100% !important;
    height: 100% !important;
  }

  </style>
</head>
<body>
  <div class="container">
    <aside class="sidebar">
      <h2>TEKNOPHONSEL</h2>
      <a href="dashboard.php" class="nav-btn">Dashboard</a>
      <a href="data.php" class="nav-btn">Rekap Data</a>
      <a href="logout.php" class="nav-btn logout" onclick="return confirm('Anda yakin mau keluar?')">Logout</a>
    </aside>

    <main class="content">
      <h1>Dashboard</h1>
      <div style="padding: 20px; width: 100%; height: 100%;">
        <div style="width: 100%; max-width: 1000px; margin: auto;">
          <canvas id="myChart" style="width: 100%; height: 400px;"></canvas>
        </div>
      </div>
    

    </main>
  </div>

  <script>
    const labels = <?= json_encode($label_array); ?>;
    const data = <?= json_encode($data_array); ?>;

    console.log("Labels:", labels);
    console.log("Data:", data);

    const ctx = document.getElementById('myChart').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [{
          label: 'Biaya Barang',
          data: data,
          backgroundColor: 'rgba(128, 0, 255, 0.6)',
          borderColor: 'rgba(128, 0, 255, 1)',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>
</body>
</html>
