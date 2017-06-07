<html>
  <head>
      <meta charset="utf-8" />
      <title>Wikiprecios</title>
      <script type = 'text/javascript' src = "<?= base_url('js/jquery.min.js');?>"></script>
      <link rel= "stylesheet" type ="text/css" href="<?= base_url('styles/bootstrap-material.min.css'); ?>">
      <link rel= "stylesheet" type ="text/css" href="<?= base_url('styles/animate.css'); ?>">
      <script type = 'text/javascript' src = "<?= base_url('js/bootstrap-notify.min.js');?>"></script>
      <script type = 'text/javascript' src = "<?= base_url('js/bootstrap.min.js');?>"></script>
  </head>

  <body>
      <div class="row">
          <div class="col-lg-3 col-lg-offset-4">
              <form class="form-signin" action="<?= base_url('recuperar_clave'); ?>" method="POST">
                  <h3>Restablecer Contraseña</h3>
                  <h2> </h2>
                  <h4>Su nueva contraseña se le enviara a su cuenta de correo electrónico,
                      podrá cambiarla una vez iniciada la sesión.</h4>
                  <br>

                  <h4>Ingrese su email:</h4>
                    <input type="email" class="form-control" name="mail" placeholder="nombre@dominio.com">
                  <h3></h3>

                  <button class="btn btn-lg btn-primary btn-block" name="submit" value="entrar" type="submit">Enviar</button>
                  <h3></h3>
              </form>

              <a href="<?= base_url(); ?>">Volver al inicio</a>

              <div style="text-align: center;">
                  <?php if (isset($error)) { ?>
                      <script>$.notify('<strong></strong><?= $error;?>',
                      { allow_dismiss: true, type: 'danger', placement: {from: 'bottom', align: 'right'}});</script>

                  <?php } if (isset($warning)) { ?>
                      <script>$.notify('<strong>Atención!  </strong><?= $warning;?>',
                      { allow_dismiss: true, type: 'warning', placement: {from: 'bottom', align: 'right'}});</script>

                  <?php } if (isset($success)) {?>
                      <script>$.notify('<strong></strong><?= $success;?>',
                      { allow_dismiss: true, type: 'success', placement: {from: 'bottom', align: 'right'}});</script>
                  <?php } ?>
              </div>

          </div><!-- /.col-lg-4 -->
      </div>
  </body>
  </html>
