<html>

    <body>
        <div id="container">

            <div class="col-lg-3 col-lg-offset-4">

            <br></br>
            <div style="text-align: center;"><img src="<?= base_url("/images/logo-medium.png"); ?>"/></div>

                <form class="form-signin" action="<?= site_url('Login_controller/login');?>" method="POST">

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
                        <a href="<?= base_url('recuperar_clave'); ?>">¿Olvidó su contraseña?</a>
                    <p></p>

                </form>
            </div>
        </div>
    </body>
</html>
