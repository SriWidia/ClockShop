<?php
session_start();
if (!isset($_SESSION['idpengguna'])) {
    header("Location: index.php");
    exit();
}

include 'config.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
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

<div class="container mx-auto mt-6 px-6 flex justify-between">
    <h2 class="text-2xl font-semibold text-gray-700">Daftar pengguna</h2>
    <div class="space-x-4">
        <a href="add.php" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md shadow-md transition">Tambah Pengguna</a>
    </div>
</div>
<div class="container mx-auto px-6 py-10">
    <div class="bg-gray-100 p-6 rounded-2xl shadow-xl">
        <div class="flex items-center mb-4 space-x-3">
            <input type="text" placeholder="Cari Pengguna..." id="searchInput"
                class="w-full p-3 border rounded-lg text-gray-800 shadow-sm focus:ring-2 focus:ring-blue-400"
                oninput="searchUser(this.value)"/>
        </div>
        <div id="UserList" class="bg-white p-4 rounded-lg shadow-md">

            <?php
            $sql = "SELECT * FROM pengguna";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<div class='overflow-x-auto'>";
                echo "<table class='w-full bg-white rounded-lg shadow-lg border-collapse overflow-hidden'>";
                echo "<thead class='bg-blue-500 text-white text-left'>";
                echo "<tr>
                        <th class='p-3'>ID</th>
                        <th class='p-3'>Nama</th>
                        <th class='p-3'>Username</th>
                        <th class='p-3'>Sandi</th>
                        <th class='p-3'>Level</th>
                        <th class='p-3'>Aksi</th>
                      </tr>";
                echo "</thead><tbody class='text-gray-700'>";
                
                while ($row = $result->fetch_assoc()) {
                    echo "<tr class='border-b hover:bg-gray-100 transition duration-200'>";
                    echo "<td class='p-3'>" . htmlspecialchars($row['idpengguna']) . "</td>";
                    echo "<td class='p-3'>" . htmlspecialchars($row['nama']) . "</td>";
                    echo "<td class='p-3'>" . htmlspecialchars($row['username']) . "</td>";
                    echo "<td class='p-3'>" . htmlspecialchars($row['password']) . "</td>"; 
                    echo "<td class='p-3'>" . htmlspecialchars($row['level']) . "</td>";
                    echo "<td class='p-3 flex space-x-2'>
                            <a href='edit.php?id=" . $row['idpengguna'] . "' class='bg-green-500 text-white px-3 py-1 rounded-md shadow-md hover:bg-green-600 transition duration-200'>Edit</a>
                            <a href='delete.php?id=" . $row['idpengguna'] . "' class='bg-red-500 text-white px-3 py-1 rounded-md shadow-md hover:bg-red-600 transition duration-200' onclick='return confirm(\"Apakah Anda yakin ingin menghapus user ini?\")'>Hapus</a>
                          </td>"; 
                    echo "</tr>";
                }
                
                echo "</tbody></table></div>";
            } else {
                echo "<p class='text-gray-500 text-center'>Tidak ada pengguna yang terdaftar.</p>";
            }

            $conn->close();
            ?>

        </div>
    </div>
</div>

<script>
function searchUser(query) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'cariuser.php?query=' + encodeURIComponent(query), true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            document.getElementById('UserList').innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}
function goBack() {
        window.history.back();
    }
</script>

</body>
</html>
