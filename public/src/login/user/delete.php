<?php
include 'config.php';

if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM pengguna WHERE idpengguna = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: datauser.php?status=deleted"); 
}

$conn->close();
?>
