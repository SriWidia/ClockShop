<?php
include 'config.php';
session_start(); 

$query = isset($_GET['query']) ? $_GET['query'] : '';

$sql = "SELECT * FROM penjualan WHERE idpenjualan LIKE '%$query%' OR tanggal_penjualan LIKE '%$query%'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr class='border-b hover:bg-gray-100'>
                <td class='border p-2 text-center'>{$row['idpenjualan']}</td>
                <td class='border p-2 text-center'>{$row['tanggal_penjualan']}</td>
                <td class='border p-2 text-center'>Rp " . number_format($row['total_harga'], 0, ',', '.') . "</td>
                <td class='border p-2 text-center'>
                    <a href='detail_penjualan.php?id={$row['idpenjualan']}' class='bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-700'>Lihat Detail</a>";

        if ($_SESSION['level'] !== 'petugas') {
            echo " <a href='delete_penjualan.php?id={$row['idpenjualan']}' class='bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-700'>Batalkan Transaksi</a>";
        }

        echo "</td></tr>";
    }
} else {
    echo "<tr><td colspan='4' class='text-center p-4'>Tidak ada hasil yang ditemukan</td></tr>";
}
?>
