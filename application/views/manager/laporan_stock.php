<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Laporan Stok</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
      <div class="d-flex justify-content-end align-items-center">
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Laporan Stok</li>
          </ol>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header" style="background-color: #d63b70">
          <h4 class="m-b-0 text-white">Filter Laporan Stok</h4>
        </div>
        <div class="card-body">
          <form id="form_laporan">
            <div class="form-group">
                <label for="">Pilih Tanggal Awal</label>
                <input type="date" class="form-control" name="tgl_awal" id="tgl_awal">
            </div>
            <div class="form-group">
                <label for="">Pilih Tanggal Akhir</label>
                <input type="date" class="form-control" name="tgl_akhir" id="tgl_akhir">
            </div>
            <button style="" class="btn btn-md btn-block btn-info" id="submit_laporan">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12" id="content_laporan">
      
        
    </div>
  </div>

</div>

<script>

    var renderUI = (() => {
        return {
            renderData: (data) => {
                var html = '';
                var tgl_awal = $('#tgl_awal').val();
                var tgl_akhir = $('#tgl_akhir').val();

                html += `
                <div class="card">
                    <div class="card-header">
                        <button id="print" style="float: right;" class="btn btn-md btn-success"><i class="fa fa-print"></i> Print</button>
                    </div>
                    <div class="card-body">
                        <div class="card-body printableArea">
                            <div class="row">
                                <div class="col-md-12">
                                <div class="pull-left">
                                    <table>
                                        <tr>
                                            <td>
                                                <img style="height: 60px" src="<?= base_url('assets/images/logo-mini.png') ?>">
                                            </td>
                                            <td>
                                                <address>
                                                    <h3> &nbsp;<b class="text-danger">PT. Setia Sapta</b></h3>
                                                    <p class="text-muted m-l-5">Jl. Gajah Mada No. 183-184 Glodok Taman Sari Jakarta Barat, DKI Jakarta 11120</p>
                                                </address>
                                            </td>
                                        </tr>
                                    </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="table-responsive m-t-40" style="clear: both;">
                                <h4>Laporan Stock Periode ${tgl_awal} - ${tgl_akhir}</h4>
                                <table class="table table-hover" id="detail_barang_keluar">
                                    <thead>
                                        <tr>
                                            <th>ID Identifikasi</th>
                                            <th>No Persediaan</th>
                                            <th>No Identifikasi</th>
                                            <th>Keterangan</th>
                                            <th>Saldo Awal</th>
                                            <th>Barang Masuk</th>
                                            <th>Barang Keluar</th>
                                            <th>Saldo Akhir</th>
                                        </tr>
                                    </thead>
                                    <tbody>`

                                         if(data.length !== 0){
                                            $.each(data, function(k, v){
                                                html += `
                                                    <tr>
                                                        <td>${v.id_identifikasi}</td>
                                                        <td>${v.no_persediaan}</td>
                                                        <td>${v.no_identifikasi}</td>
                                                        <td>${v.keterangan}</td>
                                                        <td>${v.saldo_awal}</td>
                                                        <td>${v.barang_masuk}</td>
                                                        <td>${v.barang_keluar}</td>
                                                        <td>${v.saldo_akhir}</td>
                                                    </tr>
                                                `;
                                            })
                                        } else {
                                            html += `
                                                <tr>
                                                    <td colspan="6"><center>Tidak ada data ditemukan</center></td>
                                                </tr>
                                            `;
                                        }
                                    `</tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                `;

                $('#content_laporan').html(html);
            }
        }
    })();
    
    var laporanController = ((UI) => {
        var session = localStorage.getItem('sipb');
        var auth = JSON.parse(session);

        var printLaporan = () => {
            $('#content_laporan').on('click', '#print', function(){
                var mode = 'iframe'; //popup
                var close = mode == "popup";
                var options = {
                    mode: mode,
                    popClose: close
                };

                $("div.printableArea").printArea(options);
            })
        }

        var submitLaporan = () => {
            $('#form_laporan').on('submit', function(e){
                e.preventDefault();

                var tgl_awal = $('#tgl_awal').val();
                var tgl_akhir = $('#tgl_akhir').val();

                if(tgl_awal === '' || tgl_akhir === ''){
                    Swal.fire({
                        position: 'center',
                        type: 'warning',
                        title: 'Silahkan isi periode laporan',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    $.ajax({
                        url: `<?= base_url('api/stock/laporan/') ?>${auth.token}?tgl_awal=${tgl_awal}&tgl_akhir=${tgl_akhir}`,
                        type: 'GET',
                        dataType: 'JSON',
                        beforeSend: function(){
                            $('#submit_laporan').html('Loading...')
                        },
                        success: function(res){
                            if(res.status === 200){
                                UI.renderData(res.data);
                            } else {
                                Swal.fire({
                                    position: 'center',
                                    type: 'warning',
                                    title: res.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }

                            $('#submit_laporan').html('Submit')
                        },
                        error: function(){
                            Swal.fire({
                                position: 'center',
                                type: 'warning',
                                title: 'Tidak dapat mengakases server',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            $('#submit_laporan').html('Submit')
                        }
                    })
                }
            })
        }

        return {
            init: () => {
                submitLaporan();
                printLaporan();
            }
        }
    })(renderUI);

    $(document).ready(function(){
        laporanController.init();
    })
</script>