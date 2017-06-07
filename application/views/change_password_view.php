<html>
    <meta charset="utf-8" />
    <title>Wikiprecios</title>

    <body>
        <div class="row">
            <div class="row">
                <div class="col-lg-4 col-lg-offset-4" >
                <h3>Cambiar contraseña</h3>
            </div>
            <div class="col-lg-3 col-lg-offset-4">
                <form class="form-signin" action="<?= base_url('cambiar_clave_admin'); ?>" method="POST">

                    <h4>Ingrese su contraseña actual:</h4>
                        <input type="password" class="form-control " name="old_password"  placeholder="Contraseña actual">
                    <h3></h3>
                    <h4>Ingrese la nueva contraseña:</h4>
                        <input type="password" class="form-control " name="new_password"  placeholder="Contraseña nueva">
                    <h3></h3>
                    <button class="btn btn-lg btn-primary btn-block" name="submit" value="entrar" type="submit">Cambiar</button>
                    <h3></h3>
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
