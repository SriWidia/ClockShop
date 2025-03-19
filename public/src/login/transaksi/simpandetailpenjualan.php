<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_penjualan = $_POST['idpenjualan'];
    $id_produk = $_POST['idproduk'];
    $jumlah_produk = $_POST['jumlah_produk'];
    $subtotal = $_POST['subtotal'];
    $tanggal_penjualan = $_POST['tanggal_penjualan'];

    $query = "INSERT INTO detail_penjualan (idpenjualan, idproduk, jumlah_produk, subtotal, tanggal_penjualan) 
              VALUES ('$id_penjualan', '$id_produk', '$jumlah_produk', '$subtotal', '$tanggal_penjualan')";

    if (mysqli_query($conn, $query)) {
        echo "success";
    } else {
        echo "error";
    }
}
?>
