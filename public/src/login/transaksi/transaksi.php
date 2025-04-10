<?php
session_start();

if (!isset($_SESSION['idpengguna'])) {
    header("Location: index.php");
    exit();
}
?>
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
<body class="bg-gray-200">
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
  <div class="flex space-x-3 mt-3">
    <button id="btnPelanggan" class="bg-blue-500 text-white px-4 py-2 rounded">Buat Member Pelanggan</button>
  </div>
  
  <div class="container mx-auto grid grid-cols-3 gap-4">
    <div class="bg-white p-6 shadow-lg rounded-lg border border-gray-200">
        <h2 class="font-semibold text-xl text-gray-700 mb-5">Input Transaksi</h2>
        <input type="date" id="tanggalTransaksi" name="tanggalTransaksi"
       class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
       hidden>
       <input type="hidden" name="idkasir" id="idkasir" value="<?php echo $_SESSION['idpengguna']; ?>">
        <form action="" method="POST" class="space-y-4">
            <div>
                <label for="idpenjualan" class="block text-gray-600 font-medium">ID Penjualan:</label>
                <input type="text" name="idpenjualan" id="idpenjualan"
                       class="w-full p-3 border border-gray-300 rounded-lg shadow-sm bg-gray-100" readonly oninput="updateRingkasan()">
            </div>

            <div>
            <label class="block text-gray-600 font-medium">ID Pelanggan:</label>
            <input type="text" id="idpelanggan" name="idpelanggan"
                class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                placeholder="Cari ID Pelanggan..." onkeyup="cariPelanggan()" oninput="updateRingkasan()">

            <div class="relative">
                <ul id="listPelanggan" class="absolute w-full bg-white border border-gray-300 rounded-lg shadow-lg max-h-40 overflow-auto hidden">
                    <?php
                    include 'config.php';
                    $query = "SELECT idpelanggan, nama_pelanggan FROM pelanggan";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<li class='p-2 hover:bg-blue-100 cursor-pointer' 
                                onclick='pilihPelanggan(\"{$row['idpelanggan']}\", \"{$row['nama_pelanggan']}\")'>
                                {$row['idpelanggan']} - {$row['nama_pelanggan']}
                            </li>";
                    }
                    ?>
                </ul>
            </div>
        </div>

<div>
    <label class="block text-gray-600 font-medium">Nama Pelanggan</label>
    <input type="text" id="nama_pelanggan"
           class="w-full p-3 border border-gray-300 rounded-lg bg-gray-100 shadow-sm focus:outline-none" readonly>
</div>
            <div>
                <label class="block text-gray-600 font-medium">Pilih Produk</label>
                <input type="text" id="searchProduk" 
                      class="w-full p-3 border border-gray-300 rounded-lg shadow-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-400" 
                      placeholder="Cari Produk..." onkeyup="cariProduk()">
                
                <div class="relative">
                    <ul id="listProduk" class="absolute w-full bg-white border border-gray-300 rounded-lg shadow-lg max-h-40 overflow-auto hidden">
                        <?php
                        include 'config.php';
                        $query = "SELECT idproduk, nama_produk, harga_jual FROM produk";
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<li class='p-2 hover:bg-blue-100 cursor-pointer' 
                                    onclick='pilihProduk(\"{$row['idproduk']}\", \"{$row['nama_produk']}\", \"{$row['harga_jual']}\")'>
                                    {$row['idproduk']} - {$row['nama_produk']}
                                  </li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>

            <div>
                <label class="block text-gray-600 font-medium">ID Produk</label>
                <input type="text" id="idproduk" 
                      class="w-full p-3 border border-gray-300 rounded-lg bg-gray-100 shadow-sm focus:outline-none" readonly>
            </div>

            <div>
                <label class="block text-gray-600 font-medium">Nama Produk</label>
                <input type="text" id="nama_produk" 
                      class="w-full p-3 border border-gray-300 rounded-lg bg-gray-100 shadow-sm focus:outline-none" readonly>
            </div>
            <div>
    <label class="block text-gray-600 font-medium">Harga Produk</label>
    <input type="text" id="harga_jual" 
           class="w-full p-3 border border-gray-300 rounded-lg bg-gray-100 shadow-sm focus:outline-none" 
           readonly oninput="formatRupiah(this)">
</div>
            <div>
                <label class="block text-gray-600 font-medium">Jumlah Produk</label>
                <input type="number" id="jumlah_produk" min="1" 
                       class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            
            <div class="flex justify-end">
                <button id="btnTambahProduk" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg font-semibold shadow-md transition duration-200">
                    Tambah Produk
                </button>
            </div>
        </form>
    </div>
 
<div class="col-span-2 flex flex-col gap-4">
<div class="bg-white p-6 rounded-xl shadow-lg h-[16.5vh]">
    <h2 class="font-bold text-lg mb-4">Detail Transaksi</h2>
    <form action="" method="POST">
    <p class="text-lg font-semibold">ID Penjualan: 
        <span id="idPenjualanText" class="font-bold text-red-500">-</span>
    </p>
    <input type="hidden" name="id_penjualan" id="idpenjualan">
        <div class="overflow-x-auto">
            <table class="w-full text-left" id="detailTransaksi">
                <thead>
                    <tr>
                        <th class="border-b p-2">ID Produk</th>
                        <th class="border-b p-2" id="jumlah">Total</th>
                        <th class="border-b p-2" id="subtotal">Subtotal</th>
                        <th class="border-b p-2" id="subtotal">Tanggal</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <div class="mt-5 flex justify-end">
            <button type="button" id="btnSelesai" 
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-5 py-3 rounded-lg shadow">
                Selesai
            </button>
        </div>
    </form>
</div>
<div class="bg-white p-6 rounded-xl shadow-lg h-[16.5vh]"></div>
<form id="formTransaksi" class="col-span-2">
    <div class="bg-white p-6 shadow-lg rounded-xl mt-6 w-full border border-gray-200">
        <h2 class="font-bold text-xl mb-4 text-gray-700">Ringkasan Transaksi</h2>
        <div class="mt-5 p-6 bg-gray-50 rounded-xl shadow-md">
            <p class="text-lg font-semibold text-gray-600">ID Penjualan: 
                <span id="ringkasanIdPenjualan" class="font-bold text-red-500">-</span>
            </p>
            <p class="text-lg font-semibold text-gray-600">ID Pelanggan: 
                <span id="ringkasanIdPelanggan" class="font-bold text-red-500">-</span>
            </p>
            <p class="text-lg font-semibold text-gray-600">Tanggal Transaksi: 
                <span id="ringkasanTanggal" class="font-bold text-red-500">-</span>
            </p>
            <p class="text-lg font-semibold text-gray-600 mt-3">Total Barang: 
                <span id="totalBarang" class="font-bold text-blue-500">0</span>
            </p>
            <p class="text-lg font-semibold text-gray-600">Total Harga: 
                <span id="totalHarga" class="font-bold text-blue-500">Rp. 0</span>
            </p>
            <p class="text-lg font-semibold text-gray-600">Potongan Harga: 
                <input type="text" id="potonganHarga" class="border p-3 rounded-md w-32 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                    value="Rp 0" oninput="formatCurrency(this)">
            </p>
            <p class="text-lg font-semibold text-gray-600">Total Bayar: 
                <span id="totalSetelahDiskon" class="font-bold text-green-500">0</span>
            </p>

            <div class="mt-4">
                <label for="cash" class="block text-gray-700 font-semibold mb-1">Cash</label>
                <input type="text" id="cash" name="cash" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                    value="Rp 0" oninput="formatCurrency(this)" required>
            </div>
            <div class="mt-4">
                <label for="kembali" class="block text-gray-700 font-semibold mb-1">Kembali</label>
                <input type="text" id="kembali" name="kembali" class="w-full p-3 border border-gray-300 rounded-lg bg-gray-100 font-bold text-green-600" readonly>
            </div>
            <div class="mt-5 flex justify-end">
                <button type="submit" id="btnselesaikan" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition-all duration-300 ease-in-out transform hover:scale-105">
                    Selesaikan Transaksi
                </button>
            </div>
        </div>
    </div>
</form>

</div>

</body>
<script>
    document.getElementById("btnPelanggan").addEventListener("click", function() {
    window.location.href = "./pelanggan/datapelanggan.php";
 });

function goBack() {
    window.history.back();
}

//from Transaksi
document.addEventListener("DOMContentLoaded", function () {
    generateIdPenjualan();
    document.getElementById("idpelanggan").addEventListener("change", hitungTotal);
});

function generateIdPenjualan() {
    let today = new Date();
    let year = today.getFullYear();
    let month = String(today.getMonth() + 1).padStart(2, '0');
    let day = String(today.getDate()).padStart(2, '0'); 
    let randomNum = Math.floor(1000 + Math.random() * 9000);
    let idPenjualan = `KSS-${year}${month}${day}-${randomNum}`;
    
    document.getElementById("idpenjualan").value = idPenjualan;
    document.getElementById("idPenjualanText").innerText = idPenjualan;
    document.getElementById("inputIdPenjualan").value = idPenjualan;
}


function cariPelanggan() {
    let input = document.getElementById("idpelanggan").value.toLowerCase();
    let list = document.getElementById("listPelanggan");
    let items = list.getElementsByTagName("li");

        if (input === "") {
            list.classList.add("hidden");
            return;
        }

            list.classList.remove("hidden");

    let hasResult = false;
        for (let i = 0; i < items.length; i++) {
    let text = items[i].innerText.toLowerCase();
        if (text.includes(input)) {
            items[i].style.display = "block";
            hasResult = true;
        } else {
            items[i].style.display = "none";
        }
        }

        if (!hasResult) {
            list.classList.add("hidden");
        }
        }

function pilihPelanggan(id, nama) {
    document.getElementById("idpelanggan").value = id;
    document.getElementById("nama_pelanggan").value = nama;
    document.getElementById("idRingkasanPelanggan").innerText = id; 
    document.getElementById("namaRingkasanPelanggan").innerText = nama;

    let list = document.getElementById("listPelanggan");
    list.classList.add("hidden");

    setTimeout(() => {
        list.style.display = "none";
    }, 300);
}

function pilihPelanggan(id, nama) {
    document.getElementById('idpelanggan').value = id;
    document.getElementById('nama_pelanggan').value = nama;
    document.querySelector('input[name="id_pelanggan"]').value = id;
    document.getElementById('listPelanggan').classList.add('hidden');
}

    document.getElementById('idpelanggan').addEventListener('input', function() {
    document.getElementById('idpelanggan_detail').value = this.value;
    });

function cariProduk() {
    let input = document.getElementById("searchProduk").value.toLowerCase();
    let list = document.getElementById("listProduk");
    let items = list.getElementsByTagName("li");

    if (input === "") {
        list.classList.add("hidden");
        return;
    }

    list.classList.remove("hidden");

    let hasResult = false;
    for (let i = 0; i < items.length; i++) {
        let text = items[i].innerText.toLowerCase();
        if (text.includes(input)) {
            items[i].style.display = "block";
            hasResult = true;
        } else {
            items[i].style.display = "none";
        }
    }

    if (!hasResult) {
        list.classList.add("hidden");
    }
}

function pilihProduk(id, nama, harga) {
    document.getElementById("idproduk").value = id;
    document.getElementById("nama_produk").value = nama;
    document.getElementById("harga_jual").value = harga;
    document.getElementById("listProduk").classList.add("hidden");
}
function formatRupiah(input) {
        let value = input.value.replace(/[^0-9]/g, ''); 
        let formattedValue = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); 
        input.value = 'Rp ' + formattedValue; 
    }
//tambah produk
document.getElementById("btnTambahProduk").addEventListener("click", function(event) {
    event.preventDefault(); 

    let idpenjualan = document.getElementById("idpenjualan").value;
    let idproduk = document.getElementById("idproduk").value;
    let harga = document.getElementById("harga_jual").value;
    let jumlah_produk = document.getElementById("jumlah_produk").value;
    
    if (!idproduk || !jumlah_produk) {
        alert("Harap pilih produk dan masukkan jumlah!");
        return;
    }

    let subtotal = jumlah_produk * harga;

    let today = new Date().toISOString().split('T')[0];

    let formData = new FormData();
    formData.append("idpenjualan", idpenjualan);
    formData.append("idproduk", idproduk);
    formData.append("jumlah_produk", jumlah_produk);
    formData.append("subtotal", subtotal);
    formData.append("tanggal_penjualan", today); 

    fetch("simpandetailpenjualan.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if (data === "success") {
            alert("Produk berhasil ditambahkan!");
            tambahKeTabel(idproduk, jumlah_produk, subtotal, today);

            document.getElementById("idproduk").value = "";      
            document.getElementById("nama_produk").value = "";  
            document.getElementById("harga_jual").value = "";   
            document.getElementById("jumlah_produk").value = ""; 
        } else {
            alert("Gagal menambahkan produk!");
        }
    })
    .catch(error => console.error("Error:", error));
});


function tambahKeTabel(idproduk, jumlah, subtotal, tanggal) {
    let table = document.getElementById("detailTransaksi").getElementsByTagName('tbody')[0];
    let newRow = table.insertRow();
    
    newRow.innerHTML = `
        <td class="border-b p-2">${idproduk}</td>
        <td class="border-b p-2">${jumlah}</td>
        <td class="border-b p-2">Rp ${subtotal}</td>
        <td class="border-b p-2">${tanggal}</td>
    `;
}

//tampilkan ringkasan
function updateRingkasan() { 
    document.getElementById("ringkasanIdPenjualan").textContent = document.getElementById("idpenjualan").value || "-";
    document.getElementById("ringkasanIdPelanggan").textContent = document.getElementById("idpelanggan").value || "-";
    document.getElementById("ringkasanTanggal").textContent = document.getElementById("tanggalTransaksi").value || "-";
}

document.addEventListener("DOMContentLoaded", function() {
    let today = new Date().toISOString().split('T')[0]; 
    document.getElementById("tanggalTransaksi").value = today;
    document.getElementById("ringkasanTanggal").textContent = today;
});

document.getElementById('btnSelesai').addEventListener('click', function () {
    let totalBarang = 0;
    let totalHarga = 0;

    const tbody = document.querySelector("#detailTransaksi tbody");
    const rows = tbody.querySelectorAll("tr");

    rows.forEach(row => {
        let jumlah = parseInt(row.children[1].textContent) || 0;
        let subtotal = parseInt(row.children[2].textContent.replace(/\D/g, '')) || 0;
        
        console.log(`Jumlah: ${jumlah}, Subtotal: ${subtotal}`); 
        
        totalBarang += jumlah;
        totalHarga += subtotal;
    });

    console.log(`Total Barang: ${totalBarang}, Total Harga: ${totalHarga}`); 

    document.getElementById('totalBarang').textContent = totalBarang;
    document.getElementById('totalHarga').textContent = `Rp. ${totalHarga.toLocaleString('id-ID')}`;

    hitungTotal();
});

function formatCurrency(input) {
    let value = input.value.replace(/[^0-9]/g, ''); 
    let formattedValue = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); 
    input.value = 'Rp ' + formattedValue; 
}

document.getElementById('potonganHarga').addEventListener('input', function() {
    formatCurrency(this); 
    hitungTotal();
});

document.getElementById('cash').addEventListener('input', function() {
    formatCurrency(this); 
    hitungKembalian();
});

function hitungTotal() {
    let totalHarga = parseInt(document.getElementById("totalHarga").textContent.replace(/\D/g, '')) || 0;
    let idPelanggan = document.getElementById("idpelanggan").value;
    let potonganInput = parseInt(document.getElementById("potonganHarga").value.replace(/[^0-9]/g, '')) || 0;
    
    let potongan = 0;

    if (idPelanggan !== "0") {
        potongan = totalHarga * 0.1;
    }

    potongan = Math.max(potongan, potonganInput);

    let totalSetelahDiskon = totalHarga - potongan;
    if (totalSetelahDiskon < 0) totalSetelahDiskon = 0;

    document.getElementById("potonganHarga").value = `Rp ${potongan.toLocaleString('id-ID')}`;
    document.getElementById("totalSetelahDiskon").textContent = `Rp. ${totalSetelahDiskon.toLocaleString('id-ID')}`;

    hitungKembalian();
}

function hitungKembalian() {
    let totalSetelahDiskon = parseInt(document.getElementById('totalSetelahDiskon').textContent.replace(/\D/g, '')) || 0;
    let cash = parseInt(document.getElementById('cash').value.replace(/[^0-9]/g, '')) || 0;
    let kembali = cash - totalSetelahDiskon;

    console.log("Total Setelah Diskon:", totalSetelahDiskon);
    console.log("Cash Diterima:", cash);
    console.log("Kembalian:", kembali);

    let kembaliElement = document.getElementById('kembali');
    if (kembaliElement) {
        kembaliElement.value = kembali >= 0 ? `Rp. ${kembali.toLocaleString('id-ID')}` : "Rp. 0";
    }
}


document.getElementById("formTransaksi").addEventListener("submit", function (event) {
    event.preventDefault();

    let idPenjualan = document.getElementById("ringkasanIdPenjualan").textContent;
    let idPelanggan = document.getElementById("ringkasanIdPelanggan").textContent;
    let tanggalPenjualan = document.getElementById("ringkasanTanggal").textContent;
    let totalHarga = document.getElementById("totalHarga").textContent.replace(/[^0-9]/g, "");
    let potonganHarga = document.getElementById("potonganHarga").value.replace(/[^0-9]/g, "");
    let totalSetelahDiskon = document.getElementById("totalSetelahDiskon").textContent.replace(/[^0-9]/g, "");
    let totalUang = document.getElementById("cash").value.replace(/[^0-9]/g, "");
    let totalKembali = document.getElementById("kembali").value.replace(/[^0-9]/g, "");

    let formData = new FormData();
    formData.append("idpenjualan", idPenjualan);
    formData.append("idpelanggan", idPelanggan);
    formData.append("tanggal_penjualan", tanggalPenjualan);
    formData.append("total_harga", totalHarga);
    formData.append("potongan_harga", potonganHarga);
    formData.append("total_bayar", totalSetelahDiskon);
    formData.append("total_uang", totalUang);
    formData.append("total_kembali", totalKembali);

    fetch("simpan_transaksi.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        alert(result); 
        window.location.href = "detail_penjualan.php?idpenjualan=" + idPenjualan;
    })
    .catch(error => console.error("Error:", error));
});


</script>
</html>