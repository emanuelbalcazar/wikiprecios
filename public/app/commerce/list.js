(function () {
    'use strict';

    var controllerName = 'commerceListCtrl';

    angular.module('app').controller(controllerName, ['$scope', 'toastr', 'paginationSrv', 'dialogs', 'commerceSrv', commerceListCtrl]);

    function commerceListCtrl($scope, logger, paginationSrv, dialogs, service) {

        // find all commerces.
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

        // delete commerce from database.
        $scope.remove = function (commerce) {
            dialogs.confirm('Confirmación', '¿Está seguro que desea eliminar el comercio "' + commerce.name + '"?', { size: 'md' }).result.then(
                function () {
                    service.remove(commerce.id).then(function (response) {
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