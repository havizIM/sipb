<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
      <h4 class="text-themecolor">Detail Return Pelanggan</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
      <div class="d-flex justify-content-end align-items-center">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="#/return_masuk">Return Pelanggan</a></li>
          <li class="breadcrumb-item active">Detail Return Pelanggan</li>
        </ol>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body printableArea">
          <h3><b>DETAIL RETURN PELANGGAN</b> <span class="pull-right"></span></h3>
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
                    <h4 class="font-bold" id="nama_customer" name="nama_supplier"></h4>
                    <p class="text-muted m-l-30" id="alamat" name="alamat" style="margin-bottom: 0px;"></p>
                    <p class="text-muted m-l-30" id="no_ref" name="no_ref" style="margin-bottom: 0px;"></p>
                    <p><b>Tgl. Return :</b> <i class="fa fa-calendar"></i> <span id="tgl_return" name="tgl_return"></span> </p>
                  </address>
                </div>
              </div>
           </div>

          <div class="col-md-12">
            <div class="table-responsive m-t-40" style="clear: both;">
              <table class="table table-hover" id="detail_return_masuk">
                <thead>
                  <tr>
                    <th>No. Identifikasi</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Keterangan</th>
                    <th>Qty Return Masuk</th>
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
    var no_return_masuk = location.hash.substr(22);
    var link =

    $.ajax({
      url: `<?= base_url('api/return_masuk/detail/') ?>${auth.token}?no_return_masuk=${no_return_masuk}`,
      type: 'GET',
      dataType: 'JSON',
      success: function(response){

        $.each(response.data, function(k, v){
          $('#no_return_masuk').text(v.no_return_masuk)
          $('#nama_customer').text(v.nama_customer)
          $('#alamat').text('Alamat : '+v.alamat)
          $('#no_ref').text('No. Ref : '+v.no_ref)
          $('#tgl_return_masuk').text(v.tgl_return_masuk)

          var html = ''

          $.each(v.detail, function(k1, v1){
            html+= `<tr id="baris${v1.id_dreturn_masuk}">`

            html+= `<td>${v1.no_identifikasi}</td>`
            html+= `<td>${v1.no_persediaan}</td>`
            html+= `<td>${v1.nama_persediaan}</td>`
            html+= `<td>${v1.keterangan}</td>`
            html+= `<td>${v1.qty_return_masuk}</td>`
            html+= `</tr>`
          })

          $('#detail_return_masuk tbody').append(html)
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
