<hr>
<?php
// $thisdb=new db($h,$u,$pass,$db);
// $conn=$thisdb->connect();
if(isset($_SESSION['logedin'])&&$_SESSION['account']==="advanced"&&$_SESSION['accountType']=="propertyacc"){

if(isset($_REQUEST["Newact"])){
  switch ($_REQUEST["Newact"]) {
    case 'UpdateSiteInfo':
    include("property.UpdateSiteInfo.php");
      break;
      case 'EditSiteInfo':
      include("editSiteInfo.php");
        break;

    default:
      // code...




      break;
  }
}else{
  $propProfileSql="SELECT*FROM site_profile WHERE propertyId='$_SESSION[account_id]'";
    $propProfileQuery=mysqli_query($conn,$propProfileSql);
    if($propProfileQuery==true){
      $propProfileResult=mysqli_num_rows($propProfileQuery);
      if(!$propProfileResult==0){
      $propProfileInfoArray=mysqli_fetch_array($propProfileQuery);?>
      <div class="header-mini" style="background:url('public/gallery/images/<?php echo $propProfileInfoArray['propertyCoverPhoto']?>'); background-repeat:no-repeat; background-size:100%; height:500px;">
        <div class="header-content container">
          <h1 class="text-left"><?php echo $propProfileInfoArray['propertyHeading'] ?>  <a href="" class="h6">Edit</a> </h1>
          <p  class="text-left"><?php echo $propProfileInfoArray['site_profileSubheading'] ?> <a href="">Edit</a></p>
          <div class="">
        </div>
        </div>
        <hr>

      </div>
      <hr>
      <a href="?action=view&page=property-site-management&section=propertyInformation&Newact=EditSiteInfo" id="editSiteInfo">Update Information</a>
      <!-- <script type="text/javascript">
        $(document).ready(()=>{
          $("#editSiteInfo").click((e)=>{
            e.preventDefault();
            $.ajax({
              url:"./properties/editSiteInfo.php?Newact=EditSiteInfo",
              type:"GET",
              beforeSend:function(){
                $("#modal-content").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='../public/images/loading.gif'></div><div class='col-md-4'></div></div>")
                $("#modal").fadeIn("slow")
              },
              success:function(data){
                setTimeout(()=>{
                  $("#modal-content").html(data)
                },1500)

              },
              error:function(){
                $("#odal-content").html("Error")
              }

            })
          })
        })
      </script> -->
      <?php
    }else{
  if(isset($_REQUEST['Newact'])){
  include("property.UpdateSiteInfo.php");
  }else{?>
  <p class=" text-muted alert alert-warning"><span class="text-left">Site Information is not Up to date</span>   <span class="text-right"><a href="?action=view&page=property-site-management&section=propertyInformation&Newact=UpdateSiteInfo">Update Information Now</a> </span> </p>
    <table  class="table table-responsive">
      <tr>
        <td>Property Name</td>
        <td><?php echo $proprty["propertyName"];?></td>
      </tr>
      <tr>
        <td>Property Type</td>
        <td><?php echo $proprty["propertyType"];?></td>
      </tr>
      <tr>
        <td> Country</td>
        <td><?php echo $proprty["country"];?></td>
      </tr>
      <tr>
        <td> Location</td>
        <td><?php echo $proprty["location"];?></td>
      </tr>
      <tr>
        <td> Address</td>
        <td><?php echo $proprty["address"];?></td>
      </tr>
      <tr>
        <td>Email</td>
        <td><?php echo $proprty["owner_email"];?></td>
      </tr>
      <tr>
        <td>Phone</td>
        <td><?php echo $proprty["owner_phone"];?></td>
      </tr>
      <tr>
        <td> Description</td>
        <td><?php echo $proprty["property_description"];?></td>
      </tr>
      <tr>
        <td>Number of Rooms</td>
        <td><?php echo $proprty["number_of_assests"];?></td>
      </tr>
      <tr>
        <td>Minimum Room Rate</td>
        <td>K <?php echo $proprty["min_asset_rate"];?></td>
      </tr>
      <tr>
        <td>Maximum Room Rate</td>
        <td>K <?php echo $proprty["max_asset_rate"];?></td>
      </tr>
      <tr>
        <td>Rate Intervals</td>
        <td><?php echo $proprty["asset_rate_intervals"];?></td>
      </tr>
    </table>
    <?php
  }
      ?>
      <?php
    }
    }else{
      echo "Error:  ".mysqli_error($conn);
    }
}
}else{
  echo"<h1>This Section is Not Available</h1>";
}
?>
