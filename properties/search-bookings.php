<?php

session_start();
//use the configuration file  and file virables
include("../controllers/config.php");
//use the db class and db connection functions
include("../controllers/classes/db-class.php");
$db=new db($h,$u,$pass,$db);
switch ($_SERVER["REQUEST_METHOD"]) {
  case 'GET':
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
  ?>
  <div class="col-md-8 offset-2">
    <form class="" action="" method="post" id="bookingsSearchForm">
      <div class="row">
        <div class="col-md-4">
          <select class="form-control" name="searchByCategory">
            <option value="">Search By</option>
            <option value="customerName">Guest Name</option>
            <option value="customerSurName">Guest Surname</option>
            <option value="customerEmail">Guest Email</option>
            <option value="reservationCode">Reservation Code</option>
          </select>
        </div>
        <div class="col-md-4">
          <input type="text" name="searchQuery" class="form-control">
        </div>
        <div class="col-md-4">
          <button type="submit" class="btn btn-light">SEARCH</button>
        </div>
      </div>
    </form>
  </div>
  <hr>
  <div class="" id="reservationSearcResults">
  </div>
  <script type="text/javascript">
    $(document).ready(()=>{
      $("#bookingsSearchForm").on("submit",function(e){
        e.preventDefault();
        $.ajax({
          url:"properties/search-bookings",
          type:"POST",
          data:new FormData(this),
  				contentType:false,
  				cache:false,
  				processData:false,
          beforeSend:function(){
            $("#reservationSearcResults").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='public/images/loading.gif'></div><div class='col-md-4'></div></div>")
          },
          success:function(data){
            setTimeout(()=>{
              $("#reservationSearcResults").html(data)
            },1500)

          }
        })
      })
    })
  </script>
  <?php
    break;

//processing of POST request
    case 'POST':
    //echo "Post Request";
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
    //recived the form data and preoccess the data
    if(isset($_POST['searchByCategory'])&&isset($_POST['searchQuery'])){
      if(empty($_POST['searchByCategory'])){
        echo "Please Select a Search Category";
        die();
      }
      if(empty($_POST['searchQuery'])){
        echo "Please Type a Search Query";
        die();
      }

      switch ($_POST['searchByCategory']) {
        case 'customerName':
        $bookingsSerachSql="SELECT *FROM bookings JOIN customers ON bookings.customerId=customers.customerId WHERE customers.customerName='$_POST[searchQuery]' AND bookings.propertyId='$_SESSION[account_id]'AND (bookings.reservationStatus='Checked In' OR bookings.reservationStatus='Pending Confirmation')";
        $bookingsSerachQuery=mysqli_query($conn,$bookingsSerachSql);
        if($bookingsSerachQuery==true){
          $bookingsSerachQueryResults=mysqli_num_rows($bookingsSerachQuery);
          if($bookingsSerachQueryResults>0){

            ?>

<table class="table table-striped">
<thead>
  <?php echo $bookingsSerachQueryResults." Results for Your Search"; ?>
</thead>
<tr>
  <th>Name</th>
  <th>Email</th>
  <th>Booked Room</th>
  <th>Checkin</th>
  <th>Checkout</th>
  <th>reservation Code</th>
  <th>Status</th>
</tr>


            <?php
            while($bookingsSerachQueryResults=mysqli_fetch_array($bookingsSerachQuery)){

              $selectRoomQuery=mysqli_query($conn,"SELECT *FROM rooms WHERE roomId='$bookingsSerachQueryResults[roomId]'");
              if($selectRoomQuery==true){

                $selectRoomQueryResultArray=mysqli_fetch_array($selectRoomQuery);
                ?>
                <tr>
                  <td><?php echo $bookingsSerachQueryResults['customerName']; ?>
                    <?php echo $bookingsSerachQueryResults['customerSurname']; ?></td>
                  <td><?php echo $bookingsSerachQueryResults['customerEmail']; ?></td>
                  <td><?php  echo $selectRoomQueryResultArray['roomName']; ?></td>
                  <td><?php  echo $bookingsSerachQueryResults['checkInDate']; ?></td>
                  <td><?php  echo $bookingsSerachQueryResults['checkOutDate']; ?></td>
                  <td>
                    <a href="#" class="reservationDetailsLink" accessKey="<?php  echo $bookingsSerachQueryResults['bookingId']; ?>"><?php  echo $bookingsSerachQueryResults['reservationCode']; ?></a>
                    </td>
                  <td><?php if($bookingsSerachQueryResults['reservationStatus']=="Checked In"){
                    ?><span class="text-success"><?php echo $bookingsSerachQueryResults['reservationStatus'];?></span> <?php
                  }else{
                    ?>
                    <span class="text-warning"><?php echo $bookingsSerachQueryResults['reservationStatus'];?></span>
                    <?php
                  }  ?></td>
                </tr>
                <p> </p>

                <?php


              }else{
                echo mysqli_error($conn);
              }
            }
            ?>
            </table>

            <?php

          }else{
            echo "<h5 class='text-center text-muted'>No Results  available for Your Search</h5>";
          }
        }else{
          echo mysqli_error($conn);
        }
          break;
        case 'customerSurName':
        $bookingsSerachSql="SELECT *FROM bookings JOIN customers ON bookings.customerId=customers.customerId WHERE customers.customerSurname='$_POST[searchQuery]' AND bookings.propertyId='$_SESSION[account_id]' AND (bookings.reservationStatus='Checked In' OR bookings.reservationStatus='Pending Confirmation')";
        $bookingsSerachQuery=mysqli_query($conn,$bookingsSerachSql);
        if($bookingsSerachQuery==true){
          $bookingsSerachQueryResults=mysqli_num_rows($bookingsSerachQuery);
          if($bookingsSerachQueryResults>0){

            ?>

<table class="table table-striped">
<thead>
  <?php echo $bookingsSerachQueryResults." Results for Your Search"; ?>
</thead>
<tr>
  <th>Name</th>
  <th>Email</th>
  <th>Booked Room</th>
  <th>Checkin</th>
  <th>Checkout</th>
  <th>reservation Code</th>
  <th>Status</th>
</tr>


            <?php
            while($bookingsSerachQueryResults=mysqli_fetch_array($bookingsSerachQuery)){

              $selectRoomQuery=mysqli_query($conn,"SELECT *FROM rooms WHERE roomId='$bookingsSerachQueryResults[roomId]'");
              if($selectRoomQuery==true){

                $selectRoomQueryResultArray=mysqli_fetch_array($selectRoomQuery);
                ?>
                <tr>
                  <td><?php echo $bookingsSerachQueryResults['customerName']; ?>
                    <?php echo $bookingsSerachQueryResults['customerSurname']; ?></td>
                  <td><?php echo $bookingsSerachQueryResults['customerEmail']; ?></td>
                  <td><?php  echo $selectRoomQueryResultArray['roomName']; ?></td>
                  <td><?php  echo $bookingsSerachQueryResults['checkInDate']; ?></td>
                  <td><?php  echo $bookingsSerachQueryResults['checkOutDate']; ?></td>
                  <td>
                    <a href="#" class="reservationDetailsLink" accessKey="<?php  echo $bookingsSerachQueryResults['bookingId']; ?>"><?php  echo $bookingsSerachQueryResults['reservationCode']; ?></a>
                    </td>
                  <td><?php if($bookingsSerachQueryResults['reservationStatus']=="Checked In"){
                    ?><span class="text-success"><?php echo $bookingsSerachQueryResults['reservationStatus'];?></span> <?php
                  }else{
                    ?>
                    <span class="text-warning"><?php echo $bookingsSerachQueryResults['reservationStatus'];?></span>
                    <?php
                  }  ?></td>
                </tr>
                <p> </p>

                <?php


              }else{
                echo mysqli_error($conn);
              }
            }
            ?>
            </table>

            <?php

          }else{

            echo "<h5 class='text-center text-muted'>No Results  available for Your Search</h5>";
          }
        }else{
          echo mysqli_error($conn);
        }
          break;


        case 'customerEmail':
        $bookingsSerachSql="SELECT *FROM bookings JOIN customers ON bookings.customerId=customers.customerId WHERE customers.customerEmail='$_POST[searchQuery]' AND bookings.propertyId='$_SESSION[account_id]' AND (bookings.reservationStatus='Checked In' OR bookings.reservationStatus='Pending Confirmation')";
        $bookingsSerachQuery=mysqli_query($conn,$bookingsSerachSql);
        if($bookingsSerachQuery==true){
          $bookingsSerachQueryResults=mysqli_num_rows($bookingsSerachQuery);
          if($bookingsSerachQueryResults>0){

            ?>

<table class="table table-striped">
<thead>
  <?php echo $bookingsSerachQueryResults." Results for Your Search"; ?>
</thead>
<tr>
  <th>Name</th>
  <th>Email</th>
  <th>Booked Room</th>
  <th>Checkin</th>
  <th>Checkout</th>
  <th>reservation Code</th>
  <th>Status</th>
</tr>


            <?php
            while($bookingsSerachQueryResults=mysqli_fetch_array($bookingsSerachQuery)){

              $selectRoomQuery=mysqli_query($conn,"SELECT *FROM rooms WHERE roomId='$bookingsSerachQueryResults[roomId]'");
              if($selectRoomQuery==true){

                $selectRoomQueryResultArray=mysqli_fetch_array($selectRoomQuery);
                ?>
                <tr>
                  <td><?php echo $bookingsSerachQueryResults['customerName']; ?>
                    <?php echo $bookingsSerachQueryResults['customerSurname']; ?></td>
                  <td><?php echo $bookingsSerachQueryResults['customerEmail']; ?></td>
                  <td><?php  echo $selectRoomQueryResultArray['roomName']; ?></td>
                  <td><?php  echo $bookingsSerachQueryResults['checkInDate']; ?></td>
                  <td><?php  echo $bookingsSerachQueryResults['checkOutDate']; ?></td>
                  <td>
                    <a href="#" class="reservationDetailsLink" accessKey="<?php  echo $bookingsSerachQueryResults['bookingId']; ?>"><?php  echo $bookingsSerachQueryResults['reservationCode']; ?></a>
                    </td>
                  <td><?php if($bookingsSerachQueryResults['reservationStatus']=="Checked In"){
                    ?><span class="text-success"><?php echo $bookingsSerachQueryResults['reservationStatus'];?></span> <?php
                  }else{
                    ?>
                    <span class="text-warning"><?php echo $bookingsSerachQueryResults['reservationStatus'];?></span>
                    <?php
                  }  ?></td>
                </tr>
                <p> </p>

                <?php


              }else{
                echo mysqli_error($conn);
              }
            }
            ?>
            </table>

            <?php

          }else{
            echo "<h5 class='text-center text-muted'>No Results  available for Your Search</h5>";
          }
        }else{
          echo mysqli_error($conn);
        }
          break;
        case 'reservationCode':
        $bookingsSerachSql="SELECT *FROM bookings JOIN customers ON bookings.customerId=customers.customerId WHERE bookings.reservationCode='$_POST[searchQuery]' AND bookings.propertyId='$_SESSION[account_id]'AND (bookings.reservationStatus='Checked In' OR bookings.reservationStatus='Pending Confirmation')";
        $bookingsSerachQuery=mysqli_query($conn,$bookingsSerachSql);
        if($bookingsSerachQuery==true){
          $bookingsSerachQueryResults=mysqli_num_rows($bookingsSerachQuery);
          if($bookingsSerachQueryResults>0){

            ?>

<table class="table table-striped">
<thead>
  <?php echo $bookingsSerachQueryResults." Results for Your Search"; ?>
</thead>
<tr>
  <th>Name</th>
  <th>Email</th>
  <th>Booked Room</th>
  <th>Checkin</th>
  <th>Checkout</th>
  <th>reservation Code</th>
  <th>Status</th>
</tr>


            <?php
            while($bookingsSerachQueryResults=mysqli_fetch_array($bookingsSerachQuery)){

              $selectRoomQuery=mysqli_query($conn,"SELECT *FROM rooms WHERE roomId='$bookingsSerachQueryResults[roomId]'");
              if($selectRoomQuery==true){

                $selectRoomQueryResultArray=mysqli_fetch_array($selectRoomQuery);
                ?>
                <tr>
                  <td><?php echo $bookingsSerachQueryResults['customerName']; ?>
                    <?php echo $bookingsSerachQueryResults['customerSurname']; ?></td>
                  <td><?php echo $bookingsSerachQueryResults['customerEmail']; ?></td>
                  <td><?php  echo $selectRoomQueryResultArray['roomName']; ?></td>
                  <td><?php  echo $bookingsSerachQueryResults['checkInDate']; ?></td>
                  <td><?php  echo $bookingsSerachQueryResults['checkOutDate']; ?></td>
                  <td>
                    <a href="#" class="reservationDetailsLink" accessKey="<?php  echo $bookingsSerachQueryResults['bookingId']; ?>"><?php  echo $bookingsSerachQueryResults['reservationCode']; ?></a>
                    </td>
                  <td><?php if($bookingsSerachQueryResults['reservationStatus']=="Checked In"){
                    ?><span class="text-success"><?php echo $bookingsSerachQueryResults['reservationStatus'];?></span> <?php
                  }else{
                    ?>
                    <span class="text-warning"><?php echo $bookingsSerachQueryResults['reservationStatus'];?></span>
                    <?php
                  }  ?></td>
                </tr>
                <p> </p>

                <?php


              }else{
                echo mysqli_error($conn);
              }
            }
            ?>
            </table>

            <?php
          }else{
            echo "<h5 class='text-center text-muted'>No Results  available for Your Search</h5>";
          }
        }else{
          echo mysqli_error($conn);
        }
          break;

        default:
          // code...
          echo "Incorrect Search Parameter";
          break;
      }
    }
    ?>
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
      break;


  default:
    echo "Wrong Request Method";
    break;
}


 ?>
