<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Return Pelanggan</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
      <div class="d-flex justify-content-end align-items-center">
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Return Pelanggan</li>
          </ol>
          <a href="#/add_return_masuk" class="btn btn-info d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Tambah Baru</a>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header" style="background-color: #d63b70">
          <h4 class="m-b-0 text-white">Data Return Pelanggan</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="t_return_masuk" class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>Tgl Return Masuk</th>
                  <th>No. Return Masuk</th>
                  <th>Nama Pelanggan</th>
                  <th>Alamat</th>
                  <th>No. Ref</th>
                  <th>Status</th>
                  <th>Nama Admin</th>
                  <th style="width: 17%;"></th>
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

    var table = $('#t_return_masuk').DataTable({
      columnDefs: [{
        targets: [0, 3, 4, 5, 6, 7],
        searchable: false
      }, {
        targets: [7],
        orderable: false
      }],
      autoWidth: false,
      language: {
        search: '<span>Cari (No. Return/Nama Pelanggan) :</span>_INPUT_',
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
      ajax: '<?= base_url('api/return_masuk/show/'); ?>'+auth.token,
      columns: [
        {"data": 'tgl_return'},
        {"data": 'no_return_masuk'},
        {"data": 'nama_customer'},
        {"data": 'alamat'},
        {"data": 'no_ref'},
        {"data": 'status'},
        {"data": 'nama_user'},
        {"data": null, 'render': function(data, type, row){
            if(row.status === 'Proses'){
              return `
                <a href="#/edit_return_masuk/${row.no_return_masuk}" class="btn btn-info"><i class="far fa-edit"></i></a>
                <a href="#/detail_return_masuk/${row.no_return_masuk}" class="btn btn-primary" id="print"><i class="fa fa-eye"></i></a>
                <button class="btn btn-danger" id="hapus_return_masuk" data-id="${row.no_return_masuk}"><i class="fas fa-trash"></i></button>
              `
            } else {
              return `
                <a href="#/detail_return_masuk/${row.no_return_masuk}" class="btn btn-primary" id="print"><i class="fa fa-eye"></i></a>
              `
            }
            
          }
        }
      ],
      order: [[0, 'desc']]
    })

    $(document).on('click', '#hapus_return_masuk', function(){
      var no_return_masuk = $(this).attr('data-id');

      Swal.fire({
        title: `Apa Anda yakin ingin menghapus ${no_return_masuk}?`,
        text: "Data akan terhapus secara permanen",
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
            url: `<?= base_url('api/return_masuk/delete/'); ?>${auth.token}?no_return_masuk=${no_return_masuk}`,
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

    // var pusher = new Pusher('6a169a704ab461b9a26a', {
    //   cluster: 'ap1',
    //   forceTLS: true
    // });
    //
    // var channel = pusher.subscribe('sipb');
    // channel.bind('return_masuk', function(data) {
    //   table.ajax.reload();
    // });

  })

</script>
