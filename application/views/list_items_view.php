<html>
    <meta charset="utf-8" />

    <body>

        <div class="col-lg-4 col-lg-offset-4" >
            <form class="form-signin" action="<?= base_url('buscar_rubro'); ?>" method="GET">

                <div class="input-group">
                    <input type="text" class="form-control" name="item" placeholder="buscar rubro">
                    <span class="input-group-btn">
                     <button class="btn btn-default" type="submit">Buscar</button>
                    </span>
                </div><!-- /input-group -->

                <br>

                <table class="table">
                    <thead>
                        <th>Codigo</th>
                       <th>Nombre</th>
                    </thead>

                    <tbody>
                        <?php if (isset($items)) { ?>
                            <?php foreach ($items as  $item) { ?>
                            <tr>
                                <td><?= $item->letter; ?></td>
                                <td><?= $item->name; ?></td>
                            </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>

            </form>
        </div>
    </body>
</html>
