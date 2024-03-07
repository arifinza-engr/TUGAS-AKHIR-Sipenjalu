<?php
function generate_uuid()
{
  return sprintf(
    '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
    mt_rand(0, 0xffff),
    mt_rand(0, 0xffff),
    mt_rand(0, 0xffff),
    mt_rand(0, 0x0fff) | 0x4000,
    mt_rand(0, 0x3fff) | 0x8000,
    mt_rand(0, 0xffff),
    mt_rand(0, 0xffff),
    mt_rand(0, 0xffff)
  );
}

$UUID = generate_uuid();
?>
<div class="container mt-4">
  <div class="card">
    <div class="card-header bg-infooo">
      <i class="bi bi-plus"></i>
      <b>Tambah Pengadu</b>
    </div>
    <div class="card-body">
      <form method="POST">

        <div class="mb-3">
          <label for="nama_pengadu" class="form-label">Nama Pengguna</label>
          <input type="text" class="form-control" id="nama_pengadu" name="nama_pengadu" placeholder="Nama Pengadu" required />
        </div>

        <div class="mb-3">
          <label for="jekel" class="form-label">Jenis Kelamin</label>
          <select class="form-select" id="jekel" name="jekel">
            <option value="">- Pilih -</option>
            <option>Laki-Laki</option>
            <option>Perempuan</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="no_hp" class="form-label">No HP</label>
          <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="No HP" required />
        </div>

        <div class="mb-3">
          <label for="alamat" class="form-label">Alamat</label>
          <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat" required />
        </div>

        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" id="username" name="username" placeholder="Username" required />
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Password" required />
        </div>

        <div class="mb-3">
          <input type="submit" name="Simpan" value="Simpan" class="btn btn-primary">
          <a href="?page=user_data" title="Kembali" class="btn btn-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php

if (isset($_POST['Simpan'])) {

  $sql_simpan = "INSERT INTO tb_pengadu (id_pengadu, nama_pengadu, jekel, no_hp, alamat) VALUES (
			'$UUID',
			'" . $_POST['nama_pengadu'] . "',
			'" . $_POST['jekel'] . "',
			'" . $_POST['no_hp'] . "',
			'" . $_POST['alamat'] . "')";
  $query_simpan = mysqli_query($koneksi, $sql_simpan);

  $sql_pengguna = "INSERT INTO tb_pengguna (id_pengguna, nama_pengguna, username, password) VALUES (
			'$UUID',
			'" . $_POST['nama_pengadu'] . "',
			'" . $_POST['username'] . "',
			'" . $_POST['password'] . "')";
  $query_pengguna = mysqli_query($koneksi, $sql_pengguna);

  if ($query_simpan && $query_pengguna) {
    echo "<script>
            Swal.fire({title: 'Tambah Sukses',text: '',icon: 'success',confirmButtonText: 'OK'
            }).then((result) => {if (result.value)
                {window.location = 'index.php?page=pengadu_view';
                }
            })</script>";
  } else {
    echo "<script>
            Swal.fire({title: 'Tambah Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
            }).then((result) => {if (result.value)
                {window.location = 'index.php?page=pengadu_view';
                }
            })</script>";
  }
}
?>
<!-- end -->