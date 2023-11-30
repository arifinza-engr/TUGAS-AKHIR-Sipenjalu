<!-- refactored -->
<div class="container mt-4">
  <div class="card">
    <div class="card-header bg-infooo">
      <i class="fas fa-book"></i> <!-- FontAwesome 5 update -->
      Data Aduan
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-bordered" id="aduMenunggu">
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

            function get_address_from_latlng($lat, $lng, $api_key)
            {
              $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng&key=$api_key";
              $json_data = file_get_contents($url);
              $result = json_decode($json_data, TRUE);
              return $result['results'][0]['formatted_address'] ?? 'Alamat tidak ditemukan';
            }

            $no = 1;
            $query = "SELECT a.id_pengaduan, a.judul, a.no_telpon, a.foto, a.lat, a.lng, a.status, j.jenis, p.nama_pengadu, p.no_hp 
          FROM tb_pengaduan a 
          JOIN tb_jenis j ON a.jenis=j.id_jenis 
          JOIN tb_pengadu p ON a.author=p.id_pengadu
          WHERE status='Proses'";
            $result = $koneksi->query($query);



            while ($row = $result->fetch_assoc()) {
              echo "<tr class='text-center align-middle'>";
              echo "<td>{$no}</td>";
              echo "<td>{$row['judul']}</td>";
              echo "<td>{$row['no_telpon']}</td>";
              echo "<td>{$row['judul']}</td>";
              echo "<td>{$row['jenis']}</td>";
              $address = get_address_from_latlng($row['lat'], $row['lng'], $api_key);
              echo "<td><a href='https://www.google.com/maps/place/{$row['lat']},{$row['lng']}' target='_blank'>$address</a></td>";
              $imgSrc = "foto/{$row['foto']}";
              echo "<td><img src='{$imgSrc}' width='100px' data-bs-toggle='modal' data-bs-target='#imageModal' onclick='showImage(this.src)' role='button' tabIndex='0' /></td>";

              $status = $row['status'] === 'Proses' ? 'Menunggu' : $row['status'];
              $labelClass = $status === 'Menunggu' ? 'warning' : ($status === 'Tanggapi' ? 'success' : 'primary');
              echo "<td><span class='label label-{$labelClass}'>{$status}</span></td>";

              $manageLink = "?page=aduan_kelola&kode={$row['id_pengaduan']}";
              echo "<td><a href='{$manageLink}' title='Tanggapi' class='btn btn-primary btn-sm'><i class='fas fa-pen'></i></a></td>";
              echo "</tr>";
              $no++;
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


<script>
  $(document).ready(function() {
    var table = $('#aduMenunggu').DataTable({
      dom: 'Bfrtip', // Show buttons in the specified location
      buttons: [{
        extend: 'excel', // Use the Excel export button
        text: 'Export to Excel', // Set the custom text for the button
        title: 'Daftar Aduan Menunggu', // Set the title for the Excel sheet
        className: 'btn btn-primary' // Add Bootstrap 5 button classes
      }],
    });

    // Add a click event handler for the export button
    $('#export-excel').on('click', function() {
      table.buttons('excel').trigger(); // Trigger the Excel export action
    });
  });

  function showImage(src) {
    document.getElementById('imagePreview').src = src;
  }
</script>