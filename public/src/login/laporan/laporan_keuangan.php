<?php
include 'config.php';

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$tanggal_penjualan = isset($_GET['tanggal_penjualan']) ? $_GET['tanggal_penjualan'] : date('Y-m-d');
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

$whereClause = "";
if ($filter == "harian") {
    $whereClause = "WHERE DATE(p.tanggal_penjualan) = '$tanggal_penjualan'";
} elseif ($filter == "bulanan") {
    $whereClause = "WHERE MONTH(p.tanggal_penjualan) = '$bulan' AND YEAR(p.tanggal_penjualan) = '$tahun'";
} elseif ($filter == "tahunan") {
    $whereClause = "WHERE YEAR(p.tanggal_penjualan) = '$tahun'";
}

$sql = "SELECT 
    p.idpenjualan,
    p.tanggal_penjualan,
    SUM(dp.jumlah_produk) AS jumlah_produk,
    p.total_bayar AS penjualan,
    SUM(dp.jumlah_produk * pr.harga_beli) AS pengeluaran,
    (p.total_bayar - SUM(dp.jumlah_produk * pr.harga_beli)) AS untung_rugi
FROM penjualan p
JOIN detail_penjualan dp ON p.idpenjualan = dp.idpenjualan
JOIN produk pr ON dp.idproduk = pr.idproduk
$whereClause
GROUP BY p.idpenjualan, p.tanggal_penjualan, p.total_bayar";

$result = mysqli_query($conn, $sql);

$sql_total = "SELECT 
    SUM(d.jumlah_produk) AS total_barang_terjual, 
    SUM(p.total_bayar) AS total_harga_terjual,
    SUM(d.jumlah_produk * pr.harga_beli) AS total_modal,
    SUM(p.total_bayar - (d.jumlah_produk * pr.harga_beli)) AS total_keuntungan
FROM detail_penjualan d
JOIN penjualan p ON d.idpenjualan = p.idpenjualan
JOIN produk pr ON d.idproduk = pr.idproduk
$whereClause";

$result_total = mysqli_query($conn, $sql_total);
$total = mysqli_fetch_assoc($result_total);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</head>
<body class="bg-gray-100 p-4">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <button onclick="goBack()" class="text-gray-600 hover:text-gray-900 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </button>
            <h2 class="text-2xl font-bold text-center text-gray-700">Laporan Penjualan</h2>
            <div></div>
        </div>

        <form method="GET" class="mb-4 text-center">
            <label for="filter" class="font-semibold">Filter: </label>
            <select name="filter" id="filter" class="border rounded px-3 py-1" onchange="toggleInput()">
                <option value="all" <?= ($filter == 'all') ? 'selected' : '' ?>>Semua</option>
                <option value="harian" <?= ($filter == 'harian') ? 'selected' : '' ?>>Per Hari</option>
                <option value="bulanan" <?= ($filter == 'bulanan') ? 'selected' : '' ?>>Per Bulan</option>
                <option value="tahunan" <?= ($filter == 'tahunan') ? 'selected' : '' ?>>Per Tahun</option>
            </select>

            <input type="date" name="tanggal_penjualan" id="inputTanggal" class="border rounded px-3 py-1" style="display: none;" value="<?= $tanggal_penjualan ?>">
            <select name="bulan" id="inputBulan" class="border rounded px-3 py-1" style="display: none;">
                <?php for ($i = 1; $i <= 12; $i++) : ?>
                    <option value="<?= $i ?>" <?= ($bulan == $i) ? 'selected' : '' ?>><?= date("F", mktime(0, 0, 0, $i, 10)) ?></option>
                <?php endfor; ?>
            </select>
            <select name="tahun" id="inputTahun" class="border rounded px-3 py-1" style="display: none;">
                <?php for ($i = 2020; $i <= date('Y'); $i++) : ?>
                    <option value="<?= $i ?>" <?= ($tahun == $i) ? 'selected' : '' ?>><?= $i ?></option>
                <?php endfor; ?>
            </select>

            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded">Tampilkan</button>
        </form>

        <div id="laporan" class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold mt-2 text-center">Data Penjualan</h2><br>
            <table class="w-full border border-gray-300 bg-white rounded-lg">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2">ID Penjualan</th>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Jumlah Barang</th>
                        <th class="px-4 py-2">Penjualan</th>
                        <th class="px-4 py-2">Pengeluaran</th>
                        <th class="px-4 py-2">Untung/Rugi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0) : ?>
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr class="border-b hover:bg-gray-100">
                                <td class="px-4 py-3 font-semibold"><?= $row['idpenjualan']; ?></td>
                                <td class="px-4 py-3"><?= $row['tanggal_penjualan']; ?></td>
                                <td class="px-4 py-3"><?= number_format($row['jumlah_produk'], 0, ',', '.'); ?></td>
                                <td class="px-4 py-3"><?= number_format($row['penjualan'], 0, ',', '.'); ?></td>
                                <td class="px-4 py-3 text-blue-600"><?= number_format($row['pengeluaran'], 0, ',', '.'); ?></td>
                                <td class="px-4 py-3 font-semibold <?= ($row['untung_rugi'] >= 0) ? 'text-green-600' : 'text-red-600'; ?>">
                                    <?= number_format($row['untung_rugi'], 0, ',', '.'); ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        <!-- <tr class="bg-gray-200 font-bold">
                            <td colspan="2" class="px-4 py-3 text-right">Total:</td>
                            <td class="px-4 py-3"><?= number_format($total['total_barang_terjual'], 0, ',', '.'); ?></td>
                            <td class="px-4 py-3"><?= number_format($total['total_harga_terjual'], 0, ',', '.'); ?></td>
                            <td class="px-4 py-3 text-blue-600"><?= number_format($total['total_modal'], 0, ',', '.'); ?></td>
                            <td class="px-4 py-3 <?= ($total['total_keuntungan'] >= 0) ? 'text-green-600' : 'text-red-600'; ?>">
                                <?= number_format($total['total_keuntungan'], 0, ',', '.'); ?>
                            </td>
                        </tr> -->
                    <?php else : ?>
                        <tr>
                            <td colspan="6" class="text-center text-gray-500 py-3">Tidak ada data yang tersedia.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-6">
            <button onclick="cetakPDF()" class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg shadow-md transition duration-300">
                Cetak Laporan
            </button>
        </div>
    </div>
</body>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    let filter = document.getElementById('filter');
    
    function toggleInput() {
        let value = filter.value;
        document.getElementById('inputTanggal').style.display = (value === 'harian') ? 'inline-block' : 'none';
        document.getElementById('inputBulan').style.display = (value === 'bulanan') ? 'inline-block' : 'none';
        document.getElementById('inputTahun').style.display = (value === 'tahunan' || value === 'bulanan') ? 'inline-block' : 'none';
    }
    toggleInput();

    filter.addEventListener('change', toggleInput);
});


function cetakPDF() {
    const { jsPDF } = window.jspdf;
    const laporan = document.querySelector("#laporan");

    html2canvas(laporan, { scale: 2 }).then(canvas => {
        const doc = new jsPDF('p', 'mm', 'a4');
        const pageWidth = 210;  
        const pageHeight = 297;
        const marginX = 10; 
        const marginY = 10;  
        const imgWidth = pageWidth - (2 * marginX);
        const imgHeight = (canvas.height * imgWidth) / canvas.width;

        const totalPages = Math.ceil(imgHeight / (pageHeight - 2 * marginY));
        let currentHeight = 0;

        for (let i = 0; i < totalPages; i++) {
            if (i > 0) doc.addPage(); 

            const sectionCanvas = document.createElement("canvas");
            sectionCanvas.width = canvas.width;
            sectionCanvas.height = (pageHeight - 2 * marginY) * (canvas.width / imgWidth);

            const ctx = sectionCanvas.getContext("2d");
            ctx.drawImage(
                canvas,
                0, currentHeight, canvas.width, sectionCanvas.height, 
                0, 0, sectionCanvas.width, sectionCanvas.height 
            );

            const sectionImgData = sectionCanvas.toDataURL("image/png");
            doc.addImage(sectionImgData, "PNG", marginX, marginY, imgWidth, pageHeight - 2 * marginY);

            currentHeight += sectionCanvas.height; 
        }

        doc.save("Laporan_Keuntungan.pdf");
    });
}


    function goBack() {
        window.history.back();
    }
</script>

</html>