//Google Map Stuff

var infowindows = [];
var markers = [];
var map;
function initMap() {
  map = new google.maps.Map(document.getElementById('map'), {
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
    $.ajax({
        type: "POST",
        url: "http://localhost/Campfire/Event/search_nearby",
        data: {current_lat: position.coords.latitude, current_lng: position.coords.longitude, dist: 10},
        success: function(data){
            var result = $.parseJSON(data);
            displayEvents(result);
        }
    });
  });
  }

  autocomplete.bindTo('bounds', map);
  autocomplete.setTypes(['(regions)']);

  map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);

  autocomplete.addListener('place_changed', function() {
    removeMarkers();
    removeInfoWindows();
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

    $.ajax({
        type: "POST",
        url: "http://localhost/Campfire/Event/search_nearby",
        data: {current_lat: place.geometry.location.lat, current_lng: place.geometry.location.lng, dist: 10},
        success: function(data){
            var result = $.parseJSON(data);
            displayEvents(result);
        }
    });

  });
}
function displayEvents(events){
  events.forEach(function(event){

    var infowindow = new google.maps.InfoWindow();
    var marker = new google.maps.Marker({
      map: map
    });

    marker.addListener('click', function() {
      infowindow.open(map, marker);
    });

    marker.setPosition(new google.maps.LatLng(event['geolat'], event['geolng']));
    marker.setVisible(true);
    var url = 'http://localhost/Campfire/Event/display/' + event['event_id'];
    var content =
    '<strong>' + event['event_title'] + '</strong><br>' +
    '<em>Description:</em> ' + event['event_description']  + '<br>' +
    '<em>Date/Time:</em> ' + event['event_begin_datetime']  + ' to ' +  event['event_end_datetime']  + '<br>' +
    '<em>Tag:</em> '  + '-' +  event['tag_title']  + '<br>' +
    '<em>Members:</em> '  + '-' +  event['attendee_count']  + '<br>' +
    '<em>Link:</em> '  + '<a href="'+ url +'">Go to </a>';

    infowindow.setContent(content);

    infowindows.push(infowindow);
    markers.push(marker);
  });
}
function removeMarkers(){
  markers.forEach(function(marker){
    marker.setMap(null);
  });
}

function removeInfoWindows(){
  infowindows.forEach(function(iw){
    iw.close();
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
$(function () {
    $('#startDate').datetimepicker({
    startDate,
    format: 'mm/dd/yyyy h:i',
    minuteStep: 15,
    autoclose: true,
    });

    $('#endDate').datetimepicker({
    format: 'mm/dd/yyyy h:i',
    minuteStep: 15,
    autoclose: true
    });

    $("#startDate").on("dp.change",function (e) {
        $('#endDate').data("DateTimePicker").setMinDate(e.date);
    });
    $("#endDate").on("dp.change",function (e) {
        $('#startDate').data("DateTimePicker").setMaxDate(e.date);
    });
});


function initialize() {

var input = document.getElementById('searchTextField');
var autocomplete = new google.maps.places.Autocomplete(input);
}
google.maps.event.addDomListener(window, 'load', initialize);

// end of custom.js


// $(function () {
//         $('#startDate').datetimepicker();
//         $('#endDate').datetimepicker({
//             useCurrent: false //Important! See issue #1075
//         });
//         $("#startDate").on("dp.change", function (e) {
//             $('#endDate').data("DateTimePicker").minDate(e.date);
//         });
//         $("#endDate").on("dp.change", function (e) {
//             $('#startDate').data("DateTimePicker").maxDate(e.date);
//         });
//     });

// function testJS() {
//   jQuery('#eventDateTimeStart').datetimepicker();
//   jQuery('#eventDateTimeEnd').datetimepicker();
//   jQuery("#eventDateTimeStart").on("dp.change",function (e) {
//         jQuery('#eventDateTimeEnd').data("DateTimePicker").setMinDate(e.date);
//   });
//   jQuery("#eventDateTimeEnd").on("dp.change",function (e) {
//         jQuery('#eventDateTimeStart').data("DateTimePicker").setMaxDate(e.date);
//   });
// };
