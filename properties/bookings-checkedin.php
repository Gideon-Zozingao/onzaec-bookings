
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
if(isset($_SESSION["logedin"])){

if(!isset($_SESSION['account'])&&($_SESSION['account'])!=="advanced"&&$_SESSION['accountType']!=="propertyacc"){
	echo "Login to your property Accoun to have access to this section";
die();
}
//echo "All Active Bookings";
//echo $_SESSION['account_id']." ".$_SESSION['accountType'];
$allActiveBookingsSql="SELECT *FROM bookings JOIN rooms ON bookings.roomId=rooms.roomId WHERE bookings.propertyId='$_SESSION[account_id]' AND bookings.reservationStatus='Checked In'";
$allActiveBookingQUery=mysqli_query($conn,$allActiveBookingsSql);
if($allActiveBookingQUery==true){
$allActiveBookingQUeryResults=mysqli_num_rows($allActiveBookingQUery);
if($allActiveBookingQUeryResults>0){
  ?>
<table class="table table-fluid  table-striped">
<thead>
  <?php echo $allActiveBookingQUeryResults." Checkedin Bookings";?>
</thead>
<tr>
  <th>Room</th>
  <th>Reservation Code</th>
  <th>Reservation date</th>
  <th>Checkin </th>
  <th>Checkin</th>
  <th>Status</th>
  <th>Bill</th>
</tr>

  <?php
while($allActiveBookingQUeryResultsArray=mysqli_fetch_array($allActiveBookingQUery)){
  ?>

<tr>
  <td><?php echo $allActiveBookingQUeryResultsArray['roomName'];?></td>
  <td>
        <a href="#" class="reservationDetailsLink" accessKey="<?php echo $allActiveBookingQUeryResultsArray['bookingId'];?>"> <?php echo $allActiveBookingQUeryResultsArray['reservationCode'];?></a></td>
  <td><?php echo $allActiveBookingQUeryResultsArray['reservationDate'];?></td>
  <td><?php echo $allActiveBookingQUeryResultsArray['checkInDate'];?></td>
  <td><?php echo $allActiveBookingQUeryResultsArray['checkOutDate'];?></td>
  <td><?php
if($allActiveBookingQUeryResultsArray['reservationStatus']=="Checked In"){
  ?>
<span class="text-success"><?php echo $allActiveBookingQUeryResultsArray['reservationStatus'];?></span>
  <?php
}else{
  ?>
<span class="text-warning"><?php echo $allActiveBookingQUeryResultsArray['reservationStatus'];?></span>

  <?php
}
  ?></td>
  <td> K <?php echo $allActiveBookingQUeryResultsArray['reservationBill'];?></td>
</tr>
  <?php

}
?>

</table>
<script type="text/javascript">
  //class="reservationDetailsLink"
  $(document).ready(function(){
    var reservationDetailsLink=$(".reservationDetailsLink");
    for(i=0;i<reservationDetailsLink.length;i++){
      $(reservationDetailsLink[i]).on("click",function(e){
        e.preventDefault();
        $.ajax({
          url:`properties/booking-details?viewBookingId=${this.accessKey}`,
          type:"GET",
          beforeSend:function(){
            $("#modal-content").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='public/images/loading.gif'></div><div class='col-md-4'></div></div>");
            $("#modal").fadeIn("slow")
          },
          success:function(data){
            setTimeout(()=>{
              $("#modal-content").html(data)
            },1500)
          }
        })
        //alert(`Viewing ${this.accessKey}`)
      })
    }
  })
</script>
<?php
}else{
  echo $allActiveBookingQUeryResults." Active Bookings";
}
}else{
  echo mysqli_error($conn);
}
}
else{
echo "Please Login to access this Section";
}
?>
