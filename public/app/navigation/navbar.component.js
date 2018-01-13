(function () {
	'use strict';
	angular.module('navbar', [])
		// Se define el componente de la barra de navegacion.
		.component('navbar', {
            templateUrl: 'public/app/navigation/navbar.view.html',
            controller: 'navbarCtrl'
		})
})();
