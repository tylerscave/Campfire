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
				if ($ownedgroups == NULL)
				{
					echo '<h4 style="padding-top:30px">No groups owned. Create a group? <a href="createGroup/index">click here</a></h4>';
				}
				else {
					echo '<div style="padding-top:30px">';

						//lists all the groups that the user created
						if ($ownedgroups != null) {
							$size = sizeof($ownedgroups);
							for ($x = 0; $x < $size; $x++) {
							echo "<div class='col-md-3 >";
								echo "<p class='org-title'>".$ownedgroups[$x]->org_title."</p>";
								echo "<a id = '".$ownedgroups[$x]->org_id."' href='".base_url()."index.php/Group/display/".$ownedgroups[$x]->org_id."'>";
								echo "<img class='img-responsive center-cropped' src='";
								echo base_url()."uploads/".$ownedgroups[$x]->org_picture."' alt='".$ownedgroups[$x]->org_title."'></a></div>";
							}

						}
					echo "</div>";
				}
				?>
			</div>
			<div id="joined_groups" class="tab-pane fade">
				<?php

					if (sizeof($memberedgroups) == sizeof($ownedgroups))
					{
						echo '<h4 style="padding-top:30px">No groups joined. Search for a group to join: <a href="';
						echo base_url('index.php/Group/search');
						echo '">click here</a></h4>';
					}
					else
					{
						echo '<div style="padding-top:30px">';
							//list all groups the user joined
							if ($memberedgroups != null) {
								$memberedsize = sizeof($memberedgroups);
								$ownedsize = sizeof($ownedgroups);
								$ownedsameasmembered = false;
								for ($x = 0; $x < $memberedsize; $x++) {
									//excludes all groups user is an owner but is a member of
									for ($y = 0; $y < $ownedsize; $y++) {
										if ($memberedgroups[$x]->org_id == $ownedgroups[$y]->org_id) {
											$ownedsameasmembered = true;
										}
									}
									if ($ownedsameasmembered != true) {
										echo "<div class='col-md-3 >";
										echo "<p class='org-title'>".$memberedgroups[$x]->org_title."</p>";
										echo "<a id= '".$memberedgroups[$x]->org_id."' href='".base_url()."index.php/Group/display/".$memberedgroups[$x]->org_id."'>";
										echo "<img class='img-responsive center-cropped' src='";
										echo base_url()."uploads/".$memberedgroups[$x]->org_picture."' alt='".$memberedgroups[$x]->org_title."'></a></div>";
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