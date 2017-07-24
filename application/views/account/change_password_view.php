<div class="row">
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4" >
        <h3>Cambiar contraseña</h3>
    </div>
    <div class="col-lg-3 col-lg-offset-4">
        <form class="form-signin" action="<?= site_url('Account_controller/change_password'); ?>" method="POST">

            <h4>Ingrese su contraseña actual:</h4>
                <input type="password" class="form-control " name="old_password"  placeholder="Contraseña actual">
            <h3></h3>
            <h4>Ingrese la nueva contraseña:</h4>
                <input type="password" class="form-control " name="new_password"  placeholder="Contraseña nueva">
            <h3></h3>
            <h4>Confirmar la nueva contraseña:</h4>
                <input type="password" class="form-control " name="confirm_password"  placeholder="Confirmar contraseña nueva">
            <h3></h3>
            <button class="btn btn-lg btn-primary btn-block" name="submit" value="entrar" type="submit">Cambiar</button>
            <h3></h3>
        </form>

    </div><!-- /.col-lg-4 -->
</div>
