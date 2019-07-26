<div class="container-fluid">
  <div class="row page-titles">
      <div class="col-md-5 align-self-center">
          <h4 class="text-themecolor">Barang</h4>
      </div>
      <div class="col-md-7 align-self-center text-right">
          <div class="d-flex justify-content-end align-items-center">
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
                  <li class="breadcrumb-item active">Barang</li>
              </ol>
      </div>
  </div>

  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Data Barang</h4>
        <div class="table-responsive">
          <table id="table_barang" class="table table-striped table-hover">
            <thead>
              <tr>
                <th>Tgl Input</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Satuan</th>
                <th>Warna</th>
                <th>Keterangan</th>
                <th>Barang Masuk</th>
                <th>Barang Keluar</th>
                <th>Return Pemasok</th>
                <th>Return Pelanggan</th>
                <th>Sisa Stock</th>
                <th>Foto</th>
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

<script type="text/javascript">

  $(document).ready(function(){

    var session = localStorage.getItem('sipb');
    var auth = JSON.parse(session);

    var table = $('#table_barang').DataTable({
      columnDefs: [{
        targets: [0, 3, 4, 5, 6],
        searchable: false
      }],
      autoWidth: false,
      language: {
        search: 'Cari (Kode/Nama Barang): _INPUT_',
        lengthMenu: 'Tampilkan: _MENU_',
        paginate: {'next': 'Berikutnya', 'previous': 'Sebelumnya'},
        info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ Barang',
        zeroRecords: 'Barang tidak ditemukan',
        infoEmpty: 'Menampilkan 0 sampai 0 dari _TOTAL_ Barang',
        loadingRecords: '<i class="fa fa-refresh fa-spin"></i>',
        processing: 'Memuat....',
        infoFiltered: ''
      },
      responsive: true,
      processing: true,
      ajax: '<?= base_url('api/barang/show/'); ?>'+auth.token,
      columns: [
        {"data": 'tgl_input'},
        {"data": 'no_persediaan'},
        {"data": 'nama_persediaan'},
        {"data": 'satuan'},
        {"data": 'warna'},
        {"data": 'keterangan'},
        {"data": null, 'render': function(data, type, row){
          return `${row.jml_barang_masuk ? row.jml_barang_masuk : 0}`
          }
        },
        {"data": null, 'render': function(data, type, row){
          return `${row.jml_barang_keluar ? row.jml_barang_keluar : 0}`
          }
        },
        {"data": null, 'render': function(data, type, row){
          return `${row.jml_return_keluar ? row.jml_return_keluar : 0}`
          }
        },
        {"data": null, 'render': function(data, type, row){
          return `${row.jml_return_masuk ? row.jml_return_masuk : 0}`
          }
        },
        {"data": null, 'render': function(data, type, row){
          return `${0 + (parseInt(row.jml_barang_masuk) - parseInt(row.jml_barang_keluar)) + (parseInt(row.jml_return_masuk) - parseInt(row.jml_return_keluar)) }`
          }
        },
        {"data": null, 'render': function(data, type, row){
            var barang_masuk = row.jml_barang_masuk ? row.jml_barang_masuk : 0;
            var barang_keluar = row.jml_barang_keluar ? row.jml_barang_keluar : 0;
            var return_masuk = row.jml_return_masuk ? row.jml_return_masuk : 0;
            var return_keluar =  row.jml_return_keluar ? row.jml_return_keluar : 0;
            var total_barang = parseInt(barang_masuk - barang_keluar) + parseInt(return_masuk - return_keluar);

            return `${total_barang}`
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
    // channel.bind('barang', function(data) {
    //   table.ajax.reload();
    // });

  })

</script>
