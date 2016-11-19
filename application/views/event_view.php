<!-- Header -->
<?php $this->load->view('template/header.php'); ?>
<!-- End Header -->

<!-- Body -->
	<div class="container custom-body" style="color: black">

		<div class="row">
			<div class="col-md-8 col-md-offset-2 ">
			<div id="map-canvas" style="width:100%;height:200px;margin:10px;" ></div>
				<div class="row">
					<div class="col-md-3">
				      	 <img id="eventPicture" height="100%" width="100%" src="<?php echo base_url().'uploads/'.$info['event_picture']?>" alt="...">
				  	</div>
			  		<div class="col-md-9">
						<div class="row">
							<div class=" col-md-12 panel panel-default">
								<div class="panel-body" id="eventTitleText"><h4><strong><?php echo $info['event_title'];?></strong>
								<?php 
								if ($status == 'owner') {
									echo '<a class="btn btn-info pull-right" id="editEventButton" href="'.base_url().'index.php/EditEvent/index/'.$info['event_id'].'">Edit Event</a>';
								} else if ($status == 'member') {
									echo '<a class="btn btn-info pull-right" id="leaveEventButton" href="'.base_url().'index.php/Event/leave_event/'.$info['event_id'].'">Withdraw</a>';
								} else  if ($status == 'nonmember'){
									echo '<a class="btn btn-info pull-right" id="joinEventButton" href="'.base_url().'index.php/Event/join_event/'.$info['event_id'].'">RSVP</a>';
								} else {
									echo '<a class="btn btn-info pull-right" id="joinEventButton" href="'.base_url().'index.php/Login">Login to Join</a>';
								}
								?></h4></div>
								<table class="table text-left">
									<tr>
										<td id="eventOwnerName">Owner: <?php echo $info['user_fname'].' '.$info['user_lname'];?></td>
										<td id="eventOwnerEmail">Email: <?php echo $info['user_email']?></td>
									</tr>
								</table>
							</div>
						</div>
						<div class="row" style="padding: 1em 0em">
							<div class="panel panel-default">
								<table class="table table-responsive">
									<?php 
										echo '<tr class="row">';
										echo '<td colspan="2">'.$info['address_one'].' '.$info['address_two'].'</td>';
										echo '</tr>';
										echo '<tr class="row">';
										echo '<td>'.$info['city'].'</td><td>'.$info['state'].'</td>';
										echo '</tr>';
									?>
								</table>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row">
				<div class="panel panel-default">
								<div class="panel-heading">
									<div class="row">
										<div class="col-md-10 col-md-offset-1"><h5 class="panel-title">Attendees (<?php echo count($members)?>)</h5></div>
										<div class="col-md-1">
											<button  type="button" class="btn btn-default" data-toggle="collapse" data-target="#member-table">
										  		<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
											</button>
										</div>
									</div>
								</div>
								<div class="pre-scrollable collapse" id="member-table">
									<table class="table">
										<?php 
											$count = 0;
											foreach ($members as $row) {
												if ($count % 3 == 0) {
													echo '<tr>';
												}
													echo '<td style=\'width:33%\'>'.$row['user_fname'].' '.substr($row['user_lname'], 0,1).'.</td>';
												$count++;
												if ($count % 3 == 3) {
													echo '</tr>';
												}
											}
											while ($count % 3 != 0) {
												echo '<td style=\'width:33%\'> </td>';
												$count++;
											}
											echo '</tr>';
											
										?>
									</table>
								</div>
							</div>
					
				</div>
				<div class="row">
					<div class="panel panel-default">
						<div class="panel-heading"><h5 class="panel-title">Description</h5></div>
						<div class="panel-body" id="eventDescriptionText">
							<?php echo $info['event_description'];?>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="panel panel-default">
						<div class="panel-heading"><h5 class="panel-title">Bulletin Board</h5></div>
						<div class="panel-body">
							<table class="table table-responsive text-left">
							<?php 
								foreach ($bulletins as $row) {
									echo '<tr class="row">';
									echo '<td class="col-md-2">'.$row['user_fname'].' '.substr($row['user_lname'], 0,1).'.</td>';
									echo '<td class="col-md-2">'.$row['bulletin_datetime'].'.</td>';
									echo '<td class="col-md-8"><p style="font-size: 14px;">'.$row['bulletin_message'].'</p></td>';
									echo '</tr>';
								}
							?>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<!-- End Body -->

<!-- Footer -->
<?php $this->load->view('template/footer.php'); ?>
<!-- End Footer -->

<script>
var lat = <?php echo $info['geolat']?>;
var lng = <?php echo $info['geolng']?>;

function toggler(divId) {
    $("#" + divId).toggle();
}

function initialize() {
    var mapOptions = {
        center: new google.maps.LatLng(lat, lng),
        zoom: 17,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        scrollwheel: false,
        draggable: false,
        panControl: true,
        zoomControl: true,
        mapTypeControl: true,
        scaleControl: true,
        streetViewControl: false,
        overviewMapControl: true,
        rotateControl: true,
    };
    
    var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
    var marker = new google.maps.Marker({
        position: {lat: lat, lng: lng},
        map: map,
        title: "<?php echo $info['event_title']?>"
      });
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-6CzpsxPQPdiOV_3M0QhATgjyTqO7JQE&libraries=places&callback=initialize">
 </script>
