<?php
include 'config.php';

if (!isset($_GET['id'])) {
    die("ID Penjualan tidak ditemukan.");
}

$idpenjualan = $_GET['id'];

$sql_penjualan = "SELECT p.*, pl.nama_pelanggan, u.nama AS nama_kasir 
        FROM penjualan p
        JOIN pelanggan pl ON p.idpelanggan = pl.idpelanggan
        JOIN pengguna u ON p.idkasir = u.idpengguna
        WHERE p.idpenjualan = ?";
$stmt = $conn->prepare($sql_penjualan);
$stmt->bind_param("s", $idpenjualan);
$stmt->execute();
$result_penjualan = $stmt->get_result();
$penjualan = $result_penjualan->fetch_assoc();

if (!$penjualan) {
    die("Data penjualan tidak ditemukan.");
}

$sql_detail = "SELECT 
                dp.idproduk, 
                pr.nama_produk, 
                SUM(dp.jumlah_produk) AS jumlah_produk, 
                pr.harga_jual, 
                SUM(dp.subtotal) AS subtotal 
            FROM detail_penjualan dp 
            JOIN produk pr ON dp.idproduk = pr.idproduk
            WHERE dp.idpenjualan = ?
            GROUP BY dp.idproduk, pr.nama_produk, pr.harga_jual";

$stmt_detail = $conn->prepare($sql_detail);
$stmt_detail->bind_param("s", $idpenjualan);
$stmt_detail->execute();
$result_detail = $stmt_detail->get_result();

$detail_produk = [];
while ($row = $result_detail->fetch_assoc()) {
    $detail_produk[] = $row;
}
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
<body class="flex items-center justify-center min-h-screen bg-gray-100">

<div class="bg-white shadow-lg rounded-lg p-6 max-w-sm text-center">
    <img src="1.png" alt="Logo Toko" class="w-25 mx-auto mb-2">
    <p class="text-sm">Jln. PagarBetis, Sumedang</p>
    <hr class="my-2 border-dashed border-gray-400">
    <p class="text-sm font-semibold">
        <?php echo date("d/m/Y", strtotime($penjualan['tanggal_penjualan'])); ?> | KSS-<?php echo $idpenjualan; ?>
    </p>

    <hr class="my-2 border-dashed border-gray-400">
    <p class="text-sm font-semibold mb-2">
        <span class="flex justify-between">
            <span>Kasir</span>
            <span class="ml-2"><?php echo $penjualan['nama_kasir']; ?></span>
        </span>
    </p>
    <p class="text-sm font-semibold mb-2">
        <span class="flex justify-between">
            <span>Pembeli</span>
            <span class="ml-2"><?php echo $penjualan['nama_pelanggan']; ?></span>
        </span>
    </p>
    <hr class="my-2 border-dashed border-gray-400">

    <div class="text-left">
        <?php foreach ($detail_produk as $detail) { ?>
            <div class="flex justify-between text-sm">
                <span><?php echo $detail['nama_produk']; ?> (<?php echo $detail['jumlah_produk']; ?>)</span>
                <span>Rp <?php echo number_format($detail['subtotal'], 0, ',', '.'); ?></span>
            </div>
        <?php } ?>
    </div>

    <hr class="my-2 border-dashed border-gray-400">
    <div class="flex justify-between font-semibold text-sm">
        <span>Total</span> 
        <span>Rp <?php echo number_format($penjualan['total_harga'], 0, ',', '.'); ?></span>
    </div>
    <div class="flex justify-between text-sm">
        <span>Potongan</span> 
        <span>Rp <?php echo number_format($penjualan['potongan_harga'], 0, ',', '.'); ?></span>
    </div>

    <hr class="my-2 border-dashed border-gray-400">
    <div class="flex justify-between font-semibold text-sm">
        <span>Total Bayar</span> 
        <span>Rp <?php echo number_format($penjualan['total_bayar'], 0, ',', '.'); ?></span>
    </div>
    <div class="flex justify-between text-sm">
        <span>Tunai</span> 
        <span>Rp <?php echo number_format($penjualan['total_uang'], 0, ',', '.'); ?></span>
    </div>
    <div class="flex justify-between text-sm">
        <span>Kembalian</span> 
        <span>Rp <?php echo number_format($penjualan['total_kembali'], 0, ',', '.'); ?></span>
    </div>
    <hr class="my-2 border-dashed border-gray-400">

    <p class="text-xs">Terima Kasih Telah Berbelanja!</p>
    <p class="text-xs italic">Barang yang sudah dibeli tidak dapat dikembalikan kecuali ada cacat produksi.</p>

    <button class="mt-3 px-4 py-2 bg-green-500 text-white text-sm rounded shadow-md" onclick="window.print()">Cetak Struk</button>
</div>

</body>
</html>
