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
    <div class="col-md-4">
      <div class="card bg-primary">
        <div class="card-body">
          <h5 class="card-title">Total Pelanggan</h5>
          <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
            <span class="display-5 text-white"><i class="icon-people"></i></span>
            <a  class="link display-5 ml-auto"> <span id="data_1">0</span> </a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card bg-info">
        <div class="card-body">
          <h5 class="card-title">Total Barang</h5>
          <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
            <span class="display-5 text-white"><i class="ti-package"></i></span>
            <a  class="link display-5 ml-auto"> <span id="data_2">0</span> </a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card bg-warning">
        <div class="card-body">
          <h5 class="card-title">Pesanan</h5>
          <div class="d-flex m-t-30 m-b-20 no-block align-items-center">
            <span class="display-5 text-white"><i class="ti-shopping-cart"></i></span>
            <a  class="link display-5 ml-auto"> <span id="data_3">0</span> </a>
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

    var data_1 = `<?= base_url().'api/customer/show/' ?>${token}`
    var data_2 = `<?= base_url().'api/barang/show/' ?>${token}`
    var data_3 = `<?= base_url().'api/pesanan/show/' ?>${token}`

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
  });
</script>
