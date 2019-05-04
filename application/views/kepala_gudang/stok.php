<div class="container-fluid">
  <div class="row page-titles">
      <div class="col-md-5 align-self-center">
          <h4 class="text-themecolor">Stok</h4>
      </div>
      <div class="col-md-7 align-self-center text-right">
          <div class="d-flex justify-content-end align-items-center">
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
                  <li class="breadcrumb-item active">Stok</li>
              </ol>
          </div>
      </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Data Stok</h4>
          <div class="table-responsive m-t-40">
            <table id="t_stok" class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>Tgl Input</th>
                  <th>Nomor Identifikasi</th>
                  <th>Keterangan Stok</th>
                  <th>Saldo Awal</th>
                  <th>Nomor Persediaan</th>
                  <th>Nama Persediaan</th>
                  <th>Satuan</th>
                  <th>Warna</th>
                  <th>Keterangan Barang</th>
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

    var table = $('#t_stok').DataTable({
      columnDefs: [{
        targets: [0, 2, 3, 4, 5, 6, 7, 8],
        searchable: false
      }],
      autoWidth: false,
      language: {
        search: '<span>Cari (Nomor Identifikasi) :</span>_INPUT_',
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
      ajax: '<?= base_url('api/stock/show/'); ?>'+auth.token,
      columns: [
        {"data": 'tgl_input'},
        {"data": 'no_identifikasi'},
        {"data": 'ket_stock'},
        {"data": 'saldo_awal'},
        {"data": 'no_persediaan'},
        {"data": 'nama_persediaan'},
        {"data": 'satuan'},
        {"data": 'warna'},
        {"data": 'ket_barang'}
      ],
      order: [[0, 'desc']]
    })

    var pusher = new Pusher('6a169a704ab461b9a26a', {
      cluster: 'ap1',
      forceTLS: true
    });

    var channel = pusher.subscribe('sipb');
    channel.bind('stock', function(data) {
      table.ajax.reload();
    });

  })

</script>
