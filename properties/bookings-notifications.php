<?php
session_start();
//use the configuration file  and file virables
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
echo "You are not logged in";
die();
}

if(!isset($_SESSION['account'])&&($_SESSION['account'])!=="advanced"&&$_SESSION['accountType']!=="propertyacc"){
	echo "You are not logged";
die();
}

switch ($_SERVER['REQUEST_METHOD']) {
  case 'GET':
  if(isset($_GET['viewList'])){
    $sql="SELECT * FROM bookings  JOIN rooms on bookings.roomId=rooms.roomId WHERE bookings.propertyId='$_SESSION[account_id]' and reservationNoticeSeen='No'";
    $query=mysqli_query($conn,$sql);
    if($query==true){
    $queryResults=mysqli_num_rows($query);
    ?>
<div class="container">


    <?php
    if($queryResults>0){
      ?>

      <?php
      while($queryResultsArray=mysqli_fetch_array($query)){
        ?><div class="card">
<div class="card-body">


        <a href="#" class="notificationDetails" accessKey="<?php echo $queryResultsArray['bookingId']?>"> <?php echo$queryResultsArray['roomName'] ;?></a> @ <?php echo$queryResultsArray['reservationDate'] ;?>
      </div>
              </div>
        <hr>
        <?php
      }
      ?>

<script type="text/javascript">
  $(document).ready(function(){
    var notificationLinks=$(".notificationDetails");
    for( i=0;i<notificationLinks.length;i++){
      $(notificationLinks[i]).on("click",function(e){
        e.preventDefault();
        $.ajax({
          url:`properties/view.booking.notification.php?notifsBookingId=${this.accessKey}`,
          type:"GET",
          beforeSend:function(){
            $("#modal-content").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='public/images/loading.gif'></div><div class='col-md-4'></div></div>");
            $("#modal").fadeIn("slow");
          },
          success:function(data){
            setTimeout(()=>{
              //alert($(notificationLinks[i]).accessKey)
              $("#modal-content").html(data).fadeIn("slow")
              $(notificationLinks[i]).hide()
            },1000)
          }
        })
      })
    }
  })

</script>
</div>
      <?php
    }else{
      echo "O New Notification";
    }
  }else{
    echo mysqli_error($conn);
  }
  }else{

    $sql="SELECT * FROM bookings WHERE propertyId='$_SESSION[account_id]' and reservationNoticeSeen='No'";
    $query=mysqli_query($conn,$sql);
    if($query==true){
    $queryResuls=mysqli_num_rows($query);
    if($queryResuls>0){
      ?>
    <a href="account?action=view&page=booking.notification" id="bookingNotification"><?php echo $queryResuls ." New ";if($queryResuls===1){
      echo "Reservation";
    }else{
      echo "Reservations";
    } ?> </a>
    <script type="text/javascript">
      $(document).ready(()=>{
        $("#bookingNotification").on("click",(e)=>{
          e.preventDefault()
          //alert("Bokking Notification");
          $.ajax({
            url:"properties/bookings-notifications.php?viewList=true",
            type:"GET",
            beforeSend:function(){
              $("#viewBookings").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='public/images/loading.gif'></div><div class='col-md-4'></div></div>")
              //$("#modal").fadeIn("slow");
            },
            success:function(data){
              setTimeout(()=>{
                $("#viewBookings").html(data)
              },1500)

              setInterval(()=>{
                $("#bookingNotificationView").load("properties/bookings-notifications.php?viewList=true");
              },2000)

          }

          })
        })
      })
    </script>
      <?php

    }else{
      ?>
<p class="text-muted"> O Notifications</p>
      <?php
      ///echo "O Notifications";
    }
    }else{
      echo "Connection Failded!".mysqli_error($conn);
    }
  }
    // code...
    break;

  default:
    // code...
    break;
}
?>
