<?php
// Mengambil statistik keluhan
$sql = $koneksi->query("SELECT COUNT(id_pengaduan) as proses  from tb_pengaduan where status='Proses'");
while ($data = $sql->fetch_assoc()) {
  $proses = $data['proses'];
}

$sql = $koneksi->query("SELECT COUNT(id_pengaduan) as tanggapi  from tb_pengaduan where status='Tanggapi'");
while ($data = $sql->fetch_assoc()) {
  $tangan = $data['tanggapi'];
}

$sql = $koneksi->query("SELECT COUNT(id_pengaduan) as selesai  from tb_pengaduan where status='Selesai'");
while ($data = $sql->fetch_assoc()) {
  $sel = $data['selesai'];
}

$sql = $koneksi->query("SELECT COUNT(id_pengguna) as orang from tb_pengguna");
while ($data = $sql->fetch_assoc()) {
  $or = $data['orang'] - 1;
}
?>


<h4 class="text-center mt-4" id="text-dinas">DINAS PERUMAHAN DAN KAWASAN PERMUKIMAN KAB PEMALANG</h4>
<div class="container mt-5">
  <div class="row">
    <div class="col-md-3 col-sm-6 col-xs-6 mb-4">
      <a href="?page=aduan_admin" style="text-decoration: none; color: inherit;">
        <div class="card card-3d" id="card-panel">
          <div class="card-body text-center">
            <span class="fs-1 text-danger">
              <i class="fa fa-bell"></i>
            </span>
            <h1><?= $proses; ?></h1>
            <p>Pengaduan Menunggu</p>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-6 mb-4">
      <a href="?page=aduan_admin_tanggap" style="text-decoration: none; color: inherit;">
        <div class="card card-3d" id="card-panel">
          <div class="card-body text-center">
            <span class="fs-1 text-success">
              <i class="fa fa-bell"></i>
            </span>
            <h1><?= $tangan; ?></h1>
            <p>Pengaduan Ditanggapi</p>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-6 mb-4">
      <a href="?page=aduan_admin_selesai" style="text-decoration: none; color: inherit;">
        <div class="card card-3d" id="card-panel">
          <div class="card-body text-center">
            <span class="fs-1 text-primary">
              <i class="fa fa-bell"></i>
            </span>
            <h1><?= $sel; ?></h1>
            <p>Pengaduan Selesai</p>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-6 mb-4">
      <a href="?page=user_data" style="text-decoration: none; color: inherit;">
        <div class="card card-3d" id="card-panel">
          <div class="card-body text-center">
            <span class="fs-1 text-success">
              <i class="fa fa-users"></i>
            </span>
            <h1><?= $or; ?></h1>
            <p>Data Pengguna</p>
          </div>
        </div>
      </a>
    </div>
  </div>
</div>