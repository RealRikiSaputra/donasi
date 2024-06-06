<?php
session_start();
include '../koneksi.php';

$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$password = mysqli_real_escape_string($koneksi, $_POST['password']);

$query = "SELECT * FROM admin WHERE username='$username'";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) > 0) {
    $admin_data = mysqli_fetch_assoc($result);
    if (password_verify($password, $admin_data['password'])) {
        $_SESSION['admin'] = $username;
        header("location: dashboard.php");
    } else {
        header("location: index.php?pesan=gagal");
    }
} else {
    header("location: index.php?pesan=gagal");
}

