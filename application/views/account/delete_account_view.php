<body>
    <div class="row">
        <div class="col-lg-3 col-lg-offset-4">
            <form class="form-signin" action="<?= site_url('Account_controller/delete_account'); ?> "method="POST">
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
        </div> <!-- /.col-lg-4 -->
    </div>
</body>
