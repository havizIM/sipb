<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Barang Masuk</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
      <div class="d-flex justify-content-end align-items-center">
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Barang Masuk</li>
          </ol>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header" style="background-color: #d63b70">
          <h4 class="m-b-0 text-white">Data Barang Masuk</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="t_barang_masuk" class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>Tgl Masuk</th>
                  <th>No. Masuk</th>
                  <th>No. Surat</th>
                  <th>No. PO</th>
                  <th>Nama Pemasok</th>
                  <th>Telepon</th>
                  <th>Fax</th>
                  <th>Email</th>
                  <th>Alamat</th>
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

    var table = $('#t_barang_masuk').DataTable({
      columnDefs: [{
        targets: [0, 2, 3, 5, 6, 7, 8, 9],
        searchable: false
      }, {
        targets: [9],
        orderable: false
      }],
      autoWidth: false,
      language: {
        search: '<span>Cari (No. Masuk/Nama Pemasok) :</span>_INPUT_',
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
      ajax: '<?= base_url('api/barang_masuk/show/'); ?>'+auth.token,
      columns: [
        {"data": 'tgl_masuk'},
        {"data": 'no_masuk'},
        {"data": 'no_surat'},
        {"data": 'no_po'},
        {"data": 'nama_supplier'},
        {"data": 'telepon'},
        {"data": 'fax'},
        {"data": 'email'},
        {"data": 'alamat'},
        {"data": 'status'},
        {"data": 'nama_user'},
        {"data": null, 'render': function(data, type, row){
            return `<a href="#/detail_barang_masuk/${row.no_masuk}" class="btn btn-primary" id="print"><i class="fa fa-eye"></i></a>`
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
    // channel.bind('barang_masuk', function(data) {
    //   table.ajax.reload();
    // });

  })

</script>
