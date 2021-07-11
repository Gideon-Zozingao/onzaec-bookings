<?php
session_start();
include("../controllers/config.php");
include('../controllers/classes/db-class.php');
include('../controllers/classes/user-class.php');
$thisdb=new db($h,$u,$pass,$db);
$conn=$thisdb->connect();
$me=new User();
$me->setUserId($_SESSION['id']);
if(!$conn){
  die("Connection Failed Try Again Later");
}
$myData=$me->viewUSer($conn);
switch ($_SERVER["REQUEST_METHOD"]) {
  case 'GET':

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
      <h3 class="text-muted">Edit Your Profile Information</h3>
      <?php //echo json_encode($myData) ?>
      <hr>
      <form class="" action="" method="post" id="editprofile-form">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for=""> Name</label>
              <input type="text" name="name" value="<?php echo $myData['name'] ?> " class="form-control">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for=""> Surname</label>
              <input type="text" name="surname" value="<?php echo $myData['surname'] ?> " class="form-control">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for=""> Gender</label>
              <select name="gender" class="form-control">
                <option value="<?php echo $myData['gender']?>"><?php echo $myData['gender']?> </option>
                <?php if($myData['gender']=="Male"){
                  ?>  <option value="Female">Female</option><?php
                }else{
                  ?>
                  <option value="Male">Male</option>
                  <?php
                } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for=""> Date of Birth</label>
              <input type="date" name="dateOfBirth" value="<?php echo   $myData['dateOfBirth'] ?> " class="form-control">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for=""> Country</label>
              <input type="text" name="country" value="<?php echo $myData['country'] ?> " class="form-control">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for=""> State/Province</label>
              <input type="text" name="state" value="<?php echo $myData['state'] ?> " class="form-control">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for=""> Address</label>
              <input type="text" name="address" class="form-control" value="<?php echo $myData['address']?>">

            </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-4 offset-4">
            <button type="submit" name="button" class=" btn btn-primary btn-lg">Save Information</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <script type="text/javascript">
  $(document).ready(()=>{
    $("#editprofile-form").on("submit",function(e){
      e.preventDefault()
      $.ajax({
        url:"../users/edit-profile.php",
        type:"POST",
        data:new FormData(this),
				contentType:false,
				cache:false,
				processData:false,
        beforeSend:()=>{
          $("#modal-top-body").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='../public/images/loading.gif'></div><div class='col-md-4'></div></div>")
          $("#modal-top").fadeIn("slow")

        },
        success:(data)=>{
          $("#modal-top-body").html(data);
          let JSONdata=JSON.parse(data);
          if(JSONdata.alert_type=="error"){
                $("#modal-top-body").html(`<span class="col-md-8 offset-2 text-center text-danger">${JSONdata.message}</span>`)
                setTimeout(()=>{
                    $("#modal-top").fadeOut("slow");
                },2000)
          }else{
            $("#modal-top-body").html(`<span class="col-md-8 offset-2 text-center text-success">${JSONdata.message}</span>`)
            setTimeout(()=>{
                $("#modal-top").fadeOut("slow");
                window.location.replace("");
            },1500)
          }

        }

      })
    })
  })

  </script>

  <?php
    break;
    case 'POST':
    $alert=Array('alert_type'=>'','message'=>'');
      // code...
      if(isset($_POST["name"])&&isset($_POST["surname"])&&isset($_POST["dateOfBirth"])&&isset($_POST["gender"])&&isset($_POST["country"])&&isset($_POST["state"])&&isset($_POST["address"])){


        if($_POST["name"]===""||$_POST["surname"]===""||$_POST["dateOfBirth"]===""||$_POST["gender"]===""||$_POST["country"]===""||$_POST["state"]===""||$_POST["address"]===""){
          $alert["alert_type"]="error";
          $alert["message"]="Some information missing";
          echo json_encode($alert);
          die();
        }

        $me->setName($_POST["name"]);
        $me->setSurName($_POST["surname"]);
        $me->setDateOfBirth($_POST["dateOfBirth"]);
        $me->setGender($_POST["gender"]);
        $me->setUserCountry($_POST["country"]);
        $me->setPostalAddress($_POST["address"]);
        $me->setUserState($_POST["state"]);

        $updateInfo=$me->updateUserInformation($conn);
        if($updateInfo==true){
          $alert["alert_type"]="success";
          $alert["message"]="Personal Informatin Updated Successfully";
          echo json_encode($alert);
          die();
        }else{
          $alert["alert_type"]="error";
          $alert["message"]="There was a Problem Updating User Information";
          echo json_encode($alert);
          die();
        }
      }
      break;

  default:
    // code...
    break;
}
