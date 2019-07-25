<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="description" content="">

  <meta name="author" content="">

  <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url(''); ?>assets/images/logo-mini.png">

  <title>Login | SIPB</title>

  <link href="<?= base_url(''); ?>assets/dist/css/pages/login-register-lock.css" rel="stylesheet">

  <link href="<?= base_url(''); ?>assets/dist/css/style.min.css" rel="stylesheet">

  <script src="<?= base_url(''); ?>assets/node_modules/jquery/jquery-3.2.1.min.js"></script>

  <link href="<?= base_url(''); ?>assets/node_modules/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">

  <script type="text/javascript">

    function cek_auth(){
      var session = localStorage.getItem('sipb');
      var auth = JSON.parse(session);

      if (session) {
        window.location.replace('<?= base_url() ?>'+auth.level+'/')
      };
    };

    cek_auth();

  </script>

  <style media="screen">



  </style>

</head>

<body class="skin-default card-no-border">

  <section id="wrapper" class="login-register login-sidebar" style="background-image:url('<?= base_url(''); ?>assets/images/background-login2.jpg');">
    <div class="login-box card">
      <div class="card-body">
        <form class="form-horizontal form-material text-center" id="form_login" action="index.html">
          <a href="javascript:void(0)" class="db"><img src="<?= base_url(''); ?>assets/images/logo.png" alt="Home" style="width: 65%;"></a>
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

  <script src="<?= base_url(''); ?>assets/node_modules/sweetalert/sweetalert.min.js"></script>

  <script src="<?= base_url(''); ?>assets/node_modules/sweetalert/jquery.sweet-alert.custom.js"></script>

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
          Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: 'Isi dulu Username dan Passwordnya',
            showConfirmButton: false,
            timer: 1500
          })
        } else {
          $.ajax({
            url: '<?= base_url('api/auth/login_user'); ?>',
            type: 'POST',
            dataType: 'JSON',
            beforeSend: function(){
              $('#btn_login').addClass('disabled').attr('disabled', 'disabled').html('<i class="fa fa-fw fa-spinner fa-spin"></i>');
            },
            data: $('#form_login').serialize(),
            success: function(response){
              if(response.status === 200){
                localStorage.setItem('sipb', JSON.stringify(response.data));
                var link = '<?= base_url('') ?>'+response.data.level+'/'
                window.location.replace(link);
              } else {
                Swal.fire({
                  type: 'error',
                  title: 'Oops...',
                  text: response.message,
                  showConfirmButton: false,
                  timer: 1500
                })
                $('#btn_login').removeClass('disabled').removeAttr('disabled', 'disabled').text('Masuk');
              }
            },
            error: function(){
              Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Tidak dapat mengakses server',
                showConfirmButton: false,
                timer: 1500
              })
              $('#btn_login').removeClass('disabled').removeAttr('disabled', 'disabled').text('Masuk');
            }
          });
        }
      });

    });

  </script>

</body>

</html>
