<!-- Header -->
<?php $this->load->view('template/header.php'); ?>
<!-- End Header -->
<!-- Body -->
<div class="container custom-body">
	<?php $attributes = array("class" => "form-inline global-search", "method" => "get");
				echo form_open("group/search", $attributes); ?>

		<div class="form-group">
				<input type="search" class="form-control" id="groupQuery" name="groupQuery" placeholder="Enter a city or zip">
		</div>
		<div class="form-group">
			<button type="submit" id="searchButton" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> </button>
		</div>

<br/>
	<?php echo form_close(); ?>
	    <div class="col-md-10 col-md-offset-1">
						<?php
							if(isset($groups)) {
								echo "<h3>".count($groups)." Group(s) Found:</h3>";
							}
							else{
								if($this->input->get('groupQuery')){
									echo "<h3>0 Groups Found</h3></div>";
								}
								else{
									if(isset($random)){
										echo "<h5>Here are some random groups:</h5>";
									}
								}
							} ?>
							<div class="col-md-1 well" style="min-height: 100px;">
								<div class="form-group">
								  <label for="select-tag">Filter:</label>
								  <select class="form-control" id="select-tag">
								    <option id="all-opt" data-filter="all">All</option>
								    <option id="movies-opt" data-filter="Movies">Movies</option>
								    <option id="education-opt" data-filter="Education">Education</option>
								    <option id="sports-opt" data-filter="Sports">Sports</option>
										<option id="food-opt" data-filter="Food">Food</option>
										<option id="coffe-opt" data-filter="Coffee">Coffee</option>
								  </select>
								</div>
							</div>
							<div class="col-md-10 well">
								<div class="card-group">
							<?php
								if(isset($groups)) {
										displayTiles($groups);
								}else{
										if(isset($random)){
											displayTiles($random);
										}
									}
									?>
							</div>
						</div>
	    </div>
</div>
<!-- End Body -->

<!-- Footer -->
<?php $this->load->view('template/footer.php'); ?>
<!-- End Footer -->

<?php

function displayTiles($groups){
	for ($x = 0; $x < count($groups); $x++) {
		echo "<div class='col-md-3 card filter ".$groups[$x]['tag_title']."'>";
		echo "<a id='".$groups[$x]['org_id']."' href='".base_url()."index.php/Group/display/".$groups[$x]['org_id']."'><img class='img-responsive' src='";
		echo base_url()."uploads/".$groups[$x]['org_picture']."' alt='".$groups[$x]['org_title']."'></a>";
		echo "<div class='card-block'>";
		echo"<h4 class='card-title' id='card-title'>".$groups[$x]['org_title']."</h4>";
		echo "<p class='card-text'>".$groups[$x]['org_description']."</p>
		<a class='btn btn-primary waves-effect waves-light' href='".base_url()."index.php/Group/display/".$groups[$x]['org_id']."'>See More</a>
		<p class='card-text'><small class='text-muted'>Last updated 3 mins ago</small></p></div></div>";
	}
}
?>

<script>
$(document).ready(function(){
	$('#select-tag').on('change', function() {
    var value = $(this).find(':selected');
		if(value.val() == "All")
		{
				$('.filter').show('1000');
		}
		else
		{
				$(".filter").not('.'+value.val()).hide('3000');
				$('.filter').filter('.'+value.val()).show('3000');
		}
	});

});
</script>
