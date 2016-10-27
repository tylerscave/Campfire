<!-- Header -->
<?php $this->load->view('template/header.php'); ?>
<!-- End Header -->

<!-- Body -->
	<div class="container custom-body" style="color: black">
	
		<div class="row">
			<div class="col-md-8 col-md-offset-2 ">
				<div class="row">
					<div class="col-md-3">
				      	<img height="200" width="200" src="<?php echo base_url().'uploads/'.$info['org_picture']?>" alt="...">
				  	</div>
			  		<div class="col-md-9">
						<div class="row">
							<div class=" col-md-12 panel panel-default">
								<div class="panel-body"><?php echo $info['org_title'];?>
								<?php 
								if ($status == 'owner') {
									echo '<a class="btn btn-info pull-right" id="editGroupButton" href="'.base_url().'index.php/EditGroup/index/'.$info['org_id'].'">Edit Group</a>';
								} else if ($status == 'member') {
									echo '<a class="btn btn-info pull-right" id="leaveGroupButton" href="'.base_url().'index.php/Group/leave_group/'.$info['org_id'].'">Leave</a>';
								} else {
									echo '<a class="btn btn-info pull-right" id="joinGroupButton" href="'.base_url().'index.php/Group/join_group/'.$info['org_id'].'">Join</a>';
								}
								?></div>
								<table class="table">
									<tr>
										<td><?php echo $info['user_fname'].' '.$info['user_lname'];?></td>
										<td><?php echo $info['user_email']?></td>
									</tr>
								</table>
							</div>
						</div>
						<div class="row" style="padding: 1em 0em">
							<div class="panel panel-default">
								<div class="panel-heading">
									<div class="row">
										<div class="col-md-10 col-md-offset-1"><h5 class="panel-title">Members</h5></div>
										<div class="col-md-1">
											<button  type="button" class="btn btn-default" data-toggle="collapse" data-target="#member-table">
										  		<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
											</button>
										</div>
									</div>
								</div>
								<div class="pre-scrollable collapse" id="member-table">
									<table class="table">
										<?php 
											foreach ($members as $row) {
												echo '<tr><td>'.$row['user_fname'].' '.substr($row['user_lname'], 0,1).'.</td><tr>';
											}
										?>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="panel panel-default">
						<div class="panel-heading"><h5 class="panel-title">Description</h5></div>
						<div class="panel-body">
							<?php echo $info['org_description'];?>
						</div>
					</div>
				</div>
				<div class="row">
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
	</div>

<!-- End Body -->

<!-- Footer -->
<?php $this->load->view('template/footer.php'); ?>
<!-- End Footer -->

<script>
function toggler(divId) {
    $("#" + divId).toggle();
}
</script>
