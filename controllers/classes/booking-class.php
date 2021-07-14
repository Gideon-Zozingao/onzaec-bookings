<?php

class Bookings
{
private $bookingId;
private $roomId;
private $propertyId;
private $reservationDate;
private $reserVationCode;
private $customerId;
private $checkInDate;
private $checkOutDate;
private $reservationStatus;
private $notificationSeen;
private $children;
private $adults;
private $customerMessage;
private $reservationComment;
private $reservationBill;

//constructor function
  function __construct($roomId,$propertyId,$reserVationCode,$reservationDate,$customerId)
  {

    $this->roomId=$roomId;
    $this->propertyId=$propertyId;
    $this->reserVationCode=$reserVationCode;
    $this->reservationDate=$reservationDate;
    $this->customerId=$customerId;
  }

/**Setter  are functions that sets and modifys the class attributes and  properties

these class has 9 Setter functions

*/

public function setBookingId($bookingId){
  $this->bookingId=$bookingId;
}
  // sets and Modifiies Checkindates
 public function setCheckInDate($checkInDate){
  $this->checkInDate=$checkInDate;

 }
 // sets and modifys checkOut dates
 public function setCheckOutDate($checkOutDate){
   $this->checkOutDate=$checkOutDate;

 }
 // sets and Modifys Reservation Status
 public function setReservationStatus($reservationStatus){
   $this->reservationStatus=$reservationStatus;

 }

 //sets and modifies reservation Notification Status
 public function setNotificationSeen($notificationSeen){
   $this->notificationSeen=$notificationSeen;

 }

 //sets and modifys numbe rof children at the reservations
 public function setChildren($children){
    $this->children=$children;
 }

 //sets and modifys numbe rof adults
 public function setAdults($adults){
    $this->adults= $adults;
 }

 //sets and Modifys custommer Messages
 public function setCustomerMessage($customerMessage){
   $this->customerMessage=$customerMessage ;
 }
 // sets and Modifys Admin Reservation Comments
 public function setReservationComment($reservationComment){
   $this->reservationComment=$reservationComment;
 }

 // sets and Modifys reservation Billings
 public function setReservationBill($reservationBill){
   $this->reservationBill=$reservationBill;
 }
/** getter function are the functions that returns the value of the setter function
**It allows the avlues of the class attributes to be accessed
*/

//returns the value of reservation Id

public function getBookingId(){
  return $this->bookingId;
}

//return the value of  room Id
public function getRoomId(){
  return $this->roomId;
}

//return the value of Property  Id
public function getPropertyId(){
  return  $this->propertyId;
}

//return the value of Reservation date
public function getReservationDate(){
  return$this->reservationDate;
}

//return the value of Reservation Code
public function getReserVationCode(){
  return $this->reserVationCode;
}

//return the value of Customer Id
public function getCustomerId(){
  return $this->customerId;
}

//return the value of Checkin date
public function getCheckInDate(){
  return $this->checkInDate;
}
//return the value of Checkout Date
public function getCheckOutDate(){
  return $this->checkOutDate;

}

//return the value of Reservation Status
public function getReservationStatus(){
  return $this->reservationStatus;
}

//return the value of Notification seen Status
public function getNotificationSeen(){
  return$this->notificationSeen;
}

//return the value of number of Children
public function getChildren(){
  return $this->children;
}

//return the value of Number of Adults
public function getAdults(){
  return $this->adults;
}

//return the value of Customer Messages
public function getCustomerMessage(){
  return $this->customerMessage;
}

//return the value of Reservation Comment
public function getReservationComment(){
  return $this->reservationComment;
}

//return the value of Reservation Bill
public function getReservationBill(){
  return $this->reservationBill;
}

//Update reservation Status
public function updateReservationStatus($conn){
  try {
    $sql="UPDATE bookings SET reservationStatus='$this->reservationStatus' WHERE bookingId='$this->bookingId'";
    $query=$conn->prepare($sql);
    $query->execute();
    $affected=$query->rowCount();
    if($affected>0){
      return true;
    }else{
            return FALSE;
    }

  } catch (PDOException $e) {
    return FALSE;
  }

}
public function checkOut($conn){
  try {
        $sql="UPDATE bookings SET reservationStatus='$this->reservationStatus',reservationComment='$this->reservationComment',checkOutDate='$this->checkOutDate',reservationBill='$this->reservationBill' WHERE bookingId='$this->bookingId'";

          $query=$conn->prepare($sql);

          $query->execute();
          $affected=$query->rowCount();
          if ($affected>0) {
            return true;
          }else{
                return FALSE;
          }

  } catch (PDOException $e) {
    return FALSE;
  }
}
public function updateReservationComment($conn){
try {
      $sqli="UPDATE bookings SET reservationComment='$this->reservationComment' WHERE bookinId='$this->bookingId'";
      $query=$conn->prepare($sql);
      $query->execute();
      $affected=$query->rowCout();
  if ($affected>0) {
      return true;
  }else{
      return FALSE;
  }
} catch (PDOException $e) {
  return FALSE;
}
}
//booking Notification View function
public function updateNotificationSeen($conn){
  $sql="UPDATE bookings SET reservationNoticeSeen='$this->notificationSeen' WHERE bookingId='$this->bookingId'";
  $query=mysqli_query($conn,$sql);
  if($query==true){
      return true;
  }else{
      return FALSE;
  }
}

// create bookings and record the boking in the database
public function makeBooking($conn){
  try {
    $sql="INSERT INTO bookings VALUES(
       '$this->bookingId',
       '$this->roomId',
       '$this->propertyId',
       '$this->checkInDate',
       '$this->checkOutDate',
       '$this->customerId',
       '$this->reserVationCode',
       '$this->reservationStatus',
       '$this->reservationDate',
       '$this->children',
       '$this->adults',
       '$this->notificationSeen',
       '$this->customerMessage','$this->reservationComment','$this->reservationBill')";
       $query =$conn->prepare($sql);
       $query->execute();
       $affected=$query->rowCount();
       if ($affected>0) {
         return true;
       }else{
         return FALSE;
       }
  } catch (PDOException $e) {
      return FALSE;
  }
}
}
?>
