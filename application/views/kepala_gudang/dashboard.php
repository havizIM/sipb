<div class="container-fluid">
  <div class="row page-titles">
      <div class="col-md-5 align-self-center">
          <h4 class="text-themecolor">Dashboard</h4>
      </div>
      <div class="col-md-7 align-self-center text-right">
          <div class="d-flex justify-content-end align-items-center">
              <ol class="breadcrumb">
                  <li class="breadcrumb-item active">Dashboard</li>
              </ol>
          </div>
      </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body" style="padding-bottom:7%;">
          <img src="<?= base_url().'assets/images/welcome.png' ?>" class="img-responsive animated rubberBand" alt="Selamat Datang" style="width:530px; position:relative;">
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card" style="background-color:#a978fb !important;">
        <div class="card-body">
          <h5 class="card-title">Memorandum</h5>
          <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
            <span class="display-5 text-white"><i class="fas fa-file"></i></span>
            <a  class="link display-5 ml-auto"> <span id="data_10">0</span> </a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card bg-warning">
        <div class="card-body">
          <h5 class="card-title">Pesanan</h5>
          <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
            <span class="display-5 text-white"><i class="ti-shopping-cart"></i></span>
            <a  class="link display-5 ml-auto"> <span id="data_5">0</span> </a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card bg-danger">
        <div class="card-body">
          <h5 class="card-title">Barang Masuk</h5>
          <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
            <span class="display-5 text-white"><i class="fas fa-arrow-down"></i></span>
            <a  class="link display-5 ml-auto"> <span id="data_6">0</span> </a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card bg-danger">
        <div class="card-body">
          <h5 class="card-title">Barang Keluar</h5>
          <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
            <span class="display-5 text-white"><i class="fas fa-arrow-up"></i></span>
            <a  class="link display-5 ml-auto"> <span id="data_7">0</span> </a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card bg-primary">
        <div class="card-body">
          <h5 class="card-title">Data Barang</h5>
          <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
            <span class="display-5 text-white"><i class="ti-package"></i></span>
            <a  class="link display-5 ml-auto"> <span id="data_1">0</span> </a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card bg-primary">
        <div class="card-body">
          <h5 class="card-title">Stok Barang</h5>
          <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
            <span class="display-5 text-white"><i class="ti-package"></i></span>
            <a  class="link display-5 ml-auto"> <span id="data_2">0</span> </a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="col-md-12">
        <div class="card bg-success">
          <div class="card-body">
            <h5 class="card-title">Pelanggan</h5>
            <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
              <span class="display-5 text-white"><i class="icon-people"></i></span>
              <a  class="link display-5 ml-auto"> <span id="data_3">0</span> </a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="card bg-success">
          <div class="card-body">
            <h5 class="card-title">Pemasok</h5>
            <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
              <span class="display-5 text-white"><i class="icon-people"></i></span>
              <a  class="link display-5 ml-auto"> <span id="data_4">0</span> </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="col-md-12">
        <div class="card bg-info">
          <div class="card-body">
            <h5 class="card-title">Retur Pelanggan</h5>
            <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
              <span class="display-5 text-white"><i class=" fas fa-exchange-alt"></i></span>
              <a  class="link display-5 ml-auto"> <span id="data_9">0</span> </a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="card bg-info">
          <div class="card-body">
            <h5 class="card-title">Retur Pemasok</h5>
            <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
              <span class="display-5 text-white"><i class=" fas fa-exchange-alt"></i></span>
              <a  class="link display-5 ml-auto"> <span id="data_8">0</span> </a>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {

      var session = localStorage.getItem('sipb');
      var auth = JSON.parse(session);
      var token = auth.token

    var data_1 = `<?= base_url().'api/barang/show/' ?>${token}`
    var data_2 = `<?= base_url().'api/stock/show/' ?>${token}`
    var data_3 = `<?= base_url().'api/customer/show/' ?>${token}`
    var data_4 = `<?= base_url().'api/supplier/show/' ?>${token}`
    var data_5 = `<?= base_url().'api/pesanan/show/' ?>${token}`
    var data_6 = `<?= base_url().'api/barang_keluar/show/' ?>${token}`
    var data_7 = `<?= base_url().'api/barang_masuk/show/' ?>${token}`
    var data_8 = `<?= base_url().'api/return_keluar/show/' ?>${token}`
    var data_9 = `<?= base_url().'api/return_masuk/show/' ?>${token}`
    var data_10 = `<?= base_url().'api/memorandum/show/' ?>${token}`

    $.ajax({
      url: data_1,
      type: 'GET',
      dataType: 'JSON',
      // data: {},
      // beforeSend:function(){},
      success:function(response){

        $('#data_1').text(response.data.length)
      },
      error:function(err){}
    });
    $.ajax({
      url: data_2,
      type: 'GET',
      dataType: 'JSON',
      // data: {},
      // beforeSend:function(){},
      success:function(response){

        $('#data_2').text(response.data.length)
      },
      error:function(err){}
    });
    $.ajax({
      url: data_3,
      type: 'GET',
      dataType: 'JSON',
      // data: {},
      // beforeSend:function(){},
      success:function(response){

        $('#data_3').text(response.data.length)
      },
      error:function(err){}
    });
    $.ajax({
      url: data_4,
      type: 'GET',
      dataType: 'JSON',
      // data: {},
      // beforeSend:function(){},
      success:function(response){

        $('#data_4').text(response.data.length)
      },
      error:function(err){}
    });
    $.ajax({
      url: data_5,
      type: 'GET',
      dataType: 'JSON',
      // data: {},
      // beforeSend:function(){},
      success:function(response){

        $('#data_5').text(response.data.length)
      },
      error:function(err){}
    });
    $.ajax({
      url: data_6,
      type: 'GET',
      dataType: 'JSON',
      // data: {},
      // beforeSend:function(){},
      success:function(response){

        $('#data_6').text(response.data.length)
      },
      error:function(err){}
    });
    $.ajax({
      url: data_7,
      type: 'GET',
      dataType: 'JSON',
      // data: {},
      // beforeSend:function(){},
      success:function(response){

        $('#data_7').text(response.data.length)
      },
      error:function(err){}
    });
    $.ajax({
      url: data_8,
      type: 'GET',
      dataType: 'JSON',
      // data: {},
      // beforeSend:function(){},
      success:function(response){

        $('#data_8').text(response.data.length)
      },
      error:function(err){}
    });
    $.ajax({
      url: data_9,
      type: 'GET',
      dataType: 'JSON',
      // data: {},
      // beforeSend:function(){},
      success:function(response){

        $('#data_9').text(response.data.length)
      },
      error:function(err){}
    });
    $.ajax({
      url: data_10,
      type: 'GET',
      dataType: 'JSON',
      // data: {},
      // beforeSend:function(){},
      success:function(response){

        $('#data_10').text(response.data.length)
      },
      error:function(err){}
    });


  });
</script>
