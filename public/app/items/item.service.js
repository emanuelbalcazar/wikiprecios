(function () {
	'use strict';

	var service = 'itemSrv';

	angular.module('app').factory(service, ['$http', '$httpParamSerializer', itemSrv]);

	/**
	 * Services associated with items.
	 */
	function itemSrv($http, serializer) {

		var service = {
			findAll: findAll,
			save: save,
			remove: remove
		}

		return service;

		function findAll() {
			return $http({
				url: 'api/rubros',
				method: "GET"
			}).then(
				function success(response) {
					return response.data;
				},
				function error(error) {
					return error.data;
				});
		}

		function save(item) {
			return $http({
				url: 'api/rubro/' + id,
				method: "DELETE"
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
				url: 'api/rubro/' + id,
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