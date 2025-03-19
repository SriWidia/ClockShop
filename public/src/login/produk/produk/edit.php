<?php
$conn = new mysqli('localhost', 'root', '', 'kasir_ukk_widia');

if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM produk WHERE idproduk = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Produk tidak ditemukan.";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_produk = $_POST['nama_produk'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];

    $update_sql = "UPDATE produk SET nama_produk = ?, harga_beli = ?, harga_jual = ? WHERE idproduk = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sddi", $nama_produk, $harga_beli, $harga_jual, $id);

    if ($update_stmt->execute()) {
        header("Location: dataproduk.php?status=updated");
        exit;
    } else {
        echo "Gagal memperbarui data.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md mt-10">
        <div class="flex items-center gap-2 mb-6">
            <button onclick="goBack()" class="text-gray-600 hover:text-gray-900 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </button>
            <h2 class="text-2xl font-bold text-gray-800">Edit Produk</h2>
        </div>
        
        <form action="edit.php?id=<?php echo $row['idproduk']; ?>" method="POST" class="space-y-4">
            <div>
                <label for="nama_produk" class="block text-sm font-semibold">Nama Produk</label>
                <input type="text" name="nama_produk" id="nama_produk" value="<?php echo htmlspecialchars($row['nama_produk']); ?>" class="w-full p-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-400" />
            </div>
            <div>
                <label for="harga_beli" class="block text-sm font-semibold">Harga Beli</label>
                <input type="number" step="0.01" name="harga_beli" id="harga_beli" value="<?php echo htmlspecialchars($row['harga_beli']); ?>" class="w-full p-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-400" />
            </div>
            <div>
                <label for="harga_jual" class="block text-sm font-semibold">Harga Jual</label>
                <input type="number" step="0.01" name="harga_jual" id="harga_jual" value="<?php echo htmlspecialchars($row['harga_jual']); ?>" class="w-full p-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-400" />
            </div>
            <button type="submit" class="bg-blue-400 text-white py-2 rounded-md hover:bg-blue-500 w-full">Perbarui</button>
        </form>
    </div>
</body>
<script>
     function goBack() {
  window.history.back();
}
</script>
</html>
