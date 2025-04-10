<?php
session_start();
include "config.php";

if (!isset($_SESSION['idpengguna'])) {
    die("Anda harus login terlebih dahulu!");
}

$idpenjualan = mysqli_real_escape_string($conn, $_POST['idpenjualan']);
$idpelanggan = mysqli_real_escape_string($conn, $_POST['idpelanggan']);
$tanggal_penjualan = mysqli_real_escape_string($conn, $_POST['tanggal_penjualan']);
$total_harga = str_replace(',', '', $_POST['total_harga']);
$potongan_harga = str_replace(',', '', $_POST['potongan_harga']);
$total_bayar = str_replace(',', '', $_POST['total_bayar']);
$total_uang = str_replace(',', '', $_POST['total_uang']);
$total_kembali = str_replace(',', '', $_POST['total_kembali']);
$idkasir = $_SESSION['idpengguna']; 

$sql = "INSERT INTO penjualan (idpenjualan, idkasir, idpelanggan, tanggal_penjualan, total_harga, potongan_harga, total_bayar, total_uang, total_kembali) 
        VALUES ('$idpenjualan', '$idkasir', '$idpelanggan', '$tanggal_penjualan', '$total_harga', '$potongan_harga', '$total_bayar', '$total_uang', '$total_kembali')";

if ($conn->query($sql) === TRUE) {
    echo "Transaksi berhasil disimpan";
} else {
    echo "Gagal menyimpan transaksi: " . $conn->error;
}

$conn->close();
?>
