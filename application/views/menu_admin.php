<head>
    <meta charset="utf-8" />
    <title>Wikiprecios</title>
    <script type = 'text/javascript' src = "<?= base_url('js/jquery.min.js');?>"></script>
    <link rel= "stylesheet" type ="text/css" href="<?= base_url('styles/bootstrap-material.min.css'); ?>">
    <link rel= "stylesheet" type ="text/css" href="<?= base_url('styles/bootstrap-select.min.css'); ?>">
    <link rel= "stylesheet" type ="text/css" href="<?= base_url('styles/animate.css'); ?>">

    <script type = 'text/javascript' src = "<?= base_url('js/bootstrap-select.min.js');?>"></script>
    <script type = 'text/javascript' src = "<?= base_url('js/bootstrap-notify.min.js');?>"></script>
    <script type = 'text/javascript' src = "<?= base_url('js/bootstrap.min.js');?>"></script>
</head>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Titulo-->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
            </button>
                <a class="navbar-brand" href="<?= base_url('menu_administrador'); ?>">Wikiprecios</a>
        </div>

        <!-- Menu de administrador para carga masiva de datos -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown">Comercios<b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?= base_url('menu_nuevo_comercio'); ?>">Nuevo Comercio</a></li>
                            <li><a href="<?= base_url('menu_comercios_masivos'); ?>">Cargar Desde Archivo</a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown">Precios<b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?= base_url('menu_precios_masivos'); ?>">Cargar Desde Archivo</a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown">Productos<b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?= base_url('menu_nuevo_producto_especial'); ?>">Nuevo Producto Especial</a></li>
                            <li><a href="<?= base_url('menu_productos_especiales_masivos'); ?>">Cargar Desde Archivo</a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown">Rubros<b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?= base_url('menu_nuevo_rubro'); ?>">Nuevo Rubro</a></li>
                            <li><a href="<?= base_url('menu_listar_rubros'); ?>">Listar Rubros</a></li>
                        </ul>
                    </li>
                </ul>

            <!-- Menu de usuario  -->
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown"><?= $user;?><b class="caret"></b>
                    </a>

                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?= base_url('menu_desactivar_cuenta'); ?>">Desactivar Cuenta</a></li>
                        <li><a href="<?= base_url('menu_cambiar_clave'); ?>">Cambiar Contraseña</a></li>
                        <li><a href="<?= base_url('cerrar_sesion'); ?>">Cerrar Sesion</a></li>
                    </ul>
                </li>
            </ul>

        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
