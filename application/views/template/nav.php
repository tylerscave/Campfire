<!-- Fixed navbar -->
   <nav class="navbar navbar-inverse navbar-fixed-top">
     <div class="container">     
         
         <!--Transparent logo-->
         <div class="navbar-header">
         <img id="transparentLogo" src="<?php echo base_url("assets/img/logo_transparent.png");?>">
         </div>
         
       <div class="navbar-header">
         <a class="navbar-brand" href="<?php echo base_url(); ?>index.php/home">Campfire</a>
       </div>
       <div id="navbar" class="navbar-collapse collapse">
         <ul class="nav navbar-nav">
           <li <?php if(isActive("home")) echo "class='active'"; ?>><a href="<?php echo base_url(); ?>index.php/home">Home</a></li>
           <li <?php if(isActive("about")) echo "class='active'"; ?>><a href="<?php echo base_url(); ?>index.php/about">About</a></li>
         </ul>

         <ul class="nav navbar-nav navbar-right">
  			 <li <?php if(isActive("login")) echo "class='active' "; ?> id="login"><a href="<?php echo base_url(); ?>index.php/login">Log in</a></li>
  			 <li <?php if(isActive("signup")) echo "class='active' "; ?> id="signup"><a href="<?php echo base_url(); ?>index.php/signup">Signup</a></li>

        </ul>
       </div><!--/.nav-collapse -->
     </div>
   </nav>

<?php
//Find which page is currently on, then make it active on navbar
function isActive($arg) {
  //$ci is used instead of $this because of "Using $this when not in object context" error
  $ci =& get_instance();
  if($arg === $ci->uri->segment(1))
    return true;

  return false;
}
?>
