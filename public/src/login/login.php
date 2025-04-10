<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['username']) ? trim($_POST['username']) : null;
    $password = isset($_POST['password']) ? trim($_POST['password']) : null;

    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Username atau password tidak boleh kosong!";
        header("Location: index.php");
        exit();
    }

    $sql = $conn->prepare("SELECT * FROM pengguna WHERE username = ?");
    $sql->bind_param("s", $username);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        if (password_verify($password, $row['password'])) {
            $_SESSION['idpengguna'] = $row['idpengguna'];
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['username'] = $username;
            $_SESSION['level'] = $row['level'];

            if ($row['level'] === 'admin') {
                header("Location: homeadmin.php");
            } elseif ($row['level'] === 'petugas') {
                header("Location: homepetugas.php");
            } else {
                $_SESSION['error'] = "Level tidak dikenali.";
                header("Location: index.php");
            }
        } else {
            $_SESSION['error'] = "Password salah!";      
            header("Location: index.php");
        }
    } else {
        $_SESSION['error'] = "Username tidak ditemukan!";
        header("Location: index.php");
    }

    $conn->close();
} else {
    header("Location: index.php");
    exit();
}
?>
