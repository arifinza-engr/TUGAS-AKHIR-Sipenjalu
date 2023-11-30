<!-- refactored -->
<div class="container mt-4">
  <div class="card">
    <div class="card-header bg-infooo">
      <i class="fas fa-book"></i> <!-- FontAwesome 5 update -->
      Data Aduan
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-bordered" id="aduDitanggapi">
          <thead>
            <tr>
              <th>No</th>
              <th>Pengadu</th>
              <th>No Telp</th>
              <th>Nama</th>
              <th>Jenis</th>
              <th>Alamat</th>
              <th>Foto</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            $stmt = $koneksi->prepare("SELECT a.id_pengaduan, a.judul, a.no_telpon, a.foto, a.lat, a.lng, a.status, j.jenis, p.nama_pengadu, p.no_hp
                        FROM tb_pengaduan a
                        JOIN tb_jenis j ON a.jenis=j.id_jenis
                        JOIN tb_pengadu p ON a.author=p.id_pengadu
                        WHERE status=?");
            $status = 'Tanggapi';
            $stmt->bind_param('s', $status);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($data = $result->fetch_assoc()) {
              displayRow($data, $no++, $api_key);
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- modal -->
<div id="imageModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Foto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <img src="" id="imagePreview" width="100%" alt="Preview">
      </div>
    </div>
  </div>
</div>



<?php
function get_address_from_latlng($lat, $lng, $api_key)
{
  $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng&key=$api_key";
  $json_data = file_get_contents($url);
  $result = json_decode($json_data, TRUE);
  return $result['results'][0]['formatted_address'] ?? 'Alamat tidak ditemukan';
}

function displayRow($data, $no, $api_key)
{
  $status_label = getStatusLabel($data['status']);
  $address = get_address_from_latlng($data['lat'], $data['lng'], $api_key);

  // Prepare Google Maps link based on latitude and longitude
  $mapLink = "https://www.google.com/maps/place/{$data['lat']},{$data['lng']}";

  echo "<tr class='text-center align-middle'>
        <td>$no</td>
        <td>{$data['nama_pengadu']}</td> <!-- Pastikan ini adalah kolom yang benar untuk 'Pengadu' -->
        <td>{$data['no_telpon']}</td>
        <td>{$data['judul']}</td> <!-- Ini mungkin perlu diubah jika 'Nama' bukan judul aduan -->
        <td>{$data['jenis']}</td>
        <td><a href='{$mapLink}' target='_blank'>{$address}</a></td> <!-- Tampilkan alamat sebagai link -->
        <td><img src='foto/{$data['foto']}' width='100px' onclick='showImageInModal(this.src)' data-bs-toggle='modal' data-bs-target='#imageModal' role='button' tabIndex='0'></td>
        <td><span class='label $status_label[0]'>$status_label[1]</span></td>
        <td><a href='?page=aduan_kelola&kode={$data['id_pengaduan']}' title='Tanggapi' class='btn btn-primary btn-sm'><i class='fas fa-pen'></i></a></td>
    </tr>";
}


function getStatusLabel($status)
{
  switch ($status) {
    case 'Proses':
      return ['label-warning', 'menunggu'];
    case 'Tanggapi':
      return ['label-success', 'Ditanggapi'];
    default:
      return ['label-primary', 'Selesai'];
  }
}
?>

<script>
  $(document).ready(function() {
    var table = $('#aduDitanggapi').DataTable({
      dom: 'Bfrtip', // Show buttons in the specified location
      buttons: [{
        extend: 'excel', // Use the Excel export button
        text: 'Export to Excel', // Set the custom text for the button
        title: 'Daftar Aduan Diproses', // Set the title for the Excel sheet
        className: 'btn btn-primary' // Add Bootstrap 5 button classes
      }],
    });

    // Add a click event handler for the export button
    $('#export-excel').on('click', function() {
      table.buttons('excel').trigger(); // Trigger the Excel export action
    });
  });

  // Fungsi untuk menampilkan gambar dalam modal ketika gambar diklik
  function showImageInModal(src) {
    // Mengubah sumber dari img di dalam modal
    document.getElementById('imagePreview').src = src;
  }
</script>