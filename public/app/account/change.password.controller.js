(function () {
    'use strict';

    var controllerName = 'changePasswordCtrl';

    angular.module('app').controller(controllerName, ['$scope', 'toastr', '$cookieStore', '$location', 'accountSrv', changePasswordCtrl]);

    // change password screen controller.
    function changePasswordCtrl($scope, logger, $cookieStore, $location, service) {

        var user = $cookieStore.get('user');
        $scope.data = { email: user.email, password: '', newPassword: '', confirmNewPassword: '' };

        $scope.change = function () {
            if ($scope.data.newPassword != $scope.data.confirmNewPassword)
                return logger.error('La contraseña nueva no coincide con la confirmada');

            service.changePassword($scope.data).then(function (response) {
                    if (response.error)
                        return logger.error(response.error);

                    logger.success(response.success);
                    $location.path('/home');                    
                }
            );
        };
    }

})();