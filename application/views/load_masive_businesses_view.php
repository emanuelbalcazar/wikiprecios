<html>
    <meta charset="utf-8" />

    <body>
        <div class="row">
            <div class="row">
                <div class="col-lg-4 col-lg-offset-4" >
                <h3>Cargar Comercios Masivos</h3>
            </div>
            <div class="col-lg-3 col-lg-offset-4" >
                <form class="form-signin" action="<?= base_url('comercios_masivos'); ?>" method="POST" enctype="multipart/form-data">
                    <h4>Seleccione el archivo a cargar:</h4>
                        <input class = "fileinput" type="file" class="form-control " name="userfile" accept=".csv">
                    <br>
                    <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">Subir</button>
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
