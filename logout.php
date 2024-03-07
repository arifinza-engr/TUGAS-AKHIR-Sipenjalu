<?php
session_start();

// Cek jika level sesi ada dan tidak kosong
if (isset($_SESSION['ses_level']) && !empty($_SESSION['ses_level'])) {
  // Pemeriksaan level pengguna dan redirect ke halaman yang sesuai
  if ($_SESSION['ses_level'] == 'Administrator' || $_SESSION['ses_level'] == 'Petugas') {
    session_destroy();
    echo "<script>location='loginAdmin';</script>";
  } elseif ($_SESSION['ses_level'] == 'Pengadu') {
    session_destroy();
    echo "<script>location='login';</script>";
  } else {
    // Jika level sesi tidak dikenali, hancurkan sesi dan redirect ke halaman login umum
    session_destroy();
    echo "<script>location='login';</script>";
  }
} else {
  // Jika tidak ada sesi level, hancurkan sesi dan redirect ke halaman login umum
  session_destroy();
  echo "<script>location='login';</script>";
}
