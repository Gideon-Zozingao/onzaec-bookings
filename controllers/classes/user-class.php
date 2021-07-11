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
        $q="SELECT * from  user  WHERE phone='$this->userPhone'";
        $query=mysqli_query($dbConnection,$q);
        if($query){
          $rowCount=mysqli_num_rows($query);
          if($rowCount>0){
            return  $rowCount;
          }else{
            return  0;
          }
        }else{
          return  "Error: ".mysqli_error($dbConnection);
        }
      }
      public  function  varifyEmail($dbConnection){
          $q="SELECT * from  user  WHERE email='$this->userEmail'";
          $query=mysqli_query($dbConnection,$q);
          if($query){
            $rowCount=mysqli_num_rows($query);
            if($rowCount>0){
              return  $rowCount;
            }else{
              return  0;
            }
          }else{
            return  "Error: ".mysqli_error($dbConnection);
          }
      }
      public  function  varifyUserName($dbConnection){
        $q="SELECT * from  user  WHERE username='$this->username'";
        $query=mysqli_query($dbConnection,$q);
        if($query){
          $rowCount=mysqli_num_rows($query);
          if($rowCount>0){
              return  $rowCount;
          }else{
              return  0;
          }
        }else{
            return  "Error: ".mysqli_error($dbConnection);
        }
      }

      public  function  registerUser($dbConnection){
          $q="INSERT  INTO  user(userId,name,surname,dateOfBirth,gender ,country,state,address,phone,email,userType,avata,username,password,registrationDate)VALUES('$this->id','$this->name','$this->surname','$this->dateOfBirth','$this->gender','$this->userCountry','$this->userState',
          '$this->postalAddress','$this->userPhone','$this->userEmail',
            '$this->userType',
            '$this->avata',
            '$this->username','$this->password','$this->registrationDate')";
            $query=mysqli_query($dbConnection,$q);
            if($query==true){
                return true;
            }else{
                return  mysqli_error($dbConnection);
            }
      }

      public  function  authUSer($dbConnection){
        $q="SELECT * from  user  WHERE username='$this->username'AND  password='$this->password'";
        $query=mysqli_query($dbConnection,$q);
        if($query){
          $rowCount=mysqli_num_rows($query);
          if($rowCount>0){
            $rows=mysqli_fetch_array($query);
              return  $rows;
          }else{
              return  0;
          }
        }else{
            return  FALSE;
        }
      }

        public  function  viewUSer($dbConnection){
            $q="SELECT* FROM user  WHERE userId='$this->id'";
            $query=mysqli_query($dbConnection,$q);
            if($query){
              $results=mysqli_num_rows($query);
              if($results>0){
                $resut_row=mysqli_fetch_array($query);
                return  $resut_row;
              }else{
                return  0;
              }
            }else{
              return  FALSE;
            }
      }
    public function updateAvat($conn){
      $sql="UPDATE user SET avata='$this->avata' WHERE userId='$this->id'";
      $query=mysqli_query($conn,$sql);
      if($query==true){
        return true;
      }else{
        return FALSE;
      }
    }
    public function changePassword($conn){
      $sql="UPDATE user SET password='$this->password' WHERE userId='$this->id'";
      $query=mysqli_query($conn,$sql);
      if($query==true){
        return true;
      }else{
        return FALSE;
      }
    }

    public function updateUserInformation($conn){
      $sql="UPDATE user SET name='$this->name',surname='$this->surname',dateOfBirth='$this->dateOfBirth',gender='$this->gender' ,country='$this->userCountry',state='$this->userState',address='$this->postalAddress'  WHERE userId='$this->id'";
      $query=mysqli_query($conn,$sql);
      if($query==true){
        return true;
      }else{
        return FALSE;
      }
    }
}

?>
