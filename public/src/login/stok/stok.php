<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    body { font-family: 'Poppins', sans-serif; }
  </style>
</head>
<body class="bg-gray-100">
  
  <header class="flex items-center justify-between p-4 bg-blue-500 text-white shadow-md">
    <div class="flex items-center space-x-4">
      <i class="fas fa-arrow-left text-2xl cursor-pointer hover:opacity-80" onclick="goBack()"></i>
      <img src="./image/logo-putih.png" alt="Logo" class="w-12 h-12 rounded-full shadow-md">
      <div>
        <p class="font-semibold text-xl">SmartShop</p>
        <p class="text-sm hidden sm:block opacity-90">Aplikasi Pengelolaan Toko</p>
      </div>
    </div>
  </header>
  
  <main class="max-w-6xl mx-auto mt-6 p-6 bg-white rounded-lg shadow-lg">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4 border-b pb-2">Daftar Stok Produk</h2>
    <div id="UserList" class="mt-4">
      <?php include 'tampilkanstok.php'; ?>
    </div>
  </main>
  
  <script>
    function goBack() {
      window.history.back();
    }
  </script>
  
</body>
</html>
