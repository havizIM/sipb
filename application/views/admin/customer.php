<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
      <h4 class="text-themecolor">Pelanggan</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
      <div class="d-flex justify-content-end align-items-center">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item active">Pelanggan</li>
        </ol>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card-header" style="background-color: #d63b70">
          <h4 class="m-b-0 text-white">Data Pelanggan</h4>
        </div>
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table id="t_customer" class="table table-striped">
              <thead>
                <tr>
                  <th>Tgl. Input</th>
                  <th>Nama Pelanggan</th>
                  <th>Telepon</th>
                  <th>Fax</th>
                  <th>Email</th>
                  <th>Alamat</th>
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
        search: 'Cari (Nama): _INPUT_',
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
        {"data": null, 'render': function(data, type, row){
          return `<a href="#/riwayat/${row.id_customer}" class="btn btn-danger">${row.nama_customer}</a>`
          }
        },
        {"data": 'telepon'},
        {"data": 'fax'},
        {"data": 'email'},
        {"data": 'alamat'}
      ],
      order: [[0, 'desc']]
    });

    // var pusher = new Pusher('6a169a704ab461b9a26a', {
    //   cluster: 'ap1',
    //   forceTLS: true
    // });
    //
    // var channel = pusher.subscribe('sipb');
    // channel.bind('customer', function(data) {
    //   table.ajax.reload();
    // });

  })

</script>
