<?php
session_start();
$alert=Array("alert_type"=>"","message"=>"");
if(isset($_SESSION['logedin'])){
if(isset($_POST["property-name"])){
	include("config.php");
	include("classes/db-class.php");
	include("data-sanitiation.php");

	$dbConnect=new db($h,$u,$pass,$db);
	$connect=$dbConnect->connect();
if(!$connect){
	$alert["alert_type"]="error";
	$alert["message"]="Cannot Perform transactions. Connection failed";
	echo(json_encode($alert));
	die();
}
	$propertyName=$_POST["property-name"];
	$propertyType=$_POST["property-type"];
	$country=$_POST["country"];
	$location=$_POST["location"];
	$address=$_POST["address"];
	$email=$_POST["email"];
	$phone=$_POST["phone"];
	$rateIntervals=$_POST["rate-interval"];
	$maxRate=(float)$_POST["max-rate"];
	$minRate=(float)$_POST["min-rate"];
	$propertyDescription=$_POST["property-description"];
	$numberOfAssets=(int)$_POST["number-of-assets"];
$propertylink=str_replace(" ",'-',$_POST["property-name"]);
	if($propertyName==""){
		$alert['alert_type']="error";
		$alert["message"]="Property Name Missing";
		die(json_encode($alert));
	}
	if($propertyType==""){
		$alert['alert_type']="error";
		$alert["message"]="Property Type is e required";
		die(json_encode($alert));
	}
	if($country==""){
		$alert['alert_type']="error";
		$alert["message"]="Country Field Missing";
		die(json_encode($alert));
	}
	if($location==""){
		$alert['alert_type']="error";
		$alert["message"]="Location Missing";
		die(json_encode($alert));
	}
	if($address==""){
		$alert['alert_type']="error";
		$alert["message"]="Address Mising";
		die(json_encode($alert));
	}
	if($rateIntervals==""){
		$alert['alert_type']="error";
		$alert["message"]="Rate Intervals is blank";
		die(json_encode($alert));
	}
	if($numberOfAssets==""){
$alert['alert_type']="error";
		$alert["message"]="Number of Assets Missing";
		die(json_encode($alert));
	}
	if(!is_int($numberOfAssets)){
		$alert['alert_type']="error";
		$alert["message"]=$numberOfAssets." for number of assets is not correct";
		die(json_encode($alert));
	}
	if($maxRate==""){
		$alert['alert_type']="error";
		$alert["message"]="Max rate Field is empty";
		die(json_encode($alert));
	}
	if(!is_float($maxRate)){
		$alert['alert_type']="error";
		$alert["message"]=$maxRate." for Max Rate is not correct";
		die(json_encode($alert));
	}
	if($minRate==""){
		$alert['alert_type']="error";
		$alert["message"]="Min rate field is empty";
		die(json_encode($alert));
	}
	if(!is_float($minRate)){
		$alert['alert_type']="error";
		$alert["message"]="Wrong input for Min Rate";
		die(json_encode($alert));
	}
	$validPropName=filterName($propertyName);
	if($validPropName==FALSE){
		$alert['alert_type']="error";
		$alert["message"]="Invalid Property name Input";
		die(json_encode($alert));
	}
	$valiCountry=filterName($country);
	if($valiCountry==FALSE){
		$alert['alert_type']="error";
		$alert["message"]="Invalid Country Name input";
		die(json_encode($alert));
	}
	$validLocation=filterString($location);
	if($validLocation==FALSE){
		$alert['alert_type']="error";
		$alert["message"]="Invalid Location name input";
		die(json_encode($alert));
	}
	$validaddress=filterString($address);
	if($validaddress==FALSE){
		$alert['alert_type']="error";
		$alert["message"]="Invalid Address Input";
		die(json_encode($alert));
	}
	$validEmail=filterEmail($email);
	if($validEmail==FALSE){
		$alert['alert_type']="error";
		$alert["message"]="Invalid email Format";
		die(json_encode($alert));
	}
if($connect){
	include("classes/property-class.php");
	include('classes/account-class.php');
$myAccount=new Account();

$myAccount->setAccId(date("YmdHis"));
$myAccount->setAccoutOwnerId($_SESSION['id']);
$myAccount->setAccountName($validPropName);
$myAccount->setAccountType("propertyacc");
$myAccount->setRegistrationDate(date("Y-m-d"));
$myAccount->setUserType("admin");
$myAccount->setAccountStatus("Active");
$property=new Property();
$property->setPropertyId(date("YmdHis"));
  $property->setPropertyName($validPropName);
  $property->setPropertyType($propertyType);
  $property->setCountry($valiCountry);
  $property->setLocation($validLocation);
   $property->setAddress($validaddress);
  $property->setOwerPhone($phone);
  $property->setOwnerEmail($validEmail);
  $property->setNumOfAssets($numberOfAssets);
  $property->setMaxAssetRate($maxRate);
  $property->setMinAssetRate($minRate);
  $property->setAssetRateInterval($rateIntervals);
  $property->setPropertyLink(strtolower($propertylink));
  $property->setOwerId($_SESSION['id']);
  $property->setRegistrationDate(date("Y/m/d"));
  $property->setpropertyDescription($propertyDescription);
  $property->setPropertyLogo("");
  $property->setGeoLocCoordinates("");
  $propLink=$property->findPropertyLink($connect);
  $propName=$property->findPropertyName($connect);
  if($propName!==0&&$propName!==FALSE){
		$alert['alert_type']="error";
		$alert["message"]="Property name already Registered";
		die(json_encode($alert));
  }

	$myAcc=$myAccount->createAccount($connect);
	if($myAcc===true){
	}else{
		$alert['alert_type']="error";
		$alert["message"]="Cannot Register Your Property.	Property Account Creation failed ";
		die(json_encode($alert));
	}
  if($propLink!==0&&$propLink==FALSE){
  	$newPropLink=$propLink.".".$property->getLocation();
  	$property->setPropertyLink(strtolower($newPropLink));
  	$reg=$property->listProperty($connect);
	if($reg==true){
		$alert['alert_type']="success";
		$alert["message"]="Your Property is Successfully Listed";
		die(json_encode($alert));
	}else{
		echo $reg;
	}
  }else{
  	$reg=$property->listProperty($connect);
	if($reg==true){
		$alert['alert_type']="success";
		$alert["message"]="Your Property is Successfully Listed";
		die(json_encode($alert));
	}else{
		echo $reg;
	}
  }
}else{
	$alert['alert_type']="error";
	$alert["message"]="Cannot	REgister	Due	to	Some	Internal	Error";
	die(json_encode($alert));
}
}else{
		header("Location:../property-listing");
}
} else{
		$alert['alert_type']="error";
	$alert["message"]="You	are	loged	in";
	die(json_encode($alert));
}
?>
