<?php
include("../controllers/config.php");
include('../controllers/classes/db-class.php');
session_start();
$thisdb=new db($h,$u,$pass,$db);
$conn=$thisdb->connect();

if(!$conn){
  echo "Conection failed";
  die();}

if(!isset($_SESSION['account'])&&($_SESSION['account'])!=="advanced"){
  ?>
<h3 class="text-center text-muted">You canot access this section of the Site</h3>
  <?php
  die();}

switch ($_SERVER["REQUEST_METHOD"]) {
  case 'GET':
  if(isset($_GET['roomid'])){
    $roomInfoSql="SELECT * FROM rooms WHERE roomId='$_GET[roomid]'";
    $roomdetailsQuery=mysqli_query($conn,$roomInfoSql);
    if($roomdetailsQuery==true){
      $roomresult=mysqli_num_rows($roomdetailsQuery);
      if($roomresult>0){
        $room_array=mysqli_fetch_array($roomdetailsQuery);

if($room_array['propertyId']!=$_SESSION['account_id']){
?>
  <h3 class="text-muted text-cnenter">You don't haner Ownership to this room</h3>
<?php
  die();
}
        ?>
        <a href="" id="edit-room-Info" class="btn btn-light"><span class="fas fa-edit"></span>Edit Details </a>|
        <a href="" id="deleteRoom"  class="btn btn-light"><span class="fas fa-trash"></span>Delete Room </a>|
        <a href="#" id="viewRoomPhoto"  class="btn btn-light"><span class="fas fa-trash"></span>View Photos</a>
        <hr>
        <div id="roomdetails">
          <p class="text-muted text-">Room ID  <?php echo $room_array['roomName']; ?>  </p>
          <hr>
          <p>Floor:  <?php echo $room_array['FloorNumber']; ?></p>
          <p> Number of Bed :<?php echo $room_array['numberOfBed']; ?></p>
            <!-- room photo -->

          <script type="text/javascript">
            $(document).ready(()=>{
              $("#viewRoomPhoto").on("click",function(e){
                e.preventDefault()
                $.ajax({
                  url:`properties/room-photos.php?roomId=<?php echo $room_array['roomId']?>`,
                  type:"GET",
                  beforeSend:function(){
                    $("#roomdetails").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='public/images/loading.gif'></div><div class='col-md-4'></div></div>")
                  },
                  success:function(data){
                    $("#roomdetails").html(data)
                  }
                })
              })

              $("#deleteRoom").on("click",function(e){
                e.preventDefault()
                $.ajax({
                  url:`properties/room.details.php?deleteRoom=<?php echo$room_array['roomId']?>`,
                  type:"GET",
                  beforeSend:function(){
                    $("#roomdetails").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='public/images/loading.gif'></div><div class='col-md-4'></div></div>").show()
                  },
                  success:function(data){
                    $("#roomdetails").html(`${data}`);
                  }
                })
              })
              $("#edit-room-Info").on("click",function(e){
                e.preventDefault()
                $.ajax({
                  url:`properties/edit-room-info.php?roomId=<?php echo $_GET['roomid'];?>`,
                  type:"GET",
                  beforeSend:function(){
                    $("#roomdetails").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='public/images/loading.gif'></div><div class='col-md-4'></div></div>").show()
                  },
                  success:function(data){
                    setTimeout(()=>{
                      $("#roomdetails").html(data).fadeIn("slow");
                    },1500)
                  }
                })

              })
            })
          </script>
        </div>
        <section id="editroominfo">

        </section>
        <?php
      }else{
        echo "The room is Not Available.";
      }
    }else{
      echo "Cannot Process Your data Due to Some technical Faults<br>".mysqli_error($conn);
    }
  }else if(isset($_GET['deleteRoom'])){
    ?>
    <div class="row">
      <div class="col-md-4">

      </div>
      <div class="col-md-4">

        <h5>Delete this room Now?</h5>
        <button type="button" class="btn btn-primary" id="confrimDelete">Delete</button>
      </div>
      <div class="col-md-4">

      </div>

    </div>
    <script type="text/javascript">
      $("#confrimDelete").on("click",function(){
        $.ajax({
          url:`properties/room.details.php?ConfirmDel=<?php echo $_GET['deleteRoom'];?>`,
          type:"GET",
          beforeSend:function(){
            $("#modal-content").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='public/images/loading.gif'></div><div class='col-md-4'></div></div>")
          },
          success:function(data){
            var realData=JSON.parse(data);
            if(realData.alert_type==="success"){
            $("#modal-content").html(`<div class="row"><div class="col-md-4"></div><div class="col-md-4"> <span class="alert aler-success">${realData.message}</span></div><div class="col-md-4"></div><div>`)
            setTimeout(()=>{
              $("#modal-content").hide();
              window.location.replace("");
            },3000)
          }else{
            $("#modal-content").html(`<div class="row"><div class="col-md-4"></div><div class="col-md-4"> <span class="alert aler-danger">${realData.message}</span></div><div class="col-md-4"></div><div>`)
          }

          }
        })
      })
    </script>
    <?php
  } else if(isset($_GET['ConfirmDel'])){

    $alert=Array("alert_type"=>"","message"=>"");

    $deleteRoomSql="DELETE FROM rooms  WHERE roomId='$_GET[ConfirmDel]'";
    $delQuery=mysqli_query($conn,$deleteRoomSql);
    if($delQuery==true){
      $alert['alert_type']="success";
      $alert['message']="Room Deleted Successfully";
        echo (json_encode($alert));
        die();
    }else{
      $alert['alert_type']="error";
      $alert['message']="Error Deleteing Room Data.";
        echo (json_encode($alert));
        die();

    }

  }
  else{
    echo "Room data Missing at the Moment";
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
