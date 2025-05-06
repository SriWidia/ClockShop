<?php
include 'config.php';

if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
$filter = isset($_GET['filter']) ? mysqli_real_escape_string($conn, $_GET['filter']) : 'all';
$tanggal_penjualan = isset($_GET['tanggal_penjualan']) ? mysqli_real_escape_string($conn, $_GET['tanggal_penjualan']) : date('Y-m-d');
$bulan = isset($_GET['bulan']) ? mysqli_real_escape_string($conn, $_GET['bulan']) : date('m');
$tahun = isset($_GET['tahun']) ? mysqli_real_escape_string($conn, $_GET['tahun']) : date('Y');

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
            p.total_bayar,
            GROUP_CONCAT(pr.nama_produk SEPARATOR ', ') AS nama_produk,
            GROUP_CONCAT(dp.jumlah_produk SEPARATOR ', ') AS jumlah_produk
        FROM penjualan p
        JOIN pelanggan c ON p.idpelanggan = c.idpelanggan
        JOIN detail_penjualan dp ON p.idpenjualan = dp.idpenjualan
        JOIN produk pr ON dp.idproduk = pr.idproduk
        $whereClause
        GROUP BY p.idpenjualan";

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-4 font-sans">
    <div class="max-w-7xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <button onclick="goBack()" class="text-gray-600 hover:text-gray-900 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </button>
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

        <div id="laporan" class="mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold mt-2 text-center">Laporan Penjualan</h2> <br> 
            <table class="w-full border-collapse table-auto text-sm text-gray-600">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="px-6 py-3 text-left">ID Penjualan</th>
                        <th class="px-6 py-3 text-left">Tanggal</th>
                        <th class="px-6 py-3 text-left">Nama Produk</th>
                        <th class="px-6 py-3 text-left">Jumlah Produk</th>
                        <th class="px-6 py-3 text-left">Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0) : ?>
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr class="border-b hover:bg-gray-100">
                                <td class="px-6 py-4"><?= htmlspecialchars($row['idpenjualan']); ?></td>
                                <td class="px-6 py-4"><?= htmlspecialchars($row['tanggal_penjualan']); ?></td>
                                <td class="px-6 py-4"><?= htmlspecialchars($row['nama_produk']); ?></td>
                                <td class="px-6 py-4"><?= htmlspecialchars($row['jumlah_produk']); ?></td>
                                <td class="px-6 py-4">Rp <?= number_format($row['total_bayar'], 0, ',', '.'); ?></td>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="9" class="text-center text-gray-500 py-3">Tidak ada data yang tersedia.</td>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
    function goBack() {
        window.history.back();
    }

    function toggleInput() {
        let filter = document.getElementById('filter').value;
        document.getElementById('inputTanggal').style.display = (filter === 'harian') ? 'inline-block' : 'none';
        document.getElementById('inputBulan').style.display = (filter === 'bulanan') ? 'inline-block' : 'none';
        document.getElementById('inputTahun').style.display = (filter === 'tahunan' || filter === 'bulanan') ? 'inline-block' : 'none';
    }
    toggleInput();

    function cetakPDF() {
    const { jsPDF } = window.jspdf;
    
    html2canvas(document.getElementById("laporan"), { scale: 2 }).then(canvas => {
        const pdf = new jsPDF('l', 'mm', 'a4'); 
        const pageWidth = 297; 
        const pageHeight = 210; 
        const imgWidth = pageWidth - 20; 
        const imgHeight = (canvas.height * imgWidth) / canvas.width;

        let y = 10; 
        let heightLeft = imgHeight;

        while (heightLeft > 0) {
            let heightToPrint = Math.min(heightLeft, pageHeight - 20); 
            let canvasSection = document.createElement("canvas");
            let ctx = canvasSection.getContext("2d");

            canvasSection.width = canvas.width;
            canvasSection.height = (heightToPrint * canvas.width) / imgWidth;

            ctx.drawImage(canvas, 0, y * (canvas.width / imgWidth), canvas.width, canvasSection.height, 0, 0, canvas.width, canvasSection.height);

            let sectionImgData = canvasSection.toDataURL("image/png");
            pdf.addImage(sectionImgData, "PNG", 10, 10, imgWidth, heightToPrint);

            heightLeft -= heightToPrint;
            y += heightToPrint;

            if (heightLeft > 0) {
                pdf.addPage();
            }
        }

        pdf.save("Laporan_Penjualan.pdf");
    });
}


</script>
</html>
