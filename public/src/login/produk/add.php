<?php
include 'config.php'; 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_produk = $_POST['nama_produk'];
    $harga_jual = $_POST['harga_jual'];
    $harga_beli = $_POST['harga_beli'];
    $stok = $_POST['stok'];

    if (!empty($nama_produk) && !empty($harga_jual) && !empty($harga_beli) && !empty($stok)) {
        $stmt = $conn->prepare("INSERT INTO produk (nama_produk, harga_jual, harga_beli, stok) VALUES (?, ?, ?, ?)" );
        $stmt->bind_param("siii", $nama_produk, $harga_jual, $harga_beli, $stok);

        if ($stmt->execute()) {
            header("Location: dataproduk.php?status=success");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Semua kolom harus diisi!";
    }
}

$conn->close();
?>
