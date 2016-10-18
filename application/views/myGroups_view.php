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
			<div class="container">
				<div class="col-md-3">
					<?php
						$size = sizeof($memberedgroups);
						echo "<div>";
						for ($x = 0; $x < $size; $x++) {
							#echo '<div float: left;>';
							echo '<div float:left;>' .$memberedgroups[$x]->org_title;
							echo '</br>' .$memberedgroups[$x]->org_description. '</div>';
							#echo '</div>';
						}
						echo "</div>";
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
