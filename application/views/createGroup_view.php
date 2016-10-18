<!-- Header -->
<?php $this->load->view('template/header.php'); ?>
<!-- End Header -->

<!-- Body -->
<div class="container custom-body">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 well">
			<?php $attributes = array("name" => "creategroupform");
			echo form_open("createGroup/index", $attributes);?>
			<legend>Create Group</legend>
			<div class="form-group">
				<label for="groupName">Group Name</label>
				<input class="form-control" name="groupName" placeholder="Group Name" type="text" value="<?php echo set_value('groupName'); ?>" />
				<span class="text-danger"><?php echo form_error('groupName'); ?></span>
			</div>
			<div class="form-group">
				<label for="name">Group Zip Code</label>
				<input class="form-control" name="zip" placeholder="Group Zip Code" type="text" value="<?php echo set_value('zip'); ?>" />
				<span class="text-danger"><?php echo form_error('zip'); ?></span>
			</div>
			<div class="form-group">
				<label for="tag">Choose Tag</label>
				<select class="form-control" name="tag">
					<?php
					foreach($tag_list as $row) {
						echo '<option>'.$row.'</option>';
					}
					?>
				</select>
			</div>
			<div class="form-group">
				<label for="description">Group Description</label>
				<textarea class="form-control" rows="5" name="description" value="<?php echo set_value('description'); ?>"></textarea>
				<span class="text-danger"><?php echo form_error('description'); ?></span>
			</div>
			<div class="form-group">
				<label for="imageUpload">Upload an Image</label>
				<?php echo form_open_multipart('upload/do_upload');?>
				<input class="file" name="imageUpload" type="file" data-buttonText="Upload Image" />
				<span class="text-danger"><?php if (isset($error)) { echo $error; } ?></span>
			</div>
			<div class="form-group">
				<button name="submit" type="submit" class="btn btn-info">Create Group</button>
				<button type="button" class="btn btn-info" onclick="location.href='../home/index'">Cancel</button>
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
