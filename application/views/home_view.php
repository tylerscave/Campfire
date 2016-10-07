<!-- Header -->
<?php $this->load->view('template/header.php'); ?>
<!-- End Header -->

<!-- Body -->
<div class="container">
  <input id="pac-input" class="controls" type="text" placeholder="City, State, or Zip">
  <div id="map"></div>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-6CzpsxPQPdiOV_3M0QhATgjyTqO7JQE&libraries=places&callback=initMap" async defer></script>
</div> <!-- /container -->

<!-- End Body -->

<!-- Footer -->
<?php $this->load->view('template/footer.php'); ?>
<!-- End Footer -->
