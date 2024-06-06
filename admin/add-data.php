<?php
session_start();
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ket = $_POST['ket'];


    $foto = upload();

    if (!$foto) {
        $foto = NULL;
    }

    $query = "INSERT INTO assets (foto, keterangan) 
    VALUES ('$foto', '$ket')";


    if (mysqli_query($koneksi, $query)) {
        header("Location: view-data.php?sukses=1");
    } else {
        header("Location: view-data.php?error=1");
    }
} else {
    echo "Metode request tidak valid!";
}

function upload()
{
    $namaFile = $_FILES['foto']['name'];
    $ukuranFile = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmpName = $_FILES['foto']['tmp_name'];

    if ($error === 4) {
        return false;
    }

    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
                alert('File bukan foto');
            </script>";
        return false;
    }

    if ($ukuranFile > 3000000) {
        echo "<script>
                alert('Ukuran Gambar Terlalu besar');
            </script>";
        return false;
    }
    $namaFileBaru = uniqid();
    $namaFileBaru .= "." . $ekstensiGambar;

    move_uploaded_file($tmpName, '../assets/' . $namaFileBaru);

    return $namaFileBaru;
}
?>