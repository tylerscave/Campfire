<!-- Header -->
<?php $this->load->view('template/header.php'); ?>
<!-- End Header -->

<!-- Body -->
<div class="container custom-body">
	<div class="row">
		<!-- Intro -->
		<div class="col-md-4 col-md-offset-4">
			<h3>Gather ather around the warmth</h3></br>
		</div>
		<php? print_r("in createEvent") ?>
		<div class="col-md-4 col-md-offset-4 well">
			<?php $attributes = array("name" => "createeventform", "method" => "post");
			echo form_open_multipart("CreateEvent/index", $attributes);?>
			<!-- Title -->
			<legend>Create Event</legend>
			<hr/>
			<div class="form-group row">
				<div class="col-sm-6">
					<!-- <label for="eventTitle">Title</label> -->
					<input id="eventTitle" class="form-control" name="eventTitle" placeholder="Event Title" type="text" value="<?php echo set_value('eventTitle'); ?>" />
					<span id="eventTitle_error" class="text-danger"><?php echo form_error('eventTitle'); ?></span>
				</div>

				<!-- hosted by "username" -->
				<div class="col-sm-6">
					<label for="name"><h4> hosted by </label>
					<?php echo $uname; ?></h4>
				</div>	
			</div>
			<!-- address -->
<!-- 			<div class="form -group row">
 --><!-- 	 			<div class="col-sm-8 ">
 -->					<!-- <label>Address</label> -->
	<!-- 				 <div id="locationField">
   		 				<input id="autocomplete" placeholder="Enter your address"
           				  onFocus="geolocate()" type="text"></input>
					 </div>
					<input id="searchTextField" class ="form-control" name = "address" type="text" placeholder="Address" value="<?php //echo set_value('address'); ?>" />
					<span id="eventCity_error" class="text-danger"><?php //echo form_error('event address'); ?></span>
				</div>
			</div> -->
			<!-- <div class="form -group row "></div> -->

			<!--Street address  -->
			<div class="form -group row">
				<div class="col-sm-10 ">
					<input id="address1" class="form-control" name="address1" placeholder="Address" type="text" value="<?php echo set_value('address1'); ?>" />
					<span id="eventAddress1_error" class="text-danger"><?php echo form_error('address1'); ?></span>
				</div>
			</div>
			<div class="form -group row">
				<div class="col-sm-10 ">
					<input id="address2" class="form-control" name="address2" placeholder="Address 2" type="text" value="<?php echo set_value('address2'); ?>" />
					<span id="eventAddress2_error" class="text-danger"><?php echo form_error('address2'); ?></span>
				</div>
			</div>

			<!-- City, State, Zip -->
			<div class="form -group row">
				<div class="col-sm-5">
					<input id="eventCity" class="form-control" name="eventCity" placeholder="City" type="text" value="<?php echo set_value('eventCity'); ?>" />
					<span id="eventCity_error" class="text-danger"><?php echo form_error('eventCity'); ?></span>
				</div>
				<div class="col-sm-2">
				<!-- Drop down list to select from(inactive) -->
				<!-- 	<select id="eventState" class="form-control" name="eventState"><?php //echo StateDropdown('New Hampshire', 'name'); ?></select> -->
					<input id="eventState" class="form-control" name="eventState" placeholder="--" value="<?php echo set_value('eventState'); ?>" />
					<span id="eventState_error" class="text-danger"><?php echo form_error('eventState'); ?></span>	
				</div>
				<div class="col-sm-5">
					<input id="eventZip" class="form-control" name="eventZip" placeholder="Zip Code" type="text" value="<?php echo set_value('eventZip'); ?>" />
					<span id="eventZip_error" class="text-danger"><?php echo form_error('eventZip'); ?></span>
				</div>
			</div>
			<hr>

			<!--Event End Date  -->
			<div class="form -group row">
				<div class='col-sm-6'>
					<!-- <div class="form-group"> -->
						<div class='input-group date', id='startDate'> 
							<input type='datetime'  class="form-control" name='eventDTStart' placeholder = "Start Date" value="<?php echo set_value('eventDTStart'); ?>" />
							<span id="eventDTStart_error" class="text-danger"><?php echo form_error('eventDTStart'); ?></span>
						</span>
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				<!-- </div> -->
			</div>

			<!--Event Start Date  -->
			<div class='col-sm-6'>
				<div class="form-group">
					<div class='input-group date' id='endDate'>
						<input type='datetime' class="form-control" name='eventDTEnd' placeholder = "End Date" value="<?php echo set_value('eventDTEnd'); ?>" />
						<span id="eventDTEnd_error" class="text-danger"><?php echo form_error('eventDTEnd'); ?>
						</span>
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</div>
			</div>
		</div>

		<!-- Event Tags -->
		<div class="form -group row">
			<div class="col-sm-8 col-md-offset-2">
				<label for="tag">Event Tag</label>
				<select id="groupTag" class="form-control" name="tag">
					<?php
					foreach($tag_list as $row) {
						echo '<option>'.$row.'</option>';
					}
					?>
				</select>
			</div>

			<div class="form-group">
				<div class="col-sm-10 col-md-offset-1">
					<label for="eventDescription">Event Description:</label>
					<textarea class="form-control" rows="4" id="eventDescription" name="eventDescription"></textarea>
				</div>
			</div>
		</div>

		<div class="form-group row">
			<div class="col-sm-4 col-md-offset-2">
				<button id="bReset" type="reset" class="btn btn-info">Reset</button>
				<button id="bCancel" type="button" class="btn btn-danger" onclick="location.href='<?php echo base_url();?>index.php/home/index'">Cancel</button>
			</div>
			<div class="col-sm-4">
				<button id="bSubmit" type="submit" name="submit" action="controllers/CreateEvent/createEvent" class="btn btn-info">Create Event</button>
			</div>
		</div>
		<hr/>
		<div class="col-md-4 col-md-offset-4">
			<!-- <p>Thanks for Logging in!</p> -->
			<!-- <p>Name: <?php echo $uname; ?></p> -->
			<p>Email: <?php echo $uemail; ?></p>
		</div>	
		<?php echo form_close(); ?>
		<?php echo $this->session->flashdata('msg'); ?>
	</div>	
	<!-- </form> -->

</div>
</div>

<!-- Date Picker -->
<!-- 			<div class="form -group row">
			    <div class='col-sm-6'>
				<fieldset>
				  <input type="text" id="input_text"> 
	  			  <input type="text" id="input_text" onclick="datepicker()">

				  <input type="text" id="input_date">
				</fieldset>
				</div>
			</div> -->
<!-- 			<script type="text/javascript">
			    $(function () {
			        $('#startDate').datetimepicker();
			        $('#endDate').datetimepicker({
			            useCurrent: false //Important! See issue #1075
			        });
			        $("#startDate").on("dp.change", function (e) {
			            $('#endDate').data("DateTimePicker").minDate(e.date);
			        });
			        $("#endDate").on("dp.change", function (e) {
			            $('#startDate').data("DateTimePicker").maxDate(e.date);
			        });
			    });
			</script>				 -->

			<!-- blank timebar -->
<!-- 				<div class='col-sm-5'>
					<div class="row">
						<input type='text' name = 'datetime' class="form-control" id='datetimepicker' placeholder="Date/Time"/>
					</div>
					<script type="text/javascript">
						$(function () { $('#datetimepicker').datetimepicker();
						});
					</script>
				</div> -->

				<!-- Standard timebar that has issues -->
<!-- 			<form class="form-inline">
				<div class="col-sm-6">
					<label for="date">Date:</label>
					<input type="date" class="form-control" id="date" value = date("Y/m/d">
				</div>
				<div class="col-sm-6">
					<label for="time">time:</label>
					<input type="time" class="form-control" id="time">
				</div>
			</form>  -->

			<!-- Fancy datepickers script still does not work yet -->
			<!--  			<div class="form-group"> -->
			<!-- 				<div class="row"> -->
<!-- 				<div class='col-sm-6'>
				<div class='input-group date' id='datetimepicker'>
					<input type='text' class="form-control" placeholder="Event Date"/>
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
				<script type="text/javascript">
					$(function () {
						$('#datetimepicker').datetimepicker();
					});
				</script>
			</div> -->
<!-- 			</div>
-->


<!-- End Body -->

<!-- Footer -->
<?php $this->load->view('template/footer.php'); ?>
<!-- End Footer -->
