<?php
session_start();
if(isset($_SESSION['logedin'])&&$_SESSION['logedin']==true){
  $alert=Array('alert_type'=>'','message'=>'');
  // code...
  include("../controllers/config.php");
  include('../controllers/classes/db-class.php');
  include('../controllers/classes/user-class.php');
  $thisdb=new db($h,$u,$pass,$db);
  $conn=$thisdb->connect();
  $me=new User();
  $me->setUserId($_SESSION['id']);
  if($conn){
  $myData=$me->viewUSer($conn);
  if($myData==FALSE){
    die("User  Data Not Present");
  }
  ?>
  <div class="card">
    <div class="card-body">
      <h5>Registered User Information</h5>
      <section class="" id="personalDetails">
        <h6 class="text-muted">Personal Details</h6>
        <hr>
        <p>Registered Name <span class="text-primary"><?php echo $myData['name']." ".$myData['surname']  ?> </span> </p>
        <p>Gender  <span class="text-primary"><?php echo $myData['gender']  ?> </span></p>
        <p>Date of Birth <span class="text-primary"><?php echo $myData['dateOfBirth']?> </span></p>
        <p>Country <span class="text-primary"><?php echo $myData['country']  ?> </span></p>
        <p>State  <span class="text-primary"><?php echo $myData['state']?> </span></p>
        <p>Address <span class="text-primary"><?php echo $myData['address']  ?> </span></p>
        <p class="text-info"><a href="#" id="editPersonalInfo">Edit  Details</a> </p>
      </section>
      <section class="" id="contactInformation">
        <h6 class="text-muted">Contact Information</h6>
        <hr>
        <p>Phone <span class="text-primary"><?php echo $myData['phone']  ?> </span></p>
        <p>Email <span class="text-primary"><?php echo $myData['email']?> </span></p>
        <p class="text-info"><a href="#" id="editContactInfo">Edit Contacts</a> </p>
      </section>
      <section id="accountSettings">
        <h6 class="text-muted">Account Settings</h6>
        <hr>
        <p class="text-info"><a href="#" id="passwordSettings">Change Password</a> </p>
        <p class="text-info"> <a href="#" id="accountStatus">Account Deletion and Deactivation</a>  </p>
      </section>
    </div>
  </div>
<script type="text/javascript">
  $(document).ready(()=>{
    $("#editPersonalInfo").click((e)=>{
      e.preventDefault()
    $.ajax({
      url:"users/edit-profile.php",
      type:"GET",
      beforeSend:()=>{
        $("#modal-top-body").html("<span class='col-md-2 offset-5'><img src='../public/images/loading.gif'></span>")
        $("#modal-top").fadeIn("slow");
      },
      success:(data)=>{
        setTimeout(()=>{
          $("#modal-top").fadeOut("slow");
          $("#personalDetails").html(data)
        },1500)

      }
    })
    })

    $("#editContactInfo").click((e)=>{
      e.preventDefault()
      $.ajax({
        url:"users/edit-contacts.php",
        type:"GET",
        beforeSend:()=>{
          $("#modal-top-body").html("<span class='col-md-2 offset-5'><img src='../public/images/loading.gif'></span>")
          $("#modal-top").fadeIn("slow");
        },
        success:(data)=>{
          setTimeout(()=>{
            $("#modal-top").fadeOut("slow");
            $("#contactInformation").html(data);
          },1500)
        }
      })
    })

    $("#passwordSettings").click((e)=>{
      e.preventDefault();
      $.ajax({
        url:"users/change-password.php",
        type:"GET",
        beforeSend:()=>{
          $("#modal-top-body").html("<span class='col-md-2 offset-5'><img src='../public/images/loading.gif'></span>")
          $("#modal-top").fadeIn("slow");
        },
        success:(data)=>{
          setTimeout(()=>{
            $("#modal-top").fadeOut("slow")
            $("#accountSettings").html(data)
          },1500)

        }
      })
    })
  })
</script>
  <?php

}else{
  echo "Profile Information cannot Be displayed at the Momment";
}
}else{
echo "You are Not Loged In";
}

 ?>
