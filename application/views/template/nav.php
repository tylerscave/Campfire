<nav id="topNav" class="navbar navbar-default navbar-fixed-top">
   <div class="container-fluid">
       <div class="navbar-header">
         <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar">
             <span class="sr-only">Toggle navigation</span>
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
         </button>
           <a id="bHome" class="navbar-brand page-scroll" href="http://teamcampfire.me/home"><p class="cursive">Campfire  <i class="ion-bonfire" id="custom-icon"></i></p></a>
       </div>
       <div class="navbar-collapse collapse" id="bs-navbar">
           <ul class="nav navbar-nav">
               <li>
                   <a class="page-scroll" href="<?php if(!isActive("home")) echo 'http://teamcampfire.me/home';?>#about">About</a>
               </li>
                 <li>
                     <a class="page-scroll" href="<?php if(!isActive("home")) echo 'http://teamcampfire.me/home';?>#contact">Contact</a>
                 </li>
                 <li class="dropdown" id="dropmenu-event">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            Event<span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                          <li <?php if(isActive("Event/search")) echo "class='active' "; ?>><a id = "searchEvents" href="http://teamcampfire.me/event/search">Search Event</a></li>
                        </ul>
                </li>
                <li class="dropdown" id="dropmenu-group">
                       <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                           Group<span class="caret"></span>
                       </a>
                       <ul class="dropdown-menu">
                           <li <?php if(isActive("Group/search")) echo "class='active' "; ?>><a id = "searchGroups" href="http://teamcampfire.me/group/search">Search Groups</a></li>
                       </ul>
               </li>
           </ul>
           <ul class="nav navbar-nav navbar-right">
             <li <?php if(isActive("login")) echo "class='active' "; ?> id="login"><a href="http://teamcampfire.me/login">Log in</a></li>
             <li <?php if(isActive("signup")) echo "class='active' "; ?> id="signup"><a href="http://teamcampfire.me/signup">Signup</a></li>
           </ul>
       </div>
   </div>
</nav>


<?php
//Find which page is currently on, then make it active on navbar
function isActive($arg) {
  //$ci is used instead of $this because of "Using $this when not in object context" error
  $ci =& get_instance();
  if($arg === $ci->uri->segment(1))
    return true;
  else if($arg===$ci->uri->segment(1).'/'.$ci->uri->segment(2))
       return true;


  return false;
}
?>
