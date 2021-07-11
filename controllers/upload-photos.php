<?php
session_start();
include("config.php");
include("classes/db-class.php");
$dbConnect=new db($h,$u,$pass,$db);
$connect=$dbConnect->connect();
$alert=Array('alert_type'=>'','message'=>'');
if($_SERVER["REQUEST_METHOD"]=="POST"){
  if(isset($_FILES['propertyPhoto'])){
    $validExtensions = Array("jpeg", "jpg", "png");

    if($_FILES['propertyPhoto']['name']!==""){
      $temp=explode(".",$_FILES['propertyPhoto']["name"]);
      if(!in_array(end($temp),$validExtensions)){
        $alert['alert_type']="error";
        $alert['message']="Please upload  a valid Image File [jpg,jpeg  or  PNG file]";
        die(json_encode($alert));
      }
      $newFileName="ONZAEC-IMG".date("YmdHis").round(microtime(true)).".".end($temp);
      $upload=move_uploaded_file($_FILES['propertyPhoto']["tmp_name"],"../public/gallery/images/".$newFileName);
      if($upload==true){
        $uploadDate=date("Y-m-d-H-i-s");
        $phId=date("YmdHis");
        $sql="INSERT  INTO  propertyphotos(photoId,photoName,propertyId,photoAltext,creattionDate) VALUES('$phId','$newFileName','$_SESSION[account_id]','Onzaec-Photos',$uploadDate)";
          $query=mysqli_query($connect,$sql);
          if($query==true){
                        $alert['alert_type']="success";
                        $alert['message']="Photo Uploaded Successfully";
                        echo(json_encode($alert));
          }else{
            $alert['alert_type']="error";
            $alert['message']="Photo cannot be Uploaded due to Some technical Faults ".mysqli_error($connect);
            die(json_encode($alert));
          }
      }else{
        $alert['alert_type']="error";
        $alert['message']="Unable  to  Upload  Photo";
        die(json_encode($alert));
      }
    }else{
      $alert['alert_type']="error";
      $alert['message']="No Photo Inserted ";
      die(json_encode($alert));
    }
  }else{
    $alert['alert_type']="error";
    $alert['message']="Wrong Request";
    die(json_encode($alert));
  }
}else{
  $alert['alert_type']="error";
  $alert['message']="Unknow  Error";
  die(json_encode($alert));
}
?>
