<?php
session_start();
if(isset($_SESSION["logedin"])&&$_SESSION["logedin"]===true){
if($_SESSION["accountType"]==="propertyacc"){

  if($_SERVER["REQUEST_METHOD"]==="POST"){
    include("config.php");
  	include("classes/db-class.php");
  	include("data-sanitiation.php");
    include("classes/room-class.php");
    $room=new Room();
    $dbConnect=new db($h,$u,$pass,$db);
  	$connect=$dbConnect->connect();
    $alert=Array('msg_type'=>'','message'=>'');
    //check for file  existence
    if(isset($_FILES['cover_photo'])){
      //allowed file  extensions
      $validExtensions = Array("jpeg", "jpg", "png");
//check for form  submision
if(empty($_POST["roomname"])&&empty($_POST["roomcategory"])&&empty($_POST["floor"])&&empty($_POST["numbber_of_people"])&&empty($_POST["number_of_beds"])&&empty($_POST["bed_size"])&&empty($_POST["rate"])){
   $alert['msg_type']="error";
        $alert['message']="You Haven't filled out the form";
        die(json_encode($alert));
  }
      if($_POST["roomname"]==""){
        $alert['msg_type']="error";
        $alert['message']="Please Fill  in  the Room  name  Field";
        die(json_encode($alert));
      }$validRoomName=filterName($_POST["roomname"]);
      if($validRoomName==FALSE){
        $alert['msg_type']="error";
        $alert['message']="Invalid room name input";
        die(json_encode($alert));
      }
      if($_POST["roomcategory"]==""){
        $alert['msg_type']="error";
        $alert['message']="Please Fill  in  the Room  Catagory  Field";
        die(json_encode($alert));
      }
      $valiRoomCat=filterName($_POST["roomcategory"]);
      if($valiRoomCat==FALSE){
        $alert['msg_type']="error";
        $alert['message']="Invalid Room Caetegory Input";
        die(json_encode($alert));
      }
      $floor=(int)$_POST["floor"];
      if($floor==""){
        $alert['msg_type']="error";
        $alert['message']="Please Fill  in  the Floor number  of  the room";
        die(json_encode($alert));
      }
      $people=(int)$_POST["numbber_of_people"];
      if($people==""){
        $alert['msg_type']="error";
        $alert['message']="Please fill  in  the nubmer of  people  field";
        die(json_encode($alert));
      }

      $beds=(int)$_POST["number_of_beds"];
      if($beds==""){
        $alert['msg_type']="error";
        $alert['message']="Please fill  in  the number  of  beds  the room  has";
        die(json_encode($alert));
      }
      $bedSize=(float)$_POST["bed_size"];
      if($bedSize==""){
        //die();
        $alert['msg_type']="error";
        $alert['message']="Bed  size  is  missing";
        die(json_encode($alert));
      }
      $rate=(float)$_POST["rate"];
      if($rate==""){
        $alert['msg_type']="error";
        $alert['message']="Please fill  in  the Rate  field";
        die(json_encode($alert));
      }
      $gst=(float)$_POST["gst"];
      if($gst==""){
        $alert['msg_type']="error";
        $alert['message']="Please fill  in  the GST field";
        die(json_encode($alert));
      }

      $temp=explode(".",$_FILES["cover_photo"]["name"]);
      if(!in_array(end($temp),$validExtensions)){
        $alert['msg_type']="error";
        $alert['message']="Please upload  a valid Image File [jpg,jpeg  or  PNG file]";
        die(json_encode($alert));
      }
      $newFileName="ONZAEC-IMG".date("YmdHis").round(microtime(true)).".".end($temp);
      $upload=move_uploaded_file($_FILES['cover_photo']["tmp_name"],"../public/gallery/images/".$newFileName);
      if($upload!==true){
        $alert['msg_type']="error";
        $alert['message']="Room Registraion Did not Succeed.<br>Encountered an  error uploading the Cover Image.";
        die(json_encode($alert));
      }
       $room->setRoomId(date("Ymd").round(microtime(true)));
       $room->setRoomName($_POST["roomname"]);
       $room->setRoomCategory($_POST["roomcategory"]);
       $room->setFloorNumber($floor);
       $room->setRoomCapacity($people);
       $room->setNumberOfBed($beds);
       $room->setBedSize($bedSize);
       $room->setFacilities($_POST['additional_features']);
       $room->setPrice($rate);
       $room->setTax($gst);
       $room->setavailabilityStatus("Available");
       $room->setavaialibiltyDate(date("Y-m-d"));
       $room->setroomDescription($_POST["room_description"]);
       $room->setRoomCoverPhoto($newFileName);
       $room->setpropertyId($_SESSION["account_id"]);
       $room->setPubblicationStatus($_POST['publication_status']);
       $addRoom=$room->addRoom($connect);
       if($addRoom==true){
         $alert['msg_type']="success";
         $alert['message']="Room  Regsitration  Sucessful";
         echo(json_encode($alert));
       }else{
         $alert['msg_type']="error";
         $alert['message']="Room Registration  was not Successful";
         echo(json_encode($alert));
       }
    }else{
      $alert['msg_type']="error";
      $alert['message']="Cover  Photo not attached";
      echo(json_encode($alert));
    }
  }else{
    header("Location:../account.php");
  }
}else{
header("Location:../accouny.switch");
}
}else{
  header("Location:../");
}
?>
