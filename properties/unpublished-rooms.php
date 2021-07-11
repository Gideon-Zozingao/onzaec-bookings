

<?php
session_start();
//use the configuration file  and file virables
// function dateDiff($date1,$date2){
//
// //change the date string to timestamps and  take the difference of the later and previous date
//   $diff=strtotime($date2)-strtotime($date1);
//   //1 day=24hours
//   //24*60*60=86400  seconds
//
//   return(abs(round($diff/(24*60*60))));
//
// }
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
if(isset($_SESSION['logedin'])&&isset($_SESSION['account'])&&$_SESSION['accountType']==="propertyacc"){
$roomslq="SELECT  * FROM  rooms WHERE propertyId='$_SESSION[account_id]' AND publoicationStatus<>'Published'";
$roomQuery=mysqli_query($conn,$roomslq);
if($roomQuery==true){
$results=mysqli_num_rows($roomQuery);
if($results>0){?>


              <table class="table table-striped">
                <thead>

                </thead>
                <tr>
                  <th>Room ID</th>
                  <th>Room Type</th>
                  <th>Floor</th>
                  <th>Beds</th>
                  <th>Nomaral Rate</th>
                  <th>Capacity</th>
                  <th>Publication Status</th>
                  <th>Availability</th>
<th><button type="button" name="button" class="btn-primary btn btn-sm"  id="addRoomButton">Add a Room</button> </th>
                  </tr>

              <div class="row">
  <?php
while($roomRows=mysqli_fetch_array($roomQuery)){
  ?>
<tr>
  <td><a href="?action=view&page=rooms&room=<?php echo$roomRows['roomId']?>"><?php echo$roomRows['roomName']?></a> </td>
  <td><?php echo$roomRows['roomCategory']?></td>
  <td><?php echo$roomRows['FloorNumber']?></td>
  <td><?php echo$roomRows['numberOfBed']?></td>
  <td><span  class="text-center  text-warning"> K  <?php echo$roomRows['price']?>/Night</span></td>
  <td><?php echo$roomRows['roomCapacity']?></td>
  <td><?php
  echo $roomRows['publoicationStatus'];
if($roomRows['publoicationStatus']=="Available"){
  ?><span class="text-success"><?php echo$roomRows['publoicationStatus'] ?></span> <?phpecho$roomRows['publoicationStatus']
}else{?>
    <span class="text-warning"><?php echo$roomRows['publoicationStatus'] ?> </span>
  <?php

}
  ?></td>
  <td><?php
  if($roomRows['availabilityStatus']=="Available"){
    ?><span class="text-success"><?php echo$roomRows['availabilityStatus'] ?></span> <?php
  }else{?>
      <span class="text-warning"><?php echo$roomRows['availabilityStatus'] ?> </span>
    <?php

  }
    ?>
  </td>
  <td><a href="" class="roomDetails" accessKey="<?php echo$roomRows['roomId']?>"><span class="fas fa-info"></span> Details </a> | <a href="" class="editroomDetails" accessKey="<?php echo $roomRows['roomId']?>"><span class="fas fa-edit"></span> Edit</a>
    <?php if($roomRows['availabilityStatus']=="Available"){
    ?>
|<a href="#" class="checkinLink" accessKey="<?php echo $roomRows['roomId']?>">Checkin</a>
    <?php
  }?>
  </td>
</tr>
  <?php
}
?>
<script type="text/javascript">
$(document).ready(function(){
  //checkin Link CLicking Event
var checkinLink=$(".checkinLink");
for(let i=0;i<checkinLink.length;i++){
  $(checkinLink[i]).on("click",function(e){
    //alert(`Checking in at ${this.accessKey}`)

    $.ajax({
      url:`../properties/forms/counter-reservation-form?roomid=${this.accessKey}`,
      type:"GET",
      beforeSend:function(){
        $("#modal-content").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='public/images/loading.gif'></div><div class='col-md-4'></div></div>")
        $("#modal").fadeIn("slow")
      },
      success:function(data){
        setTimeout(()=>{
        $("#modal-content").html(data)
        },1500)
      }
    })
  })
}
console.log(checkinLink)



  var roomdetailLink=$(".roomDetails");
  var editRoomLink=$(".editroomDetails");
  for(let e=0;e<editRoomLink.length;e++){
    $(editRoomLink[e]).on("click",function(a){
      a.preventDefault();
      $.ajax({
        url:`properties/edit-room-info.php?roomId=${this.accessKey}`,
        type:"GET",
        beforeSend:function(){
          $("#modal").show()
          $("#modal-content").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='public/images/loading.gif'></div><div class='col-md-4'></div></div>").show()
        },
        success:function(data){
          setTimeout(()=>{
            $("#modal-content").html(data);
            $("#modal").fadeIn("slow");
          },1500)
        },
        error:function(error){
        }

      })
    })
  }


  for(let i=0;i<roomdetailLink.length;i++){
    $(roomdetailLink[i]).on("click",function(e){
      e.preventDefault();
      $.ajax({
        url:`properties/room.details.php?roomid=${this.accessKey}`,
        type:"GET",
        beforeSend:function(){
          $("#modal").show()
          $("#modal-content").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='public/images/loading.gif'></div><div class='col-md-4'></div></div>").show()
        },
        success:function(data){
          setTimeout(()=>{
            $("#modal-content").html(data);
            $("#modal").fadeIn("slow");
          },1500)
        },
        error:function(error){
        }
      })
    })
  }


    //Resirecto to Add Room Page on Add Room Button Click
  $("#addRoomButton").on("click",()=>{
      setTimeout(()=>{
          window.location.replace("account?action=add&a?=room")
      },1000)

  })


})
</script>
</div>
</table>

<?php
}else{?>
  <br>
<section class="">

  <h3 class="text-muted">No Rooms availabel for this site
  your site</h3>

</section>
  <?php
}
}else{
  die("Error: ".mysqli_error($conn));
}

}else{
die("Unknow Error");
}
?>
