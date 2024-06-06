<?php
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM admin WHERE id = $id";

    if (mysqli_query($koneksi, $query)) {
        header("location: view-admin.php?status=deletesuccess");
        exit();
    } else {
        header("location: view-admin.php?status=deleteerror&message=" . urlencode(mysqli_error($koneksi)));
        exit();
    }
} else {
    echo "Invalid request.";
}

mysqli_close($koneksi);
?>