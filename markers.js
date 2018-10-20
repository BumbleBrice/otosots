class points extends google.maps.OverlayView 
{
    constructor (pos, map, text) 
    {
        super()
        this.div = null
        this.pos = pos
        this.text = text
        this.setMap(map)
    }

    onAdd () 
    {
        this.div = document.createElement('div')
        this.div.classList.add('div_custom')
        this.div.innerHTML = this.text
        this.getPanes().overlayImage.appendChild(this.div)
    }

    draw () 
    {
        let position = this.getProjection().fromLatLngToDivPixel(this.pos)
        this.div.style.left = position.x + "px"
        this.div.style.top = position.y + "px"
    }

    onRemove () 
    {
        this.div.parentNode.removeChild(this.div)
    }
}

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

drawpoints()