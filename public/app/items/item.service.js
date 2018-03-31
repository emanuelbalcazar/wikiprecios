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
			remove: remove,
			update: update
		};

		return service;

		function findAll() {
			return $http({
				url: 'api/admin/items',
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
				url: 'api/rubro/registrar',
				method: "POST",
				data: serializer(item)
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

		function update(item) {
			return $http({
				url: 'api/rubro/' + item.id,
				method: "POST",
				data: serializer(item)
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