let positions       = ``,
    photo_bas64     = '',
    video           = document.querySelector('#video'),
    canvas          = document.querySelector('#canvas'),
    startbutton     = document.querySelector('#startbutton'),
    width = 250,
    height = 250;

// photo
navigator.mediaDevices.getUserMedia(
{
    video: true,
    audio: false
}).then(stream => 
{
    video.srcObject = stream
}).catch(console.error)

function takepicture() 
{
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d').drawImage(video, 0, 0);
    photo_bas64 = canvas.toDataURL('image/png');
}

startbutton.addEventListener('click', function(ev)
{
    ev.preventDefault();
    takepicture();
    let data = new FormData()

    data.append("positions", positions)
    data.append("photo", photo_bas64)
    data.append("entreprise", document.querySelector('input[type=text][name=entreprise]').value)

    // ajax
    fetch('add.php', {method: 'POST', body: data})
    .then(response => response.text()).then(response => {
        if(response !== 'ok')
        {
            alert('il y a eu une erreur')
        }
        else
        {
            if(confirm('L\'annonce a bien était enregistré Voulez vous retourner a la maps ?'))
            {
                document.location = "http://localhost:8000/"
            }
        }
    })
    // /ajax

}, false);
// /photo

// geo
var options = {
    enableHighAccuracy: true,
    timeout: 5000,
    maximumAge: 0
  };
  
  function success(pos) {
    var crd = pos.coords;
    positions = `${crd.latitude} ${crd.longitude}`;
    startbutton.removeAttribute('disabled');
  };
  
  function error(err) {
    console.warn(`ERROR(${err.code}): ${err.message}`);
  };
  
  navigator.geolocation.getCurrentPosition(success, error, options);
// /geo