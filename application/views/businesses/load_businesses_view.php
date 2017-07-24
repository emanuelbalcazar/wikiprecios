<body>
    <div class="row">
        <div class="row">
            <div class="col-lg-4 col-lg-offset-4" >
            <h3>Cargar Comercios Masivos</h3>
        </div>
        <div class="col-lg-3 col-lg-offset-4" >
            <form class="form-signin" action="<?= site_url('Commerce_controller/load_from_file'); ?>" method="POST" enctype="multipart/form-data">
                <h4>Seleccione el archivo a cargar:</h4>
                    <input class = "fileinput" type="file" class="form-control " name="userfile" accept=".csv">
                <br>
                <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">Subir</button>
                <h3></h3>

            </form>

        </div><!-- /.col-lg-4 -->
    </div>
</body>
