<html ng-app="app">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{title}}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="images/favicon.png" />
    <link href="public/assets/app.min.css" rel="stylesheet">
    <script src="public/assets/app.min.js"></script>
    
</head>

<body>
    <navbar></navbar>
    <div class="container" ng-view=""></div>
</body>

</html>
