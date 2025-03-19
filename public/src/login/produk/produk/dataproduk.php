<?php
session_start();

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
    <title>Data Produk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
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
<div class="container mx-auto mt-6 px-6 flex justify-between">
    <h2 class="text-2xl font-semibold text-gray-700">Daftar Produk</h2>
    <div class="space-x-4">
        <a href="addproduk.php" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md shadow-md transition">Tambah Produk</a>
        <a href="./stok/datastok.php" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-md shadow-md transition">Tambah Stok</a>
    </div>
</div>
<div class="container mx-auto mt-6 p-6 bg-white rounded-lg shadow-lg">
    <input type="text" id="searchInput" placeholder="Cari Produk..." class="w-full p-3 mb-4 border rounded-md text-gray-700 focus:ring focus:ring-blue-400">
    
    <?php
    include 'config.php';
    $sql = "SELECT * FROM produk";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<div class='overflow-x-auto'>";
        echo "<table class='w-full bg-white rounded-md shadow-md border-collapse'>";
        echo "<thead class='bg-gradient-to-r from-blue-500 to-indigo-500 text-white'>";
        echo "<tr><th class='p-3 text-left'>ID</th><th class='p-3 text-left'>Nama Produk</th><th class='p-3 text-left'>Harga Beli</th><th class='p-3 text-left'>Harga Jual</th><th class='p-3 text-left'>Stok</th><th class='p-3 text-left'>Action</th></tr>";
        echo "</thead><tbody id='productTable'>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr class='border-t hover:bg-gray-100 transition'>";
            echo "<td class='p-3'>" . $row['idproduk'] . "</td>";
            echo "<td class='p-3'>" . $row['nama_produk'] . "</td>";
            echo "<td class='p-3'>Rp. " . number_format($row['harga_beli'], 0, ',', '.') . "</td>";
            echo "<td class='p-3'>Rp. " . number_format($row['harga_jual'], 0, ',', '.') . "</td>";
            echo "<td class='p-3'>" . $row['stok'] . "</td>";
            echo "<td class='p-3 flex space-x-2'>";
            echo "<a href='edit.php?id=" . $row['idproduk'] . "' class='bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600'>Edit</a>";
            echo "<a href='delete.php?id=" . $row['idproduk'] . "' class='bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600' onclick='return confirm(\"Apakah Anda yakin ingin menghapus Produk ini?\")'>Hapus</a>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</tbody></table></div>";
    } else {
        echo "<p class='text-red-500'>Tidak ada produk yang terdaftar.</p>";
    }

    $conn->close();
    ?>
</div>

<script>
    function goBack() {
        window.history.back();
    }

    document.getElementById('searchInput').addEventListener('input', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#productTable tr');
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>
</body>
</html>
