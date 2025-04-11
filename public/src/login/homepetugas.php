<?php
session_start();

include 'config.php';

if (!isset($_SESSION['idpengguna'])) {
    header("Location: index.php");
    exit();
}

$query_produk = "SELECT 
                    (SELECT COUNT(*) FROM produk) AS jumlah_produk, 
                    (SELECT p.nama_produk 
                     FROM produk p
                     JOIN detail_penjualan d ON p.idproduk = d.idproduk
                     JOIN penjualan pj ON d.idpenjualan = pj.idpenjualan
                     WHERE DATE(pj.tanggal_penjualan) = CURDATE() 
                     GROUP BY p.idproduk 
                     ORDER BY SUM(d.jumlah_produk) DESC 
                     LIMIT 1) AS produk_laris, 
                    (SELECT SUM(d.jumlah_produk) 
                     FROM detail_penjualan d
                     JOIN penjualan pj ON d.idpenjualan = pj.idpenjualan
                     WHERE DATE(pj.tanggal_penjualan) = CURDATE()) AS produk_terjual";

$result_produk = $conn->query($query_produk);
$produk = $result_produk->fetch_assoc();

$produk_laris = $produk['produk_laris'] ? $produk['produk_laris'] : "Belum ada transaksi hari ini";
$produk_terjual = $produk['produk_terjual'] ? $produk['produk_terjual'] : "Belum ada transaksi hari ini";

$query_pendapatan = "SELECT IFNULL(SUM(total_bayar), 0) AS pendapatan_hari_ini FROM penjualan WHERE DATE(tanggal_penjualan) = CURDATE()";
$result_pendapatan = $conn->query($query_pendapatan);
$row_pendapatan = $result_pendapatan->fetch_assoc();
$pendapatan_hari_ini = $row_pendapatan['pendapatan_hari_ini'];

$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClockShop Petugas</title>
    <link href="https://fonts.googleapis.com/css2?family=Spirax&family=Open+Sans+Condensed:wght@300&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
    <link href="./css/output.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="flex flex-col h-screen">
    <header class="bg-indigo-500 text-white flex justify-between items-center p-4 w-full">
        <div class="flex items-center space-x-3">
            <img src="./image/logo/2.png" alt="Logo" class="w-24">
        </div>

        <button id="logout-btn" class="hidden md:flex items-center space-x-2 hover:text-gray-300">
            <img src="./image/icon/8.png" class="w-6" alt="Logout Icon">
        </button>

        <button id="menu-toggle" class="block md:hidden p-2 bg-white text-indigo-500 rounded-lg">
            ☰
        </button>
    </header>

    <div class="flex flex-1 flex-col md:flex-row">
        <aside id="sidebar" class="w-full md:w-64 bg-white p-4 shadow-lg hidden md:block">
            <ul class="mt-6 space-y-4">
                <li>
                    <a href="./produk/produk/dataproduk.php" class="flex items-center space-x-3 p-2 rounded-lg text-black hover:text-blue-600">
                        <img src="./image/icon/11.png" class="w-6 h-6" alt="Data Produk Icon">
                        <span>Data Produk</span>
                    </a>
                </li>
                <li>
                    <a href="./transaksi/transaksi.php" class="flex items-center space-x-3 p-2 rounded-lg text-black hover:text-blue-600">
                        <img src="./image/icon/4(1).png" class="w-6 h-6" alt="Transaksi Icon">
                        <span>Transaksi</span>
                    </a>
                </li>
                <li>
                    <a href="./penjualan/penjualan.php" class="flex items-center space-x-3 p-2 rounded-lg text-black hover:text-blue-600">
                        <img src="./image/icon/6(1).png" class="w-6 h-6" alt="Penjualan Icon">
                        <span>Penjualan</span>
                    </a>
                </li>
                <li>
                    <a href="./transaksi/pelanggan/datapelanggan.php" class="flex items-center space-x-3 p-2 rounded-lg text-black hover:text-blue-600">
                        <img src="./image/icon/7(1).png" class="w-6 h-6" alt="Tambah Pelanggan Icon">
                        <span>Tambah Pelanggan</span>
                    </a>
                </li>
                <li class="md:hidden">
                    <button id="mobile-logout-btn" class="flex items-center space-x-3 p-2 rounded-lg text-red-600 hover:text-red-800 w-full">
                        <img src="./image/icon/8.png" class="w-6" alt="Logout Icon">
                        <span>Logout</span>
                    </button>
                </li>
            </ul>
        </aside>
            <main class="flex flex-col items-center py-10 bg-gray-100 min-h-screen">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            
        <div class="bg-white shadow-xl rounded-2xl p-6 transition duration-300 hover:bg-gray-50 hover:shadow-2xl hover:scale-105 max-w-sm">
    <div class="flex items-center space-x-4">
      <div class="bg-blue-100 p-3 rounded-full">
      <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14a6 6 0 100-12 6 6 0 000 12zm0 2c-4 0-8 2-8 4v2h16v-2c0-2-4-4-8-4z"></path>
      </svg>
      </div>
      <div>
        <h2 class="text-xl font-semibold text-gray-700"><?php echo $_SESSION['username']; ?></h2>
        <p class="text-gray-500 text-sm capitalize"><?php echo $_SESSION['level']; ?></p>
      </div>
      </div>
      <div class="mt-4 text-gray-500">
        <p><strong>ID Pengguna:</strong> <?php echo $_SESSION['idpengguna']; ?></p>
        <p><strong>Nama Lengkap:</strong> <?php echo $_SESSION['nama']; ?></p>
      </div>
    </div>

    <div class="bg-white shadow-xl rounded-2xl p-6 transition duration-300 hover:bg-gray-50 hover:shadow-2xl hover:scale-105">
      <div class="flex items-center space-x-4">
        <div class="bg-pink-100 p-3 rounded-full">
          <svg class="w-8 h-8 text-pink-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h18v18H3V3zM3 9h18M9 3v18"></path>
          </svg>
        </div>
        <h2 class="text-xl font-semibold text-gray-700">Informasi Penjualan Hari Ini</h2>
      </div>
      <ul class="mt-4 space-y-2 text-gray-500">
        <li><strong>Produk Paling Laris:</strong> <?php echo $produk['produk_laris'] ?: "Belum ada transaksi hari ini"; ?></li>
        <li><strong>Produk Terjual:</strong> <?php echo $produk['produk_terjual'] ?: "Belum ada transaksi hari ini"; ?></li>
        <li><strong>Pendapatan Hari Ini:</strong> 
        <?php 
          echo $row_pendapatan['pendapatan_hari_ini'] 
            ? 'Rp. ' . number_format($row_pendapatan['pendapatan_hari_ini'], 0, ',', '.') 
            : 'Belum ada transaksi hari ini'; 
        ?>
      </li>
      </ul>
    </div>

      <div class="bg-white shadow-xl rounded-2xl p-6 transition duration-300 hover:bg-gray-50 hover:shadow-2xl hover:scale-105">
        <div class="flex items-center space-x-4">
          <div class="bg-red-100 p-3 rounded-full">
            <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c3.87 0 7-3.13 7-7H5c0 3.87 3.13 7 7 7zm0 4c-3.87 0-7 3.13-7 7h14c0-3.87-3.13-7-7-7z"></path>
            </svg>
          </div>
          <h2 class="text-xl font-semibold text-gray-700">Laporan Keuntungan</h2>
        </div>
        <p class="text-gray-500 mt-4">Pantau keuntungan bisnis Anda dengan mudah.</p>
        <a href="./laporan/laporan_keuangan.php" class="block mt-6 py-3 px-5 bg-red-500 text-white font-semibold text-center rounded-lg transition duration-300 transform hover:bg-red-700 hover:scale-110">
          Lihat Detail
        </a>
      </div>
      
      <div class="bg-white shadow-xl rounded-2xl p-6 transition duration-300 hover:bg-gray-50 hover:shadow-2xl hover:scale-105">
        <div class="flex items-center space-x-4">
          <div class="bg-green-100 p-3 rounded-full">
            <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
          </div>
          <h2 class="text-xl font-semibold text-gray-700">Laporan Penjualan</h2>
        </div>
        <p class="text-gray-500 mt-4">Analisis transaksi penjualan secara real-time.</p>
        <a href="./laporan/laporan_penjualan.php" class="block mt-6 py-3 px-5 bg-green-500 text-white font-semibold text-center rounded-lg transition duration-300 transform hover:bg-green-700 hover:scale-110">
          Lihat Detail
        </a>
      </div>
  
      <div class="bg-white shadow-xl rounded-2xl p-6 transition duration-300 hover:bg-gray-50 hover:shadow-2xl hover:scale-105">
        <div class="flex items-center space-x-4">
          <div class="bg-yellow-100 p-3 rounded-full">
            <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h18M9 21h6M12 17V3"></path>
            </svg>
          </div>
          <h2 class="text-xl font-semibold text-gray-700">Laporan Stok Barang</h2>
        </div>
        <p class="text-gray-500 mt-4">Kelola stok barang dengan lebih efisien.</p>
        <a href="./laporan/laporan_produk.php" class="block mt-6 py-3 px-5 bg-yellow-500 text-white font-semibold text-center rounded-lg transition duration-300 transform hover:bg-yellow-700 hover:scale-110">
          Lihat Detail
        </a>
      </div>

      <div class="bg-white shadow-xl rounded-2xl p-6 transition duration-300 hover:bg-gray-50 hover:shadow-2xl hover:scale-105">
        <div class="flex items-center space-x-4">
          <div class="bg-purple-100 p-3 rounded-full">
            <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"></path>
            </svg>
          </div>
          <h2 class="text-xl font-semibold text-gray-700">Laporan Data Produk</h2>
        </div>
        <p class="text-gray-500 mt-4">Lihat detail data produk yang tersedia di sistem.</p>
        <a href="./laporan/laporan_dataproduk.php" class="block mt-6 py-3 px-5 bg-purple-500 text-white font-semibold text-center rounded-lg transition duration-300 transform hover:bg-purple-700 hover:scale-110">
          Lihat Detail
        </a>
      </div>

        </div>
    </div>
</main>


        </div>
    </div>

    <script>
   document.getElementById('menu-toggle').addEventListener('click', function() {
        document.getElementById('sidebar').classList.toggle('hidden');
    });

    function logout() {
        if (confirm('Apakah Anda yakin ingin logout?')) {
            window.location.href = 'index.php';
        }
    }

    document.getElementById('logout-btn').addEventListener('click', logout);

    document.getElementById('mobile-logout-btn').addEventListener('click', logout);

    history.pushState(null, null, location.href);
    window.onpopstate = function () {
      history.pushState(null, null, location.href);
    };
    </script>
</body>
</html>
