<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
      <h4 class="text-themecolor">Detail Pesanan</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
      <div class="d-flex justify-content-end align-items-center">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="#/pesanan">Pesanan</a></li>
          <li class="breadcrumb-item active">Detail Pesanan</li>
        </ol>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body printableArea">
          <h3><b>SURAT PESANAN</b> <span class="pull-right" id="no_pesanan"></span></h3>
          <hr>
          <div class="row">
            <div class="col-md-6">
              <div class="pull-left">
                <address>
                  <h3> &nbsp;<b class="text-danger">PT. Setia Sapta</b></h3>
                  <p class="text-muted m-l-5">Jl. Gajah Mada No. 183-184 Glodok,
                    <br/> Taman Sari,
                    <br/> Jakarta Barat,
                    <br/> DKI Jakarta 11120</p>
                  </address>
                </div>
              </div>

            <div class="col-md-6">
              <div class="pull-right text-right">
                <address>
                  <h3>Kepada,</h3>
                  <h4 class="font-bold" id="nama_customer" name="nama_customer"></h4>
                  <p class="text-muted m-l-30" id="alamat_kirim" name="alamat_kirim"></p>
                  <p class="m-t-30"><b>Tanggal Pesanan :</b> <i class="fa fa-calendar"></i> <span id="tgl_pesanan" name="tgl_pesanan"></span> </p>
                  <p><b>Tanggal Kirim :</b> <i class="fa fa-calendar"></i> <span id="tgl_kirim" name="tgl_kirim"></span> </p>
                </address>
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <div class="table-responsive m-t-40" style="clear: both;">
              <table class="table table-hover" id="detail_data_pesanan">
                <thead>
                  <tr>
                    <th>Nomor Persediaan</th>
                    <th>Quantity</th>
                    <th>Nama Persediaan</th>
                    <th>Keterangan</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>
          </div>
        </div>
        <hr>
        <div class="text-right" id="action">
          <button id="print" class="btn btn-info" type="button" style="margin-right: 15px; margin-bottom: 15px;"> <span><i class="fa fa-print"></i> Cetak</span> </button>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

  $(document).ready(function(){

    var session = localStorage.getItem('sipb');
    var auth = JSON.parse(session);
    var no_pesanan = location.hash.substr(17);
    var link =

    $.ajax({
      url: `<?= base_url('api/pesanan/detail/') ?>${auth.token}?no_pesanan=${no_pesanan}`,
      type: 'GET',
      dataType: 'JSON',
      success: function(response){

        $.each(response.data, function(k, v){
          $('#no_pesanan').text('#'+v.no_pesanan)
          $('#nama_customer').text(v.nama_customer)
          $('#alamat_kirim').text(v.alamat_kirim)
          $('#tgl_pesanan').text(v.tgl_pesanan)
          $('#tgl_kirim').text(v.tgl_kirim)

          var btn = '';
          if(v.status === 'Disetujui'){
            btn  += `
              <button id="print" class="btn btn-info" type="button" style="margin-right: 15px; margin-bottom: 15px;"> <span><i class="fa fa-print"></i> Cetak</span> </button>
            `

            $('#action').html(btn)
          } else if(v.status === 'Batal'){
            btn += `
              <h3 class="text-danger" style="margin-right: 15px; margin-bottom: 15px"><i class="ti-close"></i> Batal</h3>
            `;

            $('#action').html(btn)
          }

          var html = ''
          $.each(v.detail, function(k1, v1){
            html+= `<tr id="baris${v1.id_detail_pesanan}">`

            html+= `<td>${v1.no_persediaan}</td>`
            html+= `<td>${v1.qty_pesanan}</td>`
            html+= `<td>${v1.nama_persediaan}</td>`
            html+= `<td>${v1.keterangan}</td>`
            html+= `</tr>`
          })

          $('#detail_data_pesanan tbody').append(html)
        })
      },
      error: function(){
        Swal.fire({
          position: 'center',
          type: 'warning',
          title: 'Tidak dapat mengakses server',
          showConfirmButton: false,
          timer: 1500
        });
      }
    })

    $('#action').on('click', '#print', function() {

      var mode = 'iframe'; //popup
      var close = mode == "popup";
      var options = {
          mode: mode,
          popClose: close
      };
      
      $("div.printableArea").printArea(options);
    });

  })

</script>
