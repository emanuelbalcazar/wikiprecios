(function () {
    'use strict';

    var controllerName = 'loginCtrl';

    angular.module('app').controller(controllerName, ['$scope', '$rootScope', 'toastr', '$cookieStore', '$location', 'accountSrv', loginCtrl]);

    // login screen controller.
    function loginCtrl($scope, $rootScope, logger, $cookieStore, $location, service) {

        $scope.user = { email: '', password: '' };

        if ($cookieStore.get('user'))
            $location.path('/home');

        // the user's session starts, provided the data is valid.
        $scope.login = function () {
            service.login($scope.user).then(
                function(response) {
                    if (response.error)
                        return logger.error('Usuario o contraseña incorrectos', 'Fallo de autenticacion');

                    $rootScope.$broadcast('loginSuccess', { user: $scope.user });            
                    return $location.path('/home');
                }
            );
        };

        $scope.redirectTo = function (route) {
            $location.path(route);
        };
    }

})();