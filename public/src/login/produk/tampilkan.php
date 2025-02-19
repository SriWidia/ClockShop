<?php
include 'config.php';

$sql = "SELECT * FROM produk";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table class='w-full bg-white rounded-md shadow-md'>";
    echo "<thead><tr class='bg-gray-200 text-left'>";
    echo "<th class='p-2'>ID</th>";
    echo "<th class='p-2'>nama_produk</th>";
    echo "<th class='p-2'>harga_beli</th>";
    echo "<th class='p-2'>harga_jual</th>";
    echo "<th class='p-2'>stok</th>";
    echo "<th class='p-2'>Action</th>";
    echo "</tr></thead><tbody>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr class='border-t'>";
        echo "<td class='p-2'>" . $row['idproduk'] . "</td>";
        echo "<td class='p-2'>" . $row['nama_produk'] . "</td>";
        echo "<td class='p-2'>" . $row['harga_beli'] . "</td>";
        echo "<td class='p-2'>" . $row['harga_jual'] . "</td>";
        echo "<td class='p-2'>" . $row['stok'] . "</td>";
        echo "<td class='p-2 flex space-x-2'>
            <a href='edit.php?id=" . $row['idproduk'] . "' class='bg-yellow-400 text-white p-2 rounded-md hover:bg-yellow-500'>
            Edit
            </a>

            <a href='delete.php?id=" . $row['idproduk'] . "' class='bg-red-500 text-white p-2 rounded-md hover:bg-red-600' onclick='return confirm(\"Apakah Anda yakin ingin menghapus Produk ini?\")'>
            Hapus
            </a>
        </td>"; 
        echo "</tr>";
    }

    echo "</tbody></table>";
} else {
    echo "<p>Tidak ada produk yang terdaftar.</p>";
}

$conn->close();
?>
