<?php
include 'config.php';

$query = isset($_GET['query']) ? $_GET['query'] : '';

$sql = "SELECT * FROM pelanggan WHERE idpelanggan LIKE ? OR nama_pelanggan LIKE ?";
$stmt = $conn->prepare($sql);
$search = "%$query%";
$stmt->bind_param("ss", $search, $search);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<table class='w-full bg-white rounded-md shadow-md'>";
    echo "<thead><tr class='bg-gray-200 text-left'>";
    echo "<th class='p-2'>ID</th>";
    echo "<th class='p-2'>Nama Member</th>";
    echo "<th class='p-2'>Alamat</th>";
    echo "<th class='p-2'>No. Telepon</th>";
    echo "<th class='p-2'>Action</th>";
    echo "</tr></thead><tbody>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr class='border-t'>";
        echo "<td class='p-2'>" . $row['idpelanggan'] . "</td>";
        echo "<td class='p-2'>" . $row['nama_pelanggan'] . "</td>";
        echo "<td class='p-2'>" . $row['alamat'] . "</td>";
        echo "<td class='p-2'>" . $row['no_telepon'] . "</td>";
        echo "<td class='p-2 flex space-x-2'>
            <a href='editpelanggan.php?id=" . $row['idpelanggan'] . "' class='bg-green-400 text-white p-2 rounded-md hover:bg-green-500'>
                Edit
            </a>
            <a href='deletepelanggan.php?id=" . $row['idpelanggan'] . "' class='bg-red-500 text-white p-2 rounded-md hover:bg-red-600' onclick='return confirm(\"Apakah Anda yakin ingin menghapus Pelanggan ini?\")'>
                Hapus
            </a>
            </td>"; 
        echo "</tr>";
    }

    echo "</tbody></table>";
} else {
    echo "<p>Tidak ada Pelanggan yang terdaftar.</p>";
}

$stmt->close();
$conn->close();
?>
