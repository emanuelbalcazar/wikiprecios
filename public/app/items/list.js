(function () {
    'use strict';

    var controllerName = 'itemListCtrl';

    angular.module('app').controller(controllerName, ['$scope', 'toastr', 'paginationSrv', 'dialogs', 'itemSrv', itemListCtrl]);

    function itemListCtrl($scope, logger, paginationSrv, dialogs, service) {

        $scope.sort = { column: 'name', descending: false };

        // find all items.
        function findAll() {
            service.findAll().then(function (response) {
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

        $scope.changeStatus = function (item, status) {
            var text = (status == 1) ? "activar" : "desactivar";

            dialogs.confirm('Confirmación', '¿Está seguro que desea ' + text + ' el rubro "' + item.name + '"?', { size: 'md' }).result.then(
                function () {
                    item.active = Number(status);
                    
                    service.update(item).then(function (response) {
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