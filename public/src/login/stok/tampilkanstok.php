<?php
include 'config.php';

$sql = "SELECT * FROM produk";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<div class='overflow-x-auto'>";
    echo "<table class='w-full border border-blue-900 rounded-lg shadow-md'>";
    echo "<thead>";
    echo "<tr class='bg-blue-600 text-white text-left border border-blue-900'>";
    echo "<th class='p-3 border border-blue-900'>ID</th>";
    echo "<th class='p-3 border border-blue-900'>Nama Produk</th>";
    echo "<th class='p-3 border border-blue-900'>Stok</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody class='divide-y divide-gray-300'>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr class='hover:bg-blue-100 transition duration-300'>";
        echo "<td class='p-3 border border-blue-900'>" . $row['idproduk'] . "</td>";
        echo "<td class='p-3 border border-blue-900'>" . $row['nama_produk'] . "</td>";
        echo "<td class='p-3 border border-blue-900'>" . $row['stok'] . "</td>";
        echo "</tr>";
    }

    echo "</tbody></table></div>";
} else {
    echo "<p class='text-center text-gray-500'>Tidak ada produk yang terdaftar.</p>";
}

$conn->close();
?>
