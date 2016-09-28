//Tabbed Forms Script
$(document).ready( function(){$('#loginlink').click(function(e) {
		$("#login-form").delay(100).fadeIn(100);
 		$("#register-form").fadeOut(100);
		$('#register-tab').removeClass('active');
		$('#login-tab').addClass('active');
	});
	$('#registerlink').click(function(e) {
		$("#register-form").delay(100).fadeIn(100);
 		$("#login-form").fadeOut(100);
		$('#login-tab').removeClass('active');
		$('#register-tab').addClass('active');
	}); });


//Google Maps Stuff
function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 37.3352, lng: -121.8811},
          zoom: 5
        });

				var marker = new google.maps.Marker({
					map:map
				});

				var input = document.getElementById('pac-input');
				map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);

        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };

            map.setCenter(pos);
												// Set the position of the marker using the place ID and location.
						marker.setPosition(pos);
						marker.setVisible(true);
						map.setZoom(16);

          }, function() {
            //Error
          });
        } else {
          // Browser doesn't support Geolocation
        }
      }
