// Modulo de rutas.
(function () {
	'use strict';

	var app = angular.module('app');

	// get the defined routes
	app.constant('routes', getRoutes());

	// configure the routes and who solves them.
    app.config(['$routeProvider', 'routes', routeConfigurator]);

	// register each route in the provider, with its corresponding configuration.
	function routeConfigurator($routeProvider, routes) {

        routes.forEach(function(r) {
            $routeProvider.when(r.url, r.config);
        });

        $routeProvider.otherwise({ redirectTo: '/login' });
    }

	// the routes are declared here.
	function getRoutes() {
		return [
			{
				url: '/login',
				config: {
					title: 'Inicio de Sesion',
					templateUrl: 'public/app/authentication/login.html',
					controller: 'loginCtrl'
				}
			},
			{
				url: '/home',
				config: {
					title: 'Principal',
					templateUrl: 'public/app/home/home.html',
					controller: 'homeCtrl'
				}
			},
			{
				url: '/password/reset',
				config: {
					title: 'Olvide mi contraseña',
					templateUrl: 'public/app/authentication/forgot.password.html',
					controller: 'forgotPasswordCtrl'
				}
			},
			{
				url: '/password/change',
				config: {
					title: 'Cambiar contraseña',
					templateUrl: 'public/app/account/change.password.html',
					controller: 'changePasswordCtrl'
				}
			},
			{
				url: '/commerce/:id',
				config: {
					title: 'Editar Comercio',
					templateUrl: 'public/app/commerce/edit.html',
					controller: 'commerceEditCtrl'
				}
			},
			{
				url: '/commerces',
				config: {
					title: 'Listar Comercios',
					templateUrl: 'public/app/commerce/list.html',
					controller: 'commerceListCtrl'
				}
			},
			{
				url: '/prices/load',
				config: {
					title: 'Cargar Precios',
					templateUrl: 'public/app/prices/load.html',
					controller: 'loadPricesCtrl'
				}
			},
			{
				url: '/prices',
				config: {
					title: 'Listar Precios',
					templateUrl: 'public/app/prices/list.html',
					controller: 'pricesListCtrl'
				}
			},
			{
				url: '/product/new',
				config: {
					title: 'Nuevo Producto Especial',
					templateUrl: 'public/app/products/new.html',
					controller: 'newProductCtrl'
				}
			},
			{
				url: '/products',
				config: {
					title: 'Productos Especiales',
					templateUrl: 'public/app/products/list.html',
					controller: 'productListCtrl'
				}
			},
			{
				url: '/item/new',
				config: {
					title: 'Nuevo Rubro',
					templateUrl: 'public/app/items/new.html',
					controller: 'newItemCtrl'
				}
			},
			{
				url: '/items',
				config: {
					title: 'Listar Rubros',
					templateUrl: 'public/app/items/list.html',
					controller: 'itemListCtrl'
				}
			}
	  	];
	}

})();
