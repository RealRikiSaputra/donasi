<?php
include '../koneksi.php';
session_start();
if (isset($_SESSION['admin'])) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $tipe = $_POST['tipe'];

        if ($tipe == "data") {       
            $id = $_POST['id'];
            $ket = $_POST['ket'];
            $jumlah = $_POST['jumlah'];
            $tanggal = $_POST['tanggal'];

            $update_query = "UPDATE transaksi SET keterangan='$ket', jumlah='$jumlah', tgl='$tanggal' WHERE id=$id";

        if (mysqli_query($koneksi, $update_query)) {
            header("Location: dashboard.php?sukses=4");
        } else {
            header("Location: dashboard.php?error=4");
        }
        } elseif ($tipe == "galery") {
            $id = $_POST['id'];
            $ket = $_POST['ket'];
            $foto_lama = $_POST['foto'];

            if ($_FILES['foto']['error'] === 4) {
                $foto = $foto_lama;
            } else {
                if (!empty($foto_lama)) {
                    $file_path = "../assets/" . $foto_lama;
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                }
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
        } else {
            header("Location: index.php?error=invalid_type");
        }
    }


    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $id = mysqli_real_escape_string($koneksi, $id);

        $sql = "SELECT * FROM assets WHERE id=$id";
        $result = mysqli_query($koneksi, $sql);

        
        $sql_data = "SELECT * FROM transaksi WHERE id=$id";
        $result_data = mysqli_query($koneksi, $sql_data);
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
                        <?php $jenis_post = $_GET['jenis_post']; ?>
                        <input type="hidden" name="foto" value="<?php echo $row['foto']; ?>">

                        <?php if ($jenis_post == 'galery'): ?>

                            <input type="hidden" name="tipe" value="galery">

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
                        <?php elseif ($jenis_post == 'data'):
        if ($result_data) {
            $row_data = mysqli_fetch_assoc($result_data);
        } else {
            echo "Error: " . mysqli_error($koneksi);
        }
        ?>
    <input type="hidden" name="tipe" value="data">

    <div class="form-group">
        <label for="ket" style="display: block; margin-bottom: 5px;">Keterangan</label>
        <select class="form-control" id="ket" name="ket" style="width: 100%;">
            <option value="pengeluaran" <?php if ($row_data['keterangan'] == 'pengeluaran') echo 'selected'; ?>>Pengeluaran</option>
            <option value="pemasukan" <?php if ($row_data['keterangan'] == 'pemasukan') echo 'selected'; ?>>Pemasukan</option>
        </select>
    </div>

    <div class="form-group">
        <label for="jumlah" style="display: block; margin-bottom: 5px;">Jumlah</label>
        <input type="number" class="form-control" id="jumlah" name="jumlah" style="width: 100%;" value="<?php echo $row_data['jumlah']; ?>" required>
    </div>

    <div class="form-group">
        <label for="tanggal">Tanggal</label>
        <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo $row_data['tgl']; ?>">
    </div>
<?php endif; ?>

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

    move_uploaded_file($tmpName, '../assets/' . $namaFileBaru);

    return $namaFileBaru;
}
?>