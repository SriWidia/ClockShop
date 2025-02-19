<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Produk</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>

<header class="flex items-center justify-between p-4 bg-yellow-500 text-white">
  <div class="flex items-center space-x-3">
    <div class="p-2 rounded-full">
      <img src="./image/logo-putih.png" alt="Logo" class="w-10 h-10">
    </div>
    <div>
      <p class="font-bold">Sri Widia</p>
      <p class="text-sm">Admin</p>
    </div>
  </div>
  
  <div class="flex items-center">
    <input type="text" placeholder="Cari Produk..." id="searchInput" 
      class="w-96 p-2 border rounded-l-md text-black focus:outline-none focus:ring focus:ring-blue-400" 
      oninput="searchProduk(this.value)"
    />
    <button class="bg-white border rounded-r-md p-2">🔍</button>
  </div>

  <button class="bg-yellow-700 hover:bg-yellow-600 p-2 rounded text-white">
    Logout
  </button>
</header>

<main class="p-6 flex space-x-6">
  <div class="bg-gray-200 p-6 w-1/4 rounded-lg shadow-md">
    <h2 class="font-bold text-lg mb-4">Tambah Produk</h2>
    
    <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
      <div class="bg-green-100 text-green-700 p-4 rounded-md mb-4">
        Produk berhasil ditambahkan!
      </div>
    <?php endif; ?>

    <form action="add.php" method="post" class="space-y-4">
      <div>
        <label class="block text-sm font-semibold">Nama Produk</label>
        <input type="text" name="nama_produk" class="w-full p-2 border rounded-md text-black"/>
      </div>
      <div>
        <label class="block text-sm font-semibold">Harga Jual</label>
        <input type="text" name="harga_jual" class="w-full p-2 border rounded-md text-black"/>
      </div>
      <div>
        <label class="block text-sm font-semibold">Harga Beli</label>
        <input type="text" name="harga_beli" class="w-full p-2 border rounded-md text-black"/>
      </div>
      <div>
        <label class="block text-sm font-semibold">Stok</label>
        <input type="text" name="stok" class="w-full p-2 border rounded-md text-black"/>
      </div>
      <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">
        Tambah
      </button>
    </form>
  </div>

  <div class="bg-gray-300 flex-1 p-6 rounded-lg shadow-md">
    <h2 class="text-lg">Daftar Produk</h2>
    <div id="produkList">
      <?php include 'tampilkan.php'; ?>
    </div>
  </div>
</main>

<script>
function searchProduk(query) {
  const xhr = new XMLHttpRequest();
  xhr.open('GET', 'cari.php?query=' + encodeURIComponent(query), true);
  xhr.onload = function () {
    if (xhr.status === 200) {
      console.log(xhr.responseText);
      document.getElementById('produkList').innerHTML = xhr.responseText;
    }
  };
  xhr.send();
}
</script>

</body>
</html>
