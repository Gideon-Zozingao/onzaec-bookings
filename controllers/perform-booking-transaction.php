<?php
session_start();
$respose=Array("respose_type"=>"","respose_message"=>"","reseponese_note"=>"");
if(isset($_SESSION["sqNumberOfAdult"])&&isset($_SESSION["sqNumberOfChildren"])&&isset($_SESSION["sqDestination"])&&isset($_SESSION["sqCheckinDate"])&&isset($_SESSION["sqCheckoutdate"])&&isset($_SESSION['reservationCost'])){
  include("config.php");
  include("classes/db-class.php");
  include("data-sanitiation.php");
  //inintialize the connection Objet
  $db=new db($h,$u,$pass,$db);
  //atempt the  database connecction
  $conn=$db->connect();

  //validate the conection
  if(!$conn){
    //$respose=Array("respose_type"=>"","respose_message"=>"","reseponese_note"=>"");
    $respose["respose_type"]="error";
    $respose["respose_message"]="Transactions Cannot Be Performed at this time";
    $respose['reseponese_note']="Connection Failed";
    echo(json_encode($respose));
    die();
  }

//switch between the Server request Methods
  switch ($_SERVER["REQUEST_METHOD"]) {
    case 'POST':
    //varifying  annd sanitizing data
    //customer's name must be presnet for the booking transaction to be completed

      //include the config file and  use the functions within  the files
      include("classes/booking-class.php");
      include("classes/customer-class.php");
      include("classes/room-class.php");
    if(empty($_POST["checkInDate"])){

      //$alert=Array("alert_type"=>"","message"=>"");
      $alert["respose_type"]="error";
      $alert["respose_type"]="Checkin Date Field is Empty";
      echo(json_encode($alert));
      die();
    }

    if(empty($_POST["checkOutDate"])){

      $alert["respose_type"]="error";
      $alert["respose_message"]="Checkout Date Field is Empty";
      echo(json_encode($alert));
      die();
    }

    if(empty($_POST["custname"])){
      $alert["respose_type"]="error";
      $alert["respose_message"]="Name field is Empty";
      echo(json_encode($alert));
      die();
    }
    if(empty($_POST["custsurname"])){


      $alert["respose_type"]="error";
      $alert["respose_message"]="Surname field is Empty";
      echo(json_encode($alert));
      die();
    }
    if(empty($_POST["country"])){

      $alert["respose_type"]="error";
      $alert["respose_message"]="Country field is Empty";
      echo(json_encode($alert));
      die();
    }

    if(empty($_POST["age"])){
      $alert["respose_type"]="error";
      $alert["respose_message"]="Age field is Empty";
      echo(json_encode($alert));
      die();
    }
    $age=(int)$_POST["age"];
    if(!is_int($age)){
      $alert["respose_type"]="error";
      $alert["respose_message"]="Wrong Age Input";
      echo(json_encode($alert));
      die();

    }

    if(empty($_POST["phone"])){

      $alert["respose_type"]="error";
      $alert["respose_message"]="Phone Number field is Empty";
      echo(json_encode($alert));
      die();
    }
    if(empty($_POST["custemail"])){
      $alert["respose_type"]="error";
      $alert["respose_message"]="Email field is Empty";
      echo(json_encode($alert));
      die();
    }
if(filterEmail($_POST["custemail"])==FALSE){
  $alert["respose_type"]="error";
  $alert["respose_message"]="Invalid Email Format";
  echo(json_encode($alert));
  die();
}
//roomId
if(empty($_POST["roomId"])){
  $alert["respose_type"]="error";
  $alert["respose_message"]="Form data was Tempored";
  echo(json_encode($alert));
  die();
}
if(empty($_POST["propertyId"])){

  $alert["respose_type"]="error";
  $alert["respose_message"]="Form data was Tempored";
  echo(json_encode($alert));
  die();
}

$room=new Room();
$room->setRoomId($_POST["roomId"]);
$room->setavailabilityStatus("Occupied");
$room->setavaialibiltyDate(date("Y-m-d"));

//$room->setavaialibiltyDate(date("Y-m-d"));
//$room->updateAvailablityStatus($conn)


$customerId=date("YmdHis");
$reservationCode=rand(10000,20000);
//find customer by Email
try {
  $findCustomerByEmailSql="SELECT * FROM customers WHERE customerEmail='$_POST[custemail]'";
  $findCustomerByEmailQuery=$conn->query($findCustomerByEmailSql);
  $findCustomerByEmailQuery->setFetchMode(PDO::FETCH_ASSOC);
  $findCustomerByEmailResult=$findCustomerByEmailQuery->rowCount();
  if($findCustomerByEmailResult>0){
     $findCustomerByEmailResultRows=$findCustomerByEmailQuery->fetch();
     //create bookings onnly using the user Id from the result as s the
     //customer UserId
     $booking=new Bookings($room->getRoomId(),$_POST["propertyId"],$reservationCode,date("Y-m-d"),$findCustomerByEmailResultRows['customerId']);
     $booking->setBookingId(date("YmdHis"));
     $booking->setCheckInDate($_SESSION["sqCheckinDate"]);
     $booking->setCheckOutDate($_SESSION["sqCheckoutdate"]);
     $booking->setChildren($_SESSION["sqNumberOfChildren"]);
     $booking->setAdults($_SESSION["sqNumberOfAdult"]);
     $booking->setReservationComment("");
     $booking->setReservationStatus("Pending Confirmation");
     $booking->setNotificationSeen("No");
     $booking->setCustomerMessage($_POST['customerMessage']);
     $booking->setReservationBill($_SESSION['reservationCost']);

     $updateRoomAvailStatus=$room->updateAvailablityStatus($conn);
     if(!$updateRoomAvailStatus===true){
       $alert["respose_type"]="error";
       $alert["respose_message"]="Booking transaction not Successful ";
       $alert["reseponese_note"]="Room Information Update Failed";
       die();
     }
     $makeBooking=$booking->makeBooking($conn);
     if($makeBooking===true){
       //return Success Message to teh CLient

       $alert["respose_type"]="success";
       $alert["respose_message"]="Booking Transaction Performed Successfully ";
       //notes
       $alert["reseponese_note"]=$reservationCode;
       $_SESSION["sqNumberOfAdult"]=null;
       $_SESSION["sqNumberOfChildren"]=null;
       $_SESSION["sqDestination"]=null;
       $_SESSION["sqCheckinDate"]=null;
       $_SESSION["sqCheckoutdate"]=null;
       $_SESSION['reservationCost']=null;
       echo(json_encode($alert));
       die();
     }else{
       //return Erro Message to the Client

       $alert["respose_type"]="error";
       $alert["respose_message"]="Reservation Not Successful";
       $alert["reseponese_note"]="Encountered and Error While Performing Transaction with  Your Previous Personal Information Information";


       echo(json_encode($alert));
       die();
     }
  }else{
    //initialise customerId abnd Customer First Transaction Dates
    $updateRoomAvailStatus=$room->updateAvailablityStatus($conn);
    if(!$updateRoomAvailStatus===true){
      $alert["respose_type"]="error";
      $alert["respose_message"]="Booking transaction not Successful ";
      $alert["reseponese_note"]="Room Information Update Failed";
      die();
    }
    $customer=new Customer(date("YmdHis"),date("Y-m-d"));
    $customer->setName($_POST["custname"]);
    $customer->setSurName($_POST["custsurname"]);
    $customer->setUserPhone($_POST["phone"]);
    $customer->setUserEmail($_POST["custemail"]);
    $customer->setUserCountry($_POST["country"]);


    // initialize the Bookin Object
    $booking=new Bookings($room->getRoomId(),$_POST["propertyId"],$reservationCode,date("YmdHis"),$customer->getUserId());

    $booking->setBookingId(date("YmdHis"));
    $booking->setCheckInDate($_SESSION["sqCheckinDate"]);
    $booking->setCheckOutDate($_SESSION["sqCheckoutdate"]);
    $booking->setChildren($_SESSION["sqNumberOfChildren"]);
    $booking->setAdults($_SESSION["sqNumberOfAdult"]);
    $booking->setReservationComment("");
    $booking->setReservationStatus("Pending Confirmation");
    $booking->setNotificationSeen("No");
    $booking->setCustomerMessage($_POST['customerMessage']);

    $booking->setReservationBill($_SESSION['reservationCost']);

    $registerCustomer=$customer->registerCustomer($conn);
    if($registerCustomer==true){
      //perform the Boooking Transaction
      //And Register the Booking Information to the Database

      //updateAvailablityStatus($conn)
    $makeBooking=$booking->makeBooking($conn);
    if($makeBooking===true){


      //return Success Mesasge to the Clien or User
      $alert["respose_type"]="success";
      $alert["respose_message"]="Booking Transaction Performed Successfully ";
      //notes
      $alert["reseponese_note"]=$reservationCode;
      echo(json_encode($alert));
      die();
    }else{
// Output the Erro Message to the User
$alert["respose_type"]="error";
$alert["respose_message"]="Your Booking Transaction Was Not Cpmplete.";
$alert["reseponese_note"]=" Encountered an Error while Performing Transaction with Current Details";
    echo(json_encode($alert));
    die();
    }
    }else{

      $alert["respose_type"]="error";
      $alert["respose_message"]="Booking Transaction Not Successful";
      $alert["reseponese_note"]="Encountered an Error while Regsitering Personal Information ";
          echo(json_encode($alert));
          die();
    }
  }
} catch (PDOException $e) {
  $alert["respose_type"]="error";
  $alert["respose_message"]=$e->getMessage();
  $alert["reseponese_note"]="Encountered an Error while Regsitering Personal Information ";
      echo(json_encode($alert));
      die();
  
}



    break;
      case 'GET':
        break;
    default:

    $alert["respose_type"]="error";
    $alert["respose_message"]="Wron Request Method";

      echo(json_encode($alert));
      break;
  }
}else{

      $alert["respose_type"]="error";
      $alert["respose_message"]="Accomodation Booking Session is Not available";
      $alert["reseponese_note"]=" Make sure  to fill a form necessar to perform a Booking transaction";
        echo(json_encode($alert));

}
?>
