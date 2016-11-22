<!-- Header -->
<?php $this->load->view('template/header.php'); ?>
<!-- End Header -->

<!-- Body -->
<div class="container custom-body">
	<div class="row" style="padding-top:50px">
	<div class="col-md-4" align="center">
		<ul class="nav nav-pills nav-justified" style="background-color:white">
		<li id="owned_groupsTab" class="active"><a data-toggle="tab" href="#owned_groups">Owned</a></li>
		<li id="joined_groupsTab"><a data-toggle="tab" href="#joined_groups">Joined</a></li>
		</ul>
	</div>
	<div class="container-fluid">
		<div style="padding-top:50px"></div>
		<div class="col-md-12 well" id="group_view_layout">
			<div class="col-md-10">
				<div class="tab-content">
					<div id="owned_groups" class="tab-pane fade in active">
						<?php
							if ($ownedgroups == NULL)
							{
								echo '<h4 style="padding-top:30px">No groups owned. Create a group? <a href="createGroup/index">click here</a></h4>';
							}
							else {								
								$ci =& get_instance();
								$ci->set_config($ownedgroups);
								$per_page = $ci->input->get('per_page');
								$index = 12 * $per_page;
								$max = $index + 12;
								if($max > count($ownedgroups)-1){
									$max = count($ownedgroups); //in case of out of range error
								}
								for ($x = $index; $x < $max; $x++) {
									echo "<div class='col-md-3 card'>";
									echo "<a id='".$ownedgroups[$x]->org_id."' href='".base_url()."index.php/Group/display/".$ownedgroups[$x]->org_id."'><img class='img-responsive center-cropped' src='";
									echo base_url()."uploads/".$ownedgroups[$x]->org_picture."' alt='".$ownedgroups[$x]->org_title."'></a>";
									echo "<div class='card-block'>";
									echo"<h4 class='card-title' id='card-title'>".$ownedgroups[$x]->org_title."</h4>";
									echo "<p class='card-text'>".$ownedgroups[$x]->org_description."</p>
									<a class='btn btn-primary waves-effect waves-light' href='".base_url()."index.php/Group/display/".$ownedgroups[$x]->org_id."'>See More</a>
									</div></div>";
								}
								
								echo "<div class='col-md-12'>";
								echo $ci->pagination->create_links();
								echo "</div>";
								
							}
						?>
					</div>
					<div id="joined_groups" class="tab-pane fade">
						<?php
							if ($memberedgroups == NULL)
							{
								echo '<h4 style="padding-top:30px">No groups joined. Search for a group to join: <a href="';
								echo base_url('index.php/Group/search');
								echo '">click here</a></h4>';
							}
							else
							{
								$ci =& get_instance();
								$per_page = $ci->input->get('per_page');
								$index = 12 * $per_page;
								$max = $index + 12;
								if($max > count($memberedgroups)-1){
									$max = count($memberedgroups); //in case of out of range error
								}										
								for ($x = $index; $x < $max; $x++) {
									echo "<div class='col-md-3 card'>";
									echo "<a id='".$memberedgroups[$x]->org_id."' href='".base_url()."index.php/Group/display/".$memberedgroups[$x]->org_id."'><img class='img-responsive center-cropped' src='";
									echo base_url()."uploads/".$memberedgroups[$x]->org_picture."' alt='".$memberedgroups[$x]->org_title."'></a>";
									echo "<div class='card-block'>";
									echo"<h4 class='card-title' id='card-title'>".$memberedgroups[$x]->org_title."</h4>";
									echo "<p class='card-text'>".$memberedgroups[$x]->org_description."</p>
									<a class='btn btn-primary waves-effect waves-light' href='".base_url()."index.php/Group/display/".$memberedgroups[$x]->org_id."'>See More</a>
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
</div>
<!-- End Body -->

<!-- Footer -->
<?php $this->load->view('template/footer.php'); ?>
<!-- End Footer -->