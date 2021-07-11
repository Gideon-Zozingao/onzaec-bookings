<?php
session_start();
if($_SERVER["REQUEST_METHOD"]=="POST"){

  $alert=Array('alert_type'=>'','message'=>'');

  $validExtensions = Array("jpeg", "jpg", "png");

if(isset($_POST['siteTitle'])&&isset($_POST['siteSubTitle'])&&isset($_POST['propertyType'])&&isset($_POST['country'])&&isset($_POST['propertyLocation'])&&isset($_POST['propertyAddress'])&&isset($_POST['reservationPhone'])&&isset($_POST['reservationEmail'])&&isset($_POST['siteDescription'])
&&isset($_POST['numberOfRoom'])&&isset($_POST['minRoomRate'])&&isset($_POST["geoCoords"])
&&isset($_POST['maxRoomRate'])&&isset($_POST['rateIntervals'])&&isset($_FILES['propSisteCoverImage']['name'])){
  include("config.php");
  include("classes/db-class.php");
  include("data-sanitiation.php");
  $dbConnect=new db($h,$u,$pass,$db);
  $connect=$dbConnect->connect();
  include("classes/property-site-profile-class.php");
  if(empty($_POST['siteTitle']))
  {
    $alert['alert_type']="error";
    $alert['message']="Site Title Missing";
    die(json_encode($alert));
  }
  if(filterName($_POST['siteTitle'])===FALSE){
    $alert['alert_type']="error";
    $alert['message']="Invalid Site Title Input";
    die(json_encode($alert));
  }
  if(empty($_POST['propertyType'])){
    $alert['alert_type']="error";
    $alert['message']="Property Type Field Missing";
    die(json_encode($alert));
  }
  if(empty($_POST['country'])){
    $alert['alert_type']="error";
    $alert['message']="Country Missing";
    die(json_encode($alert));
  }
  if(empty($_POST['propertyLocation'])){
    $alert['alert_type']="error";
    $alert['message']="Location Missing";
    die(json_encode($alert));
  }
  if(empty($_POST['propertyAddress'])){
    $alert['alert_type']="error";
    $alert['message']="Address missing";
    die(json_encode($alert));
  }
  if(empty($_POST['reservationPhone'])){
    $alert['alert_type']="error";
    $alert['message']="Reservation Phone  number missing";
    die(json_encode($alert));
  }
  if(empty($_POST['reservationEmail'])){
    $alert['alert_type']="error";
    $alert['message']="Reservation Email mising";
    die(json_encode($alert));
  }
  if(filterEmail($_POST['reservationEmail'])===FALSE){
    $alert['alert_type']="error";
    $alert['message']="Invalid Email format";
    die(json_encode($alert));
  }
  if(empty($_POST['numberOfRoom'])){
    $alert['alert_type']="error";
    $alert['message']="Number of Rooms field is Empty";
    die(json_encode($alert));
  }
  if(empty($_POST['minRoomRate'])){
    $alert['alert_type']="error";
    $alert['message']="Minimum Room Rate is missing";
    die(json_encode($alert));
  }
  if(empty($_POST['maxRoomRate'])){
    $alert['alert_type']="error";
    $alert['message']="Maximum Room Rate is missing";
    die(json_encode($alert));
  }
  if(empty($_POST['rateIntervals'])){
    $alert['alert_type']="error";
    $alert['message']="Room Rates Intervals is Missing";
    die(json_encode($alert));
  }

$siteProfile=new PropertySiteProfile();
$siteProfile->setSiteProfileId(date("YmdHis"));
 $siteProfile->setPropertyId($_SESSION["account_id"]);
 $siteProfile->setPropertyHeading($_POST['siteTitle']); $siteProfile->setSiteProfileSubheading($_POST['siteSubTitle']);
 $siteProfile->setPropertyAddress($_POST['propertyAddress']);
 $siteProfile->setPropertyEmail($_POST['reservationEmail']);
$siteProfile->setPropertyPhone($_POST['reservationPhone']);
$siteProfile->setPropertyMapInfo($_POST["geoCoords"]);

  if($_FILES['propSisteCoverImage']['name']!==""){
    $temp=explode(".",$_FILES['propSisteCoverImage']["name"]);
    if(!in_array(end($temp),$validExtensions)){
      $alert['alert_type']="error";
      $alert['message']="Please upload  a valid Image File [jpg,jpeg  or  PNG file]";
      die(json_encode($alert));
    }
    $newFileName="ONZAEC-IMG".date("YmdHis").round(microtime(true)).".".end($temp);
    $upload=move_uploaded_file($_FILES['propSisteCoverImage']["tmp_name"],"../public/gallery/images/".$newFileName);
    if(!$upload){
      $alert['alert_type']="error";
      $alert['message']="Site Updates Failed. File Uploda Error";
      die(json_encode($alert));
    }
  $siteProfile->setPropertyCoverPhoto($newFileName);
  $createProfile=$siteProfile->createSiteProfile($connect);
  if($createProfile==true){
    $alert['alert_type']="success";
    $alert['message']="Profile Updated successfuly with Cover Photo";
    die(json_encode($alert));
  }else{
    $alert['alert_type']="error";
    $alert['message']="Profile Updates  with Cover Image failed";
    die(json_encode($alert));
  }
  }else{
    $siteProfile->setPropertyCoverPhoto($_FILES['propSisteCoverImage']);
    $createProfile=$siteProfile->createSiteProfile($connect);
    if($createProfile==true){
      $alert['alert_type']="success";
      $alert['message']="Profile Updated successfuly without Cover Photo";
      die(json_encode($alert));
    }else{
      $alert['alert_type']="error";
      $alert['message']="Profile Updates failed:";
      die(json_encode($alert));
    }
  }
  $alert['alert_type']="success";
  $alert['message']="Form Submission recived";
  die(json_encode($alert));
}else{
  $alert['alert_type']="error";
  $alert['message']="Invalid form data Submission";
  die(json_encode($alert));
}

}
?>
