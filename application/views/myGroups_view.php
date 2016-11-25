<!-- Header -->
<?php $this->load->view('template/header.php'); ?>
<!-- End Header -->

<!-- Body -->
<div class="container custom-body">
	<div class="row">
	<div class="container" style="padding-top:50px">
		<ul class="nav nav-pills">
		<li id="owned_groupsTab" class="active"><a data-toggle="tab" href="#owned_groups">Owned</a></li>
		<li id="joined_groupsTab"><a data-toggle="tab" href="#joined_groups">Joined</a></li>
		</ul>
	</div>
	<div class="container-fluid">
		<div style="padding-top:20px"></div>
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
								make_tiles("owned", count($ownedgroups), $ownedgroups);
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
								make_tiles("membered", count($memberedgroups), $memberedgroups);
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

<?php

function make_tiles($set, $size, $groups)
{
	if ($set == "owned")
	{
		for ($x = 0; $x < $size; $x++) {
			echo "<div class='col-md-3 card'>";
			echo "<a id='".$groups[$x]->org_id."' href='".base_url()."index.php/Group/display/".$groups[$x]->org_id."'><img class='img-responsive center-cropped' src='";
			echo base_url()."uploads/".$groups[$x]->org_picture."' alt='".$groups[$x]->org_title."'></a>";
			echo "<div class='card-block'>";
			echo"<h4 class='card-title' id='card-title'>".$groups[$x]->org_title."</h4>";
			echo "<p class='card-text'>".$groups[$x]->org_description."</p>
			<a class='btn btn-primary waves-effect waves-light' href='".base_url()."index.php/Group/display/".$groups[$x]->org_id."'>See More</a>
			</div></div>";
		}
	}
	else if ($set == "membered")
	{
		for ($x = 0; $x < $size; $x++) {
			echo "<div class='col-md-3 card'>";
			echo "<a id='".$groups[$x]->org_id."' href='".base_url()."index.php/Group/display/".$groups[$x]->org_id."'><img class='img-responsive center-cropped' src='";
			echo base_url()."uploads/".$groups[$x]->org_picture."' alt='".$groups[$x]->org_title."'></a>";
			echo "<div class='card-block'>";
			echo"<h4 class='card-title' id='card-title'>".$groups[$x]->org_title."</h4>";
			echo "<p class='card-text'>".$groups[$x]->org_description."</p>
			<a class='btn btn-primary waves-effect waves-light' href='".base_url()."index.php/Group/display/".$groups[$x]->org_id."'>See More</a>
			</div></div>";
		}
	}
	else{
		return;
	}
}

?>

<!-- Footer -->
<?php $this->load->view('template/footer.php'); ?>
<!-- End Footer -->
