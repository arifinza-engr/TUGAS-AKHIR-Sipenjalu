<?php
$sql = $koneksi->query("SELECT COUNT(id_pengaduan) as proses  from tb_pengaduan where status='Proses' and author='$data_id'");
while ($data = $sql->fetch_assoc()) {
  $proses = $data['proses'];
}

$sql = $koneksi->query("SELECT COUNT(id_pengaduan) as tanggapi  from tb_pengaduan where status='Tanggapi' and author='$data_id'");
while ($data = $sql->fetch_assoc()) {
  $tangan = $data['tanggapi'];
}

$sql = $koneksi->query("SELECT COUNT(id_pengaduan) as selesai  from tb_pengaduan where status='Selesai' and author='$data_id'");
while ($data = $sql->fetch_assoc()) {
  $sel = $data['selesai'];
}

?>
<h4 class="text-center mt-4" id="text-dinas">DINAS PERUMAHAN DAN KAWASAN PERMUKIMAN KAB PEMALANG</h4>
<div class="container mt-5">
  <div class="row">
    <div class="col-md-3 col-sm-6 col-xs-6 mb-4">
      <a href="#" style="text-decoration: none; color: inherit;">
        <div class="card card-3d" id="card-panel">
          <div class="card-body text-center">
            <span class="fs-1 text-danger">
              <i class="fa fa-bell"></i>
            </span>
            <h1><?= $proses; ?></h1>
            <p class="fw-bold">Pengaduan Menunggu</p>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-6 mb-4">
      <a href="#" style="text-decoration: none; color: inherit;">
        <div class="card card-3d" id="card-panel">
          <div class="card-body text-center">
            <span class="fs-1 text-success">
              <i class="fa fa-bell"></i>
            </span>
            <h1><?= $tangan; ?></h1>
            <p class="fw-bold">Pengaduan Ditanggapi</p>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-6 mb-4">
      <a href="#" style="text-decoration: none; color: inherit;">
        <div class="card card-3d" id="card-panel">
          <div class="card-body text-center">
            <span class="fs-1 text-primary">
              <i class="fa fa-bell"></i>
            </span>
            <h1><?= $sel; ?></h1>
            <p class="fw-bold">Pengaduan Selesai</p>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-6 mb-4">
      <a href="?page=aduan_tambah" style="text-decoration: none; color: inherit;">
        <div class="card card-3d" id="card-panel">
          <div class="card-body text-center">
            <span class="fs-1">
              <i class="fas fa-plus fa-1x mb-4 mt-4"></i>
            </span>
            <p class="fw-bold">Tambah Aduan</p>
          </div>
        </div>
      </a>
    </div>
  </div>
</div>