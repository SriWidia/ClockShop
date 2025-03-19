<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM penjualan WHERE idpenjualan = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Data berhasil dihapus!');
                window.location.href = 'penjualan.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus data!');
                window.location.href = 'penjualan.php'; 
              </script>";
    }
}

$conn->close();
?>
