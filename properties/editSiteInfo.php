<?php
if(!isset($_SESSION["logedin"])){
  echo "Please Login to Have access to This Section";
  die();
}
if(!isset($_SESSION['account'])&&($_SESSION['account'])!=="advanced"&&$_SESSION['accountType']!=="propertyacc"){
  echo "Login to your property Accoun to have access to this section";
die();
}
switch ($_SERVER["REQUEST_METHOD"]) {
  case 'GET':
    // code...if()

    if(isset($_GET["Newact"])){
      //Newact=EditSiteInfo
switch ($_GET["Newact"]) {
  case 'EditSiteInfo';

$sql="SELECT *FROM site_profile  JOIN properties  ON site_profile.propertyId=properties.propertyId WHERE properties.propertyId='$_SESSION[account_id]'";
$q=mysqli_query($conn,$sql);
if($q==true){
  $qResult=mysqli_num_rows($q);
  if($qResult>0){
$qResultArray=mysqli_fetch_array($q);
  ?>
  <div class="card">
    <div class="card-header bg-dark">
            <h5 class="text-center text-muted">	Edit Property Site Details</h5>
    </div>
      <div class="card-body">
<form class="" action="" method="post">
  <!-- first row -->
  <div class="row">
<div class="form-group col-md-6">
<label for="">Property Title</label>
  <input type="text" name="propertyTitle" value="<?php echo $qResultArray["propertyHeading"]?>" class="form-control">
</div>
<div class="form-group col-md-6">
  <label for="">Property Subtitle</label>
  <input type="text" name="" value="<?php echo $qResultArray["site_profileSubheading"]?>" class="form-control">
</div>
</div>
<!-- first row ends -->

<!-- second row -->
<div class="row">
<div class="form-group col-md-4">
  <label for="">Property Address</label>
  <input type="text" name="propertyAddress" value="<?php echo $qResultArray["propertyAddress"]?>" class="form-control">
</div>
<div class="form-group col-md-4">
  <label for="">Property Email</label>
  <input type="text" name="propertyEmail" value="<?php echo $qResultArray["propertyEmail"]?>" class="form-control">
</div>
<div class="form-group col-md-4">
  <label for="">Property Phone</label>
  <input type="text" name="propertyPhone" value="<?php echo $qResultArray["propertyPhone"]?>" class="form-control">
</div>
</div>
<div class="row">
  <div class="col-md-12 form-group">
    <label for="">Property Description</label>
  <textarea name="name" rows="8" cols="80" class="form-control"><?php
echo $qResultArray["property_description"];
  ?></textarea>
  </div>
</div>
<div class="row">
  <div class="col-md-12 form-group" >
    <label for="">  Make your Property Location Known</label>
  <div class="card">
    <div class="card-body" id="map" style="height:400px">
    </div>
  </div>
  <input type="hidden" name="mapCoords" value="" id="mapLngLat">
  </div>
</div>
<!-- second row end -->
</form>
      </div>
  </div>
  <script type="text/javascript">
  var marker;
  var mapLongLat=document.getElementById("mapLngLat");
  //var mapLat=document.getElementById("mapLat");
  function initMap() {
  const map = new google.maps.Map(document.getElementById("map"), {
  zoom: 15,
  center: { lat: -6.721764901537771, lng: 147.0024936391811 },
  });
  map.addListener("click", (e) => {

  mapLongLat.value=JSON.stringify(e.latLng);
  placeMarkerAndPanTo(e.latLng, map);
  });
  }


  function placeMarkerAndPanTo(latLng, map) {
      if (marker == null)
      {
          marker = new google.maps.Marker({
           position: latLng,
          map: map,
          });
      }
      else
      {
        marker.setPosition(latLng);
      }
  }
  </script>
  <?php
  }else{
    echo "Site Profile Information is Not Available";
  }
}else{
  echo "Error. ".mysqli_error($conn);
}


    ?>


    <?php
    break;

  default:
    // code...
    break;
}

    }

    break;
    case 'POST':
      // code...
      break;
  default:
    // code...
    break;
}
 ?>
