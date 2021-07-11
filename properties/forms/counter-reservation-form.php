<?php
session_start();
//use the configuration file  and file virables
include("../../controllers/config.php");

//use the db class and db connection functions
include("../../controllers/classes/db-class.php");

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
    // reciveing of checkin request
    if(isset($_GET['roomid'])){
      echo "Cheking in at ".$_GET['roomid'];

      die();
    }
    //
    break;
    case 'POST':
      // code...
      break;
  default:
    // code...
    break;
}
?>
