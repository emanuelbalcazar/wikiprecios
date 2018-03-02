(function () {
    'use strict';

    var controllerName = 'loadPricesCtrl';

    angular.module('app').controller(controllerName, ['$scope', 'toastr', 'FileUploader', '$cookieStore', 'commerceSrv', 'pricesSrv', loadPricesCtrl]);

    function loadPricesCtrl($scope, logger, FileUploader, $cookieStore, commerceSrv, service) {

        commerceSrv.findAll().then(function (response) {
            $scope.commerces = response;
            $scope.commerce = $scope.commerces[0];
        });

        // create a instance from FileUploader
        $scope.uploader = new FileUploader({
            url: 'api/admin/prices/load'
        });

        // add other data before upload item.
        $scope.uploader.onBeforeUploadItem = function (item) {
            item.formData.push({ user: $cookieStore.get('user').email });
            item.formData.push({ commerce: $scope.commerce.id });
            logger.info('Se procedera a cargar los datos, por favor espere');
        };

        // on finish load, show status messages.
        $scope.uploader.onCompleteItem = function (fileItem, response, status, headers) {
            if (response.error)
                return logger.error(response.error, 'Error al cargar');

            logger.success(response.success, 'Carga Exitosa');
        };

    }

})();