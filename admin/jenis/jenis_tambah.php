<div class="container mt-4"> <!-- Container pembungkus -->
  <div class="card">
    <div class="card-header bg-infooo">
      <i class="fas fa-plus"></i> <!-- FontAwesome 5 icon -->
      Tambah Jenis
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <form method="POST">
            <div class="mb-3"> <!-- Menggunakan mb-3 (margin-bottom) untuk memberikan jarak antar elemen -->
              <label for="jenisInput" class="form-label">Tambah Jenis</label>
              <input type="text" class="form-control" id="jenisInput" name="jenis" placeholder="..." required>
            </div>
            <div>
              <input type="submit" name="Simpan" value="Simpan" class="btn btn-primary">
              <a href="?page=jenis_view" title="Kembali" class="btn btn-secondary">Batal</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div> <!-- Penutup container -->


<?php

if (isset($_POST['Simpan'])) {

  $sql_simpan = "INSERT INTO tb_jenis (jenis) VALUES ('" . $_POST['jenis'] . "')";
  $query_simpan = mysqli_query($koneksi, $sql_simpan);
  if ($query_simpan) {
    echo "<script>
            Swal.fire({title: 'Tambah Sukses',text: '',icon: 'success',confirmButtonText: 'OK'
            }).then((result) => {if (result.value)
                {window.location = 'index.php?page=jenis_view';
                }
            })</script>";
  } else {
    echo "<script>
            Swal.fire({title: 'Tambah Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
            }).then((result) => {if (result.value)
                {window.location = 'index.php?page=jenis_view';
                }
            })</script>";
  }
}
?>
<!-- end -->