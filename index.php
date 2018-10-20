<?php
  $fichiers = array_slice(scandir('annonces'), 2);

  $photos = array_map("trie", $fichiers);

  function trie($photo)
  {
    $img = $photo;
    $photo = explode(' ', $photo);
    $lat = $photo[0];
    $lng = $photo[1];
    $ent = explode('.', join(' ', array_slice($photo, 2)))[0];
    return ['lat' => $lat, 'lng' => $lng, 'ent' => $ent, 'img' => $img];
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Maps</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        width: 900px;
        height: 900px;
        margin: 0 auto;
      }
      .div_custom
      {
          border-style: none;
          border-width: 25px;
          position: absolute;
          background-color: red;
          width: 110px;
          height: 30px;
          font-size: 20px;
          white-space: nowrap;
      }
    </style>
    <script>
      function initMap() 
      {
          var map = new google.maps.Map(document.getElementById('map'),
          {
              zoom: 6.3,
              center: {lat: 46, lng: 2},
              mapTypeId: 'roadmap'
          });

          // geo
          var options = {
              enableHighAccuracy: true,
              timeout: 5000,
              maximumAge: 0
          };
          
          function success(pos) {
              var crd = pos.coords;
              map.setCenter({lat: crd.latitude, lng: crd.longitude})
              map.setZoom(14)
          };
          
          function error(err) {
              console.warn(`ERROR(${err.code}): ${err.message}`);
          };
          
          navigator.geolocation.getCurrentPosition(success, error, options);
          // /geo
          
          var markers = []

          <?php foreach($photos as $key => $photo): ?>

            content = '<h1><?=$photo['ent']?></h1><br><img src="annonces/<?=$photo['img']?>">'

            var infowindow<?=$key?> = new google.maps.InfoWindow({content: content});
            var marker<?=$key?> = new google.maps.Marker({position: {lat: <?=$photo['lat']?>, lng: <?=$photo['lng']?>}, map: map, title: '<?=$photo['ent']?>'});
            marker<?=$key?>.addListener('click', function() { infowindow<?=$key?>.open(map, marker<?=$key?>);});
            markers.push(marker<?=$key?>)
          <?php endforeach; ?>
        
          var markerCluster = new MarkerClusterer(map, markers, {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});

      }
    </script>
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBF87DmvYXqVVDCaNriE2Qfhob3bqDVhtU&callback=initMap"></script>
  </head>
  <body>
    <div id="map"></div>
    <a href="add.php">Ajouter une photo</a>
  </body>
</html>