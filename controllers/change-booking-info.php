<?php
//initializes sessions
session_start();

//checking for get request from the server
if($_SERVER["REQUEST_METHOD"]="GET"){


  function dateDiff($date1,$date2){
    $diff=strtotime($date2)-strtotime($date1);
    //1 day=24hours
    //24*60*60=86400  seconds
    return(abs(round($diff/(24*60*60))));
  }
//checking  for session variables
  if(isset($_SESSION["sqNumberOfAdult"])&&isset($_SESSION["sqNumberOfChildren"])&&isset($_SESSION["sqDestination"])&&isset($_SESSION["sqCheckinDate"])&&isset($_SESSION["sqCheckoutdate"])){

//checkin for checkin date change request
    if(isset($_GET['checkindateChange'])&&isset($_GET['rate'])&&isset($_GET["tax"])){


    $_SESSION["sqCheckinDate"]=$_GET['checkindateChange'];
    echo "Cost  of Staying ". dateDiff($_SESSION["sqCheckoutdate"],$_SESSION["sqCheckinDate"])." days <br>";
    echo "Rate K".$_GET['rate']." /Night <br>";
    echo "<hr>";
echo"Gross Cost K ". dateDiff($_SESSION["sqCheckoutdate"],$_SESSION["sqCheckinDate"])*$_GET['rate']."<br>";
 echo "+ ".$_GET['tax']." % GST <br>";
   $_SESSION['reservationCost']=dateDiff($_SESSION["sqCheckinDate"],$_SESSION["sqCheckoutdate"])*(float)$_GET['rate']+(($_GET['rate']*(float)$_GET['tax'])/100);
   echo "K ".$_SESSION['reservationCost'];
    }
    //checking for checkout date chage request
    if(isset($_GET['checkoutDateChange'])&&isset($_GET['rate'])&&isset($_GET["tax"])){
    $_SESSION["sqCheckoutdate"]=$_GET['checkoutDateChange'];
    echo "Cost of staying ".

     dateDiff($_SESSION["sqCheckoutdate"],$_SESSION["sqCheckinDate"])." days <br>";
     echo "Rate K".$_GET['rate']." /Night <br>";
     echo "<hr>";
echo"Gross Cost K ". dateDiff($_SESSION["sqCheckoutdate"],$_SESSION["sqCheckinDate"])*$_GET['rate']."<br>";
  echo "+ ".$_GET['tax']." % GST <br>";
    $_SESSION['reservationCost']=dateDiff($_SESSION["sqCheckinDate"],$_SESSION["sqCheckoutdate"])*(float)$_GET['rate']+(($_GET['rate']*(float)$_GET['tax'])/100);
    echo "K ".$_SESSION['reservationCost'];
    }
  }else{
    //session variables  not availabke for processing
    if(isset($_GET["numberOfAdults"])){
      echo $_SESSION["sqNumberOfAdult"];
      $_SESSION["sqNumberOfAdult"]=$_GET["numberOfAdults"];
    }
    if(isset($_GET["numberOfChildren"])){
      $_SESSION["sqNumberOfChildren"]=$_GET["numberOfChildren"];
      echo $_SESSION["sqNumberOfChildren"];
    }
    if(isset($_GET['checkindateChange'])&&isset($_GET['rate'])&&isset($_GET['tax'])){


          $_SESSION["sqCheckinDate"]=$_GET['checkindateChange'];
          echo "Cost  of Staying ". dateDiff($_SESSION["sqCheckoutdate"],$_SESSION["sqCheckinDate"])." days <br>";
          echo "Rate K".$_GET['rate']." /Night <br>";
          echo "<hr>";
      echo"Gross Cost K ". dateDiff($_SESSION["sqCheckoutdate"],$_SESSION["sqCheckinDate"])*$_GET['rate']."<br>";
       echo "+ ".$_GET['tax']." % GST <br>";
         $_SESSION['reservationCost']=dateDiff($_SESSION["sqCheckinDate"],$_SESSION["sqCheckoutdate"])*(float)$_GET['rate']+(($_GET['rate']*(float)$_GET['tax'])/100);
         echo "K ".$_SESSION['reservationCost'];
    }

//

if(isset($_GET['checkoutDateChange'])&&isset($_GET['rate'])&&isset($_GET['tax'])){
  $_SESSION["sqCheckoutdate"]=$_GET['checkoutDateChange'];
  echo "Cost of staying ".

   dateDiff($_SESSION["sqCheckoutdate"],$_SESSION["sqCheckinDate"])." days <br>";
   echo "Rate K".$_GET['rate']." /Night <br>";
   echo "<hr>";
  echo"Gross Cost K ". dateDiff($_SESSION["sqCheckoutdate"],$_SESSION["sqCheckinDate"])*$_GET['rate']."<br>";
  echo "+ ".$_GET['tax']." % GST <br>";
  $_SESSION['reservationCost']=dateDiff($_SESSION["sqCheckinDate"],$_SESSION["sqCheckoutdate"])*(float)$_GET['rate']+(($_GET['rate']*(float)$_GET['tax'])/100);
  echo "K ".$_SESSION['reservationCost'];
}

  }
}else{
  //Get request not avaliable
  echo "Wrong request Method";
}
?>
