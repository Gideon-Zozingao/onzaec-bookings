<?php
if(empty($_SESSION["sqNumberOfAdult"])&&empty($_SESSION["sqNumberOfChildren"])){
echo "<p  class='text-warning text-center'>Include number  of  Children or  number Adults  in  your  Search</p>";
}else{
  if($_SESSION["sqDestination"]!=""&&$_SESSION["sqCheckoutdate"]!=""&&$_SESSION["sqCheckinDate"]!=""){

      include("controllers/config.php");
      include("controllers/classes/db-class.php");
      $db=new db($h,$u,$pass,$db);
      $conn=$db->connect();
      if(!$conn){
        ?>
        <div class="col-md-4 offset-4">
          <h5 class="text-muted text-center"> Unable to Show your Resuts now</h5>
          <p class="text-muted text-center">Contact the Administrator Now</p>
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
$getRecommendedResults="SELECT*FROM rooms JOIN properties on properties.propertyId=rooms.propertyId  WHERE  (availabilityStatus='Available' AND location = '$_SESSION[sqDestination]') AND (roomCapacity='$totalPeople' OR  numberOfBed='$totalPeople' ) ORDER BY price ASC LIMIT 1,3";

/*
AND publoicationStatus='Published'AND  location= '$_SESSION[sqDestination]'   AND roomCapacity='$totalPeople' OR  numberOfBed='$totalPeople'

*/
try {
$getRecommendedResultsQuery=$conn->query($getRecommendedResults);

  $getRecommendedResultsQuery->setFetchMode(PDO::FETCH_ASSOC);
  $countResult=$getRecommendedResultsQuery->rowCount();
  if($countResult>0){
    ?>
    <div class="" id="after-header">

    </div>
    <section class="modal-content" id="recomended-room">
      <div class="modal-header">
        <p class=" text-success">Recomended Rooms</p>
        <span class="close" id="close-recomended-rooms">&times;</span>
      </div>

      <div class="modal-body ">

    <?php //echo $countResult." Results available"; ?>

      <div class="row">
    <?php
    while($QueryResultsArray=$getRecommendedResultsQuery->fetch()){?>
      <div class="col-md-4 ">
          <div class="card room-card">
              <div class="card-body">
                  <h5><?php echo $QueryResultsArray["roomCategory"] ?> </h5>
                  <p>
                  <a href="../properties.php?Propertylink=<?php echo $QueryResultsArray["property_link"]?>" target="_blank"> <?php echo $QueryResultsArray["propertyName"] ?></a>
                     </p>
                  <img src="../public/gallery/images/<?php echo $QueryResultsArray["roomCoverPhoto"]?>" alt="" class="img-responsive img-fluid">
                  <p>  <span class="h4 text-warning"> K <?php echo $QueryResultsArray["price"] ?></span> /Night </p>
                  <hr>
                    <a href="#" class="btn btn-info  reservationButton" accessKey="<?php echo $QueryResultsArray['roomId']?>">Book Now</a> | <a href="#" class="roomdetailsLink text-primary text-right" accessKey="<?php  echo $QueryResultsArray['roomId']?>">More Details</a>
              </div>
          </div>
      </div>

      <?php

    }
    ?>
  </div>
  </section>
  <script type="text/javascript">
    $(function(){

      $("#recomended-room").css("border","1px solid #3CB371")
      $("#recomended-room").css("border-radius","5px")
      $("#recomended-room").css("width","99%")
      $("#close-recomended-rooms").on("click",()=>{
        $("#recomended-room").fadeOut("fast")
      })
      // setTimeout(()=>{
      //   ("#recomended-room").show()
      // },2000)
      let roomClass=$(".room-card");
      console.log(roomClass);
      for (let i = 0; i<roomClass.length; i++) {
        $(roomClass[i]).on("mouseover",()=>{

            $(roomClass[i]).toggleClass("form-card");
            $(roomClass[i]).css("border","1px solid #1E90FF")

        })

        $(roomClass[i]).on("mouseleave",()=>{
          $(roomClass[i]).toggleClass("form-card")
          $(roomClass[i]).css("border","")

        })
      }
    })
  </script>

    <?php
  }else{

  }
  ?>

  <?php

} catch (PDOException $e) {
  echo $e->getMessage();
}

?>

      <hr>

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
  $no_of_records_per_page = 4;

  //setting the sql page offset
  $offset = ($pageno-1) * $no_of_records_per_page;

  $total_pages_sql="SELECT *  FROM properties JOIN rooms on rooms.propertyId=properties.propertyId WHERE  (properties.location = '$_SESSION[sqDestination]' AND  rooms.availabilityStatus='Available' AND publoicationStatus='Published') AND (roomCapacity>=$totalPeople OR  numberOfBed>=$totalPeople)
  ";

  function totalRows($conn,$sql){
      $result=$conn->query($sql);
      $count = $result->rowCount();
      return $count;
  }

  $total_rows=totalRows($conn,$total_pages_sql);


  $total_pages = ceil($total_rows / $no_of_records_per_page);

      $AccomSearchQuery="SELECT*FROM properties JOIN rooms on rooms.propertyId=properties.propertyId WHERE  properties.location = '$_SESSION[sqDestination]' AND  availabilityStatus='Available' AND rooms.publoicationStatus='Published'
      GROUP BY propertyName ORDER BY rooms.price ASC LIMIT $offset,$no_of_records_per_page";
try {
  $query1=$conn->query($AccomSearchQuery);
  $query1->setFetchMode(PDO::FETCH_ASSOC);
  $countAccom=$query1->rowCount();
  if($countAccom>0){
    ?>
    <div class="container-fluid">
      <h4 class=" text-success">Accomodations at your Destination</h4>
      <?php
      while($rows=$query1->fetch()){
          ?>
          <section id="about" class="about section-bg">
            <div class="container" data-aos="fade-up">
              <div  class="row">
                <div class="col-lg-6" data-aos="zoom-out" data-aos-delay="100">
                  <h5 class="text-primary"><a href="../properties/<?php echo$rows['property_link']?>" target="_blank"> <?php echo $rows['propertyName']?></a> </h5>
                  <?php
                  $sql2="SELECT *FROM site_profile WHERE  propertyId='$rows[propertyId]'";
                  try {
                    $query2=$conn->query($sql2);

                    $Result2=$query2->fetch();
                    ?>
                    <img src="../public/gallery/images/<?php echo $Result2['propertyCoverPhoto'];?>" class="img-fluid" alt="" style="max-width:400px;">
                    <p class="font-italic text-left"><i class="bx bx-map"></i> <?php echo $Result2['propertyAddress']?></p>
                    <p class="font-italic"><i class="bx bx-envelope"></i> <?php echo $Result2['propertyEmail']?></p>
                    <p class="font-italic"><i class="bx bx-phone-call"></i> <?php echo $Result2['propertyPhone']?></p>
                    <?php
                  } catch (PDOException $e) {
                    echo $e->getMessage();
                  }
            ?>
            <p class="text-left"><?php echo $rows['property_description']?></p>
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0 content d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="100">
            <div  class="card room-card">
              <div  class="card-body">
                <h6 class="font-italic">
                  <?php echo $rows['roomCategory']?>
                </h6>
                <ul>
                  <li>
                    <div>
                      <img src="../public/gallery/images/<?php echo $rows['roomCoverPhoto']?>" alt="" class="img-responsive img-fluid">
                      <br>
                      <?php if($rows['facilitiesl']!=""){?>
                        <div class="container-fluid">
                          <h6 class="text-success">Features</h6>
                          <p  class="text-left"> <?php echo $rows['facilitiesl']?> </p>
                        </div>
                        <?php

                      }else{

                      } ?>

                      <br>
                      <div>
                        <p><span class="h3 text-warning">K <?php echo $rows['price']?></span>  <?php echo $rows['asset_rate_intervals']?> </p>
                      </div>
                      <div>
                        <hr>
                        <a href="Booknow?roomid=<?php echo $rows['roomId']?>" class="btn-lg btn-info  reservationButton" accessKey="<?php echo $rows['roomId']?>"> Book Now</a> | <a href="#" class="roomdetailsLink text-primary text-right" accessKey="<?php  echo $rows['roomId']?>">More Detials</a>
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
          </section>
    <hr>
          <?php
      }?>
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
    </div>
    <?php
  }else{
    ?>
    <section>
      <h4 class="text-center text-muted">No  accomodation  Listed for this Destination</h4>
    </section>
    
    <?php
  }

} catch (PDOException $e) {
}

    }
    }else{
      ?>
      <section class="container">
        <h5 class="text-muted text-center">Some iformation missing on your Search query</h5>
      </section>
      <?php

    }
}
?>
