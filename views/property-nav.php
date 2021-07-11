<?php
if(isset($_SESSION['logedin'])&&$_SESSION['logedin']==true){
  if($_SESSION['userType']==="admin"){
    ?>
<nav class="navbar navbar-expand-md navbar-light bg-dark  fixed-top">
    <a href="#" class="navbar-brand btn btn-info btn-lg" id="sidebarCollapse">
        <i class="fas fa-cog"></i>
        <span>Management</span>
    </a>
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div id="navbarCollapse" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
            <li class="nav-item">
                <a href="../" class="nav-link text-white">Home</a>
            </li>
            <li class="nav-item">
              <a href='?action=view&page=rooms' class='nav-link text-white'>Rooms</a></li>
              <li><a href='?action=view&page=reservations' class='nav-link text-white'> Reservations</a>
            </li>
            <li><a href='?action=view&page=services' class='nav-link text-white'>Services</a> </li>
        </ul>
        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle text-primary" data-toggle="dropdown"> <span class="fas fa-user"></span> <?php echo $_SESSION["name"] ." ".$_SESSION["surname"]?></a>
                <div class="dropdown-menu dropdown-menu-right bg-dark">
                    <a href='account.signout' class='dropdown-item' id='signin'>Leave this Account</a>

                    <div class="dropdown-divider"></div>
                    <a href='../logout' class='dropdown-item' id='signin'>Signout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>

    <?php

  }else{
echo "string";
}}else{
  echo "string";
}
 ?>
