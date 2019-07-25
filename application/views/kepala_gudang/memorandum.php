<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
      <h4 class="text-themecolor">Memorandum</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
      <div class="d-flex justify-content-end align-items-center">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item active">Memorandum</li>
        </ol>
        <a href="#/add_memorandum" class="btn btn-info d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Tambah Baru</a>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Data Memorandum</h4>
          <div class="table-responsive m-t-40">
            <table id="t_memorandum" class="table table-striped">
              <thead>
                <tr>
                  <th>Tgl. Memo</th>
                  <th>No. Memo</th>
                  <th>Keterangan</th>
                  <th>Status</th>
                  <th>Nama Admin</th>
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

<script type="text/javascript">

  $(document).ready(function(){

    var session = localStorage.getItem('sipb');
    var auth = JSON.parse(session);

    var table = $('#t_memorandum').DataTable({
      columnDefs: [{
        targets: [0, 2, 3, 4, 5],
        searchable: false
      }, {
        targets: [5],
        orderable: false
      }],
      autoWidth: false,
      language: {
        search: 'Cari (No. Memo): _INPUT_',
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
      ajax: '<?= base_url('api/memorandum/show/'); ?>'+auth.token,
      columns: [
        {"data": 'tgl_memo'},
        {"data": 'no_memo'},
        {"data": 'keterangan_memo'},
        {"data": 'status'},
        {"data": 'nama_user'},
        {"data": null, 'render': function(data, type, row){
            return `<a href="#/detail_memorandum/${row.no_memo}" class="btn btn-primary"><i class="fa fa-eye"></i></a>`
          }
        }
      ],
      order: [[0, 'desc']]
    });

    // var pusher = new Pusher('6a169a704ab461b9a26a', {
    //   cluster: 'ap1',
    //   forceTLS: true
    // });
    //
    // var channel = pusher.subscribe('sipb');
    // channel.bind('memorandum', function(data) {
    //   table.ajax.reload();
    // });

  })

</script>
