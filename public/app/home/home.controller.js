(function () {
    'use strict';

    var controllerName = 'homeCtrl';

    angular.module('app').controller(controllerName, ['$scope', 'toastr', homeCtrl]);

    // home screen controller.
    function homeCtrl($scope, logger) {
        
        logger.success('Bienvenido a Wikiprecios');
    }

})();