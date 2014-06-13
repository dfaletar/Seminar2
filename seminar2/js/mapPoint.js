 var kor = <?php echo json_encode($kor); ?>;
 var imena = <?php echo json_encode($imena); ?>;
 var count =<?php echo json_encode($counter); ?>;
 var tmpIme = [];
 var tmpNes = [];
 var infowindow = [];


for (var i = 0; i < count; i++) {
    tmpIme[i] =new google.maps.LatLng(kor[i]);
}

function initialize()
{

  var mapProp = {
  panControlOptions: {
    position: google.maps.ControlPosition.TOP_RIGHT
  },
  zoomControl: true,
  zoomControlOptions: {
    style: google.maps.ZoomControlStyle.LARGE,
    position: google.maps.ControlPosition.TOP_RIGHT
  },
    center:myCenter,
    zoom:11,
    scrollwheel:false,
    mapTypeId:google.maps.MapTypeId.ROADMAP
  };

  var map=new google.maps.Map(document.getElementById("googleMap"), mapProp);

  for (var j = 0; j < count; j++) {
    
    tmpNes[j] = new google.maps.Marker({
        position:tmpIme[i],});
      tmpNes[j].setMap(map);
      infowindow1[j] = new google.maps.InfoWindow({
        content:"nes"});
      google.maps.event.addListener(tmpNes[j], 'mouseover', function() {
        infowindow1[j].open(map,tmpNes[j]);});
      google.maps.event.addListener(tmpNes[j], 'mouseout', function() {
        infowindow1[j].close();});
  }
}
//karte se učitavaju tek nakon što sa stranica učitala
google.maps.event.addDomListener(window, 'load', initialize);