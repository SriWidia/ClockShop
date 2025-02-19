<?php
$conn = new mysqli('localhost', 'root', '', 'kasir_ukk_widia');

if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
}

$query = isset($_GET['query']) ? $_GET['query'] : '';

$sql = "SELECT * FROM user WHERE username LIKE ? OR level LIKE ?";
$stmt = $conn->prepare($sql);
$searchQuery = "%$query%";
$stmt->bind_param("ss", $searchQuery, $searchQuery);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<table class='w-full bg-white rounded-md shadow-md'>";
    echo "<thead><tr class='bg-gray-200 text-left'>";
    echo "<th class='p-2'>ID</th>";
    echo "<th class='p-2'>Username</th>";
    echo "<th class='p-2'>Password</th>";
    echo "<th class='p-2'>Level</th>";
    echo "<th class='p-2'>Aksi</th>";
    echo "</tr></thead><tbody>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr class='border-t'>";
        echo "<td class='p-2'>" . htmlspecialchars($row['iduser']) . "</td>";
        echo "<td class='p-2'>" . htmlspecialchars($row['username']) . "</td>";
        echo "<td class='p-2'>" . htmlspecialchars($row['password']) . "</td>";
        echo "<td class='p-2'>" . htmlspecialchars($row['level']) . "</td>";
        echo "<td class='p-2 flex space-x-2'>
            <a href='edit.php?id=" . $row['iduser'] . "' class='bg-yellow-400 text-white p-2 rounded-md hover:bg-yellow-500'>
            Edit
            </a>
            
            <a href='delete.php?id=" . $row['iduser'] . "' class='bg-red-500 text-white p-2 rounded-md hover:bg-red-600' onclick='return confirm(\"Apakah Anda yakin ingin menghapus produk ini?\")'>
            Hapus
            </a>
        </td>"; 
        echo "</tr>";
    }

    echo "</tbody></table>";
} else {
    echo "<p class='text-gray-500'>Tidak ada produk ditemukan.</p>";
}

$conn->close();
?>
