<?php
include 'config.php';

if (!isset($_GET['id'])) {
    die("ID Penjualan tidak ditemukan.");
}

$idpenjualan = $_GET['id'];

$sql_penjualan = "SELECT p.*, pl.nama_pelanggan, u.username AS nama_kasir
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

$sql_detail = "SELECT dp.idproduk, pr.nama_produk, dp.jumlah_produk, pr.harga_jual, dp.subtotal 
               FROM detail_penjualan dp 
               JOIN produk pr ON dp.idproduk = pr.idproduk
               WHERE dp.idpenjualan = ?";
$stmt_detail = $conn->prepare($sql_detail);
$stmt_detail->bind_param("s", $idpenjualan);
$stmt_detail->execute();
$result_detail = $stmt_detail->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Penjualan</title>
    <link href="https://fonts.googleapis.com/css2?family=Spirax&family=Open+Sans+Condensed:wght@300&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-blue-100 p-6">
    <div class="max-w-4xl mx-auto bg-white p-6 shadow-lg rounded-lg mt-5">
        <div class="flex items-center gap-2 mb-6">
            <button onclick="goBack()" class="text-blue-700 hover:text-blue-900 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </button>
            <h2 class="text-2xl font-semibold text-blue-700">Detail Penjualan ID: <?php echo $penjualan['idpenjualan']; ?></h2>
        </div>    
        <p class="text-gray-600 mb-2"><strong>Pelanggan:</strong> <?php echo $penjualan['nama_pelanggan']; ?></p>
        <p class="text-gray-600 mb-2"><strong>Kasir:</strong> <?php echo $penjualan['nama_kasir']; ?></p>
        <p class="text-gray-600 mb-2"><strong>Tanggal:</strong> <?php echo $penjualan['tanggal_penjualan']; ?></p>
        <p class="text-gray-600 mb-2"><strong>Total Harga:</strong> Rp <?php echo number_format($penjualan['total_harga'], 0, ',', '.'); ?></p>
        <p class="text-gray-600 mb-2"><strong>Potongan Harga:</strong> Rp <?php echo number_format($penjualan['potongan_harga'], 0, ',', '.'); ?></p>
        <p class="text-gray-600 mb-4"><strong>Total Bayar:</strong> Rp <?php echo number_format($penjualan['total_bayar'], 0, ',', '.'); ?></p>
        <p class="text-gray-600 mb-2"><strong>Total Uang:</strong> Rp <?php echo number_format($penjualan['total_uang'], 0, ',', '.'); ?></p>
        <p class="text-gray-600 mb-4"><strong>Kembalian:</strong> Rp <?php echo number_format($penjualan['total_kembali'], 0, ',', '.'); ?></p>

        <h3 class="text-xl font-semibold mb-3 text-blue-700">Produk yang Dibeli:</h3>
        <table class="w-full border-collapse border border-blue-300">
            <thead>
                <tr class="bg-blue-200">
                    <th class="border p-2 text-blue-700">Nama Produk</th>
                    <th class="border p-2 text-blue-700">Jumlah</th>
                    <th class="border p-2 text-blue-700">Harga Satuan</th>
                    <th class="border p-2 text-blue-700">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($detail = $result_detail->fetch_assoc()) { ?>
                    <tr class='border-b hover:bg-blue-100'>
                        <td class='border p-2 text-center'><?php echo $detail['nama_produk']; ?></td>
                        <td class='border p-2 text-center'><?php echo $detail['jumlah_produk']; ?></td>
                        <td class='border p-2 text-center'>Rp <?php echo number_format($detail['harga_jual'], 0, ',', '.'); ?></td>
                        <td class='border p-2 text-center'>Rp <?php echo number_format($detail['subtotal'], 0, ',', '.'); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="mt-4">
            <a href="cetak_struk.php?id=<?php echo $penjualan['idpenjualan']; ?>" target="_blank" class="bg-green-500 text-white px-3 py-1 rounded-md hover:bg-green-700">Cetak Struk</a>
        </div>
    </div>
</body>
<script>
    function goBack() {
    window.history.back();
}
</script>
</html>

