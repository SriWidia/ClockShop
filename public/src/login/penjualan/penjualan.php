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
    <title>Data Penjualan</title>
    <link href="https://fonts.googleapis.com/css2?family=Spirax&family=Open+Sans+Condensed:wght@300&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
    <link href="./css/output.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="bg-gray-100">
<header class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-600 to-indigo-500 text-white shadow-lg">
  <div class="flex items-center space-x-4">
    <button onclick="goBack()" class="p-2 rounded-full bg-white bg-opacity-20 hover:bg-opacity-30 transition duration-300">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
    </button>
    
    <div class="flex items-center space-x-3">
      <div>
        <p class="font-bold text-xl tracking-wide">ClockShop</p>
        <p class="text-sm hidden sm:block opacity-90 italic">Aplikasi Pengelolaan Kasir Toko</p>
      </div>
    </div>
  </div>

  <div class="flex items-center space-x-4">
    <div>
      <h2 class="text-lg font-semibold"><?php echo $_SESSION['username']; ?></h2>
      <p class="text-sm opacity-90 capitalize"><?php echo $_SESSION['level']; ?></p>
    </div>
  </div>
</header>

<div class="max-w-4xl mx-auto bg-white p-6 shadow-lg rounded-lg mt-5">
    <h2 class="text-2xl font-semibold mb-4 text-gray-700">Daftar Penjualan</h2>
    <div class="flex items-center mb-4 space-x-2">
      <div class="relative flex-grow">
        <input type="text" placeholder="Cari Penjualan..." id="searchInput" 
          class="w-full p-3 border rounded-md text-black focus:outline-none focus:ring focus:ring-blue-400" 
          oninput="searchPenjualan(this.value)"/>
      </div>
    </div>
    <table class="w-full border-collapse border border-gray-200">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">ID Penjualan</th>
                <th class="border p-2">Tanggal</th>
                <th class="border p-2">Total Harga</th>
                <th class="border p-2">Aksi</th>
            </tr>
        </thead>
        <tbody id="PenjualanList">
            <?php
            $sql = "SELECT * FROM penjualan";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<tr class='border-b hover:bg-gray-100'>
                  <td class='border p-2 text-center'>{$row['idpenjualan']}</td>
                  <td class='border p-2 text-center'>{$row['tanggal_penjualan']}</td>
                  <td class='border p-2 text-center'>Rp " . number_format($row['total_harga'], 0, ',', '.') . "</td>
                  <td class='border p-2 text-center'>
                      <a href='detail_penjualan.php?id={$row['idpenjualan']}' class='bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-700'>Detail</a>";
                  if ($_SESSION['level'] != 'petugas') {
                  echo "<a href='delete_penjualan.php?id={$row['idpenjualan']}' class='bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-700'>Batalkan</a>";
                  }echo "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='text-center p-4'>Tidak ada data penjualan</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
function goBack() {
    window.history.back();
}

function searchPenjualan(query) {
  const xhr = new XMLHttpRequest();
  xhr.open('GET', 'caripenjualan.php?query=' + encodeURIComponent(query), true);
  xhr.onload = function () {
    if (xhr.status === 200) {
      document.getElementById('PenjualanList').innerHTML = xhr.responseText;
    }
  };
  xhr.send();
}
</script>
</body>
</html>
