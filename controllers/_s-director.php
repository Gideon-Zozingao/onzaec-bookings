<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
	if(isset($_POST["destination"])&&isset($_POST["checkinDate"])&&isset($_POST["checkoutdate"])&&isset($_POST["numberOfChildren"])&&isset($_POST["numberOfAdult"])){
			session_start();
			function returnNum($num){
				if(empty($num)){
					return 0;
				}else{
					return $num;
				}
			}
  		$numberOfAdult=intval($_POST["numberOfAdult"]);
  		$numberOfChildren=intval($_POST["numberOfChildren"]);
  		$checkoutdate=$_POST["checkoutdate"];
  		$checkinDate=$_POST["checkinDate"];
  		$destination=$_POST["destination"];
  		//initiating search session variales

  		$_SESSION["sqNumberOfAdult"]=$numberOfAdult;
  		$_SESSION["sqNumberOfChildren"]=$numberOfChildren;
  		$_SESSION["sqDestination"]=$destination;
  		$_SESSION["sqCheckinDate"]=$checkinDate;
  		$_SESSION["sqCheckoutdate"]=$checkoutdate;
		header("Location:../search.accomodations.php?Destination=$_SESSION[sqDestination]");

}else{
		header("Location:../search.accomodations.php");
}

}else{
header("Location:../search.accomodations");
}

?>
