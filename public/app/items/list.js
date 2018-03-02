(function () {
    'use strict';

    var controllerName = 'itemListCtrl';

    angular.module('app').controller(controllerName, ['$scope', 'toastr', 'paginationSrv', 'dialogs', 'itemSrv', itemListCtrl]);

    function itemListCtrl($scope, logger, paginationSrv, dialogs, service) {

        // find all items.
        function findAll() {
            service.findAll().then(function (response) {
                $scope.records = response;
                logger.info('Se obtuvieron ' + $scope.records.length + ' registros');
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

        // delete item from database.
        $scope.remove = function (item) {
            dialogs.confirm('Confirmación', '¿Está seguro que desea eliminar el rubro "' + item.name + '"?', { size: 'md' }).result.then(
                function () {
                    service.remove(item.id).then(function (response) {
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