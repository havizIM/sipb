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
          <h3><b>NO RETURN PELANGGAN</b> <span class="pull-right" id="no_return"></span></h3>
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
                        <h4 class="font-bold" id="nama_customer" name="nama_supplier"></h4>
                        <p class="text-muted m-l-30" id="alamat" name="alamat" style="margin-bottom: 0px;"></p>
                        <p class="text-muted m-l-30" id="no_ref" name="no_ref" style="margin-bottom: 0px;"></p>
                        <p><b>Tgl. Return :</b> <i class="fa fa-calendar"></i> <span id="tgl_return" name="tgl_return"></span> </p>
                      </address>
                    </div>
                  </div>
                </td>
              </tr>
            </table>

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
    var no_return_masuk = location.hash.substr(22);

    $.ajax({
      url: `<?= base_url('api/return_masuk/detail/') ?>${auth.token}?no_return_masuk=${no_return_masuk}`,
      type: 'GET',
      dataType: 'JSON',
      success: function(response){

        $.each(response.data, function(k, v){
          $('#no_return').text('#'+v.no_return_masuk)
          $('#nama_customer').text(v.nama_customer)
          $('#alamat').text('Alamat : '+v.alamat)
          $('#no_ref').text('No. Ref : '+v.no_ref)
          $('#tgl_return').text(v.tgl_return)

          var btn = ''
          if(v.status === 'Proses'){
            btn+=`<button type="submit" id="btn_approve" data-id="${v.no_return_masuk}" class="btn btn-success" style="margin-right: 10px; margin-bottom: 15px;"><i class="ti-check"></i> Approve</button>`

            $('#action').html(btn)
          } else {
            btn += `<button id="print" class="btn btn-info" type="button" style="margin-right: 15px; margin-bottom: 15px;"> <span><i class="fa fa-print"></i> Cetak</span> </button>`

            $('#action').html(btn)
          }

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

    $('#action').on('click', '#btn_approve', function(){
      var no_return_masuk = $(this).attr('data-id');

      Swal.fire({
        title: `Apakah Anda yakin ingin mengapprove ${no_return_masuk}?`,
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
              url: `<?= base_url('api/return_masuk/approve/'); ?>${auth.token}?no_return_masuk=${no_return_masuk}`,
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
                  window.location = '#/return_masuk'
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
      })

    $("#action").on('click', '#print', function() {

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
