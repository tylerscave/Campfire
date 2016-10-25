//Google Map Stuff
function initMap() {
  var map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: 37.3352, lng: -121.8811},
    zoom: 5
  });
  var input = document.getElementById('pac-input');
  var autocomplete = new google.maps.places.Autocomplete(input);

  // Try HTML5 geolocation.
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
    };
    map.setCenter(pos);
    map.setZoom(13);
  });
  }

  autocomplete.bindTo('bounds', map);
  autocomplete.setTypes(['(regions)']);

  map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);

  var infowindow = new google.maps.InfoWindow();
  var marker = new google.maps.Marker({
    map: map
  });
  marker.addListener('click', function() {
    infowindow.open(map, marker);
  });

  autocomplete.addListener('place_changed', function() {
    infowindow.close();
    var place = autocomplete.getPlace();
    if (!place.geometry) {
      return;
    }

    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(18);
    }

    // Set the position of the marker using the place ID and location.
    marker.setPlace({
      placeId: place.place_id,
      location: place.geometry.location
    });
    marker.setVisible(true);

    infowindow.setContent('<div><strong>' + place.formatted_address + '</strong><br>');

    infowindow.open(map, marker);

  });
}

function confirmDelete() {
	bootbox.confirm({
	    message: "Are you sure you want to delete your account? This can not be undone.",
	    buttons: {
	        confirm: {
	            label: 'Delete',
	            className: 'btn-danger'
	        },
	        cancel: {
	            label: 'Cancel',
	            className: 'btn'
	        }
	    },
	    callback: function (result) {
	        if (result) {
	            $.ajax({
	                url: 'editProfile/deleteUser',
	                type: 'POST'
	            });
	            $('.well').append('<div class="alert alert-success text-center">You have Successfully Deleted your account! You will be redirected shortly.</div>');
	            var delay = 3000;
	            setTimeout(function() {
	            	location.href='home/index';
	            }, delay);


	        }
	    }
	});
}

function confirmGroupDelete() {
	bootbox.confirm({
	    message: "Are you sure you want to delete this group? This can not be undone.",
	    buttons: {
	        confirm: {
	            label: 'Delete',
	            className: 'btn-danger'
	        },
	        cancel: {
	            label: 'Cancel',
	            className: 'btn'
	        }
	    },
	    callback: function (result) {
	        if (result) {
	            $.ajax({
	                url: 'editGroup/deleteGroup',
	                type: 'POST'
	            });
	            $('.well').append('<div class="alert alert-success text-center">You have Successfully Deleted The Group! You will be redirected shortly.</div>');
	            var delay = 3000;
	            setTimeout(function() {
	            	location.href='home/index';
	            }, delay);
	        }
	    }
	});
}
