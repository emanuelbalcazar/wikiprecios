(function () {
	'use strict';

	var service = 'productSrv';

	angular.module('app').factory(service, ['$http', '$httpParamSerializer', productSrv]);

	/**
	 * Services associated with products.
	 */
	function productSrv($http, serializer) {

		var service = {
			save: save,
			categories: categories,
			remove: remove
		};

		return service;

		function save(data) {
			return $http({
				url: 'api/categoria/registrar',
				method: "POST",
				data: serializer(data)
			}).then(
				function success(response) {
					return response.data;
				},
				function error(error) {
					return error.data;
				});
		}

		function categories() {
			return $http({
				url: 'api/categorias',
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
				url: 'api/categorias/' + id,
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