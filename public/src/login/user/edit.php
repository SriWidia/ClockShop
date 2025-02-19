<?php
$conn = new mysqli('localhost', 'root', '', 'kasir_ukk_widia');

if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM user WHERE iduser = ?");
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
    $password = $_POST['password'];
    $level = $_POST['level'];

    $update_sql = "UPDATE user SET nama = ?, username = ?, password = ?, level = ? WHERE iduser = ?";
    $update_stmt = $conn->prepare($update_sql);

    $update_stmt->bind_param("ssssi", $nama, $username, $password, $level, $id);

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
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md mt-10">
        <h2 class="text-2xl font-bold mb-6">Edit Produk</h2>
        
        <form action="edit.php?id=<?php echo $row['iduser']; ?>" method="POST" class="space-y-4">
            <div>
                <label for="nama" class="block text-sm font-semibold">Nama</label>
                <input type="text" name="nama" id="nama" value="<?php echo htmlspecialchars($row['username']); ?>" class="w-full p-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-400" />
            </div>
            <div>
                <label for="username" class="block text-sm font-semibold">Username</label>
                <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($row['username']); ?>" class="w-full p-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-400" />
            </div>
            <div>
                <label for="password" class="block text-sm font-semibold">Password</label>
                <input type="text" step="0.01" name="password" id="password" value="<?php echo htmlspecialchars($row['password']); ?>" class="w-full p-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-400" />
            </div>
            <div>
                <label for="level" class="block text-sm font-semibold">Level</label>
                <input type="text" step="0.01" name="level" id="level" value="<?php echo htmlspecialchars($row['level']); ?>" class="w-full p-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-400" />
            </div>
            <button type="submit" class="bg-blue-400 text-white py-2 rounded-md hover:bg-blue-500 w-full">Update</button>
        </form>
    </div>
</body>
</html>
