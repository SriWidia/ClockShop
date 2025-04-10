<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_produk = $_POST['nama_produk'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];

    if (!empty($nama_produk) && !empty($harga_beli) && !empty($harga_jual)) {
        $stmt = $conn->prepare("INSERT INTO produk (nama_produk, harga_beli, harga_jual) VALUES (?, ?, ?)");
        $stmt->bind_param("sii", $nama_produk, $harga_beli, $harga_jual);

        if ($stmt->execute()) {
            $status = "success";
        } else {
            $status = "error";
        }
        $stmt->close();
    } else {
        $status = "empty";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Produk</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen">
  <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">

    <div class="flex items-center gap-2 mb-6">
        <button onclick="goBack()" class="text-gray-600 hover:text-gray-900 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
        </button>
        <h2 class="text-2xl font-bold text-gray-800">Tambah Produk</h2>
    </div>
    
    <form action="" method="post" class="space-y-4">
      <div>
        <label class="block text-sm font-semibold">Nama Produk</label>
        <input type="text" name="nama_produk" required class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"/>
      </div>
      <div>
        <label class="block text-sm font-semibold">Harga Beli</label>
        <input type="number" name="harga_beli" required class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"/>
      </div>
      <div>
        <label class="block text-sm font-semibold">Harga Jual</label>
        <input type="number" name="harga_jual" required class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"/>
      </div>
      
      <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-md hover:bg-blue-700 transition">
        Simpan
      </button>
    </form>
  </div>
</body>
<script>
    function goBack() {
      window.history.back();
    }
    
    setTimeout(() => {
      let alertBox = document.getElementById("alert");
      if (alertBox) {
        alertBox.classList.add("hidden");
      }
    }, 3000);
  </script>
</html>
