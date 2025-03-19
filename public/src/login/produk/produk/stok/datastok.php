<?php
session_start();

if (!isset($_SESSION['idpengguna'])) {
    header("Location: index.php");
    exit();
}
?><!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Aplikasi Pengelolaan Kasir Toko - ClockShop">
  <title>Data Stok</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<header class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg">
  <div class="flex items-center space-x-3">
    <button onclick="goBack()" class="p-2 rounded-full bg-white bg-opacity-20 hover:bg-opacity-40 transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
    </button>
    <div>
      <p class="font-bold text-xl">ClockShop</p>
      <p class="text-sm hidden sm:block opacity-90">Aplikasi Pengelolaan Kasir Toko</p>
    </div>
  </div>
  <div class="flex items-center space-x-4">
    <div>
      <h2 class="text-lg font-semibold"><?php echo $_SESSION['username']; ?></h2>
      <p class="text-sm opacity-90 capitalize"><?php echo $_SESSION['level']; ?></p>
    </div>
  </div>
</header>

<main class="p-6 flex flex-col space-y-6">

<div class="container mx-auto mt-6 px-6 flex justify-between">
    <h2 class="text-2xl font-semibold text-gray-700">Daftar Input Stok</h2>
    <div class="space-x-4">
        <a href="addinputstok.php" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md shadow-md transition">Tambah Stok</a>
    </div>
</div>

  <div class="bg-white p-6 rounded-lg shadow-lg">
    <div class="flex items-center mb-4 space-x-2">
      <div class="relative flex-grow">
        <input type="text" placeholder="Cari Produk..." id="searchInput" 
          class="w-full p-3 border rounded-lg text-gray-700 focus:outline-none focus:ring focus:ring-indigo-400" 
          oninput="searchProduk(this.value)"/>
      </div>
    </div>

    <div id="inputStok">
      <?php
      include 'config.php';

      $sql = "SELECT * FROM stok";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          echo "<table class='w-full bg-white rounded-lg shadow-md border-collapse overflow-hidden'>";
          echo "<thead><tr class='bg-blue-500 text-white'>";
          echo "<th class='p-3'>ID</th>";
          echo "<th class='p-3'>ID Produk</th>";
          echo "<th class='p-3'>Tanggal</th>";
          echo "<th class='p-3'>Jumlah Stok Masuk</th>";
          echo "<th class='p-3'>Keterangan</th>";
          echo "<th class='p-3'>Action</th>";
          echo "</tr></thead><tbody class='text-gray-700'>";

          while ($row = $result->fetch_assoc()) {
              echo "<tr class='border-b hover:bg-gray-100'>";
              echo "<td class='p-3 text-center'>" . $row['idstok'] . "</td>";
              echo "<td class='p-3 text-center'>" . $row['idproduk'] . "</td>";
              echo "<td class='p-3 text-center'>" . $row['tanggal_input_stok'] . "</td>";
              echo "<td class='p-3 text-center'>" . $row['input_stok'] . "</td>";
              echo "<td class='p-3 text-center'>" . $row['keterangan'] . "</td>";
              echo "<td class='p-3 text-center'>
                  <a href='delete.php?id=" . $row['idstok'] . "' class='bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 transition' onclick='return confirm(\"Apakah Anda yakin ingin menghapus Produk ini?\")'>
                  Hapus
                  </a>
              </td>"; 
              echo "</tr>";
          }

          echo "</tbody></table>";
      } else {
          echo "<p class='text-center text-gray-600'>Tidak ada produk yang terdaftar.</p>";
      }

      $conn->close();
      ?>
    </div>
  </div>

</main>

<script>
 function goBack() {
  window.history.back();
}
function searchProduk(query) {
  const xhr = new XMLHttpRequest();
  xhr.open('GET', 'cari.php?query=' + encodeURIComponent(query), true);
  xhr.onload = function () {
    if (xhr.status === 200) {
      document.getElementById('inputStok').innerHTML = xhr.responseText;
    }
  };
  xhr.send();
}
</script>

</body>
</html>
