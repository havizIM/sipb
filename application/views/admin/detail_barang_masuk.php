<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
      <h4 class="text-themecolor">Detail Barang Masuk</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
      <div class="d-flex justify-content-end align-items-center">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="#/barang_masuk">Barang Masuk</a></li>
          <li class="breadcrumb-item active">Detail Barang Masuk</li>
        </ol>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body printableArea">
          <h3><b>NO BARANG MASUK</b> <span class="pull-right" id="no_masuk"></span></h3>
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
                        <h3>Dari,</h3>
                        <h4 class="font-bold" id="nama_supplier" name="nama_supplier"></h4>
                        <p class="text-muted m-l-30" id="no_surat" name="no_surat" style="margin-bottom: 0px;"></p>
                        <p class="text-muted m-l-30" id="no_po" name="no_po" style="margin-bottom: 0px;"></p>
                        <p><b>Tgl. Masuk :</b> <i class="fa fa-calendar"></i> <span id="tgl_masuk" name="tgl_masuk"></span> </p>
                      </address>
                    </div>
                  </div>
                </td>
              </tr>
            </table>

          <div class="col-md-12">
            <div class="table-responsive m-t-40" style="clear: both;">
              <table class="table table-hover" id="detail_barang_masuk">
                <thead>
                  <tr>
                    <th>No. Identifikasi</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
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
      </div>
      <div class="text-right" id="action">
        
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

  $(document).ready(function(){

    var session = localStorage.getItem('sipb');
    var auth = JSON.parse(session);
    var no_masuk = location.hash.substr(22);
    var link =

    $.ajax({
      url: `<?= base_url('api/barang_masuk/detail/') ?>${auth.token}?no_masuk=${no_masuk}`,
      type: 'GET',
      dataType: 'JSON',
      success: function(response){

        $.each(response.data, function(k, v){
          $('#no_masuk').text('#'+v.no_masuk)
          $('#nama_supplier').text(v.nama_supplier)
          $('#no_surat').text('No. Surat : '+v.no_surat)
          $('#no_po').text('No. PO : '+v.no_po)
          $('#tgl_masuk').text(v.tgl_masuk)


          var btn = ''
          if(v.status === 'Disetujui'){
            btn += `<button id="print" class="btn btn-info" type="button" style="margin-right: 15px; margin-bottom: 15px;"> <span><i class="fa fa-print"></i> Cetak</span> </button>`

            $('#action').html(btn)
          }

          var html = ''
          $.each(v.detail, function(k1, v1){
            html+= `<tr id="baris${v1.id_masuk_detail}">`

            html+= `<td>${v1.no_identifikasi}</td>`
            html+= `<td>${v1.no_persediaan}</td>`
            html+= `<td>${v1.nama_persediaan}</td>`
            html+= `<td>${v1.keterangan}</td>`
            html+= `<td>${v1.qty_masuk}</td>`
            html+= `</tr>`
          })

          $('#detail_barang_masuk tbody').append(html)
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
