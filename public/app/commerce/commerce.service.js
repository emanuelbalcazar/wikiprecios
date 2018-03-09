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
			remove: remove,
			getAddress: getAddress,
			geocode: geocode,
			save: save
		};

		return service;

		// busca todos los comercios.
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

		// elimina un comercio por ID.
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

		// obtiene la direccion a partir de la posicion geografica.
		function getAddress(latitude, longitude) {
			return $http({
				url: 'https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=' + latitude + '&lon=' + longitude,
				method: "GET"
			}).then(
				function success(response) {
					return response.data;
				},
				function error(error) {
					return error.data;
				});
		}

		function geocode(address, city) {
			return $http({
				url: 'https://nominatim.openstreetmap.org/search?format=jsonv2&street=' + address + '&city=' + city,
				method: "GET"
			}).then(
				function success(response) {
					return response.data;
				},
				function error(error) {
					return error.data;
				});
		}

		// guarda un nuevo comercio.
		function save(commerce) {
			return $http({
				url: 'api/comercio/registrar',
				method: "POST",
				data: serializer(commerce)
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