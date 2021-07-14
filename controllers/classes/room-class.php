<?php
class Room{
  private $roomId;
  private $roomName;
  private $roomCategory;
  private $FloorNumber;
  private $roomCapacity;
  private $numberOfBed;
  private $bedSize;
  private $facilities;
  private $price;
  private $tax;
  private $availabilityStatus;
  private $avaialibiltyDate;
  private $roomDescription;
  private $roomCoverPhoto;
  private $pubblicationStatus;
  private $propertyId;
//setter  methods
  public  function  setRoomId($roomId){
      $this->roomId=$roomId;
  }
  public  function  setRoomName($roomName){
      $this->roomName=$roomName;
  }
  public  function  setRoomCategory($roomCategory){
    $this->roomCategory=$roomCategory;
  }
  public  function  setFloorNumber($FloorNumber){
    $this->FloorNumber=$FloorNumber;
  }
  public  function  setRoomCapacity($roomCapacity){

    $this->roomCapacity= $roomCapacity;
  }
  public  function  setNumberOfBed($numberOfBed){
    $this->numberOfBed=$numberOfBed;
  }
  public  function  setBedSize($bedSize){
    $this->bedSize=$bedSize;
  }
  public  function setFacilities($facilities){
    $this->facilities=$facilities;
  }
  public  function  setPrice($price){
    $this->price=$price;
  }
  public  function  setTax($tax){
      $this->tax=$tax;
  }
  public  function  setavailabilityStatus($availabilityStatus){
    $this->availabilityStatus=$availabilityStatus;
  }
  public  function  setavaialibiltyDate($avaialibiltyDate){
      $this->avaialibiltyDate=$avaialibiltyDate;
  }
  public  function  setroomDescription($roomDescription){
      $this->roomDescription=$roomDescription;
  }
  public  function  setRoomCoverPhoto($roomCoverPhoto){
      $this->roomCoverPhoto=$roomCoverPhoto;
  }

  public  function  setPubblicationStatus($pubblicationStatus){
      $this->pubblicationStatus=$pubblicationStatus;
  }
  //$pubblicationStatus
  public  function  setpropertyId($propertyId){
      $this->propertyId=$propertyId;
  }
//getter methods

  public  function  getRoomId(){
      return  $this->roomId;
  }
  public  function  getRoomName(){
      return  $this->roomName;
  }
  public  function  getRoomCategory(){
    return  $this->roomCategory;
  }
  public  function  getFloorNumber(){
    return  $this->FloorNumber;
  }
  public  function  getRoomCapacity(){

    return  $this->roomCapacity;
  }
  public  function  getNumberOfBed(){
    return  $this->numberOfBed;
  }
  public  function  getBedSize(){
    return  $this->bedSize;
  }
  public  function getFacilities(){
    return  $this->facilities;
  }
  public  function  getPrice(){
    return  $this->price;
  }
  public  function  getTax(){
      return  $this->tax;
  }
  public  function  getavailabilityStatus(){
    return  $this->availabilityStatus;
  }
  public  function  getavaialibiltyDate(){
      return  $this->avaialibiltyDate;
  }
  public  function  getroomDescription(){
      return  $this->roomDescription;
  }

  public  function  getRoomCoverPhoto(){
      return  $this->roomCoverPhoto;
  }
  public  function  getPubblicationStatus(){
      return  $this->pubblicationStatus;
  }
  public  function  getpropertyId(){
      return $this->propertyId;
  }
  public  function  addRoom($conn){

      try {
        $q="INSERT  INTO  rooms (roomId,roomName,roomCategory, 	FloorNumber,roomCapacity,numberOfBed,bedSize,facilitiesl, 	price,tax,availabilityStatus,avaialibiltyDate,roomDescription,publoicationStatus,roomCoverPhoto,propertyId)  VALUES('$this->roomId',
          '$this->roomName','$this->roomCategory','$this->FloorNumber','$this->roomCapacity', '$this->numberOfBed','$this->bedSize','$this->facilities','$this->price','$this->tax','$this->availabilityStatus','$this->avaialibiltyDate','$this->roomDescription','$this->pubblicationStatus','$this->roomCoverPhoto',
          '$this->propertyId')";

        $exec=$conn->prepare($q);
        $exec->execute();
        $affected=$exec->rowCOunt();
        if($affected>0){
          return true;
        }else{
          return 0;
        }
      } catch (PDOException $e) {
        return FALSE;
      }
  }

public  function  getThisPropsRooms($conn){
  $q="SELECT*FROM rooms WHERE propertyId='$this->propertyId'";
  try {
    $query=$conn->query($q);
    $query->setFetchMode(PDO::FETCH_ASSOC);
    $results=$query->rowCount();
    if($results>0){
      $rows=$query->fetch();
      return  $rows;
    }else{
        return  0;
    }
  } catch (PDOException $e) {
      return FALSE;
  }
}

public function updateAvailablityStatus($conn){
  try {
    $sql="UPDATE rooms SET availabilityStatus='$this->availabilityStatus',avaialibiltyDate='$this->avaialibiltyDate'
     WHERE roomId='$this->roomId'";
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
}


?>
