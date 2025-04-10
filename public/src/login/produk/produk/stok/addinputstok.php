<?php
include 'config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idproduk = $_POST['idproduk'];
    $tanggal_input_stok = $_POST['tanggal_input_stok'];
    $input_stok = $_POST['input_stok'];
    $keterangan = $_POST['keterangan'];

    if (!empty($idproduk) && !empty($tanggal_input_stok) && !empty($input_stok) && !empty($keterangan)) {
        $stmt = $conn->prepare("INSERT INTO stok (idproduk, tanggal_input_stok, input_stok, keterangan) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $idproduk, $tanggal_input_stok, $input_stok, $keterangan);

        if ($stmt->execute()) {
            header("Location: datastok.php?status=success");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Semua kolom harus diisi!";
    }
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Stok</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen">
  <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
  <div class="flex items-center gap-2 mb-6">
        <button onclick="goBack()" class="text-gray-600 hover:text-gray-900 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
        </button>
        <h2 class="text-2xl font-bold text-gray-800">Tambah Stok</h2>
    </div>
    <form action="" method="post" class="space-y-4">
      <div>
        <label class="block text-sm font-semibold">ID Produk</label>
        <input type="text" name="idproduk" class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required/>
      </div>
      <div>
        <label class="block text-sm font-semibold">Pilih Tanggal</label>
        <input type="date" name="tanggal_input_stok" class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required/>
      </div>
      <div>
        <label class="block text-sm font-semibold">Stok</label>
        <input type="number" name="input_stok" class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required/>
      </div>
      <div>
        <label class="block text-sm font-semibold">Keterangan</label>
        <input type="text" name="keterangan" class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" required/>
      </div>
      <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-md hover:bg-blue-700 transition">
        Tambah Stok
      </button>
    </form>
  </div>
</body>
<script>
    function goBack() {
      window.history.back();
    }
  </script>
</html>
