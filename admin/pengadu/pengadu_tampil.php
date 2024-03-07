<div class="container mt-4">
  <div class="card">
    <div class="card-header bg-infooo">
      <i class="fas fa-book"></i> <!-- FontAwesome 5 icon -->
      Data Pengadu
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-bordered" id="dataTables-example">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>JK</th>
              <th>No HP</th>
              <th>Alamat</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            $sql = $koneksi->query("select * from tb_pengadu");
            while ($data = $sql->fetch_assoc()) {
            ?>
              <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $data['nama_pengadu']; ?></td>
                <td><?php echo $data['jekel']; ?></td>
                <td><?php echo $data['no_hp']; ?></td>
                <td><?php echo $data['alamat']; ?></td>
                <td>
                  <a href="?page=pengadu_ubah&kode=<?php echo $data['id_pengadu']; ?>" title="Ubah" class="btn btn-success btn-sm">
                    <i class="fas fa-edit"></i> <!-- FontAwesome 5 icon -->
                  </a>
                  <a href="?page=pengadu_hapus&kode=<?php echo $data['id_pengadu']; ?>" onclick="return confirm('Apakah anda yakin hapus pengadu ini ?')" title="Hapus" class="btn btn-danger btn-sm">
                    <i class="fas fa-trash"></i> <!-- FontAwesome 5 icon -->
                  </a>
                </td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
        <a href="?page=pengadu_tambah" class="btn btn-primary mt-3">
          <i class="fas fa-plus"></i> Tambah <!-- FontAwesome 5 icon -->
        </a>
      </div>
    </div>
  </div>
</div>