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
              <a href="#/add_stok" type="button" class="btn btn-info d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Tambah Baru</a>
          </div>
      </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header" style="background-color: #d63b70">
          <h4 class="m-b-0 text-white">Data Stok</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="t_stok" class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>Tgl Input</th>
                  <th>Nomor Identifikasi</th>
                  <th>Keterangan Stok</th>
                  <th>Saldo Awal</th>
                  <th>Kode Barang</th>
                  <th>Nama Barang</th>
                  <th>Satuan</th>
                  <th>Warna</th>
                  <th>Keterangan Barang</th>
                  <th style="width: 12%;"></th>
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
        targets: [0, 2, 3, 5, 6, 7, 8, 9],
        searchable: false
      }, {
        targets: [9],
        orderable: false
      }],
      autoWidth: false,
      language: {
        search: '<span>Cari (No. Identifikasi/Nama Barang) :</span>_INPUT_',
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
        {"data": 'ket_barang'},
        {"data": null, 'render': function(data, type, row){
          return `<a href="#/edit_stok/${row.id_identifikasi}" class="btn btn-info" id="edit_stok" data-id="${row.id_identifikasi}">Ubah</a> <button class="btn btn-danger" style="margin-left: 5px;" id="hapus_stok" data-id="${row.id_identifikasi}" data-nama="${row.no_identifikasi}">Hapus</button>`
          }
        }
      ],
      order: [[0, 'desc']]
    })

    $(document).on('click', '#hapus_stok', function(){
      var id_identifikasi = $(this).attr('data-id');
      var no_identifikasi = $(this).attr('data-nama')

      Swal.fire({
        title: `Apa Anda yakin ingin menghapus ${no_identifikasi}?`,
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
            url: `<?= base_url('api/stock/delete/'); ?>${auth.token}?id_identifikasi=${id_identifikasi}`,
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
    // channel.bind('stock', function(data) {
    //   table.ajax.reload();
    // });

  })

</script>
