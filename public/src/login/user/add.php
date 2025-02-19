<?php
include 'config.php'; 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $level = $_POST['level'];

    if (!empty($username) && !empty($password) && !empty($level) ) {
        $stmt = $conn->prepare("INSERT INTO user (nama, username, password, level) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nama, $username, $password, $level);

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
