<?php
session_start();
if (isset($_SESSION['admin'])) {
    include_once ("../koneksi.php");

    if (isset($_GET['status'])) {
        $notificationStyle = 'text-align: center; background-color: #f0f0f0; padding: 10px; border: 1px solid #ccc; position: absolute; top: 0; left: 50%; transform: translateX(-50%);';

        if ($_GET['status'] == 'success') {
            echo '<div style="' . $notificationStyle . ' color: green;">Update berhasil!</div>';
        } elseif ($_GET['status'] == 'error') {
            echo '<div style="' . $notificationStyle . ' color: red;">Update gagal. Pesan error: ' . htmlspecialchars($_GET['message']) . '</div>';
        }
    }
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'deletesuccess') {
            echo '<div style="text-align: center; background-color: #dff0d8; color: #3c763d; padding: 10px; border: 1px solid #d6e9c6; margin-bottom: 15px;">Pengguna berhasil dihapus!</div>';
        } elseif ($_GET['status'] == 'deleteerror') {
            echo '<div style="text-align: center; background-color: #f2dede; color: #a94442; padding: 10px; border: 1px solid #ebccd1; margin-bottom: 15px;">Gagal menghapus pengguna. Pesan error: ' . htmlspecialchars($_GET['message']) . '</div>';
        }
    }

    $sql = "SELECT keterangan, jumlah FROM transaksi";
    $result = $koneksi->query($sql);

    $totalPemasukan = 0;
    $totalPengeluaran = 0;

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ket = strtolower($row['keterangan']);
            if ($ket == 'pemasukan') {
                $totalPemasukan += $row['jumlah'];
            } elseif ($ket == 'pengeluaran') {
                $totalPengeluaran += $row['jumlah'];
            }
        }
    }

    $sisaUang = $totalPemasukan - $totalPengeluaran;

    $admin = $_SESSION['admin'];
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>

    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="dashboard.php">Donasi Masjid</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
                <i class="fas fa-bars"></i>
            </button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="../logout.php" onclick="logoutClick(event)">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Menu</div>
                            <a class="nav-link" href="dashboard.php">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-tachometer-alt"></i>
                                </div>
                                Dashboard
                            </a>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-columns"></i>
                                </div>
                                Admin
                                <div class="sb-sidenav-collapse-arrow">
                                    <i class="fas fa-angle-down"></i>
                                </div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                                data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="add-admin.php">Input Admin</a>
                                    <a class="nav-link" href="view-admin.php">View Admin</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                data-bs-target="#collapseLayout" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-book-open"></i>
                                </div>
                                Data
                                <div class="sb-sidenav-collapse-arrow">
                                    <i class="fas fa-angle-down"></i>
                                </div>
                            </a>
                            <div class="collapse" id="collapseLayout" aria-labelledby="headingOne"
                                data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="view-data.php">View Data</a>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?php echo $admin; ?>!
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Dashboard Admin</h1>
                        <div class="container mt-5">
                            <div class="row">
                                <div class="col-sm-4 mb-4">
                                    <div class="card bg-success text-white">
                                        <div class="card-body">
                                            <center>
                                                <h3>Pemasukan: Rp <?php echo number_format($totalPemasukan, 0, ',', '.'); ?>
                                                </h3>
                                            </center>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-4">
                                    <div class="card bg-danger text-white">
                                        <div class="card-body">
                                            <center>
                                                <h3>Pengeluaran: Rp
                                                    <?php echo number_format($totalPengeluaran, 0, ',', '.'); ?>
                                                </h3>
                                            </center>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-4">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body">
                                            <center>
                                                <h3 id="balanceInfo">Sisa Uang: Rp <span
                                                        id="balanceValue"><?php echo number_format($sisaUang, 0, ',', '.'); ?></span>
                                                </h3>
                                            </center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                            data-bs-target="#addDataModal">Tambah Data</button>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Tagihan
                            </div>
                            <div class="card-body">
                                <?php
                                $query = "SELECT * FROM transaksi";
                                $result_data = mysqli_query($koneksi, $query);

                                if ($result_data->num_rows > 0) {
                                    echo "<table id='datatablesSimple' class='table'>";
                                    echo "<thead>";
                                    echo "<tr>";
                                    echo "<th>Keterangan</th>";
                                    echo "<th>Jumlah</th>";
                                    echo "<th>Tanggal</th>";
                                    echo "<th>Action</th>";
                                    echo "</tr>";
                                    echo "</thead>";
                                    echo "<tbody>";
                                    while ($row = $result_data->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row['keterangan'] . "</td>";
                                        echo "<td>" . $row['jumlah'] . "</td>";
                                        echo "<td>" . $row['tgl'] . "</td>";
                                        echo '<td>
                                                <a class="edit-link" href="edit-data.php?id=' . $row['id'] . '&jenis_post=data">Edit</a> |
                                                <a class="reset-link" href="delete-data.php?id=' . $row['id'] . '&jenis_post=data">Delete</a>
                                            </td>';
                                        echo "</tr>";
                                    }
                                    echo "</tbody>";
                                    echo "</table>";
                                } else {
                                    echo "Tidak ada data yang ditemukan.";
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Pop UP Modal Tambah -->
                        <div class="modal fade" id="addDataModal" tabindex="-1" aria-labelledby="addDataModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addDataModalLabel">Tambah Data Baru</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Form tambah data disini -->
                                        <form method="POST" action="add-data.php" enctype="multipart/form-data"
                                            style="margin: 20px;">
                                            <input type="hidden" name="jenis_post" value="data">

                                            <div class="form-group" style="margin-bottom: 15px;">
                                                <label for="ket"
                                                    style="display: block; margin-bottom: 5px;">Keterangan</label>
                                                <select class="form-control" id="ket" name="ket" style="width: 100%;">
                                                    <option value="pengeluaran">Pengeluaran</option>
                                                    <option value="pemasukan">Pemasukan</option>
                                                </select>
                                            </div>
                                            <div class="form-group" style="margin-bottom: 15px;">
                                                <label for="jumlah"
                                                    style="display: block; margin-bottom: 5px;">Jumlah</label>
                                                <input type="number" class="form-control" id="jumlah" name="jumlah"
                                                    style="width: 100%;" required>
                                            </div>

                                            <div class="form-group" style="margin-bottom: 15px;">
                                                <label for="tanggal"
                                                    style="display: block; margin-bottom: 5px;">Tanggal</label>
                                                <input type="date" class="form-control" id="tanggal" name="tanggal"
                                                    style="width: 100%;" required>
                                            </div>

                                            <button type="submit" class="btn btn-primary"
                                                style="margin-top: 10px;">Simpan</button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Riki Saputra 2023</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
            crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>

        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script>
            function logoutClick(event) {
                event.preventDefault();
                var logoutText = "Logout";
                var confirmation = confirm("Are you sure you want to logout?");

                if (confirmation) {
                    event.target.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Logging out...';
                    window.location.href = "logout.php";
                }
            }
        </script>
    </body>

    </html>
    <?php
    if (isset($_GET['sukses']) && $_GET['sukses'] == '1') {
        echo "<script>
            swal({
                title: 'Sukses!',
                text: 'Data berhasil disimpan!',
                icon: 'success',
                button: 'OK'
            });
         </script>";
    } elseif (isset($_GET['error']) && $_GET['error'] == '1') {
        echo "<script>
            swal({
                title: 'Gagal!',
                text: 'Data gagal disimpan!',
                icon: 'error',
                button: 'OK'
            });
         </script>";
    }elseif (isset($_GET['sukses']) && $_GET['sukses'] == '2') {
        echo "<script>
            swal({
                title: 'Sukses!',
                text: 'Data berhasil dihapus',
                icon: 'success',
                button: 'OK'
            });
         </script>";
    } elseif (isset($_GET['error']) && $_GET['error'] == '2') {
        echo "<script>
            swal({
                title: 'Gagal!',
                text: 'Data gagal dihapus',
                icon: 'error',
                button: 'OK'
            });
         </script>";
    } elseif (isset($_GET['sukses']) && $_GET['sukses'] == '4') {
        echo "<script>
            swal({
                title: 'Sukses!',
                text: 'Data berhasil di ubah',
                icon: 'success',
                button: 'OK'
            });
         </script>";
    } elseif (isset($_GET['error']) && $_GET['error'] == '4') {
        echo "<script>
            swal({
                title: 'Gagal!',
                text: 'Data gagal di ubah',
                icon: 'error',
                button: 'OK'
            });
         </script>";
    } elseif (isset($_GET['info'])) {
        echo "<script>
            swal({
                title: 'Gagal!',
                text: 'Gagal mendapatkan data',
                icon: 'warning',
                button: 'OK'
            });
         </script>";
    }
} else {
    header("Location: index.php");
    exit();
}
?>