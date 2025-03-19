<?php
include 'config.php';

$query = isset($_GET['query']) ? $_GET['query'] : '';

$sql = "SELECT * FROM pengguna WHERE idpengguna LIKE ? OR nama LIKE ? OR username LIKE ? OR level LIKE ?";
$stmt = $conn->prepare($sql);
$search = "%$query%";
$stmt->bind_param("ssss", $search, $search, $search, $search);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<div class='overflow-x-auto'>";
    echo "<table class='w-full bg-white rounded-lg shadow-lg border-collapse overflow-hidden'>";
    echo "<thead class='bg-blue-500 text-white text-left'>";
    echo "<tr>
            <th class='p-3'>ID</th>
            <th class='p-3'>Nama</th>
            <th class='p-3'>Username</th>
            <th class='p-3'>Sandi</th>
            <th class='p-3'>Level</th>
            <th class='p-3'>Aksi</th>
          </tr>";
    echo "</thead><tbody class='text-gray-700'>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr class='border-b hover:bg-gray-100 transition duration-200'>";
        echo "<td class='p-3'>" . $row['idpengguna'] . "</td>";
        echo "<td class='p-3'>" . $row['nama'] . "</td>";
        echo "<td class='p-3'>" . $row['username'] . "</td>";
        echo "<td class='p-3'>" . $row['password'] . "</td>";
        echo "<td class='p-3'>" . $row['level'] . "</td>";
        echo "<td class='p-3 flex space-x-2'>
                <a href='edit.php?id=" . $row['idpengguna'] . "' class='bg-green-500 text-white px-3 py-1 rounded-md shadow-md hover:bg-green-600 transition duration-200'>Edit</a>
                <a href='delete.php?id=" . $row['idpengguna'] . "' class='bg-red-500 text-white px-3 py-1 rounded-md shadow-md hover:bg-red-600 transition duration-200' onclick='return confirm(\"Apakah Anda yakin ingin menghapus user ini?\")'>Hapus</a>
              </td>"; 
        echo "</tr>";
    }
    
    echo "</tbody></table></div>";
} else {
    echo "<p class='text-gray-500 text-center'>Tidak ada pengguna yang terdaftar.</p>";
}

$stmt->close();
$conn->close();
?>
