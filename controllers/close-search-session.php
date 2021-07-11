<?php
session_start();

/*
$_SESSION["sqNumberOfAdult"];
$_SESSION["sqNumberOfChildren"];
$_SESSION["sqDestination"];
$_SESSION["sqCheckinDate"];
$_SESSION["sqCheckoutdate"];
*/
$message=Array("message_type"=>"","message"=>"");
if(isset($_SESSION["sqNumberOfAdult"])&&isset($_SESSION["sqNumberOfChildren"])&&isset($_SESSION["sqDestination"])&&isset($_SESSION["sqCheckinDate"])&&isset($_SESSION["sqCheckoutdate"])){
  $_SESSION["sqNumberOfAdult"]=null;
  $_SESSION["sqNumberOfChildren"]=null;
  $_SESSION["sqDestination"]=null;
  $_SESSION["sqCheckinDate"]=null;
  $_SESSION["sqCheckoutdate"]=null;
  //$message=Array("message_type"=>"","message"=>"");
  $message['message_type']="success";
  $message['message']="Search session Closed";
  echo json_encode($message);
}else{
  $message['message_type']="error";
  $message['message']="No search  sessions";
  echo json_encode($message);
}
?>
