
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Titulo-->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
            </button>
                <a class="navbar-brand" href="<?= base_url('home'); ?>">Wikiprecios</a>
        </div>

        <!-- Menu de administrador para carga masiva de datos -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;Comercios<b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?= base_url('comercios/nuevo'); ?>">Nuevo Comercio</a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-usd"></span>&nbsp;Precios<b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?= base_url('precios/cargar'); ?>">Cargar Desde Archivo</a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-barcode"></span>&nbsp;Productos<b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?= base_url('productos/nuevo'); ?>">Nuevo Producto Especial</a></li>
                            <li><a href="<?= base_url('productos/cargar'); ?>">Cargar Desde Archivo</a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-apple"></span>&nbsp;Rubros<b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?= base_url('rubros/nuevo'); ?>">Nuevo Rubro</a></li>
                        </ul>
                    </li>
                </ul>

            <!-- Menu de usuario  -->
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown"><?= $user;?><b class="caret"></b>
                    </a>

                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?= base_url('desactivar_cuenta'); ?>">Desactivar Cuenta</a></li>
                        <li><a href="<?= base_url('cambiar_clave'); ?>">Cambiar Contraseña</a></li>
                        <li><a href="<?= base_url('cerrar_sesion'); ?>">Cerrar Sesion</a></li>
                    </ul>
                </li>
            </ul>

        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>