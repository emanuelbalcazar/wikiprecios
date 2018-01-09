// Modulo principal de Angular
(function () {
    'use strict';

    var app = angular.module('app', [
        'ngAnimate',        // animaciones
        'ngRoute',          // ruteo
        'dialogs.main',
        'ui.bootstrap',      // ui-bootstrap (ex: carousel, pagination, dialog)
        'toastr',
        'ngCookies'
    ]);

    app.run(['$rootScope', '$route', function ($rootScope, $route) {
        $rootScope.title = "Wikiprecios";
    }]);

    // configuracion del locationProvider
    app.config(['$locationProvider', function ($locationProvider) {
        $locationProvider.hashPrefix('');
    }]);

    // configuracion del toastr
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
