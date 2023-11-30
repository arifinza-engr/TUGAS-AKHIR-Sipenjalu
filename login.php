<?php
include "inc/koneksi.php";

if (isset($_POST['btnLogin'])) {
  // Dapatkan input user
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Lakukan query untuk mencari user
  $sql_login = "SELECT * FROM tb_pengguna WHERE username='$username' AND password='$password'";
  $query_login = mysqli_query($koneksi, $sql_login);
  $data_login = mysqli_fetch_assoc($query_login);
  $jumlah_login = mysqli_num_rows($query_login);

  // Cek jika user ditemukan
  if ($jumlah_login == 1) {
    session_start();
    $_SESSION["ses_id"] = $data_login["id_pengguna"];
    $_SESSION["ses_nama"] = $data_login["nama_pengguna"];
    $_SESSION["ses_level"] = $data_login["level"];
    $_SESSION["ses_grup"] = $data_login["grup"];

    echo "<script>window.location = 'index';</script>";
  } else {
    echo "<script>alert('Username atau Password salah!'); window.location = 'login';</script>";
  }
}

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SIPENJALU</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="assets/css/login1.css">
</head>

<body class="">
  <form method="post">
    <section class="h-100 gradient-form" style="background-color: #eee;">
      <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-xl-10">
            <div class="card rounded-3 text-black">
              <div class="row g-0">
                <div class="col-lg-6">
                  <div class="card-body p-md-5 mx-md-4">
                    <div class="text-center">
                      <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/lotus.webp" style="width: 150px;" alt="logo">
                      <h4 class="mt-1 mb-5 pb-1">SIPENJALU</h4>
                    </div>
                    <div class="text-center">
                      <img src="assets/img/tittle.png" class="user-image img-responsive mb-4" alt="User Image" style="max-width: 180px;" />
                    </div>
                    <div class="form-outline mb-4">
                      <input type="hidden" id="form2Example11" class="form-control" value="pengadu" name="username" id="username" placeholder="Phone number or email address" />
                    </div>
                    <div class="form-outline mb-4">
                      <input type="hidden" id="form2Example22" value="123" name="password" id="password" class="form-control" />
                    </div>

                    <div class="text-center pt-1 mb-5 pb-1">
                      <button type="submit" class="btn btn-outline-primary form-control fa-lg gradient-custom-2 mb-3 text-white" name="btnLogin">MULAI PENGADUAN</button>
                    </div>
                    <div class="d-flex align-items-center justify-content-center pb-4">
                      <p class="mb-0 me-2">Copyright © SIPENJALU 2023 All rights reserved</p>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                  <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                    <h4 class="mb-4 text-center">Pengaduan Penerangan Jalan Umum: Notifikasi WhatsApp</h4>
                    <p class="small mb-0 text-justify">Kami memperkenalkan solusi formal dan efisien untuk mengatasi masalah penerangan jalan umum.
                      Dengan aplikasi pengaduan penerangan jalan kami, setiap laporan yang Anda kirimkan akan segera diproses.
                      Untuk memastikan Anda selalu mendapatkan informasi terbaru mengenai status pengaduan Anda,
                      kami telah mengintegrasikan notifikasi realtime melalui WhatsApp. Dengan komitmen kami untuk memastikan
                      penerangan jalan yang memadai dan keselamatan pengguna jalan, kami berupaya memberikan layanan yang cepat, transparan, dan akuntabel.
                      Bermitra dengan kami untuk mewujudkan kota yang lebih terang dan aman.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </form>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>

</html>


<?php
if (isset($_POST['btnLogin'])) {
  $sql_login = "SELECT * FROM tb_pengguna WHERE username='" . $_POST['username'] . "' AND password='" . $_POST['password'] . "'";
  $query_login = mysqli_query($koneksi, $sql_login);
  $data_login = mysqli_fetch_array($query_login, MYSQLI_BOTH);
  $jumlah_login = mysqli_num_rows($query_login);


  if ($jumlah_login == 1) {
    session_start();
    $_SESSION["ses_id"] = $data_login["id_pengguna"];
    $_SESSION["ses_nama"] = $data_login["nama_pengguna"];
    $_SESSION["ses_level"] = $data_login["level"];
    $_SESSION["ses_grup"] = $data_login["grup"];

    echo "<script>window.location = 'index';</script>";
  }
}
?>

<!-- END -->