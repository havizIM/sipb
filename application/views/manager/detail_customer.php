<div class="container-fluid">
  <div class="row page-titles">
      <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Riwayat Pesanan</h4>
      </div>
      <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#/customer">Customer</a></li>
            <li class="breadcrumb-item active">Riwayat Pesanan</li>
          </ol>
        </div>
      </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header" style="background-color: #d63b70">
          <h4 class="m-b-0 text-white">Detail Customer</h4>
        </div>
        <div class="card-body" id="detail_pesanan">

        </div>
      </div>
    </div>
  </div>


</div>

<script>
    var renderUI = (() => {
        return {
            renderRiwayat: (data) => {
                var html = '';

                $.each(data, function(k, v){
                    html += `
                        <h4 class="card-title">Detail Riwayat Pesanan</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>ID Pelanggan</th>
                                        <td>${v.id_customer}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Pelanggan</th>
                                        <td>${v.nama_customer}</td>
                                    </tr>
                                    <tr>
                                        <th>Telepon</th>
                                        <td>${v.telepon}</td>
                                    </tr>
                                    <tr>
                                        <th>Fax</th>
                                        <td>${v.fax}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>${v.email}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td>${v.alamat}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-info text-white">
                                    <div class="card-body">
                                    <h5 class="card-title">Total Pesanan</h5>
                                    <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
                                        <span class="display-5 text-white"><i class="ti-package"></i></span>
                                        <a class="link display-5 ml-auto"> <span id="data_2">${v.pesanan.length}</span> </a>
                                    </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr class="bg-info text-white">
                                                <th>No Pesanan</th>
                                                <th>Tgl Pesanan</th>
                                                <th>Tgl Kirim</th>
                                                <th>Alamat Kirim</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>`
                                        
                                        if(v.pesanan.length !== 0){
                                            $.each(v.pesanan, function(k1, v1){
                                                html += `
                                                    <tr>
                                                        <td>${v1.no_pesanan}</td>
                                                        <td>${v1.tgl_pesanan}</td>
                                                        <td>${v1.tgl_kirim}</td>
                                                        <td>${v1.alamat_kirim}</td>
                                                        <td>${v1.status}</td>
                                                    </tr>
                                                `;
                                            })
                                        } else {
                                            html += `
                                                <tr><td colspan="5"><center>Tidak ada riwayat pesanan</center></td></tr>
                                            `
                                        }

                html += 
                                        `</tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    `;
                })


                $('#detail_pesanan').html(html);
            }
        }
    })();

    var riwayatController = ((UI) => {
        var id_customer = location.hash.substr(10)
        var session = localStorage.getItem('sipb');
        var auth = JSON.parse(session);

        var getRiwayat = () => {
            $.ajax({
                url: `<?= base_url('api/customer/riwayat/') ?>${auth.token}?id_customer=${id_customer}`,
                type: 'GET',
                dataType: 'JSON',
                success: function(res){
                    if(res.status === 200){
                        UI.renderRiwayat(res.data);
                    } else {
                        alert('Tidak dapat mengakses server');
                    }
                },
                error: function(err){
                    alert('Tidak dapat mengakses server')
                }
            })
        }

        return {
            init: () => {
                getRiwayat();
            }
        }
    })(renderUI);

    $(document).ready(function(){
        riwayatController.init();
    })
</script>