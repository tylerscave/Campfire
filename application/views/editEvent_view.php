<!-- Header -->
<?php $this->load->view('template/header.php'); ?>
<!-- End Header -->

<!-- Body -->
<div class="container custom-body">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 well">
			<?php $attributes = array("name" => "editeventform");
			echo form_open_multipart("editEvent/index", $attributes);?>
			<legend>Edit Event</legend>
			<?php echo $this->session->flashdata('msg'); ?>
			<div class="form-event">
				<label for="eventName">Event Name</label>
				<input class="form-control" name="eventName" id="eventName"placeholder="Event Name" type="text" value="<?php echo set_value('eventName', $oldEventData['event_title']); ?>" />
				<span class="text-danger"><?php echo form_error('eventName'); ?></span>
			</div>
			<div class="form-event">
				<label for="name">Event Zip Code</label>
				<input class="form-control" name="zip" id="eventZip" placeholder="Event Zip Code" type="text" value="<?php echo set_value('zip', $oldEventData['zipcode']); ?>" />
				<span class="text-danger"><?php echo form_error('zip'); ?></span>
			</div>
			<div class="form-event">
				<label for="tag">Choose Tag</label>
				<select class="form-control" name="tag" id="eventTag">
					<?php
					foreach($tag_list as $row) {
						echo '<option>'.$row.'</option>';
					}
					?>
				</select>
			</div>
			<div class="form-event">
				<label for="description">Event Description</label>
				<textarea class="form-control" rows="5" name="description" id="eventDescription" value="<?php echo set_value('description'); ?>"><?php echo (isset($oldEventData['event_description']) ? $oldEventData['event_description'] : ''); ?></textarea>
				<span class="text-danger"><?php echo form_error('description'); ?></span>
			</div>
			<div class="form-event">
				<label for="imageUpload">Upload an Image</label>
				<input class="file" name="imageUpload" id="imageUpload" type="file" />
				<span class="text-danger"><?php echo form_error('imageUpload'); ?></span>
			</div>
			<div class="form-event">
				<button name="submit" id="bSubmit" type="submit" class="btn btn-info">Update</button>
				<button name="cancel" id="bCancel" type="button" class="btn btn-info" onclick="location.href='<?php echo base_url();?>index.php/home/index'">Cancel</button>
				<?php if(isset($oldEventData['event_id'])) : ?>
					<a href="<?php echo base_url();?>index.php/editEvent/deleteEvent/<?php echo $oldEventData['event_id'];?>"
						onclick="return confirm('Are you sure you want to delete the event: <?php echo $oldEventData['event_title'];?>?');">
						<button name="delete" id="bDelete" type="button" class="btn btn-danger">Delete Event</button>
				<?php endif; ?>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<!-- End Body -->

<!-- Footer -->
<?php $this->load->view('template/footer.php'); ?>
<!-- End Footer -->
