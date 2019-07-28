<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Laporan Pesanan</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
      <div class="d-flex justify-content-end align-items-center">
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Laporan Pesanan</li>
          </ol>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Filter Laporan Pesanan</h4>
          <form id="form_laporan">
            <div class="form-group">
                <label for="">Pilih Bulan</label>
                <select name="bulan" id="bulan" class="form-control">
                    <option value="">-- Pilih Bulan --</option>
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
            </div>
            <div class="form-group">
                <label for="">Pilih Tahun</label>
                <select name="tahun" id="tahun" class="form-control">
                    <option value="">-- Pilih Tahun --</option>
                    <option value="2017">2017</option>
                    <option value="2018">2018</option>
                    <option value="2019">2019</option>
                </select>
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
                var bulan = $('#bulan').val();
                var tahun = $('#tahun').val();
                var list_bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

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
                                <h4>Laporan Pesanan Per ${list_bulan[bulan - 1]} - ${tahun}</h4>
                                <table class="table table-hover" id="detail_barang_keluar">
                                    <thead>
                                        <tr>
                                            <th>Tgl Pesanan</th>
                                            <th>Nomor Pesanan</th>
                                            <th>Nama Pelanggan</th>
                                            <th>Alamat Pengiriman</th>
                                            <th>Nama Sales</th>
                                            <th>Tanggal Kirim</th>
                                        </tr>
                                    </thead>
                                    <tbody>`

                                         if(data.length !== 0){
                                            $.each(data, function(k, v){
                                                html += `
                                                    <tr>
                                                        <td>${v.tgl_pesanan}</td>
                                                        <td>${v.no_pesanan}</td>
                                                        <td>${v.nama_customer}</td>
                                                        <td>${v.alamat_kirim}</td>
                                                        <td>${v.status}</td>
                                                        <td>${v.tgl_kirim}</td>
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

                var bulan = $('#bulan').val();
                var tahun = $('#tahun').val();

                if(bulan === '' || tahun === ''){
                    Swal.fire({
                        position: 'center',
                        type: 'warning',
                        title: 'Silahkan isi periode laporan',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    $.ajax({
                        url: `<?= base_url('api/pesanan/laporan/') ?>${auth.token}?bulan=${bulan}&tahun=${tahun}`,
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