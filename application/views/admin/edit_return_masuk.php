<div class="container-fluid">
  <div class="row page-titles">
      <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Ubah Return Pelanggan</h4>
      </div>
      <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#/return_masuk">Return Pelanggan</a></li>
            <li class="breadcrumb-item active">Ubah Return Pelanggan</li>
          </ol>
        </div>
      </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header" style="background-color: #d63b70">
          <h4 class="m-b-0 text-white">Form Return Pelanggan</h4>
        </div>
        <div class="card-body">
          <form class="form-horizontal" method="post" id="form_edit" enctype="multipart/form-data">
            <div class="form-group">
              <label style="margin-left: 10px; margin-bottom: 5px;">No. Ref</label>
              <input type="text" class="form-control" id="no_ref" name="no_ref" rows="8" cols="80" placeholder="No. Ref">
            </div>

            <label style="margin-left: 10px; margin-bottom: 5px;">Pilih Pelanggan</label>
            <div class="input-group">
              <input type="hidden" name="id_customer" id="id_customer">
              <input type="text" class="form-control" name="nama_customer" id="nama_customer" placeholder="-- Pilih Pelanggan --" readonly>
              <div class="input-group-append">
                <span class="input-group-text bg-info text-white" id="modal_customer" style="cursor: pointer;">Cari</span>
              </div>
            </div>
            <br>

            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <label style="margin-left: 10px; margin-bottom: 5px;">Stok</label>
                  <table class="table table-bordered" id="stok">
                    <thead>
                      <th>No Identifikasi</th>
                      <th>No Persediaan</th>
                      <th>Qty</th>
                      <th> <button type="button" class="btn btn-sm btn-info" id="modal_stok"> <i class="fa fa-plus"></i> </button> </th>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <center><button type="submit" id="submit_edit" class="btn btn-info waves-effect">Simpan</button></center>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="lookup_customer" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myLargeModalLabel">Pilih Pelanggan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body form-group">
        <div class="table-responsive m-t-40">
          <table class="table table-striped table-hover" id="t_customer">
            <thead>
              <th>Nama Pelanggan</th>
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
              <th>Kode Barang</th>
              <th>Nama Barang</th>
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

    var session = localStorage.getItem('sipb')
    var auth = JSON.parse(session);
    var no_return_masuk = location.hash.substr(20);

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
          return `<button class="btn btn-info" id="pilih_stok" data-id="${row.id_identifikasi}" data-barang="${row.no_persediaan}" data-nama="${row.no_identifikasi}"> Pilih</button>`
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
      var no_persediaan = $(this).attr('data-barang');
      var no_identifikasi = $(this).attr('data-nama')

      var html = `<tr id="baris${id_identifikasi}">`

      html+=`<td>${no_identifikasi} <input type="hidden" name="id_identifikasi[]" value="${id_identifikasi}"></td>`
      html+=`<td>${no_persediaan}</td>`
      html+=`<td><input type="text" class="form-control" name="qty_return_masuk[]" placeholder="Qty" required></td>`
      html+=`<td><button type="button" class="btn btn-danger remove" id="${id_identifikasi}"><i class="fa fa-trash"></i></button></td>`
      html+=`</tr>`

      $('#stok tbody').append(html)
      $('#lookup_stok').modal('hide')
    })

    $(document).on('click', '.remove', function(){
      var id = $(this).attr('id')

      $('#baris'+id+'').remove()
    })

    $.ajax({
      url: `<?= base_url('api/return_masuk/detail/') ?>${auth.token}?no_return_masuk=${no_return_masuk}`,
      type: 'GET',
      dataType: 'JSON',
      success: function(response){
        $.each(response.data, function(k, v){
          $('#no_ref').val(v.no_ref)
          $('#id_customer').val(v.id_customer)
          $('#nama_customer').val(v.nama_customer)

          var html = ''

          $.each(v.detail, function(k1, v1){
            html+= `<tr id="baris${v1.id_identifikasi}">`

            html+=`<td>${v1.no_identifikasi} <input type="hidden" name="id_identifikasi[]" value="${v1.id_identifikasi}"></td>`
            html+=`<td>${v1.no_persediaan}</td>`
            html+=`<td><input type="text" class="form-control" value="${v1.qty_return_masuk}" name="qty_return_masuk[]" placeholder="Qty" required></td>`
            html+=`<td><button type="button" class="btn btn-danger remove" id="${v1.id_identifikasi}"><i class="fa fa-trash"></i></button></td>`
            html+=`</tr>`

            $('#stok tbody').html(html)
          })
        })
      },
      error: function(){
        Swal.fire({
          position: 'center',
          type: 'warning',
          title: 'Tidak dapat mengakses server',
          showConfirmButton: false,
          timer: 1500
        });
      }
    })

    $('#form_edit').on('submit', function(e){
      e.preventDefault();

      var no_ref = $('#no_ref').val()
      var id_customer = $('#id_customer').val()
      var stok = $('#stok tbody tr').length

      if(no_ref === '' || id_customer === ''){
        Swal.fire({
          position: 'center',
          type: 'warning',
          title: 'Data tidak boleh kosong',
          showConfirmButton: false,
          timer: 1500
        });
      } else {
        if(stok<1) {
          Swal.fire({
            position: 'center',
            type: 'warning',
            title: 'Detail tidak boleh kosong',
            showConfirmButton: false,
            timer: 1500
          });
      } else {
          $.ajax({
            url: `<?= base_url('api/return_masuk/edit/') ?>${auth.token}?no_return_masuk=${no_return_masuk}`,
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
                location.hash = '#/return_masuk';
              } else {
                Swal.fire({
                  position: 'center',
                  type: 'error',
                  title: response.message,
                  showConfirmButton: false,
                  timer: 1500
                });
                $('#submit_edit').removeClass('disabled').removeAttr('disabled', 'disabled').text('Simpan');
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
          })
        }
      }
    })

  })

</script>
