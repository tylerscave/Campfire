<!-- Header -->
<?php $this->load->view('template/header.php'); ?>
<!-- End Header -->

<!-- Body -->
<div class="container custom-body">
<p> <?php echo print_r($oldGroupData); ?> </p>
	<div class="row">
		<div class="col-md-4 col-md-offset-4 well">
			<?php $attributes = array("name" => "editgroupform");
			echo form_open_multipart("editGroup/index", $attributes);?>
			<legend>Edit Group</legend>
			<div class="form-group">
				<label for="groupName">Group Name</label>
				<input class="form-control" name="groupName" id="groupName"placeholder="Group Name" type="text" value="<?php echo set_value('groupName', $oldGroupData['org_title']); ?>" />
				<span class="text-danger"><?php echo form_error('groupName'); ?></span>
			</div>
			<div class="form-group">
				<label for="name">Group Zip Code</label>
				<input class="form-control" name="zip" id="groupZip" placeholder="Group Zip Code" type="text" value="<?php echo set_value('zip', $oldGroupData['zipcode']); ?>" />
				<span class="text-danger"><?php echo form_error('zip'); ?></span>
			</div>
			<div class="form-group">
				<label for="tag">Choose Tag</label>
				<select class="form-control" name="tag" id="groupTag">
					<?php
					foreach($tag_list as $row) {
						echo '<option>'.$row.'</option>';
					}
					?>
				</select>
			</div>
			<div class="form-group">
				<label for="description">Group Description</label>
				<textarea class="form-control" rows="5" name="description" id="groupDescription" value="<?php echo set_value('description'); ?>"></textarea>
				<span class="text-danger"><?php echo form_error('description'); ?></span>
			</div>
			<div class="form-group">
				<label for="imageUpload">Upload an Image</label>
				<input class="file" name="imageUpload" id="imageUpload" type="file" />
				<span class="text-danger"><?php echo form_error('imageUpload'); ?></span>
			</div>
			<div class="form-group">
				<button name="submit" id="bSubmit" type="submit" class="btn btn-info">Update</button>
				<button name="cancel" id="bCancel" type="button" class="btn btn-info" onclick="location.href='../../home/index'">Cancel</button>
				<button name="delete" id="bDelete" type="button" value="delete" class="btn btn-danger pull-right" onclick="confirmGroupDelete()">Delete Group</button>
			</div>
			<?php echo form_close(); ?>
			<?php echo $this->session->flashdata('msg'); ?>
		</div>
	</div>
</div>
<!-- End Body -->

<!-- Footer -->
<?php $this->load->view('template/footer.php'); ?>
<!-- End Footer -->
