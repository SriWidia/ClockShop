<?php
include 'config.php';

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$tanggal_penjualan = isset($_GET['tanggal_penjualan']) ? $_GET['tanggal_penjualan'] : date('Y-m-d');
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

$whereClauseMasuk = "";
$whereClauseKeluar = "";

if ($filter == "harian") {
    $whereClauseMasuk = "WHERE DATE(s.tanggal_input_stok) = '$tanggal_penjualan'";
    $whereClauseKeluar = "WHERE DATE(d.tanggal_penjualan) = '$tanggal_penjualan'";
} elseif ($filter == "bulanan") {
    $whereClauseMasuk = "WHERE MONTH(s.tanggal_input_stok) = '$bulan' AND YEAR(s.tanggal_input_stok) = '$tahun'";
    $whereClauseKeluar = "WHERE MONTH(d.tanggal_penjualan) = '$bulan' AND YEAR(d.tanggal_penjualan) = '$tahun'";
} elseif ($filter == "tahunan") {
    $whereClauseMasuk = "WHERE YEAR(s.tanggal_input_stok) = '$tahun'";
    $whereClauseKeluar = "WHERE YEAR(d.tanggal_penjualan) = '$tahun'";
}

$sql_masuk = "SELECT 
                p.idproduk, 
                p.nama_produk, 
                s.tanggal_input_stok AS tanggal_masuk, 
                s.input_stok AS jumlah_masuk
              FROM produk p
              INNER JOIN stok s ON p.idproduk = s.idproduk
              $whereClauseMasuk
              ORDER BY s.tanggal_input_stok ASC";

$result_masuk = $conn->query($sql_masuk);

$sql_keluar = "SELECT 
                 p.idproduk, 
                 p.nama_produk, 
                 d.tanggal_penjualan AS tanggal_keluar, 
                 SUM(d.jumlah_produk) AS jumlah_keluar
               FROM produk p
               INNER JOIN detail_penjualan d ON p.idproduk = d.idproduk
               $whereClauseKeluar
               GROUP BY p.idproduk, d.tanggal_penjualan, p.nama_produk
               ORDER BY d.tanggal_penjualan ASC";


$result_keluar = $conn->query($sql_keluar);
$totalMasuk = 0;
$totalKeluar = 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Produk Masuk & Keluar</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="p-6 bg-gray-100">
    <div class="max-w-5xl mx-auto bg-white p-6 shadow-lg rounded-lg">
        
        <div class="flex justify-between items-center mb-6">
            <button onclick="goBack()" class="text-gray-600 hover:text-gray-900 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </button>
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
        <div id="laporan" class="mx-auto bg-white p-6 rounded-lg shadow-md"><br>
        
        <h2 class="text-lg font-semibold mt-2 text-center">Laporan Produk Masuk & Keluar</h2> <br> 
        <h2 class="text-xl font-semibold mb-2">Produk Masuk</h2>
        <table id="tableMasuk" class="w-full border-collapse border border-gray-300 mb-6">
            <thead>
                <tr class="bg-green-200">
                    <th class="border border-gray-300 px-4 py-2">ID Produk</th>
                    <th class="border border-gray-300 px-4 py-2">Nama Produk</th>
                    <th class="border border-gray-300 px-4 py-2">Tanggal Masuk</th>
                    <th class="border border-gray-300 px-4 py-2">Jumlah Masuk</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result_masuk->fetch_assoc()) : 
                    $totalMasuk += $row['jumlah_masuk'];
                ?>
                    <tr class="bg-white">
                        <td class="border border-gray-300 px-4 py-2"><?= $row['idproduk']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= $row['nama_produk']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= $row['tanggal_masuk']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= $row['jumlah_masuk']; ?></td>
                    </tr>
                <?php endwhile; ?>
                <tr class="bg-gray-100">
                    <td colspan="3" class="border border-gray-300 px-4 py-2 text-right font-semibold">Total Produk Masuk</td>
                    <td class="border border-gray-300 px-4 py-2"><?= $totalMasuk; ?></td>
                </tr>
            </tbody>
        </table>

        <h2 class="text-xl font-semibold mb-2">Produk Keluar</h2>
        <table id="tableKeluar" class="w-full border-collapse border border-gray-300 mb-6">

            <thead>
                <tr class="bg-red-200">
                    <th class="border border-gray-300 px-4 py-2">ID Produk</th>
                    <th class="border border-gray-300 px-4 py-2">Nama Produk</th>
                    <th class="border border-gray-300 px-4 py-2">Tanggal Keluar</th>
                    <th class="border border-gray-300 px-4 py-2">Jumlah Keluar</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result_keluar->fetch_assoc()) : 
                    $totalKeluar += $row['jumlah_keluar'];
                ?>
                    <tr class="bg-white">
                        <td class="border border-gray-300 px-4 py-2"><?= $row['idproduk']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= $row['nama_produk']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= $row['tanggal_keluar']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= $row['jumlah_keluar']; ?></td>
                    </tr>
                <?php endwhile; ?>
                <tr class="bg-gray-100">
                    <td colspan="3" class="border border-gray-300 px-4 py-2 text-right font-semibold">Total Produk Keluar</td>
                    <td class="border border-gray-300 px-4 py-2"><?= $totalKeluar; ?></td>
                </tr>
            </tbody>
        </table>
        </div>
        
        <div class="text-center mt-6">
        <button onclick="cetakPDF()" class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg shadow-md transition duration-300">
            Cetak Laporan
        </button>

        </div>
    </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
function cetakPDF() {
    let laporan = document.getElementById("laporan");

    html2canvas(laporan, {
        scale: 2,  
        useCORS: true 
    }).then(canvas => {
        let { jsPDF } = window.jspdf;
        let pdf = new jsPDF('p', 'mm', 'a4'); 

        let pageWidth = 210;
        let pageHeight = 297;
        let margin = 10; 
        let imgWidth = pageWidth - 2 * margin;
        let imgHeight = (canvas.height * imgWidth) / canvas.width;

        let yPosition = margin;
        let heightLeft = imgHeight;

        let imgData = canvas.toDataURL("image/png");

        while (heightLeft > 0) {
            let pageCanvas = document.createElement("canvas");
            let pageCtx = pageCanvas.getContext("2d");

            let sectionHeight = Math.min(heightLeft, pageHeight - 2 * margin); 
            pageCanvas.width = canvas.width;
            pageCanvas.height = (sectionHeight * canvas.width) / imgWidth;

            pageCtx.drawImage(
                canvas,
                0,
                yPosition * (canvas.width / imgWidth),
                canvas.width,
                pageCanvas.height,
                0,
                0,
                canvas.width,
                pageCanvas.height
            );

            let sectionImgData = pageCanvas.toDataURL("image/png");
            pdf.addImage(sectionImgData, 'PNG', margin, margin, imgWidth, sectionHeight);

            heightLeft -= sectionHeight;
            yPosition += sectionHeight;

            if (heightLeft > 0) {
                pdf.addPage();
            }
        }

        pdf.save("Laporan_Produk.pdf");
    });
}


    function goBack() {
        window.history.back();
    }

    function toggleInput() {
        let filter = document.getElementById("filter").value;
        document.getElementById("inputTanggal").style.display = filter === "harian" ? "inline-block" : "none";
        document.getElementById("inputBulan").style.display = filter === "bulanan" ? "inline-block" : "none";
        document.getElementById("inputTahun").style.display = (filter === "bulanan" || filter === "tahunan") ? "inline-block" : "none";
    }
</script>

</body>
</html>
