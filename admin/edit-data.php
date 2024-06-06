<?php
include '../koneksi.php';
session_start();
if (isset($_SESSION['admin'])) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $id = $_POST['id'];

        $ket = $_POST['ket'];
        $foto_lama = $_POST['foto'];

        if ($_FILES['foto']['error'] === 4) {
            $foto = $foto_lama;
        } else {
            $foto = upload();
        }

        $update_query = "UPDATE assets SET keterangan='$ket'";

        if (!empty($foto)) {
            $update_query .= ", foto='$foto'";
        }

        $update_query .= " WHERE id=$id";

        if (mysqli_query($koneksi, $update_query)) {
            header("Location: view-data.php?sukses=4");
        } else {
            header("Location: view-data.php?error=4");
        }
    }

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $id = mysqli_real_escape_string($koneksi, $id);

        $sql = "SELECT * FROM assets WHERE id=$id";
        $result = mysqli_query($koneksi, $sql);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            ?>
            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Edit Data</title>
                <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
            </head>

            <body>
                <div class="container mt-5">
                    <h2>Edit Data</h2>
                    <form method="POST" enctype="multipart/form-data"
                        action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="foto" value="<?php echo $row['foto']; ?>">

                        <div class="form-group">
                            <label for="foto">Foto</label>
                            <img src="../assets/<?php echo $row['foto']; ?>" style="max-width: 100%; max-height: 200px;">
                            <p></p>
                            <input type="file" class="form-control-file" id="foto" name="foto">
                        </div>

                        <div class="form-group">
                            <label for="ket">Keterangan</label>
                            <input type="text" class="form-control" id="ket" name="ket" value="<?php echo $row['keterangan']; ?>">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
            </body>

            </html>
            <?php
        } else {
            echo "Error: " . mysqli_error($koneksi);
        }

    } else {
    ?>
    <?php
    }
    mysqli_close($koneksi);

} else {
    header("Location: dashboard.php");
    exit();
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

    move_uploaded_file($tmpName, '../img/' . $namaFileBaru);

    return $namaFileBaru;
}
?>