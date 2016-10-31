<!-- Header -->
<?php $this->load->view('template/header.php'); ?>
<!-- End Header -->

<!-- Body -->
<div class="container custom-body">
	<div class="row" style="padding-top:50px">
	<div class="container-fluid">
		<ul class="nav nav-pills nav-justified" style="background-color:white">
		<li class="active"><a data-toggle="tab" href="#owned_groups">Owned</a></li>
		<li><a data-toggle="tab" href="#joined_groups">Joined</a></li>
		</ul>

		<div class="tab-content">
			<div id="owned_groups" class="tab-pane fade in active">
			<?php
				if ($ownedevents == NULL)
				{
					echo '<h4 id="create_event_link" style="padding-top:30px">No events created. Create an event? <a href="createEvent/index">click here</a></h4>';
				}
				else {
					echo '<div style="padding-top:30px">';
					
						//lists all the events that the user created
						if ($ownedgroups != null) {
							$size = sizeof($ownedevents);
							for ($x = 0; $x < $size; $x++) {
								echo "<div class='col-md-3 filter ".$ownedevents[$x]->org_tag."'>";
								echo "<p class='org-title'>".$ownedevents[$x]->org_title."</p>";
								echo "<a href='".base_url()."index.php/Group/display/".$ownedevents[$x]->org_id."'>";
								echo "<img class='img-responsive center-cropped' src='";
								echo base_url()."uploads/".$ownedevents[$x]->org_picture."' alt='".$ownedevents[$x]->org_title."'></a></div>";																																																																																																	
							}
							
						}
					echo "</div>";
				}
				?>
			</div>
			<div id="joined_groups" class="tab-pane fade">
				<?php
					if (sizeof($memberedevents) == sizeof($ownedevents))
					{
						echo '<h4 id="search_event_link" style="padding-top:30px">No events that you are going to. Search for events to go to: <a href="';
						echo base_url('index.php/Event/search');
						echo '">click here</a></h4>';
					}
					else
					{
						echo '<div style="padding-top:30px">';
							//list all events the user RSVP
							if ($memberedevents != null) {
								$size = sizeof($memberedevents);
								$ownedsameasmembered = false;
								for ($x = 0; $x < $size; $x++) {
									//excludes all events created by the user to show up on RSVP list
									for ($y = 0; $y < $size; $y++) {
										if ($memberedevents[$x]->org_id == $ownedevents[$y]->org_id) {
											$ownedsameasmembered = true;
										}
									}
									if ($ownedsameasmembered != true) {
										echo "<div class='col-md-3 filter ".$memberedevents[$x]->org_tag."'>";
										echo "<p class='org-title'>".$memberedevents[$x]->org_title."</p>";
										echo "<a href='".base_url()."index.php/Group/display/".$memberedevents[$x]->org_id."'>";
										echo "<img class='img-responsive center-cropped' src='";
										echo base_url()."uploads/".$memberedevents[$x]->org_picture."' alt='".$memberedevents[$x]->org_title."'></a></div>";
									}
									else {
										$ownedsameasmembered = false;
									}
								}
							}
						echo "</div>";
					}
				?>
			</div>
		</div>
	</div>
	</div>
</div>
<!-- End Body -->

<!-- Footer -->
<?php $this->load->view('template/footer.php'); ?>
<!-- End Footer -->
