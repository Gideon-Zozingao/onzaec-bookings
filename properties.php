<?php
session_start();

include("controllers/config.php");
include("controllers/classes/db-class.php");
include("views/layout.php");
$dbobj=new db($h,$u,$pass,$db);
$conn=$dbobj->connect();
if(!$conn){
  die("Connetion Not Established");
}
switch ($_SERVER["REQUEST_METHOD"]) {
  case 'GET':
  if(isset($_REQUEST["Propertylink"])){
    if(isset($_GET["feature"])){
      echo $_GET["feature"];
    }else{
      include("views/view-property.php");
    }
  }else{
    include('views/default-property-page.php');
  }
    // code...
    break;
    case 'POST':
      // code...
      break;
  default:
    // code...
    break;
}

?>
