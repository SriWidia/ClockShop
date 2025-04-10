<?php
$conn = new mysqli('localhost', 'root', '', 'kasir_ukk_widia');

if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM pelanggan WHERE idpelanggan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Pelanggan tidak ditemukan.";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $alamat = $_POST['alamat'];
    $no_telepon = $_POST['no_telepon'];

    $update_sql = "UPDATE pelanggan SET nama_pelanggan = ?, alamat = ?, no_telepon = ? WHERE idpelanggan = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sssi", $nama_pelanggan, $alamat, $no_telepon, $id);

    if ($update_stmt->execute()) {
        header("Location: datapelanggan.php?status=updated");
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
    <title>Edit Pelanggan</title>
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
        <h2 class="text-2xl font-bold text-gray-800">Edit Member</h2>
    </div>
        
        <form action="editpelanggan.php?id=<?php echo $row['idpelanggan']; ?>" method="POST" class="space-y-4">
            <div>
                <label for="nama_pelanggan" class="block text-sm font-semibold">Nama Member </label>
                <input type="text" name="nama_pelanggan" id="nama_pelanggan" value="<?php echo htmlspecialchars($row['nama_pelanggan']); ?>" class="w-full p-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-400" />
            </div>
            <div>
                <label for="alamat" class="block text-sm font-semibold">Alamat</label>
                <input type="text" name="alamat" id="alamat" value="<?php echo htmlspecialchars($row['alamat']); ?>" class="w-full p-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-400" />
            </div>
            <div>
                <label for="no_telepon" class="block text-sm font-semibold">No Telepon</label>
                <input type="text" name="no_telepon" id="no_telepon" value="<?php echo htmlspecialchars($row['no_telepon']); ?>" class="w-full p-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-400" />
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
