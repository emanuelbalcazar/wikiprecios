<body>
        <div class="row">
            <div class="row">
                <div class="col-lg-4 col-lg-offset-4" >
                <h3>Cargar Precios Masivos</h3>
            </div>

            <div class="col-lg-3 col-lg-offset-4" >
                <form class="form-signin" action="<?= site_url('Price_controller/load_from_file'); ?>" method="POST" enctype="multipart/form-data">

                    <h4>Seleccione el comercio</h4>
                    <select class="selectpicker" data-width="100%" name="commerce" id="commerce" data-live-search="true">
                        <?php foreach ($businesses as  $commerce) { ?>
                            <option data-subtext = " - <?=$commerce->address;?> - <?=$commerce->city;?>" value = <?=$commerce->id;?> title = "<?=$commerce->name;?>"><?=$commerce->name;?></option>
                        <?php } ?>
                    </select>
                    <h3></h3>

                    <h4>Seleccione el archivo a cargar:</h4>
                        <input class = "fileinput" type="file" class="form-control " name="userfile" accept=".csv">
                    <br>
                    <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">Subir</button>
                    <h3></h3>
                </form>

            </div><!-- /.col-lg-4 -->
        </div>
    </body>
