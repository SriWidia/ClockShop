<?php
$conn = new mysqli('localhost', 'root', '', 'kasir_ukk_widia');

if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM pelanggan WHERE idpelanggan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: datapelanggan.php?status=deleted"); 
}

$conn->close();
?>
