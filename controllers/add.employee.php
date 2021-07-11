<?php
session_start();
if(isset($_SESSION['logedin'])&&$_SESSION['logedin']==true){
if($_SERVER["REQUEST_METHOD"]=="POST"&&isset($_POST["employeeRegButton"])){
		$name=$_POST["empName"];//empployee	Name
		$surName=$_POST["empSurName"];//empSurName
		$email=$_POST["empEmail"];//empEmail
		$password=$_POST["empDefaultPassword"];//empDefaultPassword

		function	returnPostedDate($posted){
				if(isset($posted)){
				$data=$posted;
					return$data;
		}else{
				return	null;
			}
		}

		$createAndManageRooms=returnPostedDate($_POST['createAndManageRooms']);
		$createAndManageSerices=returnPostedDate($_POST['createAndManageSerices']);//
		$createAndManageFacilities=returnPostedDate($_POST['createAndManageFacilities']);//
		$manageBookings=returnPostedDate($_POST['manageBookings']);//
		$sendNewsLetters=returnPostedDate($_POST['sendNewsLetters']);//
		$createandManagePromotionsAndAds;
		$createAndManageEvents;/
		$writePropertyNews;//
}else{
		header("Location:../account?action=add&a?=employee");
}
}else{
		header("Location:../");
}


?>
