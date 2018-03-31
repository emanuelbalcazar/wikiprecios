(function () {
    'use strict';

    var controllerName = 'pricesListCtrl';

    angular.module('app').controller(controllerName, ['$scope', 'toastr', 'paginationSrv', 'dialogs', 'pricesSrv', pricesListCtrl]);

    function pricesListCtrl($scope, logger, paginationSrv, dialogs, service) {

        $scope.sort = { column: 'id', descending: false };
        $scope.toSearch = '';

        // find all prices.
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

                for (var i = 0; i < $scope.records.length; i++)
                    $scope.records[i].id = Number($scope.records[i].id);

                $scope.records = $scope.records.filter(function (elem) {
                    return (elem.product_code.match(new RegExp(toSearch, 'i')) || 
                    elem.commerce_name.match(new RegExp(toSearch, 'i')));
                });
                paginate();
            });
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