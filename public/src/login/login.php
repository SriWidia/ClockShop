<?php
header( "Content-Type: application/json" );

$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "kasir_ukk_widia";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die( json_encode(['status' => 'error', 'message' => 'Koneksi ke database gagal!']));
}

$username = isset($_POST['username']) ? trim($_POST['username']) : null;
$password = isset($_POST['password']) ? trim($_POST['password']) : null;

if (empty($username) || empty($password)) {
    echo json_encode(['status' => 'error', 'message' => 'Username atau password tidak boleh kosong!']);
    exit();
}

$sql = $conn->prepare( "SELECT * FROM user WHERE username = ?" );
$sql->bind_param("s", $username);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($password === $row['password']) { 
        echo json_encode([
            'status' => 'success',
            'message' => 'Anda berhasil login!',
            'level' => $row['level'] 
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Password salah!']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Username tidak ditemukan!']);
}

$conn->close();
?>
