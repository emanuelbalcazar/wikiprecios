(function () {
    'use strict';

    var controllerName = 'productListCtrl';

    angular.module('app').controller(controllerName, ['$scope', 'toastr', 'paginationSrv', 'dialogs', 'productSrv', productListCtrl]);

    function productListCtrl($scope, logger, paginationSrv, dialogs, productSrv) {

        $scope.sort = { column: 'id', descending: false };

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

        $scope.search = function (toSearch) {
            productSrv.categories().then(function (response) {
                $scope.records = response;

                $scope.records = $scope.records.filter(function (elem) {
                    return (elem.category.match(new RegExp(toSearch, 'i')));
                });
                
                paginate();
            });
        };

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

        $scope.changeSorting = function (column) {
            var sort = $scope.sort;
            if (sort.column == column) {
                sort.descending = !sort.descending;
            } else {
                sort.column = column;
                sort.descending = false;
            }
        };
    }

})();