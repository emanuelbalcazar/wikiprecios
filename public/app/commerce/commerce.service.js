(function () {
	'use strict';

	var service = 'commerceSrv';

	angular.module('app').factory(service, ['$http', '$httpParamSerializer', commerceSrv]);

	/**
	 * Services associated with the businesses
	 */
	function commerceSrv($http, serializer) {

		var service = {
			findAll: findAll,
			remove: remove
		};

		return service;

		function findAll() {
			return $http({
				url: 'api/comercios',
				method: "GET"
			}).then(
				function success(response) {
					return response.data;
				},
				function error(error) {
					return error.data;
				});
		}

		function remove(id) {
			return $http({
				url: 'api/comercios/' + id,
				method: "DELETE"
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