<?php
if(isset($_POST['username'])&&isset($_POST['userPassword'])){
$username=$_POST['username'];
$password=$_POST['userPassword'];
include("config.php");
include("classes/db-class.php");
include("hashing.php");
include("data-sanitiation.php");
$alert=Array("alert_type"=>"","message"=>"");
if($password==""){
  $alert['alert_type']='error';
  $alert['message']='Passwrod Not Entered';
  die(json_encode($alert));
}
if($username==""){
  $alert['alert_type']='error';
  $alert['message']='Username Not Entered';
  die(json_encode($alert));
}
if($password==""&&$username==""){
  $alert['alert_type']='error';
  $alert['message']='User Credentials not Entered';
  die(json_encode($alert));
}
$validUsername=filterName($username);
if($validUsername==FALSE){
  $alert['alert_type']='error';
  $alert['message']='Username formated  you submited  is  not allowed';
  die(json_encode($alert));
}
$thisdb=new db($h,$u,$pass,$db);
$conn=$thisdb->connect();
if(!$conn){
  $alert['alert_type']='error';
  $alert['message']='Error: Cannot  Login Now Due to  Some  Internal  Errors';
  die(json_encode($alert));
}
include("classes/user-class.php");
$thisUser=new User();
$thisUser->setUserName($validUsername);
$thisUser->setUserPassword(hashData($password));
$loginUser=$thisUser->authUSer($conn);
if($loginUser==0||$loginUser==FALSE){
  $alert['alert_type']='error';
  $alert['message']="Incorrect User Credentials ";
  die(json_encode($alert));
}else{
  session_start();
  $_SESSION['logedin']=true;
  $_SESSION['account']='default';
  $_SESSION['id']=$loginUser['userId'];
  $_SESSION['name']=$loginUser['name'];
  $_SESSION['surname']=$loginUser['surname'];
  $_SESSION['userType']=$loginUser['userType'];
  $_SESSION['email']=$loginUser['email'];
  $_SESSION['password']=$loginUser['password'];
  //echo"Loging Successful";
  $alert['alert_type']='success';
  $alert['message']="Loged in Successfully";
  die(json_encode($alert));
}
}else{
  header("Location:../login");
}
?>
