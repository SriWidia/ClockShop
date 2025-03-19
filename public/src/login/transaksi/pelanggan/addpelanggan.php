<?php
session_start();
include 'config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $alamat = $_POST['alamat'];
    $no_telepon = $_POST['no_telepon'];

    if (!empty($nama_pelanggan) && !empty($alamat) && !empty($no_telepon)) {
        $stmt = $conn->prepare("INSERT INTO pelanggan (nama_pelanggan, alamat, no_telepon) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nama_pelanggan, $alamat, $no_telepon);

        if ($stmt->execute()) {
            $_SESSION['notif'] = ['type' => 'success', 'message' => 'Pelanggan berhasil ditambahkan!'];
        } else {
            $_SESSION['notif'] = ['type' => 'error', 'message' => 'Terjadi kesalahan: ' . $stmt->error];
        }

        $stmt->close();
    } else {
        $_SESSION['notif'] = ['type' => 'warning', 'message' => 'Semua kolom harus diisi!'];
    }

    $conn->close();
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Member</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white p-6 w-full max-w-md rounded-lg shadow-md">
        <div class="flex items-center gap-2 mb-6">
            <button onclick="goBack()" class="text-gray-600 hover:text-gray-900 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </button>
            <h2 class="text-2xl font-bold text-gray-800">Tambah Member</h2>
        </div>

        <?php if (isset($_SESSION['notif'])): ?>
            <div class="p-4 rounded-md mb-4 
                <?php echo $_SESSION['notif']['type'] === 'success' ? 'bg-green-100 text-green-700' : 
                       ($_SESSION['notif']['type'] === 'error' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700'); ?>">
                <?php echo $_SESSION['notif']['message']; ?>
            </div>
            <?php unset($_SESSION['notif']); ?>
        <?php endif; ?>

        <form action="" method="post" class="space-y-4">
            <div>
                <label class="block text-sm font-semibold">Nama Member</label>
                <input type="text" name="nama_pelanggan" class="w-full p-2 border rounded-md text-black" required/>
            </div>
            <div>
                <label class="block text-sm font-semibold">Alamat</label>
                <input type="text" name="alamat" class="w-full p-2 border rounded-md text-black" required/>
            </div>
            <div>
                <label class="block text-sm font-semibold">No Handphone</label>
                <input type="text" name="no_telepon" class="w-full p-2 border rounded-md text-black" required/>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">
                Tambah
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
