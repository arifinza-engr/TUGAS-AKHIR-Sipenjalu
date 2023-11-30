<div class="container mt-4"> <!-- Container pembungkus -->
  <div class="card">
    <div class="card-header bg-infooo">
      <i class="fas fa-plus"></i> <!-- FontAwesome 5 icon -->
      Tambah Pengguna
    </div>
    <div class="card-body">
      <form method="POST">

        <div class="mb-3">
          <label for="nama_pengguna" class="form-label">Nama Pengguna</label>
          <input type="text" class="form-control" id="nama_pengguna" name="nama_pengguna" placeholder="Nama Pengguna" required>
        </div>

        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
        </div>

        <div class="mb-3">
          <label for="level" class="form-label">Level</label>
          <select name="level" class="form-control" id="level">
            <option value="">- Pilih -</option>
            <option>Petugas</option>
            <option>Administrator</option>
          </select>
        </div>

        <div class="d-grid gap-2 d-md-block">
          <input type="submit" name="Simpan" value="Simpan" class="btn btn-primary">
          <a href="?page=user_data" title="Kembali" class="btn btn-light">Batal</a>
        </div>

      </form>
    </div>
  </div>
</div> <!-- Penutup container -->


<?php

if (isset($_POST['Simpan'])) {

  $sql_simpan = "INSERT INTO tb_pengguna (id_pengguna,nama_pengguna,username,password,level,grup) VALUES (
        UUID(),
        '" . $_POST['nama_pengguna'] . "',
        '" . $_POST['username'] . "',
		'" . $_POST['password'] . "',
		'" . $_POST['level'] . "',
        'A')";
  $query_simpan = mysqli_query($koneksi, $sql_simpan);
  if ($query_simpan) {
    echo "<script>
            Swal.fire({title: 'Tambah Sukses',text: '',icon: 'success',confirmButtonText: 'OK'
            }).then((result) => {if (result.value)
                {window.location = 'index.php?page=user_data';
                }
            })</script>";
  } else {
    echo "<script>
            Swal.fire({title: 'Tambah Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
            }).then((result) => {if (result.value)
                {window.location = 'index.php?page=user_data';
                }
            })</script>";
  }
}
?>
<!-- end -->