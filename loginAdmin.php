<?php
include "inc/koneksi.php";
session_start();

$message = null;

if (isset($_POST['btnLogin'])) {
  $username = mysqli_real_escape_string($koneksi, $_POST['username']);
  $password = mysqli_real_escape_string($koneksi, $_POST['password']);

  // Gunakan prepared statements untuk menghindari SQL Injection
  $stmt = $koneksi->prepare("SELECT * FROM tb_pengguna WHERE username=? AND password=?");
  $stmt->bind_param("ss", $username, $password);
  $stmt->execute();
  $result = $stmt->get_result();
  $data_login = $result->fetch_assoc();

  if ($data_login) {
    // Set session variables
    $_SESSION["ses_id"] = $data_login["id_pengguna"];
    $_SESSION["ses_nama"] = $data_login["nama_pengguna"];
    $_SESSION["ses_level"] = $data_login["level"];
    $_SESSION["ses_grup"] = $data_login["grup"];

    // Siapkan pesan sukses untuk ditampilkan
    $message = [
      "title" => "SUKSES",
      "text" => "Anda berhasil masuk",
      "icon" => "success",
      "redirect" => "index.php" // Halaman tujuan setelah login berhasil
    ];
  } else {
    // Siapkan pesan gagal untuk ditampilkan
    $message = [
      "title" => "GAGAL",
      "text" => "Username atau password salah!",
      "icon" => "error"
    ];
  }
  // Tampilkan pesan pada halaman saat ini, jangan redirect dari sini
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

<body class="bg-light">

  <section class="h-100 gradient-form" style="background-color: #eee;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-xl-10">
          <div class="card rounded-3 text-black">
            <div class="row g-0">
              <div class="col-lg-6">
                <div class="card-body p-md-5 mx-md-4">

                  <div class="text-center">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/lotus.webp" style="width: 185px;" alt="logo">
                    <h4 class="mt-1 mb-5 pb-1">SIPENJALU</h4>
                  </div>

                  <form action="" method="post">
                    <p>Please login to your account</p>

                    <div class="form-outline mb-2">
                      <input type="text" class="form-control" value="" placeholder="username" name="username" id="username" autocomplete="username">
                      <label class="form-label" for="username"></label>
                    </div>

                    <div class="form-outline mb-4">
                      <input type="password" class="form-control" value="" placeholder="password" name="password" id="password" autocomplete="current-password">
                      <label class="form-label" for="password"></label>
                    </div>

                    <div class="text-center pt-1 mb-5 pb-1">
                      <button type="submit" class="btn btn-outline-primary form-control fa-lg gradient-custom-2 mb-3 text-white" name="btnLogin">MASUK</button>
                      <a class="text-muted" href="#!">Forgot password?</a>
                    </div>

                    <div class="d-flex align-items-center justify-content-center pb-4">
                      <p class="mb-0 me-2">Don't have an account?</p>
                      <button type="button" class="btn btn-outline-primary">Create new</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                  <h4 class="mb-4">Admin Pengaduan Penerangan Jalan Umum</h4>
                  <p class="small mb-0">Kami memperkenalkan solusi formal dan efisien untuk mengatasi masalah penerangan jalan umum.
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

  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var message = <?php echo json_encode($message); ?>;
      if (message) {
        Swal.fire(message).then((result) => {
          if (message.redirect) {
            window.location = message.redirect;
          }
        });
      }
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>



<!-- END -->