<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Barang Keluar</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
      <div class="d-flex justify-content-end align-items-center">
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Barang Keluar</li>
          </ol>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Data Barang Keluar</h4>
          <div class="table-responsive m-t-40">
            <table id="t_barang_keluar" class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>Tgl Keluar</th>
                  <th>No. Keluar</th>
                  <th>Nama Customer</th>
                  <th>Alamat Pengiriman</th>
                  <th>No. SP</th>
                  <th>Ekspedisi</th>
                  <th>No. Truk</th>
                  <th>No. Invoice</th>
                  <th>Status</th>
                  <th>Nama Admin</th>
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

    var table = $('#t_barang_keluar').DataTable({
      columnDefs: [{
        targets: [0, 2, 3, 4, 5, 6, 7, 8, 9],
        searchable: false
      }, {
        targets: [9],
        orderable: false
      }],
      autoWidth: false,
      language: {
        search: '<span>Cari (Nomor Keluar) :</span>_INPUT_',
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
      ajax: '<?= base_url('api/barang_keluar/show/'); ?>'+auth.token,
      columns: [
        {"data": 'tgl_keluar'},
        {"data": 'no_keluar'},
        {"data": 'nama_customer'},
        {"data": 'alamat_kirim'},
        {"data": 'no_sp'},
        {"data": 'ekspedisi'},
        {"data": 'no_truk'},
        {"data": 'ref_id'},
        {"data": 'status'},
        {"data": 'nama_user'},
        {"data": null, 'render': function(data, type, row){
            return `<a href="#/detail_barang_keluar/${row.no_keluar}" class="btn btn-primary" style="width: 75%;"><i class="fa fa-eye"></i></a>`
          }
        }
      ],
      order: [[0, 'desc']]
    })

    $(document).on('click', '#btn_approve', function(){
      var no_keluar = $(this).attr('data-id');

        $.ajax({
          url: `<?= base_url('api/barang_keluar/approve/'); ?>${auth.token}?no_keluar=${no_keluar}`,
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
      })

    var pusher = new Pusher('6a169a704ab461b9a26a', {
      cluster: 'ap1',
      forceTLS: true
    });

    var channel = pusher.subscribe('sipb');
    channel.bind('barang_keluar', function(data) {
      table.ajax.reload();
    });

  })

</script>
