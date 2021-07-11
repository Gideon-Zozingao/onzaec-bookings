<?php

session_start();

if(isset($_SESSION['logedin'])){
  if(isset($_SESSION["account_id"])&&isset($_SESSION['account'])&&isset($_SESSION['accountType'])&&isset($_SESSION['userType'])){
    $_SESSION["account_id"]=null;
    $_SESSION['account']=null;
    $_SESSION['accountType']=null;
      header("Location:account.switch.php");
  }else{
header("Location:account.switch.php");
  }
}else{
  header("Location./");
}

?>
