<html ng-app="app">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{title}}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="images/favicon.png" />

    <!-- Styles -->
    <link href="public/assets/app.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://openlayers.org/en/v3.16.0/css/ol.css" type="text/css">

    <!-- Scripts -->
    <script src="https://openlayers.org/en/v3.16.0/build/ol.js"></script>
    <script src="public/assets/app.min.js"></script>
    
</head>

<body>
    <navbar></navbar>
    <div class="container" ng-view=""></div>
</body>

</html>
