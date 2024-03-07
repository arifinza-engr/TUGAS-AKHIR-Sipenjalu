<div class="container mt-4"> <!-- Container pembungkus -->
  <div class="card">
    <div class="card-header bg-infooo">
      <i class="fas fa-book"></i> <!-- FontAwesome 5 icon -->
      Jenis Aduan
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
          <thead>
            <tr>
              <th>No</th>
              <th>Jenis Aduan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            $sql = $koneksi->query("select * from tb_jenis");
            while ($data = $sql->fetch_assoc()) {
            ?>
              <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $data['jenis']; ?></td>
                <td>
                  <a href="?page=jenis_ubah&kode=<?php echo $data['id_jenis']; ?>" title="Ubah" class="btn btn-success btn-sm">
                    <i class="fas fa-edit"></i> <!-- FontAwesome 5 icon -->
                  </a>
                  <a href="?page=jenis_hapus&kode=<?php echo $data['id_jenis']; ?>" onclick="return confirm('Apakah anda yakin hapus jenis ini ?')" title="Hapus" class="btn btn-danger btn-sm">
                    <i class="fas fa-trash"></i> <!-- FontAwesome 5 icon -->
                  </a>
                </td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
        <a href="?page=jenis_tambah" class="btn btn-primary mt-3">
          <i class="fas fa-plus"></i> Tambah
        </a>
      </div>
    </div>
  </div>
</div> <!-- Penutup container -->