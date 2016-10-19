<!-- Header -->
<?php $this->load->view('template/header.php'); ?>
<!-- End Header -->

<!-- Body -->
<div class="container custom-body">
	<div class="row">
		<div class="col-md-4">
			<h4>Notifications</h4>
			<p>This is the My Groups Page<p/>
			<p><p/>
			<p>Thanks for Logging in!</p>
			<p>Name: <?php echo $uname; ?></p>
			<p>Email: <?php echo $uemail; ?></p>
			<hr/>
		</div>
		<div class="col-md-8">
			<button type="button" class="btn btn-info" onclick="location.href='createGroup/index'">Create New Group</button>
		</div>
		<div class="col-md-8" style="margin-top: 15px; margin-bottom: 15px;">
			<?php 
				if ($ownedgroups == null && $memberedgroups == null){
					echo 'No groups joined or owned';
				}
				else {
					echo '<div class="panel-group">';
							if ($ownedgroups != null) {
								$size = sizeof($memberedgroups);
								for ($x = 0; $x < $size; $x++) {
									echo '<div class="panel panel-default"; onclick="location.href='; echo "'group/index'"; echo '"; onmouseover="background-color:black";>';
									echo '<div class="panel-body" style="background-color: red;"><div>' .$ownedgroups[$x]->org_title;
									echo '</div><div>' .$ownedgroups[$x]->org_description. '</div></div>';
									echo '</div>';
								}
							}
							if ($memberedgroups != null) {
								$size = sizeof($memberedgroups);
								$ownedsameasmembered = false;
								for ($x = 0; $x < $size; $x++) {
									for ($y = 0; $y < $size; $y++) {
										if ($memberedgroups[$x]->org_id == $ownedgroups[$y]->org_id) {
											$ownedsameasmembered = true;
										}
									}
									if ($ownedsameasmembered != true) {
										echo '<div class="panel panel-default">';
										echo '<div class="panel-body" style="background-color: yellow;"><div>' .$memberedgroups[$x]->org_title;
										echo '</div><div>' .$memberedgroups[$x]->org_description. '</div></div>';
										echo '</div>';
									}
									else {
										$ownedsameasmembered = false;
									}
								}
							}
					echo '</div>';
				}
			?>
		</div>
	</div>
</div>
<!-- End Body -->

<!-- Footer -->
<?php $this->load->view('template/footer.php'); ?>
<!-- End Footer -->
