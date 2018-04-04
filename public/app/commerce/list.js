(function () {
    'use strict';

    var controllerName = 'commerceListCtrl';

    angular.module('app').controller(controllerName, ['$scope', 'toastr', 'paginationSrv', 'dialogs', 'commerceSrv', commerceListCtrl]);

    function commerceListCtrl($scope, logger, paginationSrv, dialogs, service) {

        $scope.sort = { column: 'id', descending: false };
        $scope.toSearch = '';

        // find all commerces.
        function findAll() {
            service.findAll().then(function (response) {
                $scope.records = response;

                for (var i = 0; i < $scope.records.length; i++)
                    $scope.records[i].id = Number($scope.records[i].id);
                    
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
            service.findAll().then(function (response) {
                $scope.records = response;

                $scope.records = $scope.records.filter(function (elem) {
                    return (elem.name.match(new RegExp(toSearch, 'i')) || elem.address.match(new RegExp(toSearch, 'i')));
                });
                paginate();
            });
        };

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