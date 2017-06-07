<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

  <title>WikiPrecios</title>
  <title>WikiPrecios</title>
  <link rel= "stylesheet" type ="text/css" href="<?= base_url('styles/bootstrap.min.css'); ?>" id="1">
  <link rel= "stylesheet" type ="text/css" href="<?= base_url('styles/main.css'); ?>">
  <script type="text/javascript" src="<?= base_url('js/jquery-2.0.3.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= base_url('js/bootstrap.min.js'); ?>"></script>
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
  <meta charset="utf-8">

  <style>
    html, body {
      height: 100%;
      margin: 0;
      padding: 0;

    }
    #map {
      height: 100%;
    }
  </style>
  <header>
    <nav>
      <ul class="nav nav-pills" id="menu">
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Acciones <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?= base_url('productosEspeciales/nuevo/'); ?>" class="testClick">Ingresar Producto especial</a></li>

            <li><a href="<?= base_url('ImportarCsv'); ?>" class="testClick">Carga masiva</a></li>
            <li><a href="<?= base_url('AgregarRubro'); ?>" class="testClick">Agregar Rubro</a></li>


          </ul>
        </li>



        <li><a href="<?= base_url('logout/'); ?>" class="testClick">Cerrar</a></li>
      </ul>
    </nav>
    <img src="<?= base_url("/images/logo-small.png"); ?>" />
    <label>Wikiprecios</label>
    <?php if(isset($alert)){ ?>
      <script>
        <div class="alert alert-info"> alert("<?= $alert; ?>");</div>
      </script>
    <?php } ?>


  </header>
  <title>wikiPrecios</title>
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
  <meta charset="utf-8">
  <style>
    html, body {
      height: 100%;
      margin: 0;
      padding: 0;
    }

    #floating-panel {
      position: absolute;
      top: 10px;
      left: 25%;
      z-index: 5;
      background-color: #fff;
      padding: 5px;
      border: 1px solid #999;
      text-align: center;
      font-family: 'Roboto','sans-serif';
      line-height: 30px;
      padding-left: 10px;
    }

  </style>
</head>
<body>
<div >
  <form  action="<?= base_url('registrarComercio'); ?>" method="get">


    <span>Nombre de comercio:</span>
    <input type="text" class="form-control" style="width:30%; border: 1px solid #357ebd;"  value= "" name="nombre"  					id="nombre" size="50" placeholder="Nombre" />

    <span>Latitud:</span>
    <input type="number" step="any" onchange="setOurMarkers();" class="form-control" style="width:30%; border: 1px solid 					#357ebd;"  name="latitud"  id="latitud" size="50" placeholder="Latitud" />
    <span>Longitud:</span>
    <input type="number" step="any" onchange="setOurMarkers();" class="form-control" style="width:30%; border: 1px solid 					#357ebd;"  name="longitud"  id="longitud" size="50" placeholder="Longitud" />
    <br/>
    <span>Direccion:</span>
    <input id="address" type="textbox" value="Puerto Madryn, Argentina" size="50">
    <input id="domicilio" type="button" value="Buscar">
    <div id="map" style="width:400px; height: 300px;;"></div>

    <button type="submit" class="btn-lg btn-default btn-primary" value="Guardar"><span class="glyphicon glyphicon-plus"> 					Guardar</button>
  </form>



</div>

<script>
  var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  var labelIndex = 0;
  var map;
  var geocoder;
  var markers = [];
  function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 8,
      center: {lat: -42.7694476, lng: -65.03171750000001}
    });
    geocoder = new google.maps.Geocoder();

    document.getElementById('domicilio').addEventListener('click', function() {
      geocodeAddress(geocoder, map);
    });
    // This event listener calls addMarker() when the map is clicked.
    google.maps.event.addListener(map, 'click', function(event) {
      addMarker(event.latLng, map);
      geocodeLatLng(geocoder, map, event.latLng);
      event.preventDefault();
    });

    // Add a marker at the center of the map.
    //addMarker(bangalore, map);
  }


  function clearMarkers() {
    setMapOnAll(null);
  }
  function setOurMarkers() {

    var markerPos =  new google.maps.LatLng(document.getElementById("latitud").value, document.getElementById("longitud").value);
//var marker = new GMarker(markerPos);
//var markerPos = new google.maps.LatLng(12.60,77.50);
    addMarker(markerPos,map);


  }

  // Sets the map on all markers in the array.
  function setMapOnAll(map) {
    for (var i = 0; i < markers.length; i++) {
      markers[i].setMap(map);
    }
  }


  // Deletes all markers in the array by removing references to them.
  function deleteMarkers() {
    clearMarkers();
    markers = [];
  }

  // Adds a marker to the map.
  function addMarker(location, map) {
    // Add the marker at the clicked location, and add the next-available label
    // from the array of alphabetical characters.
    deleteMarkers();
    var marker = new google.maps.Marker({
      position: location,
      title:"Aqui esta el comercio!",
      label: labels[labelIndex++ % labels.length],
      map: map
    });

    var latLng = marker.getPosition(); // returns LatLng object
    map.setCenter(latLng);

    markers.push(marker);
    var lat = document.getElementById("latitud");
    lat.value=marker.getPosition().lat();
    var long = document.getElementById("longitud");
    long.value=marker.getPosition().lng();
  }


  function geocodeLatLng(geocoder, map,location) {
    var address = document.getElementById('address').value;
    var latlng = {lat: location.lat(), lng: location.lng()};
    geocoder.geocode({'location': latlng}, function(results, status) {
      if (status === google.maps.GeocoderStatus.OK) {
        if (results[1]) {
          //map.setZoom(11);
          document.getElementById('address').value = results[0].formatted_address;
          console.log(results[1])
          console.log(results)

        } else {
          window.alert('No results found');
        }
      } else {
        window.alert('Geocoder failed due to: ' + status);
      }
    });
  }

  function geocodeAddress(geocoder, resultsMap) {
    var address = document.getElementById('address').value;
    geocoder.geocode({'address': address}, function(results, status) {
      if (status === google.maps.GeocoderStatus.OK) {
        resultsMap.setCenter(results[0].geometry.location);
        addMarker(results[0].geometry.location,resultsMap);
        //var marker = new google.maps.Marker({
         // map: resultsMap,
         // position: results[0].geometry.location
        //});
      } else {
        alert('Geocode was not successful for the following reason: ' + status);
      }
    });
  }
  google.maps.event.addDomListener(window, 'load', initMap);

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBN08ZfJ-qHARJN98winFknLnavWVFpHKY&signed_in=true&callback=initMap"
        async defer></script>
</body>
</html>