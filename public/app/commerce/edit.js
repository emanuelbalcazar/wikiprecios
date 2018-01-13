(function () {
    'use strict';

    var controllerName = 'commerceEditCtrl';

    angular.module('app').controller(controllerName, ['$scope', 'toastr', '$routeParams', 'commerceSrv', commerceEditCtrl]);

    function commerceEditCtrl($scope, logger, $routeParams, service) {
        
        $scope.commerce = $routeParams.id;
    }

})();