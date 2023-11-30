<?php
$author = $data_id;

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

<div class="container mt-4 mb-4">
  <div class="card">
    <div class="card-header bg-infooo text-white">
      <i class="bi bi-plus-lg"></i>
      <strong>Tambah Aduan</strong>
    </div>
    <div class="card-body">
      <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="judul" class="form-label">Nama Anda</label>
          <input type="text" class="form-control" name="judul" id="judul" placeholder="Masukan Nama Anda" required>
        </div>
        <div class="mb-3">
          <label for="no_telpon" class="form-label">No Hp/Whatsapp</label>
          <input type="text" class="form-control" name="no_telpon" id="no_telpon" placeholder="Masukan Nomor Aktif" required>
        </div>
        <hr class="custom-hr">
        <div class="mb-3">
          <label for="jenis" class="form-label">Jenis Aduan</label>
          <select name="jenis" class="form-control" id="jenis">
            <option value="">- Pilih -</option>
            <?php
            // ambil data dari database
            $query = "select * from tb_jenis";
            $hasil = mysqli_query($koneksi, $query);
            while ($row = mysqli_fetch_array($hasil)) {
            ?>
              <option value="<?php echo $row['id_jenis'] ?>">
                <?php echo $row['jenis'];  ?>
              </option>
            <?php
            }
            ?>
          </select>
        </div>
        <div class="mb-3">
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#mapModal">Pilih Lokasi</button>
          <input type="hidden" id="hiddenLat" name="lat">
          <input type="hidden" id="hiddenLng" name="lng">
        </div>
        <div class="mb-3">
          <label for="keterangan" class="form-label">Keterangan</label>
          <textarea class="form-control" name="keterangan" id="keterangan" rows="4" placeholder="Keterangan Aduan" required></textarea>
        </div>
        <div class="mb-3">
          <label for="foto" class="form-label">Foto</label>
          <input type="file" class="form-control" name="foto" id="foto" required>
        </div>
        <div>
          <input type="submit" name="Simpan" value="Simpan" class="btn btn-primary">
          <a href="?page=aduan_view" class="btn btn-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>

  <div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
          <div id="map" style="width: 100%; height: 400px;"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="saveMarkerData()">Simpan</button>
          <button type="button" class="btn btn-info" onclick="moveToCurrentLocation()">Lokasi Saya</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  var map;
  var currentMarker;
  var savedMarkerData = null; // Untuk menyimpan data marker sementara

  function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
      center: {
        lat: -7.010283,
        lng: 110.389072
      },
      zoom: 8
    });

    google.maps.event.addListener(map, 'rightclick', function(event) {
      placeMarker(event.latLng);
    });

    var longpressTimer;
    var startPressTime;

    google.maps.event.addListener(map, 'mousedown', function(event) {
      startPressTime = new Date().getTime();
      longpressTimer = setTimeout(function() {
        placeMarker(event.latLng);
      }, 1000);
    });

    google.maps.event.addListener(map, 'mouseup', function(event) {
      clearTimeout(longpressTimer);
    });

    google.maps.event.addListener(map, 'mousemove', function(event) {
      clearTimeout(longpressTimer);
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
  }

  function saveMarkerData() {
    var markerData = getMarkerData();
    if (markerData) {
      document.getElementById('hiddenLat').value = markerData.lat;
      document.getElementById('hiddenLng').value = markerData.lng;

      Swal.fire({
        title: 'Success!',
        text: 'Data saved.',
        icon: 'success',
        confirmButtonText: 'OK'
      });
    } else {
      Swal.fire({
        title: 'Error!',
        text: 'No marker to save.',
        icon: 'error',
        confirmButtonText: 'OK'
      });
    }
  }


  function submitMarkerData() {
    if (savedMarkerData) {
      // Add the 'method: "POST"' line to specify that this is a POST request.
      fetch('<?php echo $_SERVER['PHP_SELF']; ?>', {
          method: "POST",
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `lat=${savedMarkerData.lat}&lng=${savedMarkerData.lng}`
        })
        .then(response => response.text())
        .then(data => alert(data))
        .catch((error) => {
          console.error('Fetch Error:', error);
        });
    } else {
      alert("No marker data to submit.");
    }
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

  function moveToCurrentLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        var pos = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };
        map.setCenter(pos);
        placeMarker(pos);
      }, function() {
        handleLocationError(true);
      });
    } else {
      handleLocationError(false);
    }
  }

  function handleLocationError(browserHasGeolocation) {
    alert(browserHasGeolocation ?
      'Error: The Geolocation service failed.' :
      'Error: Your browser doesn\'t support geolocation.');
  }

  $('#mapModal').on('shown.bs.modal', function() {
    google.maps.event.trigger(map, "resize");
    moveToCurrentLocation();
  });
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCkyPyVxHBaWGGsJgiQDe0ttKfhE1zzDZ0&callback=initMap"></script>


<?php


if (isset($_POST['Simpan'])) {
  // Collect form data
  $aduan = $_POST['judul'];
  $no_telp = $_POST['no_telpon'];
  $lat = $_POST['lat'];  // Menerima latitude dari form
  $lng = $_POST['lng'];  // Menerima longitude dari form

  $sumber = $_FILES['foto']['tmp_name'];
  $nama_file = $_FILES['foto']['name'];
  $pindah = move_uploaded_file($sumber, 'foto/' . $nama_file);

  $stmt = $koneksi->prepare("INSERT INTO tb_pengaduan (`judul`, `no_telpon`, `jenis`, `keterangan`, `foto`, `author`, `lat`, `lng`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

  // Removed $alamat from bind_param
  $stmt->bind_param("ssssssss", $aduan, $no_telp, $_POST['jenis'], $_POST['keterangan'], $nama_file, $author, $lat, $lng);

  // Fungsi untuk mendapatkan semua nomor dari kolom wahatsapp user
  function getAllWhatsappNumbers($koneksi)
  {
    $numbers = [];
    $sql = $koneksi->query("SELECT whatsapp FROM tb_pengguna");
    while ($row = $sql->fetch_assoc()) {
      $numbers[] = $row['whatsapp'];
    }
    return implode(',', $numbers); // Menggabungkan semua nomor dengan koma sebagai pemisah
  }

  $query_simpan = $stmt->execute();

  if ($query_simpan) {
    echo "<script>
        Swal.fire({
            title: 'Tambah Sukses',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = 'index.php?page=aduan_view';
            }
        });
    </script>";

    // Send messages
    $token_wa = "$api_whatsapp";
    $wa_admin = getAllWhatsappNumbers($koneksi);
    $messageAdmin = "INFO PENGADUAN PENERANGAN JALAN UMUM

Nama Pengirim : $aduan
Alamat              : https://www.google.com/maps/place/$lat,$lng
Nomor Telpon   : $no_telp 

Memerlukan penanganan Terimakasih.";
    sendMessage($token_wa, $wa_admin, $messageAdmin);

    $messageUser = "INFO PENGADUAN PENERANGAN JALAN UMUM

Halo $aduan !!!
Terimakasih telah menghubungi kami
Kami akan segera menangani aduan anda
Tunggu pemberitahuan selanjutnya dari kami

Terimakasih.";
    sendMessage($token_wa, $no_telp, $messageUser);
  } else {
    echo "<script>
        Swal.fire({
            title: 'Tambah Gagal',
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