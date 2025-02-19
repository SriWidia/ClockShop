<?php
include 'config.php';

$sql = "SELECT * FROM user";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table class='w-full bg-white rounded-md shadow-md'>";
    echo "<thead><tr class='bg-gray-200 text-left'>";
    echo "<th class='p-2'>ID</th>";
    echo "<th class='p-2'>Nama</th>";
    echo "<th class='p-2'>Username</th>";
    echo "<th class='p-2'>Password</th>";
    echo "<th class='p-2'>Level</th>";
    echo "<th class='p-2'>Action</th>";
    echo "</tr></thead><tbody>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr class='border-t'>";
        echo "<td class='p-2'>" . $row['iduser'] . "</td>";
        echo "<td class='p-2'>" . $row['nama'] . "</td>";
        echo "<td class='p-2'>" . $row['username'] . "</td>";
        echo "<td class='p-2'>" . $row['password'] . "</td>";
        echo "<td class='p-2'>" . $row['level'] . "</td>";
        echo "<td class='p-2 flex space-x-2'>
            <a href='edit.php?id=" . $row['iduser'] . "' class='bg-yellow-400 text-white p-2 rounded-md hover:bg-yellow-500'>
            Edit
            </a>

            <a href='delete.php?id=" . $row['iduser'] . "' class='bg-red-500 text-white p-2 rounded-md hover:bg-red-600' onclick='return confirm(\"Apakah Anda yakin ingin menghapus Produk ini?\")'>
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
