<div class="container-fluid">
  <div class="row page-titles">
      <div class="col-md-5 align-self-center">
          <h4 class="text-themecolor">User</h4>
      </div>
      <div class="col-md-7 align-self-center text-right">
          <div class="d-flex justify-content-end align-items-center">
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
                  <li class="breadcrumb-item active">User</li>
              </ol>
              <button type="button" id="btn_add" class="btn btn-info d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Tambah User</button>
          </div>
      </div>
  </div>

  <div id="modal_add" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="vcenter">Tambah User</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>

        <form class="form-horizontal" method="post" id="form_add">
          <div class="modal-body form-group">
            <div class="form-group">
              <input type="text" class="form-control" name="nama_user" id="nama_user" placeholder="Nama User">
            </div>

            <div class="form-group">
              <input type="text" class="form-control" name="username" id="username" placeholder="Username">
            </div>

            <div class="form-group">
              <select class="form-control" id="level" name="level">
                <option value="">-- Pilih Level --</option>
                <option value="admin">Admin</option>
                <option value="sales">Sales</option>
                <option value="kepala gudang">Kepala Gudang</option>
                <option value="manager">Manager</option>
              </select>
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
          <h4 class="modal-title" id="vcenter">Ubah User</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>

        <form class="form-horizontal" method="post" id="form_edit">
          <div class="modal-body form-group">
            <div class="form-group">
              <input type="text" class="form-control" name="nama_user" id="edit_nama" placeholder="Nama User">
            </div>

            <div class="form-group">
              <input type="text" class="form-control" name="username" id="edit_username" placeholder="Username">
            </div>

            <div class="form-group">
              <select class="form-control" id="edit_status" name="status">
                <option value="">-- Pilih Status --</option>
                <option value="Aktif">Aktif</option>
                <option value="Nonaktif">Nonaktif</option>
              </select>
            </div>
          </div>

          <div class="modal-footer">
            <input type="hidden" name="id_user" id="edit_id" value="">
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
          <h4 class="card-title">Data User</h4>
          <div class="table-responsive m-t-40">
            <table id="table_user" class="table table-striped">
              <thead>
                <tr>
                  <th>Tgl Registrasi</th>
                  <th>ID User</th>
                  <th>Nama User</th>
                  <th>Username</th>
                  <th>Level</th>
                  <th>Foto</th>
                  <th>Status</th>
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

    var table = $('#table_user').DataTable({
      columnDefs: [{
        targets: [0, 2, 3, 4, 5, 6, 7],
        searchable: false
      }, {
        targets: [7],
        orderable: false
      }],
      autoWidth: false,
      language: {
        search: 'Cari Nama: _INPUT_',
        lengthMenu: 'Tampilkan: _MENU_',
        paginate: {'next': 'Berikutnya', 'previous': 'Sebelumnya'},
        info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ User',
        zeroRecords: 'User tidak ditemukan',
        infoEmpty: 'Menampilkan 0 sampai 0 dari _TOTAL_ User',
        loadingRecords: '<i class="fa fa-refresh fa-spin"></i>',
        processing: 'Memuat....',
        infoFiltered: ''
      },
      responsive: true,
      processing: true,
      ajax: '<?= base_url('api/user/show/'); ?>'+auth.token,
      columns: [
        {"data": null, 'render': function(data, type, row){
            return moment(row.tgl_registrasi, 'YYYY-MM-DD hh:mm:ss').format('LLL')
          }
        },
        {"data": 'id_user'},
        {"data": 'nama_user'},
        {"data": 'username'},
        {"data": 'level'},
        {"data": 'foto'},
        {"data": 'status'},
        {"data": null, 'render': function(data, type, row){
          return `<button class="btn btn-info" id="edit_user" data-id="${row.id_user}"><i class="far fa-edit"></i></button> <button class="btn btn-danger" style="margin-left: 5px;" id="hapus_user" data-id="${row.id_user}"><i class="fas fa-trash"></i></button>`
          }
        }
      ],
      order: [[1, 'desc']]
    });

    $('#btn_add').on('click', function(){
      $('#modal_add').modal('show');
    })

    $('#form_add').on('submit', function(e){
      e.preventDefault();

      var nama_user = $('#nama_user').val();
      var username = $('#username').val();
      var level = $('#level').val();

      if (nama_user === '' || username === '' || level === ''){
        Swal.fire({
          position: 'center',
          type: 'warning',
          title: 'Data belum lengkap',
          showConfirmButton: false,
          timer: 1500
        });
      } else {
        $.ajax({
          url: '<?= base_url('api/user/add/'); ?>'+auth.token,
          type: 'POST',
          dataType: 'JSON',
          beforeSend: function(){
            $('#submit_add').addClass('disabled').attr('disabled', 'disabled').html('<i class="fa fa-fw fa-spinner fa-spin"></i>');
          },
          data: {
            nama_user: nama_user,
            username: username,
            level: level
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

    $(document).on('click', '#edit_user', function(){
      var id_user = $(this).attr('data-id');

      $.ajax({
        url: `<?= base_url('api/user/show/') ?>${auth.token}?id_user=${id_user}`,
        type: 'GET',
        dataType: 'JSON',
        success: function(response){
          $.each(response.data, function(k, v){
            $('#modal_edit').modal('show');
            $('#edit_nama').val(v.nama_user);
            $('#edit_username').val(v.username);
            $('#edit_status').val(v.status);
            $('#edit_id').val(v.id_user);
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

      var nama_user = $('#edit_nama').val();
      var username = $('#edit_username').val();
      var status = $('#edit_status').val();
      var id_user = $('#edit_id').val();

      if(nama_user === '' || username === '' || level === ''){
        Swal.fire({
          position: 'center',
          type: 'warning',
          title: 'Data belum lengkap',
          showConfirmButton: false,
          timer: 1500
        });
      } else {
        $.ajax({
          url: `<?= base_url('api/user/edit/') ?>${auth.token}?id_user=${id_user}`,
          type: 'POST',
          dataType: 'JSON',
          beforeSend: function(){
            $('#submit_edit').addClass('disabled').attr('disabled', 'disabled').html('<i class="fa fa-fw fa-spinner fa-spin"></i>');
          },
          data: {
            id_user: id_user,
            nama_user: nama_user,
            username: username,
            status: status
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
              title: response.message,
              showConfirmButton: false,
              timer: 1500
            });
            $('#submit_edit').removeClass('disabled').removeAttr('disabled', 'disabled').text('Simpan')
          }
        });
      }
    });

    $(document).on('click', '#hapus_user', function(){
      var id_user = $(this).attr('data-id');

      Swal.fire({
        title: 'Apakah Anda yakin ingin menghapus User ini?',
        text: "User akan terhapus secara permanen",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',
        showLoaderOnConfirm: true
      }).then((result) => {
        if (result.value) {
          $.ajax({
            url: `<?= base_url('api/user/delete/'); ?>${auth.token}?id_user=${id_user}`,
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
                })
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

    var pusher = new Pusher('6a169a704ab461b9a26a', {
      cluster: 'ap1',
      forceTLS: true
    });

    var channel = pusher.subscribe('sipb');
    channel.bind('user', function(data) {
      table.ajax.reload();
    });

  });

</script>
