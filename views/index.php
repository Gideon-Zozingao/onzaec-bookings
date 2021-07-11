<?php
if($_SERVER['REQUEST_METHOD']=="GET"||$_SERVER['REQUEST_METHOD']=="POS"||$_SERVER['REQUEST_METHOD']=="FETCH"){
header("Location:../");
}else{
  header("Location:../");
}
?>
