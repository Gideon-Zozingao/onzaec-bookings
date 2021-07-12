<?php
  if($_SERVER["REQUEST_METHOD"]==="POST"){
    $name=$_POST["name"];
    $surname=$_POST["surname"];
    $dateOfBirth=$_POST["dateOfBirth"];
    $gender=$_POST["gender"];
    $userCountry=$_POST["userCountry"];
    $postalAddress=$_POST["postalAddress"];
    $userPhone=$_POST["userPhone"];
    $userState=$_POST["userState"];
    $userEmail=$_POST["userEmail"];
    $username=$_POST["username"];
    //$avata=$_FILES["avata"]['name'];
    $password=$_POST["password"];
    $cPassword=$_POST["cPassword"];
    $validExtensions = Array("jpeg", "jpg", "png","PNG");
    $alert=Array('alert_type'=>'','message'=>'');
    if(!$name==""&&!$surname==""&&!$dateOfBirth==""&&!$gender==""&&!$userCountry==""&&!$postalAddress==""&&!$userState==""&&!$userPhone==""&&!$userEmail==""&&!$username==""&&!$password==""&&!$cPassword==""){
      include("config.php");
      include("classes/db-class.php");
      include("data-sanitiation.php");
      include("hashing.php");

      $validEmail=filterEmail($userEmail);
      $validName=filterName($name);
      $validSurName=filterName($surname);
      $validUserName=filterName($username);
      $validCountry=filterString($userCountry);
      if($validEmail==FALSE){
        $alert['alert_type']='error';
        $alert['message']='Invalid Email format';
        die(json_encode($alert));
      }
      if($validName==FALSE||$validSurName==FALSE){
        $alert['alert_type']='error';
        $alert['message']='Inalid username format';
        die(json_encode($alert));
      }
      if($validUserName==FALSE){
        $alert['alert_type']='error';
        $alert['message']=' Invalid Username  Format';
        die(json_encode($alert));
      }
      if($validCountry==FALSE){
        $alert['alert_type']='error';
        $alert['message']=' Invalid Countryname  Format';
        die(json_encode($alert));
      }
      if($password!==$cPassword){

        $alert['alert_type']='error';
        $alert['message']='Passwords Do  Not Match';
        die(json_encode($alert));
      }
      if(strlen($password)<8){

        $alert['alert_type']='error';
        $alert['message']='Pasword is too Short. Please type 8 or more characters';
        die(json_encode($alert));
      }


        $thisdb=new db($h,$u,$pass,$db);
        $conn=$thisdb->connect();
        if($conn){
          include("classes/user-class.php");
          include('classes/account-class.php');

        $myAccount=new Account();
        $myAccount->setAccId(date("YmdHis"));
        $myAccount->setAccountName($username);
        $myAccount->setAccountType("useracc");
        $myAccount->setRegistrationDate(date("Y-m-d"));
        $myAccount->setUserType("general");
          $myUser=new user();
          $myUser->setUserId(date("YmdHis"));

          $myAccount->setAccoutOwnerId($myUser->getUserId());
          $myUser->setName($name);
          $myUser->setSurName($surname);
          $myUser->setDateOfBirth($dateOfBirth);
          $myUser->setGender($gender);
          $myUser->setUserCountry($userCountry);
          $myUser->setUserState($userState);
          $myUser->setPostalAddress($postalAddress);
          $myUser->setUserPhone($userPhone);
          $myUser->setUserEmail($userEmail);

          $myUser->setUserName($username);
          $myUser->setUserPassword(hashData($password));
          $myUser->setUserType("general");
          $myUser->setUserRegistrationDate(date("Y-m-d"));
          $varifPhone=$myUser->varifyPhone($conn);
          $varifEmail=$myUser->varifyEmail($conn);
          $varifUserName=$myUser->varifyUserName($conn);
          if($varifUserName>0){
            $alert['alert_type']='error';
            $alert['message']='Username already Taken';
            die(json_encode($alert));
          }
            if($varifPhone>0){
              $alert['alert_type']='error';
              $alert['message']='Phone number  already Taken';
              die(json_encode($alert));
            }
              if($varifEmail>0){
                $alert['alert_type']='error';
                $alert['message']='Email  already Taken';
                die(json_encode($alert));
                  }


                  if($_FILES["avata"]['name']!=""){
                    $temp=explode(".",$_FILES["avata"]['name']);
                    if(!in_array(end($temp),$validExtensions)){
                      $alert['alert_type']="error";
                      $alert['message']="Please upload  a valid Image File [jpg,jpeg  or  PNG file]";
                      die(json_encode($alert));
                    }
                    $newFileName="IMAGE".date("YmdHis").round(microtime(true)).".".end($temp);
                    $upload=move_uploaded_file($_FILES["avata"]["tmp_name"],"../users/user-photos/".$newFileName);
                    if(!$upload==true){
                      $alert['alert_type']="error";
                      $alert['message']="Failed to Process and upload your Avata";
                      die(json_encode($alert));
                    }
                      $myUser->setAvata($newFileName);
                  }else{
                    $myUser->setAvata("");
                  }


                $regUser=$myUser->registerUser($conn);
                if($regUser==true){
                  $myAcc=$myAccount->createAccount($conn);
                	if($myAcc===true){
                    $alert['alert_type']='success';
                    $alert['message']='Registartion successful';
                    die(json_encode($alert));

                	}else{
                    $alert['alert_type']='error';
                    $alert['message']='User Account Account Creation failed';
                    die(json_encode($alert));
                	}

                }else{
                  $alert['alert_type']='error';
                  $alert['message']='User Account Account Creation failed';
                  die(json_encode($alert));
                }
        }else{
          $alert['alert_type']='error';
          $alert['message']='Cannot register User Information at the Moment ' .$regUser;
          die(json_encode($alert));
        }

    }else{
      $alert['alert_type']='error';
      $alert['message']='Please fill all the required Information';
      die(json_encode($alert));
    }
  }else{
    header("Location:../register");
  }


?>
