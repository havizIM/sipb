<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">

  <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url(''); ?>assets/images/favicon.png">

  <title>Login | SIPB</title>

  <link href="<?= base_url(''); ?>assets/dist/css/pages/login-register-lock.css" rel="stylesheet">

  <link href="<?= base_url(''); ?>assets/dist/css/style.min.css" rel="stylesheet">

  <script src="<?= base_url(''); ?>assets/node_modules/jquery/jquery-3.2.1.min.js"></script>

  <script type="text/javascript">

    // function cek_auth(){
    //   var session = localStorage.getItem('session');
    //   var auth = JSON.parse(session);
    //
    //   if (session) {
    //     window.location.replace('<?= base_url() ?>'+auth.hak_akses+'/')
    //   };
    // };
    //
    // cek_auth();
    //
  </script>

  <style media="screen">

    .btn-show-pass {
      font-size: 15px;
      color: #999999;

      display: -webkit-box;
      display: -webkit-flex;
      display: -moz-box;
      display: -ms-flexbox;
      display: flex;
      align-items: center;
      position: absolute;
      height: 100%;
      top: 0;
      right: 0;
      padding-right: 5px;
      margin-right: 13px;
      cursor: pointer;
      -webkit-transition: all 0.4s;
      -o-transition: all 0.4s;
      -moz-transition: all 0.4s;
      transition: all 0.4s;
    }

    .btn-show-pass:hover {
      color: #6a7dfe;
      color: -webkit-linear-gradient(left, #21d4fd, #b721ff);
      color: -o-linear-gradient(left, #21d4fd, #b721ff);
      color: -moz-linear-gradient(left, #21d4fd, #b721ff);
      color: linear-gradient(left, #21d4fd, #b721ff);
    }

    .btn-show-pass.active {
      color: #6a7dfe;
      color: -webkit-linear-gradient(left, #21d4fd, #b721ff);
      color: -o-linear-gradient(left, #21d4fd, #b721ff);
      color: -moz-linear-gradient(left, #21d4fd, #b721ff);
      color: linear-gradient(left, #21d4fd, #b721ff);
    }

  </style>

</head>

<body class="skin-default card-no-border">

  <section id="wrapper" class="login-register login-sidebar" style="background-image:url('<?= base_url(''); ?>assets/images/background-login.jpg');">
    <div class="login-box card">
      <div class="card-body">
        <form class="form-horizontal form-material text-center" id="form_login" action="index.html">
          <a href="javascript:void(0)" class="db"><img src="<?= base_url(''); ?>assets/images/logo.png" alt="Home" style="width: 50%;"></a>
          <div class="form-group m-t-40">
            <div class="col-xs-12">
              <input class="form-control" id="username" name="username" type="text" required="" placeholder="Username">
            </div>
          </div>
          <div class="form-group">
            <div class="col-xs-12">
              <input class="form-control" id="password" name="password" type="password" required="" placeholder="Password">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-md-12">
              <div class="d-flex no-block align-items-center">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input btn_show" id="customCheck1">
                  <label class="custom-control-label" for="customCheck1">Lihat Password</label>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group text-center m-t-20">
            <div class="col-xs-12">
              <button class="btn btn-info btn-lg btn-block text-uppercase btn-rounded" id="btn_login" type="submit">Masuk</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>

  <script src="<?= base_url(''); ?>assets/node_modules/popper/popper.min.js"></script>

  <script src="<?= base_url(''); ?>assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

  <script type="text/javascript">

    $(document).ready(function(){

      $('.btn_show').on('change', function(){
        var checked = $(this).prop('checked');

        if (checked) {
          $('#password').attr('type', 'text');
        } else {
          $('#password').attr('type', 'password');
        }
      });

      $('#form_login').on('submit', function(e){
        e.preventDefault();

        var username = $('#username').val();
        var password = $('#password').val();

        if(username === '' || password === ''){
          alert('Username atau Password tidak boleh kosong');
        } else {
          $.ajax({
            url: '<?= base_url('api/auth/login_user'); ?>',
            type: 'POST',
            dataType: 'JSON',
            beforeSend: function(){
              $('#btn_login').addClass('disabled').attr('disabled', 'disabled').html('<i class="fa fa-refresh fa-spin"></i>');
            },
            data: $('#form_login').serialize(),
            success: function(response){
              if(response.status === 200){
                localStorage.setItem('sipb', JSON.stringify(response.data));
                window.location.replace('<?= base_url() ?>'+response.data.hak_akses+'/')
              } else {
                alert(response.message);
              }
              $('#btn_login').removeClass('disabled').removeAttr('disabled', 'disabled').text('Masuk');
            },
            error: function(){
              alert(response.message);
              $('#btn_login').removeClass('disabled').removeAttr('disabled', 'disabled').text('Masuk');
            }
          });
        }
      });

    });

  </script>

</body>

</html>
