// Main Module.
(function () {
    'use strict';

    var app = angular.module('app', [
        'ngAnimate',        // animations
        'ngRoute',          // routes
        'ngSanitize',
        'dialogs.main',
        'ui.bootstrap',      // ui-bootstrap (ex: carousel, pagination, dialog)
        'toastr',
        'ngCookies',
        'navbar',
        'nya.bootstrap.select',
        'angularFileUpload',
        'openlayers-directive',
        'pascalprecht.translate'
    ]);

    app.run(['$rootScope', '$route', '$http', '$cookieStore', '$location', function ($rootScope, $route, $http, $cookieStore, $location) {
        $rootScope.title = "Wikiprecios";
        $http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";

        // prevents an unauthenticated user from accessing the screens.
        $rootScope.$on("$locationChangeStart", function (event, next, current) {

            if (next.originalPath == '#/password/reset')    
                window.location.href = '#/password/reset';

            if (next.originalPath !== '#/login' && !$cookieStore.get('user'))
                window.location.href = '#/login';
        });
    }]);

    app.config(['$locationProvider', function ($locationProvider) {
        $locationProvider.hashPrefix('');
    }]);

    // configure toastr
    app.config(function (toastrConfig) {
        angular.extend(toastrConfig, {
            autoDismiss: false,
            containerId: 'toast-container',
            maxOpened: 0,
            newestOnTop: true,
            positionClass: 'toast-bottom-right',
            preventDuplicates: false,
            preventOpenDuplicates: false,
            target: 'body'
        });
    });

    // configure angular dialogs service
    app.config(['dialogsProvider','$translateProvider',function(dialogsProvider,$translateProvider){

        dialogsProvider.setSize('sm');
        
		$translateProvider.translations('es',{
			DIALOGS_ERROR: "Error",
			DIALOGS_ERROR_MSG: "Se ha producido un error desconocido.",
			DIALOGS_CLOSE: "Cerca",
			DIALOGS_PLEASE_WAIT: "Espere por favor",
			DIALOGS_PLEASE_WAIT_ELIPS: "Espere por favor...",
			DIALOGS_PLEASE_WAIT_MSG: "Esperando en la operacion para completar.",
			DIALOGS_PERCENT_COMPLETE: "% Completado",
			DIALOGS_NOTIFICATION: "Notificacion",
			DIALOGS_NOTIFICATION_MSG: "Notificacion de aplicacion Desconocido.",
			DIALOGS_CONFIRMATION: "Confirmacion",
			DIALOGS_CONFIRMATION_MSG: "Se requiere confirmacion.",
			DIALOGS_OK: "Bueno",
			DIALOGS_YES: "Si",
			DIALOGS_NO: "No"
        });
        
        $translateProvider.preferredLanguage('es');
	}]);

})();
