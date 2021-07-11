<?php
require("user-class.php");
class Customer extends User
{
  private $customerId;
  private $customerFirstTransDate;

  function __construct($customerId,$customerFirstTransDate)
  {
    $this->customerId=$customerId;
    $this->customerFirstTransDate=$customerFirstTransDate;

  }
function getCutomerId(){
  return $this->customerId;
}

 function getCustomerFirsTransDate(){
  return $this->customerFirstTransDate;
}
  public function registerCustomer($conn){
    $sql="INSERT INTO customers VALUES(
      '$this->customerId',
      '$this->name',
      '$this->surname',
      '$this->userPhone',
      '$this->userEmail',
      '$this->userCountry',
      '$this->customerFirstTransDate')";
    $query=mysqli_query($conn,$sql);
    if($query==true){
      return true;
    }else{
      return FALSE;
    }
  }
}

?>
