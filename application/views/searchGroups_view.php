<!-- Header -->
<?php $this->load->view('template/header.php'); ?>
<!-- End Header -->
<!-- Body -->
<div class="container custom-body">
	<h2> Group Search  </h2>
	<?php $attributes = array("class" => "form-inline global-search", "method" => "get");
				echo form_open("group/search", $attributes); ?>

		<div class="form-group">
				<input type="search" class="form-control" id="zip" name="zip" placeholder="Enter a zip code">
		</div>
				<div class="form-group">
		<button type="submit" id="searchButton" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> </button>
	</div>
	<?php echo form_close(); ?>
	<section id="gallery" class="no-padding">
	    <div class="container-fluid">
	        <div class="row no-gutter">
						<?php
							if(isset($groups)) {
								foreach($groups as $group){
									echo "<div class='col-lg-3 col-md-4 col-sm-6 col-xs-12'> <div class='hovereffect'> <img class='img-responsive' src='";
									echo base_url()."uploads/".$group[0]->org_picture."'>";
									echo "<div class='overlay'><h2>".$group[0]->org_title."</h2>";
									echo "<a class='info' href='".base_url()."index.php/Group/display/".$group[0]->org_id."'>View more details</a>";
									echo "</div></div>".$group[0]->org_title."</div>";
								}
							} ?>
	        </div>
	    </div>
	</section>
</div>
<!-- End Body -->

<!-- Footer -->
<?php $this->load->view('template/footer.php'); ?>
<!-- End Footer -->
