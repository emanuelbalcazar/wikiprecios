(function () {
	'use strict';

	var service = 'pricesSrv';

	angular.module('app').factory(service, ['$http', '$httpParamSerializer', pricesSrv]);

	/**
	 * Services associated with prices.
	 */
	function pricesSrv($http, serializer) {

		var service = {
			findAll: findAll
		};

		return service;

		function findAll() {
			return $http({
				url: 'api/precios/calculados',
				method: "GET"
			}).then(
				function success(response) {
					return response.data;
				},
				function error(error) {
					return error.data;
				});
		}

	} // end service
})();