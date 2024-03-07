<?php

if (isset($_GET['kode'])) {
  $sql_cek = "SELECT a.id_pengaduan, a.judul, a.no_telpon, a.foto, a.status, a.lat, a.lng , a.keterangan, j.id_jenis, j.jenis 
    FROM tb_pengaduan a JOIN tb_jenis j ON a.jenis=j.id_jenis WHERE id_pengaduan=?";
  $stmt = $koneksi->prepare($sql_cek);
  $stmt->bind_param("s", $_GET['kode']);
  $stmt->execute();
  $result = $stmt->get_result();
  $data_cek = $result->fetch_assoc();
}
?>


<div class="container mt-4 mb-4">
  <div class="card">
    <div class="card-header bg-infooo text-white">
      <i class="bi bi-pencil"></i>
      <strong>Ubah Pengaduan</strong>
    </div>
    <div class="card-body">
      <form method="POST" enctype="multipart/form-data">

        <input type='hidden' class="form-control" name="id_pengaduan" value="<?php echo $data_cek['id_pengaduan']; ?>" readonly />

        <div class="mb-3">
          <label for="judul" class="form-label">Nama</label>
          <input type="text" class="form-control" name="judul" id="judul" value="<?php echo $data_cek['judul']; ?>" />
        </div>
        <div class="mb-3">
          <label for="no_telpon" class="form-label">No Hp/Whatsapp</label>
          <input type="text" class="form-control" name="no_telpon" id="no_telpon" value="<?php echo $data_cek['no_telpon']; ?>" />
        </div>
        <hr>
        <div class="mb-3">
          <label for="jenis" class="form-label">Jenis Aduan</label>
          <select name="jenis" class="form-control" id="jenis">
            <?php
            // ambil data dari database
            $query = "select * from tb_jenis";
            $hasil = mysqli_query($koneksi, $query);
            while ($row = mysqli_fetch_array($hasil)) {
            ?>
              <option value="<?php echo $row['id_jenis'] ?>" <?= $data_cek['id_jenis'] == $row['id_jenis'] ? "selected" : null ?>>
                <?php echo $row['jenis'] ?>
              </option>
            <?php
            }
            ?>
          </select>
        </div>

        <div class="mb-3">
          <label for="alamat" class="form-label">Alamat Aduan</label><br>
          <a href="https://www.google.com/maps/?q=<?php echo $data_cek['lat'] . ',' . $data_cek['lng']; ?>" target="_blank" class="btn btn-info mt-2">
            <i class="bi bi-map"></i> Lihat Lokasi pada Google Maps
          </a>
          <button type="button" class="btn btn-warning mt-2" data-bs-toggle="modal" data-bs-target="#modalUbahLokasi">
            <i class="bi bi-pencil-square"></i> Ganti Lokasi
          </button>
          <input type="hidden" id="hiddenLat" name="lat">
          <input type="hidden" id="hiddenLng" name="lng">
        </div>


        <div class="mb-3">
          <label for="keterangan" class="form-label">Keterangan</label>
          <textarea class="form-control" name="keterangan" id="keterangan" rows="5" required><?php echo $data_cek['keterangan']; ?></textarea>
        </div>

        <div class="mb-3">
          <label for="foto" class="form-label">Foto Lama</label>
          <br>
          <img src="foto/<?php echo $data_cek['foto']; ?>" width="80px" class="img-thumbnail mb-2" />
          <input type="file" class="form-control" name="foto" id="foto">
        </div>

        <div class="d-grid gap-2">
          <input type="submit" name="Ubah" value="Ubah" class="btn btn-success">
          <a href="?page=aduan_view" class="btn btn-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal untuk mengubah lokasi -->
  <div class="modal fade" id="modalUbahLokasi" tabindex="-1" aria-labelledby="modalUbahLokasiLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalUbahLokasiLabel">Ganti Lokasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="mapCanvas" style="width: 100%; height: 400px;"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </div>
    </div>
  </div>


</div>

<script>
  var map;
  var currentMarker;

  function initMap() {
    var initialPos = {
      lat: <?php echo $data_cek['lat'] ?? '-7.010283'; ?>,
      lng: <?php echo $data_cek['lng'] ?? '110.389072'; ?>
    };

    map = new google.maps.Map(document.getElementById('mapCanvas'), {
      center: initialPos,
      zoom: 8
    });

    currentMarker = new google.maps.Marker({
      position: initialPos,
      map: map
    });

    google.maps.event.addListener(map, 'click', function(event) {
      placeMarker(event.latLng);
    });
  }

  function placeMarker(location) {
    if (currentMarker) {
      currentMarker.setMap(null);
    }

    currentMarker = new google.maps.Marker({
      position: location,
      map: map
    });

    document.getElementById('hiddenLat').value = location.lat();
    document.getElementById('hiddenLng').value = location.lng();
  }

  function getMarkerData() {
    if (currentMarker) {
      var position = currentMarker.getPosition();
      return {
        lat: position.lat(),
        lng: position.lng()
      };
    }
    return null;
  }

  $('#modalUbahLokasi').on('shown.bs.modal', function() {
    google.maps.event.trigger(map, "resize");
    if (currentMarker) {
      map.setCenter(currentMarker.getPosition());
    }
  });

  document.querySelector('.btn-primary').addEventListener('click', function() {
    var markerData = getMarkerData();
    if (markerData) {
      document.getElementById('hiddenLat').value = markerData.lat;
      document.getElementById('hiddenLng').value = markerData.lng;

      // Tutup modal setelah menyimpan
      $('#modalUbahLokasi').modal('hide');

      Swal.fire({
        title: 'Success!',
        text: 'Lokasi telah diperbarui. Jangan lupa tekan "Ubah" untuk menyimpan perubahan ke database.',
        icon: 'success',
        confirmButtonText: 'OK'
      });
    } else {
      Swal.fire({
        title: 'Error!',
        text: 'Mohon pilih lokasi di peta.',
        icon: 'error',
        confirmButtonText: 'OK'
      });
    }
  });
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCkyPyVxHBaWGGsJgiQDe0ttKfhE1zzDZ0&callback=initMap"></script>


<?php

$sumber = @$_FILES['foto']['tmp_name'];
$target = 'foto/';
$nama_file = @$_FILES['foto']['name'];
$pindah = move_uploaded_file($sumber, $target . $nama_file);

if (isset($_POST['Ubah'])) {
  $judul = $_POST['judul'];
  $jenis = $_POST['jenis'];
  $no_telpon = $_POST['no_telpon'];
  $keterangan = $_POST['keterangan'];
  $lat = $_POST['lat'];
  $lng = $_POST['lng'];
  $id_pengaduan = $_POST['id_pengaduan'];

  if (isset($_FILES['foto']['tmp_name']) && $_FILES['foto']['tmp_name'] != "") {
    $sumber = $_FILES['foto']['tmp_name'];
    $target = 'foto/';
    $nama_file = $_FILES['foto']['name'];
    $pindah = move_uploaded_file($sumber, $target . $nama_file);

    if ($pindah) {
      if (isset($data_cek['foto']) && file_exists("foto/" . $data_cek['foto'])) {
        unlink("foto/" . $data_cek['foto']);
      }

      $sql_ubah = "UPDATE tb_pengaduan SET judul=?, jenis=?, no_telpon=?, foto=?, keterangan=?, lat=?, lng=? WHERE id_pengaduan=?";
      $stmt = $koneksi->prepare($sql_ubah);
      $stmt->bind_param("ssssssss", $judul, $jenis, $no_telpon, $nama_file, $keterangan, $lat, $lng, $id_pengaduan);
    } else {
      // File gagal dipindahkan
      die("Gagal mengunggah foto.");
    }
  } else {
    $sql_ubah = "UPDATE tb_pengaduan SET judul=?, jenis=?, no_telpon=?, keterangan=?, lat=?, lng=? WHERE id_pengaduan=?";
    $stmt = $koneksi->prepare($sql_ubah);
    $stmt->bind_param("sssssss", $judul, $jenis, $no_telpon, $keterangan, $lat, $lng, $id_pengaduan);
  }

  $query_ubah = $stmt->execute();

  if ($query_ubah) {

    function getAllWhatsappNumbers($koneksi)
    {
      $numbers = [];
      $sql = $koneksi->query("SELECT whatsapp FROM tb_pengguna");
      while ($row = $sql->fetch_assoc()) {
        $numbers[] = $row['whatsapp'];
      }
      return implode(',', $numbers); // Menggabungkan semua nomor dengan koma sebagai pemisah
    }

    // Kirim pesan ke WhatsApp Admin
    $token_wa = "nT5UZXP_CTevt3HTSUBd";
    $wa_admin = GetAllWhatsappNumbers($koneksi);
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
        'target' => $wa_admin,
        'message' => $message = "INFO PENGADUAN PENERANGAN JALAN UMUM

Nama Pengirim : $aduan
Alamat              : $alamat 
Nomor Telpon   : $no_telp 

Memerlukan penanganan Terimakasih.",

      ),
      CURLOPT_HTTPHEADER => array(
        "Authorization: $token_wa"
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;

    // Kirim pesan ke WhatsApp User
    $token_wa = "kQXDoqDmuLDAN!owWbbQ";

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
        'target' => $no_telp,
        'message' => $message = "INFO PENGADUAN PENERANGAN JALAN UMUM

Halo $aduan !!!
Terimakasih telah menghubungi kami
Kami akan segera menangani aduan di $alamat
Tunggu pemberitahuan selanjutnya dari kami

Terimakasih.",

      ),
      CURLOPT_HTTPHEADER => array(
        "Authorization: $token_wa"
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;

    // echo "<script>window.open('" . $url_telegram . "', '_blank');</script>";


    echo "<script>
    Swal.fire({
        title: 'Ubah Sukses',
        icon: 'success',
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = 'index.php?page=aduan_view';
        }
    });
</script>";
  } else {
    echo "<script>
    Swal.fire({
        title: 'Ubah Gagal',
        icon: 'error',
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = 'index.php?page=aduan_view';
        }
    });
    </script>";
  }
}
?>

<!-- end -->