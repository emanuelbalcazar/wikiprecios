(function () {
    'use strict';

    var controllerName = 'pricesListCtrl';

    angular.module('app').controller(controllerName, ['$scope', 'toastr', 'paginationSrv', 'dialogs', 'pricesSrv', pricesListCtrl]);

    function pricesListCtrl($scope, logger, paginationSrv, dialogs, service) {

        // find all prices.
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
    }

})();