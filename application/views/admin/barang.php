<div class="container-fluid">
  <div class="row page-titles">
      <div class="col-md-5 align-self-center">
          <h4 class="text-themecolor">Barang</h4>
      </div>
      <div class="col-md-7 align-self-center text-right">
          <div class="d-flex justify-content-end align-items-center">
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
                  <li class="breadcrumb-item active">Barang</li>
              </ol>
              <button type="button" id="btn_add" class="btn btn-info d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Tambah Baru</button>
          </div>
      </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header" style="background-color: #d63b70">
          <h4 class="m-b-0 text-white">Data Barang</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="table_barang" class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>Tgl. Input</th>
                  <th>Kode Barang</th>
                  <th>Nama Barang</th>
                  <th>Satuan</th>
                  <th>Warna</th>
                  <th>Keterangan</th>
                  <th>Barang Masuk</th>
                  <th>Barang Keluar</th>
                  <th>Sisa Stock</th>
                  <th>Foto</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="modal_add" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="vcenter">Tambah Barang</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>

      <form class="form-horizontal" method="post" id="form_add" enctype="multipart/form-data">
        <div class="modal-body form-group">
          <div class="form-group">
            <input type="text" class="form-control" name="no_persediaan" id="no_persediaan" placeholder="Kode Barang">
          </div>

          <div class="form-group">
            <input type="text" class="form-control" name="nama_persediaan" id="nama_persediaan" placeholder="Nama Barang">
          </div>

          <div class="form-group">
            <input type="text" class="form-control" name="satuan" id="satuan" placeholder="Satuan">
          </div>

          <div class="form-group">
            <input type="text" class="form-control" name="warna" id="warna" placeholder="Warna">
          </div>

          <div class="form-group">
            <textarea class="form-control" id="keterangan" name="keterangan" rows="8" cols="80" placeholder="Keterangan"></textarea>
          </div>

          <div class="form-group">
            <label> Foto</label>
            <br>
            <input type="file" name="foto" id="foto">
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" id="submit_add" class="btn btn-info waves-effect">Tambah</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="modal_edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="vcenter">Ubah Barang</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>

      <form class="form-horizontal" method="post" id="form_edit" enctype="multipart/form-data">
        <div class="modal-body form-group">
          <div class="form-group">
            <input type="text" class="form-control" name="nama_persediaan" id="edit_nama_persediaan" placeholder="Nama Barang">
          </div>

          <div class="form-group">
            <input type="text" class="form-control" name="satuan" id="edit_satuan" placeholder="Satuan">
          </div>

          <div class="form-group">
            <input type="text" class="form-control" name="warna" id="edit_warna" placeholder="Warna">
          </div>

          <div class="form-group">
            <textarea class="form-control" id="edit_keterangan" name="keterangan" rows="8" cols="80" placeholder="Keterangan"></textarea>
          </div>

          <div class="form-group">
            <label> Foto</label>
            <br>
            <input type="file" name="foto" id="edit_foto">
          </div>
        </div>

        <div class="modal-footer">
          <input type="hidden" name="no_persediaan" id="edit_id">
          <button type="submit" id="submit_edit" class="btn btn-info waves-effect">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">

  $(document).ready(function(){

    var session = localStorage.getItem('sipb');
    var auth = JSON.parse(session);

    $('#btn_add').on('click', function(){
      $('#modal_add').modal('show');
    })

    $('#form_add').on('submit', function(e){
      e.preventDefault();

      var no_persediaan = $('#no_persediaan').val();
      var nama_persediaan = $('#nama_persediaan').val();
      var satuan = $('#satuan').val();
      var warna = $('#warna').val();
      var keterangan = $('#keterangan').val();

      if (no_persediaan === '' || nama_persediaan === '' || satuan === '' || warna=== '' || keterangan === ''){
        Swal.fire({
          position: 'center',
          type: 'warning',
          title: 'Data tidak boleh kosong',
          showConfirmButton: false,
          timer: 1500
        });
      } else {
        $.ajax({
          url: '<?= base_url('api/barang/add/'); ?>'+auth.token,
          type: 'POST',
          dataType: 'JSON',
          beforeSend: function(){
            $('#submit_add').addClass('disabled').attr('disabled', 'disabled').html('<i class="fa fa-fw fa-spinner fa-spin"></i>');
          },
          data: new FormData(this),
          processData: false,
          contentType: false,
          success: function(response){
            if(response.status === 200){
              Swal.fire({
                position: 'center',
                type: 'success',
                title: response.message,
                showConfirmButton: false,
                timer: 1500
              });
              $('#modal_add').modal('hide');
              $('#form_add')[0].reset();
              table.ajax.reload();
            } else {
              Swal.fire({
                position: 'center',
                type: 'warning',
                title: response.message,
                showConfirmButton: false,
                timer: 1500
              });
            }
            $('#submit_add').removeClass('disabled').removeAttr('disabled', 'disabled').text('Tambah')
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
        });
      }
    });

    var table = $('#table_barang').DataTable({
      columnDefs: [{
        targets: [0, 1, 4, 5, 6, 7],
        searchable: false
      }, {
        targets: [7],
        orderable: false
      }],
      autoWidth: false,
      language: {
        search: 'Cari (Kode/Nama Barang): _INPUT_',
        lengthMenu: 'Tampilkan: _MENU_',
        paginate: {'next': 'Berikutnya', 'previous': 'Sebelumnya'},
        info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ Barang',
        zeroRecords: 'Barang tidak ditemukan',
        infoEmpty: 'Menampilkan 0 sampai 0 dari _TOTAL_ Barang',
        loadingRecords: '<i class="fa fa-refresh fa-spin"></i>',
        processing: 'Memuat....',
        infoFiltered: ''
      },
      responsive: true,
      processing: true,
      ajax: {
        url : '<?= base_url('api/barang/show/'); ?>'+auth.token,
        dataSrc: function(res){
          return res.data;
        }
      },
      columns: [
        {"data": 'tgl_input'},
        {"data": 'no_persediaan'},
        {"data": 'nama_persediaan'},
        {"data": 'satuan'},
        {"data": 'warna'},
        {"data": 'keterangan'},
        {"data": null, 'render': function(data, type, row){
          return `${row.barang_masuk ? row.barang_masuk : 0}`
          }
        },
        {"data": null, 'render': function(data, type, row){
          return `${row.barang_keluar ? row.barang_keluar : 0}`
          }
        },
        {"data": null, 'render': function(data, type, row){
          return `${row.sisa_stock ? row.sisa_stock : 0}`
          }
        },
        {"data": null, 'render': function(data, type, row){
          return `<center><a href="<?= base_url('doc/barang/') ?>${row.foto}" target="_blank"><img src="<?= base_url('doc/barang/') ?>${row.foto}" style="width: 75px; height: 75px;"></a></center>`
          }
        },
        {"data": null, 'render': function(data, type, row){
          return `<button class="btn btn-info" id="edit_barang" data-id="${row.no_persediaan}"><i class="far fa-edit"></i></button> <button class="btn btn-danger" style="margin-left: 5px;" id="hapus_barang" data-id="${row.no_persediaan}" data-nama="${row.nama_persediaan}"><i class="fas fa-trash"></i></button>`
          }
        }
      ],
      order: [[0, 'desc']]
    });

    $(document).on('click', '#hapus_barang', function(){
      var no_persediaan = $(this).attr('data-id');
      var nama_persediaan = $(this).attr('data-nama')

      Swal.fire({
        title: `Apa Anda yakin ingin menghapus ${nama_persediaan}?`,
        text: "Barang akan terhapus secara permanen",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Saya yakin.',
        cancelButtonText: 'Batal',
        showLoaderOnConfirm: true
      }).then((result) => {
        if (result.value) {
          $.ajax({
            url: `<?= base_url('api/barang/delete/'); ?>${auth.token}?no_persediaan=${no_persediaan}`,
            type: 'GET',
            dataType: 'JSON',
            success: function(response){
              if(response.status === 200){
                Swal.fire({
                  position: 'center',
                  type: 'success',
                  title: response.message,
                  showConfirmButton: false,
                  timer: 1500
                });
                table.ajax.reload();
              } else {
                Swal.fire({
                  position: 'center',
                  type: 'error',
                  title: response.message,
                  showConfirmButton: false,
                  timer: 1500
                });
              }
            },
            error: function(){
              Swal.fire({
                position: 'center',
                type: 'error',
                title: 'Tidak dapat mengakses server',
                showConfirmButton: false,
                timer: 1500
              });
            }
          });
        }
      })
    });

    $(document).on('click', '#edit_barang', function(){
      var no_persediaan = $(this).attr('data-id');

      $.ajax({
        url: `<?= base_url('api/barang/show/') ?>${auth.token}?no_persediaan=${no_persediaan}`,
        type: 'GET',
        dataType: 'JSON',
        success: function(response){
          $.each(response.data, function(k, v){
            $('#modal_edit').modal('show');
            $('#edit_nama_persediaan').val(v.nama_persediaan);
            $('#edit_satuan').val(v.satuan);
            $('#edit_warna').val(v.warna);
            $('#edit_keterangan').val(v.keterangan);
            $('#edit_id').val(v.no_persediaan);
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
    });

    $('#form_edit').on('submit', function(e){
      e.preventDefault();

      var satuan = $('#edit_satuan').val();
      var warna = $('#edit_warna').val();
      var keterangan = $('#edit_keterangan').val();
      var no_persediaan = $('#edit_id').val();

      if(satuan === '' || warna === '' || keterangan === ''){
        Swal.fire({
          position: 'center',
          type: 'warning',
          title: 'Data tidak boleh kosong',
          showConfirmButton: false,
          timer: 1500
        });
      } else {
        $.ajax({
          url: `<?= base_url('api/barang/edit/') ?>${auth.token}?no_persediaan=${no_persediaan}`,
          type: 'POST',
          dataType: 'JSON',
          beforeSend: function(){
            $('#submit_edit').addClass('disabled').attr('disabled', 'disabled').html('<i class="fa fa-fw fa-spinner fa-spin"></i>');
          },
          data: new FormData(this),
          processData: false,
          contentType: false,
          success: function(response){
            if(response.status === 200){
              Swal.fire({
                position: 'center',
                type: 'success',
                title: response.message,
                showConfirmButton: false,
                timer: 1500
              });
              $('#modal_edit').modal('hide');
              $('#form_edit')[0].reset();
              table.ajax.reload();
            } else {
              Swal.fire({
                position: 'center',
                type: 'warning',
                title: response.message,
                showConfirmButton: false,
                timer: 1500
              });
            }
            $('#submit_edit').removeClass('disabled').removeAttr('disabled', 'disabled').text('Simpan')
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
    });

    // $('#table_barang tbody').on('click', 'td.details-control', function(){
    //   var tr = $(this).closest('tr');
    //   var row = table.row(tr);

    //   if(row.child.isShown() ){
    //     row.child.hide();
    //     tr.removeClass('shown');
    //   } else {
    //     row.child(format(row.data())).show();
    //     tr.addClass('shown');
    //   }
    // })

    // var pusher = new Pusher('6a169a704ab461b9a26a', {
    //   cluster: 'ap1',
    //   forceTLS: true
    // });
    //
    // var channel = pusher.subscribe('sipb');
    // channel.bind('barang', function(data) {
    //   table.ajax.reload();
    // });

  });

</script>
