<?php

if (isset($_GET['kode'])) {

    // Fetch data associated with the provided kode
    $stmt = $koneksi->prepare("SELECT * FROM tb_pengaduan WHERE id_pengaduan = ?");
    $stmt->bind_param("s", $_GET['kode']);
    $stmt->execute();
    $result = $stmt->get_result();
    $data_cek = $result->fetch_array(MYSQLI_BOTH);

    if ($data_cek) {
        // Delete the associated foto if it exists
        $fotoPath = "foto/" . $data_cek['foto'];
        if (file_exists($fotoPath)) {
            unlink($fotoPath);
        }

        // Delete the database entry
        $stmt = $koneksi->prepare("DELETE FROM tb_pengaduan WHERE id_pengaduan = ?");
        $stmt->bind_param("s", $_GET['kode']);
        $querySuccess = $stmt->execute();

        // Provide feedback based on success or failure of delete operation
        if ($querySuccess) {
            $messageTitle = 'Hapus Sukses';
            $messageIcon = 'success';
        } else {
            $messageTitle = 'Hapus Gagal';
            $messageIcon = 'error';
        }

        echo "<script>
            Swal.fire({title: '$messageTitle',text: '',icon: '$messageIcon',confirmButtonText: 'OK'
            }).then((result) => {
                if (result.value) {
                    window.location = 'index.php?page=aduan_view';
                }
            })
        </script>";
    }
}
?>

<!-- end -->