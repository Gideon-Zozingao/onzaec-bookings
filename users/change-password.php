<?php
session_start();
include("../controllers/config.php");
include('../controllers/classes/db-class.php');
include('../controllers/classes/user-class.php');
$thisdb=new db($h,$u,$pass,$db);
$conn=$thisdb->connect();
$me=new User();
$me->setUserId($_SESSION['id']);
switch ($_SERVER["REQUEST_METHOD"]) {
  case 'GET':

  if(!$conn){
    die("Connection Failed Try Again Later");
  }
  $myData=$me->viewUSer($conn);
  if($myData==FALSE){?>
    <section id="hero" class="d-flex align-items-center" >
      <div class="container" data-aos="zoom-out" data-aos-delay="100">
        <h1>Error  retrieing Your  Profile Information
        </h1>

        <section>

        </section>
      </div>
    </section>
  <?php
    die();
  }
  if($myData==0){
    ?>
    <section id="hero" class="d-flex align-items-center" >
      <div class="container" data-aos="zoom-out" data-aos-delay="100">
        <h1>Your Profile information is  Not Available
        </h1>

        <section>

        </section>
      </div>
    </section>
    <?php
  die();
  }
   ?>
   <div class="card" id="form-card">
     <div class="card-body">
       <h3 class="text-muted">Change your Password Now</h3>
       <hr>
       <?php //echo json_encode($myData) ?>
       <form class="" action="" method="post" id="changePasswprdForm">
            <div class="row">
              <div class="col-md-4">
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Type your Old Password</label>
                  <input type="password" name="oldpassword" value="" class="form-control">
                </div>
                <div class="form-group">
                  <label for="">New Password</label>
                  <input type="password" name="newPassword" value="" class="form-control">
                </div>
                <div class="form-group">
                  <label for="">Confirm  Your New Password</label>
                  <input type="password" name="confirmNewPassword" value="" class="form-control">
                </div>
                <div class="form-group">
                  <button type="submit" class="btn-primary btn-lg btn-block">Change Password</button>
                </div>
              </div>
              <div class="col-md-4">
              </div>
            </div>
       </form>
     </div>
   </div>
  <script type="text/javascript">
    $(document).ready(()=>{
      $("#changePasswprdForm").on("submit",function(e){
        e.preventDefault()
        $.ajax({
          url:"../users/change-password.php",
          type:"POST",
          data:new FormData(this),
          contentType:false,
          cache:false,
          processData:false,
          beforeSend:()=>{
            $("#modal-top-body").html("<span class='col-md-2 offset-5'><img src='../public/images/loading.gif'></span>")
            $("#modal-top").fadeIn("slow");
          },
          success:(data)=>{
            let JSONdata=JSON.parse(data);
            if(JSONdata.alert_type=="error"){
            $("#modal-top-body").html(`<span class="text-danger text-center">${JSONdata.alert_message}</span>`)
            setTimeout(()=>{
              $("#modal-top").fadeOut("slow")
            },2000)
          }else{
            $("#modal-top-body").html(`<span class="text-success text-center">${JSONdata.alert_message}</span>`)
            setTimeout(()=>{
              $("#modal-top-body").fadeOut("slow")
              window.location.replace("")
            },2000)
          }
            
          }
        })
      })
    })
  </script>
  <?php
    break;
    case 'POST':
      // code...
      $alert=Array("alert_type"=>"","alert_message"=>"");
      if(!$conn){
        $alert["alert_type"]="error";
        $alert["alert_message"]="Connection Failed";
        echo json_encode($alert);
        die();
      }
      $myData=$me->viewUSer($conn);
      if($myData==FALSE){
        $alert["alert_type"]="error";
        $alert["alert_message"]="Cannot Retrieve Your User credentials now";
        echo json_encode($alert);
        die();
      }
      if($myData==0){
        $alert["alert_type"]="error";
        $alert["alert_message"]="User Data Not Present";
        echo json_encode($alert);
      die();
      }

      if(isset($_POST['newPassword'])&&isset($_POST['oldpassword'])&&isset($_POST["confirmNewPassword"])){
        require_once("../controllers/hashing.php");

      if($_POST['newPassword']==""||$_POST['oldpassword']==""||$_POST["confirmNewPassword"]==""){
        $alert["alert_type"]="error";
        $alert["alert_message"]="Fill all the form fields Before sending the data";
        echo json_encode($alert);
        die();
      }
      $oldPassHashed=hashData($_POST['oldpassword']);
      $newHasedPass=hashData($_POST['newPassword']);
        if($oldPassHashed!=$_SESSION["password"]){
          $alert["alert_type"]="error";

          $alert["alert_message"]="Your Old Password is wrong";
          echo json_encode($alert);
        die();
        }
        if($_POST['newPassword']!=$_POST["confirmNewPassword"]){
          $alert["alert_type"]="error";
          $alert["alert_message"]="Your new Passowrds Do Not Match";
          echo json_encode($alert);
        die();
        }
          if(strlen($_POST['newPassword'])<8){
            $alert["alert_type"]="error";
            $alert["alert_message"]="Password lenght to Short";
            echo json_encode($alert);
          die();
          }
        $me->setUserPassword($newHasedPass);
        $changePass=$me->changePassword($conn);
        if($changePass==true){
          $alert["alert_type"]="success";
          $alert["alert_message"]="Password Changed Successfully";
          echo json_encode($alert);
        }
      }
      break;

  default:
    // code...
    break;
}


?>
