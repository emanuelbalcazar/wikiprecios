<html ng-app="app">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{title}}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="images/favicon.png" />

    <!-- Styles -->
    <link rel="stylesheet" href="bower_components/angular-dialog-service/dist/dialogs.min.css">
    <link rel="stylesheet" href="bower_components/angular-bootstrap/ui-bootstrap-csp.css">
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="bower_components/angular-toastr/dist/angular-toastr.min.css">
    <link rel="stylesheet" href="bower_components/nya-bootstrap-select/dist/css/nya-bs-select.min.css">

    <link rel="stylesheet" href="bower_components/angular-openlayers-directive/css/markers.css">
    <link rel="stylesheet" href="bower_components/angular-openlayers-directive/css/openlayers.css">
    <link rel="stylesheet" href="bower_components/angular-openlayers-directive/dist/angular-openlayers-directive.css">
    
    <!-- MAPA - NO PUDE ENCONTRAR UNA LIBRERIA NATIVA >:v -->
    <link rel="stylesheet" href="https://openlayers.org/en/v3.16.0/css/ol.css" type="text/css">
    <script src="https://openlayers.org/en/v3.16.0/build/ol.js"></script>

    
    <!-- Scripts -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/angular/angular.min.js"></script>
    <script src="bower_components/angular-dialog-service/dist/dialogs.min.js"></script>
    <script src="bower_components/angular-route/angular-route.min.js"></script>
    <script src="bower_components/angular-sanitize/angular-sanitize.min.js"></script>
    <script src="bower_components/angular-animate/angular-animate.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="bower_components/angular-bootstrap/ui-bootstrap.min.js"></script>
    <script src="bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js"></script>
    <script src="bower_components/angular-toastr/dist/angular-toastr.min.js"></script>
    <script src="bower_components/angular-toastr/dist/angular-toastr.tpls.min.js"></script>
    <script src="bower_components/angular-cookies/angular-cookies.min.js"></script>
    <script src="bower_components/nya-bootstrap-select/dist/js/nya-bs-select.min.js"></script>
    <script src="bower_components/angular-file-upload/dist/angular-file-upload.min.js"></script>
    <script src="bower_components/angular-openlayers-directive/dist/angular-openlayers-directive.min.js"></script>
    <script src="bower_components/openlayers/ol.js"></script>


    <!-- App configuration -->
    <script src="public/app/app.js"></script>
    <script src="public/app/config/routes.js"></script>

    <!-- App directives -->
    <script src="public/app/directives/directives.js"></script>

    <!-- Pagination -->
    <script src="public/app/pagination/pagination.service.js"></script>

    <!-- App components -->
    <script src="public/app/navigation/navbar.component.js"></script>
    <script src="public/app/navigation/navbar.controller.js"></script>

    <!-- Home -->
    <script src="public/app/home/home.controller.js"></script>

    <!-- Authentication -->
    <script src="public/app/authentication/login.controller.js"></script>
    <script src="public/app/authentication/forgot.password.controller.js"></script>

    <!-- Accounts -->
    <script src="public/app/account/change.password.controller.js"></script>
    <script src="public/app/account/account.service.js"></script>

    <!-- Commerce -->
    <script src="public/app/commerce/edit.js"></script>
    <script src="public/app/commerce/list.js"></script>
    <script src="public/app/commerce/commerce.service.js"></script>

    <!-- Prices -->
    <script src="public/app/prices/load.js"></script>
    <script src="public/app/prices/list.js"></script>
    <script src="public/app/prices/prices.service.js"></script>

    <!-- Products -->
    <script src="public/app/products/new.js"></script>
    <script src="public/app/products/list.js"></script>
    <script src="public/app/products/product.service.js"></script>

    <!-- Items -->
    <script src="public/app/items/item.service.js"></script>
    <script src="public/app/items/new.js"></script>
    <script src="public/app/items/list.js"></script>

</head>

<body>
    <navbar></navbar>
    <div class="container" ng-view=""></div>
</body>

</html>
