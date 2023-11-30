<div class="container mt-4 mb-4">
  <div class="card">
    <div class="card-header bg-infooo text-white">
      <i class="fa fa-book"></i> <!-- Harap tambahkan pustaka FontAwesome atau ikon Bootstrap lainnya -->
      <b>Data Aduan</b>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Jenis</th>
              <th>Alamat</th>
              <th>Foto</th>
              <th>Status</th>
              <!-- <th>Aksi</th> -->
            </tr>
          </thead>
          <tbody>
            <?php

            $author = $data_id;
            $no = 1;
            $sql = $koneksi->query("SELECT a.id_pengaduan, a.judul, a.lat, a.lng, a.foto, a.status, j.jenis FROM tb_pengaduan a JOIN tb_jenis j ON a.jenis=j.id_jenis WHERE author='$author'");
            while ($data = $sql->fetch_assoc()) :
            ?>
              <tr>
                <td><?= $no++; ?></td>
                <td><?= $data['judul']; ?></td>
                <td><?= $data['jenis']; ?></td>
                <td>
                  <a href="https://www.google.com/maps/place/<?= $data['lat']; ?>,<?= $data['lng']; ?>" target="_blank" class="btn btn-primary btn-sm">
                    <i class="fas fa-map-marker-alt"></i> Lihat
                  </a>
                </td>

                <td>
                  <!-- Image thumbnail that triggers the modal -->
                  <img src="foto/<?= $data['foto']; ?>" width="100px" data-bs-toggle="modal" data-bs-target="#imageModal<?= $no ?>" role="button" tabIndex="0" />
                  <!-- The Modal -->
                  <div class="modal fade" id="imageModal<?= $no ?>">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body text-center">
                          <img src="foto/<?= $data['foto']; ?>" style="width: 100%;" alt="Image Preview">
                        </div>
                      </div>
                    </div>
                  </div>

                <td class='text-center align-middle'>
                  <?php
                  if ($data['status'] == 'Proses') {
                    echo '<span class="label label-warning">Menunggu</span>';
                  } elseif ($data['status'] == 'Tanggapi') {
                    echo '<span class="label label-success">Dalam Proses</span>';
                  } else {
                    echo '<span class="label label-primary">Selesai</span>';
                  }
                  ?>
                </td>


              </tr>
            <?php
            endwhile;
            ?>
          </tbody>
        </table>
        <a href="?page=aduan_tambah" class="btn btn-primary mb-3">
          <i class="fas fa-plus"></i> Tambah
        </a>
      </div>
    </div>
  </div>
</div>