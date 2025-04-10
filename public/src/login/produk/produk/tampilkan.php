<?php
include 'config.php';

$sql = "SELECT * FROM produk";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table class='w-full bg-white rounded-md shadow-md'>";
    echo "<thead><tr class='bg-gray-200 text-left'>";
    echo "<th class='p-2'>ID</th>";
    echo "<th class='p-2'>Nama Produk</th>";
    echo "<th class='p-2'>Harga Beli</th>";
    echo "<th class='p-2'>Harga Jual</th>";
    echo "<th class='p-2'>Stok</th>";
    echo "<th class='p-2'>Action</th>";
    echo "</tr></thead><tbody>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr class='border-t'>";
        echo "<td class='p-2'>" . $row['idproduk'] . "</td>";
        echo "<td class='p-2'>" . $row['nama_produk'] . "</td>";
        echo "<td class='p-2'>Rp. " . number_format($row['harga_beli'], 0, ',', '.') . "</td>";
        echo "<td class='p-2'>Rp. " . number_format($row['harga_jual'], 0, ',', '.') . "</td>";
        echo "<td class='p-2'>" . $row['stok'] . "</td>";
        echo "<td class='p-2 flex space-x-2'>
            <a href='edit.php?id=" . $row['idproduk'] . "' class='bg-green-400 text-white p-2 rounded-md hover:bg-green-500'>
            Edit
            </a>
            <a href='delete.php?id=" . $row['idproduk'] . "' class='bg-red-500 text-white p-2 rounded-md hover:bg-red-600' onclick='return confirm(\"Apakah Anda yakin ingin menghapus Produk ini?\")'>
            Hapus
            </a>
            <a href='./stok/datastok.php' class='bg-indigo-400 text-white p-2 rounded-md hover:bg-indigo-500''>
                Tambah Stok
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
