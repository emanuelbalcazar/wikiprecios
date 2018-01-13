(function () {
    'use strict';

    var controllerName = 'forgotPasswordCtrl';

    angular.module('app').controller(controllerName, ['$scope', 'toastr', '$location', 'accountSrv', forgotPasswordCtrl]);

    // forgot password screen controller.
    function forgotPasswordCtrl($scope, logger, $location, service) {

        $scope.email = '';

        // send to reset password.
        $scope.reset = function () {
            service.forgotPassword($scope.email).then(
                function (response) {
                    if (response.error)
                        return logger.error(response.error);

                    return logger.success(response.success);
                }
            );
        };

        $scope.redirectTo = function (route) {
            $location.path(route);
        }
    }

})();