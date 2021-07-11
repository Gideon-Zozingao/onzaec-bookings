<?php
if(isset($_SESSION["logedin"])&&$_SESSION['userType']=="admin"&&$_SESSION['accountType']="propertyacc"){
?>

<section>
<h3>Property Management</h3>

    <nav  class=" nav-menu">
<ul>
<li><a href="?action=view&page=property-site-management&section=propertyInformation">Site Details</a></li>
<li><a href="?action=view&page=property-site-management&section=propertyInformation">Settings</a></li>
<li><a href="?action=view&page=property-site-management&section=Sitegallery">Site Galery</a></li>
</ul>
  </nav>
  <div  class="container-fluid">
<div  class="col-md-12">
  <?php
  if(isset($_REQUEST["section"])){
    switch ($_REQUEST["section"]) {
      case 'propertyInformation':
        include("property-site-details.php");
        break;
        case "Sitegallery":
        include("property-site-gallery.php");
          break;
      default:
        break;
    }
  }else{
    include("property-site-details.php");
  }
  ?>
</div>
</div>

</div>
</section>
<?php
}else{
    echo"Unknown  Error";
}

?>
