<!-- Header -->
<?php $this->load->view('template/header.php'); ?>
<!-- End Header -->
<!-- Body -->
<div class="container custom-body">
	<?php $attributes = array("class" => "form-inline global-search", "method" => "get");
				echo form_open("group/search", $attributes); ?>

		<div class="form-group">
				<input type="search" class="form-control" id="zip" name="zip" placeholder="Enter a zip code">
		</div>
		<div class="form-group">
			<button type="submit" id="searchButton" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> </button>
		</div>

<br/>
	<?php echo form_close(); ?>
	    <div class="container">
				<div>
					<button class="btn btn-danger filter-button" data-filter="all">All</button>
					<button class="btn btn-default filter-button" data-filter="Movies">Movies</button>
					<button class="btn btn-default filter-button" data-filter="Education">Education</button>
					<button class="btn btn-default filter-button" data-filter="Sports">Sports</button>
					<button class="btn btn-default filter-button" data-filter="Food">Food</button>
					<button class="btn btn-default filter-button" data-filter="Coffee">Coffee</button>
				</div>
	        <div class="row no-gutter">
						<?php
							if(isset($groups)) {
								echo "<h1>".count($groups)." Group(s) Found:</h1>";
								displayTiles($groups);
							}
							else{
								if($this->input->get('zip')){
									echo "<h1>0 Groups Found</h1>";
								}
								else{
									if(isset($random)){
										echo "<h1>Here's some random groups:</h1>";
										displayTiles($random);
									}
								}
							} ?>
	        </div>
	    </div>
</div>
<!-- End Body -->

<!-- Footer -->
<?php $this->load->view('template/footer.php'); ?>
<!-- End Footer -->

<?php

function displayTiles($groups){
	foreach($groups as $group){
		echo "<div class='col-md-3 filter ".$group['tag_title']."'>";
		echo "<p class='org-title'>".$group['org_title']."</p>";
		echo "<a href='".base_url()."index.php/Group/display/".$group['org_id']."'>";
		echo "<img class='img-responsive center-cropped' src='";
		echo base_url()."uploads/".$group['org_picture']."' alt='".$group['org_title']."'></a></div>";
	}
}
?>

<script>
$(document).ready(function(){

    $(".filter-button").click(function(){
        var value = $(this).attr('data-filter');

        if(value == "all")
        {
            $('.filter').show('1000');
        }
        else
        {
            $(".filter").not('.'+value).hide('3000');
            $('.filter').filter('.'+value).show('3000');

        }
    });

});
</script>
