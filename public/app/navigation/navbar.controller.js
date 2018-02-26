(function () {
    'use strict';

    var controllerName = 'navbarCtrl';

    angular.module('app').controller(controllerName, ['$scope', '$rootScope', '$location', '$cookieStore', 'accountSrv', navbarCtrl]);

    // controlador de la barra de navegacion.
    function navbarCtrl($scope, $rootScope, $location, $cookieStore, accountSrv) {

        $scope.isAuthenticated = $cookieStore.get('user') || false;

        $rootScope.$on('loginSuccess', function (evt, data) {
            $scope.isAuthenticated = data.user;
            $cookieStore.put('user', data.user);
        });

        $scope.redirectTo = function (route) {
            $location.path(route);
        };

        $scope.logout = function () {
            accountSrv.logout($cookieStore.get('user').email).then(
                function (response) {
                    $cookieStore.remove('user');
                    return window.location.reload(true);
                }
            );
        };
    }

})();
