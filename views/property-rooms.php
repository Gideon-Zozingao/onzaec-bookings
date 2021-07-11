<?php
if(!isset($conn)){
  echo"Connection Failed";
}else{
  if(isset($row1['propertyId'])){
    if(isset($_GET['pageno'])){
      $pageno=$_GET['pageno'];
    }else{
      $pageno=1;
    }
    $roomsPerPage = 5;
    $offset = ($pageno-1) * $roomsPerPage;

    $totalRoomCount="SELECT * FROM rooms WHERE  propertyId='$row1[propertyId]' AND 	publoicationStatus='Published'";
    $result = mysqli_query($conn,$totalRoomCount);
    $totalRooms=mysqli_num_rows($result);
    $totalPages=ceil($totalRooms/$roomsPerPage);?>
<h4> <?php echo $totalRooms ?> Rooms available</h4>
<hr>
    <?php
  $roomSql="SELECT  *FROM rooms WHERE  propertyId='$row1[propertyId]' AND 	publoicationStatus='Published' LIMIT $offset,$roomsPerPage";
  $roomQuery=mysqli_query($conn,$roomSql);
  if($roomQuery){
$totalRooms=mysqli_num_rows($roomQuery);
if($totalRooms>0){?>
<div class="aos-init aos-animate" data-aos="fade-up">
<div class="row portfolio-container aos-init aos-animate" data-aos="fade-up" data-aos-delay="200" style="position: relative; height: 4283.42px;">
<?php
while($room_array=mysqli_fetch_array($roomQuery)){
  ?>
<div class="col-lg-12 col-md-12 portfolio-item filter-app" style="position: absolute; left: 0px; top: 0px;margin-bottom:12px;">
<div class="card
">
<div class="row">
<div class="col-md-6 card-body">
  <img src="public/gallery/images/<?php echo $room_array['roomCoverPhoto']?>" alt="<?php echo $room_array['roomName']?>" class="img-responsive img-fluid  img-round">
</div>
<div class="col-md-6">
  <div class="room-details">
    <p  class="h5">
      Room: <?php echo $room_array['roomName']?>  Catergory:  <?php echo $room_array['roomCategory']?> <a href="#" class="roomdetailsLink text-primary text-right" accessKey="<?php  echo $room_array['roomId']?>">Detials</a></p>


  <p><span  class="h1 text-warning">K <?php echo $room_array['price']?></span>  <?php echo $row1['asset_rate_intervals']?></p>

      <hr>
      <?php
  if($room_array['availabilityStatus']!=="Available"){
  ?>
  <p><span  class="text-muted h5"><?php echo $room_array['availabilityStatus']?> </span> Since <?php echo $room_array['avaialibiltyDate']?></p>
  <?php
  }else{?>
    <div class="row">
      <p class="col-md-4"><span  class="text-success h5"><?php echo $room_array['availabilityStatus']?></span></p>
        <a href="Booknow?roomid=<?php echo$room_array['roomId']?>" class="btn btn-info btn-lg reservationButton" accessKey="<?php echo$room_array['roomId']?>"> Book Now</a>

    </div>
    <?php
  }?>
  </div>
  </div>
</div>


</div>

</div>

  <?php
}?>
</div>
</div>
<!-- <script type="text/javascript">
  $(document).ready(function(){
    var roomdetailslink=$(".roomdetailsLink");
    console.log(roomdetailslink);
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

            // $("#modal").fadeIn()
          }
        })
          // $("#modal-content").html(`Viewing room Information ${roomdetailslink[i].accessKey}`);
          // $("#modal").fadeIn();
      })
    }

  })
</script> -->
<?php
}else{
  echo "No Rooms Available  for this property";
}}else{
    echo "Error:  ".mysqli_error($conn);
  }?>

  <hr>
  <div class="row">
    <div class="col-md-3">

    </div>
    <div class="col-md-6">
      <div class="container">
        <ul class="pagination">
      <li>
        <a class="btn <?php if($pageno==1){echo'btn-dark';}else{echo 'btn-info';}?>" href="<?php if($pageno==1){
          echo"#";
        } else{
          ?>
          ?Propertylink=<?php echo$_REQUEST["Propertylink"]?>&feature=rooms&pageno=1
          <?php
        }?>">First  Page</a></li>
      <li >
          <a  class="btn <?php if($pageno <= 1){ echo 'btn-dark'; }else{echo "btn-info";} ?>" href="<?php if($pageno <= 1){ echo '#'; } else {echo"?Propertylink=". $_REQUEST['Propertylink']."&feature=rooms&pageno=".($pageno - 1); }?>">Previous Page</a>
      </li>

      <li class=" ?>">
          <a  class="btn  <?php if($pageno >= $totalPages){ echo 'btn-dark'; }else{
            echo "btn-info";
          }?>" href="<?php if($pageno >= $totalPages){
            echo"#";}
            else{?>?Propertylink=<?php echo$_REQUEST["Propertylink"]?>&feature=rooms<?php echo "&pageno=".($pageno+1);
          }
          ?>">Next  Page</a>
      </li>
      <li><a class="btn <?php if($pageno>=$totalPages){
        echo "btn-dark";
      }else{
        echo "btn-info";

      }?>" href="<?php
if($pageno>=$totalPages){
  echo "#";
}else{
  ?>?Propertylink=<?php echo$_REQUEST["Propertylink"]?>&feature=rooms&pageno=<?php echo $totalPages; ?>
  <?php
}
      ?>">Last  Page</a></li>
      </ul>
      </div>
    </div>
    <div class="col-md-3">

    </div>
  </div>
  <?php
  }else{
    echo "Cannot Display Rooms Now";
  }
}?>
<?php
?>
