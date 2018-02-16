(function () {
    'use strict';

    var controllerName = 'commerceEditCtrl';

    angular.module('app').controller(controllerName, ['$scope', 'toastr', '$routeParams', 'commerceSrv', commerceEditCtrl]);

    function commerceEditCtrl($scope, logger, $routeParams, service) {

        // Marcadores del mapa.
        $scope.markers = [];

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
                logger.info('geolocalizacion no soportada por su navegador');
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
                    addMarker($scope.label, lonlat[1], lonlat[0]);
                    $scope.createMarker = false;
                    logger.success('Marcador agregado');
                });
            }
        });

        /**
       * Agrega un nuevo marcador en el Mapa.
       * Las coordenadas deben estar en formato EPSG:4326.
       * @param {String} label etiqueta del marcador
       * @param {Number} latitude
       * @param {Number} longitude
       */
        function addMarker(label, latitude, longitude, id = null) {
            $scope.markers = [];

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
    }

})();