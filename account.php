<?php
session_start();
if(isset($_SESSION["logedin"])){
if(isset($_SESSION['account'])&&($_SESSION['account'])=="advanced")
{
include("views/account.layout.php");
  include("controllers/config.php");
  include('controllers/classes/db-class.php');
  $thisdb=new db($h,$u,$pass,$db);
  $conn=$thisdb->connect();

	switch ($_SESSION['accountType']) {
		case 'propertyacc':
					include('controllers/classes/property-class.php');
					$thisProperty=new Property();

					$thisProperty->setPropertyId($_SESSION["account_id"]);
					$proprty=$thisProperty->findProperty($conn);
					if($proprty===FALSE){
						die("Cannot Display Your Property");
					}if($proprty===0){
						echo("Your Property Account Does not Exists");
					}else{
						$page_tittle=$proprty["propertyName"];
						$_SESSION['accountName']=$proprty["propertyName"];
						?>
						<title><?php echo $page_tittle?></title>
						<body>
				<?php
					include('property-account.php');

			}
			break;
		case '':
			echo $_SESSION['accountType'];
			break;
		default:
			header("Location:../");
			break;
}

}else{
	header("Location:../");
}
}else{
	header("Location:../");
}
?>
