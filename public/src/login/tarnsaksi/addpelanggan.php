<?php
include 'config.php'; 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $alamat = $_POST['alamat'];
    $no_telepon = $_POST['no_telepon'];

    if (!empty($nama_pelanggan) && !empty($alamat) && !empty($no_telepon) ) {
        $stmt = $conn->prepare("INSERT INTO pelanggan (nama_pelanggan, alamat, no_telepon) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nama_pelanggan, $alamat, $no_telepon);

        if ($stmt->execute()) {
            header("Location: datapelanggan.php?status=success");
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
