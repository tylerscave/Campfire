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
				<h4>Notification</h4>
				<p>You are not logged in yet.</p>
			</div>
			<div class="col-md-8">
				<h2>Welcome To Tyler's Client/Server Web App!!!</h2>
				<p>The purpose of this web app is to learn how client/server interactions</br>
				take place at the application layer</p>
				<p>The front end was written in HTML and takes advantage of the Twitter's</br>
				bootstrap framework. The server side was programmed with PHP using the</br>
				CodeIgniter framework</p>
				<p>Please Signup and Login to begin interacting with the server and the</br>
				MySQL database!</p>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-1.10.2.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.js"); ?>"></script>
</body>
</html>
