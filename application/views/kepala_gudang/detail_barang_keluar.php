<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
      <h4 class="text-themecolor">Detail Barang Keluar</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
      <div class="d-flex justify-content-end align-items-center">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="#/pesanan">Barang Keluar</a></li>
          <li class="breadcrumb-item active">Detail Barang Keluar</li>
        </ol>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body printableArea">
          <h3><b>DETAIL BARANG KELUAR</b> <span class="pull-right" id="no_pesanan"></span></h3>
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
                    <p class="text-muted m-l-30" id="alamat_kirim" name="alamat_kirim" style="margin-bottom: 0px;"></p>
                    <p class="text-muted m-l-30" id="no_sp" name="no_sp" style="margin-bottom: 0px;"></p>
                    <p class="text-muted m-l-30" id="ekspedisi" name="ekspedisi" style="margin-bottom: 0px;"></p>
                    <p class="text-muted m-l-30" id="no_truk" name="no_truk" style="margin-bottom: 0px;"></p>
                    <p class="text-muted m-l-30" id="ref_id" name="ref_id" style="margin-bottom: 0px;"></p>
                    <p><b>Tgl. Keluar :</b> <i class="fa fa-calendar"></i> <span id="tgl_keluar" name="tgl_keluar"></span> </p>
                  </address>
                </div>
              </div>
           </div>

          <div class="col-md-12">
            <div class="table-responsive m-t-40" style="clear: both;">
              <table class="table table-hover" id="detail_barang_keluar">
                <thead>
                  <tr>
                    <th>No. Identifikasi</th>
                    <th>No. Persediaan</th>
                    <th>Nama Persediaan</th>
                    <th>Keterangan</th>
                    <th>Qty</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>
          </div>
        </div>
        <hr>
        <div class="text-right">
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
    var no_keluar = location.hash.substr(23);
    var link =

    $.ajax({
      url: `<?= base_url('api/barang_keluar/detail/') ?>${auth.token}?no_keluar=${no_keluar}`,
      type: 'GET',
      dataType: 'JSON',
      success: function(response){

        $.each(response.data, function(k, v){
          $('#no_keluar').text(v.no_keluar)
          $('#nama_customer').text(v.nama_customer)
          $('#alamat_kirim').text('Alamat Pengiriman : '+v.alamat_kirim)
          $('#no_sp').text('No. SP : '+v.no_sp)
          $('#ekspedisi').text('Ekspedisi : '+v.ekspedisi)
          $('#no_truk').text('No. Truk : '+v.no_truk)
          $('#ref_id').text('Ref. ID : '+v.ref_id)
          $('#tgl_keluar').text(v.tgl_keluar)

          var html = ''

          $.each(v.detail, function(k1, v1){
            html+= `<tr id="baris${v1.id_keluar_detail}">`

            html+= `<td>${v1.no_identifikasi}</td>`
            html+= `<td>${v1.no_persediaan}</td>`
            html+= `<td>${v1.nama_persediaan}</td>`
            html+= `<td>${v1.keterangan}</td>`
            html+= `<td>${v1.qty_keluar}</td>`
            html+= `</tr>`
          })

          $('#detail_barang_keluar tbody').append(html)
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

    $("#print").click(function() {

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
