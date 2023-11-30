<div class="container mt-4"> <!-- Container pembungkus -->
  <div class="card">
    <div class="card-header bg-infooo">
      <i class="fas fa-book"></i> <!-- FontAwesome 5 icon -->
      Data Pengguna
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover" id="user">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Username</th>
              <th>Password</th>
              <th>Whatsapp</th>
              <th>Level</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            $sql = $koneksi->query("select * from tb_pengguna order by grup asc");
            while ($data = $sql->fetch_assoc()) {
              if ($data['nama_pengguna'] != "Masyarakat") {
            ?>
                <tr>
                  <td><?php echo $no++; ?></td>
                  <td><?php echo $data['nama_pengguna']; ?></td>
                  <td><?php echo $data['username']; ?></td>
                  <td><?php echo str_repeat("*", strlen($data['password'])); ?></td>
                  <td><?php echo $data['whatsapp']; ?></td>
                  <td><?php echo $data['level']; ?></td>
                  <td>
                    <?php $grup = $data['grup']; ?>
                    <?php if ($grup == "A") { ?>
                      <a href="?page=pengguna_ubah&kode=<?php echo $data['id_pengguna']; ?>" title="Ubah" class="btn btn-success btn-sm">
                        <i class="fas fa-edit"></i>
                      </a>
                      <a href="?page=pengguna_hapus&kode=<?php echo $data['id_pengguna']; ?>" onclick="return confirm('Apakah anda yakin hapus pengguna ini ?')" title="Hapus" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i>
                      </a>
                    <?php } else { ?>
                      <a href="?page=pedu_ubah&kode=<?php echo $data['id_pengguna']; ?>" title="Ubah" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i>
                      </a>
                  </td>
                </tr>
            <?php
                    }
                  }
            ?>

          <?php
            }
          ?>
          </tbody>
        </table>
      </div>

      <a href="?page=pengguna_tambah" class="btn btn-primary mt-3">
        <i class="fas fa-plus"></i> Tambah
      </a>
    </div>
  </div>
</div> <!-- Penutup container -->
<script>
  $(document).ready(function() {
    var table = $('#user').DataTable({
      dom: 'Bfrtip', // Show buttons in the specified location
      buttons: [{
        extend: 'excel', // Use the Excel export button
        text: 'Export to Excel', // Set the custom text for the button
        title: 'Daftar Aduan Selesai', // Set the title for the Excel sheet
        className: 'btn btn-primary' // Add Bootstrap 5 button classes
      }],
    });

    // Add a click event handler for the export button
    $('#export-excel').on('click', function() {
      table.buttons('excel').trigger(); // Trigger the Excel export action
    });
  });

  function showImage(src) {
    document.getElementById('imagePreview').src = src;
  }
</script>