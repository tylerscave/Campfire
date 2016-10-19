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
						<div class="panel-body">Group Name</div>
						<table class="table">
							<tr>
								<td>Owner</td>
								<td>Contact Info</td>
							</tr>
						</table>
					</div>
					<div class=" col-md-2 ">
						<button class="btn btn-info" name="Join">Join</button>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading"><h5 class="panel-title">Description</h5></div>
					<div class="panel-body">
						Description of the group and its purpose
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
							<tr>
								<td>Member Name</td>
							</tr>
							<tr>
								<td>Member Name</td>
							</tr>
						</table>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading"><h5 class="panel-title">Bulletin Board</h5></div>
					<div class="panel-body">
						Here are all messages for the group
						<table class="table">
							<tr>
								<td>Message</td>
								<td>Message</td>
							</tr>
							<tr>
								<td>Message</td>
								<td>Message</td>
							</tr>
							<tr>
								<td>Message</td>
								<td>Message</td>
							</tr>
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
