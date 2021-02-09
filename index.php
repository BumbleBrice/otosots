<?php
  if(!file_exists('annonces'))
  {
    mkdir('annonces', 0777, true);
  }

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
      #map {
        width: 900px;
        height: 900px;
        margin: 0 auto;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <a href="add.php">Ajouter une photo</a>

	<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBF87DmvYXqVVDCaNriE2Qfhob3bqDVhtU"></script>
    <script>
		let map = new google.maps.Map(document.getElementById('map'),
		{
			zoom: 6.3,
			center: {lat: 46, lng: 2},
			mapTypeId: 'satellite'
		});

		// geo		
		navigator.geolocation.getCurrentPosition(
		pos => 
		{
			let crd = pos.coords;
			map.setCenter({lat: crd.latitude, lng: crd.longitude})
			map.setZoom(14)
		},
		error => console.warn(`ERROR(${error.code}): ${error.message}`), 
		{
			enableHighAccuracy: true,
			timeout: 5000,
			maximumAge: 0
		});
		// /geo

		let info_markers = 
		[
			<?php foreach($photos as $key => $photo): ?>
			{lat: <?=$photo['lat']?>, lng: <?=$photo['lng']?>, ent: '<?=$photo['ent']?>', img: '<?=$photo['img']?>'},
			<?php endforeach; ?>
		]
		console.table(info_markers)
		
		markers = info_markers.map(marker =>
		{

			return new google.maps.Marker({position: {lat: marker.lat, lng: marker.lng}, map: map, title: marker.ent})
		})

		markers.forEach((marker, index) =>
		{	
			marker.addListener('click', function() 
			{ 
				let content = `<h1>${info_markers[index].ent}</h1><br><img src="annonces/${info_markers[index].img}">`
				new google.maps.InfoWindow({content: content}).open(map, marker)
			})
		})

		new MarkerClusterer(map, markers, {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
    </script>
  </body>
</html>