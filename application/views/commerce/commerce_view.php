<html>
  <head>
    <!-- TODO se debe mover donde corresponda -->
    <link rel="stylesheet" href="https://openlayers.org/en/v3.16.0/css/ol.css" type="text/css">
    <script src="https://openlayers.org/en/v3.16.0/build/ol.js"></script>
  </head>
  <body>
    <div id="map" class="map"></div>


    <script>
      var OSMLayer = new ol.layer.Tile({
        source: new ol.source.OSM()
      });

      var map = new ol.Map({
        layers: [OSMLayer],
        target: 'map',
        view: new ol.View({
          projection: 'EPSG:4326',
          center: ['-65.0339126586914', '-42.77000141404137'],
          zoom: 13
        })
      });

    </script>

  </body>
</html>
