<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
      <h4 class="text-themecolor">Detail Memorandum</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
      <div class="d-flex justify-content-end align-items-center">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="#/memorandum">Memorandum</a></li>
          <li class="breadcrumb-item active">Detail Memorandum</li>
        </ol>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body printableArea">
          <h3><b>DETAIL MEMORANDUM</b> <span class="pull-right"></span></h3>
          <hr>
          <div class="row">
            <table width="100%">
              <tr>

                <td width="50%">
                  <div class="pull-left">
                    <address>
                      <h3> &nbsp;<b class="text-danger">PT. Setia Sapta</b></h3>
                      <p class="text-muted m-l-5">Jl. Gajah Mada No. 183-184 Glodok,
                        <br/> Taman Sari,
                        <br/> Jakarta Barat,
                        <br/> DKI Jakarta 11120</p>
                    </address>
                  </div>
                </td>

                <td width="50%">
                  <div class="pull-right text-right">
                    <address>
                      <h4 id="no_memo" name="no_memo"></h4>
                      <p><b>Tgl. Memorandum :</b> <i class="fa fa-calendar"></i> <span id="tgl_memo" name="tgl_memo"></span> </p>
                    </address>
                  </div>
                </div>
              </td>
              </tr>
            </table>

          <div class="col-md-12">
            <div class="table-responsive m-t-40" style="clear: both;">
              <table class="table table-hover" id="detail_memorandum">
                <thead>
                  <tr>
                    <th>No. Identifikasi</th>
                    <th>Nama Barang</th>
                    <th>Qty. Masuk</th>
                    <th>Qty. Keluar</th>
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
    var no_memo = location.hash.substr(20);
    var link =

    $.ajax({
      url: `<?= base_url('api/memorandum/detail/') ?>${auth.token}?no_memo=${no_memo}`,
      type: 'GET',
      dataType: 'JSON',
      success: function(response){

        $.each(response.data, function(k, v){
          $('#no_memo').html(`<b>${v.no_memo}</b>`)
          $('#tgl_memo').text(v.tgl_memo)

          var html = ''

          $.each(v.detail, function(k1, v1){
            html+= `<tr id="baris${v1.id_memorandum_detail}">`

            html+= `<td>${v1.no_identifikasi}</td>`
            html+= `<td>${v1.nama_persediaan}</td>`
            html+= `<td>${v1.qty_masuk}</td>`
            html+= `<td>${v1.qty_keluar}</td>`
            html+= `<td>${v1.keterangan}</td>`
            html+= `</tr>`
          })

          $('#detail_memorandum tbody').append(html)
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
