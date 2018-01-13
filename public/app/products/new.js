(function () {
    'use strict';

    var controllerName = 'newProductCtrl';

    angular.module('app').controller(controllerName, ['$scope', 'toastr', 'productSrv', 'itemSrv', newProductCtrl]);

    function newProductCtrl($scope, logger, productSrv, itemSrv) {

        $scope.units = ["KG", "LITRO", "DOCENA"];
        $scope.itemSelected = {};

        itemSrv.findAll().then(function (response) {
            $scope.items = response;
            $scope.itemSelected = response[0];
            $scope.product = { name: '', item: $scope.itemSelected, unit: $scope.units[0] };            
        });

        $scope.save = function () {
            $scope.product.item = $scope.itemSelected.id;
        
            productSrv.save($scope.product).then(function (response) {
                if (!response.registered)
                    return logger.error(response.message);

                logger.success(response.message);
            });
        };
    }

})();