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

//switch between the request methods
switch ($_SERVER['REQUEST_METHOD']) {
  case 'GET':
  if(isset($_GET["recalcBill"])&&isset($_GET["newDate"])){
    try {
      $getBookingInfo="SELECT *FROM  bookings JOIN rooms ON bookings.roomId=rooms.roomId WHERE bookings.bookingId='$_GET[recalcBill]'";
          $getBookingInfoQuery=$conn->query($getBookingInfo);
          $getBookingInfoQuery->setFetchMode(PDO::FETCH_ASSOC);
          $getBookingInfoResults=$getBookingInfoQuery->rowCount();

          if($getBookingInfoResults>0){
          $getBookingInfoArray=$getBookingInfoQuery->fetch();
          //echo $getBookingInfoArray['bookingId'];
          $newBill=dateDiff($getBookingInfoArray['checkInDate'],$_GET["newDate"])*$getBookingInfoArray['price'];
          ?>
          <div class="card-body" >
          <form class="" action="" method="post" id="reservationCheckoutForm">
            <input type="hidden" name="bill" value="<?php echo $newBill?>">
            <input type="hidden" name="bookingId" value="<?php echo $getBookingInfoArray['bookingId']?>">
            <div class="row">
              <input type="hidden" name="roomId" value="<?php echo $getBookingInfoArray['roomId']?>">
              <div class="col-md-4">
                <label for="">Checked In @</label>
                <p class="form-control"><?php echo $getBookingInfoArray['checkInDate'] ?></p>
              </div>
              <div class="col-md-4 ">
                <label for="">Check Out date</label>
                <input type="date" name="checkOutdate" value="<?php echo $_GET["newDate"]?>" class="form-control" id="checkOut">
              </div>
            </div>
            <hr>
            <div class="card" id="billing">
              <div class="card-body">
                <p class="h5">Room Rate <span class="text-primary"><?php echo $getBookingInfoArray['price']?></span> </p>
                <p class="h5">Stayed for <span class="text-primary"><?php
                //dateDiff($date1,$date2)
                echo  dateDiff($getBookingInfoArray['checkInDate'],$_GET["newDate"])." Nights";
                ?></span> </p>
              </div>
              <div class="card-footer">
                <p calss="h5">Total Cost of Stay <span class="h3">
                  K <?php echo  dateDiff($getBookingInfoArray['checkInDate'],$_GET["newDate"])*$getBookingInfoArray['price'];
                ?></span></p>
              </div>
            </div>
            <hr>
            <div class="">
              <textarea name="reservationComment" rows="6" cols="80" class="form-control" placeholder="Comment"></textarea>
            </div>
            <hr>
            <div class="col-md-4 offset-4">
              <button type="submit" name="button" class="btn-primary btn-lg">Check Out</button>
            </div>
          </form>
          <script type="text/javascript">
            $(document).ready(function(){
              //check out date change
              $("#checkOut").on("change",()=>{
                var newDate=$("#checkOut").val()
                $.ajax({
                url:`properties/bookings-take-action.php?recalcBill=<?php echo $getBookingInfoArray['bookingId']?>&newDate=${newDate}`,
                  type:"GET",
                  beforeSend:function(){
                    $("#checkOutPane").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='public/images/loading.gif'></div><div class='col-md-4'></div></div>")
                  },
                  success:function(data){
                    setTimeout(()=>{
                      $("#checkOutPane").html(data);
                    },1500)
                  }
                })
              })

              //precessing or reservationCheckoutForm submission
              $("#reservationCheckoutForm").on("submit",function(e){
                e.preventDefault()

                //Process the form  Asynchronously
                $.ajax({
                  url:"properties/bookings-take-action",
                  type:"POST",
                  data:new FormData(this),
                  contentType:false,
                  cache:false,
                  processData:false,
                  beforeSend:function(){
                    $("#checkOutPane").html("<div class='col-md-4 offset-4'><img src='public/images/loading.gif'></div>")
                  },
                  success:function(data){
                    $("#checkOutPane").html("")
                    var JSONdata=JSON.parse(data)
                    if(JSONdata.response_type=="success"){
                      $("#modal-top-body").html(`<span class='text-success text-center '>${JSONdata.response_message}</span>`)
                      $("#modal-top").fadeIn("slow")
                      $("#modal-content").html("")
                      $("#modal").slideToggle("fast")
                      setTimeout(()=>{
                        $("#modal-top").fadeOut("slow")
                      },2000)
                    }else{
                      $("#modal-top-body").html(`<span class='text-center text-danger '>${JSONdata.response_message}</span><p class='text-center text-muted'>${JSONdata.response_note}</p>`)
                      $("#modal-top").fadeIn("slow")

                      setTimeout(()=>{
                        $("#modal-top").fadeOut("slow")
                      },2000)

                    }
                  }
                })
              })
            })

          </script>
        </div>
          <?php
  }else{
    echo "Informaiton for this reservation is no Longer Available";
  }
      
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
    
    
}


//process thre reservation delete form submision
if(isset($_GET['deleteThis'])){
  ?>
<div class="col-md-8 offset-2">
  <h5 class="text-center text-peimary">Delet This Reservation Now</h5>
<form class="" action="" method="post" id="deleteBookingForm">
<input type="hidden" name="deleteBooking" value="<?php echo $_GET['deleteThis']?>">
<div class="col-md-4 offset-4">
<button type="submit" name="button" class="btn-primary btn-lg btn-block">Delete</button>
</div>
</form>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $("#deleteBookingForm").on("submit",function(e){
      e.preventDefault()
      $.ajax({
        url:"properties/bookings-take-action",
        type:"POST",
        data:new FormData(this),
				contentType:false,
				cache:false,
				processData:false,
        beforeSend:function(){
          $("#modal-content").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='public/images/loading.gif'></div><div class='col-md-4'></div></div>")
          $("#modal").fadeIn("slow")
        },
        success:function(data){
          var JSONdata=JSON.parse(data)
          if(JSONdata.response_type=="success"){
            setTimeout(()=>{
              $("#modal-top-body").html(`<span class=' text-center'>${JSONdata.response_message}</span>`)
              $("#modal-top").slideToggle("fast")
            },1500)
            setTimeout(()=>{
              $("#modal-top").slideToggle("fast")
              $("#modal-content").html("")
              $("#modal").slideToggle("fast")
            },2000)
          }else{
            setTimeout(()=>{
              $("#modal-content").html(`<span class='alert alert-danger col-md-4 offset-4 text-center'>${JSONdata.response_message}</span>`)
            },1500)
          }
        }
      })
    })
  })
</script>
  <?php
}
  if(isset($_GET['actFor'])&&isset($_GET['action'])){
    try {
      
      $getBookingInfo="SELECT *FROM  bookings JOIN rooms ON bookings.roomId=rooms.roomId WHERE bookings.bookingId='$_GET[actFor]'";
      $getBookingInfoQuery=$conn->query($getBookingInfo);
      $getBookingInfoQuery->setFetchMode(PDO::FETCH_ASSOC);
      $getBookingInfoResults=$getBookingInfoQuery->rowCount();
      if($getBookingInfoResults>0){
          $getBookingInfoArray=$getBookingInfoQuery->fetch();
          switch ($_GET['action']) {
            case 'Checked Out':
            ?>
            <div class="" id="checkOutPane">
              <div class="card-body" >
              <form class="" action="" method="post" id="reservationCheckoutForm">
                <input type="hidden" name="bill" value="<?php echo $getBookingInfoArray['reservationBill']?>">

                <input type="hidden" name="bookingId" value="<?php echo $getBookingInfoArray['bookingId']?>">

                <input type="hidden" name="roomId" value="<?php echo $getBookingInfoArray['roomId']?>">
                <div class="row">
                  <div class="col-md-4">
                    <label for="">Checked In @</label>
                    <p class="form-control"><?php echo $getBookingInfoArray['checkInDate'] ?></p>
                  </div>
                  <div class="col-md-4 ">
                    <label for="">Check Out date</label>
                    <input type="date" name="checkOutdate" value="<?php echo $getBookingInfoArray['checkOutDate']?>" class="form-control" id="checkOut">
                  </div>
                </div>
                <hr>
                <div class="card" id="billing">
                  <div class="card-body">
                    <p class="h5">Room Rate <span class="text-primary">K <?php echo $getBookingInfoArray['price']?> /Night</span> </p>
                    <p class="h5">Stayed for <span class="text-primary"><?php
                    //dateDiff($date1,$date2)
                    echo  dateDiff($getBookingInfoArray['checkInDate'],$getBookingInfoArray['checkOutDate'])." Nights";
                    ?></span> </p>
                  </div>
                  <div class="card-footer">
                    <p calss="h5">Total Cost of Stay <span class="h3">K <?php
                    //dateDiff($date1,$date2)
                    echo  dateDiff($getBookingInfoArray['checkInDate'],$getBookingInfoArray['checkOutDate'])*$getBookingInfoArray['price'];
                    ?></span></p>
                  </div>
                </div>
                <hr>
                <div class="">
                  <textarea name="reservationComment" rows="6" cols="80" class="form-control" placeholder="Comment"></textarea>
                </div>
                <hr>
                <div class="col-md-4 offset-4">
                  <button type="submit" name="button" class="btn-primary btn-lg">Check Out Now</button>
                </div>
              </form>
              <script type="text/javascript">
                $(document).ready(function(){
                  //check out date change
                  $("#checkOut").on("change",()=>{
                    var newDate=$("#checkOut").val()
                    $.ajax({
                    url:`properties/bookings-take-action.php?recalcBill=<?php echo $getBookingInfoArray['bookingId']?>&newDate=${newDate}`,
                      type:"GET",
                      beforeSend:function(){
                        $("#checkOutPane").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='public/images/loading.gif'></div><div class='col-md-4'></div></div>")
                      },
                      success:function(data){
                        setTimeout(()=>{
                          $("#checkOutPane").html(data);
                        },1500)
                      }
                    })
                  })
                  //precessing or reservationCheckoutForm submission
                  $("#reservationCheckoutForm").on("submit",function(e){
                    e.preventDefault()

                    //Process the form  Asynchronously
                    $.ajax({
                      url:"properties/bookings-take-action",
                      type:"POST",
                      data:new FormData(this),
                      contentType:false,
                      cache:false,
                      processData:false,
                      beforeSend:function(){
                        $("#checkOutPane").html("<div class='col-md-4 offset-4'><img src='public/images/loading.gif'></div>")
                      },
                      success:function(data){
                        $("#checkOutPane").html("")
                        var JSONdata=JSON.parse(data)
                        if(JSONdata.response_type=="success"){
                          $("#modal-top-body").html(`<span class='text-success text-center '>${JSONdata.response_message}</span>`)
                          $("#modal-top").fadeIn("slow")
                          $("#modal-content").html("")
                          $("#modal").slideToggle("fast")
                          setTimeout(()=>{
                            $("#modal-top").fadeOut("slow")
                          },2000)
                        }else{
                          $("#modal-top-body").html(`<span class='text-center text-danger '>${JSONdata.response_message}</span><p class='text-center text-muted'>${JSONdata.response_note}</p>`)
                          $("#modal-top").fadeIn("slow")

                          setTimeout(()=>{
                            $("#modal-top").fadeOut("slow")
                          },2000)

                        }
                      }
                    })
                  })
                })
              </script>
            </div>
          </div>
            <?php
            break;
            //precess request for Checkin
            case 'Checked In':
                ?>
                <div  id="checkInConfirmation">
                  <h4 class="text-center">Check In </h4>
                  <form class="" action="" method="post" id="chekinConfirmationForm">
                    <label for="">Commet</label>
                    <textarea  rows="8" cols="80" name="reservationComent" class="form-control"></textarea>
                    <input type="hidden" name="Chekin" value="Checked In">
                    <input type="hidden" name="roomId" value="<?php echo$getBookingInfoArray['roomId']?>">
                    <input type="hidden" name="bookingId" value="<?php echo $getBookingInfoArray['bookingId']?>" id="bookingId">
                    <hr>
                    <div class="col-md-6 offset-3">
                      <button type="submit" class="btn-primary btn-lg btn-block">Check In</button>
                    </div>
                  </form>
                </div>
                <script type="text/javascript">
                  $(document).ready(()=>{
                    $("#chekinConfirmationForm").on("submit",function(e){
                      e.preventDefault();
                      $.ajax({
                        url:"properties/bookings-take-action",
                        type:"POST",
                        data:new FormData(this),
                        contentType:false,
                        cache:false,
                        processData:false,
                        beforeSend:function(){
                          $("#checkInConfirmation").html("<div class='col-md-4 offset-4'><img src='public/images/loading.gif'></div>")
                        },
                        success:function(data){
                          var a=JSON.parse(data)
                          if(a.response_type=="success"){
                          $("#modal-top-body").html(`<span class=' text-success text-center'>${a.response_message}</span>`)
                          setTimeout(()=>{
                            $("#checkInConfirmation").html("")
                            $("#modal-top").fadeIn("slow")
                            $("#modal").fadeOut("slow")
                          },1500)
                          setTimeout(()=>{
                            $("#modal-top").fadeOut("slow")


                          },3000)
                        }else{
                          $("#modal-top-body").html(`<span class='text-center  text-dnager '>${a.response_message}</span>
                          <p>${a.response_note}</p>
                          `)
                          setTimeout(()=>{
                            $("#modal-top").fadeIn("slow")
                          },1500)
                          setTimeout(()=>{
                            $("#modal-top").fadeOut("slow")
                          })
                        }

                        }
                      })
                    })
                  })
                </script>
                <?php
            break;
            //proeces the canccel boking Request
            case 'Cancelled':
                  // code...
                  ?>
                  <div class="" id="cancelBookingProcess">
                    <p class="text-center">Cacel this Booking Now<p>
                   <form class="" action="" method="post" id="bookingCancellationForm">
                     <input type="hidden" name="bookingId" value="<?php echo $_GET["actFor"]?>">
                     <input type="hidden" name="cancel" value="Calcelled">
                     <input type="hidden" name="roomId" value="<?php echo$getBookingInfoArray['roomId'] ?>">
                     <!-- $getBookingInfoArray -->
                     <textarea name="reservationComment" rows="8" cols="80" class="form-control" placeholder="Comment"></textarea>
                     <hr>
                    <div class="col-md-2 offset-5">
                      <button type="submit" class="btn-primary btn-lg">Cancel</button>
                    </div>
                   </form>
                  </div>
                  <script type="text/javascript">
                      $(document).ready(()=>{
                        $("#bookingCancellationForm").on("submit",function(e){
                          e.preventDefault()
                          $.ajax({
                            url:"properties/bookings-take-action.php",
                            type:"POST",
                            data:new FormData(this),
                            contentType:false,
                            cache:false,
                            processData:false,
                            beforeSend:function(){
                              $("#cancelBookingProcess").html("<div class='col-md-4 offset-4'><img src='public/images/loading.gif'></div>")
                            },
                            success:function(data){
                              var JSONdata=JSON.parse(data)
                              if(JSONdata.response_type=="success"){
                                $("#modal-content").html(`<span class="alert alert-success text-center col-md-4 offset-4">${JSONdata.response_message}</span>`)
                                setTimeout(()=>{
                                  $("#modal").fadeIn("slow")
                                },1500)
                                setTimeout(()=>{
                                  $("#modal").fadeOut("slow")
                                },2000)
                              }else{
                                $("#modal-content").html(`<div class='col-md-4 offset-4'><span class="alert alert-danger text-center ">${JSONdata.response_message}</span><p class='text-center text-muted'>${JSONdata.response_note}</p></div>`)
                                setTimeout(()=>{
                                  $("#modal").fadeIn("slow")
                                },1500)
                              }
                              setTimeout(()=>{
                              $("#cancelBookingProcess").html(data);
                              })

                            }
                          })
                        })
                      })
                  </script>
                  <?php
            break;
            //preocess the reservation reschdule request
            case 'Reschedule':
                    echo "Reschedule";
            break;

            default:
              echo "Invalid Request";
              break;
          }
      }else{
        echo "Th result for this reservation is no Longer available";
      }


    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    
  }

    if(isset($_GET['actionThisBooking'])){
      try {
          $getBookingInfo="SELECT *FROM  bookings JOIN rooms ON bookings.roomId=rooms.roomId WHERE bookings.bookingId='$_GET[actionThisBooking]'";
        $getBookingInfoQuery=$conn->query($getBookingInfo);
        $getBookingInfoQuery->setFetchMode(PDO::FETCH_ASSOC);
        $getBookingInfoResults=$getBookingInfoQuery->rowCount();

        if($getBookingInfoResults>0){
            $getBookingInfoArray=$getBookingInfoQuery->fetch();
            ?>
            <div class="col-md-6 offset-3">
                <input type="hidden" name="bookingsId" value="<?php echo $_GET['actionThisBooking']?>" id="bookingId">
                <select class="form-control" name="bookingAction" id="bookingActionField">
                  <option value="">Take an Action</option>
                  <?php if($getBookingInfoArray['reservationStatus']=="Checked In"){?>
                    <option value="Checked Out">Check Out</option>
                    <option value="Reschedule">Reschedule</option>
                    <?php
                  }if($getBookingInfoArray['reservationStatus']=="Pending Confirmation"){
                  ?>
                  <option value="Checked In">Checkin</option>
                  <option value="Cancelled">Cancel</option>
                  <?php
                  }
                  if($getBookingInfoArray['reservationStatus']=="Cheked Out"||$getBookingInfoArray['reservationStatus']=="Cancelled"){
                    ?><?php
                  }
                  ?>
                </select>
            </div>
            <hr>
            <div class="" id="takeAcction">
            </div>
            <script type="text/javascript">
              $(document).ready(function(){
                $("#bookingActionField").on("change",function(){
                  if(this.value==""){
                    $("#takeAcction").html("<div class='col-md-6 offset-3' id='alert'><span class='alert alert-danger '>Choose and Appropriate Action</span></div>")
                    setTimeout(()=>{
                      $("#alert").fadeOut("slow")
                    },2000)
                  }else{
                    $.ajax({
                      url:`properties/bookings-take-action?actFor=<?php echo $_GET['actionThisBooking']?>&action=${this.value}`,
                      type:"GET",
                      beforeSend:function(){
                        $("#takeAcction").html("<div class='col-md-2 offset-4'><img src='public/images/loading.gif'></div>")
                      },
                      success:function(data){
                        setTimeout(()=>{
                          $("#takeAcction").html(data)
                      },1500)
                      }
                    })
                  }
                })
              })
            </script>
            <?php
          }else{
              echo "This information is o longer available";
            }

      } catch (PDOException $e) {
        echo $e->getMessage() ;
      }
    }
    break;





    //Proces all the POSt request Here
    case 'POST':
    $response=Array("response_type"=>"","response_message"=>"","response_notes"=>"");

    //process reservation Cancellation request
    if(isset($_POST["cancel"])&&isset($_POST["bookingId"])&&isset($_POST["reservationComment"])&&isset($_POST["roomId"])){
      include("../controllers/classes/booking-class.php");
      include("../controllers/classes/room-class.php");
      include("../controllers/classes/reservation-comment-class.php");
      //
      $reservationComment=new reservationComment(date("YmdHis"));
      $reservationComment->setReservationId($_POST["bookingId"]);
      $reservationComment->setUserId($_SESSION["id"]);
      $reservationComment->setCommentText($_POST["reservationComment"]);
      $reservationComment->setCommentDate(date("Y-m-d"));
      $reservationComment->setCommentTime(date("H:i:s"));

      //attemp registering of the data into the database

      if($_POST["reservationComment"]!=""){
      $reservationComment->resgisterComment($conn);
      }
      $booking=new Bookings($_POST["roomId"],$_SESSION["account_id"],"","","");
      //__construct($roomId,$propertyId,$reserVationCode,$reservationDate,$customerId)
      $room=new Room();
      $booking->setBookingId($_POST["bookingId"]);
      $booking->setReservationStatus("Cancelled");
      ///$booking->setCheckOutDate($_POST["checkOutdate"]);

      //$booking->setReservationBill($_POST["bill"]);


        $room=new Room();
        $room->setRoomId($_POST["roomId"]);
        $room->setavailabilityStatus("Available");
        $room->setavaialibiltyDate(date("Y-m-d"));

        $updateRoomAvailStatus=$room->updateAvailablityStatus($conn);
        if($updateRoomAvailStatus!==true){

          //$response=Array("response_type"=>"","response_message"=>"","response_notes"=>"");
          $response["response_type"]="error";
          $response["response_message"]="Cancellation Failed";
          $response["response_notes"]="Cannot Update room Information ";
          echo (json_encode($response));
          die();
        }
        $cancelBooking=$booking->updateReservationStatus($conn);;
        if($cancelBooking==true){
          $response["response_type"]="success";
          $response["response_message"]="Reservation Cancelled";
          $response["response_notes"]="";
          echo (json_encode($response));
          die();

        }else{

          $response["response_type"]="error";
          $response["response_message"]="Cacelation Failed";
          $response["response_notes"]="Application Error";
          echo (json_encode($response));
          die();

        }
    }
    //process the reservation check out form submssion
    if(isset($_POST["bill"])&&isset($_POST["checkOutdate"])&&isset($_POST["bookingId"])&&isset($_POST["reservationComment"])&&isset($_POST["roomId"])){
      include("../controllers/classes/booking-class.php");
      include("../controllers/classes/room-class.php");
      include("../controllers/classes/reservation-comment-class.php");
      $booking=new Bookings($_POST["roomId"],$_SESSION["account_id"],"","","");
      //__construct($roomId,$propertyId,$reserVationCode,$reservationDate,$customerId)
      $room=new Room();
      $booking->setBookingId($_POST["bookingId"]);
      $booking->setReservationStatus("Checked Out");
      $booking->setCheckOutDate($_POST["checkOutdate"]);
      $booking->setReservationComment($_POST["reservationComment"]);
      $booking->setReservationBill($_POST["bill"]);
        $room=new Room();
        $room->setRoomId($_POST["roomId"]);
        $room->setavailabilityStatus("Available");
        $room->setavaialibiltyDate(date("Y-m-d"));
        $reservationComment=new reservationComment(date("YmdHis"));
        $reservationComment->setReservationId($_POST["bookingId"]);
        $reservationComment->setUserId($_SESSION["id"]);
        $reservationComment->setCommentText($_POST["reservationComment"]);
        $reservationComment->setCommentDate(date("Y-m-d"));
        $reservationComment->setCommentTime(date("H:i:s"));

        //attemp registering of the data into the database

if($_POST["reservationComment"]!=""){
  $reservationComment->resgisterComment($conn);
}
        $updateRoomAvailStatus=$room->updateAvailablityStatus($conn);
        if($updateRoomAvailStatus!==true){
          $response['response_type']="error";
          $response["response_message"]="Check out failed";
          $response["response_note"]="Cannot Update room Information";
          echo (json_encode($response));
          die();
        }
        $checkout=$booking->checkOut($conn);
        if($checkout==true){
          $response['response_type']="success";
          $response["response_message"]="Checked Out Successfully";
          echo (json_encode($response));
          die();
        }else{
          $response['response_type']="error";
          $response["response_message"]="Check out failed";
          $response["response_note"]="Applicatin Error";
          echo (json_encode($response));
          die();
        }
    }

    //recive and precess the delet booking form submission
    if(isset($_POST["deleteBooking"])){
      try {
          $deletBookingSql="DELETE FROM bookings WHERE bookingId='$_POST[deleteBooking]'";
        $deletBookingQuery=$conn->prepare($deletBookingSql);
        $deletBookingQuery->execute();
        $count=$deletBookingQuery->rowCount();
        if($count>0){
          $response['response_type']="success";
        $response['response_message']="Reservation Deleted Succesfully";
        $response["response_note"]="";
        echo (json_encode($response));
        }else{
          $response['response_type']="error";
        $response['response_message']="Reservation Not deleted";
        $response["response_note"]="Technical Error";
        echo(json_encode($response));
        die();
        }
        
      } catch (PDOException $e) {
        
        $response['response_type']="error";
        $response['response_message']="Cannot Delete The reservation";
        $response["response_note"]="Technical Error";
        echo(json_encode($response));
        die();
      }
    }

    //preocessin Booking Confirmation Form Submision
    if(isset($_POST["Chekin"])&&isset($_POST["bookingId"])&&isset($_POST["roomId"])&&isset($_POST["reservationComent"])){
      include("../controllers/classes/booking-class.php");
      include("../controllers/classes/reservation-comment-class.php");
      $booking=new Bookings("","","","","");
      $booking->setBookingId($_POST["bookingId"]);
      $booking->setReservationStatus($_POST['Chekin']);
      $reservationComment=new reservationComment(date("YmdHis"));
      $reservationComment->setReservationId($_POST["bookingId"]);
      $reservationComment->setUserId($_SESSION["id"]);
      $reservationComment->setCommentText($_POST["reservationComent"]);
      $reservationComment->setCommentDate(date("Y-m-d"));
      $reservationComment->setCommentTime(date("H:i:s"));

      //attemp registering of the data into the database


      if($_POST["reservationComent"]!=""){
        $reservationComment->resgisterComment($conn);
      }

        $updateStatus=$booking->updateReservationStatus($conn);
        if($updateStatus==true){
          $response['response_type']="success";
          $response['response_message']="Checked in Successfully";
          $response["response_note"]="";
          echo (json_encode($response));
          die();
        }else{
          $response['response_type']="error";
          $response['response_message']="Cannot Checkin Now";
          $response["response_note"]="Problem Processing the reservation Information";
          echo (json_encode($response));
          die();
        }


    }

      break;
  default:
    // code...

    echo "Wrong Request Method";
    break;
}

?>
