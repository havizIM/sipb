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
          <a href="#/add_pesanan" class="btn btn-info d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Tambah Baru</a>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header" style="background-color: #d63b70">
          <h4 class="m-b-0 text-white">Data Pesanan</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
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
            if(row.status === 'Proses'){
              return `<a href="#/edit_pesanan/${row.no_pesanan}" class="btn btn-info"><i class="fa fa-edit"></i></a> <a href="#/detail_pesanan/${row.no_pesanan}" class="btn btn-primary" id="print"><i class="fa fa-eye"></i></a> <button class="btn btn-danger" id="hapus_pesanan" data-id="${row.no_pesanan}"><i class="fa fa-trash"></i></button>`
            } else {
              return `<a href="#/detail_pesanan/${row.no_pesanan}" class="btn btn-primary" id="print" style="width: 75%;"><i class="fa fa-eye"></i></a>`
            }
          }
        }
      ],
      order: [[0, 'desc']]
    })

    $(document).on('click', '#hapus_pesanan', function(){
      var no_pesanan = $(this).attr('data-id');

      Swal.fire({
        title: `Apa Anda yakin ingin menghapus ${no_pesanan}?`,
        text: "Data akan terhapus secara permanen",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Saya yakin.',
        cancelButtonText: 'Batal',
        showLoaderOnConfirm: true
      }).then((result) => {
        if (result.value) {
          $.ajax({
            url: `<?= base_url('api/pesanan/delete/'); ?>${auth.token}?no_pesanan=${no_pesanan}`,
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
                table.ajax.reload();
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
        }
      })
    });

    // var pusher = new Pusher('6a169a704ab461b9a26a', {
    //   cluster: 'ap1',
    //   forceTLS: true
    // });
    //
    // var channel = pusher.subscribe('sipb');
    // channel.bind('pesanan', function(data) {
    //   table.ajax.reload();
    // });

  })

</script>
