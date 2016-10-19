<!-- Header -->
<?php $this->load->view('template/header.php'); ?>
<!-- End Header -->

<!-- Body -->
	<div class="container custom-body" style="color: black">
	
		<div class="row">
			<div class="col-md-8 col-md-offset-2 well">
				<div class="row">
					<div class="col-md-2">
				      	<img height="42" width="42" src="..." alt="...">
			 	 	</div>
					<div class=" col-md-8 panel panel-default">
						<div class="panel-body"><?php echo $org_title;?></div>
						<table class="table">
							<tr>
								<td><?php echo $user_fname.' '.$user_lname;?></td>
								<td><?php echo $user_email?></td>
							</tr>
						</table>
					</div>
					<div class=" col-md-2 ">
					<?php 
						if (false) {
							echo '<button class="btn btn-info" name="Join">Join</button>';
						} else {
							echo '<button class="btn btn-info" name="leave">Leave</button>';
						}
						?>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading"><h5 class="panel-title">Description</h5></div>
					<div class="panel-body">
						<?php echo $org_description;?>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="row">
							<div class="col-md-10 col-md-offset-1"><h5 class="panel-title">Members</h5></div>
							<div class="col-md-1">
								<button  type="button" class="btn btn-default">
							  		<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
								</button>
							</div>
						</div>
					</div>
						<table class="table" id="member-table">

						</table>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading"><h5 class="panel-title">Bulletin Board</h5></div>
					<div class="panel-body">
						Here are all messages for the group
						<table class="table">
						</table>
					</div>
				</div>

			</div>
		</div>
	</div>

<!-- End Body -->

<!-- Footer -->
<?php $this->load->view('template/footer.php'); ?>
<!-- End Footer -->
