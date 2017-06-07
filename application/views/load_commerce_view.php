<!DOCTYPE html>
<html>
    <head>
    <title>Geocoding service</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">

    </head>

    <body>




    <!-- <div id="floating-panel">
      <input id="address" type="textbox" value="Puerto Madryn, Argentina">
      <input id="submit" type="button" value="Geocode">
    </div> -->


    <div id="map" class ="col-xs-6" style="width:600px; height: 500px;"></div>

    <div class ="col-xs-6">
        <input id="address" type="textbox" class="" value="Puerto Madryn, Argentina">
        <input id="submit" type="button" value="Buscar">
    </div>



    <script>
    var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    var labelIndex = 0;
    var map;
    var geocoder;
    var markers = [];

    // Inicia el mapa.
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 14,
        center: {lat: -42.7694476, lng: -65.03171750000001}
        });

        geocoder = new google.maps.Geocoder();

        document.getElementById('submit').addEventListener('click', function() {
          geocodeAddress(geocoder, map);
        });

        // This event listener calls addMarker() when the map is clicked.
        google.maps.event.addListener(map, 'click', function(event) {
            addMarker(event.latLng, map);
            geocodeLatLng(geocoder, map, event.latLng);
            event.preventDefault();
        });

    } // initMap

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

    function clearMarkers() {
        setMapOnAll(null);
    }

    function setOurMarkers() {
        var markerPos =  new google.maps.LatLng(document.getElementById("latitud").value, document.getElementById("longitud").value);
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
            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
        });
    }
    google.maps.event.addDomListener(window, 'load', initMap);

    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAqjgCisnuQgmrYeuU2suTIcXeRAnfh8-k&signed_in=true&callback=initMap">
    </script>
  </body>
</html>
