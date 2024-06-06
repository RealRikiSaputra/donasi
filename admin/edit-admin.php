<?php
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM admin WHERE id = $id";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "Pengguna tidak ditemukan.";
        exit();
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['id'];

    $new_username = $_POST['username'];
    $new_password = $_POST['new_password'];

    $update_query = "UPDATE admin SET username = '$new_username'";

    if (!empty($new_password)) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_query .= ", password = '$hashed_password'";
    }

    $update_query .= " WHERE id = $user_id";

    if (mysqli_query($koneksi, $update_query)) {
        header("Location: view-admin.php?status=success");
    } else {
        header("Location: view-admin.php?status=error&message=" . urlencode(mysqli_error($koneksi)));
    }
} else {
    echo "Permintaan tidak valid.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna</title>
    <link href="../css/styles.css" rel="stylesheet" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <main>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header">
                            <h3 class="text-center font-weight-light my-4">Edit User</h3>
                        </div>
                        <div class="card-body">

                            <form method="POST" enctype="multipart/form-data"
                                action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                                <div class="form-floating mb-3">
                                    <label for="name">Nama:</label>
                                    <input class="form-control" type="text" name="name"
                                        value="<?php echo $row['nama']; ?>" required placeholder="Nama" />
                                </div>
                                <div class="form-floating mb-3">
                                    <label for="username">Nama Pengguna:</label>
                                    <input class="form-control" type="text" name="username"
                                        value="<?php echo $row['username']; ?>" required placeholder="Username" />
                                </div>
                                <div class="form-floating mb-3">
                                    <label for="password">Password</label>
                                    <input class="form-control" type="password" name="new_password" required
                                        placeholder="Password" />
                                </div>
                                <button type="submit" class="btn btn-primary">Perbarui Pengguna</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>