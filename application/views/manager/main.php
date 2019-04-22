<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">

    <meta name="author" content="">

    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url(''); ?>assets/images/logo-mini.png">

    <title>Manager | SIMPB</title>

    <script src="<?= base_url(''); ?>assets/node_modules/jquery/jquery-3.2.1.min.js"></script>

    <script type="text/javascript">

      function cek_auth(){
        var session = localStorage.getItem('sipb');
        var auth = JSON.parse(session);

        if(!session) {
          window.location.replace('<?= base_url().'login' ?>');
        } else {
          if(auth.level !== 'manager'){
            window.location.replace('<?= base_url().'' ?>'+auth.level+'/');
          }
        };
      };

      cek_auth();

    </script>

    <link href="<?= base_url('assets/'); ?>dist/css/style.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css"/>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.2/css/responsive.bootstrap4.min.css"/>

    <style media="screen">

      .img-sidebar {
        background-image: url(<?= base_url(''); ?>assets/images/bg-sidebar.png);
        background-size: 420px;
        background-repeat: no-repeat;
        background-position: bottom;
      }

    </style>

  </head>

  <body class="skin-red fixed-layout">

    <div id="main-wrapper">

      <header class="topbar">
        <nav class="navbar top-navbar navbar-expand-md navbar-dark">
          <div class="navbar-header">
           <a class="navbar-brand" href="index.html">
            <b>
              <img src="<?= base_url(''); ?>assets/images/logo-mini.png" alt="homepage" class="light-logo" />
            </b>
            <span>
             <img src="<?= base_url(''); ?>assets/images/logo-text.png" alt="homepage" class="light-logo" style="margin-left: -15px;">
            </span>
           </a>
          </div>

          <div class="navbar-collapse">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item"> <a class="nav-link nav-toggler d-block d-md-none waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a></li>
              <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="icon-menu"></i></a></li>
            </ul>

            <ul class="navbar-nav my-lg-0">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="ti-user"></i>
                  <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                </a>

                <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown">
                  <ul>
                    <li>
                      <div class="drop-title">Informasi User</div>
                    </li>
                    <li>
                      <div class="message-center" style="height: 250px;">

                          <a href="javascript:void(0)">
                            <span><i class="ti-user"></i></span>
                            <div class="mail-contnet">
                              <h5>ID User</h5>
                              <span class="mail-desc id-user"></span>
                            </div>
                          </a>

                          <a href="javascript:void(0)">
                            <span><i class="ti-id-badge"></i></span>
                            <div class="mail-contnet">
                              <h5>Username</h5>
                              <span class="mail-desc username"></span>
                            </div>
                          </a>

                          <a href="javascript:void(0)">
                            <span><i class="ti-arrow-circle-up"></i></span>
                            <div class="mail-contnet">
                              <h5>Level</h5>
                              <span class="mail-desc level"></span>
                            </div>
                          </a>

                          <a href="javascript:void(0)">
                            <span><i class="ti-calendar"></i></span>
                            <div class="mail-contnet">
                              <h5>Tanggal Registrasi</h5>
                              <span class="mail-desc tgl-regis"></span>
                            </div>
                          </a>
                        </div>
                      </li>
                    </ul>
                  </div>
                </li>

              <li class="nav-item dropdown u-pro">
                <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?= base_url(''); ?>assets/images/users/1.jpg" alt="user" class=""> <span class="hidden-md-down nama"><i class="fa fa-angle-down"></i></span> </a>
                <div class="dropdown-menu dropdown-menu-right animated flipInY">
                  <a id="btn_modal_ganti" class="dropdown-item" style="cursor: pointer;"><i class="ti-lock"></i> Ganti Password</a>
                  <a id="btn_logout" class="dropdown-item" style="cursor: pointer;"><i class="fa fa-power-off"></i> Logout</a>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>

      <aside class="left-sidebar img-sidebar">
        <div class="scroll-sidebar">
          <nav class="sidebar-nav">
            <ul id="sidebarnav">
              <li class="user-pro"> <a class=" waves-effect waves-dark" aria-expanded="false"><img src="<?= base_url(''); ?>assets/images/users/1.jpg" alt="user-img" class="img-circle"><span class="hide-menu nama"></span></a>
              </li>

              <li>
                <a class="waves-effect waves-dark" href="#/dashboard" aria-expanded="false">
                  <i class="icon-speedometer"></i><span class="hide-menu">Dashboard</span>
                </a>
              </li>

            </ul>
          </nav>
        </div>
      </aside>

      <div class="page-wrapper" id="content">

      </div>

      <div id="modal_ganti" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="vcenter">Ganti Password</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <form class="form-horizontal" method="post" id="form_ganti">
              <div class="modal-body form-group">
                <div class="form-group">
                  <input type="password" class="form-control" name="password_lama" id="password_lama" placeholder="Password Lama">
                </div>

                <div class="form-group">
                  <input type="password" class="form-control" name="password_baru" id="password_baru" placeholder="Password Baru">
                </div>

                <div class="form-group">
                  <input type="password" class="form-control" name="re_password" id="re_password" placeholder="Konfirmasi Password">
                </div>
              </div>

              <div class="modal-footer">
                <button type="submit" id="btn_ganti" class="btn btn-info waves-effect">Ganti</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <footer class="footer">
        © 2019 Sistem Informasi Manajemen Persediaan Barang
      </footer>
    </div>

    <script src="<?= base_url(''); ?>assets/node_modules/jquery/jquery-3.2.1.min.js"></script>

    <script src="<?= base_url(''); ?>assets/node_modules/popper/popper.min.js"></script>

    <script src="<?= base_url(''); ?>assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

    <script src="<?= base_url(''); ?>assets/dist/js/perfect-scrollbar.jquery.min.js"></script>

    <script src="<?= base_url(''); ?>assets/dist/js/waves.js"></script>

    <script src="<?= base_url(''); ?>assets/dist/js/sidebarmenu.js"></script>

    <script src="<?= base_url(''); ?>assets/node_modules/sticky-kit-master/dist/sticky-kit.min.js"></script>

    <script src="<?= base_url(''); ?>assets/node_modules/sparkline/jquery.sparkline.min.js"></script>

    <script src="<?= base_url(''); ?>assets/dist/js/custom.min.js"></script>

    <script src="<?= base_url(''); ?>assets/node_modules/sweetalert/sweetalert.min.js"></script>

    <script src="<?= base_url(''); ?>assets/node_modules/sweetalert/jquery.sweet-alert.custom.js"></script>

    <script type="text/javascript">

      function load_content(link){

        $.get(`<?= base_url('manager/'); ?>${link}`, function(response){
          $('#content').html(response);
        })
      }

      $(document).ready(function(){

        var link;
        var session = localStorage.getItem('sipb');
        var auth = JSON.parse(session);

        $('.nama').text(auth.nama_user);
        $('.id-user').text(auth.id_user);
        $('.username').text(auth.username);
        $('.level').text(auth.level);
        $('.tgl-regis').text(auth.tgl_registrasi);

        if(location.hash){
          link = location.hash.substr(2);
          load_content(link);
        } else {
          location.hash = '#/dashboard'
        }

        $(window).on('hashchange', function(){
          link = location.hash.substr(2);
          load_content(link);
        })

        $('#btn_logout').on('click', function(){
          Swal.fire({
            title: 'Apa Anda yakin ingin keluar?',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Saya yakin.',
            cancelButtonText: 'Batal'
          }).then((result) => {
            if (result.value) {
              $.ajax({
                url: '<?= base_url('api/auth/logout_user/') ?>'+auth.token,
                type: 'GET',
                dataType: 'JSON',
                success: function(response){
                  localStorage.clear();
                  window.location.replace('<?= base_url().'auth' ?>');
                }
              });
            }
          })
        });

        $('#btn_modal_ganti').on('click', function(){
          $('#modal_ganti').modal('show');
        });

        $('#form_ganti').on('submit', function(e){
          e.preventDefault();

          var password_lama = $('#password_lama').val();
          var password_baru = $('#password_baru').val();
          var re_password = $('#re_password').val();

          if(password_lama === '' || password_baru === '') {
            Swal.fire({
              position: 'center',
              type: 'warning',
              title: 'Data tidak boleh kosong',
              showConfirmButton: false,
              timer: 1500
            });
          } else if (password_baru !== re_password) {
            Swal.fire({
              position: 'center',
              type: 'warning',
              title: 'Password belum sama',
              showConfirmButton: false,
              timer: 1500
            });
          } else {
            $.ajax({
              url: '<?= base_url('api/auth/password_user/') ?>'+auth.token,
              type: 'POST',
              dataType: 'JSON',
              beforeSend: function(){
                $('#btn_ganti').addClass('disabled').attr('disabled', 'disabled').html('<i class="fa fa-fw fa-spinner fa-spin"></i>');
              },
              data: {
                password_lama: password_lama,
                password_baru: password_baru
              },
              success: function(response){
                if(response.status === 200){
                  Swal.fire({
                    position: 'center',
                    type: 'success',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1500
                  });
                  $('#form_ganti')[0].reset();
                  $('#modal_ganti').modal('hide');
                } else {
                  Swal.fire({
                    position: 'center',
                    type: 'warning',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1500
                  });
                }
                $('#btn_ganti').removeClass('disabled').removeAttr('disabled', 'disabled').text('Ganti')
              },
              error: function(){
                Swal.fire({
                  position: 'center',
                  type: 'warning',
                  title: 'Tidak dapat mengakses server',
                  showConfirmButton: false,
                  timer: 1500
                });
                $('#btn_ganti').removeClass('disabled').removeAttr('disabled', 'disabled').text('Ganti')
              }
            });
          }
        });

      });

    </script>

  </body>

</html>
