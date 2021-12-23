<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo URL?>public/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo URL?>public/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo URL?>public/dist/css/adminlte.min.css">
  <link src="<?php echo URL?>public/css/sweetalert2/bootstrap-4.css" rel="stylesheet">
  <script src='https://www.google.com/recaptcha/api.js?render=<?php echo SITE_KEY; ?>'></script>
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="../../index2.html"><b>DATA</b>CIX</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form id="frmlogin" action="<?php echo URL ?>login/login">
          <div class="input-group mb-3">
            <input id="user" name="user" type="text" class="form-control" placeholder="Usuario" autocomplete="off">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3"><input type="hidden" id="token" name="token" />
            <input id="clave" name="clave" type="password" class="form-control" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="social-auth-links text-center mb-3">
            <button type="submit" class="btn btn-block btn-danger">
              INGRESAR
            </button>
          </div>
        </form>

      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="<?php echo URL?>public/plugins/jquery/jquery.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo URL?>public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo URL?>public/dist/js/adminlte.min.js"></script>
  <script src="<?php echo URL?>public/js/sweetalert2/sweetalert2.all.min.js"></script>
</body>
<script>
  $(function () {
        grecaptcha.ready(function () {
          grecaptcha.execute('<?php echo SITE_KEY?>', {
            action: 'submit'
          }).then(function (token) {
            //console.log(token);
            $('#token').val(token);
            // console.log(user) ;
            //console.log(clave) ; 
          });
        });


        $("#frmlogin").on('submit', function (e) {
          e.preventDefault()
          grecaptcha.ready(function () {
            grecaptcha.execute('<?php echo SITE_KEY?>', {
              action: 'submit'
            }).then(function (token) {
              //console.log(token);
              $('#token').val(token);
              // console.log(user) ;
              //console.log(clave) ; 
            });
          });


          let url = $(this).attr('action');
          var data = $(this).serialize();

          $.ajax({
            type: 'POST',
            url: url,
            data: data,
            dataType:'json',
            success: function (response) {
              console.log(response)
              if (response.includes('Validacion de usuario')) {
                window.location = 'dashboard';
              }
              if (response.includes('Problemas internos')) {
                Swal.fire({
                  icon: 'error',
                  title: response,
                }).then(function () {

                });
              }
              if (response.includes('Usuario no existe')) {
                Swal.fire({
                  icon: 'error',
                  title: response,
                }).then(function () {

                });
              }
            },
            error: function (jqXHR, textStatus, errorThrown) {
              console.log(jqXHR, textStatus, errorThrown.toString())
            }
          });
        });
      });
</script>

</html>