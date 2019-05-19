<div class="container-fluid">
  <div class="row page-titles">
      <div class="col-md-5 align-self-center">
          <h4 class="text-themecolor">Ubah Stok</h4>
      </div>
      <div class="col-md-7 align-self-center text-right">
          <div class="d-flex justify-content-end align-items-center">
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="#/stok">Stok</a></li>
                  <li class="breadcrumb-item active">Ubah Stok</li>
              </ol>
          </div>
      </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <form class="form-horizontal" method="post" id="form_edit" enctype="multipart/form-data">
            <div class="form-group">
              <div class="input-group">
                <input type="hidden" name="no_persediaan" id="edit_no_persediaan">
                <input type="text" class="form-control" name="nama_persediaan" id="nama_persediaan" placeholder="-- Pilih Persediaan --" readonly>
                <div class="input-group-append">
                  <span class="input-group-text bg-info text-white" id="modal_persediaan">Cari</span>
                </div>
              </div>
              <br>

              <div class="form-group">
                <input type="text" class="form-control" name="no_identifikasi" id="edit_no_identifikasi" placeholder="Nomor Identifikasi">
              </div>

              <div class="form-group">
                <textarea class="form-control" id="edit_keterangan" name="keterangan" rows="8" cols="80" placeholder="Keterangan"></textarea>
              </div>

              <input type="hidden" name="id_identifikasi" id="edit_id">
              <button type="submit" id="submit_edit" class="btn btn-info waves-effect">Simpan</button>
          </form>
        </div>
      </div>
    </div>
  </div>
 </div>
</div>

<div id="lookup_persediaan" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myLargeModalLabel">Pilih Persediaan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body form-group">
        <div class="table-responsive m-t-40">
          <table class="table table-striped table-hover" id="t_persediaan">
            <thead>
              <th>Nama Persediaan</th>
              <th>Satuan</th>
              <th>Warna</th>
              <th>Keterangan</th>
              <th>Foto</th>
              <th></th>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">

  $(document).ready(function(){

    var session = localStorage.getItem('sipb');
    var auth = JSON.parse(session);
    var id_identifikasi = location.hash.substr(12);

    $.ajax({
      url: `<?= base_url('api/stock/show/') ?>${auth.token}?id_identifikasi=${id_identifikasi}`,
      type: 'GET',
      dataType: 'JSON',
      success: function(response){
        $.each(response.data, function(k, v){
          $('#edit_no_persediaan').val(v.no_persediaan);
          $('#nama_persediaan').val(v.nama_persediaan);
          $('#edit_no_identifikasi').val(v.no_identifikasi);
          $('#edit_keterangan').val(v.ket_stock);
        })
      },
      error: function(){
        Swal.fire({
          position: 'center',
          type: 'warning',
          title: response.message,
          showConfirmButton: false,
          timer: 1500
        });
      }
    });

    $('#form_edit').on('submit', function(e){
      e.preventDefault();

      var no_persediaan = $('#edit_no_persediaan').val();
      var nama_persediaan = $('#nama_persediaan').val();
      var no_identifikasi = $('#edit_no_identifikasi').val();
      var keterangan = $('#edit_keterangan').val();

      if(no_persediaan === '' || nama_persediaan === '' || no_identifikasi === '' || keterangan === ''){
        Swal.fire({
          position: 'center',
          type: 'warning',
          title: 'Data tidak boleh kosong',
          showConfirmButton: false,
          timer: 1500
        });
      } else {
        $.ajax({
          url: `<?= base_url('api/stock/edit/') ?>${auth.token}?id_identifikasi=${id_identifikasi}`,
          type: 'POST',
          dataType: 'JSON',
          beforeSend: function(){
            $('#submit_edit').addClass('disabled').attr('disabled', 'disabled').html('<i class="fa fa-fw fa-spinner fa-spin"></i>');
          },
          data: $(this).serialize(),
          success: function(response){
            if(response.status === 200){
              Swal.fire({
                position: 'center',
                type: 'success',
                title: response.message,
                showConfirmButton: false,
                timer: 1500
              });
              $('#form_edit')[0].reset();
              location.hash = '#/stok';
            } else {
              Swal.fire({
                position: 'center',
                type: 'warning',
                title: response.message,
                showConfirmButton: false,
                timer: 1500
              });
              $('#submit_edit').removeClass('disabled').removeAttr('disabled', 'disabled').text('Simpan')
            }
          },
          error: function(){
            Swal.fire({
              position: 'center',
              type: 'warning',
              title: 'Tidak dapat mengakses server',
              showConfirmButton: false,
              timer: 1500
            });
            $('#submit_edit').removeClass('disabled').removeAttr('disabled', 'disabled').text('Simpan')
          }
        });
      }
    })

    var tables = $('#t_persediaan').DataTable({
      columnDefs: [{
        targets: [0],
        searchable: true
      }, {
        targets: [5],
        orderable: false
      }],
      autoWidth: false,
      language: {
        search: 'Cari Nama: _INPUT_',
        lengthMenu: 'Tampilkan: _MENU_',
        paginate: {'next': 'Berikutnya', 'previous': 'Sebelumnya'},
        info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ Persediaan',
        zeroRecords: 'Persediaan tidak ditemukan',
        infoEmpty: 'Menampilkan 0 sampai 0 dari _TOTAL_ Persediaan',
        loadingRecords: '<i class="fa fa-refresh fa-spin"></i>',
        processing: 'Memuat....',
        infoFiltered: ''
      },
      responsive: true,
      processing: true,
      ajax: '<?= base_url('api/barang/show/'); ?>'+auth.token,
      columns: [
        {"data": 'nama_persediaan'},
        {"data": 'satuan'},
        {"data": 'warna'},
        {"data": 'keterangan'},
        {"data": null, 'render': function(data, type, row){
          return `<center><img src="<?= base_url('doc/barang/') ?>${row.foto}" style="width: 50%;"></center>`
        }
      },
      {"data": null, 'render': function(data, type, row){
        return `<button class="btn btn-info" id="pilih_persediaan" data-id="${row.no_persediaan}" data-nama="${row.nama_persediaan}"> Pilih</button>`
        }
      }
    ],
    order: [[0, 'desc']]
    })

    $('#modal_persediaan').on('click', function(){
      $('#lookup_persediaan').modal('show');
    })

    $('#t_persediaan').on('click', '#pilih_persediaan', function(){
      var no_persediaan = $(this).attr('data-id');
      var nama_persediaan = $(this).attr('data-nama');

      $('#no_persediaan').val(no_persediaan);
      $('#nama_persediaan').val(nama_persediaan);

      $('#lookup_persediaan').modal('hide');
    })

  })


</script>
