(function () {
    'use strict';

    var controllerName = 'commerceEditCtrl';

    angular.module('app').controller(controllerName, ['$scope', 'toastr', '$routeParams', 'dialogs', 'commerceSrv', commerceEditCtrl]);

    function commerceEditCtrl($scope, logger, $routeParams, dialogs, service) {

        // Marcadores del mapa.
        $scope.markers = [];

        // Comercio
        $scope.commerce = { name: '', address: '', latitude: '', longitude: '', city: 'PUERTO MADRYN', country: 'CHUBUT' };

        $scope.information = '';

        // Posicion por defecto en donde se enfocara la vista del mapa.
        $scope.defaultPosition = { latitude: -42.7865037, longitude: -65.039605 };

        // Modifica la configuracion del visualizador de mapa.
        angular.extend($scope, {
            // centra el mapa en una determinada posicion.
            current: {
                lat: $scope.defaultPosition.latitude,
                lon: $scope.defaultPosition.longitude,
                zoom: 14
            },
            // opciones por defecto en el mapa.
            defaults: {
                // permite hacer zoom con el mouse.
                interactions: {
                    mouseWheelZoom: true
                },
                // controles visibles en el canvas del mapa.
                controls: {
                    zoom: true,
                    attribution: true
                },
                events: {
                    map: ['singleclick']
                }
            }
        });

        /**
         * Obtiene la geolocalizacion actual.
         */
        function getGeolocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    $scope.current.lat = position.coords.latitude;
                    $scope.current.lon = position.coords.longitude;
                    $scope.current.zoom = 13;

                    $scope.$apply(function () {
                        logger.info('Geolocalizacion Activada');
                    });
                });
            } else {
                logger.info('Geolocalizacion no soportada por su navegador');
            }
        }

        getGeolocation();

        $scope.new = function () {
            $scope.createMarker = true;
            logger.info('Seleccione un punto en el mapa');
        };

        /**
         * Evento capturado al realizar click en el mapa.
         * Crea un nuevo marcador en la posicion seleccionada.
         */
        $scope.$on('openlayers.map.singleclick', function (evt, data) {

            if ($scope.createMarker) {
                $scope.$apply(function () {
                    // Convierto las coordenadas del click en coordenadas de geolocalizacion.
                    var lonlat = ol.proj.transform(data.coord, 'EPSG:3857', 'EPSG:4326');
                    addMarker($scope.commerce.name, lonlat[1], lonlat[0]);

                    service.getAddress(lonlat[1], lonlat[0]).then(function (result) {
                        if (!result && result.address)
                            return logger.info('La dirección no pudo obtenerse a partir de la posición');

                        var address = result.address.road;
                        var number = (result.address.house_number) || "";

                        $scope.commerce.address = (address + " " + number).trim();
                        $scope.commerce.city = result.address.city.toUpperCase();
                        $scope.commerce.province = result.address.state.toUpperCase();
                        $scope.commerce.country = result.address.country.toUpperCase();

                        $scope.information = result.display_name || '';
                    });

                    $scope.createMarker = false;
                    logger.success('Marcador agregado');
                });
            }
        });

        $scope.geocode = function () {
            service.geocode($scope.commerce.address, $scope.commerce.city).then(function (result) {
                if (result.length == 0)
                    return logger.error('No se pudo encontrar la dirección especificada');

                $scope.current.lat = Number(result[0].lat);
                $scope.current.lon = Number(result[0].lon);
                $scope.current.zoom = 17;
                addMarker($scope.commerce.name, result[0].lat, result[0].lon);
            });
        };

        /**
       * Agrega un nuevo marcador en el Mapa.
       * Las coordenadas deben estar en formato EPSG:4326.
       * @param {String} label etiqueta del marcador
       * @param {Number} latitude
       * @param {Number} longitude
       */
        function addMarker(label, latitude, longitude, id = null) {
            $scope.markers = [];
            $scope.commerce.latitude = latitude;
            $scope.commerce.longitude = longitude;

            $scope.markers.push({
                lat: Number(latitude),
                lon: Number(longitude),
                label: {
                    show: (label) ? true : false,
                    message: (label) ? label : ""
                },
                id: id
            });
        }

        $scope.save = function () {
            dialogs.confirm('Confirmación', '¿Está seguro que desea guardar el comercio "' + $scope.commerce.name + '"?', { size: 'md' }).result.then(
                function () {
                    service.save($scope.commerce).then(function (result) {
                        if (result.registered)
                            logger.success(result.message);
                        else
                            logger.error(result.message);
                    });
                }, function () {
                    // nothing to do.
                }
            );
        };
    }

})();