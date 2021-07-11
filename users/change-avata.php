<?php
session_start();
if(isset($_SESSION['logedin'])){
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

  switch ($_SERVER["REQUEST_METHOD"]) {

    case 'GET':
      ?>
      <div class="card" id="form-card">
        <div class="card-body">
          <?php
          if($myData['avata']!=""){
            ?>
            <img src="../users/user-photos/<?php  echo $myData['avata'] ?> " alt="<?php  echo $myData['name']." ".$myData['surname']?>" class="img-fluid img-responsive" id="userAvata">
            <?php
          }else{?>
            <img src="user-photos/default.jpg " alt="<?php  echo $myData['name']." ".$myData['surname']?>" class="img-fluid img-responsive" id="userAvata">
            <?php
          }
            ?>
            <p  class="text-center" id="imageDimensions"></p>
        </div>
      </div>
        <form class="" action="" method="post" enctype="multipart/form-data" id="avataUploadForm">
          <input type="file" name="avatainput" value="" id="avatainput" accept="image/*">
          <hr>
          <div class="col-md-8 offset-2">
            <input type="hidden" name="uploadAvata" value="images">
            <button type="submit" class="btn btn-primary " id="avataUploadBtn">Upload Photo</button>
          </div>
        </form>
        <script type="text/javascript">
      $(document).ready(()=>{
        $("#avatainput").css("display","none")
        $("#userAvata").on("mouseover",()=>{
          $("#userAvata").css("cursor","pointer")
        })
        $("#userAvata").on("click",()=>{
          $("#avatainput").click()
        })
        $("#avatainput").on("change",function(){
          var file = this.files[0];
          var image=document.getElementById("userAvata")
        var readImg = new FileReader();
        readImg.readAsDataURL(file);
        readImg.onload = (e)=> {
          $('#userAvata').attr('src', e.target.result).fadeIn();
          var width=image.naturalWidth;
          var height=image.naturalHeight;
          $("#imageDimensions").html(`${width} x ${height}`)

      }
        })
      })
        </script>
        <script type="text/javascript">
          $(document).ready(()=>{
            $("#avataUploadForm").on("submit",function(e){
              e.preventDefault()
              $.ajax({
                url:"../users/change-avata.php",
                type:"POST",
                data:new FormData(this),
                contentType:false,
                cache:false,
                processData:false,
                beforeSend:()=>{
                  $("#avataUploadBtn").html("Uploading Image..")
                },
                success:(data)=>{

                  var JSONdata=JSON.parse(data);
                  if(JSONdata.alert_type=="success"){
                    $("#modal-top").fadeIn("slow")
                      $("#modal-top-body").html(`<span class="text-cnter text-success">${JSONdata.message}</span>`)
                      $("#avataUploadBtn").fadeOut("slow")
                      setTimeout(()=>{
                        $("#modal-top").fadeOut("slow")
                      },1500)
                        setTimeout(()=>{
                            window.location.replace("")
                      },2000)
                  }else{
                      $("#modal-top-body").html(`<span class="text-cnter text-danger">${JSONdata.message}</span>`)
                  }


                }
              })
            })
          })
        </script>
        <?php



      break;
      case 'POST':
        if (isset($_POST["uploadAvata"])) {
          if(isset($_FILES["avatainput"])){
            if($_FILES["avatainput"]["name"]==""){

              $alert['alert_type']="error";
              $alert['message']="No File Inserted";
              die(json_encode($alert));

            }
            $validExtensions = Array("jpeg", "jpg", "png","PNG");
            $temp=explode(".",$_FILES["avatainput"]['name']);
            if(!in_array(end($temp),$validExtensions)){
              $alert['alert_type']="error";
              $alert['message']="Please upload  a valid Image File [jpg,jpeg  or  PNG file]";
              die(json_encode($alert));
            }

            $newFileName="IMAGE".date("YmdHis").round(microtime(true)).".".end($temp);

            $upload=move_uploaded_file($_FILES["avatainput"]["tmp_name"],"../users/user-photos/".$newFileName);
            if(!$upload==true){
              $alert['alert_type']="error";
              $alert['message']="Failed to Process and upload your Avata";
              die(json_encode($alert));
            }
              $me->setAvata($newFileName);
            $updateAvata= $me->updateAvat($conn);
            if($updateAvata==true){
              $alert['alert_type']="success";
              $alert['message']="Image Uploaded Successfully";
              die(json_encode($alert));
            }
          }
        }
        break;
    default:
      // code...
      break;
  }
}else{
  die("Connection Failed");
}
}else{
echo "You are not Loged in";;
}

 ?>
