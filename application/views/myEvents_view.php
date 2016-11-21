<!-- Header -->
<?php $this->load->view('template/header.php'); ?>
<!-- End Header -->

<!-- Body -->
<div class="container custom-body">
	<div class="row" style="padding-top:50px">
	<div class="container-fluid">
		<ul class="nav nav-pills nav-justified" style="background-color:white">
			<li class="active"><a data-toggle="tab" href="#owned_events">Owned</a></li>
			<li><a data-toggle="tab" href="#joined_events">Joined</a></li>
		</ul>
		<div style="padding-top:50px"></div>
		<div class="col-md-12 well" id="event_layout">
			<div class="col-md-10">
				<div class="tab-content">
					<div id="owned_events" class="tab-pane fade in active">
						<?php
							if ($ownedevents == NULL)
							{
								echo '<h4 id="create_event_link" style="padding-top:30px">No events created. Create an event? <a href="createEvent/index">click here</a></h4>';
							}
							else {								
								$ci =& get_instance();
								$ci->set_config($ownedevents);
								$per_page = $ci->input->get('per_page');
								$index = 12 * $per_page;
								$max = $index + 12;
								if($max > count($ownedevents)-1){
									$max = count($ownedevents); //in case of out of range error
								}
								for ($x = $index; $x < $max; $x++) {
									echo "<div class='col-md-3 card'>";
									echo "<a id='".$ownedevents[$x]->event_id."' href='".base_url()."index.php/Event/display/".$ownedevents[$x]->event_id."'><img class='img-responsive center-cropped' src='";
									echo base_url()."uploads/".$ownedevents[$x]->event_picture."' alt='".$ownedevents[$x]->event_title."'></a>";
									echo "<div class='card-block'>";
									echo"<h4 class='card-title' id='card-title'>".$ownedevents[$x]->event_title."</h4>";
									/*echo "<p class='card-text'>".$ownedevents[$x]->event_description."</p>*/
									echo "<a class='btn btn-primary waves-effect waves-light' href='".base_url()."index.php/Event/display/".$ownedevents[$x]->event_id."'>See More</a>
									</div></div>";
								}
								
								echo "<div class='col-md-12'>";
								echo $ci->pagination->create_links();
								echo "</div>";
								
							}
						?>
					</div>
					<div id="joined_events" class="tab-pane fade">
						<?php
							if ($memberedevents == NULL)
							{
								echo '<h4 id="search_event_link" style="padding-top:30px">No events pending. Search for events to attend: <a href="';
								echo base_url('index.php/Event/search');
								echo '">click here</a></h4>';
							}
							else
							{
								$ci =& get_instance();
								$per_page = $ci->input->get('per_page');
								$index = 12 * $per_page;
								$max = $index + 12;
								if($max > count($memberedevents)-1){
									$max = count($memberedevents); //in case of out of range error
								}										
								for ($x = $index; $x < $max; $x++) {
									echo "<div class='col-md-3 card'>";
									echo "<a id='".$memberedevents[$x]->event_id."' href='".base_url()."index.php/Event/display/".$memberedevents[$x]->event_id."'><img class='img-responsive center-cropped' src='";
									echo base_url()."uploads/".$memberedevents[$x]->event_picture."' alt='".$memberedevents[$x]->event_title."'></a>";
									echo "<div class='card-block'>";
									echo"<h4 class='card-title' id='card-title'>".$memberedevents[$x]->event_title."</h4>";
									/*echo "<p class='card-text'>".$memberedevents[$x]->event_description."</p>*/
									echo "<a class='btn btn-primary waves-effect waves-light' href='".base_url()."index.php/Event/display/".$memberedevents[$x]->event_id."'>See More</a>
									</div></div>";
								}
							}
						?>
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
