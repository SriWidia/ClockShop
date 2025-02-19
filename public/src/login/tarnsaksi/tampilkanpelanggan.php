<?php
include 'config.php';

$sql = "SELECT * FROM pelanggan";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table class='w-full bg-white rounded-md shadow-md'>";
    echo "<thead><tr class='bg-gray-200 text-left'>";
    echo "<th class='p-2'>ID</th>";
    echo "<th class='p-2'>nama_pelanggan</th>";
    echo "<th class='p-2'>alamat</th>";
    echo "<th class='p-2'>no_telepon</th>";
    echo "<th class='p-2'>Action</th>";
    echo "</tr></thead><tbody>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr class='border-t'>";
        echo "<td class='p-2'>" . $row['idpelanggan'] . "</td>";
        echo "<td class='p-2'>" . $row['nama_pelanggan'] . "</td>";
        echo "<td class='p-2'>" . $row['alamat'] . "</td>";
        echo "<td class='p-2'>" . $row['no_telepon'] . "</td>";
        echo "<td class='p-2 flex space-x-2'>
            <a href='editpelanggan.php?id=" . $row['idpelanggan'] . "' class='bg-yellow-400 text-white p-2 rounded-md hover:bg-yellow-500'>
            Edit
            </a>
            <a href='deletepelanggan.php?id=" . $row['idpelanggan'] . "' class='bg-red-500 text-white p-2 rounded-md hover:bg-red-600' onclick='return confirm(\"Apakah Anda yakin ingin menghapus Pelanggan ini?\")'>
            Hapus
            </a>
            </a>
            <button onclick='pilihPelanggan(\"" . $row['idpelanggan'] . "\", \"" . $row['nama_pelanggan'] . "\")' class='bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600'>Pilih</button>
        </td>"; 
        echo "</tr>";
    }

    echo "</tbody></table>";
} else {
    echo "<p>Tidak ada Pelanggan yang terdaftar.</p>";
}

$conn->close();
?>
<script>
    function pilihPelanggan(id, nama) {
    window.location.href = "transaksi.php?idpelanggan=" + id + "&nama_pelanggan=" + encodeURIComponent(nama);
}
</script>
