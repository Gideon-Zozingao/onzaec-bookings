<?php
session_start();
//use the configuration file  and file virables
include("controllers/config.php");

//use the db class and db connection functions
include("controllers/classes/db-class.php");

$db=new db($h,$u,$pass,$db);
//calculate the number  of  date(date difference)
function dateDiff($date1,$date2){

//change the date string to timestamps and  take the difference of the later and previous date
  $diff=strtotime($date2)-strtotime($date1);
  //1 day=24hours
  //24*60*60=86400  seconds

  return(abs(round($diff/(24*60*60))));

}
$conn=$db->connect();
if(!$conn){?>
<div class="text-center text-muted">
<h5>Connecction Failed	</h5>
</div>
  <?php
}
?>
<br>
<main id="main">
  <div class="container">
<?php
if(isset($_REQUEST['roomid'])){
  $getRoomInfo="SELECT *FROM  rooms JOIN properties ON(rooms.propertyId=properties.propertyId)  WHERE roomId='$_REQUEST[roomid]'";
  $getRoomQuery=mysqli_query($conn,$getRoomInfo);
  if(!$getRoomQuery==true){
    echo "Error ".mysqli_error($conn);
    die();
  }
  $getRoomCount=mysqli_num_rows($getRoomQuery);
  if($getRoomCount<=0){
    ?>
    <div class="alert alert-warning">
     <p> Please try Book a deifferent room</p>
    <?php

  }
  $getRoomResults=mysqli_fetch_array($getRoomQuery);
if($getRoomResults['availabilityStatus']!=="Available"){

?>
<h5 class="text-muted text-center"> This room is <?php echo $getRoomResults['availabilityStatus']; ?></h5>
<p class="text-center">Book a diffrent room</p>
<?php
  die();

}
  if(isset($_SESSION["sqNumberOfAdult"])&&isset($_SESSION["sqNumberOfChildren"])&&isset($_SESSION["sqDestination"])&&isset($_SESSION["sqCheckoutdate"])&&isset($_SESSION["sqCheckinDate"])){
  ?>
  <div class="card" id="form-card">
    <div class="card-header">
      <h5>Booking Confirmation</h5>
    </div>
<div class="card-body">
  <table class="table teble-fluid table-resposive">
<thead>
  <h5 class="text-info">Accomodation Details</h5>
</thead>
<tr>
  <td>Destination</td><td><?php echo $_SESSION["sqDestination"]?></td>
</tr>
<tr>
  <td>Accomodation</td><td><?php echo $getRoomResults['propertyName']; ?></td>
</tr>
<tr>
  <td>Room Id</td>
  <td><?php echo $getRoomResults['roomName']; ?></td>
</tr>
<tr>
  <td>Room Type</td>
  <td><?php echo $getRoomResults['roomCategory']; ?></td>
</tr>
<tr>
  <td>Floor </td>
  <td><?php echo $getRoomResults['FloorNumber']; ?></td>
</tr>
<tr>
  <td>Beds</td>
  <td><?php echo $getRoomResults['numberOfBed']; ?></td>
</tr>
<tr>
  <td>Additional Features</td>
  <td><?php echo $getRoomResults['facilitiesl']; ?></td>
</tr>
<tr>
  <td>Rate</td>
  <td>K <?php echo $getRoomResults['price']; ?> <?php echo $getRoomResults['asset_rate_intervals'];?></td>
</tr>
  </table>
    <hr>
  <h5>Your Reservation Details</h5>
  <form class="" action="" method="POST"  id="booking_form"  >
    <input type="hidden" name="roomId" value="<?php echo $getRoomResults['roomId']?>">
    <input type="hidden" name="propertyId" value="<?php echo $getRoomResults['propertyId']?>">
  <div class="row">

 <div class="col-md-3 form-group">
   <label for="">Checkin Date</label>
   <input type="date" name="checkInDate" value="<?php echo $_SESSION["sqCheckinDate"]?>" class="form-control form-control-lg"  id="checkinDate">
 </div>
 <div class="col-md-3 form-group">
   <label for="">CheckOutDate</label>
   <input type="date" name="checkOutDate" value="<?php echo $_SESSION["sqCheckoutdate"]?>" class="form-control  form-control-lg"  id="checkOutDate">
 </div>
 <div class="col-md-3 form-group">
   <label for="">Children</label>
   <p   class="form-control form-control-lg"><?php echo $_SESSION["sqNumberOfChildren"]?>
</p>
 </div>
 <div class="col-md-3 form-group">
   <label for="">Adults</label>
   <p   class="form-control form-control-lg"><?php echo $_SESSION["sqNumberOfAdult"]?>
</p> </div>
  </div>
  <hr>
  <div class="card-body">
    <div class="" id="reservationBill">
      <p id="processinginfo" class="text-center"></p>
      <p class="">Cost  Staying<?php

      echo  dateDiff($_SESSION["sqCheckinDate"],$_SESSION["sqCheckoutdate"])?>  days</p>
      <p>Rate <span class="h5">K<?php echo $getRoomResults['price'] ?> /Night</span>  </p>
      <hr>
      <p> Gross Cost <span class="h5"> K <?php echo dateDiff($_SESSION["sqCheckinDate"],$_SESSION["sqCheckoutdate"])*$getRoomResults['price'] ?>  </span> </p>
      <p>+ <?php echo $getRoomResults['tax'] ?> % GST</p>
      <p class="h5"> Final Cost: K <?php $_SESSION['reservationCost']=dateDiff($_SESSION["sqCheckinDate"],$_SESSION["sqCheckoutdate"])*$getRoomResults['price']+(((float)$getRoomResults['price']*(float)$getRoomResults['tax'])/100);
      echo $_SESSION['reservationCost'];
      ?></p>
    </div>
    <div class="col-md-4">
    </div>
    <div class="col-md-4">
    </div>
  </div>
<hr>
<h5 class="text-info">Personal  Details</h5>
<div class="row">
  <div class="col-md-3">
    <label for="">Name</label>
    <input type="text" name="custname"  class="form-control form-control-lg">
  </div>
  <div class="col-md-3">
    <label for="">Surname</label>
    <input type="text" name="custsurname"  class="form-control form-control-lg">
    </div>
  <div class="col-md-3">
    <label for="">Country</label>
    <input type="text" name="country"  class="form-control form-control-lg">
  </div>
  <div class="col-md-3">
    <label for="">Age</label>
    <input type="text" name="age"  class="form-control form-control-lg">
  </div>
</div>
<div class="row">
  <div class="col-md-3">
    <label for="">Phone</label>
    <input type="text" name="phone"  class="form-control form-control-lg">
  </div>
  <div class="col-md-3">
    <label for="">Email</label>
    <input type="text" name="custemail"  class="form-control form-control-lg">
  </div>
  <div class="col-md-3">
  </div>
</div>
<div class="row">
  <div class="col-md-8">
    <label for=""> Leave a Message</label>
    <textarea name="customerMessage" rows="8" cols="80" placeholder="Leave and Message" class="form-control"></textarea>
  </div>
  <div class="col-md-2">
  </div>
</div
<hr>
<div id="message" class="text-center"></div>
<hr>
<div class="row">
<div class="col-md-4">
</div>
<div class="col-md-4">
    <button type="submit"  class="btn-block  btn-info btn-lg">Confirm Booking</button>
</div>
<div class="col-md-4">

</div>
</div>
  </form>
</div>
  </div>
  <?php
  }else{
    $_SESSION["sqDestination"]=$getRoomResults['location'];

    ?>
    <div class="card" id="form-card">
      <div class="card-header">
        <h5>Booking Confirmation</h5>
      </div>
    <div class="card-body">
    <table class="table teble-fluid table-resposive">
    <thead>
    <h5 class="text-info">Accomodation Details</h5>
    </thead>
    <tr>
    <td>Destination</td><td><?php echo $_SESSION["sqDestination"]; ?></td>
    </tr>
    <tr>
    <td>Accomodation</td><td><?php echo $getRoomResults['propertyName']; ?></td>
    </tr>
    <tr>
    <td>Room Id</td>
    <td><?php echo $getRoomResults['roomName']; ?></td>
    </tr>
    <tr>
    <td>Room Type</td>
    <td><?php echo $getRoomResults['roomCategory']; ?></td>
    </tr>
    <tr>
    <td>Floor </td>
    <td><?php echo $getRoomResults['FloorNumber']; ?></td>
    </tr>
    <tr>
    <td>Beds</td>
    <td><?php echo $getRoomResults['numberOfBed']; ?></td>
    </tr>
    <tr>
    <td>Additional Features</td>
    <td><?php echo $getRoomResults['facilitiesl']; ?></td>
    </tr>
    <tr>
    <td>Rate</td>
    <td>K <?php echo $getRoomResults['price']; ?> <?php echo $getRoomResults['asset_rate_intervals'];?></td>
    </tr>
    </table>
      <hr>
    <h5>Your Reservation Details</h5>
    <form class="" action="" method="POST"  id="booking_form"  >
      <input type="hidden" name="roomId" value="<?php echo $getRoomResults['roomId']?>">
      <input type="hidden" name="propertyId" value="<?php echo $getRoomResults['propertyId']?>">
    <div class="row">
    <div class="col-md-3 form-group">
     <label for="">Checkin Date</label>
     <input type="date" name="checkInDate"  class="form-control form-control-lg"  id="checkinDate">
    </div>
    <div class="col-md-3 form-group">
     <label for="">CheckOutDate</label>
     <input type="date" name="checkOutDate" class="form-control  form-control-lg"  id="checkOutDate">
    </div>
    <div class="col-md-3 form-group">
     <label for="">Children</label>
     <input type="number" name="numberOfChildren" class="form-control form-control-lg" id="numberOfChildren">
    </p>
    </div>
    <div class="col-md-3 form-group">
     <label for="">Adults</label>
     <input type="number" name="numberOfAdults" class="form-control form-control-lg" id="numberOfAdults">
   </div>
    </div>
    <hr>
    <div class="card-body">
      <div class="col-md-12 " id="reservationBill">
        <p id="processinginfo" class="text-center"></p>
      </div>
    </div>
    <hr>
    <h5 class="text-info">Personal  Details</h5>
    <div class="row">
    <div class="col-md-3">
      <label for="">Name</label>
      <input type="text" name="custname"  class="form-control form-control-lg">
    </div>
    <div class="col-md-3">
      <label for="">Surname</label>
      <input type="text" name="custsurname"  class="form-control form-control-lg">
      </div>
    <div class="col-md-3">
      <label for="">Country</label>
      <input type="text" name="country"  class="form-control form-control-lg">
    </div>
    <div class="col-md-3">
      <label for="">Age</label>
      <input type="text" name="age"  class="form-control form-control-lg">
    </div>
    </div>
    <div class="row">
    <div class="col-md-3">
      <label for="">Phone</label>
      <input type="text" name="phone"  class="form-control form-control-lg">
    </div>
    <div class="col-md-3">
      <label for="">Email</label>
      <input type="text" name="custemail"  class="form-control form-control-lg">
    </div>
    <div class="col-md-3">
    </div>
    </div>
    <div class="row">
      <div class="col-md-8">
        <label for=""> Leave a Message</label>
        <textarea name="customerMessage" rows="8" cols="80" placeholder="Leave and Message" class="form-control"></textarea>
      </div>
      <div class="col-md-2">
      </div>
    </div>
    <hr>
    <div id="message" class="text-center"></div>
    <hr>
    <div class="row">
    <div class="col-md-2">
    </div>
    <div class="col-md-8">
      <button type="submit"  class="btn-block  btn-info btn-lg">Confirm Booking</button>
      <div class="col-md-2">
    </div>
    </div>
    </div>
    </form>
    </div>
  </div>
    <script type="text/javascript">
      $(document).ready(()=>{
        //numberOfChildren field  value change
        $("#numberOfChildren").on("change",function(){
          //console.log(this.value);
          $.ajax({
            url:`../controllers/change-booking-info?numberOfChildren=${this.value}`,
            type:"GET",
            beforeSend:function(){
              $("#numberOfChildren").css({
              color:"#4682B4"
              })
            },
            success:function(data){
              $("#numberOfChildren").css({
                color:"#778899"
              })
              //alert(data)
              console.log(data)
            }
          })
        })
        //#numberOfAdults field value cahnge
        $("#numberOfAdults").on("change",function(){
          //console.log(this.value);
          $.ajax({
            url:`../controllers/change-booking-info?numberOfAdults=${this.value}`,
            type:"GET",
            beforeSend:function(){
              $("#numberOfAdults").css({
                color:"#4682B4"
              })
            },
            success:function(data){
              $("#numberOfAdults").css({
                color:"#778899"
              })
              //alert(data)
              console.log(data)
            }
          })
        })
      })
    </script>
    <?php
  }
?>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $("#reservationBill").css({
      color:"#4169E1",

    })
    $("#checkOutDate").on("change",function(){
      //checkidateChange
      $.ajax({
        url:`../controllers/change-booking-info?checkoutDateChange=${this.value}&rate=<?php echo $getRoomResults['price']?>&tax=<?php echo $getRoomResults['tax']?>`,
        type:"GET",
        beforeSend:()=>{
          $("#reservationBill").html("<div class='col-md-2 offset-5'><img src='../public/images/loading.gif'></div>")
        },
        success:(data)=>{
          setTimeout(()=>{
          $("#reservationBill").html(data)
        },5000)
        }
      })
      //$("#reservationBill").html();
    })
    $("#checkinDate").on("change",function(){
      $.ajax({
        url:`../controllers/change-booking-info?checkindateChange=${this.value}&rate=<?php echo $getRoomResults['price']?>&tax=<?php echo $getRoomResults['tax']?>`,
        type:"GET",

          beforeSend:()=>{
            $("#reservationBill").html("<div class='col-md-2 offset-5'><img src='../public/images/loading.gif'></div>")
          },

        success:(data)=>{
          setTimeout(()=>{
          $("#reservationBill").html(data)
        },5000)
        }
      })
    })
    //reservation form submistion script
    $("#booking_form").on("submit",function(e){

        //prevetn the default form submission action
       e.preventDefault();
       // submit the form usigJquery ajax method for
      $.ajax({
            url:"../controllers/perform-booking-transaction.php",
            type:"POST",
            data:new FormData(this),
            contentType:false,
            cache:false,
            processData:false,

            //before sending the form
            beforeSend : function(){
              $("#message").html("<span class='alert  alert-info text-info'>  Processing...</span>").show();
            },
            //form issuccesfull submited and response rescived without failure
            success:function(data){

              let responsedata=JSON.parse(data);

              //$respose=Array("respose_type"=>"","respose_message"=>"","reseponese_note"=>"");
              if(responsedata.respose_type==="success")
                  {
                    $("#message").html(`<span class='alert  alert-success text-success'> ${responsedata.respose_message}</span>`).show();
                    setTimeout(()=>{
                      $("#message").fadeOut('slow')
                    },1500)
                    setTimeout(()=>{
                      $("#modal").fadeOut('fast')
                    },2000)
                    setTimeout(()=>{
                      $("#modal-content-sm").html(`<h5 class='text-center'><span class='text-primary h3'>${responsedata.reseponese_note}</span> is your Reservation Code</h5><p class='text-center '>It is important you retain this Code for your Confirmation Upon Check in</p>`)
                      $("#modal-sm").slideToggle("1000")
                    },3000)
                  } else{
                    $("#message").html(`<span class='alert  alert-danger text-danger'>${responsedata.respose_message}</span>`).show();
                    setTimeout(()=>{
                      $("#message").fadeOut('slow')
                    },3000)
                    //window.location.replace("/")
                  }
              },
            error:function(error){
              $("#message").html(`<span class='alert  alert-warning text-warning'>There was an error Sending the Request</span>`).show();
              setTimeout(()=>{
                $("#message").fadeOut('slow')
              },3000)
          }
    })
})
  })
</script>
</main>
<?php
}else{
   header("Location:/");
 }
//include("views/footer-1.php");
?>
