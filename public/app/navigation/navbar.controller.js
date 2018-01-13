(function () {
    'use strict';

    var controllerName = 'navbarCtrl';

    angular.module('app').controller(controllerName, ['$scope', '$rootScope', '$location', '$cookieStore', navbarCtrl]);

    // controlador de la barra de navegacion.
    function navbarCtrl($scope, $rootScope, $location, $cookieStore) {

        $scope.isAuthenticated = $cookieStore.get('user') || false;

        $rootScope.$on('loginSuccess', function (evt, data) {
            $scope.isAuthenticated = data.user;
            $cookieStore.put('user', data.user);
        });
        
        $scope.redirectTo = function (route) {
            $location.path(route);
        }

        $scope.logout = function () {
            $cookieStore.remove('user');
            return window.location.reload(true);
        };
    }

})();
