<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
      <h4 class="text-themecolor">Log</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">User</li>
                <li class="breadcrumb-item active">Log User</li>
            </ol>
        </div>
    </div>
  </div>


  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header" style="background-color: #d63b70">
          <h4 class="m-b-0 text-white">Log Aktifitas User</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="table_log" class="table table-striped">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>ID User</th>
                  <th>Nama User</th>
                  <th>ID Ref</th>
                  <th>Keterangan</th>
                  <th>Kategori</th>
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

    var table = $('#table_log').DataTable({
      columnDefs: [{
        targets: [0, 1, 2, 3, 4],
        searchable: true
      }],
      autoWidth: false,
      language: {
        search: 'Cari: _INPUT_',
        lengthMenu: 'Tampilkan: _MENU_',
        paginate: {'next': 'Berikutnya', 'previous': 'Sebelumnya'},
        info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ User',
        zeroRecords: 'User tidak ditemukan',
        infoEmpty: 'Menampilkan 0 sampai 0 dari _TOTAL_ User',
        loadingRecords: '<i class="fa fa-refresh fa-spin"></i>',
        processing: ' Memuat....',
        infoFiltered: ''
      },
      responsive: true,
      processing: true,
      ajax: '<?= base_url('api/log/show/'); ?>'+auth.token,
      columns: [
        {"data": 'tgl_log'},
        {"data": 'id_user'},
        {"data": 'nama_user'},
        {"data": 'id_ref'},
        {"data": 'keterangan'},
        {"data": 'kategori'}
      ],
      order: [[0, 'desc']]
    });

    // var pusher = new Pusher('6a169a704ab461b9a26a', {
    //   cluster: 'ap1',
    //   forceTLS: true
    // });
    //
    // var channel = pusher.subscribe('sipb');
    // channel.bind('log', function(data) {
    //   table.ajax.reload();
    // });

  });

</script>
