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

  <section id="wrapper" class="login-register login-sidebar" style="background-image:url('<?= base_url(''); ?>assets/images/background/login-register.jpg');">
    <div class="login-box card">
      <div class="card-body">
        <form class="form-horizontal form-material text-center" id="loginform" action="index.html">
          <a href="javascript:void(0)" class="db"><img src="<?= base_url(''); ?>assets/images/logo-icon.png" alt="Home" /><br/><img src="<?= base_url(''); ?>assets/images/logo-text.png" alt="Home" /></a>
          <div class="form-group m-t-40">
            <div class="col-xs-12">
              <input class="form-control" id="username" type="text" required="" placeholder="Username">
            </div>
          </div>
          <div class="form-group">
            <div class="col-xs-12">
              <span class="btn-show-pass">
                <i class="fa fa-fw fa-eye" style="margin-bottom: 240px;"></i>
              </span>
              <input class="form-control" id="password" type="password" required="" placeholder="Password">
            </div>
          </div>
          <div class="form-group text-center m-t-20">
            <div class="col-xs-12">
              <button class="btn btn-info btn-lg btn-block text-uppercase btn-rounded" type="submit">Log In</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>

  <script src="<?= base_url(''); ?>assets/node_modules/jquery/jquery-3.2.1.min.js"></script>

  <script src="<?= base_url(''); ?>assets/node_modules/popper/popper.min.js"></script>

  <script src="<?= base_url(''); ?>assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

  <script type="text/javascript">

    $(document).ready(function(){

      var showPass = 0;
      $('.btn-show-pass').on('click', function(){
        if(showPass == 0) {
          $(this).next('input').attr('type', 'text');
          $(this).find('i').removeClass('fa-eye');
          $(this).find('i').addClass('fa-eye-slash');
          showPass = 1;
        } else {
          $(this).next('input').attr('type', 'password');
          $(this).find('i').addClass('fa-eye');
          $(this).find('i').removeClass('fa-eye-slash');
          showPass = 0;
        }
      });

    });

  </script>

</body>

</html>
