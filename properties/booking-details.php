<?php
session_start();
//use the configuration file  and file virables
function dateDiff($date1,$date2){

//change the date string to timestamps and  take the difference of the later and previous date
  $diff=strtotime($date2)-strtotime($date1);
  //1 day=24hours
  //24*60*60=86400  seconds

  return(abs(round($diff/(24*60*60))));

}
include("../controllers/config.php");
//use the db class and db connection functions
include("../controllers/classes/db-class.php");
$db=new db($h,$u,$pass,$db);

$conn=$db->connect();
if(!$conn){
  ?>
<div class="alert alert-warning">
  <h5 class="text-muted text-center">Cannot Access this Section</h5>
  <p class="text-center">Connection Failed</p>
</div>
  <?php
  die();
}
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
  if(isset($_GET["viewBookingId"])){
    $bookingDetailsSQL="SELECT *FROM  customers JOIN bookings JOIN rooms ON rooms.roomId=bookings.roomId  AND bookings.customerId =customers.customerId WHERE bookings.bookingId='$_GET[viewBookingId]' AND bookings.propertyId='$_SESSION[account_id]'";
    $bookingDetailsQuery=mysqli_query($conn,$bookingDetailsSQL);
    if($bookingDetailsQuery==true){
      $bookingDetailsQueryResults=mysqli_num_rows($bookingDetailsQuery);
      if($bookingDetailsQueryResults>0){

        $bookingDetailsQueryResultsArray=mysqli_fetch_array($bookingDetailsQuery);
        ?>
        <div class="" id="reservationDetils">


        <div class="card" >
          <div class="card-body" >

            <h5 class="text-center">Reservation Details</h5>
            <p class="h6">Room Id <span class="h5 text-primary"><?php echo$bookingDetailsQueryResultsArray['roomName'] ; ?></span></p>
            <p>  Booked @ <span><?php echo$bookingDetailsQueryResultsArray['reservationDate'] ; ?>  </span> </p>
            <p><span class="h6">Checki In</span> <?php echo$bookingDetailsQueryResultsArray['checkInDate'] ; ?> | <span class="h6">Check Out</span> <?php echo$bookingDetailsQueryResultsArray['checkOutDate'] ; ?> </p>

            <p><span class="h6">Adults</span> <?php echo$bookingDetailsQueryResultsArray['numberOfAdult'] ; ?> | <span class="h6">Children</span> <?php echo$bookingDetailsQueryResultsArray['numberOfChildren'] ; ?> </p>
    <p><span class="h6">Reservation Code</span> <?php echo$bookingDetailsQueryResultsArray['reservationCode'] ; ?>  </p>
    <p><span class="h6">Reservation Status</span> <span class=" alert text-<?php if($bookingDetailsQueryResultsArray['reservationStatus']=="Cancelled"){
      echo"danger";
    } else if($bookingDetailsQueryResultsArray['reservationStatus']=="Checked In"){
      echo"success";
    }
    else if($bookingDetailsQueryResultsArray['reservationStatus']=="Pending Confirmation"){
      echo"warning";
    }
    else if($bookingDetailsQueryResultsArray['reservationStatus']=="Checked Out"){
      echo"muted";
    }

    //Checked Out
    ?>"><?php echo$bookingDetailsQueryResultsArray['reservationStatus'] ; ?></span>   </p>
    <hr>
      <p class="h6">Guest Information</p>
      <p><span class="h6"> Name</span> <?php  echo$bookingDetailsQueryResultsArray['customerName'] ?>  <?php  echo$bookingDetailsQueryResultsArray['customerSurname'] ?> </p>
      <p> <span class="h6"> Country</span> <?php  echo$bookingDetailsQueryResultsArray['customerCountry'] ?>  </p>
      <p> <span class="h6"> Email</span> <?php  echo$bookingDetailsQueryResultsArray['customerEmail'] ?>  </p>
      <p> <span class="h6"> Phone</span> <?php  echo$bookingDetailsQueryResultsArray['customerPhone'] ?>  </p>
        <hr>
        <h4>Billing</h4>
        <p class="h6"> Rate K <?php echo $bookingDetailsQueryResultsArray['price'] ?>/Night</p>
        <p class="h6">Number of Nights <?php echo dateDiff($bookingDetailsQueryResultsArray['checkOutDate'],$bookingDetailsQueryResultsArray['checkInDate'])?></p>
        <hr>
        <p class="">COST <span class="h5">K<?php echo dateDiff($bookingDetailsQueryResultsArray['checkOutDate'],$bookingDetailsQueryResultsArray['checkInDate'])*$bookingDetailsQueryResultsArray['price']?></span> </p>
          </div>
        <?php if($bookingDetailsQueryResultsArray['reservationStatus']=="Checked Out"||$bookingDetailsQueryResultsArray['reservationStatus']=="Cancelled"){
          if($bookingDetailsQueryResultsArray['reservationStatus']=="Cancelled"&&$_SESSION['userType']==="admin"){
            //echo $_SESSION['userType'];
            ?>
            <div class="col-md-4">
              <button type="button" class="btn btn-primary btn-lg" id="deleteBookingBtn">Delete</button>
              <script type="text/javascript">
                $(document).ready(function(){
                  $("#deleteBookingBtn").on("click",()=>{
                    $.ajax({
                      url:"properties/bookings-take-action?deleteThis=<?php echo $bookingDetailsQueryResultsArray['bookingId']?>",
                      type:"GET",
                      beforeSend:function(){
                        $("#modal-content").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='public/images/loading.gif'></div><div class='col-md-4'></div></div>")
                        $("#modal").fadeIn("slow");
                      },
                      success:function(data){
                        $("#modal-content").html(data)
                      }
                    })
                  })
                })
              </script>
            </div>
              <?php
            }
            if($bookingDetailsQueryResultsArray['reservationStatus']=="Checked In"){
              ?>
              <div class="col-md-4">
                <button type="button" class="btn btn-primary btn-lg">Reschedule Stay</button>
              </div>
              <?php
            }
          ?>


          <?php

        }else{
          ?>
          <div class="card-footer">


                <div class="col-4 offset-4">
                  <button type="button" id="actionBooking" class="btn btn-primary">Take Acction</button>
                </div>
          </div>
          <script type="text/javascript">
            $(document).ready(()=>{
              $("#actionBooking").on("click",()=>{
                $.ajax({
                  url:"properties/bookings-take-action?actionThisBooking=<?php echo $bookingDetailsQueryResultsArray['bookingId']?>",
                  type:"GET",
                  beforeSend:function(){
                    $("#reservationDetils").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='public/images/loading.gif'></div><div class='col-md-4'></div></div>")
                  },
                  success:function(data){
                    setTimeout(()=>{
                      $("#reservationDetils").html(data)

                    },1500)
                  }
                })
              })
            })
          </script>
          <?php
        } ?>

        </div>
        </div>

        <?php
      }else{
        ?>
        <h5 class="text-muted text-center">This reservation is Not available</h5>
        <?php
      }
    }else{
      echo mysqli_error($conn);
    }
    die();
  }
    // if(isset($_GET['actionThisBooking'])){
    //   $thisReservationSql="SELECT *FROM bookings JOIN rooms ON rooms.roomId=bookings.roomId WHERE bookingId='$_GET[actionThisBooking]'";
    //   $thisReservationQuery=mysqli_query($conn,$thisReservationSql);
    //   if($thisReservationQuery==true){
    //     $thisReservationQueryResults=mysqli_num_rows($thisReservationQuery);
    //     if($thisReservationQueryResults>0){
    //       $thisReservationQueryResultsArray=mysqli_fetch_array($thisReservationQuery);
    //       ?>
    <!-- //       <div class="col-md-8 offset-2">
    //         <form class="" action="" method="post" id="bookingActionForm">
    //           <input type="hidden" name="actionBookingId" value="<?php echo $thisReservationQueryResultsArray['bookingId']?>">
    //           <input type="hidden" name="roomId" value="<?php echo $thisReservationQueryResultsArray['roomId']?>">
    //           <label for="">Comment</label>
    //           <textarea  class="form-control" name="actionComment" rows="6" cols="80"><?php echo$thisReservationQueryResultsArray['reservationComment']?>
    //           </textarea>
    //           <label for="">Update Status</label>
    //           <select class="form-control" name="reservationStatus">
    //             <option value="">Check</option>
    //             <option value="Checked In">Check In</option>
    //             <option value="Checked Out">Check Out</option>
    //             <option value="Cancelled">Cancel</option>
    //           </select>
    //           <hr>
    //           <div class="col-md-4 offset-4">
    //             <button type="submit" class="btn-primary btn-lg">Submit</button>
    //           </div>
    //         </form>
    //       </div>
    //       <script type="text/javascript">
    //         $(document).ready(function(){
    //           $("#bookingActionForm").on("submit",function(e){
    //             e.preventDefault();
    //             //alert("Actioning the Reservation")
    //             $.ajax({
    //               url:"properties/booking-details",
    //               type:"POST",
    //               data:new FormData(this),
    //       				contentType:false,
    //       				cache:false,
    //       				processData:false,
    //               beforeSend:function(){
    //                 $("#modal-content").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='public/images/loading.gif'></div><div class='col-md-4'></div></div>")
    //                 $("#modal").fadeIn("slow");
    //               },
    //               success:function(data){
    //                 var JSONdata=JSON.parse(data);
    //                 if(JSONdata.respose_type=="success"){
    //                   setTimeout(()=>{
    //                       $("#modal-content").html(`<span class='alert alert-success col-md-8 offset-2 text-center'>${JSONdata.respose_message}</span>`)
    //                   },1500)
    //                   setTimeout(()=>{
    //                       $("#modal-content").html("")
    //                       $("#modal").fadeOut("slow")
    //                   },2000)
    //                 }else{
    //                   setTimeout(()=>{
    //                     $("#modal-content").html(`<span class='alert alert-warning'>${JSONdata.respose_message}</span>`)
    //                   },1500)
    //                   setTimeout(()=>{
    //                       $("#modal-content").html("")
    //                       $("#modal").fadeOut("slow")
    //                   },2000)
    //                 }
    //
    //               }
    //             })
    //           })
    //         })
    //       </script> -->
    //       <?php
    //     }else{
    //       echo "This information Does Not Exist anymore";
    //     }
    //   }else{
    //     echo mysqli_error($conn);
    //   }
    //
    // }
    // code...
    break;
    // case 'POST':
    //   // code...
    //   $respose=Array("respose_type"=>"","respose_message"=>"","respose_notes"=>"");
    //
    //   $conn=$db->connect();
    //   if(!$conn){
    //     $respose['respose_type']="error";
    //     $respose["respose_message"]="Cannot Process Your requests";
    //     $respose["respose_notes"]="Connection failed";
    //     echo(json_encode($response));
    //     die();
    //   }
    //   if(!isset($_SESSION["logedin"])){
    //     $respose['respose_type']="error";
    //     $respose["respose_message"]="Cannot Process Your requests";
    //     $respose["respose_notes"]="Please Login to Have access to This Section";
    //     echo(json_encode($response));
    //     // "Please Login to Have access to This Section";
    //     die();
    //   }
    //   if(!isset($_SESSION['account'])&&($_SESSION['account'])!=="advanced"&&$_SESSION['accountType']!=="propertyacc"){
    //     $respose['respose_type']="error";
    //     $respose["respose_message"]="Your are Not allowed to perform this action";
    //     $respose["respose_notes"]="Login to your property Accoun to have access to this section";
    //     echo(json_encode($response));
    //   	//echo "Login to your property Accoun to have access to this section";
    //   die();
    //   }
    //   if(isset($_POST["actionBookingId"])&&isset($_POST["actionComment"])&&isset($_POST["reservationStatus"])&&isset($_POST["roomId"])){
    //     include("../controllers/classes/room-class.php");
    //     $room=new Room();
    //
    //     $updateBookingSlq="UPDATE bookings SET reservationComment='$_POST[actionComment]', reservationStatus='$_POST[reservationStatus]' WHERE bookingId='$_POST[actionBookingId]'";
    //        $updateBookingQuery=mysqli_query($conn,$updateBookingSlq);
    //     if($updateBookingQuery===true){
    //       switch ($_POST["reservationStatus"]) {
    //         case 'Checked Out':
    //           // code...
    //           $room->setRoomId($_POST["roomId"]);
    //           $room->setavailabilityStatus("Available");
    //           $room->updateAvailablityStatus($conn);
    //           $respose['respose_type']="success";
    //           $respose["respose_message"]=$_POST['reservationStatus']." Successfully";
    //           $respose["respose_notes"]="An Email will be sent to Guest Email regarding this change";
    //           echo(json_encode($respose));
    //           break;
    //           case 'Cancelled':
    //             // code...
    //             $room->setRoomId($_POST["roomId"]);
    //             $room->setavailabilityStatus("Available");
    //             $room->updateAvailablityStatus($conn);
    //             $respose['respose_type']="success";
    //             $respose["respose_message"]=$_POST['reservationStatus']." Successfully";
    //             $respose["respose_notes"]="An Email will be sent to Guest Email regarding this change";
    //             echo(json_encode($respose));
    //             break;
    //
    //         default:
    //           // code...
    //
    //           $respose['respose_type']="success";
    //           $respose["respose_message"]=$_POST['reservationStatus']." Successfully";
    //           $respose["respose_notes"]="An Email will be sent to Guest Email regarding this change";
    //           echo(json_encode($respose));
    //           break;
    //       }
    //
    //     }else{
    //       $respose['respose_type']="error";
    //       $respose["respose_message"]="Error Updating Booking information";
    //       $respose["respose_notes"]="Try again Later ".mysqli_error($conn);
    //       echo(json_encode($respose));
    //     }
    //     die();
    //   }
      break;

  default:
    // code...
    break;
}
 ?>
