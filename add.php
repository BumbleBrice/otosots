<?php
    if(!empty($_POST))
    {
        $decoded=base64_decode(explode(',', $_POST['photo'])[1]);
        file_put_contents('annonces/'.$_POST['positions'].' '.$_POST['entreprise'].'.png',$decoded);
        die('ok');   
    }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>ajouter une photo</title>
    <script src="photos.js" defer></script>
  </head>
  <body>
    <video id="video" autoplay></video>
    <canvas id="canvas"></canvas>
    <input type="text" name="entreprise">
    <button id="startbutton" disabled>Prendre la photo</button>
  </body>
</html>