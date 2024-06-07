<?php
session_start();
include '../koneksi.php';

if (isset($_GET['id']) && isset($_GET['jenis_post'])) {
    $id = $_GET['id'];
    $jenis_post = $_GET['jenis_post'];

    $id = mysqli_real_escape_string($koneksi, $id);
    $jenis_post = mysqli_real_escape_string($koneksi, $jenis_post);

    if ($jenis_post == 'data') {
        $delete_query = "DELETE FROM transaksi WHERE id = '$id'";
        $result = mysqli_query($koneksi, $delete_query);

        if ($result) {
            header("Location: dashboard.php?sukses=2");
            exit();
        } else {
            header("Location: dashboard.php?error=2");
            exit();
        }
    } elseif ($jenis_post == 'galery') {
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
            $result_delete = mysqli_query($koneksi, $delete_query);

            if ($result_delete) {
                header("Location: view-data.php?sukses=2");
                exit();
            } else {
                header("Location: view-data.php?error=2");
                exit();
            }
        } else {
            header("Location: view-data.php?info");
            exit();
        }
    } else {
        echo ("Data Tidak Valid");
        exit();
    }
} else {
    echo ("Null");
    exit();
}
?>