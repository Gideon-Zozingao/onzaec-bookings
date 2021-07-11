<?php
session_start();
if(isset($_POST["userType"])){
    include('hashing.php');
    $to=$_POST['to'];
    $utype=$_POST['userType'];
    $accountType=$_POST["accountType"];
    $passwd=hashData($_POST["password"]);
    $alert=Array("alert_type"=>"","message"=>"","accountType"=>"");
    if($passwd===$_SESSION['password']){
      $_SESSION["account_id"]=$to;
      $_SESSION['logedin']=true;
      $_SESSION['account']='advanced';
      $_SESSION['accountType']=$accountType;
      $_SESSION['userType']=$utype;
    $alert["alert_type"]="success";
    $alert["message"]="Password Confirmation Sccuessful";
    switch ($_SESSION['accountType']) {
      case 'useracc':
    $alert["accountType"]="useracc";
    echo(josn_encode($alert));
    die();
        break;
        case 'propertyacc':
        $alert["accountType"]="propertyacc";
        echo(json_encode($alert));
        die();
          break;
      default:
        // code...
        break;
    }
    }else{
    $alert["alert_type"]="error";
    $alert["message"]="Wrong Password";
    $alert["accountType"]="default";
    echo(json_encode($alert));
    die();
}
}else{
  header("Location:../");
}
?>
