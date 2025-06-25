    <?php
    include 'config.php';

    $id = $_GET['id'];
    $query = $conn->query("DELETE FROM barang WHERE id = $id");

    if ($query) {
        header("Location: data.php");
    } else {
        echo "Gagal menghapus data.";
    }
    ?>
