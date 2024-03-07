<!-- refactored -->

<?php

function fetchComplaint($kode, $koneksi)
{
  $stmt = $koneksi->prepare("SELECT a.id_pengaduan, a.judul, a.no_telpon, a.foto, a.status, a.keterangan, a.waktu_aduan, a.tanggapan, j.id_jenis, j.jenis, p.nama_pengadu FROM tb_pengaduan a JOIN tb_jenis j ON a.jenis = j.id_jenis JOIN tb_pengadu p ON a.author = p.id_pengadu WHERE id_pengaduan = ?");
  $stmt->bind_param('s', $kode);
  $stmt->execute();
  return $stmt->get_result()->fetch_assoc();
}

if (isset($_GET['kode'])) {
  $data_cek = fetchComplaint($_GET['kode'], $koneksi);
  $aduan = $data_cek['judul'];
}

function sendMessage($token, $target, $message)
{
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.fonnte.com/send',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array(
      'target' => $target,
      'message' => $message,
    ),
    CURLOPT_HTTPHEADER => array(
      "Authorization: $token"
    ),
  ));
  $response = curl_exec($curl);
  curl_close($curl);
  return $response;
}
?>


<!-- HTML content here -->
<div class="container mt-4"> <!-- Container pembungkus -->
  <div class="card">
    <div class="card-header bg-infooo">
      <i class="fas fa-edit"></i> <!-- FontAwesome 5 icon -->
      Tanggapi Pengaduan
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped">
          <tbody>
            <tr>
              <td rowspan="5" class="text-center">
                <img src="foto/<?php echo $data_cek['foto']; ?>" class="img-fluid">
              </td>
              <td>Nama Pengadu</td>
              <td width="55%">: <?php echo $data_cek['judul']; ?></td>
            </tr>
            <tr>
              <td>Jenis</td>
              <td>: <?php echo $data_cek['jenis']; ?></td>
            </tr>
            <tr>
              <td>Waktu Aduan</td>
              <td>:
                <?php $tgl = $data_cek['waktu_aduan'];
                echo date("d - F - Y", strtotime($tgl)) ?>
              </td>
            </tr>
            <tr>
              <td>Status</td>
              <td>: <?php echo $data_cek['status']; ?></td>
            </tr>
            <tr>
              <td>No Hp</td>
              <td>: <?php echo $data_cek['no_telpon']; ?></td>
            </tr>
          </tbody>
        </table>

        <form method="POST" enctype="multipart/form-data">

          <div class="mb-3">
            <input type='hidden' class="form-control" name="id_pengaduan" value="<?php echo $data_cek['id_pengaduan']; ?>" readonly />
          </div>

          <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea id="keterangan" class="form-control" name="" rows="2" readonly><?php echo $data_cek['keterangan']; ?></textarea>
          </div>

          <div class="mb-3">
            <label for="status" class="form-label">Status :</label>
            <select name="status" class="form-control" id="status" required>
              <option value="">- Pilih -</option>
              <option>Tanggapi</option>
              <option>Selesai</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="tanggapan" class="form-label">Tanggapan</label>
            <textarea id="tanggapan" class="form-control" name="tanggapan" rows="5" required><?php echo $data_cek['tanggapan']; ?></textarea>
          </div>

          <div class="d-grid gap-2">
            <input type="submit" name="Ubah" value="Simpan" class="btn btn-primary">
          </div>

        </form>
      </div>
    </div>
  </div>
</div> <!-- Penutup container -->

<?php

if (isset($_POST['Ubah'])) {

  $sql_ubah = "UPDATE tb_pengaduan SET
        status='" . $_POST['status'] . "',
        tanggapan='" . $_POST['tanggapan'] . "'
        WHERE id_pengaduan='" . $_POST['id_pengaduan'] . "'";
  $query_ubah = mysqli_query($koneksi, $sql_ubah);

  if ($query_ubah) {
    echo "<script>
            Swal.fire({title: 'Kelola Sukses',text: '',icon: 'success',confirmButtonText: 'OK'
            }).then((result) => {
                if (result.value) {
                    window.location = 'index.php?page=aduan_admin';
                }
            })</script>";

    // kirim pesan jika status adalah 'Tanggapi'
    if ($_POST['status'] == "Tanggapi") {
      // Send messages
      $token_wa = "$api_whatsapp";
      $no_telp = $data_cek['no_telpon'];
      $messageUser = "            INFO PENGADUAN PENERANGAN JALAN UMUM" . "\n\n" .
        "Halo $aduan !!!" . "\n" .
        "Terima kasih telah menghubungi kami. Aduan Anda saat ini sedang dalam tahap penyelesaian oleh tim kami." . "\n\n" .
        "Mohon bersabar, kami akan segera memberikan tanggapan terkait hasil penyelesaian aduan Anda." . "\n\n" .
        "Terima kasih atas kesabaran dan kepercayaan Anda.";

      sendMessage($token_wa, $no_telp, $messageUser);
    }

    // kirim pesan jika status adalah 'Selesai'
    if ($_POST['status'] == "Selesai") {
      // Send messages
      $token_wa = "$api_whatsapp";
      $no_telp = $data_cek['no_telpon'];
      $messageUser = "            INFO PENGADUAN PENERANGAN JALAN UMUM" . "\n\n" .

        "Halo $aduan !!!" . "\n" .
        "Kami senang memberitahukan bahwa aduan Anda telah berhasil diproses dan diselesaikan. Terima kasih telah memberikan masukan dan kepercayaan Anda kepada kami." . "\n" .
        "Jangan ragu untuk menghubungi kami jika Anda memiliki pertanyaan atau aduan lainnya di masa depan." . "\n\n" .

        "Salam hangat," . "\n" .
        "Dinas Perumahan Dan Kawasan Permukiman";


      sendMessage($token_wa, $no_telp, $messageUser);
    }
  } else {
    echo "<script>
            Swal.fire({title: 'Kelola Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
            }).then((result) => {
                if (result.value) {
                    window.location = 'index.php?page=aduan_admin';
                }
            })</script>";
  }
}

?>

<!-- end -->