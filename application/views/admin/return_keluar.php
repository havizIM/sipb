<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Return Pemasok</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
      <div class="d-flex justify-content-end align-items-center">
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Return Pemasok</li>
          </ol>
          <a href="#/add_return_keluar" class="btn btn-info d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Tambah Baru</a>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header" style="background-color: #d63b70">
          <h4 class="m-b-0 text-white">Data Return Pemasok</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="t_return_keluar" class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>Tgl Return</th>
                  <th>No. Return</th>
                  <th>Nama Pemasok</th>
                  <th>Telepon</th>
                  <th>Email</th>
                  <th>Fax</th>
                  <th>Alamat</th>
                  <th>No. Ref</th>
                  <th>Status</th>
                  <th>Nama Admin</th>
                  <th style="width: 13%;"></th>
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

    var table = $('#t_return_keluar').DataTable({
      columnDefs: [{
        targets: [0, 3, 4, 5, 6, 7, 8, 9, 10],
        searchable: false
      }, {
        targets: [10],
        orderable: false
      }],
      autoWidth: false,
      language: {
        search: '<span>Cari (No. Return/Nama Pemasok) :</span>_INPUT_',
        lengthMenu: '<span>Tampilkan: </span>_MENU_',
        paginate: {'next': 'Berikutnya', 'previous': 'Sebelumnya'},
        info: 'Menampilkan  _START_ sampai _END_ dari _TOTAL_ Data',
        zeroRecords: 'Data tidak ditemukan',
        infoEmpty: 'Menampilkan 0 sampai 0 dari _TOTAL_ Data',
        loadingRecords: '<i class="fas fa-redo-alt fa-spin"></i>',
        processing: 'Memuat...',
        infoFiltered: ''
      },
      responsive: true,
      processing: true,
      ajax: '<?= base_url('api/return_keluar/show/'); ?>'+auth.token,
      columns: [
        {"data": 'tgl_return'},
        {"data": 'no_return_keluar'},
        {"data": 'nama_supplier'},
        {"data": 'telepon'},
        {"data": 'email'},
        {"data": 'fax'},
        {"data": 'alamat'},
        {"data": 'no_ref'},
        {"data": 'status'},
        {"data": 'nama_user'},
        {"data": null, 'render': function(data, type, row){
            if(row.status === 'Proses'){
              return `
                <a href="#/edit_return_keluar/${row.no_return_keluar}" class="btn btn-info"><i class="far fa-edit"></i></a>
                <a href="#/detail_return_keluar/${row.no_return_keluar}" class="btn btn-primary" id="print"><i class="fa fa-eye"></i></a>
                <button class="btn btn-danger" id="hapus_return_keluar" data-id="${row.no_return_keluar}"><i class="fas fa-trash"></i></button>
              `
            } else {
              return `
                <a href="#/detail_return_keluar/${row.no_return_keluar}" class="btn btn-primary" id="print"><i class="fa fa-eye"></i></a>
              `
            }
            
          }
        }
      ],
      order: [[0, 'desc']]
    })

    $(document).on('click', '#hapus_return_keluar', function(){
      var no_return_keluar = $(this).attr('data-id');

      Swal.fire({
        title: `Apa Anda yakin ingin menghapus ${no_return_keluar}?`,
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
            url: `<?= base_url('api/return_keluar/delete/'); ?>${auth.token}?no_return_keluar=${no_return_keluar}`,
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
    // channel.bind('return_keluar', function(data) {
    //   table.ajax.reload();
    // });

  })

</script>
