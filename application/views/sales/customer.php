<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
      <h4 class="text-themecolor">Customer</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
      <div class="d-flex justify-content-end align-items-center">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item active">Customer</li>
        </ol>
        <button type="button" id="btn_add" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Tambah Baru</button>
      </div>
    </div>
  </div>

  <div id="modal_add" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="vcenter">Tambah Customer</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>

        <form class="form-horizontal" method="post" id="form_add">
          <div class="modal-body form-group">
            <div class="form-group">
              <input type="text" class="form-control" name="nama_customer" id="nama_customer" placeholder="Nama Customer">
            </div>

            <div class="form-group">
              <input type="text" class="form-control" name="telepon" id="telepon" placeholder="Telepon / HP">
            </div>

            <div class="form-group">
              <input type="text" class="form-control" name="fax" id="fax" placeholder="Fax">
            </div>

            <div class="form-group">
              <input type="email" class="form-control" name="email" id="email" placeholder="Email">
            </div>

            <div class="form-group">
              <textarea class="form-control" name="alamat" id="alamat" rows="8" cols="80" placeholder="Alamat"></textarea>
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
          <h4 class="modal-title" id="vcenter">Ubah Customer</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>

        <form class="form-horizontal" method="post" id="form_edit">
          <div class="modal-body form-group">
            <div class="form-group">
              <input type="text" class="form-control" name="nama_customer" id="edit_nama_customer" placeholder="Nama Customer">
            </div>

            <div class="form-group">
              <input type="text" class="form-control" name="telepon" id="edit_telepon" placeholder="Telepon / HP">
            </div>

            <div class="form-group">
              <input type="text" class="form-control" name="fax" id="edit_fax" placeholder="Fax">
            </div>

            <div class="form-group">
              <input type="email" class="form-control" name="email" id="edit_email" placeholder="Email">
            </div>

            <div class="form-group">
              <textarea class="form-control" name="alamat" id="edit_alamat" rows="8" cols="80" placeholder="Alamat"></textarea>
            </div>
          </div>

          <div class="modal-footer">
            <input type="hidden" name="id_customer" id="edit_id" value="">
            <button type="submit" id="submit_edit" class="btn btn-info waves-effect">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Data Supplier</h4>
          <div class="table-responsive m-t-40">
            <table id="t_customer" class="table table-striped">
              <thead>
                <tr>
                  <th>Tgl Input</th>
                  <th>Nama Customer</th>
                  <th>Telepon</th>
                  <th>Fax</th>
                  <th>Email</th>
                  <th>Alamat</th>
                  <th style="width: 12%;"></th>
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

<script type="text/javascript">

  $(document).ready(function(){

    var session = localStorage.getItem('sipb');
    var auth = JSON.parse(session);

    $('#btn_add').on('click', function(){
      $('#modal_add').modal('show');
    })

    $('#form_add').on('submit', function(e){
      e.preventDefault();

      var nama_customer = $('#nama_customer').val();
      var telepon = $('#telepon').val();
      var fax = $('#fax').val();
      var email = $('#email').val();
      var alamat = $('#alamat').val();

      if (nama_customer === '' || telepon === '' || fax === '' || email === '' || alamat === ''){
        Swal.fire({
          position: 'center',
          type: 'warning',
          title: 'Data belum lengkap',
          showConfirmButton: false,
          timer: 1500
        });
      } else {
        $.ajax({
          url: '<?= base_url('api/customer/add/'); ?>'+auth.token,
          type: 'POST',
          dataType: 'JSON',
          beforeSend: function(){
            $('#submit_add').addClass('disabled').attr('disabled', 'disabled').html('<i class="fa fa-fw fa-spinner fa-spin"></i>');
          },
          data: {
            nama_customer: nama_customer,
            telepon: telepon,
            fax: fax,
            email: email,
            alamat: alamat
          },
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

    var table = $('#t_customer').DataTable({
      columnDefs: [{
        targets: [0, 2, 3, 4, 5],
        searchable: false
      }, {
        targets: [5],
        orderable: false
      }],
      autoWidth: false,
      language: {
        search: 'Cari (Nama Customer): _INPUT_',
        lengthMenu: 'Tampilkan: _MENU_',
        paginate: {'next': 'Berikutnya', 'previous': 'Sebelumnya'},
        info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ Data',
        zeroRecords: 'Data tidak ditemukan',
        infoEmpty: 'Menampilkan 0 sampai 0 dari _TOTAL_ Data',
        loadingRecords: '<i class="fa fa-refresh fa-spin"></i>',
        processing: 'Memuat....',
        infoFiltered: ''
      },
      responsive: true,
      processing: true,
      ajax: '<?= base_url('api/customer/show/'); ?>'+auth.token,
      columns: [
        {"data": 'tgl_input'},
        {"data": 'nama_customer'},
        {"data": 'telepon'},
        {"data": 'fax'},
        {"data": 'email'},
        {"data": 'alamat'},
        {"data": null, 'render': function(data, type, row){
          return `<button class="btn btn-info" id="edit_customer" data-id="${row.id_customer}"><i class="far fa-edit"></i></button> <button class="btn btn-danger" style="margin-left: 5px;" id="hapus_customer" data-id="${row.id_customer}"><i class="fas fa-trash"></i></button>`
          }
        }
      ],
      order: [[0, 'desc']]
    });

    $(document).on('click', '#edit_customer', function(){
      var id_customer = $(this).attr('data-id');

      $.ajax({
        url: `<?= base_url('api/customer/show/') ?>${auth.token}?id_customer=${id_customer}`,
        type: 'GET',
        dataType: 'JSON',
        success: function(response){
          $.each(response.data, function(k, v){
            $('#modal_edit').modal('show');
            $('#edit_nama_customer').val(v.nama_customer);
            $('#edit_telepon').val(v.telepon);
            $('#edit_fax').val(v.fax);
            $('#edit_email').val(v.email);
            $('#edit_alamat').val(v.alamat);
            $('#edit_id').val(v.id_customer);
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
      });
    });

    $('#form_edit').on('submit', function(e){
      e.preventDefault();

      var nama_customer = $('#edit_nama_customer').val();
      var telepon = $('#edit_telepon').val();
      var fax = $('#edit_fax').val();
      var email = $('#edit_email').val();
      var alamat = $('#edit_alamat').val();
      var id_customer = $('#edit_id').val();

      if(nama_customer === '' || telepon === '' || fax === '' || email === '' || alamat === ''){
        Swal.fire({
          position: 'center',
          type: 'warning',
          title: 'Data belum lengkap',
          showConfirmButton: false,
          timer: 1500
        });
      } else {
        $.ajax({
          url: `<?= base_url('api/customer/edit/') ?>${auth.token}?id_customer=${id_customer}`,
          type: 'POST',
          dataType: 'JSON',
          beforeSend: function(){
            $('#submit_edit').addClass('disabled').attr('disabled', 'disabled').html('<i class="fa fa-fw fa-spinner fa-spin"></i>');
          },
          data: {
            id_customer: id_customer,
            nama_customer: nama_customer,
            telepon: telepon,
            fax: fax,
            email: email,
            alamat: alamat
          },
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

    $(document).on('click', '#hapus_customer', function(){
      var id_customer = $(this).attr('data-id');

      Swal.fire({
        title: 'Apa Anda yakin ingin menghapus ini?',
        text: "Data akan terhapus secara permanen",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Saya yakin.',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.value) {
          $.ajax({
            url: `<?= base_url('api/customer/delete/'); ?>${auth.token}?id_customer=${id_customer}`,
            type: 'GET',
            dataType: 'JSON',
            success: function(response){
              if(response.status === 200){
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

  })

</script>
