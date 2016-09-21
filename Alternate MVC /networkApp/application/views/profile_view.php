<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="Tyler Jones"/>
	<meta name="description" content="Network Application Home Page"/>
	<title>Home Page | SE148</title>
	<!--link the bootstrap css file-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/css/bootstrap.css"); ?>">
</head>
<body>
	<nav class="navbar navbar-default" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php echo base_url(); ?>index.php/home">SE148 NETWORK APPLICATION</a>
			</div>
			<div class="collapse navbar-collapse" id="navbar1">
				<ul class="nav navbar-nav navbar-right">
					<?php if ($this->session->userdata('login')){ ?>
					<li><p class="navbar-text">Hello <?php echo $this->session->userdata('uname'); ?></p></li>
					<li><a href="<?php echo base_url(); ?>index.php/home/logout">Log Out</a></li>
					<?php } else { ?>
					<li><a href="<?php echo base_url(); ?>index.php/login">Login</a></li>
					<li><a href="<?php echo base_url(); ?>index.php/signup">Signup</a></li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</nav>
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<h4>Profile Summary</h4>
				<p><p/>
				<p>Thanks for Logging in!</p>
				<p>Name: <?php echo $uname; ?></p>
				<p>Email: <?php echo $uemail; ?></p>
				<hr/>
			</div>
			<div class="col-md-8">
				<h4>Purpose of this page</h4>
				<p><p/>
				<p>This page demonstrates that you have successfully logged in.</p>
				<p>Your credentials matched those stored in the database on the server.</p>
				<p>By logging in you know have a valid session ID for this session.</p>
				<hr/>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-1.10.2.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.js"); ?>"></script>
</body>
</html>
