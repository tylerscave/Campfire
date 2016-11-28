<!-- Header -->
<?php $this->load->view('template/header.php'); ?>
<!-- End Header -->


<!-- Body -->
<header id="first">
    <div class="header-content">
        <div class="inner">
            <h1 class="cursive">Welcome to Campfire <img id="transparentLogo" src="<?php echo base_url("assets/img/ionicons_bonfire.png");?>"></h1>
            <h4>Connect with others by simply searching for events or groups</h4>
            <hr>
            <a id = 'search_events' href="<?php echo base_url(); ?>index.php/event/search" class="btn btn-primary btn-xl">Search Events</a> &nbsp;
            <a id = 'search_groups' href="<?php echo base_url(); ?>index.php/group/search" class="btn btn-primary btn-xl page-scroll">Search Groups</a>
        </div>
    </div>
    <video autoplay="" loop="" class="fillWidth fadeIn wow collapse in" data-wow-delay="0.5s" poster="<?php echo base_url("assets/img/Campfire.png"); ?>" id="video-background">
        <source src="<?php echo base_url("assets/video/Campfire.mp4"); ?>" type="video/mp4">Your browser does not support the video tag. I suggest you upgrade your browser.
    </video>
</header>

<section id="about">
<div class="container">
	<div class="row">
		<div class="col-md-4">
			<h4>Scrum Team</h4>
			<img src="<?php echo base_url("assets/img/devteam.JPG"); ?>" class="img-rounded"  width="304" height="236">
		</div>
		<div class="col-md-8">
			<h2>Welcome To Campfire!!!</h2>
			<p>
				Our team believes in bringing people together who have similar interests. </br>
				We also want those people to have an opportunity to get involved in </br>
				activities based on those similar interests. This is what we believe a </br>
				campfire is all about. Campfire allows anyone, whether you are a user or </br>
				not, to view events happening in your area. </br>
			</p>
			<h3>
				Registered User
			</h3>
			<p>
				1. Create and join any number of groups based on your interests </br>
				2. View any events in your area </br>
				3. View any events in an area you search by zipcode or city,state </br>
				4. Create events </br>
				5. Manage group-specific events </br>
			</p>
			<h3>
				Guest
			</h3>
			<p>
				1. View any events in your area </br>
				2. View any events in the area you search for by zip code or city, state </br>
				3. Create events </br>
			</p>
			<h3>
				Contact Us
			</h3>
			<p>
				Any questions? suggestions? Contact us at <a href = "http://www.gmail.com">teamcampfirellc@gmail.com</a>.
			</p>
		</div>
	</div>
</div>
</section>

<section id="contact" class="bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 text-center">
                <h2 class="margin-top-0 wow fadeIn">Get in Touch</h2>
                <hr class="primary">
                <p>We love feedback. Fill out the form below and we'll get back to you as soon as possible.</p>
            </div>
            <div class="col-lg-10 col-lg-offset-1 text-center">
                <?php
                $this->load->helper("form");

                echo validation_errors();

                echo form_open("/home/send_email");
                ?>

                <form method="post" action="/home/send_email" class="contact-form row">
                    <div class="col-md-6">
                        <label></label>
                        <input name="name" id="name" type="text" value="<?php echo set_value('name');?>" class="form-control custom-form-control" placeholder="Name">
                    </div>
                    <div class="col-md-6">
                        <label></label>
                        <input name="email" id="email" type="text" value="<?php echo set_value('email');?>" class="form-control custom-form-control" placeholder="Email">
                    </div>
                    <div class="col-md-12">
                        <label></label>
                        <textarea name="message" id="message" class="form-control custom-form-control" rows="9" placeholder="Your message here.."><?php echo set_value('message');?></textarea>
                    </div>
                    <div class="col-md-4 col-md-offset-4">
                        <label></label>
<!--                        <button type="button" data-toggle="modal" data-target="#alertModal" class="btn btn-primary btn-block btn-lg">Send <i class="ion-android-arrow-forward"></i></button>-->
                        <input type="submit" name="submit" value="Submit"/>
                    </div>
                </form>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</section>

<div id="galleryModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <img src="//placehold.it/1200x700/222?text=..." id="galleryImage" class="img-responsive" />
        <p>
            <br/>
            <button class="btn btn-primary btn-lg center-block" data-dismiss="modal" aria-hidden="true">Close <i class="ion-android-close"></i></button>
        </p>
      </div>
    </div>
    </div>
</div>
<div id="aboutModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <h2 class="text-center">Landing Zero Theme</h2>
        <h5 class="text-center">
            A free, responsive landing page theme built by BootstrapZero.
        </h5>
        <p class="text-justify">
            This is a single-page Bootstrap template with a sleek dark/grey color scheme, accent color and smooth scrolling.
            There are vertical content sections with subtle animations that are activated when scrolled into view using the jQuery WOW plugin. There is also a gallery with modals
            that work nicely to showcase your work portfolio. Other features include a contact form, email subscribe form, multi-column footer. Uses Questrial Google Font and Ionicons.
        </p>
        <p class="text-center"><a href="http://www.bootstrapzero.com">Download at BootstrapZero</a></p>
        <br/>
        <button class="btn btn-primary btn-lg center-block" data-dismiss="modal" aria-hidden="true"> OK </button>
      </div>
    </div>
    </div>
</div>
<div id="alertModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">
        <h2 class="text-center">Message Sent!</h2>
        <p class="text-center">Someone from the team will respond back soon.</p>

        <br/>
        <button class="btn btn-primary btn-lg center-block" data-dismiss="modal" aria-hidden="true">OK</i></button>
      </div>
    </div>
    </div>
</div>
<!-- End Body -->
<script>
$(".page-scroll").on("click", function(event) {
      var $ele = $(this);
      $('html, body').stop().animate({
          scrollTop: ($($ele.attr('href')).offset().top - 60)
      }, 1450, 'easeInOutExpo');
      event.preventDefault();
});
$('#topNav').affix({
    offset: {
        top: 200
    }
});

new WOW().init();

$('.navbar-collapse ul li a').click(function() {
    /* always close responsive nav after click */
    $('.navbar-toggle:visible').click();
});

$('#galleryModal').on('show.bs.modal', function (e) {
   $('#galleryImage').attr("src",$(e.relatedTarget).data("src"));
});
</script>

<!-- Footer -->
<?php $this->load->view('template/footer.php'); ?>
<!-- End Footer -->
