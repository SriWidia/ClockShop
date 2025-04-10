<?php
include 'config.php';

if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
}

$query = isset($_GET['query']) ? $_GET['query'] : '';

$sql = "SELECT * FROM stok WHERE idproduk LIKE ?";
$stmt = $conn->prepare($sql);

$searchQuery = "%$query%";
$stmt->bind_param("s", $searchQuery);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<table class='w-full bg-white rounded-md shadow-md'>";
    echo "<thead><tr class='bg-gray-200 text-left'>";
    echo "<th class='p-2'>ID</th>";
    echo "<th class='p-2'>ID Produk</th>";
    echo "<th class='p-2'>Tanggal</th>";
    echo "<th class='p-2'>Jumlah Stok Masuk</th>";
    echo "<th class='p-2'>Keterangan</th>";
    echo "<th class='p-2'>Action</th>";
    echo "</tr></thead><tbody>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr class='border-t'>";
        echo "<td class='p-2'>" . $row['idstok'] . "</td>";
        echo "<td class='p-2'>" . $row['idproduk'] . "</td>";
        echo "<td class='p-2'>" . $row['tanggal_input_stok'] . "</td>";
        echo "<td class='p-2'>" . $row['input_stok'] . "</td>";
        echo "<td class='p-2'>" . $row['keterangan'] . "</td>";
        echo "<td class='p-2 flex space-x-2'>
            <a href='delete.php?id=" . $row['idstok'] . "' class='bg-red-500 text-white p-2 rounded-md hover:bg-red-600' onclick='return confirm(\"Apakah Anda yakin ingin menghapus Produk ini?\")'>
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
