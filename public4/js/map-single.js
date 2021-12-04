//intialize the map
function initialize() {
  var mapOptions = {
    zoom: 13,
    scrollwheel: false,
    center: new google.maps.LatLng(40.925372, -74.27654)
  };

var map = new google.maps.Map(document.getElementById('map-single'),
      mapOptions);


// MARKERS
/****************************************************************/

//add a marker1
var marker = new google.maps.Marker({
    position: map.getCenter(),
    map: map,
    icon: 'images/pin.png'
});


// INFO BOXES
/****************************************************************/

//show info box for marker1
var contentString = '<div class="info-box"><img src="images/feature-properties/fp-1.jpg" class="info-box-img" alt="" /><h4>995 South Park Avenue</h4><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque in ultrices metus' + 
                    ' sit amet [...]</p><a href="properties-details.html" class="button small">View Details</a><br/></div>';

var infowindow = new google.maps.InfoWindow({ content: contentString });

google.maps.event.addListener(marker, 'click', function() {
    infowindow.open(map,marker);
  });

}

google.maps.event.addDomListener(window, 'load', initialize);

