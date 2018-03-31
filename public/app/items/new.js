(function () {
    'use strict';

    var controllerName = 'newItemCtrl';

    angular.module('app').controller(controllerName, ['$scope', 'toastr', '$location', 'itemSrv', newItemCtrl]);

    function newItemCtrl($scope, logger, $location, itemSrv) {

        $scope.item = { name: '', letter: '', active: 1 };

        $scope.save = function () {

            if ($scope.item.letter.indexOf(' ') >= 0) {
                return logger.error('El codigo no debe contener espacios');
            }

            if ($scope.item.name == '')
                return logger.error('Ingrese un nombre para el rubro');

            $scope.item.letter = $scope.item.letter.toUpperCase();

            itemSrv.save($scope.item).then(function (response) {
                                
                if (response.error)
                    return logger.error(response.error);

                logger.success('El rubro se registro correctamente');
                $location.path('/items');
            });
        };
    }

})();