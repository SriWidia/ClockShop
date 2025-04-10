<?php
session_start();
include 'config.php';

if (!isset($_SESSION['idpengguna'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Pelanggan</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
<header class="bg-gradient-to-r from-blue-600 to-indigo-500 text-white shadow-md p-4 flex justify-between items-center">
  <div class="flex items-center space-x-4">
    <button onclick="goBack()" class="p-2 rounded-full bg-white bg-opacity-20 hover:bg-opacity-30 transition duration-300">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
    </button>
    <h1 class="text-xl font-bold">ClockShop</h1>
  </div>
  <div class="flex items-center space-x-4">
    <div>
      <h2 class="text-lg font-semibold"><?php echo $_SESSION['username']; ?></h2>
      <p class="text-sm opacity-90 capitalize"><?php echo $_SESSION['level']; ?></p>
    </div>
  </div>
</header>

<div class="container mx-auto p-6">
  <div class="flex justify-between items-center mb-4">
    <h2 class="text-2xl font-semibold text-gray-700">Daftar Member</h2>
    <a href="addpelanggan.php" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md shadow-md transition">Tambah Member</a>
  </div>
  <div class="bg-white p-6 rounded-lg shadow-md">
    <input type="text" placeholder="Cari Pelanggan..." id="searchInput" 
      class="w-full p-3 border rounded-md text-black focus:outline-none focus:ring focus:ring-blue-400" 
      oninput="searchPelanggan(this.value)"/>
  </div>

  <div id="PelangganList" class="mt-4 bg-white p-6 rounded-lg shadow-md">
    <?php 
    $sql = "SELECT * FROM pelanggan";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<table class='w-full border-collapse'>";
        echo "<thead><tr class='bg-gray-200 text-left text-gray-700'>";
        echo "<th class='p-3'>ID</th>";
        echo "<th class='p-3'>Nama</th>";
        echo "<th class='p-3'>Alamat</th>";
        echo "<th class='p-3'>No. Telepon</th>";
        echo "<th class='p-3'>Aksi</th>";
        echo "</tr></thead><tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr class='border-t hover:bg-gray-100'>";
            echo "<td class='p-3'>" . $row['idpelanggan'] . "</td>";
            echo "<td class='p-3'>" . $row['nama_pelanggan'] . "</td>";
            echo "<td class='p-3'>" . $row['alamat'] . "</td>";
            echo "<td class='p-3'>" . $row['no_telepon'] . "</td>";
            echo "<td class='p-3 space-x-2'>";
            echo "<a href='editpelanggan.php?id=" . $row['idpelanggan'] . "' class='bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600'>Edit</a>";
            echo "<a href='deletepelanggan.php?id=" . $row['idpelanggan'] . "' class='bg-red-500 text-white px-3 py-2 rounded hover:bg-red-600' onclick='return confirm(\"Hapus pelanggan?\")'>Hapus</a>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p class='text-gray-600'>Tidak ada pelanggan yang terdaftar.</p>";
    }
    $conn->close();
    ?>
  </div>
</div>

<script>
  function goBack() {
    window.history.back();
  }
  function searchPelanggan(query) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'cari.php?query=' + encodeURIComponent(query), true);
    xhr.onload = function () {
      if (xhr.status === 200) {
        document.getElementById('PelangganList').innerHTML = xhr.responseText;
      }
    };
    xhr.send();
  }
</script>
</body>
</html>