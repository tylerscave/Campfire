<!-- Header -->
<?php $this->load->view('template/header.php'); ?>
<!-- End Header -->

<!-- Body -->
<div class="container custom-body">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 well">
			<?php $attributes = array("name" => "createeventform");
			echo form_open_multipart("createEvent/index", $attributes);?>
			<legend>Create Event</legend>
			<div class="form-group row">
				<div class="col-sm-6">
					<label for="eventTitle">Title</label>
					<input id="eventTitle" class="form-control" name="eventTitle" placeholder="Event Title" type="text" value="<?php echo set_value('eventTitle'); ?>" />
					<span id="eventTitle_error" class="text-danger"><?php echo form_error('eventTitle'); ?></span>
				</div>
				<div class="col-sm-6">
					<label><h5> Hosted by </br>
					<?php echo $uname; ?></h5></label>
				</div>
			</div>
			<div class="form-group">
				<label for="address1">Street Address 1</label>
				<input id="address1" class="form-control" name="address1" placeholder="Street Address 1" type="text" value="<?php echo set_value('address1'); ?>" />
				<span id="address1_error" class="text-danger"><?php echo form_error('address1'); ?></span>
			</div>
			<div class="form-group">
				<label for="address2">Street Address 2</label>
				<input id="address2" class="form-control" name="address2" placeholder="Street Address 2" type="text" value="<?php echo set_value('address2'); ?>" />
				<span id="address2_error" class="text-danger"><?php echo form_error('address2'); ?></span>
			</div>
			<div class="form-group">
				<label for="zip">Event Zip Code</label>
				<input id="eventZip" class="form-control" name="zip" placeholder="Event Zip Code" type="text" value="<?php echo set_value('zip'); ?>" />
				<span id="groupZip_error" class="text-danger"><?php echo form_error('zip'); ?></span>
			</div>
			<div class="form-group row">
				<div class="col-sm-6">
					<div class="input-group date" id="startDate">
						<label for="startTime">Event Start</label>
						<input id="startTime" type="datetime" class="form-control" name="startTime" placeholder="Event Start" value="<?php echo set_value('startTime'); ?>" />
						<span id="startTime_error" class="text-danger"><?php echo form_error('startTime'); ?></span>
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="input-group date" id="endDate">
						<label for="endTime">Event End</label>
						<input id="endTime" type="datetime" class="form-control" name="endTime" placeholder="Event End" value="<?php echo set_value('endTime'); ?>" />
						<span id="endTime_error" class="text-danger"><?php echo form_error('endTime'); ?>
						</span>
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="tag">Choose Tag</label>
				<select id="eventTag" class="form-control" name="tag">
					<?php
					foreach($tag_list as $row) {
						echo '<option>'.$row.'</option>';
					}
					?>
				</select>
			</div>
			<div class="form-group">
				<label for="description">Event Description</label>
				<textarea id="eventDescription" class="form-control" rows="5" name="description" value="<?php echo set_value('description'); ?>"><?php echo (isset($description) ? $description : ''); ?></textarea>
				<span id="eventDescription_error" class="text-danger"><?php echo form_error('description'); ?></span>
			</div>
			<div class="form-group">
				<label for="imageUpload">Upload an Image</label>
				<input id="eventImage" class="file" name="imageUpload" type="file" />
				<span id="eventimage_error" class="text-danger"><?php echo form_error('imageUpload'); ?></span>
			</div>
			<div class="form-group">
				<button id="bSubmit" name="submit" type="submit" class="btn btn-info">Create Event</button>
				<button id="bCancel" type="button" class="btn btn-info" onclick="location.href='<?php echo base_url();?>index.php/home/index'">Cancel</button>
			</div>
			<?php echo form_close(); ?>
			<?php echo $this->session->flashdata('msg'); ?>
		</div>
	</div>
</div>
<!-- End Body -->
<script>
$(function () {
    $('#startDate').datetimepicker({
    startDate,
    format: 'mm/dd/yyyy h:i',
    minuteStep: 15,
    autoclose: true,
    });

    $('#endDate').datetimepicker({
    format: 'mm/dd/yyyy h:i',
    minuteStep: 15,
    autoclose: true
    });

    $("#startDate").on("dp.change",function (e) {
        $('#endDate').data("DateTimePicker").setMinDate(e.date);
    });
    $("#endDate").on("dp.change",function (e) {
        $('#startDate').data("DateTimePicker").setMaxDate(e.date);
    });
});
</script>
<!-- Footer -->
<?php $this->load->view('template/footer.php'); ?>
<!-- End Footer -->
