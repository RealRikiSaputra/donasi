<?php
session_start();
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $select_query = "SELECT foto FROM assets WHERE id = '$id'";
    $result = mysqli_query($koneksi, $select_query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $foto = $row['foto'];
        $file_path = "../assets/" . $foto;

        if (file_exists($file_path)) {
            unlink($file_path);
        }

        $delete_query = "DELETE FROM assets WHERE id = '$id'";
        if (mysqli_query($koneksi, $delete_query)) {
            header("Location: view-data.php?sukses=2");
            exit();
        } else {
            header("Location: view-data.php?error=2");
            exit();
        }
    } else {
        header("Location: view-data.php?error=2");
        exit();
    }
} else {
    header("Location: view-data.php?info");
    exit();
}
?>