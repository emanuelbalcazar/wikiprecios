<html>
    <meta charset="utf-8" />
    <title>Wikiprecios</title>

    <body>
        <div class="row">
            <div class="col-lg-3 col-lg-offset-4">
                <form class="form-signin" action="<?= base_url('desactivar_cuenta'); ?> "method="POST">
                    <h3>Importante:</h3>
                    <h4>Al desactivar su cuenta, no podrá reactivarla de nuevo, iniciar sesión
                         o registrarse usando el mismo correo electronico.</h4>
                    <br>

                    <h4>Ingrese su contraseña:</h4>
                        <input type="password" class="form-control " name="password"  placeholder="Contraseña">
                    <h3></h3>
                    <button class="btn btn-lg btn-primary btn-block" name="submit" value="entrar" type="submit">Desactivar Cuenta</button>
                    <p></p>

                </form>

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
