<!-- refactored -->

<div class="container mt-4">
  <div class="card">
    <div class="card-header bg-infooo">
      <i class="fas fa-book"></i> <!-- FontAwesome 5 update -->
      Data Aduan
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-bordered" id="aduSelesai">
          <thead>
            <tr>
              <th>No</th>
              <th>Pengadu</th>
              <th>No Telp</th>
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
                        JOIN tb_jenis j ON a.jenis = j.id_jenis
                        JOIN tb_pengadu p ON a.author = p.id_pengadu
                        WHERE status = ?");
            $status = 'Selesai';
            $stmt->bind_param('s', $status);
            $stmt->execute();
            $result = $stmt->get_result();

            function get_address_from_latlng($lat, $lng, $api_key)
            {
              $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng&key=$api_key";
              $json_data = file_get_contents($url);
              $result = json_decode($json_data, TRUE);
              return $result['results'][0]['formatted_address'] ?? 'Alamat tidak ditemukan';
            }

            while ($data = $result->fetch_assoc()) {
              echo generateRow($data, $no++, $api_key);
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imageModalLabel">Detail Image</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img src="" id="imagePreview" width="100%" alt="Preview">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php
function generateRow($data, $no, $api_key)
{
  $statusLabel = getStatusLabel($data['status']);
  $lat = $data['lat'];
  $lng = $data['lng'];
  $address = get_address_from_latlng($lat, $lng, $api_key); // Mendapatkan alamat

  return "
    <tr class='text-center align-middle'>
        <td>$no</td>
        <td>{$data['judul']}</td> <!-- Ganti dengan nama pengadu jika berbeda -->
        <td>{$data['no_telpon']}</td>
        <td>{$data['jenis']}</td>
        <td><a href='https://www.google.com/maps/?q=$lat,$lng' target='_blank'>$address</a></td> <!-- Tampilkan alamat sebagai link -->
        <td><img src='foto/{$data['foto']}' width='100px' data-bs-toggle='modal' data-bs-target='#imageModal$no' role='button' tabindex='0'></td>
        <td><span class='label $statusLabel[0]'>$statusLabel[1]</span></td>
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
    case 'Selesai':
      return ['label-primary', 'Selesai'];
    default:
      return ['label-default', 'Unknown'];
  }
}
?>

<script>
  $(document).ready(function() {
    var table = $('#aduSelesai').DataTable({
      dom: 'Bfrtip', // Show buttons in the specified location
      buttons: [{
        extend: 'excel', // Use the Excel export button
        text: 'Export to Excel', // Set the custom text for the button
        title: 'Daftar Aduan Selesai', // Set the title for the Excel sheet
        className: 'btn btn-primary' // Add Bootstrap 5 button classes
      }],
    });

    // Add a click event handler for the export button
    $('#export-excel').on('click', function() {
      table.buttons('excel').trigger(); // Trigger the Excel export action
    });
  });
</script>