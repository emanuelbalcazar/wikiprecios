(function () {
	'use strict';

	var service = 'accountSrv';

	angular.module('app').factory(service, ['$http', '$httpParamSerializer', accountSrv]);

	/**
	 * Services associated with the accounts
	 */
	function accountSrv($http, serializer) {

		var service = {
			login: login,
			forgotPassword: forgotPassword,
			changePassword: changePassword
		}

		return service;


		function login(credentials, route) {
			return $http({
				url: 'api/admin/login',
				method: "POST",
				data: serializer(credentials)
			}).then(
				function success(response) {
					return response.data;
				},
				function error(error) {
					return error.data;
				});
		}

		function forgotPassword(email) {
			return $http({
				url: 'api/admin/password/reset',
				method: "POST",
				data: serializer({email: email})
			}).then(
				function success(response) {
					return response.data;
				},
				function error(error) {
					return error.data;
				});
		}

		function changePassword(data) {
			return $http({
				url: 'api/admin/password/change',
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

	} // end service
})();