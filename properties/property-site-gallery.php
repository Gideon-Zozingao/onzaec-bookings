<hr>
<?php
if(isset($_SESSION['logedin'])&&$_SESSION['account']==="advanced"&&$_SESSION['accountType']=="propertyacc"){?>
<div class="row">
  <div class="col-md-4">
<?php
$propCoverSql="SELECT propertyCoverPhoto FROM site_profile WHERE propertyId='$_SESSION[account_id]'";
  $propCoverQuery=mysqli_query($conn,$propCoverSql);
  if($propCoverQuery==true){
    $Result=mysqli_num_rows($propCoverQuery);
    $propCoverArray=mysqli_fetch_array($propCoverQuery);
    if(!$Result==0&&$propCoverArray['propertyCoverPhoto']!==""){
      ?>
      <h5>Cover Photo</h5>
      <img src="public/gallery/images/<?php echo $propCoverArray['propertyCoverPhoto']?>" alt="Cover  Photo"  class="img-responsive img-fluid">
      <a href="?action=view&page=property-site-management&section=Sitegallery&media=coverphoto">Edit Cover Photo</a>
      <a href="?action=view&page=property-site-management&section=Sitegallery&media=photos">View  Photos</a>
      <a href="?action=view&page=property-site-management&section=Sitegallery&media=videos">Videos</a>
      <?php
  }else{?>
      <img src="public/images/no-image.png" alt="Cover  Photo"  class="img-responsive img-fluid">
      <a href="?action=view&page=property-site-management&section=Sitegallery&media=coverphoto">Edit Cover Photo</a>
      <a href="?action=view&page=property-site-management&section=Sitegallery&media=photos">View  Photos</a>
      <a href="?action=view&page=property-site-management&section=Sitegallery&media=videos">Videos</a>
      <?php
    }
  }else{
    echo "<h5 class='text-muted'>Cannot Display Your Cover Photo. Due to Some Technical Faults</h5>";
  }
  ?>
  </div>
  <div class="col-md-8" id="media-section">
    <?php
if(isset($_REQUEST['media'])){
  switch ($_REQUEST['media']) {
  case 'photos':
    include("properties/photos.php");
  break;
  case 'videos':
      echo "<h5>Videos</h5>";
      echo "<hr>";
      echo "<p  class='text-warning alert alert-warning'>Video Functionalities  are Not available for this version</p>";
  break;
  case 'coverphoto':
  $propCoverSql="SELECT propertyCoverPhoto FROM site_profile WHERE propertyId='$_SESSION[account_id]'";
    $propCoverQuery=mysqli_query($conn,$propCoverSql);
    if($propCoverQuery==true){
      $Result=mysqli_num_rows($propCoverQuery);
      $propCoverArray=mysqli_fetch_array($propCoverQuery);
      if(!$Result==0&&$propCoverArray['propertyCoverPhoto']!==""){
        ?>
        <h5>Cover Photo</h5>
        <img src="public/gallery/images/<?php echo $propCoverArray['propertyCoverPhoto']?>" alt="Cover  Photo"  class="img-responsive img-fluid">
        <hr>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <form class="" action="" method="post"  enctype="multipart/form-data">
                  <h3>Update  Cover Phto</h3>
                  <div class="form-group">
                    <input type="file" name="coverPhot" class="form-control">
                  </div>
                  <input type="hidden" name="updateCoverPhoto" value="true">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-4">
                      </div>
                      <div class="col-md-4">
                        <button type="submit" class="btn-primary">Upload</button>
                      </div>
                      <div class="col-md-4">
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <?php
    }else{?>
        <img src="public/images/no-image.png" alt="Cover  Photo"  class="img-responsive img-fluid">
        <?php
      }
    }else{
      echo "Cannot Display Your Cover Photo. Due to Some Technical Faults";
    }
  break;
  }
}else{
  include("properties/photos.php");
}?>
</div>
  <?php
}else{
      echo"<h1>This Section is Not Available</h1>";
}
?>
