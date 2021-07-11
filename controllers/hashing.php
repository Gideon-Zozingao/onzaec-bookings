<?php

function  hashData($data){
  $salt = '2123293dsj2hu2nikhiljdsd';
  $data1 = hash('sha256', $data);
  $hashData = hash('sha256', $salt . $data1);
  return  $hashData;
}
?>
