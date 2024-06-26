<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Donasi Masjid</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css" />
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Donasi Masjid</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#gallery">Galeri</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#donate">Donasi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#contact">Kontak</a>
        </li>
      </ul>
    </div>
  </nav>

  <header class="jumbotron text-center">
    <h1 class="display-4" style="font-size: 2rem; margin-bottom: 10px">
      Bantu Pembangunan Masjid Kami
    </h1>
    <p class="lead">Mari berdonasi untuk pembangunan dan perbaikan masjid.</p>
    <a class="btn btn-primary btn-lg" href="#donate" role="button">Donasi Sekarang</a>
  </header>

  <section id="gallery" class="container my-5">
    <h2 class="text-center mb-4">Galeri Masjid</h2>
    <div class="row" id="gallery-container">
      <!-- Gallery images will be inserted here -->
      <?php
      $query = "SELECT * FROM assets";
      $result = mysqli_query($koneksi, $query);

      while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="col-md-4 mb-4">
                <div class="card">
                  <img src="assets/' . $row['foto'] . '" class="card-img-top" alt="gambar galeri masjid">
                  <div class="card-body">
                    <p class="card-text">' . $row['keterangan'] . '</p>
                  </div>
                </div>
              </div>';
      }
      ?>
    </div>
  </section>


  <section id="donate" class="bg-light py-5">
    <div class="container">
      <h2 class="text-center mb-4">Metode Donasi</h2>
      <div class="row">
        <div class="col-lg-6">
          <center>
            <h3><strong>Donasi dengan QRIS</strong></h3>
          </center>
          <div class="text-center">
            <img src="img/QRIS.jpeg" class="img-fluid" alt="QRIS Code" />
            <p class="mt-3">
              Scan kode QR di atas menggunakan aplikasi pembayaran yang
              mendukung QRIS untuk berdonasi.
            </p>
          </div>
        </div>
        <div class="col-lg-6">
          <center>
            <h3><strong>Donasi dengan Bank BSI</strong></h3>
          </center>

          <div class="text-center mb-3">
            <img src="img/BSI.png" class="img-fluid" alt="Logo Bank BSI" style="max-width: 300px" />
          </div>
          <p>
            Anda juga dapat melakukan donasi melalui transfer bank ke rekening
            kami di Bank BSI.
          </p>
          <p>Detail rekening:</p>
          <ul>
            <li>Nama Bank: Bank BSI</li>
            <li>Nomor Rekening: 7178018536</li>
            <li>Nama Penerima: Masjid Al-Madinatul Munawwaroh</li>
          </ul>
          <p>
            Mohon pastikan untuk mencantumkan tujuan donasi Anda saat
            melakukan transfer.
          </p>
        </div>
      </div>
    </div>
  </section>

  <section id="contact" class="container my-5">
    <h2 class="text-center mb-4">Kontak</h2>
    <div class="row">
      <div class="col-md-6">
        <h3>Lokasi</h3>
        <!-- Google Maps iframe -->
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1982.3899318722767!2d107.0681919!3d-6.2135527!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e698f3231a35b43%3A0xaf18958ae307a614!2sMasjid%20Al%20Madinatul%20Munawarah!5e0!3m2!1sid!2sid!4v1622186590547!5m2!1sid!2sid"
          width="100%" height="300" style="border: 0" allowfullscreen="" loading="lazy"></iframe>
      </div>

      <div class="col-md-6">
        <h3>Kontak Kami</h3>
        <div class="card mb-4">
          <div class="card-body">
            <h5 class="card-title">Sodikin</h5>
            <p class="card-text">+6281210434605</p>
            <a href="https://wa.me/6281210434605" class="btn btn-success" target="_blank" rel="noopener noreferrer"><i
                class="fab fa-whatsapp"></i> Hubungi via WhatsApp</a>
          </div>
        </div>
        <div class="card mb-4">
          <div class="card-body">
            <h5 class="card-title">Dedi Hermana</h5>
            <p class="card-text">+6281510126455</p>
            <a href="https://wa.me/6281510126455" class="btn btn-success" target="_blank" rel="noopener noreferrer"><i
                class="fab fa-whatsapp"></i> Hubungi via WhatsApp</a>
          </div>
        </div>
        <div class="card mb-4">
          <div class="card-body">
            <h5 class="card-title">Syamsudin</h5>
            <p class="card-text">+6287883727888</p>
            <a href="https://wa.me/6287883727888" class="btn btn-success" target="_blank" rel="noopener noreferrer"><i
                class="fab fa-whatsapp"></i> Hubungi via WhatsApp</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer class="text-center py-4">
    <p>
      &copy; <span id="tahun"></span> Masjid Al-Madinatul Munawwaroh. All
      rights reserved. | Copyright
      <a href="https://realrikisaputra.github.io/Portfolio/">Riki Saputra</a>
    </p>
  </footer>

  <script>
    var tahunElement = document.getElementById("tahun");
    var tahun = new Date().getFullYear();
    tahunElement.textContent = tahun;
  </script>

  <script src="https://kit.fontawesome.com/6bf94bf80b.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="script.js"></script>
</body>

</html>