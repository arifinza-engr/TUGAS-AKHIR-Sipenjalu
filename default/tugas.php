<?php
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

$sql = $koneksi->query("SELECT COUNT(id_pengadu) as orang  from tb_pengadu");
while ($data = $sql->fetch_assoc()) {
  $or = $data['orang'];
}
?>

<h2 class="text-center mt-4" id="oswald-font">DINAS PERUMAHAN DAN KAWASAN PERMUKIMAN KAB PEMALANG</h2>
<div class="container mt-5">
  <div class="row">
    <div class="col-md-4 col-sm-6 col-xs-6 mb-4">
      <a href="?page=aduan_admin" style="text-decoration: none; color: inherit;">
        <div class="card card-3d" id="card-panel">
          <div class="card-body text-center">
            <span class="fs-1 text-danger">
              <i class="fas fa-bell 3x"></i>
            </span>
            <h1><?= $proses; ?></h1>
            <p>Pengaduan Menunggu</p>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-6 mb-4">
      <a href="?page=aduan_admin_tanggap" style="text-decoration: none; color: inherit;">
        <div class="card card-3d" id="card-panel">
          <div class="card-body text-center">
            <span class="fs-1 text-success">
              <i class="fas fa-bell 3x"></i>
            </span>
            <h1><?= $tangan; ?></h1>
            <p>Pengaduan Ditanggapi</p>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-6 mb-4">
      <a href="?page=aduan_admin_selesai" style="text-decoration: none; color: inherit;">
        <div class="card card-3d" id="card-panel">
          <div class="card-body text-center">
            <span class="fs-1 text-primary">
              <i class="fas fa-bell 3x"></i>
            </span>
            <h1><?= $sel; ?></h1>
            <p>Pengaduan Selesai</p>
          </div>
        </div>
      </a>
    </div>
  </div>
</div>