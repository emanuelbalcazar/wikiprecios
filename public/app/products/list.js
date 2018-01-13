(function () {
    'use strict';

    var controllerName = 'productListCtrl';

    angular.module('app').controller(controllerName, ['$scope', 'toastr', 'paginationSrv', 'dialogs', 'productSrv', productListCtrl]);

    function productListCtrl($scope, logger, paginationSrv, dialogs, productSrv) {

        // find all prices.
        function findAll() {
            productSrv.categories().then(function (response) {
                $scope.records = response;
                paginate();
            });
        }

        findAll();

        // paginate function.
        function paginate() {
            $scope.pagination = { currentPage: 1 };
            $scope.$watch("pagination.currentPage", function () {
                $scope.pagination = paginationSrv.paginate($scope.records, $scope.pagination.currentPage, 10);
            });
        }

         // delete product from database.
         $scope.remove = function (product) {
            dialogs.confirm('Confirmación', '¿Está seguro que desea eliminar el producto especial "' + product.category + '"?', { size: 'md' }).result.then(
                function () {
                    productSrv.remove(product.id).then(function (response) {
                        if (response.error)
                        return logger.error(response.error);

                    logger.success(response.success);
                    findAll();
                    });

                }, function () {
                    // nothing to do.
                }
            );
        };
    }

})();