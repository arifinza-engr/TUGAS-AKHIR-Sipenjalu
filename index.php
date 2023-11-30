<?php

session_set_cookie_params(0, '/', '', false, true);
session_start();

if (empty($_SESSION['ses_nama'])) {
  header("location: login");
  exit();
} else {
  $data_id = $_SESSION["ses_id"];
  $data_nama = $_SESSION["ses_nama"];
  $data_level = $_SESSION["ses_level"];
  $data_grup = $_SESSION["ses_grup"];
}

include "inc/koneksi.php";

include "inc/koneksi.php";

function getApiKey($koneksi, $nama)
{
  // Query to fetch the 'kunci' value from 'tb_kunciapi' where the 'nama' column matches
  $sql = "SELECT kunci FROM tb_kunciapi WHERE nama = ?";
  $stmt = $koneksi->prepare($sql);
  $stmt->bind_param("s", $nama);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    return $row["kunci"]; // Return the API key
  } else {
    echo "No API key found for '" . $nama . "'.";
    return null;
  }
}

// Fetching Google Maps API key
$api_key = getApiKey($koneksi, 'Google Maps API');

// Fetching WhatsApp Fontte API key
$api_whatsapp = getApiKey($koneksi, 'WhatsApp Fonnte API');

?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SIPENJALU</title>

  <!-- my css -->
  <link rel="stylesheet" href="assets/css/style1.css">
  <link rel="stylesheet" href="assets/css/label.css">

  <!-- Bootstrap 5.3.2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <!-- sweet alert -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

  <!-- Include DataTables CSS and JS -->
  <link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

  <!-- Include DataTables Buttons CSS and JS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css">
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.5/jszip.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>

</head>

<body>
  <nav class="navbar navbar-expand-lg bg-light fixed-top" id="navbar">
    <div class="container">
      <a class="navbar-brand" href="index">
        <img src="assets/img/tittle.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
        <span id="text-brand">KABUPATEN PEMALANG</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse fw-semibold" id="navbarNav">
        <ul class="navbar-nav ms-auto">

          <?php if ($data_level == "Administrator" || $data_level == "Petugas" || $data_level == "Pengadu") : ?>
            <li class="nav-item">
              <a class="nav-link" href="index">Dashboard</a>
            </li>
          <?php endif; ?>

          <?php if ($data_level == "Administrator") : ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Master Data
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="?page=api">Data API</a></li>
                <li><a class="dropdown-item" href="?page=jenis_view">Jenis Pengaduan</a></li>
              </ul>
            </li>
          <?php endif; ?>

          <?php if ($data_level == "Administrator" || $data_level == "Petugas") :  ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="" id="pengaduanDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Pengaduan
              </a>
              <ul class="dropdown-menu" aria-labelledby="pengaduanDropdown">
                <li><a class="dropdown-item" href="?page=aduan_admin_semua">Semua Aduan</a></li>
                <li><a class="dropdown-item" href="?page=aduan_admin">Aduan Menunggu</a></li>
                <li><a class="dropdown-item" href="?page=aduan_admin_tanggap">Aduan Ditanggapi</a></li>
                <li><a class="dropdown-item" href="?page=aduan_admin_selesai">Aduan Selesai</a></li>
              </ul>
            </li>
          <?php endif; ?>

          <?php if ($data_level == "Pengadu") :  ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="pengaduanDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Pengaduan
              </a>
              <ul class="dropdown-menu" aria-labelledby="pengaduanDropdown">
                <li><a class="dropdown-item" href="?page=aduan_tambah">Tambah Aduan</a></li>
                <li><a class="dropdown-item" href="?page=aduan_view">Lihat Aduan</a></li>
              </ul>
            </li>
          <?php endif; ?>

          <?php if ($data_level == "Administrator") : ?>
            <li class="nav-item">
              <a class="nav-link" href="?page=user_data">Pengguna</a>
            </li>
          <?php endif; ?>

          <?php if ($data_level == "Administrator" || $data_level == "Petugas") : ?>
            <a class="btn btn-danger fw-bold buttonLogout" type="button" href="?page=logout">LOGOUT</a>
          <?php endif; ?>

          <?php if ($data_level == "Pengadu") : ?>
            <a class="btn btn-outline-danger fw-bold buttonLogout" type="button" href="?page=logout">KELUAR</a>
          <?php endif; ?>

        </ul>
      </div>
    </div>
  </nav>

  <div class="slider_area">
    <div class="slider_active owl-carousel">
      <!-- single_carouse -->
      <div class="single_slider d-flex align-items-center jumbotron">
        <div class="container">
          <div class="row justify-content-center"> <!-- Tambahkan "justify-content-center" untuk mengatur konten ke tengah -->
            <div class="col-12">
              <div class="slider_text text-center"> <!-- Tambahkan "text-center" untuk mengatur teks ke tengah -->
                <h1 class="text-white" id="text-sipenjalu">SIPENJALU</h1>
                <h2 class="text-white" id="header-text">APLIKASI PENGADUAN PENERANGAN JALAN UMUM BERBASIS WEB MENGGUNAKAN REAL TIME NOTIFIKASI WHATSAPP</h2>
                <img src="" alt="" id="logosmp1" class="img-fluid"> <!-- Tambahkan "img-fluid" untuk responsifitas gambar -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--/ single_carouse -->
    </div>
  </div>

  <?php
  // Define an associative array to map page requests to file paths.
  $pageMap = [
    'admin-def' => 'default/admin.php',
    'petugas-def' => 'default/tugas.php',
    'pengadu' => 'default/pengadu.php',
    'user_data' => 'admin/pengguna/pengguna_tampil.php',
    'pengguna_tambah' => 'admin/pengguna/pengguna_tambah.php',
    'pengguna_ubah' => 'admin/pengguna/pengguna_ubah.php',
    'pedu_ubah' => 'admin/pengguna/pedu_ubah.php',
    'pengguna_hapus' => 'admin/pengguna/pengguna_hapus.php',
    'jenis_view' => 'admin/jenis/jenis_tampil.php',
    'jenis_tambah' => 'admin/jenis/jenis_tambah.php',
    'jenis_ubah' => 'admin/jenis/jenis_ubah.php',
    'jenis_hapus' => 'admin/jenis/jenis_hapus.php',
    'pengadu_view' => 'admin/pengadu/pengadu_tampil.php',
    'pengadu_tambah' => 'admin/pengadu/pengadu_tambah.php',
    'pengadu_ubah' => 'admin/pengadu/pengadu_ubah.php',
    'pengadu_hapus' => 'admin/pengadu/pengadu_hapus.php',
    'aduan_admin' => 'admin/aduan/adu_tampil.php',
    'aduan_admin_semua' => 'admin/aduan/adu_tampil_semua.php',
    'aduan_admin_tanggap' => 'admin/aduan/adu_tanggap.php',
    'aduan_admin_selesai' => 'admin/aduan/adu_selesai.php',
    'aduan_kelola' => 'admin/aduan/adu_ubah.php',
    'api' => 'admin/api/api.php',
    'laporan' => 'admin/laporan/laporan.php',
    'logout' => 'logout.php',
    'aduan_view' => 'pengadu/aduan/adu_tampil.php',
    'aduan_tambah' => 'pengadu/aduan/adu_tambah.php',
    'aduan_ubah' => 'pengadu/aduan/adu_ubah.php',
    'aduan_hapus' => 'pengadu/aduan/adu_hapus.php',
    'regis' => 'regis.php'
  ];

  // Define an array for default pages based on user level
  $defaultPages = [
    'Administrator' => 'default/admin.php',
    'Petugas' => 'default/tugas.php',
    'Pengadu' => 'default/pengadu.php'
  ];

  // Get the requested page from the URL query parameter.
  $hal = $_GET['page'] ?? null;

  // Include the appropriate file based on the request, or go to the default page based on user level.
  if (isset($pageMap[$hal])) {
    include $pageMap[$hal];
  } elseif (isset($defaultPages[$data_level])) {
    include $defaultPages[$data_level];
  } else {
    echo "<center><h1> ERROR !</h1></center>";
  }

  ?>

  <!-- Footer -->
  <footer class="bg-infooo text-center text-white" id="footer">
    <div class="container p-4 pb-0">
      <section class="mb-4">
        <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-facebook-f"></i></a>
        <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-twitter"></i></a>
        <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-google"></i></a>
        <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-instagram"></i></a>
        <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-linkedin-in"></i></a>
        <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-github"></i></a>
      </section>
    </div>
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
      Copyright © SIPENJALU 2023 All rights reserved
    </div>
  </footer>
  <!-- End -->

  <!-- Scripts -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

  <!-- Bootstrap 5.3.2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>