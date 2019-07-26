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
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Data Return Pelanggan</h4>
          <div class="table-responsive m-t-40">
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
            return `<a href="#/detail_return_masuk/${row.no_return_masuk}" class="btn btn-primary" id="print"><i class="fa fa-eye"></i></a>`
          }
        }
      ],
      order: [[0, 'desc']]
    })

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
