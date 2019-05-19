<div class="container-fluid">
  <div class="row page-titles">
      <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Tambah Barang Keluar</h4>
      </div>
      <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#/barang_keluar">Barang Keluar</a></li>
            <li class="breadcrumb-item active">Tambah Barang Keluar</li>
          </ol>
        </div>
      </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <form class="form-horizontal" method="post" id="form_add" enctype="multipart/form-data">
            <div class="form-group">
              <label style="margin-left: 10px; margin-bottom: 5px;">Pilih Customer</label>
              <div class="input-group">
                <input type="hidden" name="id_customer" id="id_customer">
                <input type="text" class="form-control" name="nama_customer" id="nama_customer" placeholder="-- Pilih Customer --" readonly>
                <div class="input-group-append">
                  <span class="input-group-text bg-info text-white" id="modal_customer" style="cursor: pointer;">Cari</span>
                </div>
              </div>
              <br>

              <div class="form-group">
                <label style="margin-left: 10px; margin-bottom: 5px;">Alamat Pengiriman</label>
                <textarea class="form-control" id="alamat_kirim" name="alamat_kirim" rows="8" cols="80" placeholder="Alamat Pengiriman"></textarea>
              </div>

              <div class="form-group">
                <label style="margin-left: 10px; margin-bottom: 5px;">Ekspedisi</label>
                <input type="text" class="form-control" name="ekspedisi" id="ekspedisi">
              </div>

              <div class="form-group">
                <label style="margin-left: 10px; margin-bottom: 5px;">No. Truk</label>
                <input type="text" class="form-control" name="no_truk" id="no_truk">
              </div>

              <div class="form-group">
                <label style="margin-left: 10px; margin-bottom: 5px;">No. Invoice</label>
                <input type="text" class="form-control" name="ref_id" id="ref_id">
              </div>

              <label style="margin-left: 10px; margin-bottom: 5px;">Pilih Pesanan</label>
              <div class="input-group">
                <input type="text" class="form-control" name="no_sp" id="no_pesanan" placeholder="-- Pilih Pesanan --" readonly>
                <div class="input-group-append">
                  <span class="input-group-text bg-info text-white" id="modal_pesanan" style="cursor: pointer;">Cari</span>
                </div>
              </div>
              <br>

              <div class="row">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <label style="margin-left: 10px; margin-bottom: 5px;">Detail Barang Keluar</label>
                    <table class="table table-bordered" id="detail_keluar">
                      <thead>
                        <th>No Identifikasi</th>
                        <th>Qty</th>
                        <th> <button type="button" class="btn btn-sm btn-info" id="modal_stok"> <i class="fa fa-plus"></i> </button> </th>
                      </thead>
                      <tbody>

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <center><button type="submit" id="submit_add" class="btn btn-info waves-effect">Tambah</button></center>
          </form>
        </div>
      </div>
    </div>
  </div>
  </div>
</div>

<div id="lookup_customer" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myLargeModalLabel">Pilih Customer</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body form-group">
        <div class="table-responsive m-t-40">
          <table class="table table-striped table-hover" id="t_customer">
            <thead>
              <th>Nama Customer</th>
              <th>Telepon</th>
              <th>Fax</th>
              <th>Email</th>
              <th>Alamat</th>
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

<div id="lookup_pesanan" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myLargeModalLabel">Pilih Pesanan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body form-group">
        <div class="table-responsive m-t-40">
          <table class="table table-striped table-hover" id="t_pesanan">
            <thead>
              <th>No. Pesanan</th>
              <th>Tgl. Pesanan</th>
              <th>Tgl. Pengiriman</th>
              <th>Nama Customer</th>
              <th>Alamat Pengiriman</th>
              <th>Nama Admin</th>
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

<div id="lookup_stok" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myLargeModalLabel">Pilih Stok</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body form-group">
        <div class="table-responsive m-t-40">
          <table class="table table-striped table-hover" id="t_stok">
            <thead>
              <th>No. Identifikasi</th>
              <th>Ket. Stok</th>
              <th>Saldo Awal</th>
              <th>No. Persediaan</th>
              <th>Nama Persediaan</th>
              <th>Satuan</th>
              <th>Warna</th>
              <th>Ket. Barang</th>
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

    var tables = $('#t_customer').DataTable({
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
        info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ Customer',
        zeroRecords: 'Customer tidak ditemukan',
        infoEmpty: 'Menampilkan 0 sampai 0 dari _TOTAL_ Customer',
        loadingRecords: '<i class="fa fa-refresh fa-spin"></i>',
        processing: 'Memuat....',
        infoFiltered: ''
      },
      responsive: true,
      processing: true,
      ajax: '<?= base_url('api/customer/show/'); ?>'+auth.token,
      columns: [
        {"data": 'nama_customer'},
        {"data": 'telepon'},
        {"data": 'fax'},
        {"data": 'email'},
        {"data": 'alamat'},
        {"data": null, 'render': function(data, type, row){
          return `<button class="btn btn-info" id="pilih_customer" data-id="${row.id_customer}" data-nama="${row.nama_customer}"> Pilih</button>`
          }
        }
      ],
      order: [[0, 'desc']]
    })

    $('#modal_customer').on('click', function(){
      $('#lookup_customer').modal('show');
    })

    $('#t_customer').on('click', '#pilih_customer', function(){
      var id_customer = $(this).attr('data-id');
      var nama_customer = $(this).attr('data-nama');

      $('#id_customer').val(id_customer);
      $('#nama_customer').val(nama_customer);

      $('#lookup_customer').modal('hide');
    })

    var table = $('#t_pesanan').DataTable({
      columnDefs: [{
        targets: [0, 2, 3, 4, 5, 6],
        searchable: false
      }, {
        targets: [6],
        orderable: false
      }],
      autoWidth: false,
      language: {
        search: '<span>Cari (Nomor Pesanan) :</span>_INPUT_',
        lengthMenu: '<span>Tampilkan: </span>_MENU_',
        paginate: {'next': 'Berikutnya', 'previous': 'Sebelumnya'},
        info: 'Menampilkan  _START_ sampai _END_ dari _TOTAL_ Pesanan',
        zeroRecords: 'Pesanan tidak ditemukan',
        infoEmpty: 'Menampilkan 0 sampai 0 dari _TOTAL_ Pesanan',
        loadingRecords: '<i class="fas fa-redo-alt fa-spin"></i>',
        processing: '<i class="fas fa-redo-alt fa-spin"></i>',
        infoFiltered: ''
      },
      responsive: true,
      processing: true,
      ajax: '<?= base_url('api/pesanan/show/'); ?>'+auth.token,
      columns: [
        {"data": 'no_pesanan'},
        {"data": 'tgl_pesanan'},
        {"data": 'tgl_kirim'},
        {"data": 'nama_customer'},
        {"data": 'alamat_kirim'},
        {"data": 'nama_user'},
        {"data": null, 'render': function(data, type, row){
          return `<button class="btn btn-info" id="pilih_pesanan" data-id="${row.no_pesanan}"> Pilih</button>`
          }
        }
      ],
      order: [[0, 'desc']]
    })

    $('#modal_pesanan').on('click', function(){
      $('#lookup_pesanan').modal('show');
    })

    $('#t_pesanan').on('click', '#pilih_pesanan', function(){
      var no_pesanan = $(this).attr('data-id');

      $('#no_pesanan').val(no_pesanan);

      $('#lookup_pesanan').modal('hide');
    })

    var table = $('#t_stok').DataTable({
      columnDefs: [{
        targets: [0, 2, 3, 4, 5, 6, 7, 8],
        searchable: false
      }, {
        targets: [8],
        orderable: false
      }],
      autoWidth: false,
      language: {
        search: '<span>Cari (Nomor Identifikasi) :</span>_INPUT_',
        lengthMenu: '<span>Tampilkan: </span>_MENU_',
        paginate: {'next': 'Berikutnya', 'previous': 'Sebelumnya'},
        info: 'Menampilkan  _START_ sampai _END_ dari _TOTAL_ Data',
        zeroRecords: 'Data tidak ditemukan',
        infoEmpty: 'Menampilkan 0 sampai 0 dari _TOTAL_ Data',
        loadingRecords: '<i class="fas fa-redo-alt fa-spin"></i>',
        processing: '<i class="fas fa-redo-alt fa-spin"></i>',
        infoFiltered: ''
      },
      responsive: true,
      processing: true,
      ajax: '<?= base_url('api/stock/show/'); ?>'+auth.token,
      columns: [
        {"data": 'no_identifikasi'},
        {"data": 'ket_stock'},
        {"data": 'saldo_awal'},
        {"data": 'no_persediaan'},
        {"data": 'nama_persediaan'},
        {"data": 'satuan'},
        {"data": 'warna'},
        {"data": 'ket_barang'},
        {"data": null, 'render': function(data, type, row){
          return `<button class="btn btn-info" id="pilih_stok" data-id="${row.id_identifikasi}" data-nama="${row.no_identifikasi}"> Pilih</button>`
          }
        }
      ],
      order: [[0, 'desc']]
    })

    $('#modal_stok').on('click', function(){
      $('#lookup_stok').modal('show');
    })

    $('#t_stok').on('click', '#pilih_stok', function(){
      var id_identifikasi = $(this).attr('data-id')
      var no_identifikasi = $(this).attr('data-nama')

      var html = `<tr id="baris${id_identifikasi}">`

      html+=`<td>${no_identifikasi} <input type="hidden" name="id_identifikasi[]" value="${id_identifikasi}"></td>`
      html+=`<td><input type="text" class="form-control" name="qty_keluar[]" placeholder="Qty" required></td>`
      html+=`<td><button type="button" class="btn btn-danger remove" id="${id_identifikasi}"><i class="fa fa-trash"></i></button></td>`
      html+=`</tr>`

      $('#detail_keluar').append(html)
    })

    $(document).on('click', '.remove', function(){
      var id = $(this).attr('id')

      $('#baris'+id+'').remove()
    })

    $('#form_add').on('submit', function(e){
      e.preventDefault()

      var id_customer = $('#id_customer').val()
      var alamat_kirim = $('#alamat_kirim').val()
      var ekspedisi = $('#ekspedisi').val()
      var no_truk = $('#no_truk').val()
      var ref_id = $('#ref_id').val()
      var no_pesanan = $('#no_pesanan').val()
      var detail = $('#detail_keluar tbody tr').length

      if(id_customer === '' || alamat_kirim === '' || ekspedisi === '' || no_truk === '' || ref_id === ''){
        Swal.fire({
          position: 'center',
          type: 'warning',
          title: 'Data tidak boleh kosong',
          showConfirmButton: false,
          timer: 1500
        });
      } else {
        if(detail<1) {
          Swal.fire({
            position: 'center',
            type: 'warning',
            title: 'Detail tidak boleh kosong',
            showConfirmButton: false,
            timer: 1500
          });
        } else {
          $.ajax({
            url: '<?= base_url('api/barang_keluar/add/') ?>'+auth.token,
            type: 'POST',
            dataType: 'JSON',
            beforeSend: function(){
              $('#submit_add').addClass('disabled').attr('disabled', 'disabled').html('<i class="fa fa-fw fa-spinner fa-spin"></i>');
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
                $('#form_add')[0].reset();
                location.hash = '#/barang_keluar';
              } else {
                Swal.fire({
                  position: 'center',
                  type: 'error',
                  title: response.message,
                  showConfirmButton: false,
                  timer: 1500
                });
                $('#submit_add').removeClass('disabled').removeAttr('disabled', 'disabled').text('Tambah');
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
              $('#submit_add').removeClass('disabled').removeAttr('disabled', 'disabled').text('Tambah')
            }
          })
        }
      }
    })

  })

</script>
