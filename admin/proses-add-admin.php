<?php
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $query = "INSERT INTO admin (username, password) VALUES ('$username', '$password')";

    if (mysqli_query($koneksi, $query)) {
        header("location: view-admin.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    echo "Akses tidak sah.";
}
mysqli_close($koneksi);
?>