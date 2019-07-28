<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Pesanan</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
      <div class="d-flex justify-content-end align-items-center">
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Pesanan</li>
          </ol>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Data Pesanan</h4>
          <div class="table-responsive m-t-40">
            <table id="t_pesanan" class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>Tgl Pesanan</th>
                  <th>Nomor Pesanan</th>
                  <th>Nama Pelanggan</th>
                  <th>Alamat Pengiriman</th>
                  <th>Status</th>
                  <th>Nama Sales</th>
                  <th>Tanggal Kirim</th>
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

    var table = $('#t_pesanan').DataTable({
      columnDefs: [{
        targets: [0, 3, 4, 5, 6, 7],
        searchable: false
      }, {
        targets: [7],
        orderable: false
      }],
      autoWidth: false,
      language: {
        search: '<span>Cari (No. Pesanan/Nama Pelanggan) :</span>_INPUT_',
        lengthMenu: '<span>Tampilkan: </span>_MENU_',
        paginate: {'next': 'Berikutnya', 'previous': 'Sebelumnya'},
        info: 'Menampilkan  _START_ sampai _END_ dari _TOTAL_ Pesanan',
        zeroRecords: 'Pesanan tidak ditemukan',
        infoEmpty: 'Menampilkan 0 sampai 0 dari _TOTAL_ Pesanan',
        loadingRecords: '<i class="fas fa-redo-alt fa-spin"></i>',
        processing: 'Memuat...',
        infoFiltered: ''
      },
      responsive: true,
      processing: true,
      ajax: '<?= base_url('api/pesanan/show/'); ?>'+auth.token,
      columns: [
        {"data": 'tgl_pesanan'},
        {"data": 'no_pesanan'},
        {"data": 'nama_customer'},
        {"data": 'alamat_kirim'},
        {"data": 'status'},
        {"data": 'nama_user'},
        {"data": 'tgl_kirim'},
        {"data": null, 'render': function(data, type, row){
            return `<a href="#/detail_pesanan/${row.no_pesanan}" class="btn btn-primary" id="print" style="width: 75%;"><i class="fa fa-eye"></i></a>`
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
      // channel.bind('pesanan', function(data) {
      //   table.ajax.reload();
      // });

    });

</script>
