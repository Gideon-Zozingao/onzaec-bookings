<?php
include("../controllers/config.php");
include("../controllers/classes/db-class.php");
$dbobj=new db($h,$u,$pass,$db);
$conn=$dbobj->connect();
if(!$conn){
  echo("Connetion Not Established");
  die();
}
switch ($_SERVER['REQUEST_METHOD']) {
  case 'GET':

  if(isset( $_GET["roomDetailsLink"])&&$_GET["roomDetailsLink"]=="true"){

          $roomsql="SELECT*FROm rooms where roomId='$_GET[room]'";
          $roomquery=mysqli_query($conn,$roomsql);
          if($roomquery==true){
            $roomresult=mysqli_num_rows($roomquery);
            if($roomresult>0){
              $roomarray=mysqli_fetch_array($roomquery);
                ?>

                <!-- <img src="../public/gallery/images/<?php echo $roomarray["roomCoverPhoto"]?>" alt="<?php echo $roomarray['roomName']?>" class="img-responsive img-fluid">
                <hr> -->
                <div class="card">
                  <div class="card-body">
                    <p><b>Room ID</b>  <?php echo $roomarray['roomName']?> | <b>Room Type</b> <?php echo $roomarray['roomCategory']?>	</p>
                    <p> <b>Floor</b>   <?php echo $roomarray['FloorNumber']?></p>
                    <p> <b>Beds</b>   <?php echo $roomarray['numberOfBed']?></p>
                    <p> <b>Bed Sizes</b>   <?php echo $roomarray['bedSize']?> cm <sup>2</sup>  </p>
                    <p> <b>Amenities</b> <br> <i><?php if($roomarray['facilitiesl']==""){
                      echo "Facilities  not Available ";
                    }else{
                       echo $roomarray['facilitiesl'];
                    } ?></i> </p>
                    <p> <b>Room Description</b> <br> <i><?php if($roomarray['roomDescription']==""){
                      echo "Description Not Available";
                    }else{
                      echo $roomarray['roomDescription'];
    }
                      ?>
                     </i> </p>
                     <p><?php if($roomarray['availabilityStatus']=="Available"){
                       echo "<span class='text-success'>".$roomarray["availabilityStatus"]." for Reservation now<span>";
                       ?>
                       <hr>
                       <button type="button" class="btn-primary btn-lg" id="reservationButton">Reserve a Space Now</button>
                       <script type="text/javascript">
                         $(document).ready(function(){
                           $("#reservationButton").on("click",function(){
                             $.ajax({
                               url:"../Booknow?roomid=<?php echo$roomarray['roomId']?>",
                               type:"GET",
                               beforeSend:function(){
                                 $("#modal").show();
                                 $("#modal-content").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='../public/images/loading.gif'></div><div class='col-md-4'></div></div>")
                               },
                               success:function(data){
                                 $("#modal-content").html(data);
                               }
                             })
                           })
                         })
                       </script>
                       <?php
                     }else{
                       echo "<span class='text-muted'>".$roomarray['availabilityStatus']."</span>";;
                     }?></p>

                  </div>

                </div>

                <?php
            }else{
              echo "The resource you are trying to access no longer exist";
            }
          }else{
            echo "Error Processing your equest ".mysqli_error($conn);
          }
  }
    if(isset($_GET['roomId'])){
      ?>

<a href="#" id="roomDetailsLink" class="btn btn-light">Room Information</a>  | <a href="#" id="roomPhotoLink" class="btn btn-light">Photos</a>
<hr>
<div class="" id="roomDetailsView">

</div>
  <script type="text/javascript">
    $(document).ready(()=>{
      //load the room information page when the document is ready and loaded
      $("#roomDetailsView").load(`../views/room-details.php?roomDetailsLink=true&room=<?php echo $_GET['roomId']?>`)

      $("#roomDetailsLink").on("click",(e)=>{
        e.preventDefault();

          $.ajax({
          url:`../views/room-details.php?roomDetailsLink=true&room=<?php echo $_GET['roomId']?>`,
          type:"GET",

          beforeSend:function(){
            $("#roomDetailsView").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='../public/images/loading.gif'></div><div class='col-md-4'></div></div>");
          },
          success:function(data){
            setTimeout(()=>{
                $("#roomDetailsView").html(data);
            },1500)

          }
        })
      })

      //roomDetailsView

      $("#roomPhotoLink").on("click",(e)=>{
        e.preventDefault();


        $.ajax({
        url:`../views/room-photos.php?roomPhotosLink=true&room=<?php echo $_GET['roomId']?>`,
        type:"GET",

        beforeSend:function(){
          $("#roomDetailsView").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='../public/images/loading.gif'></div><div class='col-md-4'></div></div>");
        },
        success:function(data){
          setTimeout(()=>{
              $("#roomDetailsView").html(data);
          },1500)

        }
        })

      })
    })
  </script>
      <?php

    }

    break;
    case 'POST':

      break;
  default:
    echo "Wrong Request method";
    break;
}

 ?>
