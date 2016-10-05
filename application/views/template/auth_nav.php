<!-- Fixed navbar -->
   <nav class="navbar navbar-inverse navbar-fixed-top">
     <div class="container">
       <div class="navbar-header">
         <a class="navbar-brand" href="<?php echo base_url(); ?>index.php/home">Campfire</a>
       </div>
       <div id="navbar" class="navbar-collapse collapse">
         <ul class="nav navbar-nav">
           <li <?php if(isActive("home")) echo "class='active'"; ?>><a href="<?php echo base_url(); ?>index.php/home">Home</a></li>
           <li <?php if(isActive("about")) echo "class='active'"; ?>><a href="<?php echo base_url(); ?>index.php/about">About</a></li>
         </ul>

         <ul class="nav navbar-nav navbar-right">

         <li class="dropdown" id="dropmenu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <strong><?php echo $this->session->userdata('fname')." ".$this->session->userdata('lname'); ?> </strong><span></span><span class="glyphicon glyphicon-user"></span>
					          <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                  <li <?php if(isActive("editprofile")) echo "class='active' "; ?>><a href="<?php echo base_url(); ?>index.php/editprofile">Edit Profile</a></li>
                  <li <?php if(isActive("mygroups")) echo "class='active' "; ?>><a href="<?php echo base_url(); ?>index.php/mygroups">My Groups</a></li>
                  <li <?php if(isActive("myevents")) echo "class='active' "; ?>><a href="<?php echo base_url(); ?>index.php/myevents">My Events</a></li>
                  <li class="divider"></li>
                  <li><a href="<?php echo base_url(); ?>index.php/home/logout">Log Out</a></li>
                </ul>
        </li>

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
