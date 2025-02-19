<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Spirax&family=Open+Sans+Condensed:wght@300&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
  <link href="./css/output.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <title>Tampilan Transaksi</title>
</head>
<body class="bg-gray-200 p-5">
  <header class="flex items-center justify-between p-4 bg-yellow-500 text-white">
    <div class="flex items-center space-x-3">
  
      <i class="fas fa-arrow-left text-white text-2xl cursor-pointer" onclick="goBack()"></i>
  
      <div class="p-2 rounded-full">
        <img src="./image/logo-putih.png" alt="Logo" class="w-10 h-10">
      </div>
  
      <div>
        <p class="font-bold text-lg">SmartShop</p>
        <p class="text-sm hidden sm:block">Aplikasi Pengelolaan Toko</p>
      </div>
    </div>
  </header>

  <div class="flex space-x-3 mt-3">
    <button id="btnPelanggan" class="bg-yellow-500 text-white px-4 py-2 rounded">Pilih Pelanggan</button>
  </div>
  

  <div class="grid grid-cols-2 gap-5 mt-5">
    <div class="bg-gray-100 p-5 shadow-md rounded">
      <h2 class="font-bold text-lg mb-4">Input Transaksi</h2>
      <div class="space-y-3">
      <form id="formTransaksi">
        <label for="nama_pelanggan">Nama Pelanggan</label>
        <input type="text" id="nama_pelanggan" name="nama_pelanggan" class="border p-2 w-full" readonly>
      </form>
        <div>
            <label class="block mb-1">ID Produk</label>
            <input type="text" id="idproduk" class="w-full p-2 border rounded">
        </div>
        <div>
            <label class="block mb-1">Nama Produk</label>
            <input type="text" id="nama_produk" class="w-full p-2 border rounded" readonly>
        </div>
        <div>
            <label class="block mb-1">Harga Produk</label>
            <input type="text" id="harga_jual" class="w-full p-2 border rounded" readonly>
        </div>
        <div>
          <label class="block mb-1">Jumlah Produk</label>
          <input type="text" class="w-full p-2 border rounded">
        </div>
        <div>
          <label class="block mb-1">Tanggal Pembelian</label>
          <input type="date" class="w-full p-2 border rounded">
        </div>
        <div class="flex space-x-3 mt-3">
          <button class="bg-yellow-500 text-white px-4 py-2 rounded">Kolom Baru</button>
          <button class="bg-yellow-500 text-white px-4 py-2 rounded">Selesai</button>
        </div>
      </div>
    </div>
    <div class="bg-gray-100 p-5 shadow-md rounded">
      <h2 class="font-bold text-lg mb-4">Rincian Pembelian</h2>
      <div class="overflow-x-auto">
        <table class="w-full text-left">
          <thead>
            <tr>
              <th class="border-b p-2">Nama Barang</th>
              <th class="border-b p-2">Total</th>
              <th class="border-b p-2">Harga</th>
              <th class="border-b p-2">Tanggal</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="p-2">Samsung</td>
              <td class="p-2">1</td>
              <td class="p-2">Rp. 3.499.999</td>
              <td class="p-2">02-01-2025</td>
            </tr>
            <tr>
              <td class="p-2">Oppo</td>
              <td class="p-2">1</td>
              <td class="p-2">Rp. 3.499.999</td>
              <td class="p-2">02-01-2025</td>
            </tr>
            <tr>
              <td class="p-2">Vivo</td>
              <td class="p-2">1</td>
              <td class="p-2">Rp. 3.499.999</td>
              <td class="p-2">02-01-2025</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="bg-gray-100 p-5 shadow-md rounded mt-5">
    <h2 class="font-bold text-lg mb-4">Ringkasan Pembelian</h2>
    <div class="flex justify-between items-center">
      <div>
        <p>Total Barang: <span class="font-bold">3</span></p>
        <p>Total Harga: <span class="font-bold">Rp. 7.499.999</span></p>
      </div>
      <button class="bg-yellow-500 text-white px-5 py-3 rounded">Selesaikan Transaksi</button>
    </div>
  </div>
</body>
<script>
  document.getElementById("btnPelanggan").addEventListener("click", function() {
  window.location.href = "datapelanggan.php";
});
function goBack() {
  window.history.back();
} 

function pilihPelanggan(id, nama) {
    window.location.href = "transaksi.php?idpelanggan=" + id + "&nama_pelanggan=" + encodeURIComponent(nama);
}

</script>
</html>
