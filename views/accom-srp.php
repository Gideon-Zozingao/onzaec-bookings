<?php
if(empty($_SESSION["sqNumberOfAdult"])&&empty($_SESSION["sqNumberOfChildren"])){
echo "<p  class='text-warning text-center'>Include number  of  Children or  number Adults  in  your  Search</p>";
}else{
  if(!empty($_SESSION["sqDestination"])&&!empty($_SESSION["sqCheckoutdate"])&&!empty($_SESSION["sqCheckinDate"])){
      include("controllers/config.php");
      include("controllers/classes/db-class.php");
      $db=new db($h,$u,$pass,$db);
      $conn=$db->connect();
      if(!$conn==true){
        ?>
        <div class="col-md-4 offset-4">
          <h5 class="text-muted text-center"> Unable to Show your Resuts now</h5>
          <p class="text-muted text-center">Conatact the Administrator Now</p>
        </div>
        <?php
        //echo("<h5>Cannot Display Your Results Now</h5>Trya again Later!");
        die();
    }else{
      //function to return digits instead of empty imputs;
      function returnNum($num){
        if($num==""){
          return 0;
        }else{
          return $num;
        }
      }
      $totalPeople=(int)$_SESSION['sqNumberOfAdult']+(int)$_SESSION['sqNumberOfChildren'];
      // display the reccomendation of the system here

      ?>
<?php
$getRecommendedResults="SELECT*FROM rooms JOIN properties on properties.propertyId=rooms.propertyId  WHERE (location= '$_SESSION[sqDestination]' AND  availabilityStatus='Available' AND publoicationStatus='Published' AND roomCapacity='$totalPeople' OR  numberOfBed='$totalPeople') ORDER BY price ASC LIMIT 3";

$getRecommendedResultsQuery=mysqli_query($conn,$getRecommendedResults);

if($getRecommendedResultsQuery==true){
  $QueryResults=mysqli_num_rows($getRecommendedResultsQuery);
if($QueryResults>0){
?>
<section class="bg-light" id="recomended-room">
    <span class="close" id="close-recomended-rooms">&times;</span>
  <div class="container ">
<h4 class="text-center text-success">Recomended Rooms</h4>
<hr>
  <div class="row">
<?php
while($QueryResultsArray=mysqli_fetch_array($getRecommendedResultsQuery)){
?>
<div class="col-md-4">
<div class="card">
<div class="card-body">
<h5><?php echo $QueryResultsArray["roomCategory"] ?> </h5>
<p>
<a href="../properties.php?Propertylink=<?php echo $QueryResultsArray["property_link"]?>" target="_blank"> <?php echo $QueryResultsArray["propertyName"] ?></a>
   </p>
<img src="../public/gallery/images/<?php echo $QueryResultsArray["roomCoverPhoto"]?>" alt="" class="img-responsive img-fluid">
<p>  <span class="h4 text-warning"> K <?php echo $QueryResultsArray["price"] ?></span> /Night </p>
<hr>
  <a href="#" class="btn btn-info btn-lg reservationButton" accessKey="<?php echo $QueryResultsArray['roomId']?>">Book Now</a> | <a href="#" class="roomdetailsLink text-primary text-right" accessKey="<?php  echo $QueryResultsArray['roomId']?>">More Details</a>
</div>
</div>
</div>
<?php
}

?>
</div>
</div>
      </section>
      <script type="text/javascript">
        $(function(){
          $("#recomended-room").css("border","1px solid #1E90FF")
          $("#recomended-room").css("border-radius","5px")
          $("#close-recomended-rooms").on("click",()=>{
            $("#recomended-room").fadeOut("fast")
          })
        })
      </script>
<?php
//echo $QueryResults."Recomende Rooms Available";
}else{
//echo "NO  recommended rooms available";
}

      }else{

}

?>

      <hr>
      <h3 class="text-center text-primary">Accomodations at your Destination</h3>
      <?php




      //check for pege number equest variabl
  if (isset($_GET["pageno"])) {

    //returve abnd store the requested page number if the page number is set
  $pageno=$_GET["pageno"];
  } else {
    //set the current page number to 1 if otherwise
  $pageno=1;

  }
  //decalring the number of reccords per and initializing to 5
  $no_of_records_per_page = 5;

  //setting the sql page offset
  $offset = ($pageno-1) * $no_of_records_per_page;
  $total_pages_sql="SELECT  *  FROM properties JOIN rooms on rooms.propertyId=properties.propertyId WHERE  properties.location = '$_SESSION[sqDestination]' AND  rooms.availabilityStatus='Available' AND publoicationStatus='Published' AND roomCapacity>=$totalPeople OR  numberOfBed>=$totalPeople
  GROUP BY propertyName";
  $result = mysqli_query($conn,$total_pages_sql);
  if(!$result){
    die("Errro Processinf your Page Request.".mysqli_error($conn));
  }
  $total_rows = mysqli_num_rows($result);
  $total_pages = ceil($total_rows / $no_of_records_per_page);
      $AccomSearchQuery="SELECT*FROM properties JOIN rooms on rooms.propertyId=properties.propertyId WHERE  properties.location = '$_SESSION[sqDestination]' AND  availabilityStatus='Available' AND rooms.publoicationStatus='Published'
      GROUP BY propertyName ORDER BY rooms.price ASC LIMIT $offset,$no_of_records_per_page ";
      $query1=mysqli_query($conn,$AccomSearchQuery);
    if($query1){
        $results=mysqli_num_rows($query1);
        if($results>0){
          while($rows=mysqli_fetch_array($query1)){
            ?>
            <section id="about" class="about section-bg">
              <div class="container" data-aos="fade-up">
                <div  class="row">
                  <div class="col-lg-6" data-aos="zoom-out" data-aos-delay="100">
                    <h3><a href="../properties/<?php echo$rows['property_link']?>" target="_blank"> <?php echo $rows['propertyName']?></a> </h3>
                    <?php
                    $sql2="SELECT *FROM site_profile WHERE  propertyId='$rows[propertyId]'";
                    $query2=mysqli_query($conn,$sql2);
                    $results_row2=mysqli_num_rows($query2);
                    if($results_row2>0){
                      $Result2=mysqli_fetch_array($query2);
                        ?>
                          <img src="../public/gallery/images/<?php echo $Result2['propertyCoverPhoto'];?>" class="img-fluid" alt="" style="max-width:400px;">
                          <p class="font-italic text-left"><i class="bx bx-map"></i> <?php echo $Result2['propertyAddress']?></p>
                          <p class="font-italic"><i class="bx bx-envelope"></i> <?php echo $Result2['propertyEmail']?></p>
                          <p class="font-italic"><i class="bx bx-phone-call"></i> <?php echo $Result2['propertyPhone']?></p>
                  <hr>
  <?php          }else{
              }
              ?>
              <p class="text-left"><?php echo $rows['property_description']?></p>
            </div>
            <div class="col-lg-6 pt-4 pt-lg-0 content d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="100">
              <div  class="card">
                <div  class="card-body">
                  <h3 class="font-italic">
                    <?php echo $rows['roomCategory']?>
                  </h3>
                  <ul>
                    <li>
                      <div>
                        <img src="../public/gallery/images/<?php echo $rows['roomCoverPhoto']?>" alt="" class="img-responsive" style="max-width:500px;">
                        <br>
                        <h5  class="text-left">Room ID: <?php echo $rows['roomName']?>|  Floor <?php echo $rows['FloorNumber']?> |Beds: <?php echo $rows['numberOfBed']?> | <a href="#" class="roomdetailsLink text-primary text-right" accessKey="<?php  echo $rows['roomId']?>">More Detials</a></h5>

                        <div>
                          <p><span class="h3 text-warning">K <?php echo $rows['price']?></span>  <?php echo $rows['asset_rate_intervals']?> </p>
                        </div>
                        <div>
                          <hr>
                          <a href="Booknow?roomid=<?php echo $rows['roomId']?>" class="btn btn-info btn-lg reservationButton" accessKey="<?php echo $rows['roomId']?>"> Book Now</a>
                        </div>
                      </div>
                    </li>
                    <li>
                  </ul>
              </div>
              </div>
            </div>
            </div>
            </div>
            <!-- <script type="text/javascript">
              $(document).ready(()=>{
                var reservationButton=$(".reservationButton");
                //alert(reservationButton);
                for(let i=0; i<reservationButton.length;i++){
                  $(reservationButton[i]).on("click",(e)=>{
                    e.preventDefault();
                    $.ajax({
                      url:`Booknow?roomid=${reservationButton[i].accessKey}`,
                      type:"GET",
                      beforeSend:()=>{
                        $("#modal").show();
                        $("#modal-content").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='public/images/loading.gif'></div><div class='col-md-4'></div></div>")
                      },
                      success:(data)=>{
                        setTimeout(()=>{
                        $("#modal-content").html(data);
                      },1500)

                      }

                    })
                  })
                }
              })
            </script> -->
            <!-- <script type="text/javascript">
              $(document).ready(function(){
                var roomdetailslink=$(".roomdetailsLink");
              //  console.log(roomdetailslink);
                for(let i=0; i<roomdetailslink.length;i++){
                  $(roomdetailslink[i]).on("click",function(e){
                    e.preventDefault();
                    $.ajax({
                      url:`views/room-details.php?roomId=${roomdetailslink[i].accessKey}`,
                      type:"GET",
                      beforeSend:function(){
                        $("#modal").fadeIn()
                        $("#modal-content").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='public/images/loading.gif'></div><div class='col-md-4'></div></div>");
                      },
                      success:function(data){
                        setTimeout(()=>{
                        $("#modal-content").html(data)
                      },1500)
                      }
                    })

                  })
                }
              })
            </script> -->
            </section>
            <hr>
          <!-- End About Section -->

            <?php
          }
  ?>
  <div class="container">
    <div class="row">
      <div class="col-md-4">
      </div>
      <div class="col-md-4">
        <div class="container">
          <ul class="pagination">
        <li><a class="btn <?php if($pageno==1){
          echo"btn-dark text-muted";
        }else{
          echo"btn-info ";
        }?>" href="<?php if($pageno==1){
          echo"#";
        }else{
          echo"?pageno=1";
        }?>">First</a></li>
        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a   href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>" class="btn btn-dark text-muted">Prev</a>
        </li>
        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a  class="btn <?php if($total_pages>1&&$pageno!=$total_pages){
              echo "btn-info";
            }else{
              echo "btn-dark text-muted";
            }?>  " href="?Destination=<?php echo$_SESSION['sqDestination']?><?php if($pageno >= $total_pages){ echo '#'; } else { echo "&pageno=".($pageno + 1); } ?>">Next</a>
        </li>
        <li><a class="btn btn-info " href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
        </ul>
        </div>
      </div>
      <div class="col-md-4">
      </div>
    </div>
  </div>
  <?php
  }else{?>
  <h5 class="text-muted text-center">
    No Accomodations availale for your Search..
  </h5>
    <?php
    }?>

        <?php
    }else{
      echo("Error while Processing Your Search Queries: ".mysqli_error($conn));
    }
    }
    }else{
      echo"<h5>Accomodation Search</h5>";
    }
}
?>
