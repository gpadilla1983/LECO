<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/public/css/main.css">
  <!-- Font-icon css-->
  <link rel="icon" type="image/png" href="<?= base_url(); ?>/public/images/icono.png">
  <link rel="stylesheet" type="text/css"
    href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>Login - LECO</title>
</head>

<body>
  <section class="material-half-bg">
    <div class="cover"></div>
  </section>
  <section class="login-content">
    <div>
      <img src="<?= base_url(); ?>/public/images/LOGO.jpeg" style="widht:350px; height:280px" alt="Logo">
      <br></br>
    </div>
    <div class="col-md-4">
      <?php if (isset($alerta)): ?>

        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
              aria-hidden="true">&times;</span></button>
          <?= $alerta ?>
        </div>

      <?php endif; ?>
    </div>

    <div class="login-box">
      <form class="login-form" action="<?= base_url(); ?>LoginController/authenticate" method="POST">
        <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>Inicio de Sesión</h3>
        <div class="form-group">

          <label class="control-label" for="tbx_usuario">Usuario</label>
          <input class="form-control" type="text" id="tbx_usuario" name="tbx_usuario" placeholder="Usuario" autofocus>
        </div>
        <div class="form-group">
          <label class="control-label" for="tbx_password">Contraseña</label>
          <input class="form-control" type="password" id="tbx_password" name="tbx_password" placeholder="Contraseña">
        </div>
        <div class="form-group btn-container">
          <button class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>Inicio</button>
        </div>
      </form>
    </div>
  </section>
  <!-- Essential javascripts for application to work-->
  <script src="<?= base_url(); ?>/public/js/jquery-3.3.1.min.js"></script>
  <!--<script src="<?= base_url(); ?>/public/js/popper.min.js"></script>-->
  <script src="<?= base_url(); ?>/public/js/bootstrap.min.js"></script>
  <script src="<?= base_url(); ?>/public/js/main.js"></script>
  <!-- The javascript plugin to display page loading on top-->
  <script src="<?= base_url(); ?>/public/js/plugins/pace.min.js"></script>
  <script type="text/javascript">
    // Login Page Flipbox control
    $('.login-content [data-toggle="flip"]').click(function () {
      $('.login-box').toggleClass('flipped');
      return false;
    });
  </script>
</body>

</html>