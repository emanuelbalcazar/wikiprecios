(function () {
    'use strict';

    var controllerName = 'newItemCtrl';

    angular.module('app').controller(controllerName, ['$scope', 'toastr', '$location', 'itemSrv', newItemCtrl]);

    function newItemCtrl($scope, logger, $location, itemSrv) {

        $scope.item = { name: '' };

        $scope.save = function () {
            itemSrv.save($scope.item).then(function (response) {
                if (response.error)
                    return logger.error(response.error);

                logger.success('El rubro se registro correctamente');
                $location.path('/items');
            });
        };
    }

})();