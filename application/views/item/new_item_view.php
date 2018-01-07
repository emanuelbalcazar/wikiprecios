<body>
    <div class="row">
        <div class="row">
            <div class="col-lg-4 col-lg-offset-4" >
            <h3>Nuevo Rubro</h3>
        </div>

        <div class="col-lg-3 col-lg-offset-4" >
            <form class="form-signin" action="<?= site_url('Item_controller/load_item'); ?>" method="POST">

            <h4>Ingrese el nombre:</h4>
            <input type="text" class="form-control" name="name" placeholder="Nombre del rubro">
            <h3></h3>

            <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">Cargar</button>
            </form>
        </div><!-- /.col-lg-4 -->
    </div>
</body>