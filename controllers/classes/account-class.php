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
    try {
      $sql="INSERT INTO user_accounts
    VALUES('$this->accId','$this->accountName','$this->accountType','$this->userType','$this->accoutOwnerId','$this->registrationDate','$this->accountStatus')";

      $query=$conection->prepare($sql);
      $query->execute();

      if($query->rowCount()>0){
        return true;
      }else{
        return FALSE;
      }
    } catch (PDOException $e) {
      return FALSE;
    }
}


public function getUserAounts($connection){
  try {

    $q="SELECT * FROM user_accounts WHERE accoutOwnerId=$this->accoutOwnerId";
      $query=$connection->query($q);
      $count=$query->rowCount();
      
      if($count>0){
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $row=$query->fetch();
        return $row;
      }else{
        return 0;
      }

  } catch (PDOException $e) {
      return FALSE;
  }
}
}
?>
