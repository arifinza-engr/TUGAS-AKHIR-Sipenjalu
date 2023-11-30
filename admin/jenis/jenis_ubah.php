<?php

if (isset($_GET['kode'])) {
  $sql_cek = "SELECT * FROM tb_jenis WHERE id_jenis='" . $_GET['kode'] . "'";
  $query_cek = mysqli_query($koneksi, $sql_cek);
  $data_cek = mysqli_fetch_array($query_cek, MYSQLI_BOTH);
}
?>


<div class="container mt-4"> <!-- Container pembungkus -->
  <div class="card">
    <div class="card-header bg-infooo">
      <i class="fas fa-edit"></i> <!-- FontAwesome 5 icon -->
      Ubah Jenis
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <form method="POST">

            <!-- Hidden input -->
            <input type='hidden' class="form-control" name="id_jenis" value="<?php echo $data_cek['id_jenis']; ?>" readonly>

            <div class="mb-3"> <!-- Menggunakan mb-3 (margin-bottom) untuk memberikan jarak antar elemen -->
              <label for="jenisInput" class="form-label">Jenis Aduan</label>
              <input type="text" class="form-control" id="jenisInput" name="jenis" value="<?php echo $data_cek['jenis']; ?>">
            </div>

            <div>
              <input type="submit" name="Ubah" value="Ubah" class="btn btn-success">
              <a href="?page=jenis_view" title="Kembali" class="btn btn-secondary">Batal</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div> <!-- Penutup container -->



<?php

if (isset($_POST['Ubah'])) {

  $sql_ubah = "UPDATE tb_jenis SET
        jenis='" . $_POST['jenis'] . "' WHERE id_jenis='" . $_POST['id_jenis'] . "'";
  $query_ubah = mysqli_query($koneksi, $sql_ubah);
  if ($query_ubah) {
    echo "<script>
        Swal.fire({title: 'Ubah Sukses',text: '',icon: 'success',confirmButtonText: 'OK'
        }).then((result) => {if (result.value)
            {window.location = 'index.php?page=jenis_view';
            }
        })</script>";
  } else {
    echo "<script>
        Swal.fire({title: 'Ubah Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
        }).then((result) => {if (result.value)
            {window.location = 'index.php?page=jenis_view';
            }
        })</script>";
  }
}
?>
<!-- end -->