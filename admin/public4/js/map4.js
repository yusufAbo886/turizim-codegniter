//intialize the map
function initialize() {
  var mapOptions = {
    zoom: 12,
    scrollwheel: false,
    center: new google.maps.LatLng(40.925372, -74.27654)
  };

var map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);
	
var styles = [
    {
        "stylers": [
            {
                "hue": "#0098ef"
            },
            {
                "saturation": 0
            },
            {
                "gamma": 0
            },
            {
                "lightness": 0
            }
        ]
    },
	{
        "featureType": "road",
        "elementType": "geometry",
        "stylers": [
            {
                "color": "#f9a11b"
            },
            {
                "lightness": 40
            }
        ]
    }
]

    map.setOptions({styles: styles});


// MARKERS
/****************************************************************/

//add a marker1
var marker = new google.maps.Marker({
    position: map.getCenter(),
    map: map,
    icon: 'images/pin.png'
});

//add a marker2
var marker2 = new google.maps.Marker({
    position: new google.maps.LatLng(40.929399, -74.430091),
    map: map,
    icon: 'images/pin.png'
});

//add a marker3
var marker3 = new google.maps.Marker({
    position: new google.maps.LatLng(40.892321, -74.477377),
    map: map,
    icon: 'images/pin.png'
});

//add a marker4
var marker4 = new google.maps.Marker({
    position: new google.maps.LatLng(40.895654, -74.433256),
    map: map,
    icon: 'images/pin.png'
});

//add a marker5
var marker5 = new google.maps.Marker({
    position: new google.maps.LatLng(40.882099, -74.379868),
    map: map,
    icon: 'images/pin.png'
});

//add a marker6
var marker6 = new google.maps.Marker({
    position: new google.maps.LatLng(40.976543, -74.025419),
    map: map,
    icon: 'images/pin.png'
});
	
//add a marker7
var marker7 = new google.maps.Marker({
    position: new google.maps.LatLng(41.879198, -87.843116),
    map: map,
    icon: 'images/pin.png'
});
	
//add a marker8
var marker8 = new google.maps.Marker({
    position: new google.maps.LatLng(40.928710, -74.039862),
    map: map,
    icon: 'images/pin.png'
});
	
//add a marker9
var marker9 = new google.maps.Marker({
    position: new google.maps.LatLng(40.959966, -74.297921),
    map: map,
    icon: 'images/pin.png'
});
	
//add a marker10
var marker10 = new google.maps.Marker({
    position: new google.maps.LatLng(40.914876, -74.382921),
    map: map,
    icon: 'images/pin.png'
});
	
//add a marker11
var marker11 = new google.maps.Marker({
    position: new google.maps.LatLng(40.926000, -74.302921),
    map: map,
    icon: 'images/pin.png'
});
	
//add a marker12
var marker12 = new google.maps.Marker({
    position: new google.maps.LatLng(40.842000, -74.302921),
    map: map,
    icon: 'images/pin.png'
});
	
//add a marker13
var marker13 = new google.maps.Marker({
    position: new google.maps.LatLng(40.867000, -74.258921),
    map: map,
    icon: 'images/pin.png'
});
	



// INFO BOXES
/****************************************************************/

//show info box for marker1
var contentString = '<div class="info-box"><img src="images/feature-properties/fp-1.jpg" class="info-box-img" alt="" /><h4>995 South Park Avenue</h4><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque in ultrices metus.' + 
                    '</p><a href="properties-details.html" class="button small">View Details</a><br/></div>';

var infowindow = new google.maps.InfoWindow({ content: contentString });

google.maps.event.addListener(marker, 'click', function() {
    infowindow.open(map,marker);
  });


//show info box for marker2
google.maps.event.addListener(marker2, 'click', function() {
    infowindow.open(map,marker2);
  });

//show info box for marker3
google.maps.event.addListener(marker3, 'click', function() {
    infowindow.open(map,marker3);
  });

//show info box for marker4
google.maps.event.addListener(marker4, 'click', function() {
    infowindow.open(map,marker4);
  });

//show info box for marker5
google.maps.event.addListener(marker5, 'click', function() {
    infowindow.open(map,marker5);
  });

//show info box for marker6
google.maps.event.addListener(marker6, 'click', function() {
    infowindow.open(map,marker6);
  });
	
//show info box for marker7
google.maps.event.addListener(marker7, 'click', function() {
    infowindow.open(map,marker7);
  });
	
//show info box for marker8
google.maps.event.addListener(marker8, 'click', function() {
    infowindow.open(map,marker8);
  });
	
//show info box for marker9
google.maps.event.addListener(marker9, 'click', function() {
    infowindow.open(map,marker9);
  });
	
//show info box for marker10
google.maps.event.addListener(marker10, 'click', function() {
    infowindow.open(map,marker10);
  });
	
//show info box for marker11
google.maps.event.addListener(marker11, 'click', function() {
    infowindow.open(map,marker11);
  });
	
//show info box for marker12
google.maps.event.addListener(marker12, 'click', function() {
    infowindow.open(map,marker12);
  });
	
//show info box for marker13
google.maps.event.addListener(marker13, 'click', function() {
    infowindow.open(map,marker13);
  });

}

google.maps.event.addDomListener(window, 'load', initialize);