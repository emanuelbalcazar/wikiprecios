// Main Module.
(function () {
    'use strict';

    var app = angular.module('app', [
        'ngAnimate',        // animations
        'ngRoute',          // routes
        'ngSanitize',
        'dialogs.main',
        'ui.bootstrap',      // ui-bootstrap (ex: carousel, pagination, dialog)
        'toastr',
        'ngCookies',
        'navbar',
        'nya.bootstrap.select',
        'angularFileUpload',
        'openlayers-directive'
    ]);

    app.run(['$rootScope', '$route', '$http', '$cookieStore', '$location', function ($rootScope, $route, $http, $cookieStore, $location) {
        $rootScope.title = "Wikiprecios";
        $http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";

        // prevents an unauthenticated user from accessing the screens.
        $rootScope.$on("$locationChangeStart", function (event, next, current) {

            if (next.originalPath == '#/password/reset')    
                window.location.href = '#/password/reset';

            if (next.originalPath !== '#/login' && !$cookieStore.get('user'))
                window.location.href = '#/login';
        });
    }]);

    app.config(['$locationProvider', function ($locationProvider) {
        $locationProvider.hashPrefix('');
    }]);

    // configure toastr
    app.config(function (toastrConfig) {
        angular.extend(toastrConfig, {
            autoDismiss: false,
            containerId: 'toast-container',
            maxOpened: 0,
            newestOnTop: true,
            positionClass: 'toast-bottom-right',
            preventDuplicates: false,
            preventOpenDuplicates: false,
            target: 'body'
        });
    });

})();
