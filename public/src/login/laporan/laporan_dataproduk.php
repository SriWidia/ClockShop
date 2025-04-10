<?php
include 'config.php';

$sql = "SELECT 
            idproduk,
            nama_produk,
            harga_jual,
            harga_beli,
            stok
        FROM produk";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Produk</title>
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
        </div>
        <div id="laporan">
        <h2 class="text-3xl font-extrabold text-center text-gray-800 mb-8">Data Produk</h2>
        <table class="w-full border-collapse table-auto text-sm text-gray-600">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="px-6 py-3 text-left">ID Produk</th>
                    <th class="px-6 py-3 text-left">Nama Produk</th>
                    <th class="px-6 py-3 text-left">Harga Jual</th>
                    <th class="px-6 py-3 text-left">Harga Beli</th>
                    <th class="px-6 py-3 text-left">Stok</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0) : ?>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr class="border-b hover:bg-gray-100">
                            <td class="px-6 py-4"><?= $row['idproduk']; ?></td>
                            <td class="px-6 py-4"><?= $row['nama_produk']; ?></td>
                            <td class="px-6 py-4"><?= number_format($row['harga_jual'], 0, ',', '.'); ?></td>
                            <td class="px-6 py-4"><?= number_format($row['harga_beli'], 0, ',', '.'); ?></td>
                            <td class="px-6 py-4"><?= $row['stok']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-3">Tidak ada data produk yang tersedia.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        </div>
        
        <button onclick="cetakPDF()" class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg shadow-md transition duration-300">
            Cetak Laporan
        </button>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
    function cetakPDF() {
    let element = document.querySelector(".max-w-7xl"); 

    html2canvas(document.getElementById("laporan"), { scale: 2 }).then(canvas => {
        let { jsPDF } = window.jspdf;
        let pdf = new jsPDF('l', 'mm', 'a4'); 

        let pageWidth = 297; 
        let pageHeight = 210;
        let margin = 10;
        let imgWidth = pageWidth - 2 * margin; 
        let imgHeight = (canvas.height * imgWidth) / canvas.width; 
        let yPosition = margin; 
        let heightLeft = imgHeight; 

        while (heightLeft > 0) {
            let canvasSection = document.createElement("canvas");
            let ctx = canvasSection.getContext("2d");

            let heightToPrint = Math.min(heightLeft, pageHeight - 2 * margin); 
            canvasSection.width = canvas.width;
            canvasSection.height = (heightToPrint * canvas.width) / imgWidth;

            ctx.drawImage(
                canvas,
                0,
                (yPosition - margin) * (canvas.width / imgWidth), 
                canvas.width,
                canvasSection.height,
                0,
                0,
                canvas.width,
                canvasSection.height
            );

            let sectionImgData = canvasSection.toDataURL("image/png");
            pdf.addImage(sectionImgData, 'PNG', margin, margin, imgWidth, heightToPrint);

            heightLeft -= heightToPrint; 
            yPosition += heightToPrint; 
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
</script>
</body>
</html>
