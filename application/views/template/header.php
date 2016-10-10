<!DOCTYPE html>
<html lang='en'>
<META NAME="Author" CONTENT="Peter Curtis, Tyler Jones, Troy Nguyen, Marshall Cargle, Luis Otero, Jorge Aguiniga, Stephen Piazza, Jatinder Verma">
<META NAME="Date" CONTENT="September 1, 2016">
<META NAME="Copyright" CONTENT="SJSU CMPE165 Fall 2016 Project. All rights reserved.">
<META NAME="Robots" CONTENT="all">
<META NAME="Keywords" CONTENT="">
<META NAME="Description" CONTENT="">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Home | Campfire</title>
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url("assets/img/favicon.ico"); ?>">
	<!--link local CSS files  :  note that javascript is linked at the bottom of page-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/css/bootstrap.css"); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/css/bootstrap-theme.css"); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/css/bootstrap-theme.min.css"); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/css/custom.css"); ?>">
	<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-1.10.2.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.min.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/js/bootbox.min.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/js/custom.js"); ?>"></script>
</head>
<body>

  <?php
  //Due to a flickering issue on page load, authenticated navbar and normal navbar would be stored in seprate files
  if( $this->session->userdata('login') ){
     $this->load->view('template/auth_nav.php');
  }
  else{
    $this->load->view('template/nav.php');
  }
   ?>
