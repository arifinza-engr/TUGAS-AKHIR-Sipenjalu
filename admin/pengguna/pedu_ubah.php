<?php

if (isset($_GET['kode'])) {
	$sql_cek = "SELECT * FROM tb_pengguna WHERE id_pengguna='" . $_GET['kode'] . "'";
	$query_cek = mysqli_query($koneksi, $sql_cek);
	$data_cek = mysqli_fetch_array($query_cek, MYSQLI_BOTH);
}
?>


<div class="container mt-4"> <!-- Container pembungkus -->
	<div class="card">
		<div class="card-header bg-infooo">
			<i class="fas fa-edit"></i> <!-- FontAwesome 5 icon -->
			Ubah Pengguna
		</div>
		<div class="card-body">
			<form method="POST">

				<div class="mb-3">
					<input type='hidden' class="form-control" name="id_pengguna" value="<?php echo $data_cek['id_pengguna']; ?>" readonly />
				</div>

				<div class="mb-3">
					<label for="nama_pengguna" class="form-label">Nama lengkap</label>
					<input type="text" class="form-control" id="nama_pengguna" name="nama_pengguna" value="<?php echo $data_cek['nama_pengguna']; ?>" readonly>
				</div>

				<div class="mb-3">
					<label for="username" class="form-label">Username</label>
					<input type="text" class="form-control" id="username" name="username" value="<?php echo $data_cek['username']; ?>">
				</div>

				<div class="mb-3">
					<label for="password" class="form-label">Password</label>
					<input type="password" class="form-control" id="password" name="password" value="<?php echo $data_cek['password']; ?>">
				</div>

				<div class="d-grid gap-2 d-md-block">
					<input type="submit" name="Ubah" value="Ubah" class="btn btn-success">
					<a href="?page=user_data" title="Kembali" class="btn btn-light">Batal</a>
				</div>

			</form>
		</div>
	</div>
</div> <!-- Penutup container -->



<?php

if (isset($_POST['Ubah'])) {

	$sql_ubah = "UPDATE tb_pengguna SET
        username='" . $_POST['username'] . "',
        password='" . $_POST['password'] . "'
        WHERE id_pengguna='" . $_POST['id_pengguna'] . "'";
	$query_ubah = mysqli_query($koneksi, $sql_ubah);
	if ($query_ubah) {
		echo "<script>
        Swal.fire({title: 'Ubah Sukses',text: '',icon: 'success',confirmButtonText: 'OK'
        }).then((result) => {if (result.value)
            {window.location = 'index.php?page=user_data';
            }
        })</script>";
	} else {
		echo "<script>
        Swal.fire({title: 'Ubah Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
        }).then((result) => {if (result.value)
            {window.location = 'index.php?page=user_data';
            }
        })</script>";
	}
}
?>
<!-- end -->