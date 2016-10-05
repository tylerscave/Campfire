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