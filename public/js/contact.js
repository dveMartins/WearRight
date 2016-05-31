
function initialize() {
  var mapProp = {
    center:new google.maps.LatLng(47.878660,10.621740),
    zoom:10,
    mapTypeId:google.maps.MapTypeId.ROADMAP
  };
  var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
  var marker = new google.maps.Marker({
      position:new google.maps.LatLng(47.878660,10.621740)
      });

      marker.setMap(map);
      var infowindow = new google.maps.InfoWindow({
        content:"WearRight Inc."
      });

      infowindow.open(map,marker);
}

google.maps.event.addDomListener(window, 'load', initialize);