<?php
if(isset($_GET['kode'])){
            $sql_hapus = "DELETE FROM tb_pengadu WHERE id_pengadu='".$_GET['kode']."'";
            $query_hapus = mysqli_query($koneksi, $sql_hapus);

            $sql_hap = "DELETE FROM tb_pengguna WHERE id_pengguna='".$_GET['kode']."'";
            $query_del = mysqli_query($koneksi, $sql_hap);

            if ($query_hapus && $query_del) {
                echo "<script>
                Swal.fire({title: 'Hapus Sukses',text: '',icon: 'success',confirmButtonText: 'OK'
                }).then((result) => {if (result.value)
                    {window.location = 'index.php?page=pengadu_view';
                    }
                })</script>";
                }else{
                echo "<script>
                Swal.fire({title: 'Hapus Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
                }).then((result) => {if (result.value)
                    {window.location = 'index.php?page=pengadu_view';
                    }
                })</script>";
            }
        }

?>

<!-- end -->