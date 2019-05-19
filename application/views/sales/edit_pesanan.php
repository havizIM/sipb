<div class="container-fluid">
  <div class="row page-titles">
      <div class="col-md-5 align-self-center">
          <h4 class="text-themecolor">Ubah Pesanan</h4>
      </div>
      <div class="col-md-7 align-self-center text-right">
          <div class="d-flex justify-content-end align-items-center">
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="#/stok">Pesanan</a></li>
                  <li class="breadcrumb-item active">Ubah Pesanan</li>
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
                <label style="margin-left: 10px; margin-bottom: 5px;">Tanggal Kirim</label>
                <input type="date" class="form-control" name="tgl_kirim" id="tgl_kirim">
              </div>

              <div class="form-group">
                <label style="margin-left: 10px; margin-bottom: 5px;">Alamat Pengiriman</label>
                <textarea class="form-control" id="alamat_kirim" name="alamat_kirim" rows="8" cols="80" placeholder="Alamat Pengiriman"></textarea>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <label style="margin-left: 10px; margin-bottom: 5px;">Detail Pesanan</label>
                    <table class="table table-bordered" id="detail_pesanan">
                      <thead>
                        <th>No Persediaan</th>
                        <th>Keterangan</th>
                        <th>Qty</th>
                        <th> <button type="button" class="btn btn-sm btn-info" id="modal_persediaan"> <i class="fa fa-plus"></i> </button> </th>
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
    var no_pesanan = location.hash.substr(15);

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

      var html = `<tr id="baris${no_persediaan}">`

      html+=`<td>${nama_persediaan} <input type="hidden" name="no_persediaan[]" value="${no_persediaan}"></td>`
      html+=`<td><input type="text" class="form-control" name="keterangan[]" placeholder="Keterangan" required></td>`
      html+=`<td><input type="number" class="form-control" name="qty_pesanan[]" placeholder="Qty" required></td>`
      html+=`<td><button type="button" class="btn btn-danger remove" id="${no_persediaan}"><i class="fa fa-trash"></i></button></td>`
      html+=`</tr>`

      $('#detail_pesanan tbody').append(html)
    })

    $(document).on('click', '.remove', function(){
      var id = $(this).attr('id')

      $('#baris'+id+'').remove();
    })

    $.ajax({
      url: `<?= base_url('api/pesanan/detail/') ?>${auth.token}?no_pesanan=${no_pesanan}`,
      type: 'GET',
      dataType: 'JSON',
      success: function(response){
        $.each(response.data, function(k, v){
          $('#id_customer').val(v.id_customer)
          $('#nama_customer').val(v.nama_customer)
          $('#tgl_kirim').val(v.tgl_kirim)
          $('#alamat_kirim').val(v.alamat_kirim)

          var html = ''

          $.each(v.detail, function(k1, v1){
            html+= `<tr id="baris${v1.no_persediaan}">`

            html+= `<td>${v1.nama_persediaan} <input type="hidden" name="no_persediaan[]" value="${v1.no_persediaan}"></td>`
            html+= `<td><input type="text" class="form-control" value="${v1.keterangan}" name="keterangan[]" placeholder="Keterangan" required></td>`
            html+= `<td><input type="number" class="form-control" value="${v1.qty_pesanan}" name="qty_pesanan[]" placeholder="Qty" required></td>`
            html+= `<td><button type="button" class="btn btn-danger remove" id="${v1.no_persediaan}"><i class="fa fa-trash"></i></button></td>`
            html+= `</tr>`
          })

          $('#detail_pesanan tbody').append(html)
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

      var id_customer = $('#id_customer').val()
      var tgl_kirim = $('#tgl_kirim').val()
      var alamat_kirim = $('#alamat_kirim').val()
      var detail = $('#detail_pesanan tbody tr').length

      if(id_customer === '' || tgl_kirim === '' || alamat_kirim === ''){
        Swal.fire({
          position: 'center',
          type: 'warning',
          title: 'Data tidak boleh kosong',
          showConfirmButton: false,
          timer: 1500
        });
      } else {
        if (detail<1) {
          Swal.fire({
            position: 'center',
            type: 'warning',
            title: 'Detail tidak boleh kosong',
            showConfirmButton: false,
            timer: 1500
          });
        } else {
          $.ajax({
            url: `<?= base_url('api/pesanan/edit/') ?>${auth.token}?no_pesanan=${no_pesanan}`,
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
                location.hash = '#/pesanan';
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
