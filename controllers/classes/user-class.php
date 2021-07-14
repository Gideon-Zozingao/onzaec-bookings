<?php
class User{
      protected  $id;
      protected  $name;
      protected  $surname;
      private  $dateOfBirth;
      private  $gender;
      protected  $userCountry;
      protected  $postalAddress;
      protected  $userState;
      protected  $userPhone;
      protected  $userEmail;
      private  $avata;
      private  $username;
      private  $password;
      private  $userType;
      private  $registrationDate;
      public  function  setUserId($id){
        $this->id=$id;
    }
      public  function  setName($name){
        $this->name=$name;
      }
    public  function  setSurName($surname){
      $this->surname=$surname;
    }
    public  function  setDateOfBirth($dateOfBirth){
      $this->dateOfBirth=$dateOfBirth;
    }
    public  function  setGender($gender){
      $this->gender=$gender;
    }
    public  function  setUserCountry($userCountry){
      $this->userCountry=$userCountry;
    }
    public  function  setPostalAddress($postalAddress){
      $this->postalAddress=$postalAddress;
    }
    public  function  setUserState($userState){
      $this->userState=$userState;
    }
    public  function  setUserPhone($userPhone){
      $this->userPhone=$userPhone;
    }
    public  function  setUserEmail($userEmail){
      $this->userEmail=$userEmail;
    }
    public  function  setAvata($avata){
        $this->avata=$avata;
      }
      public  function  setUserName($username){
        $this->username=$username;
      }
      public  function  setUserPassword($password){
        $this->password=$password;
      }
      public  function  setUserType($userType){
        $this->userType=$userType;
      }
      public  function setUserRegistrationDate($registrationDate){
        $this->registrationDate=$registrationDate;
      }

      //getter   functions

    public  function  getUserId(){return  $this->id;}

    public  function  getName(){return  $this->name;}

    public  function  getSurName(){
      return $this->surname;
    }
    public  function  getDateOfBirth(){return  $this->dateOfBirth;
    }

    public  function  getGender(){return  $this->gender;}

    public  function  getUserCountry(){return  $this->userCountry;}

    public  function  getPostalAddress(){return  $this->postalAddress;}

    public  function  getUserState(){return  $this->userState;}

    public  function  getUserPhone(){return  $this->userPhone;}

    public  function  getUserEmail(){return  $this->userEmail;}

    public  function  getAvata(){return  $this->avata;}

    public  function  getUserName(){return  $this->username;}

      public  function  getUserPassword(){return  $this->password;}

      public  function  getUserType(){return  $this->userType;}

      public  function  getUserRegistrationDate(){return $this->registrationDate;}

      //varifying the existece  of  the User  Phone Numer
      public  function  varifyPhone($dbConnection){
        try {
          $q="SELECT * from  user  WHERE phone='$this->userPhone'";
          $query=$dbConnection->query($q);
          $query->setFetchMode(PDO::FETCH_ASSOC);
          $count=$query->rowCount();
          if($count>0){
            return $count;
          }else{
            return  0;
          }
        } catch (PDOException $e) {
          return null;
        }
      }


      public  function  varifyEmail($dbConnection){
        try {
          $q="SELECT * from  user  WHERE email='$this->userEmail'";
          $query=$dbConnection->query($q);
          $query->setFetchMode(PDO::FETCH_ASSOC);
          $count=$query->rowCount();
          if($count>0){
            return $count;
          }else{
            return 0;
          }
        } catch (PDOException $e) {
            return null;
        }
      }

      public  function  varifyUserName($dbConnection){
        try {
            $q="SELECT * from  user  WHERE username='$this->username'";
            $query=$dbConnection->query($q);
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $rowCount=$query->rowCount();
            if($rowCount>0){
              return $rowCount;
            }else{
              return 0;
            }
        } catch (PDOException $e) {
          return null;
        }
      }

      public  function  registerUser($dbConnection){
        try {
          $q="INSERT  INTO  user(userId,name,surname,dateOfBirth,gender ,country,state,address,phone,email,userType,avata,username,password,registrationDate)VALUES('$this->id','$this->name','$this->surname','$this->dateOfBirth','$this->gender','$this->userCountry','$this->userState',
          '$this->postalAddress','$this->userPhone','$this->userEmail',
            '$this->userType',
            '$this->avata',
            '$this->username','$this->password','$this->registrationDate')";
            $query=$dbConnection->prepare($q);
              $query->execute();
              $count=$query->rowCount();
              if ($count>0) {
                return true;
              }else{
                return false;
              }
        } catch (PDOException $e) {
          return FALSE;
        }
      }

      public  function  authUSer($dbConnection){
        try {
              $q="SELECT *FROM  user  WHERE username='$this->username'AND  password='$this->password'";
                  $query=$dbConnection->query($q);
                  $query->setFetchMode(PDO::FETCH_ASSOC);
                  $rowCount=$query->rowCount();
                  if ($rowCount>0) {
                    $rows=$query->fetch();
                    return $rows;
                  }else{
                    return 0;
                  }
        } catch (PDOException $e) {
          return null;
        }
      }

        public  function  viewUSer($dbConnection){
          try {
            $q="SELECT* FROM user  WHERE userId='$this->id'";
            $query=$dbConnection->query($q);
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $count=$query->rowCount();
            if ($count>0) {
              $rows=$query->fetch();
              return $rows;
            }else{
              return 0;
            }
          } catch (PDOException $e) {
              return FALSE;
          }
      }
    public function updateAvat($conn){
      try {
        $sql="UPDATE user SET avata='$this->avata' WHERE userId='$this->id'";
        $query=$conn->prepare($sql);
        $query->execute();
        $count=$query->rowCount();
        if ($count>0) {
            return true;
        }else{
            return FALSE;
        }
      } catch (PDOException $e) {
          return FALSE;
      }
    }


    public function changePassword($conn){
      try {
            $sql="UPDATE user SET password='$this->password' WHERE userId='$this->id'";
              $query=$conn->prepare($sql);
              $query->execute();
              $count=$query->rowCount();
              if($count>0){
                return true;
              }else{
                return FALSE;
              }
      } catch (PDOException $e) {
          return FALSE;
      }
    }

    public function updateUserInformation($conn){
       try {
           $sql="UPDATE user SET name='$this->name',surname='$this->surname',dateOfBirth='$this->dateOfBirth',gender='$this->gender' ,country='$this->userCountry',state='$this->userState',address='$this->postalAddress'  WHERE userId='$this->id'";
           $query=$conn->prepare($sql);
           $query->execute();
           $count=$query->rowCount();
           if($count>0){
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
