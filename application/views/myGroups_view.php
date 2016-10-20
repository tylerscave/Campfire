<!-- Header -->
<?php $this->load->view('template/header.php'); ?>
<!-- End Header -->

<!-- Body -->
<div class="container custom-body">
	<div class="row">
		<div class="no-gutter">
			<button type="button" class="btn btn-info" onclick="location.href='createGroup/index'">Create New Group</button>
		</div>
	</div>
	<div class="container-fluid">
	<?php 
		if (!isset($ownedgroups) && !isset($memberedgroups))
		{
			echo 'No groups joined or owned';
		}
		else {
			if (isset($ownedgroups))
			{
				echo "<div class='container-fluid'>";
					echo "<h3 style='text-align:left'>Owned Groups:</h3>";
				echo "</div>";
				echo "<section id='view_group_list_owned' class='no-padding'>";
					echo "<div class='container-fluid'>";
						echo "<div class='row no-gutter'>";			
							//lists all the groups that the user created
							if ($ownedgroups != null) {
								$size = sizeof($memberedgroups);
								for ($x = 0; $x < $size; $x++) {
									echo "<div class='col-lg-3 col-md-4 col-sm-6 col-xs-12'> <div class='hovereffect'> <img class='img-responsive' src='";
									echo base_url()."uploads/".$ownedgroups[$x]->org_picture."' style='width:300px; height:200px';>";
									echo "<div class='overlay'><h2>".$ownedgroups[$x]->org_title."</h2>";
									echo "<a class='info' id = 'owned".$ownedgroups[$x]->org_id."' href='".base_url()."index.php/Group/display/".$ownedgroups[$x]->org_id."'>View more details</a>";
									echo "</div></div>".$ownedgroups[$x]->org_title."</div>";
								}
							}
						echo "</div>";
					echo "</div>";
				echo "</section>";
			}
			if (isset($joinedgroups))
			{
				echo "<div class='no-padding'>";
					echo "<h3 style='text-align:left'>Joined Groups:</h3>";
				echo "</div>";
				echo "<section id='view_group_list_joined' class='no-padding' style='alignment:center'>";
					echo "<div class='container-fluid'>";
						echo "<div class='row no-gutter'>";
								//list all groups the user joined
								if ($memberedgroups != null) {
									$size = sizeof($memberedgroups);
									$ownedsameasmembered = false;
									for ($x = 0; $x < $size; $x++) {
										//excludes all groups user is an owner but is a member of
										for ($y = 0; $y < $size; $y++) {
											if ($memberedgroups[$x]->org_id == $ownedgroups[$y]->org_id) {
												$ownedsameasmembered = true;
											}
										}
										if ($ownedsameasmembered != true) {
											echo "<div class='col-lg-3 col-md-4 col-sm-6 col-xs-12'> <div class='hovereffect'> <img class='img-responsive' src='";
											echo base_url()."uploads/".$memberedgroups[$x]->org_picture."' style='width:300px; height:200px';>";
											echo "<div class='overlay'><h2>".$memberedgroups[$x]->org_title."</h2>";
											echo "<a class='info' id = 'joined".$memberedgroups[$x]->org_id."' href='".base_url()."index.php/Group/display/".$memberedgroups[$x]->org_id."'>View more details</a>";
											echo "</div></div>".$memberedgroups[$x]->org_title."</div>";
										}
										else {
											$ownedsameasmembered = false;
										}
									}
								}	
						echo "</div>";
					echo "</div>";
				echo "</section>";
			}	
		}
	?>
	</div>
</div>
<!-- End Body -->

<!-- Footer -->
<?php $this->load->view('template/footer.php'); ?>
<!-- End Footer -->
