<?php
class Account{
  private $accId;
  private $accountName;
  private $accountType;
  private $userType;
  private $accoutOwnerId;
  private $registrationDate;
  private $accountStatus;

  public function setAccId($accId){
      $this->accId=$accId;
  }
  public function setAccountName($accountName){
    $this->accountName=$accountName;
  }
  public function setAccountType($accountType){
$this->accountType=$accountType;
  }
  public function setAccoutOwnerId($accoutOwnerId){
    $this->accoutOwnerId=$accoutOwnerId;
  }
  public function setRegistrationDate($registrationDate){
$this->registrationDate=$registrationDate;
  }
  public function setUserType($userType){
$this->userType=$userType;
  }
  public function setAccountStatus($accountStatus){
    $this->accountStatus=$accountStatus;
  }
    public function getAccId(){
        return$this->accId;
    }
    public function getAccountName(){
      return$this->accountName;
    }
    public function getAccountType(){
  return$this->accountType;
    }
    public function getAccoutOwnerId(){
      return$this->accoutOwnerId;
    }
    public function getRegistrationDate(){
      return$this->registrationDate;
    }
    public function getUserType(){
  return $this->userType;
    }

public function gteAccountStatus (){
  return $this->accountStatus;
}
public function createAccount($conection){
  $sql="INSERT INTO user_accounts
    VALUES('$this->accId','$this->accountName','$this->accountType','$this->userType','$this->accoutOwnerId','$this->registrationDate','$this->accountStatus')";
    $query=mysqli_query($conection,$sql);
  if($query==true){
    return true;
  }else{
    return mysqli_error($conection);
  }
}


public function getUserAounts($connection){
  $q="SELECT * FROM user_accounts WHERE accoutOwnerId=$this->accoutOwnerId";
  $query=mysqli_query($connection,$q);
  if($query==true){
    $results=mysqli_num_rows($query);
    if($results>0){
      $row=mysqli_fetch_array($query);
      return $row;
    }else{
      return 0;
    }
  }else{
    return msqli_error($connection);
  }
}
}
?>
