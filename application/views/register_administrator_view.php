<html>
    <meta charset="utf-8" />

    <body>
        <div class="row">
            <div class="col-lg-4 col-lg-offset-4" >
            <h3>Nuevo usuario</h3>
        </div>
            <div class="col-lg-3 col-lg-offset-4" >
                <form class="form-signin" action="<?= base_url('productos_especiales_masivos'); ?>" method="POST" enctype="multipart/form-data">
                    <br>
                    <h4>Nombre</h4>
                      <input type="text" class="form-control" name="name" placeholder="">
                    <br>

                    <h4>Apellido</h4>
                      <input type="text" class="form-control" name="surname" placeholder="">
                    <br>

                    <h4>Email:</h4>
                      <input type="email" class="form-control" name="mail" placeholder="nombre@dominio.com">
                    <br>

                     <h4>Contraseña:</h4>
                        <input type="password" class="form-control " name="password"  placeholder="Contraseña">
                    <br>

                    <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">Subir</button>
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
