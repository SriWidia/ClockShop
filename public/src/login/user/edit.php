<?php
include 'config.php';

if (!isset($conn)) {
    die('Koneksi tidak ditemukan.');
}

if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM pengguna WHERE idpengguna = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "User tidak ditemukan.";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $level = $_POST['level'];
    $password = $_POST['password'];

    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update_sql = "UPDATE pengguna SET nama = ?, username = ?, level = ?, password = ? WHERE idpengguna = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ssssi", $nama, $username, $level, $hashed_password, $id);
    } else {
        $update_sql = "UPDATE pengguna SET nama = ?, username = ?, level = ? WHERE idpengguna = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("sssi", $nama, $username, $level, $id);
    }

    if ($update_stmt->execute()) {
        header("Location: datauser.php?status=updated");
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
    <title>Edit Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-lg p-6 bg-white rounded-2xl shadow-lg">
        
        <div class="flex items-center gap-2 mb-6">
            <button onclick="goBack()" class="text-gray-600 hover:text-gray-900 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </button>
            <h2 class="text-2xl font-bold text-gray-800">Edit Pengguna</h2>
        </div>

        <form action="edit.php?id=<?php echo $row['idpengguna']; ?>" method="POST" class="space-y-4">
            <div>
                <label for="nama" class="block text-sm font-semibold text-gray-700">Nama</label>
                <input type="text" name="nama" id="nama" value="<?php echo htmlspecialchars($row['nama']); ?>" 
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all" />
            </div>

            <div>
                <label for="username" class="block text-sm font-semibold text-gray-700">Nama Pengguna</label>
                <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($row['username']); ?>" 
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all" />
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700">Level</label>
                <select name="level" 
                    class="w-full p-3 border border-gray-300 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all">
                    <option value="admin" <?php if($row['level'] == 'admin') echo 'selected'; ?>>Admin</option>
                    <option value="petugas" <?php if($row['level'] == 'petugas') echo 'selected'; ?>>Petugas</option>
                </select>
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700">Kata Sandi (Kosongkan jika tidak ingin mengubah)</label>
                <input type="password" name="password" id="password" 
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all" />
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white font-semibold py-3 rounded-lg hover:bg-blue-600 transition-all">
                Perbarui
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
