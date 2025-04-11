<?php
include "config.php";

$idpenjualan = isset($_GET['idpenjualan']) ? $_GET['idpenjualan'] : '';

if ($idpenjualan == '') {
    echo "ID Penjualan tidak ditemukan.";
    exit;
}

$sql = "SELECT p.*, pl.nama_pelanggan, u.nama AS nama_kasir 
        FROM penjualan p
        JOIN pelanggan pl ON p.idpelanggan = pl.idpelanggan
        JOIN pengguna u ON p.idkasir = u.idpengguna
        WHERE p.idpenjualan = '$idpenjualan'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
} else {
    echo "Transaksi tidak ditemukan.";
    exit;
}

$sql_detail = "SELECT dp.idproduk, pr.nama_produk, dp.jumlah_produk, pr.harga_jual, dp.subtotal 
               FROM detail_penjualan dp 
               JOIN produk pr ON dp.idproduk = pr.idproduk
               WHERE dp.idpenjualan = '$idpenjualan'";
$result_detail = $conn->query($sql_detail);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembelian</title>
    <link href="https://fonts.googleapis.com/css2?family=Spirax&family=Open+Sans+Condensed:wght@300&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
    <link href="./css/output.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100" onload="window.print()">

<div class="bg-white shadow-lg rounded-lg p-6 max-w-sm text-center">
    <img src="1.png" alt="Logo Toko" class="w-25 mx-auto mb-2">
    <p class="text-sm">Jln. PagarBetis, Sumedang</p>
    <hr class="my-2 border-dashed border-gray-400">
    <p class="text-sm font-semibold">
        <?php echo date("d/m/Y", strtotime($data['tanggal_penjualan'])); ?> | <?php echo $idpenjualan; ?>
    </p>
    <hr class="my-2 border-dashed border-gray-400">
    <p class="text-sm font-semibold mb-2">
        <span class="flex justify-between">
            <span>Kasir</span>
            <span class="ml-2"><?php echo $data['nama_kasir']; ?></span>
        </span>
    </p>
    <p class="text-sm font-semibold mb-2">
        <span class="flex justify-between">
            <span>Pembeli</span>
            <span class="ml-2"><?php echo $data['nama_pelanggan']; ?></span>
        </span>
    </p>

    <hr class="my-2 border-dashed border-gray-400">
    <div class="text-left">
        <?php while ($detail = $result_detail->fetch_assoc()) { ?>
            <div class="flex justify-between text-sm">
                <span><?php echo $detail['nama_produk']; ?> (<?php echo $detail['jumlah_produk']; ?>)</span>
                <span>Rp <?php echo number_format($detail['subtotal'], 0, ',', '.'); ?></span>
            </div>
        <?php } ?>
    </div>

    <hr class="my-2 border-dashed border-gray-400">
    <div class="flex justify-between font-semibold text-sm">
        <span>Total</span> 
        <span>Rp <?php echo number_format($data['total_harga'], 0, ',', '.'); ?></span>
    </div>
    <div class="flex justify-between text-sm">
        <span>Potongan</span> 
        <span>Rp <?php echo number_format($data['potongan_harga'], 0, ',', '.'); ?></span>
    </div>

    <hr class="my-2 border-dashed border-gray-400">
    <div class="flex justify-between font-semibold text-sm">
        <span>Total Bayar</span> 
        <span>Rp <?php echo number_format($data['total_bayar'], 0, ',', '.'); ?></span>
    </div>
    <div class="flex justify-between text-sm">
        <span>Tunai</span> 
        <span>Rp <?php echo number_format($data['total_uang'], 0, ',', '.'); ?></span>
    </div>
    <div class="flex justify-between text-sm">
        <span>Kembalian</span> 
        <span>Rp <?php echo number_format($data['total_kembali'], 0, ',', '.'); ?></span>
    </div>
    <hr class="my-2 border-dashed border-gray-400">

    <p class="text-xs">Terima Kasih Telah Berbelanja!</p>
    <p class="text-xs italic">Barang yang sudah dibeli tidak dapat dikembalikan kecuali ada cacat produksi.</p>
</div>

</body>
</html>
