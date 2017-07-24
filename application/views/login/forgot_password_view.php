<html>

    <body>
      <div class="row">
          <div class="col-lg-3 col-lg-offset-4">
              <form class="form-signin" action="<?= site_url('Forgot_password_controller/forgot_password'); ?>" method="POST">
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
          </div><!-- /.col-lg-4 -->
      </div>
  </body>

</html>
