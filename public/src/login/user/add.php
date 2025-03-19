<?php
session_start();
include 'config.php'; 

if (!isset($_SESSION['idpengguna'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $level = $_POST['level'];

    if (!empty($username) && !empty($password) && !empty($level)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO pengguna (nama, username, password, level) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nama, $username, $hashed_password, $level);

        if ($stmt->execute()) {
            header("Location: datauser.php?status=success");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Semua kolom harus diisi!";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-200 p-5">
    <div class="container mx-auto px-6 py-10">
        <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-300 max-w-md mx-auto">
            <div class="flex items-center gap-2 mb-6">
                <button onclick="goBack()" class="text-gray-600 hover:text-gray-900 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                </button>
                <h2 class="text-2xl font-bold text-gray-800">Tambah Pengguna</h2>
            </div>

            <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
                <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-5 border border-green-300 shadow-sm flex items-center">
                    <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Pengguna berhasil ditambahkan!</span>
                </div>
            <?php endif; ?>

            <form action="" method="post" class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama</label>
                    <input type="text" name="nama" class="w-full p-3 border rounded-lg text-gray-900 shadow-sm focus:ring-2 focus:ring-blue-400" required />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Pengguna</label>
                    <input type="text" name="username" class="w-full p-3 border rounded-lg text-gray-900 shadow-sm focus:ring-2 focus:ring-blue-400" required />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Sandi</label>
                    <input type="password" name="password" class="w-full p-3 border rounded-lg text-gray-900 shadow-sm focus:ring-2 focus:ring-blue-400" required />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Level</label>
                    <select name="level" class="w-full p-3 border rounded-lg text-gray-900 shadow-sm focus:ring-2 focus:ring-blue-400" required>
                        <option value="admin">Admin</option>
                        <option value="petugas">Petugas</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-indigo-500 text-white py-3 rounded-xl shadow-lg">
                    Tambah Pengguna
                </button>
            </form>
        </div>
    </div>
</body>
<script>
    function goBack() {
      window.history.back();
    }
</script>
</html>
