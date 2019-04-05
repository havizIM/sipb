<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
      <h4 class="text-themecolor">Log Aktifitas</h4>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Data Log Aktifitas User</h4>
          <div class="table-responsive m-t-40">
            <table id="table_log" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>ID User</th>
                  <th>Nama User</th>
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
        {"data": null, 'render': function(data, type, row){
            return moment(row.tgl_log, 'YYYY-MM-DD hh:mm:ss').format('LLL')
          }
        },
        {"data": 'id_user'},
        {"data": 'nama_user'},
        {"data": 'keterangan'},
        {"data": 'kategori'}
      ],
      order: [[0, 'asc']]
    });

  });

</script>
