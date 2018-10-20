<?php
  $fichiers = array_slice(scandir('annonces'), 2);

  $photos = array_map("trie", $fichiers);

  function trie($photo)
  {
    $photo = explode(' ', $photo);
    $lat = $photo[0];
    $lng = $photo[1];
    $ent = explode('.', join(' ', array_slice($photo, 2)))[0];
    return ['lat' => $lat, 'lng' => $lng, 'ent' => $ent];
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

    // This example displays a marker at the center of Australia.
    // When the user clicks the marker, an info window opens.

    function initMap() {
      var uluru = {lat: -25.363, lng: 131.044};
      var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 4,
        center: uluru
      });

      var contentString = '<div id="content">'+
          '<div id="siteNotice">'+
          '</div>'+
          '<h1 id="firstHeading" class="firstHeading">Uluru</h1>'+
          '<div id="bodyContent">'+
          '<p> azeazeazeazeazeazeazeaeazeaeaez </p>'+
          '<p>Attribution: Uluru, <a href="https://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">'+
          'https://en.wikipedia.org/w/index.php?title=Uluru</a> '+
          '(last visited June 22, 2009).</p>'+
          '</div>'+
          '</div>';

      var infowindow = new google.maps.InfoWindow({
        content: contentString
      });

      var marker = new google.maps.Marker({
        position: uluru,
        map: map,
        title: 'Uluru (Ayers Rock)'
      });
      marker.addListener('click', function() {
        infowindow.open(map, marker);
      });
    }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBF87DmvYXqVVDCaNriE2Qfhob3bqDVhtU&callback=initMap"></script>
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBF87DmvYXqVVDCaNriE2Qfhob3bqDVhtU"></script>
    <script src="markers.js" defer></script>
    <script defer>
      function drawpoints()
      {
        <?php foreach($photos as $key => $photo): ?>
          let points<?=$key?> = new points(new google.maps.LatLng(<?=$photo['lat']?>, <?=$photo['lng']?>), map, '<?=$photo['ent']?>')
        <?php endforeach; ?>
      }
    </script> -->
  </head>
  <body>
    <div id="map"></div>
    <a href="add.php">Ajouter une photo</a>
  </body>
</html>