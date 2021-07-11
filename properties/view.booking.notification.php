<?php

include("../controllers/config.php");

//use the db class and db connection functions
include("../controllers/classes/db-class.php");


$db=new db($h,$u,$pass,$db);
$conn=$db->connect();
if(!$conn){
  ?>
  <div class="alert alert-warning text-center">
<h5>Cannot view Notification Details</h5>
    <p>Connections failed</p>
  </div>
  <?php
  die();
}
//echo "string";
switch ($_SERVER["REQUEST_METHOD"]) {
  case 'GET':
if(isset($_GET["notifsBookingId"])){

  //  make a call to the database for  details of the booking made
  $bookingDetailSql="SELECT *FROM  bookings JOIN rooms ON rooms.roomId=bookings.roomId WHERE bookings.bookingId='$_GET[notifsBookingId]'";
  $bookingDetailQuery=mysqli_query($conn,$bookingDetailSql);
  if($bookingDetailQuery==true){
    $bookingDetailQueryReuslts=mysqli_num_rows($bookingDetailQuery);
    if($bookingDetailQueryReuslts>0){
      //store the query Resut in An array
      $bookingDetailQueryReusltsArray=mysqli_fetch_array($bookingDetailQuery);

      //call the database for cusdtomer information related  this booking
      $customerSql="SELECT *FROM customers WHERE customerId='$bookingDetailQueryReusltsArray[customerId]'";
      $customerQuery=mysqli_query($conn,$customerSql);
      if($customerQuery==true){
        $customerQueryResult=mysqli_num_rows($customerQuery);
        //chaeck if any customer data relate dto this Booking is Present
      if($customerQueryResult>0){
        //store the customer data in an Array
          $customerQueryResultArray=mysqli_fetch_array($customerQuery);
          ?>
          <div class="card">
      <div class="card-body">
        <p class="h5">New Reservation for room <span class=" text-primary "><?php echo $bookingDetailQueryReusltsArray['roomName']; ?></span> <span class="text-left text-muted"></span>  </p>
        <p><?php echo $bookingDetailQueryReusltsArray['reservationDate']; ?></p>
        <hr>
        <div class="row">
<div class="col-md-6">
  <h5>Guest Details</h5>
  <p><?php echo $customerQueryResultArray['customerName']?> <?php echo $customerQueryResultArray['customerSurname']?></p>
  <p><span class="h6">EMAIL</span> <?php echo $customerQueryResultArray['customerEmail']?> </p>
  <p><span class="h6">PHONE</span> <?php echo $customerQueryResultArray['customerPhone']?> </p>
  <p><span class="h6">COUNTRY</span> <?php echo $customerQueryResultArray['customerCountry']?> </p>
</div>
<div class="col-md-6">
  <h5>Reservation Details</h5>
  <p><span class="h6">CHECK IN </span> <u><?php echo $bookingDetailQueryReusltsArray['checkInDate']; ?></u>  <span class="h6"> CHECK OUT </span><u><?php echo $bookingDetailQueryReusltsArray['checkOutDate']; ?></u> </p>
  <p><span class="h6">ADULTS </span>  <?php echo $bookingDetailQueryReusltsArray['numberOfAdult']; ?><span class="h6"> CHILDREN </span><?php echo $bookingDetailQueryReusltsArray['numberOfChildren']; ?></p>
  <p><span class="h6">RESERVATION CODE</span> <u><?php echo $bookingDetailQueryReusltsArray['reservationCode']; ?></u> </p>

</div>
        </div>
      </div>
          </div>


          <?php

          //update the Notification Status
          $notifictionSeetSql="UPDATE bookings SET reservationNoticeSeen='Yes' WHERE bookingId='$_GET[notifsBookingId]'";
          $notifictionSeetQuery=mysqli_query($conn,$notifictionSeetSql);
          if($notifictionSeetQuery==true){
            echo "Notification View";
          }else{
            echo mysqli_error($conn);
          }

      }else{
          echo "Cusomer Data Not available";
      }
    }else{
          echo mysqli_error($customerQuery);

    }


    }else{
      ?>
<div class="text-muted text-center">
  <h5><?php  echo "Booking Information is Not Presetn at the Moment";?></h5>
</div>
      <?php

    }
  }else{
    echo mysqli_error($conn);
    die();
  }

  die();
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
