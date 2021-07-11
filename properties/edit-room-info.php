<?php
include("../controllers/config.php");
include('../controllers/classes/db-class.php');
session_start();
$thisdb=new db($h,$u,$pass,$db);
$conn=$thisdb->connect();
//checking for database connection
if(!$conn){
  die("Conection failed");
}

//cehcking for sessin variables
if(!isset($_SESSION['account'])&&($_SESSION['account'])!=="advanced"){
  die("You cannot Access this Section of the Site");
}

//Switch Between Request methods
switch ($_SERVER["REQUEST_METHOD"]) {
  case 'GET':
if(isset($_GET["roomId"])){
    //echo $_GET["roomId"];
    $sql="SELECT*FROM rooms WHERE roomId='$_GET[roomId]'";
    $query=mysqli_query($conn,$sql);
    if($query==true){
        $rooms=mysqli_num_rows($query);
        if($rooms>0){
            $room_array=mysqli_fetch_array($query);
            ?>
            <div class="card" id="form-card">
              <div class="card-header">
                <h5>Edit room Information</h5>
              </div>
              <div class="card-body">
                <form class="" action="" method="post" id="roomImdomationEdit-form">
                  <div class="row">
                    <div class="col-md-4">
                      <input type="hidden" name="roomId" value="<?php echo $room_array['roomId'];?>">
                      <label for="">Room Name/Room Id</label>
                      <input type="text" name="roomname" value="<?php echo$room_array['roomName']?>" class="form-control ">
                    </div>
                    <div class="col-md-4">
                      <label for="">Room Type/Category</label>
                      <input type="text" name="roomCategory" value="<?php echo$room_array['roomCategory']?>" class="form-control ">
                    </div>
                    <div class="col-md-4">
                      <label for="">Floor</label>
                      <input type="text" name="floorNummber" value="<?php echo$room_array['FloorNumber']?>" class="form-control ">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <label for="">Number of Beds</label>
                      <input type="text" name="beds" value="<?php echo$room_array['numberOfBed']?>" class="form-control ">
                    </div>
                    <div class="col-md-4">
                      <label for="">Bed Sizes (cm <sup>2</sup>)</label>
                      <input type="text" name="bedsizes" value="<?php echo $room_array['bedSize']?>" class="form-control ">
                    </div>
                    <div class="col-md-4">
                    </div>
                  </div>
                  <label for="">Amenities</label>
                  <textarea name="amenities" rows="8" cols="80" class="form-control "><?php echo $room_array['facilitiesl']?></textarea>
                  <label for="">Room Description</label>
                  <textarea name="roomDescription" rows="8" cols="80" class="form-control "><?php echo $room_array['roomDescription']?></textarea>
                  <div class="row">
                    <div class="col-md-4">
                      <label for="">Publication Status</label>
                      <select class="form-control" name="publicationStatus">
                        <option value="">-Publication Status--</option>
                        <option value="<?php echo $room_array['publoicationStatus']?>"><?php echo $room_array['publoicationStatus']?></option>
                        <?php
                        if($room_array['publoicationStatus']!="Published"){
                          ?>
                          <option value="Published">Publish</option>
                          <?php
                        }
                        if($room_array['publoicationStatus']!=="Under Review"){
                          ?>
                          <option value="Under Review">Put Under Review</option>
                          <?php
                        }
                        ?>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label for="">Rate (K/Night)</label>
                      <input type="text" name="rate" value="<?php echo $room_array['price']?>" class="form-control -control-lg">
                    </div>
                    <div class="col-md-4">
                      <label for="">Capacity</label>
                      <input type="text" name="capacity" value="<?php echo $room_array['roomCapacity']?>" class="form-control ">
                    </div>
                  </div>
                  <hr>
                  <div class="" id="processing">
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-4">
                      <button type="submit" class="btn-primary btn-lg btn-block">Save Changes Now</button>
                    </div>
                    <div class="col-md-4">
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <script type="text/javascript">
              $(document).ready(function(){
                $("#roomImdomationEdit-form").on("submit",function(e){
                  e.preventDefault();
                  $.ajax({
                    url:"properties/edit-room-info.php",
                    type:"POST",
            				data:new FormData(this),
            				contentType:false,
            				cache:false,
            				processData:false,
                     beforeSend:function(){
                       $("#processing").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='public/images/loading.gif'></div><div class='col-md-4'></div></div>")
                    },
                    success:function(data){
                      var realData=JSON.parse(data)
                      if(realData.alert_type==="success"){
                        setTimeout(()=>{
                          $("#processing").html(`<div class='row'><div class='col-md-2'></div><div class='col-md-8'><span class='alert alert-success'>${realData.message}</span><div class='col-md-2'></div></div>`).show();
                        },2000)
                        setTimeout(()=>{
                          $("#processing").fadeOut("slow");
                          $("#modal-content").fadeOut("slow")
                          window.location.replace("")
                        },3000)
                      }else{
                        setTimeout(()=>{
                          $("#processing").html(`<div class='row'><div class='col-md-2'></div><div class='col-md-8'><span class='alert alert-danger'>${realData.message}</span><div class='col-md-2'></div></div>`).show();
                        },2000)
                        setTimeout(()=>{
                          $("#processing").fadeOut("slow");
                        },3000)
                      }
                    },
                      error:function(){
                        alert("Error")                      }
                  })
                })
              })
            </script>
            <?php

        }else{
            echo "Information for this room is Not available";
        }
    }else{
        echo "Cannot Access the room Information due to some rechnical Faults ";
    }
}else{
  echo "Request Data is Not Properly Submited";
}
    break;
    case 'POST':
    $alert=Array("alert_type"=>"","message"=>"");

    if(isset($_POST['roomname'])&&isset($_POST['roomCategory'])&&isset($_POST['floorNummber'])&&isset($_POST['beds'])&&isset($_POST['bedsizes'])&&isset($_POST['amenities'])&&isset($_POST['publicationStatus'])&&isset($_POST['rate'])&&isset($_POST['capacity'])
    &&isset($_POST['roomId'])&&isset($_POST['roomDescription'])){

        //check Out the room publication Status
          if($_POST['publicationStatus']==""){
              $alert["alert_type"]="error";
              $alert["message"]="Publication Status is missing";
              die(json_encode($alert));
          }

        $editRoomSql="UPDATE rooms SET roomname='$_POST[roomname]',roomCategory='$_POST[roomCategory]',FloorNumber='$_POST[floorNummber]',numberOfBed='$_POST[beds]',bedSize='$_POST[bedsizes]',facilitiesl='$_POST[amenities]',publoicationStatus='$_POST[publicationStatus]', price='$_POST[rate]',roomDescription='$_POST[roomDescription]',roomCapacity='$_POST[capacity]' WHERE roomId='$_POST[roomId]'";

          $editRoomQUery=mysqli_query($conn,$editRoomSql);

          if($editRoomQUery==true){
          $alert["alert_type"]="success";
          $alert["message"]="Room Iformation Updated Successfully";
            die(json_encode($alert));
        }else{
          $alert["alert_type"]="error";
          $alert["message"]="Room Infoamtin Update failed ".mysqli_error($conn);
            die(json_encode($alert));
        }
    }else{
      $alert["alert_type"]="error";
      $alert["message"]="Incomplete form Data Submited";
      //$alert=Array("alert_typ"=>"","message"=>"");
        die(json_encode($alert));
    }
    break;
  default:
    echo "Wrong Request Method";
    break;
} ?>
