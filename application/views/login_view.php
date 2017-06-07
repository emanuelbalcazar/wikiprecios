  <html>
    <head>
        <meta charset="utf-8" />
        <title>Wikiprecios</title>
         <script type = 'text/javascript' src = "<?= base_url('js/jquery.min.js');?>"></script>
         <link rel= "stylesheet" type ="text/css" href="<?= base_url('styles/bootstrap-material.min.css'); ?>">
         <link rel= "stylesheet" type ="text/css" href="<?= base_url('styles/animate.css'); ?>">
         <link rel= "stylesheet" type ="text/css" href="<?= base_url('styles/signin.css'); ?>">
         <script type = 'text/javascript' src = "<?= base_url('js/bootstrap-notify.min.js');?>"></script>
         <script type = 'text/javascript' src = "<?= base_url('js/bootstrap.min.js');?>"></script>
    </head>

    <body>
        <div id="container">
            <div style="text-align: center;"><img src="<?= base_url("/images/logo-medium.png"); ?>"/></div>

            <form class="form-signin" action="<?= base_url('login_administrador'); ?> "method="POST">

                <h3 class="form-signin-heading">Inicie Sesión</h3>
                <h3></h3>

                <label for="email_id" class="control-label">Email</label>
		              <input type="email" class="form-control" name="mail" placeholder="nombre@dominio.com">

                <p></p>
                <label>Contraseña</label>
                    <input type="password" class="form-control" name="password"  placeholder="Contraseña">
                <h3></h3>

                <button class="btn btn-lg btn-primary btn-block" name="submit" value="entrar" type="submit">Entrar</button>
                <p></p>
                    <a href="<?= base_url('menu_recuperar_clave'); ?>">¿Olvidó su contraseña?</a>
                <p></p>

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
            </form>

        </div>
    </body>
</html>
